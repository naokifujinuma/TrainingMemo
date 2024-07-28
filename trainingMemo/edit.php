<?php

require_once 'connect.php';
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $post_id = $_GET['post_id'];

    $sql = 'SELECT content FROM posts WHERE post_id = :post_id AND user_id = :user_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
}


//更新
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'];
    $content = $_POST['content'];
    
    $sql = 'UPDATE posts SET content = :content WHERE post_id = :post_id AND user_id = :user_id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':content', $content, PDO::PARAM_STR);
    $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    
    header('Location: index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿編集</title>
    <link rel="stylesheet" href="all.css">
    <link rel="stylesheet" href="edit.css">
</head>
<body>
    <div class="content2">
        <h1 class="title">投稿編集</h1>
        <?php if($_SERVER['REQUEST_METHOD'] === 'GET' && '$post'): ?>
            <form method="POST" action="edit.php">
            <textarea name="content"><?php htmlspecialchars($post['content'], ENT_QUOTES)?></textarea><br>
            <input type="hidden" name="post_id" value="<?php $post_id ?>">
            <button type="submit">更新</button>
        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'GET'): ?>
            <p>投稿が見つかりません。</p>
        <?php endif; ?>
    </div>
    
</body>
</html>