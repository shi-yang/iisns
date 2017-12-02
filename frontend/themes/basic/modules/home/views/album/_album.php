<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\home\models\Album;

$albumUrl = Url::toRoute(['/home/album/view', 'id' => $model['id']]);
$src = Album::getCoverPhoto($model['id'], $model['cover_id']);
$name = Html::encode($model['name']);
$status = ($model['status'] != Album::TYPE_PUBLIC) ? '<i class="glyphicon glyphicon-lock"></i>' : '';
?>
<div class="album-img">
    <a href="<?= $albumUrl ?>" data-pjax="0">
        <img src="<?= $src ?>" class="album-cover" alt="album-cover">
    </a>
</div>
<div class="album-info">
	<div class="album-desc">
		<div class="album-desc-side"><?= $status ?></div>
		<div class="album-tit">
			<?= Html::a($name, $albumUrl, ['class' => 'album-name', 'data-pjax' => 0]) ?>
		</div>
	</div>
</div>
