<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ExploreRecommend */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Explore Recommend',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Explore Recommends'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="explore-recommend-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
