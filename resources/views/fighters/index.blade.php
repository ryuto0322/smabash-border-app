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

    <h1 class="title">目指せスネーク地元最強</h1>

    <form action="/fighters" method="POST" style="margin-bottom: 30px; text-align: center;">
        @csrf
        <input type="text" name="name" placeholder="ファイター名" required>
        <input type="number" name="current_score" placeholder="現在の戦闘力" required>
        <button type="submit">登録する</button>
    </form>

    @foreach($fighters as $fighter)
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

            <div style="text-align: right;">

                <p style="margin: 0 0 10px 0; font-size: 14px; font-weight: bold; color: #444;">
                    【 {{ $fighter->wins ?? 0 }} 勝 / {{ $fighter->losses ?? 0 }} 敗 】
                </p>
                <div style="display: flex; gap: 5px; justify-content: flex-end;">
                    <form action="/fighters/{{ $fighter->id }}/win" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" style="background: #ff3b30; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-weight: bold; cursor: pointer;">WiN!</button>
                    </form>

                    <form action="/fighters/{{ $fighter->id }}/lose" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" style="background: #007aff; color: white; border: none; padding: 6px 12px; border-radius: 6px; font-weight: bold; cursor: pointer;">LOSE...</button>
                    </form>
                </div>
            </div>

        </div>
    @endforeach
    </div>

</body>
</html>