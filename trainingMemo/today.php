<?php
require_once 'connect.php';
session_start();

$today = date('Y-m-d');

//トレーニングデータを取得
$sql = 'SELECT * FROM `t_workout` WHERE t_workout.user_id = :user_id ORDER BY t_workout.work_no ASC';
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':user_id',$_SESSION['user_id'], PDO::PARAM_STR);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

//トレーニング終了時に全データ保存
$sql = 'INSERT INTO t_allwork (work_no, work_weight, work_times, work_set, work_dt, user_id, work_name) VALUE(:work_no, :work_weight, :work_times, :work_set, :work_dt, :user_id, :work_name)' ;
$stmt = $dbh->prepare($sql);

foreach($results as $row) {
    $stmt->bindValue(':work_no', $row['work_no'], PDO::PARAM_INT);
    $stmt->bindValue(':work_weight', $row['work_weight'], PDO::PARAM_INT);
    $stmt->bindValue(':work_times', $row['work_times'], PDO::PARAM_INT);
    $stmt->bindValue(':work_set', $row['work_set'], PDO::PARAM_INT);
    $stmt->bindValue(':work_dt', $row['work_dt'], PDO::PARAM_STR);
    $stmt->bindValue(':user_id', $row['user_id'], PDO::PARAM_INT);
    $stmt->bindValue(':work_name', $row['work_name'], PDO::PARAM_STR);
    $stmt->execute();
}


//全データ保存のタイミングでt_workoutのデータ削除
$sql = 'DELETE FROM t_workout WHERE user_id = :user_id';
$stmt = $dbh->prepare($sql);
$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>本日のトレーニング結果</title>
    <link rel="stylesheet" href="all.css">
    <link rel="stylesheet" href="today.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200&family=Open+Sans:wght@300&display=swap" rel="stylesheet">
</head>
<body>
    <div class="content2">
        <div class="content_inner"> 
            <h1 class="title">お疲れ様でした</h1>
            <div class="results">
                <?php print_r($today) ?>
                <?php foreach($results as $row): ?>
                <div class="result-row">
                    <span class="work_name"><?= htmlspecialchars($row['work_name'], ENT_QUOTES) ?></span>
                    <span class="work_weight"><?= htmlspecialchars($row['work_weight'], ENT_QUOTES) ?></span>
                    <span class="work_times"><?= htmlspecialchars($row['work_times'], ENT_QUOTES) ?></span>
                    <span class="work_set"><?= htmlspecialchars($row['work_set'], ENT_QUOTES) ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="btn_wrap">
        <a class="btn" href="index.php">ホームへ戻る</a>
    </div>
</body>
</html>
