<?php

namespace App\Http\Controllers;
use App\Models\Fighter;
use Illuminate\Http\Request;


class FighterController extends Controller
{
    public function index(){//メイン画面
        $fighters = Fighter::all();

        return view('fighters.index',compact('fighters'));
    }


    public function store(Request $request)
    {
        $name = str_replace([' ', '　'], '', $request->name);
        
        // 💡 許可が出たら、パソコン内の画像を見に行くこのコードに戻す！
        $imagePath = 'images/' . $name . '.png';

        Fighter::create([
            'name'          => $request->name,
            'current_score' => $request->current_score,
            'image_path'    => $imagePath, 
        ]);

        return redirect('/fighters');
    }



    public function win(Fighter $fighter)//win
    {
        $fighter->increment('wins');
        return redirect('/fighters');
    }
    public function lose(Fighter $fighter)//lose
    {
        $fighter->increment('losses');
        return redirect('/fighters');
    }
}
