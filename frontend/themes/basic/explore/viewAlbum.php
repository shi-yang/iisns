<?php

use yii\helpers\Html;
use yii\helpers\Url;
use shiyang\masonry\Masonry;

/* @var $this yii\web\View */
/* @var $model app\modules\home\models\Album */

$this->title = $model->name . '_' . Yii::$app->setting->get('siteName');
$this->params['title'] = $model->name;
$this->params['breadcrumb'][] = ['label' => Yii::t('app', 'Photos'), 'url' => ['/explore/photos']];
$this->params['breadcrumb'][] = $model->name;
$this->registerMetaTag(['name' => 'keywords', 'content' => $model->name . Yii::$app->setting->get('siteKeyword')]);
$this->registerMetaTag(['name' => 'description', 'content' => $model->description]);
$this->registerCssFile('@web/js/lightbox/css/lightbox.css');
$this->registerJsFile('@web/js/lightbox/js/lightbox.min.js', ['depends' => ['yii\web\JqueryAsset'], 'position' => \yii\web\View::POS_END]);
$this->registerCss('
.no-photo {
    padding: 50px 50px 150px;
}
.no-picture {
    float: left;
}
.no-photo-msg {
    float: left;
    padding-top: 40px;
    padding-left: 50px;
    font-size: 14px;
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
');
?>
<div class="album-view">
    <?php if ($model->photoCount == 0): ?>
        <?php if ($model->created_by === Yii::$app->user->id): ?>
            <div class="no-photo">
                <img src="<?= Yii::getAlias('@web/images/no_photo.png') ?>" class="no-picture" alt="No photos">
                <div class="no-photo-msg">                       
                    <div><?= Yii::t('app', 'No photo in this album, click "Upload new photo" to make up your album.') ?></div>
                    <div class="button">
                        <div class="bigbutton">
                            <a href="<?= Url::toRoute(['/home/album/upload', 'id' => $model->id]) ?>" class="btn btn-default">
                                <span class="glyphicon glyphicon-plus"></span> <?= Yii::t('app', 'Upload a new photo') ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="no-data-found">
                <i class="glyphicon glyphicon-folder-open"></i>
                <?= Yii::t('app', 'No data to display.') ?>
            </div>
        <?php endif ?>
    <?php else: ?>
        <?php if ($model->created_by === Yii::$app->user->id): ?>
            <a href="<?= Url::toRoute(['/home/album/upload', 'id' => $model->id]) ?>" class="btn btn-default">
                <span class="glyphicon glyphicon-plus"></span> <?= Yii::t('app', 'Upload a new photo') ?>
            </a>
        <?php endif ?>
        <div class="alert alert-success" role="alert">
            <a href="#">
              <img style="width: 45px;height: 45px;" src="<?= Yii::getAlias('@avatar').$model->user['avatar'] ?>" alt="User avatar">
              <?= Html::a(Html::encode($model->user['username']), ['/user/view', 'id' => Html::encode($model->user['username'])]) ?>
            </a>
        </div>
        <div class="img-all row">
            <?php Masonry::begin([
                'options' => [
                  'id' => 'photos'
                ],
                'pagination' => $model->photos['pages']
            ]); ?>
            <?php foreach ($model->photos['photos'] as $photo): ?>
                <?php
                    $albumUrl = Url::toRoute(['/explore/view-album', 'id' => $photo['id']]);
                    $src = (empty($photo['path'])) ? Yii::getAlias('@web/images/pic-none.png') : $photo['path'] ;
                ?>
                <div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="photo-item">
                        <a title="<?= Html::encode($photo['name']) ?>" href="<?= $src ?>" data-lightbox="image-1" data-title="<?= Html::encode($model['name']) ?>">
                            <img src="<?= $src ?>" class="img-responsive" alt="photo-cover">
                        </a>
                    </div>
                </div>
            <?php endforeach ?>
            <?php Masonry::end(); ?>
        </div>
    <?php endif ?>
</div>
