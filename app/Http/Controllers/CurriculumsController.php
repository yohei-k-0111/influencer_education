<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curriculum; 
use App\Models\CurriculumProgress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CurriculumsController extends Controller
{
    public function user_stream(Request $request)
    {
        $userId = $request->input('users_id');
        
        $progressIds = CurriculumProgress::where('users_id', $userId)->pluck('curriculums_id');
    
        $curriculumsInProgress = Curriculum::whereIn('id', $progressIds)
            ->select('id', 'title', 'video_url', 'thumbnail', 'always_delivery_flg')
            ->get();
    
        $curriculumsForCurrentMonth = Curriculum::where('always_delivery_flg', 1)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->whereDay('created_at', '>=', 1)
            ->get();
    
        $curriculums = $curriculumsInProgress->merge($curriculumsForCurrentMonth);
    
        return view('user_stream', compact('curriculums'));
    }
    
    public function show($id)
    {
        $deliveryInstance = new DeliveryTime();
        $delivery = $deliveryInstance->getDeliveryTime($id); 
    
        $curriculums = Curriculum::find($id);
    
        $progress = CurriculumProgress::where('curriculums_id', $id)
            ->where('users_id', 1)
            ->value('clear_flg');
    
        return view('delivery', compact('curriculums', 'progress'));
    }

    public function clear(Request $request)
    {
        \Log::info('Clear method called', ['user_id' => $request->user_id]);
        $userId = $request->input('user_id');
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
