<?php

use yii\helpers\Html;
use yii\helpers\Url;
use shiyang\masonry\Masonry;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['title'] = Yii::t('app', 'Explore') . ' - ' . Yii::t('app', 'Photos');
$this->params['breadcrumb'][] = Yii::t('app', 'Photos');
$this->registerCssFile('@web/js/lightbox/css/lightbox.css');
$this->registerJsFile('@web/js/lightbox/js/lightbox.min.js', ['depends' => ['yii\web\JqueryAsset'], 'position' => \yii\web\View::POS_END]);
$this->registerCss('
.photo-index {
  padding:0
}
.photo-item {
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
.photo-img img {
  -moz-border-radius: 3px 3px 0 0;
  -webkit-border-radius: 3px 3px 0 0;
  border-radius: 3px 3px 0 0;
}
.photo-details {
  padding: 10px;
  font-weight: bold;
  border-top: 1px solid #e7e7e7;
  color: #777;
  line-height: 15px;
  font-size: 11px;
}
.photo-details:hover {
  background: #f1f1f1;
}
.photo-title {
  margin: 0;
  font-weight: normal;
}
.user-image, .user-image img {
    position: relative;
  border-radius: 2px;
  float: left;
  height: 30px;
  margin-right: 5px;
  width: 30px;
}
.photo-at {
  white-space: nowrap;
  overflow: hidden;
  -ms-text-overflow: ellipsis;
  text-overflow: ellipsis;
}
.album-title {
  white-space: nowrap;
  overflow: hidden;
  -ms-text-overflow: ellipsis;
  text-overflow: ellipsis;
  overflow: hidden;
  display: block;
}
');
?>
<div class="photo-index container-fluid">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Masonry::begin([
        'options' => [
          'id' => 'photos'
        ],
        'pagination' => $pages
    ]); ?>
    <?php foreach ($photos as $model): ?>
        <?php
            $albumUrl = Url::toRoute(['/explore/view-album', 'id' => $model['id']]);
            $src = (empty($model['path'])) ? Yii::getAlias('@web/images/pic-none.png') : $model['path'] ;
        ?>
        <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
            <div class="photo-item">
                <a title="<?= Html::encode($model['name']) ?>" href="<?= $src ?>" data-lightbox="image-1" data-title="<?= Html::encode($model['name']) ?>">
                    <img src="<?= $src ?>" class="img-responsive" alt="photo-cover">
                </a>
                <div class="photo-details">                         
                  <a href="<?= $albumUrl ?>">
                    <div class="user-image">
                      <div class="heightContainer">
                        <img src="<?= Yii::getAlias('@avatar') . $model['avatar'] ?>">
                      </div>
                    </div>
                    <div class="photo-at"><?= Html::encode($model['username']) ?></div>
                    <div class="album-title">@ <?= Html::encode($model['name']) ?></div>
                  </a>
                </div>
            </div>
        </div>
    <?php endforeach ?>
    <?php Masonry::end(); ?>
</div>
