<?php
$this->title = Yii::t('app', 'Video');
?>
<video id="video1" width="420" style="margin-top:15px;" controls="controls" controls="controls">
	<source src="<?= Yii::getAlias('@web') ?>/css/mov.mp4" type="video/mp4" />
	Your browser does not support HTML5 video.
</video>
<br>
<div class="page-title">
  <h1><?= Yii::t('app', 'Note: This section is under development.') ?></h1>
  <h3>
      <?= Yii::t('app', 'I am very sorry to let you see this page. I will try to go to this page and complete, stay tuned!') ?>
  </h3>
  <p><?= Yii::t('app', 'You are welcome to develop together.') ?></p>
</div>
