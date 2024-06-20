<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CurriculumRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Curriculum;
use Carbon\Carbon;

class CurriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // 授業一覧画面表示メソッド
    public function showCurriculumList(Request $request) {
        // CurriculumモデルのgetCurriculumListメソッドを実行して返り値を取得
        $curriculum = new Curriculum();
        $curriculums = $curriculum->getCurriculumList($request);
        // gradesテーブルの全てのレコード情報を取得
        $grades = DB::table('grades')->get();
        // 選択した学年名を取得
        $select_grade_id = $request->input('grade_id', 1);
        $select_grade_name = $grades->where('id', $select_grade_id)->value('name');
        // dd($select_grade_id);
        // ①授業一覧画面を表示し②取得したcurriculums(deliveryTimes含む)とgrades、select_grade_nameの情報を渡す
        return view('admin.curriculum_list', compact('curriculums', 'grades', 'select_grade_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // 授業新規作成画面表示メソッド
    public function showCurriculumCreate() {
        // gradesテーブルの全てのレコード情報を取得
        $grades = DB::table('grades')->get();
        // ①新規登録画面を表示し②取得したgradesの情報を渡す。
        return view('admin.curriculum_create', compact('grades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // 授業新規登録メソッド
    public function showCurriculumStore(CurriculumRequest $request) {
        // トランザクション開始
        // DB::beginTransaction();
        // try {
            // CurriculumモデルのgetCurriculumStoreメソッドを実行する（登録処理）
            $curriculum_store = new Curriculum();
            $curriculum_store->getCurriculumStore($request);
        //     DB::commit();
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     return back();
        // }
        // リクエストから選択中の学年idを取得
        $grade_id = $request->grade_id;
        // ①授業一覧画面にリダイレクトし②取得した学年idを渡す③フラッシュメッセージをセッション
        return redirect()->route('admin.show.curriculum.list', compact('grade_id'))->with('store_curriculum_message', '授業を登録しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // 授業編集画面表示メソッド
    public function showCurriculumEdit($id) {
        // curriculumsテーブルの指定したidレコード情報を取得
        $curriculum = DB::table('curriculums')->find($id);
        // gradesテーブルの全てのレコード情報を取得
        $grades = DB::table('grades')->get();
        // ①授業編集画面を表示し②取得したcurriculumとgradesの情報（配列）を渡す。
        return view('admin.curriculum_edit', compact('curriculum', 'grades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // 授業内容更新メソッド
    public function showCurriculumUpdate(CurriculumRequest $request, $id) {
        // トランザクション開始
        // DB::beginTransaction();
        // try {
            // CurriculumモデルのgetCurriculumUpdateメソッドを実行する（更新処理）
            $curriculum_update = new Curriculum();
            $curriculum_update->getCurriculumUpdate($request, $id);
        //     DB::commit();
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     return back();
        // }
        // リクエストから選択中の学年idを取得
        $grade_id = $request->grade_id;
        // ①授業一覧画面にリダイレクトし②取得した学年idを渡す③フラッシュメッセージをセッション
        return redirect()->route('admin.show.curriculum.list', compact('grade_id'))->with('update_curriculum_message', '授業内容を更新しました');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
