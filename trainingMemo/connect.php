<?php 

//DB接続

if($_SERVER["HTTP_HOST"] == "localhost:8888") {
    //localhost:8888
    $dsn = 'mysql:host=localhost;dbname=t_memo';
    $user = 'naoki';
    $pass = 'Twtm3153';
} else if($_SERVER["HTTP_HOST"] == "nao9n.chips.jp") {
    //nao9n.chips.jp
    $dsn = 'mysql:host=mysql301.phy.lolipop.lan;dbname=LAA1584511-xabivx';
    $user = 'LAA1584511';
    $pass = '4J0Fuqy827GNBk9J';
} else {
    echo "接続失敗";
}


try {
    $dbh = new PDO($dsn,$user,$pass);
} catch(PDOException $e) {
    echo '接続失敗<br>'.$e -> getMessage();
    exit;
}

?>
