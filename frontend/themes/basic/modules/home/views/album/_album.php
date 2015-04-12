<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\home\models\Album;

$albumUrl = Url::toRoute(['/home/album/view', 'id' => $model['id']]);
$src = Album::getCoverPhoto($model['id'], $model['cover_id']);
$name = ($model['status'] != Album::TYPE_PUBLIC) ? '<i class="glyphicon glyphicon-lock"></i>'.Html::encode($model['name']) : Html::encode($model['name']) ;
?>
<div class="album-img">
	<a href="<?= $albumUrl ?>">
		<img src="<?= $src ?>" class="album-cover" alt="album-cover">
	</a>
</div>

<?= Html::a($name, $albumUrl) ?>
