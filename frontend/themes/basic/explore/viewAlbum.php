<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\home\models\Album */

$this->title = $model->name . '_' . Yii::$app->setting->get('siteName');
$this->params['title'] = $model->name;
$this->registerMetaTag(['name' => 'keywords', 'content' => $model->name . Yii::$app->setting->get('siteKeyword')]);
$this->registerMetaTag(['name' => 'description', 'content' => $model->description]);
//$view = new \yii\web\View;

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
.img-all {

}
.img-item {
box-shadow: 0 1px 2px 0 rgba(210,210,210,.31);
-webkit-box-shadow: 0 1px 2px 0 rgba(180,180,180,.5);
overflow: hidden;
margin-bottom: 20px;
}
.img-item:hover {
    opacity: .8;
    filter: alpha(opacity=80);
}
.img-main {
    margin-bottom: 5px;
    background-color: #fff;
}
.img-main img {
    min-width:100%;
    max-width: 100%;
}
.img-name {
    display:block;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
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
            <?php \yii2masonry\yii2masonry::begin([
                'clientOptions' => [
                    'itemSelector' => '.img-item'
                ]
            ]); ?>
            <?php foreach ($model->photos as $photo): ?>
                <div class="img-item col-md-3">
                    <div class="img-main">
                        <a title="<?= Html::encode($photo['name']) ?>" href="<?= Yii::getAlias('@photo').$photo['path']?>" data-lightbox="image-1" data-title="<?= Html::encode($photo['name']) ?>">
                            <img src="<?= Yii::getAlias('@photo').$photo['path'] ?>"> 
                        </a>
                        <div class="img-name"><?= Html::encode($photo['name']) ?></div> 
                    </div>
                </div>
            <?php endforeach ?>
            <?php \yii2masonry\yii2masonry::end(); ?>
        </div>
    <?php endif ?>
</div>
