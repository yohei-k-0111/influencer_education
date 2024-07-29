<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curriculum; 
use App\Models\CurriculumProgress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CurriculumsController extends Controller
{
    public function user_stream(Request $request, $id)
    {
        $userId = auth()->user()->id;

        $progressIds = CurriculumProgress::where('users_id', $userId)->pluck('curriculums_id');
    
        $curriculumsInProgress = Curriculum::whereIn('id', $progressIds)
            ->select('id', 'title', 'video_url', 'thumbnail', 'always_delivery_flg', 'description')
            ->get();
    
        $curriculumsForCurrentMonth = Curriculum::where('always_delivery_flg', 1)
            ->select('id', 'title', 'video_url', 'thumbnail', 'always_delivery_flg', 'description')
            ->get();
    
        $curriculums = $curriculumsInProgress->merge($curriculumsForCurrentMonth);
    
        // パラメーターから渡されたid情報でカリキュラムを絞り込み
        $filteredCurriculum = $curriculums->where('id', $id)->first();
    
        return view('user_stream', compact('filteredCurriculum'));
    }    
    
    public function show($id)
    {
        $deliveryInstance = new DeliveryTime();
        $delivery = $deliveryInstance->getDeliveryTime($id); 
    
        $curriculums = Curriculum::find($id);
    
        $progress = CurriculumProgress::where('curriculums_id', $id)
            ->where('users_id', auth()->user()->id) 
            ->value('clear_flg');
    
        return view('delivery', compact('curriculums', 'progress'));
    }

    public function clear(Request $request)
    {
        \Log::info('Clear method called', ['user_id' => $request->user_id]);
        $userId = auth()->user()->id;
        $curriculumId = $request->input('curriculum_id');

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'curriculum_id' => 'required|exists:curriculums,id',
        ]);

        $progress = CurriculumProgress::updateOrCreate(
            ['users_id' => $userId, 'curriculums_id' => $curriculumId],
            ['clear_flg' => 1]
        );

        return response()->json(['success' => true, 'redirect' => route('top')]);//遷移先は仮
    }
}
