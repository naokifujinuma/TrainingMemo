
<?php
require_once 'connect.php';

//webサーバーから入力フォームを取り出す
$user_id = $_POST['user_id'] ?? '';
$name = $_POST['name'] ?? '';
$mail_address = $_POST['mail_address'] ?? '';
$password = $_POST['password'] ?? '';

//データベースでuser_idからpasswordを選択し、実行
if($user_id !== '' && $password !== '') {
    $sql = "SELECT password FROM `m_user` WHERE user_id = :user_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt->execute();

    //実行成功ならリダイレクト、失敗→エラー表示
    if($stmt->rowCount() > 0 ) {
        $data = $stmt->fetch(PDO::FETCH_ASSOC);//データベースから1行取得($dbhはPDOオブジェクトのためfetchを使う際は$stmtに対して実行する必要がある)
        if($data) {
            if(password_verify($password, $data['password'])) { //パスワード検証
                session_start();
                $_SESSION['user_id'] = $user_id;
                header('Location: welcome.html'); 
                exit;
            } else {
                echo 'パスワードが間違っています'; //一致しない場合
            }
        } else {
            echo '登録されていません'; //データが見つからない場合
        }
    } else {
        echo 'やり直してください';
        print_r($stmt->errorInfo());
    }
}


?>



<!-- <!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <link rel="stylesheet" href="all.css">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css" />
</head>
<body>
    <div class="content">
        <div class="text4">
            <form method="POST" action="">
                <h1 class="title">Login</h1>
                <div class="textbox">
                    <input type="text" name="user_id" id="user_id" class="t_form" value="<?= htmlspecialchars($user_id, ENT_QUOTES) ?>">
                    <label for="user_id">User_ID:</label>
                    
                    <div>
                        <input type="password" name="password" id="password" class="t_form" value="<?= htmlspecialchars($password, ENT_QUOTES) ?>">
                        <label for="password">Password:</label>
                    </div>
                    <div>
                        <input class="t_form" type="submit" value="始める">
                    </div>
                </div>
                <a href="new.php" class="btn">新規登録</a>
            </form>
        </div>
    </div>
</body>
</html> -->

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <link rel="stylesheet" href="all.css">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css" />
</head>
<body>
    <div class="content">
        <div class="text4">
            <form method="POST" action="">
                <h1 class="title">Login</h1>
                <div class="textbox">
                    <div class="input-container">
                        <input type="text" name="user_id" id="user_id" class="t_form" value="<?= htmlspecialchars($user_id, ENT_QUOTES) ?>" placeholder=" ">
                        <label for="user_id">User_ID:</label>
                    </div>
                    <div class="input-container">
                        <input type="password" name="password" id="password" class="t_form" value="<?= htmlspecialchars($password, ENT_QUOTES) ?>" placeholder=" ">
                        <label for="password">Password:</label>
                    </div>
                    <div>
                        <input class="t_form submit-btn" type="submit" value="始める">
                    </div>
                </div>
                <a href="new.php" class="btn">新規登録</a>
            </form>
        </div>
    </div>
</body>
</html>
