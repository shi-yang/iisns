<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\blog\models\Album */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'My Albums'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


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
    margin-top:20px
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
.img-edit {
    position: absolute;
    top:0;
    right:0;
}
.img-main {
    margin-bottom: 5px;
    background-color: #fff;
}
.img-main img {
    min-width:100%
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
    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('<i class="glyphicon glyphicon-edit"></i> ' . Yii::t('app', 'Edit Album'), ['/blog/album/update', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    <?php if ($model->photoCount == 0 && $model->created_by === Yii::$app->user->id): ?>
        <div class="no-photo">
            <img src="<?= Yii::getAlias('@web/images/no_photo.png') ?>" class="no-picture" alt="No photos">
            <div class="no-photo-msg">                       
                <div><?= Yii::t('app', 'No photo in this album, click "Upload new photo" to make up your album.') ?></div>
                <div class="button">
                    <div class="bigbutton">
                        <a href="<?= Url::toRoute(['/blog/album/upload', 'id' => $model->id]) ?>" class="btn btn-default">
                            <span class="glyphicon glyphicon-plus"></span> <?= Yii::t('app', 'Upload a new photo') ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <a href="<?= Url::toRoute(['/blog/album/upload', 'id' => $model->id]) ?>" class="btn btn-default">
            <span class="glyphicon glyphicon-plus"></span> <?= Yii::t('app', 'Upload a new photo') ?>
        </a>
        <div class="img-all row">
            <?php \yii2masonry\yii2masonry::begin([
                'clientOptions' => [
                    'itemSelector' => '.img-item'
                ]
            ]); ?>
            <?php foreach ($model->photos as $photo): ?>
                <div class="img-item col-md-3">
                    <a class="img-edit" href="<?= Url::toRoute(['/blog/photo/delete', 'id' => $photo['id']]) ?>" data-confirm=<?= Yii::t('app', 'Are you sure to delete it?') ?> data-method="photo"><span class="glyphicon glyphicon-remove"></span></a>
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
