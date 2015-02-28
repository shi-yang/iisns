<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ForumSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="forum-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'forum_name') ?>

    <?= $form->field($model, 'forum_desc') ?>

    <?= $form->field($model, 'forum_url') ?>

    <?= $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'forum_icon') ?>

    <?php // echo $form->field($model, 'theme') ?>

    <?php // echo $form->field($model, 'layout') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
