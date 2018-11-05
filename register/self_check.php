<?php
    //functions.phpファイルを読み込む
    require('../functions.php');

    v($_POST);

    // 変数
    $name = htmlspecialchars($_POST['name']);
    $name1 = htmlspecialchars($_POST['name1']);
    $text = htmlspecialchars($_POST['text']);
    $date = htmlspecialchars($_POST['date']);
    $address = htmlspecialchars($_POST['address']);
    $tel = htmlspecialchars($_POST['tel']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $result_name = '';
    $result_name2 = '';
    $result_text = '';
    $result_date = '';
    $result_address = '';
    $result_tel = '';
    $result_email = '';
    $result_password = '';

    // 入力チェック → バリデーション validation
    if ($name == '') {
        $result_name = '未入力です';
    } else {
        $result_name = $name;
    }

    // email, content版を作成

    if ($email == '') {
        $result_email = '未入力です';
    } else {
        $result_email = $email;
    }

    if ($content == '') {
        $result_content = '未入力です';
    } else {
        $result_content = $content;
    }

    // contentには100文字までという制限
    // 文字数制限→バイト
    // 関数

    //strlen()
    if (mb_strlen($result_content) > 100) {
      $result_content = 'お問い合わせ内容は100字以内で入力してください';
    }

    //もし１つでも未入力があれば
    //もし１つも未入力がなければ
    //もし$nameが空じゃない且つ$emailが空じゃない且つ$contentが空じゃなければ
    //if ($name !='' && $email !='' && $content !='') {

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <title></title>
  <meta charset="utf-8">
</head>
<body>
  <h1>お問い合わせ内容確認</h1>
  <p>ユーザー名: <?= $result_name; ?></p>
  <p>ユーザー名（フリガナ）: <?= $result_name1; ?></p>
  <p>性別: <?= $result_text; ?></p>
  <p>誕生日: <?= $result_date; ?></p>
  <p>住所: <?= $result_address; ?></p>
  <p>電話番号: <?= $result_tel; ?></p>
  <p>メールアドレス: <?= $result_email; ?></p>
  <p>パスワード: <?= $result_password; ?></p>

  <!--<a href="send.php">戻る</a> -->
  <form action="thanks.php" method="POST">
    <input type="hidden" name="name" value="<?= $result_name; ?>">
    <input type="hidden" name="name1" value="<?= $result_name1; ?>">
    <input type="hidden" name="text" value="<?= $result_text; ?>">
    <input type="hidden" name="date" value="<?= $result_date; ?>">
    <input type="hidden" name="address" value="<?= $result_address; ?>">
    <input type="hidden" name="tel" value="<?= $result_tel; ?>">
    <input type="hidden" name="email" value="<?= $result_email; ?>">
    <input type="hidden" name="password" value="<?= $result_password; ?>">

    <input type="button" value="戻る" onclick="history.back()">
    <?php if ($name !='' && $email !='' && $content !='' && mb_strlen($content) <= 100): ?>
      <input type="submit" value="送信">
    <?php endif; ?>
  </form>
</body>
</html>