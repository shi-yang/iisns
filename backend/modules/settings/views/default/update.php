<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\settings\models\Settings */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Settings',
]) . ' ' . $model->key;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->key, 'url' => ['view', 'id' => $model->key]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="settings-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
