<?php
require_once 'connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $post_id = $_GET['post_id'];
    
    $sql = 'DELETE FROM posts WHERE post_id = :post_id AND user_id = :user_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    
    header('Location: index.php');
    exit;
}
?>
