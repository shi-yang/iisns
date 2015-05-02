<?php

use yii\helpers\Html;
use yii\helpers\Url;
use shiyang\masonry\Masonry;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['title'] = Yii::t('app', 'Explore') . ' - ' . Yii::t('app', 'Photos');
$this->registerCss('
.album-all {
    list-style-type: none;
}
.album-item {
      background: #fcfcfc;
      margin-bottom: 20px;
      -moz-border-radius: 3px;
      -webkit-border-radius: 3px;
      border-radius: 3px;
      -moz-box-shadow: 0 3px 0 rgba(12,12,12,0.03);
      -webkit-box-shadow: 0 3px 0 rgba(12,12,12,0.03);
      box-shadow: 0 3px 0 rgba(12,12,12,0.03);
      position: relative;
}
.album-img img {
  -moz-border-radius: 3px 3px 0 0;
  -webkit-border-radius: 3px 3px 0 0;
  border-radius: 3px 3px 0 0;
}
');
?>
<div class="album-index container-fluid">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Masonry::begin([
        'options' => [
          'id' => 'photos'
        ],
        'pagination' => $pages
    ]); ?>
    <?php foreach ($albums as $model): ?>
        <?php
            $albumUrl = Url::toRoute(['/explore/view-album', 'id' => $model['id']]);
            $src = (empty($model['path'])) ? Yii::getAlias('@web/images/pic-none.png') : Yii::getAlias('@photo') . $model['path'] ;
        ?>
        <div class="col-xs-6 col-sm-4 col-md-3">
            <div class="album-item">
                <a href="<?= $albumUrl ?>" class="album-img">
                <a title="<?= Html::encode($model['name']) ?>" href="<?= Yii::getAlias('@photo').$model['path']?>" data-lightbox="image-1" data-title="<?= Html::encode($model['name']) ?>">
                    <img src="<?= $src ?>" class="img-responsive" alt="album-cover">
                </a>
            </a>
            <?= Html::a($model['name'], $albumUrl) ?>
        </div>
        </div>
    <?php endforeach ?>
    <?php Masonry::end(); ?>
</div>
