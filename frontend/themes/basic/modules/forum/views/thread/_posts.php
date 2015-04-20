<?php 
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use shiyang\infinitescroll\InfiniteScrollPager;

if (isset($_GET['page']) >= 2) //分页标识大于2才开始计算
    $floor -= ($pageSize * $_GET['page']) - $pageSize;
?>
<div id="post-view">
	<?php foreach($posts as $post): 
		$floor_number=$floor--;
	?>
		<div class="row thread-view">
			<div class="col-sm-2">
				<div class="thread-meta">
					<div class="author hidden-xs">
						<img src="<?= Yii::getAlias('@avatar') . $post['avatar'] ?>" alt="User avatar">
					</div>
					<p style="margin: 0;font-weight: bold;white-space: normal;word-break: break-all;">
					  	<?= Html::a(Html::encode($post['username']), ['/user/view', 'id' => $post['username']]) ?>
					</p>
				</div>
			</div>
			<div class="col-sm-10">
				<div class="post-meta">
					<a class="floor-number" id="<?= $post['id'] ;?>" href="#<?= $floor_number ?>">
						<span class="post-time">
							<?= \app\components\Tools::formatTime($post['create_time']) ?>
						</span>   <span class="badge">#<?= $floor_number ?></span>
					</a>
				</div>
				<div class="post-main">
					<?= HtmlPurifier::process($post['content']) ?>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
    <?= InfiniteScrollPager::widget([
        'pagination' => $pages,
        'widgetId' => '#post-view',
    ]);?>
</div>