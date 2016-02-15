<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\forum\models\Forum */

$this->title = $model->forum_name;
$this->registerMetaTag(['name' => 'keywords', 'content' => $model->forum_name]);
$this->registerMetaTag(['name' => 'description', 'content' => $model->forum_desc]);
$this->params['forum'] = $model->toArray;
?>

<div class="jumbotron">
    <h2><?= Yii::t('app', 'Please wait for the administrator to review.'); ?></h2>
</div>
