<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\blog\models\Photo */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Albums'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="album-view">
    <h1><?= Html::encode($this->title) ?></h1>
</div>
<div class="row">
    <div class="col-md-9">
        <img src="<?= Yii::getAlias('@photo'). $model->path ?>">
    </div>
    <div class="col-md-3"></div>
</div>
