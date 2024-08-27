<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\PasswordEditRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    // プロフィールページトップ表示処理
    public function showProfileForm()
    {
        $user = Auth::user();
        $tempData = session('temp_data', []);
        return view('user.profile_edit', compact('user', 'tempData'));
    }

    // パスワード変更画面遷移と登録処理の分岐
    public function buttonRooting(Request $request)
    {
        $currentData = [
            'name' => $request->input('name'),
            'name_kana' => $request->input('name_kana'),
            'email' => $request->input('email'),
        ];
    
        // 現在のユーザーデータとマージ
        $user = Auth::user();
        $mergedData = array_merge([
            'name' => $user->name,
            'name_kana' => $user->name_kana,
            'email' => $user->email,
        ], array_filter($currentData));
    
        session(['temp_profile_data' => $mergedData]);

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('temp', 'public');
            session(['temp_profile_image' => $path]);
        }
    
        $action = $request->input('action');

        if($action === 'password_edit'){
            return redirect()->route('user.password.edit')
                ->withInput($request->except(['action', 'profile_image']));
        } elseif($action === 'profile_register'){
            // return redirect()->route('user.profile.update');
            $userRequest = new UserRequest();
            $rules = $userRequest->rules();

            // バリデーションを実行
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // バリデーションが成功した場合、updateメソッドを呼び出す
        return $this->update($request);
        }
    }

    // パスワード変更画面遷移時の処理
    public function passwordEdit(Request $request)
    {
        $user = Auth::user();
        $tempPassword = session('temp_password');
        return view('user.password_edit', compact('user', 'tempPassword'));

        // 一時保存し戻るボタンをクリックされた場合
        if($request->input('back') == 'back'){
            return redirect()->route('user.password_edit')
                ->withInput();
        }
    }

    public function tempSavePassword(PasswordEditRequest $request)
    {

        if ($request->filled('password')) {
            session(['temp_password' => $request->password]);
            return redirect()->route('user.show.profile')->with('password_message', 'パスワードが一時保存されました。');
        }
        return redirect()->route('user.show.profile');
    }

    public function update(Request $request)
    {
        // UserRequestのルールを取得してバリデーション
        $userRequest = new UserRequest();
        $validator = Validator::make($request->all(), $userRequest->rules());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        // ユーザーを取得
        $user = Auth::user();

        // トランザクション開始
        DB::beginTransaction();

        try {
            // $data = $request->validated();
            // セッションに一時保存されたパスワードがあれば、それを使用
            if (session()->has('temp_password')) {
                $data['password'] = session('temp_password');
                session()->forget('temp_password');  // 使用後はセッションから削除
            } 

            if (session()->has('temp_profile_image')) {
                $data['profile_image'] = session('temp_profile_image');
                session()->forget('temp_profile_image');
            }

            $user->updateProfile($data);
            DB::commit();

            // 処理が完了したらユーザープロフィール画面にリダイレクト
            // return redirect()->route('user.show.profile')->with('success', 'プロフィールが更新されました。');
            return redirect()->route('user.show.profile')->with('profile_message', 'プロフィールが更新されました。');
        } catch (\Exception $e) {
            // エラーが発生した場合はトランザクションロールバック
            DB::rollback();
            return back()->with('error', 'プロフィールの更新に失敗しました。');
        }
    }

    public function __destruct()
    {
        // セッションが終了したときに一時ファイルを削除
        if (session()->has('temp_profile_image')) {
            Storage::disk('public')->delete(session('temp_profile_image'));
            session()->forget('temp_profile_image');
        }
    }
}
