          <div class="thumbnail">
            <div class="row">
              <div class="col-xs-1">
                <img src="user_profile_img/<?php echo $feed_each['profile_image'];?>" width="70">
                <!-- [<a href="signout.php">サインアウト</a>] -->

              </div>
              <div class="col-xs-11">
                <?php echo $feed_each["name"]."<br>"; ?>
                <a href="#" style="color: #7F7F7F;"><?php echo $feed_each["created"]; ?></a>
              </div>
            </div>
            <div class="row feed_content">
              <div class="col-xs-12" >
                <span style="font-size: 24px;"><?php echo $feed_each["feed"]; ?></span>
              </div>
            </div>
            <div class="row feed_sub">
              <div class="col-xs-12">
                <!-- <form method="POST" action="" style="display: inline;">
                  <input type="hidden" name="feed_id" >
                  
                    <input type="hidden" name="like" value="like">
                    <button type="submit" class="btn btn-default btn-xs"><i class="fa fa-thumbs-up" aria-hidden="true"></i>いいね！</button>
                </form>
                <span class="like_count">いいね数 : 100</span>-->
                <span hidden class="feed_id" ><?= $feed_each["id"] ?></span>
                  <button class="btn btn-default btn-xs js-like">
                    <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                    <span>いいね!</span>
                  </button>
                <span>いいね数 : </span>
                <span class="like_count"><?= $feed_each['like_count']; ?></span>


                <span class="comment_count">コメント数 : 9</span>
                <?php if ($_SESSION["id"]==$feed_each['user_id']) :?> 
                  <a href="edit.php?feed_id=<?= $feed_each['id'];?>"s class="btn btn-success btn-xs">編集</a>
                  <a onclick="return confirm('ほんとに消すの？');" href="delete.php?feed_id=<?= $feed_each['id'];?>" class="btn btn-danger btn-xs">削除</a>
                  <!-- ?はGET送信という意味 -->
                <?php endif;?>
              </div>
            </div>
          </div>
          <!-- <?php  v($feed_each,'$feed_each'); ?> -->