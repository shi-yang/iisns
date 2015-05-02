<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Forum */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="forum-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'forum_name')->textInput(['maxlength' => 32]) ?>

    <?= $form->field($model, 'forum_desc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'forum_url')->textInput(['maxlength' => 32]) ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'forum_icon')->textInput(['maxlength' => 26]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
