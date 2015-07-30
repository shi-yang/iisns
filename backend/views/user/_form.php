<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['maxlength' => 32]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 32]) ?>

    <?= $form->field($model, 'password_hash')->textInput(['maxlength' => 255, 'disabled' => true]) ?>

    <?= $form->field($model, 'new_password')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'password_reset_token')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'auth_key')->textInput(['maxlength' => 255, 'disabled' => true]) ?>

    <?= $form->field($model, 'role')->textInput() ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 64]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'avatar')->textInput(['maxlength' => 24]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
