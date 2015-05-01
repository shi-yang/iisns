<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\forum\models\Post */

$seoInfo = $model->seoInfo;
$this->title = $seoInfo['title'];
$this->registerMetaTag(['name' => 'keywords', 'content' => $seoInfo['keywords']]);
$this->registerMetaTag(['name' => 'description', 'content' => $seoInfo['description']]);

$this->params['forum'] = $model->forum;
if (!$model->isOneBoard()):
    $this->params['breadcrumbs'][] = ['label' => $model->board['name'], 'url' => ['/forum/board/view', 'id' => $model->board['id']]];
endif;
$this->params['breadcrumbs'][] = $model->user['username'];

$posts = $model->posts;
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
            'posts'=>$posts['posts'],
            'floor'=> count($posts['posts']),
            'pageSize'=>$posts['pages']->pageSize,
               'pages' => $posts['pages'],
        ]); 
    ?>
</div>
