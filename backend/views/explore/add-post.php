<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model backend\models\ExploreRecommend */

$this->title = Yii::t('app', 'Create Explore Recommend');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Explore Recommends'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="explore-recommend-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
//        Modal::begin([
//        'header' => '<h2>Hello world</h2>',
//        'toggleButton' => ['label' => 'click me', 'class' => 'btn btn-success'],
//        ]);
            echo $this->render('_form', [
                'model' => $model,
            ]);
//        Modal::end();
    ?>

</div>
