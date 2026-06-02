<!DOCTYPE html>
<html lang="ja">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<head>
    <meta charset="UTF-8">
    <title>自分用スマブラ表</title>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; padding: 40px; }
        .title { color: #ff3b30; text-align: center; font-size: 32px; margin-bottom: 20px; }
    </style>
</head>
<body>

   <div style="text-align: center; margin-bottom: 30px; padding: 20px; background: #fff; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
    <img src="{{ asset('images/スネーク.png') }}" 
         alt="スネーク" 
         style="width: 120px; height: 120px; border-radius: 50%; border: 4px solid #ff9500; object-fit: cover; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
    
    <h1 style="color: #ff3b30; margin: 15px 0 5px 0; font-size: 32px; font-weight: bold;">
        スネーク 専用戦績表
    </h1>
    <p style="color: #666; font-size: 14px; margin: 0 0 20px 0;">〜 世界最強の蛇になるためのキャラ対メモ 〜</p>

    @php
        // 1. スネーク自身のデータ（ID）を取得
        $snake = $fighters->where('name', 'スネーク')->first();

        // 2. スネークが「他のキャラ相手に戦った全データ」の合計を自動計算する！
        $snakeWins = 0;
        $snakeLosses = 0;

        if ($snake) {
            // 全ファイターの戦績をループして、スネークが勝った/負けた分を全部足す
            foreach($fighters as $f) {
                if($f->name === 'スネーク') continue; // 自分自身はスキップ
                
                // スネーク vs このキャラ のデータを取得
                $m = \App\Models\FighterResult::where('fighter_id', $snake->id)
                            ->where('opponent_fighter_id', $f->id)
                            ->first();
                if($m) {
                    $snakeWins += $m->wins;
                    $snakeLosses += $m->losses;
                }
            }
        }

        $snakeTotal = $snakeWins + $snakeLosses;
        $snakeRate = $snakeTotal > 0 ? round(($snakeWins / $snakeTotal) * 100, 1) : 0;
    @endphp

    <div style="background: #f9f9f9; padding: 15px; border-radius: 8px; display: inline-block; min-width: 300px; border: 1px solid #eee;">
        <p style="margin: 0 0 10px 0; font-size: 18px; font-weight: bold; color: #444;">
            通算戦績：【 {{ $snakeWins }} 勝 / {{ $snakeLosses }} 敗 】
        </p>
        <p style="margin: 0 0 15px 0; font-size: 20px; font-weight: bold; color: #ff9500;">
            総合勝率：{{ $snakeRate }}%
        </p>
        
        @if($snake)
            <div style="display: flex; justify-content: center; gap: 10px;">
                <button class="btn-win" onclick="addWin({{ $snake->id }})" style="padding: 8px 20px; font-size: 16px; font-weight: bold; cursor: pointer;">WIN!</button>
                <button class="btn-lose" onclick="addLose({{ $snake->id }})" style="padding: 8px 20px; font-size: 16px; font-weight: bold; cursor: pointer;">LOSE</button>
            </div>
        @endif
    </div>
</div>

    <form action="/fighters" method="POST" style="margin-bottom: 30px; text-align: center;">
        @csrf
        <input type="text" name="name" placeholder="ファイター名" required>
        <input type="number" name="current_score" placeholder="現在の戦闘力" required>
        <button type="submit">登録する</button>
    </form>

   @foreach($fighters as $fighter)
        @if($fighter->name === 'スネーク') @continue @endif

        <div style="background: #ffffff; padding: 20px; margin-bottom: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); display: flex; align-items: center; justify-content: space-between;">
            
            <div style="display: flex; align-items: center;">
                <div style="width: 50px; height: 50px; background: #e5e5ea; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; overflow: hidden; flex-shrink: 0;">
                    @if($fighter->image_path)
                        <img src="{{ asset($fighter->image_path) }}" alt="icon" style="width: 100%; height: 100%; object-fit: cover; object-position: 5% 15%;">
                    @else
                        <span style="font-size: 20px;">🥊</span>
                    @endif
                </div> 
                <div>
                    <h2 style="margin: 0; font-size: 20px; font-weight: bold; color: #333;">{{ $fighter->name }}</h2>
                    <p style="margin: 5px 0 0 0; font-size: 14px; color: #666;">戦闘力: {{ number_format($fighter->current_score) }}</p>
                </div>
            </div>

            @php
                // FighterResultのモデルから直接、自分(スネーク) vs 相手(このキャラ) のデータを探す
                $match = \App\Models\FighterResult::where('fighter_id', $snake->id)
                            ->where('opponent_fighter_id', $fighter->id)
                            ->first();

                $wins = $match ? $match->wins : 0;
                $losses = $match ? $match->losses : 0;

                $totalGames = $wins + $losses;
                $winRate = $totalGames > 0 ? round(($wins / $totalGames) * 100, 1) : 0;
            @endphp

            <div style="text-align: right;">
                <p style="margin: 0 0 10px 0; font-size: 14px; font-weight: bold; color: #444;">
                    【 {{ $wins }} 勝 / {{ $losses }} 敗 】
                </p>
                <p style="margin: 5px 0 10px 0; font-size: 14px; font-weight: bold; color: #ff9500;">
                    勝率：{{ $winRate }}%
                </p>
            </div>

            <div class="d-flex">
                <form action="{{ route('match-results.update') }}" method="POST" style="display: inline">
                    @csrf 
                    <input type="hidden" name="fighter_id" value="{{ $snake->id }}">
                    <input type="hidden" name="opponent_fighter_id" value="{{ $fighter->id }}">
                    <input type="hidden" name="type" value="win">
                    <button type="submit" class="btn-danger btn-sm me-1">WIN!</button>
                </form>

                <form action="{{ route('match-results.update') }}" method="POST" style="display: inline">
                    @csrf
                    <input type="hidden" name="fighter_id" value="{{ $snake->id }}">
                    <input type="hidden" name="opponent_fighter_id" value="{{ $fighter->id }}">
                    <input type="hidden" name="type" value="lose">
                    <button type="submit" class="btn-primary btn-sm">LOSE</button>
                </form>
            </div>

        </div>
    @endforeach
    </div>

</body>
</html>