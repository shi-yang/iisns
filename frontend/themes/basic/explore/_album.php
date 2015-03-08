<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\blog\models\Album;
?>

<?php foreach ($albums as $model): ?>
	<?php
		$albumUrl = Url::toRoute(['/explore/view-album', 'id' => $model['id']]);
		$src = Album::getCoverPhoto($model['id'], $model['cover_id']);
	?>
    <div class="album-item col-md-2 col-sm-6">
		<div class="album-img">
			<a href="<?= $albumUrl ?>">
				<img src="<?= $src ?>" class="album-cover" alt="album-cover">
			</a>
		</div>
		<?= Html::a($model['name'], $albumUrl) ?>
    </div>
<?php endforeach ?>
