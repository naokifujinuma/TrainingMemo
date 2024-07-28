<?php

require_once 'connect.php';
session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $POST['content'];
    $user_id = $_SESSION['user_id'];

    $sql = 'INSERT INTO posts (user_id, content) VALUES (:user_id, :content)';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':content', $content, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: index.php');
    exit;
}

?>