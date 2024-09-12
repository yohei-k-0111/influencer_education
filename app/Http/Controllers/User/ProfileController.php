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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // プロフィールページトップ表示処理
    public function showProfileForm()
    {
        $user = Auth::user();
        $tempData = session('temp_profile_data', []);
        return view('user.profile_edit', compact('user', 'tempData'));
    }

    // パスワード変更画面遷移と登録処理の分岐
    public function buttonRooting(UserRequest $request)
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
            session(['temp_profile_data.profile_image' => $path]);
        }
    
        $action = $request->input('action');

        if($action === 'password_edit'){
            // パスワード編集画面へのリダイレクト時にセッションにデータを保存
            session(['temp_profile_data' => $request->except(['action', 'profile_image'])]);
            return redirect()->route('user.password.edit');
        } elseif($action === 'profile_register'){
        // バリデーションが成功した場合、updateメソッドを呼び出す
        return $this->update($request);
        }

        // 不正なアクションの場合
        return redirect()->back()->with('error', '不正な操作です。');
    }

    // パスワード変更画面遷移時の処理
    public function passwordEdit(Request $request)
    {
        $user = Auth::user();
        return view('user.password_edit', compact('user'))->withInput($request->old());
    }

    public function tempSavePassword(PasswordEditRequest $request)
    {
        session(['temp_password' => $request->new_password]);

        return redirect()->route('user.show.profile')
            ->withInput($request->except('new_password', 'new_password_confirmation'))
            ->with('password_message', 'パスワードが一時保存されました。');

    }

    public function update(UserRequest $request)
    {
        // ユーザーを取得
        $user = Auth::user();
        $data = $request->validated();
        $tempData = session('temp_profile_data', []);

        if (session()->has('temp_password')) {
            $data['password'] = session('temp_password');
            session()->forget('temp_password');
        }
        // 一時保存されたプロフィール画像があれば、それを使用
        if (isset($tempData['profile_image'])) {
            $data['profile_image'] = $tempData['profile_image'];
        }

        // トランザクション開始
        DB::beginTransaction();

        try {
            $user->updateProfile($data);
            DB::commit();

            // 処理が完了したらユーザープロフィール画面にリダイレクト
            return redirect()->route('user.show.profile')->with('profile_message', 'プロフィールが更新されました。');
        } catch (\Exception $e) {
            // エラーが発生した場合はトランザクションロールバック
            DB::rollback();
            return back()->with('error', 'プロフィールの更新に失敗しました。')->withInput();
        }
    }

    public function __destruct()
    {
        // セッションが終了したときに一時ファイルを削除
        if (session()->has('temp_profile_data.profile_image')) {
            Storage::disk('public')->delete(session('temp_profile_data.profile_image'));
            session()->forget('temp_profile_data.profile_image');
        }
    }
}
