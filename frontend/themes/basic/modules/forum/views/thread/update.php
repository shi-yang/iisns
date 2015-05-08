<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\forum\models\Post */

$seoInfo = $model->seoInfo;
$this->title = $seoInfo['title'];
$this->registerMetaTag(['name' => 'keywords', 'content' => $seoInfo['keywords']]);
$this->registerMetaTag(['name' => 'description', 'content' => $seoInfo['description']]);

$this->params['forum'] = $model->forum;
$this->params['breadcrumbs'][] = $model->user['username'];
?>
<div class="widget-container">
    <?= $this->render('_form', ['model'=>$model]); ?>
</div>
