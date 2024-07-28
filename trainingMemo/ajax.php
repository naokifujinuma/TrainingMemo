<?php

require_once 'connect.php';
session_start();

//トレーニング開始した種目をt_workoutテーブルに追加
$sql = "INSERT INTO `t_workout` (`work_weight`, `work_times`, `work_set`, `work_dt`, `user_id`, `work_name`) VALUES (:work_weight, :work_times, :work_set, :work_dt, :user_id, :work_name)";
$stmt = $dbh->prepare($sql);



$stmt->bindParam(':work_weight', $_POST['work_weight'], PDO::PARAM_STR);
$stmt->bindParam(':work_times', $_POST['work_times'], PDO::PARAM_INT);
$stmt->bindParam(':work_set', $_POST['work_set'], PDO::PARAM_INT);
$stmt->bindParam(':work_dt', $_POST['work_dt'], PDO::PARAM_STR);
$stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->bindParam(':work_name', $_POST['work_name'], PDO::PARAM_STR);


$result = $stmt->execute();

if ($result) {
    echo json_encode(["status" => "success"]);
} else {
    $errorInfo = $stmt->errorInfo();
    echo json_encode(["status" => "error", "message" => $errorInfo[2]]);
}

?>
