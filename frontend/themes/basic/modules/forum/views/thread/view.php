<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $model app\modules\forum\models\Post */

$this->title = $model->title;
$this->params['forum'] = $model->forum;
if (!$model->isOneBoard()):
	$this->params['breadcrumbs'][] = ['label' => $model->board['name'], 'url' => ['/forum/board/view', 'id' => $model->board['id']]];
endif;
$this->params['breadcrumbs'][] = $model->user['username'];
?>
<div class="widget-container">
	<?= $this->render('_view', array('data'=>$model)); ?>

	<!-- Post Form Begin -->
	<?= $this->render('/post/_form',[
			'model'=>$newPost,
		]); 
	?>
	<!-- Post Form End -->
	<div class="row">
		<div class="col-lg-12">
			<h3 style="margin-left: 20px;"><?= $model->postCount ?> Comments</h3>
		</div>
	</div>

	<?= $this->render('_posts', [
			'posts'=>$model->posts['posts'],
			'floor'=> count($model->posts['posts']),	
			'pageSize'=>$model->posts['pages']->pageSize,
		]); 
	?>
	<?= LinkPager::widget([
       'pagination' => $model->posts['pages'],
    ]);?>
</div>
