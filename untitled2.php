<div class="thumbnail">
            <div class="row">
              <div class="col-xs-1">
                <img src="https://placehold.jp/40x40.png" width="40">
              </div>
              <div class="col-xs-11">
                野原ひろし<br>
                <a href="#" style="color: #7F7F7F;">2018-03-03</a>
              </div>
            </div>
            <div class="row feed_content">
              <div class="col-xs-12" >
                <?php if(isset($validations['feed']) && $validations['feed'] != 'blank'): ?>
                  <span style="font-size: 24px;"><?php echo $validations['feed']; ?></span>
                <?php endif; ?>
              </div>
            </div>
            <div class="row feed_sub">
              <div class="col-xs-12">
                <form method="POST" action="" style="display: inline;">
                  <input type="hidden" name="feed_id" >
                  
                    <input type="hidden" name="like" value="like">
                    <button type="submit" class="btn btn-default btn-xs"><i class="fa fa-thumbs-up" aria-hidden="true"></i>いいね！</button>
                </form>
                <span class="like_count">いいね数 : 100</span>
                <span class="comment_count">コメント数 : 9</span>
                  <a href="#" class="btn btn-success btn-xs">編集</a>
                  <a href="#" class="btn btn-danger btn-xs">削除</a>
              </div>
            </div>
          </div>