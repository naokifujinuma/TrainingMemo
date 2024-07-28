<?php
require_once 'connect.php';

//webサーバーから入力フォームを取り出す
$user_id = $_POST['user_id'] ?? '';
$name = $_POST['name'] ?? '';
$mail_address = $_POST['mail_address'] ?? '';
$password = $_POST['password'] ?? '';

//webサーバーから取り出した$_POSTの値をデータベースに追加する
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "INSERT INTO `m_user` (`user_id`, `name`, `mail_address`, `password`) VALUES (:user_id, :name, :mail_address, :password)";
    $stmt = $dbh->prepare($sql);
    
    // パラメータをバインド
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':mail_address', $mail_address);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // パスワードをハッシュ化
    $stmt->bindParam(':password', $hashed_password); 

    $result = $stmt->execute();
    if($result) {
        unset($stmt);
        //リダイレクト 登録に成功した場合
        header('Location: login.php'); 
        exit;
    } else {
        echo 'もう一度登録してください';
        // デバッグ情報を表示
        print_r($stmt->errorInfo());
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録</title>
    <link rel="stylesheet" href="all.css">
    <link rel="stylesheet" href="new.css">
</head>
<body>
    <div class="content2">
        <h1 class="title">新規登録</h1>
        <form method="POST" action="" class="n_form">
            <label for="name">name</label>
            <input class="l_form" type="text" name="name" id="name" value="<?= htmlspecialchars($name, ENT_QUOTES) ?>"><br>
            <label for="user_id">ID&nbsp;&nbsp;&nbsp;</label>
            <input class="l_form" type="text" name="user_id" id="user_id" value="<?= htmlspecialchars($user_id, ENT_QUOTES) ?>"><br>
            <label for="mail_address">mail</label>
            <input class="l_form" type="text" name="mail_address" id="mail_address" value="<?= htmlspecialchars($mail_address, ENT_QUOTES) ?>"><br>
            <label for="password">Pass</label>
            <input class="l_form" type="password" name="password" id="password" value=""><br>
            <input type="submit" value="登録" class="registration">
        </form>
    </div>

</body>
</html>
