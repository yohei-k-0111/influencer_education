<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Curriculum;
use App\Models\CurriculumProgress;
use App\Models\Grade;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    public function showProgress(Request $request)
    {
        // $user = User::with('grade')->where('id', auth()->id())->first();
        // $curriculumProgresses = $user->curriculumProgresses()->with('curriculum')->get();
        $user = User::with(['grade.curriculums', 'curriculumProgresses.curriculum'])->where('id', auth()->id())->first();
        $curriculumProgress = CurriculumProgress::all()->first();
        // return view('user.curriculum_progress', compact('user', 'curriculumProgresses'));
        $grades = Grade::with('curriculums')->get();
        return view('user.curriculum_progress', compact('user', 'curriculumProgress', 'grades'));

    }
    
}
