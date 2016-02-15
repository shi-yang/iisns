<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>iiSNS</b>Admin LTE</a>
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>
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

            <?= $form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::classname(), [
                // configure additional widget properties here
            ]) ?>

            <div class="row">
                <div class="col-xs-4">
                    <?= Html::submitButton('Sign me in', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
                </div><!-- /.col -->
            </div>
        <?php ActiveForm::end(); ?>
    </div><!-- /.login-box-body -->
</div>
