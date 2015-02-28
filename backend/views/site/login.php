<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="form-box" id="login-box">
    <div class="header">Sign In</div>
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <div class="body bg-gray">
            <?= $form->field($model, 'username', [
                'inputOptions' => [
                    'placeholder' => $model->getAttributeLabel('username'),
                ]
            ])->label(false); ?>

            <?= $form->field($model, 'password', [
                'inputOptions' => [
                    'placeholder' => $model->getAttributeLabel('password'),
                ]
            ])->passwordInput()->label(false); ?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>
        </div>
        <div class="footer">
            <?= Html::submitButton('Sign me in', ['class' => 'btn bg-olive btn-block', 'name' => 'login-button']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>