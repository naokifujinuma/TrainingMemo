


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>種目を選択</title>
    <link rel="stylesheet" href="all.css">
    <link rel="stylesheet" href="exercise.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200&family=Open+Sans:wght@300&display=swap" rel="stylesheet">
</head>
<body>
    <div class="content3">
        <div class="text3">
            <h1 class="title">種目を選択</h1>
            <p class="large">トレーニング種目を入力</p>
            <p>
            今日鍛えたい所はどこですか？<br>
            目的をもって取り組もう！
            </p>
            <div class="textarea">
                <form method="POST" action="exercise2.php">
                    <div class="textbox">
                        <input class="t_form" type="text" name="custom" size="30" placeholder="placeholder" required>
                        <label for="custom">種目を入力</label>
                    </div>
                    <input type="submit" class="btn" value="開始">
                </form>
            </div>

        </div>
        <div class="img2">
            <img src="_.jpeg" alt="#">
        </div>
    </div>
</body>
</html>