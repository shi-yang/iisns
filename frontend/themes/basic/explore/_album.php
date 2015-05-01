<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<?php \yii2masonry\yii2masonry::begin([
    'clientOptions' => [
        'columnWidth' => 0,
        'itemSelector' => '.col-xs-6'
    ]
]); ?>
<?php foreach ($albums as $model): ?>
    <?php
        $albumUrl = Url::toRoute(['/explore/view-album', 'id' => $model['id']]);
        //$src = Album::getCoverPhoto($model['id'], $model['cover_id']);
        $src = (empty($model['path'])) ? Yii::getAlias('@web/images/pic-none.png') : Yii::getAlias('@photo') . $model['path'] ;
    ?>
    <div class="col-xs-6 col-sm-4 col-md-3">
        <div class="album-item">
            <a href="<?= $albumUrl ?>" class="album-img">
            <img src="<?= $src ?>" class="img-responsive" alt="album-cover">
        </a>
        <?= Html::a($model['name'], $albumUrl) ?>
    </div>
    </div>
<?php endforeach ?>
<?php \yii2masonry\yii2masonry::end(); ?>
