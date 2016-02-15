<div class="media">
    <div class="media-left">
        <a href="">
            <img width="50" height="50" class="media-object" src="<?= $user['avatar']; ?>" alt="<?= $user['username']; ?>">
        </a>
    </div>
    <div class="media-body">
        <h4 class="media-heading"><?= $user['username']; ?></h4>
        <a class="btn btn-xs btn-success btn-follow" href="<?= $user['followUrl']; ?>"><?= $user['followBtn']; ?></a>
    </div>
    <div class="media-footer">
        <div class="row">
            <div class="col-xs-4 text-center">
                <span class="block font-14"><?= $user['userData']['following_count']; ?></span><br>
                <small class="text-muted"><?= Yii::t('app', 'Following') ?></small>
            </div><!-- /.col -->
            <div class="col-xs-4 text-center">
                <span class="block font-14"><?= $user['userData']['follower_count']; ?></span><br>
                <small class="text-muted"><?= Yii::t('app', 'Follower') ?></small>
            </div><!-- /.col -->
            <div class="col-xs-4 text-center">
                <span class="block font-14"><?= $user['userData']['feed_count']; ?></span><br>
                <small class="text-muted"><?= Yii::t('app', 'Feed') ?></small>
            </div><!-- /.col -->
        </div>
    </div>
</div>
