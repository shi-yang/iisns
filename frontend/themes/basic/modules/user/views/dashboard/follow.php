<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = $title;
$users = $model->getFollow($type);
if ($type === 'following') {
  $this->registerJs("
    $('.btn-follow').css('display', 'none');
  ");
}
if ($type === 'follower') {
  $this->registerJs("
    $('.btn-unfollow').css('display', 'none');
  ");
}
?>
<div class="page-header">
  <h2><?= $title ?></h2>
</div>
<div class="follow-list row">
  <?php foreach($users['result'] as $user): ?>
    <div class="follow-list-item col-md-4" id="<?= $user['id'] ?>">
      <a class="pull-left" href="<?= Url::toRoute(['/user/view', 'id' => Html::encode($user['username'])]) ?>" rel="author">
        <img class="avatar" src="<?= Yii::getAlias('@avatar') . $user['avatar'] ?>" alt="@<?= Html::encode($user['username']) ?>">
      </a>
      <div class="follow-list-container">
        <h3 class="follow-list-name">
          <span><?= Html::a(Html::encode($user['username']), ['/user/view', 'id' => Html::encode($user['username'])], ['rel' => 'author']) ?></span>
        </h3>
        <div class="user-following-container">
          <a class="btn btn-sm btn-default btn-follow"><span class="glyphicon glyphicon-plus"></span> <?= Yii::t('app', 'Follow') ?></a>
          <a class="btn btn-sm btn-default btn-unfollow" href="<?= Url::toRoute(['/user/user/follow', 'id' => $user['id']]) ?>" data-clicklog="delete" onclick="return false;" title="取消关注">
            <span class="glyphicon glyphicon-eye-close"></span> <?= Yii::t('app', 'Unfollow') ?>
          </a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?php
echo LinkPager::widget([
    'pagination' => $users['pages'],
  ]);
?>
