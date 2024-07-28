<?php

require_once 'connect.php';

$custom = $_POST['custom'] ?? '';



?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>トレーニング画面</title>
    <link rel="stylesheet" href="all.css">
    <link rel="stylesheet" href="exercise2.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200&family=Open+Sans:wght@300&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>
<body>
    <div class="content2">
        <div class="text">
            <h1 class="title">トレーニング画面</h1>
            <p class="large">種目名： <?= htmlspecialchars($custom, ENT_QUOTES) ?></p>
            <form method="POST" name="timer" class="t_area">
                <div class="t_custom">
                    <input class="t_form" type="number" name="work_weight" size="5" required>
                    <input class="r_only" type="text" size="1" value="Kg" readonly>

                    <input class="t_form" type="number" name="work_times" size="5" required>
                    <input class="r_only" type="text" size="1" value="回" readonly>

                    <input class="t_form" type="number" name="work_set" required>
                    <input class="r_only" type="text" size="2" value="セット" readonly>

                </div>
                <div class="time">
                    <input class="t_form" type="number" name="min" required>
                    <input class="r_only" type="text" size="2" value="分"  readonly>

                    <input class="t_form" type="number" name="second" required>
                    <input class="r_only" type="text" size="2" value="秒" readonly>
                </div>

                <div class="timer">
                    <input class="btn" type="button" value="スタート" name="start" onclick="cntStart()">
                    <input class="btn" type="button" value="ストップ" name="stop" onclick="cntStop()">
                </div>

            </form>
        </div>
    </div>
    <div class="slide">
        <a href="exercise.php" class="btn">種目を変更する</a>
        <a href="today.php" class="btn">トレーニング終了</a>
    </div>
</body>
</html>

<script>
    //タイマーを格納する変数の宣言
    var timer1;

    //カウントダウン関数を1000ミリ毎秒に呼び出す関数
    function cntStart() {
        document.timer.start.disabled = true;
        timer1 = setInterval(countDown, 1000);
    }

    //タイマー停止関数
    function cntStop() {
        document.timer.stop.disabled = false;
        clearInterval(timer1);
    }

    //カウントダウン関数
    function countDown() {
        var min = document.timer.min.value;
        var sec = document.timer.second.value;

        if ((min === "") && (sec === "")) {
            alert("時間を設定してください");
            reSet();
        } else {
            if (min === "") min = 0;
            min = parseInt(min);

            if (sec === "") sec = 0;
            sec = parseInt(sec);

            tmWrite(min * 60 + sec - 1);
        }
    }

    //残り時間を書き出す関数
    function tmWrite(int) {
        int = parseInt(int);
        if (int <= 0) {
            reSet();
            alert("時間です");
            finish();
        } else {
            //残り分数はintを６０で割って切り捨てる
            document.timer.min.value = Math.floor(int / 60);
            //残り秒数はintを６０で割った余り
            document.timer.second.value = int % 60;
        }
    }

    //初期値に戻すリセット関数
    function reSet() {
        document.timer.min.value = "";
        document.timer.second.value = "";
        document.timer.start.disabled = false;
        clearInterval(timer1);
    }

    function finish() {
        var postData = {
            "work_weight": document.timer.work_weight.value,
            "work_times": document.timer.work_times.value,
            "work_set": document.timer.work_set.value,
            "work_dt": new Date().toISOString().slice(0, 19).replace('T', ' '),
            "work_name": <?= json_encode($custom) ?>
        }
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: postData,
            dataType: "json",
            async: true
        })
        .done(function(response) {
            console.log("Success:", response);
        }).fail(function(error) {
            console.log("Error:", error);
        });
    }
</script>