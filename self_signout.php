<?php
    session_start();

    //SESSION変数破棄
    $_SESSION = [];//箱は残っている

    //サーバー内の$_SESSION変数のクリア
    session_destroy();//箱自体を破棄（全破壊）

    //signin.phpへの移動
    header("Location: self_signin.php");
    exit();//これ以降の処理を行わない（ここで終了する）

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title></title>
  <meta charset="utf-8">
</head>
<body>

</body>
</html>