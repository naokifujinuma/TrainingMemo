<?php
require_once 'connect.php';
session_start();

// 投稿フォームが送信された場合
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = $_POST['content'] ?? '';
    $user_id = $_SESSION['user_id'];

    if (!empty($content)) {
        $sql = 'INSERT INTO posts (user_id, content) VALUES (:user_id, :content)';
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        if ($stmt->execute()) {
            // 投稿が成功した場合、ページを再読み込みして新しい投稿を表示
            header('Location: index.php');
            exit;
        } else {
            echo "投稿に失敗しました。";
            print_r($stmt->errorInfo());
        }
    }
}

// データベースから投稿を取得
$sql = 'SELECT posts.post_id, posts.content, posts.created_at, m_user.name AS username, posts.user_id 
FROM posts LEFT JOIN m_user ON posts.user_id = m_user.user_id ORDER BY posts.created_at DESC';
$stmt = $dbh->prepare($sql);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>掲示板</title>
    <link rel="stylesheet" href="all.css">
    <link rel="stylesheet" href="index.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200&family=Open+Sans:wght@300&display=swap" rel="stylesheet">
</head>
<body>
    <div class="content2">
        <div class="content_inner">
            <h1 class="title">みんなの掲示板</h1>

            <form id="postForm" method="POST" action="index.php">
                <textarea name="content" class="textarea" required></textarea><br>
                <button type="submit">投稿</button>
            </form>
        </div>

        <div id="posts">
            <?php foreach ($posts as $post): ?>
                <div>
                <p>投稿者: <?= htmlspecialchars($post['username'], ENT_QUOTES) ?></p>
                    <p><?= htmlspecialchars($post['content'], ENT_QUOTES) ?></p>

                    <p><?= $post['created_at'] ?></p>
                    <?php if ($_SESSION['user_id'] == $post['user_id']): ?>
                        <div class="btn_wrap2">
                            <a class="btn" href="edit.php?post_id=<?= $post['post_id'] ?>">編集</a>
                            <a class="btn" href="delete.php?post_id=<?= $post['post_id'] ?>">削除</a>
                        </div>
                    <?php endif; ?>
                </div>
                <hr>
            <?php endforeach; ?>
        </div>
        <div class="content_inner">
            <div class="btn_wrap">
                <a class="btn" href="exercise.php">トレーニングを始める</a>
            </div>
        </div>
    </div>
</body>
</html>
