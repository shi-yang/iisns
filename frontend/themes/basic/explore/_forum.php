<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php foreach($forums as $model): ?>
    <div class="item" onclick="window.location.href= '<?= \yii\helpers\Url::toRoute(['/forum/forum/view', 'id' => $model['forum_url']]) ?>';return false">
      <div class="row">
        <img src="<?= Yii::getAlias('@forum_icon') . $model['forum_icon'] ?>" class="col-md-12 col-sm-12 col-xs-4">
        <div class="meta col-md-12 col-sm-8 col-xs-8">
          <strong class="forum-name"><?= Html::encode($model['forum_name']); ?></strong>
        </div>
        <div class="forum-description col-md-12 col-sm-8 col-xs-8">
          <?= Html::encode($model['forum_desc']); ?>
        </div>
      </div>
    </div>
<?php endforeach; ?>
