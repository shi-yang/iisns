<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\LightBoxAsset;
use shiyang\masonry\Masonry;

/* @var $this yii\web\View */
/* @var $model app\modules\home\models\Album */

LightBoxAsset::register($this);

$this->title = $model->name;
$this->params['user'] = $user;
$this->params['profile'] = $user->profile;
$this->params['userData'] = $user->userData;
?>

<div class="album-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php if ($model->photoCount == 0 && $model->created_by === Yii::$app->user->id): ?>
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
        <div class="img-all row">
            <?php Masonry::begin([
                'options' => [
                  'id' => 'photos'
                ],
                'pagination' => $model->photos['pages']
            ]); ?>
            <?php foreach ($model->photos['photos'] as $photo): ?>
                <div class="img-item col-md-6" id="<?= $photo['id'] ?>">
                    <div class="img-wrap">
                        <div class="img-main">
                            <a title="<?= Html::encode($photo['name']) ?>" href="<?= $photo['path']?>" data-lightbox="image-1" data-title="<?= Html::encode($photo['name']) ?>">
                                <img src="<?= $photo['path'] ?>"> 
                            </a>
                            <div class="img-name"><?= Html::encode($photo['name']) ?></div> 
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
            <?php Masonry::end(); ?>
        </div>
    <?php endif ?>
</div>
