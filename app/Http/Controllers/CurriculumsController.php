<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curriculum; 
use App\Models\CurriculumProgress;
use App\Models\DeliveryTime; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CurriculumsController extends Controller
{
    public function user_stream(Request $request, $id)
    {
        $userId = auth()->user()->id;
    
        // カリキュラム情報を取得
        $filteredCurriculum = Curriculum::where('id', $id)
            ->select('id', 'title', 'video_url', 'thumbnail', 'always_delivery_flg', 'description')
            ->first();
    
        if (!$filteredCurriculum) {
            abort(404, 'カリキュラムが見つかりません');
        }
    
        // 公開期間をチェック
        $deliveryTime = DeliveryTime::where('curriculums_id', $id)
            ->where('delivery_from', '<=', now())
            ->where('delivery_to', '>=', now())
            ->first();
    
        // 受講済みかどうかをチェック
        $isCompleted = CurriculumProgress::where('users_id', $userId)
            ->where('curriculums_id', $id)
            ->where('clear_flg', 1)
            ->exists();
    
        // 常時公開フラグと公開期間の条件で、$canAttend を設定
        $isWithinDeliveryPeriod = $deliveryTime ? true : false;
        $canAttend = false;
    
        if ($filteredCurriculum->always_delivery_flg == 1) {
            // 常時公開の場合
            $canAttend = !$isCompleted;
        } elseif ($isWithinDeliveryPeriod) {
            // 常時公開ではないが、期間内の場合
            $canAttend = !$isCompleted;
        }
    
        return view('user_stream', compact('filteredCurriculum', 'isWithinDeliveryPeriod', 'canAttend', 'isCompleted'));
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
        $userId = auth()->user()->id;
        $curriculumId = $request->input('curriculum_id');
    
        \Log::info('Clear method called', ['user_id' => $userId, 'curriculum_id' => $curriculumId]);
    
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'curriculum_id' => 'required|exists:curriculums,id',
        ]);
    
        $curriculum = Curriculum::find($curriculumId);

        // カリキュラムが見つからない場合のエラーハンドリング
        if (!$curriculum) {
            return response()->json(['success' => false, 'message' => 'カリキュラムが見つかりません。']);
        }

        // DeliveryTime モデルを使用して公開期間を取得
        $deliveryTime = DeliveryTime::where('curriculums_id', $curriculumId)
            ->where('delivery_from', '<=', now())
            ->where('delivery_to', '>=', now())
            ->first();

        // DeliveryTime が存在しない場合、または公開期間外の場合
        if (!$deliveryTime) {
            return response()->json(['success' => false, 'message' => 'このカリキュラムは受講できません。']);
        }
    
        $progress = CurriculumProgress::updateOrCreate(
            ['users_id' => $userId, 'curriculums_id' => $curriculumId],
            ['clear_flg' => 1]
        );
    
        return response()->json(['success' => true, 'redirect' => route('top')]);
    }
}
