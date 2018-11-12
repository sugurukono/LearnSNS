<?php
    // timeline.phpの処理を記載
    session_start();
    require('functions.php');
    require('dbconnect.php');

    $data = array($_SESSION['id']);
    $sql = 'SELECT * FROM `users` WHERE `id` = ?';

    $stmt = $dbh->prepare($sql);//アロー演算子の左側をオブジェクトという
    $stmt->execute($data);
    $signin_user = $stmt->fetch(PDO::FETCH_ASSOC);

    $validations = array();
    $feed = '';

    if (!empty($_POST)) {
        $feed = $_POST['feed'];

        if ($feed == '') {
            $validations['feed'] = 'blank';
        }else{
            //データベースに投稿データを保存
            //DB登録処理
            //usersテーブルにユーザー情報の登録処理
            $sql = 'INSERT INTO `feeds` SET `user_id` = ?, `feed` = ?, `created` = NOW()';
            $stmt = $dbh->prepare($sql);
            $data = array($signin_user['id'], $feed);
            $stmt->execute($data);
        }
    }

    //一覧データの取得
    $sql = 'SELECT `f`.*, `u`.`name`,`u`.`img_name` AS `profile_image` FROM `feeds` AS `f` INNER JOIN `users` AS `u` ON `f`.`user_id` = `u`.`id` ORDER BY `created` DESC'; 
    //一覧を取得するSELECT文を記述
    //DESC 大きい数字から小さい数字に並べる
    //ASC 小さい数字から大きい数字に並べる
    $data = array();
    $stmt = $dbh->prepare($sql);
    $stmt->execute($data);

    $feeds = []; //投稿データを全て格納する配列

    while (true) {
        $feed = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($feed == false) {
            //取得できるデータはすべて取得できているので、繰り返しを中断する
            break;
        }

        //いいね済みかどうかの確認
        $like_flag_sql = "SELECT * FROM `likes` WHERE `user_id` = ? AND `feed_id` = ?";
        $like_flag_data = [$signin_user['id'], $feed['id']];
        $like_flad_stmt = $dbh->prepare($like_flag_sql);
        $like_flad_stmt->execute($like_flag_data);

        $is_liked = $like_flag_stmt->fetch(PDO::FETCH_ASSOC);

        //三項演算子（if文の省略形。代入のみの場合に使える）
        $feed['is_liked'] = $is_liked ? true:false;
        //下のif文と全く一緒
        //if ($is_liked) {
          //$feed['is_liked'] = true;
        //}else{$feed['is_liked'] = false; }

        //$feed連想配列にlike数を格納するキーを用意し、数字を代入する
        //代入するlike数を取得するSQL文の実行
        $like_sql = 'SELECT COUNT(*) as `like_count` FROM `likes` WHERE `feed_id` = ?';
        $like_data = array($feed['id']);
        $like_stmt = $dbh->prepare($like_sql);
        $like_stmt->execute($like_data);

        $like_count_data = $like_stmt->fetch(PDO::FETCH_ASSOC);

        $feed['like_count'] = $like_count_data['like_count'];

        //v($feed,'$feed');

        $feeds[] = $feed; //[]は、配列の末尾にデータを追加するという意味
    }

    //v($feeds,'$feeds');


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Learn SNS</title>
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <style>
    .error_msg {
      color: red;
      font-size: 12px;
    }
  </style>
</head>
<body style="margin-top: 60px; background: #E4E6EB;">
  <div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Learn SNS</a>
      </div>
      <div class="collapse navbar-collapse" id="navbar-collapse1">
        <ul class="nav navbar-nav">
          <li class="active"><a href="#">タイムライン</a></li>
          <li><a href="#">ユーザー一覧</a></li>
        </ul>
        <form method="GET" action="" class="navbar-form navbar-left" role="search">
          <div class="form-group">
            <input type="text" name="search_word" class="form-control" placeholder="投稿を検索">
          </div>
          <button type="submit" class="btn btn-default">検索</button>
        </form>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <span hidden id="signin-user"><?php echo $signin_user['id']; ?></span>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="user_profile_img/<?php echo $signin_user['img_name']; ?>" width="40" class="img-circle"><span>  </span><?php echo $signin_user['name']; ?> <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#">マイページ</a></li>
              <li><a href="signout.php">サインアウト</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row">
      <div class="col-xs-3">
        <ul class="nav nav-pills nav-stacked">
          <li class="active"><a href="timeline.php?feed_select=news">新着順</a></li>
          <li><a href="timeline.php?feed_select=likes">いいね！済み</a></li>
          <!-- <li><a href="timeline.php?feed_select=follows">フォロー</a></li> -->
        </ul>
      </div>
      <div class="col-xs-9">
        <div class="feed_form thumbnail">
          <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
              <textarea name="feed" class="form-control" rows="3" placeholder="Happy Hacking!" style="font-size: 24px;"></textarea><br>
              <?php if(isset($validations['feed']) && $validations['feed'] == 'blank'): ?>
                <span class="error_msg">投稿データを入力してください</span>
              <?php endif; ?>
            </div>
            <input type="submit" value="投稿する" class="btn btn-primary">
          </form>
        </div>

        <?php foreach ($feeds as $feed_each ) {
          //require と include の違い
          //どちらも外部ファイルを読み込む時に使用される
          //require。。。読み込んだ外部ファイル内でエラーが発生した場合、処理を中断する。
          //include。。。読み込んだ外部ファイル内でエラーが発生した場合、処理を続行する。
          //require。。。DB接続などのエラーが出ると致命的な処理に使用
          //include。。。HTML、CSSなど表示系に使用（一部表示にエラーが出ていても処理ができる可能性がある）
          include("timeline_row.php");
        } ?>

        <div aria-label="Page navigation">
          <ul class="pager">
            <li class="previous disabled"><a href="#"><span aria-hidden="true">&larr;</span> Newer</a></li>
            <li class="next"><a href="#">Older <span aria-hidden="true">&rarr;</span></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/js/jquery-3.1.1.js"></script>
  <script src="assets/js/jquery-migrate-1.4.1.js"></script>
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/app.js"></script>

</body>
</html>
