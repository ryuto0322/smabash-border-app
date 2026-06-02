<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FighterResult;

class FighterResultController extends Controller
{
    public function updateResult(Request $request)
    {
        $request->validate([
            'fighter_id' => 'required|exists:fighters,id',
            'opponent_fighter_id'=> 'required|exists:fighters,id',
            'type' => 'required|in:win,lose',
        ]);

        // スネーク vs 相手キャラ の戦績を1件だけきれいに更新する
        $result = FighterResult::firstOrNew([
            'fighter_id' => $request->fighter_id,
            'opponent_fighter_id' => $request->opponent_fighter_id,
        ]);

        if($request->type === 'win'){
            $result->wins += 1;
        }else{
            $result->losses += 1;
        }
        $result->save();

        return redirect()->back()->with('success','戦績を更新しました');
    }
}