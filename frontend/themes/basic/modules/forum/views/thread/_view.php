<?php 
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;

$user = $data->user;
?>
<div class="row thread-view" id="thread-wrap">
	<div class="col-sm-2">
		<div class="thread-meta">
			<div class="author hidden-xs">
				<img src="<?= Yii::getAlias('@avatar') . $user['avatar'] ?>" alt="User avatar">
			</div>
			<p style="margin: 0;font-weight: bold;white-space: normal;word-break: break-all;<?php if($data->is_broadcast) echo "color:#ff6f3d;"; ?>">
			  	<?= Html::a(Html::encode($user['username']), ['/user/view', 'id' => $user['username']]) ?>
			</p>
		</div>
	</div>
	<div class="col-sm-10">
		<div class="thread-head">
			<span class="glyphicon glyphicon-time"></span>
			<?= \app\components\Tools::formatTime($data->create_time) ?>
		</div>
		<div class="thread-main">
			<h3><?= Html::a(Html::encode($data->title), $data->url) ?></h3>
			<div class="content">
			 <?= HtmlPurifier::process($data->content) ?>
			</div>
		</div>
	</div>
</div>
