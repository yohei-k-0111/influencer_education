<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Curriculum;
use App\Models\CurriculumProgress;
use App\Models\Grade;
use App\Models\ClassesClearCheck;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    public function showProgress(Request $request)
    {
        $user = User::with(['grade', 'curriculumProgresses.curriculum'])->where('id', auth()->id())->first();
        $grades = Grade::with('curriculums')->get();
        $curriculumProgresses = $user->curriculumProgresses->keyBy('curriculums_id');
        // dd($curriculumProgresses);

        // 現在の学年のカリキュラムが全てクリアされたかをチェック
        $currentGrade = $user->grade;
        $allCleared = true;
        foreach ($currentGrade->curriculums as $curriculum) {
            if (!isset($curriculumProgresses[$curriculum->id]) || $curriculumProgresses[$curriculum->id]->clear_flg != 1) {
                $allCleared = false;
                break;
            }
        }

        // 全てクリアされていたら、classes_clear_checksテーブルを更新
        if ($allCleared) {
            $clearCheck = ClassesClearCheck::firstOrNew(['users_id' => $user->id, 'grade_id' => $currentGrade->id]);
            $clearCheck->clear_flg = 1;
            $clearCheck->save();

            // grade_idをインクリメントし、上限を12に設定
            $nextGradeId = min($currentGrade->id + 1, 12);

            // classes_clear_checksテーブルのgrade_idを更新
            $clearCheck->grade_id = $nextGradeId;
            $clearCheck->save();

            // usersテーブルのgrade_idを更新
            $user->grade_id = $nextGradeId;
            $user->save();
        }

        return view('user.curriculum_progress', compact('user', 'grades', 'curriculumProgresses'));
    }    
}
