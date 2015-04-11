<?php
use yii\helpers\Url;
use shiyang\webuploader\MultiImage;
?>
<div class="page-title">
  <h1><?= Yii::t('app', 'Albums') ?></h1>
</div>
<div class="jumbotron well">
  <h1>Hello, <?= Yii::$app->user->identity->username ?></h1>
  <?php MultiImage::widget(); ?>
</div>