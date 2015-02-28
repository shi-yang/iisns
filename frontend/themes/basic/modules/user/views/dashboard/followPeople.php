<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use app\components\FormatTime;
use app\modules\user\models\User;
?>
<?php foreach($posts as $post): ?>
<!-- Text Post -->
    <div class="item widget-container fluid-height social-entry">
      <div class="widget-content padded">
        <div class="profile-info clearfix">
          <img width="50" height="50" class="social-avatar pull-left" src="images/avatar-female2.png" />
          <div class="profile-details">
            <a class="user-name" href="#"><?= Html::encode(User::getUser($post['user_id'])) ?></a>
            <p>
              <em><?= \app\components\Tools::formatTime($post['create_time']) ?></em>
            </p>
          </div>
        </div>
        <p class="content">
          <?= $post['content'] ?>
        </p>
        <div class="btn btn-sm btn-default-outline">
          <i class="icon-thumbs-up-alt"></i>
        </div>
        <div class="btn btn-sm btn-default-outline">
          <i class="icon-mail-forward"></i>
        </div>
      </div>
      <div class="comments padded">
        <form role="form">
          <div class="form-group">
            <input class="form-control" id="exampleInputEmail1" placeholder="Add a comment..." type="email">
          </div>
        </form>
      </div>
    </div>
    <!-- end Text Post -->
<?php endforeach; ?>

<?php
echo LinkPager::widget([
      'pagination' => $pages,
  ]);
?>