<?php
use yii\bootstrap\ActiveForm; 
use yii\helpers\Html;
?>
<div class="panel panel-default">
  <div class="panel-heading"><?= $title ?></div>
  <div class="panel-body">
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <?= $form->field($user, 'username', [
              'inputOptions' => [
                  'placeholder' => $user->getAttributeLabel('username'),
              ],
            ])->label(false);
        ?>
        <?= $form->field($user, 'password', [
              'inputOptions' => [
                  'placeholder' => $user->getAttributeLabel('password'),
              ],
            ])->passwordInput()->label(false);
        ?>
        <div style="color:#999;margin:1em 0">
            If you forgot your password you can <?= Html::a('reset it', ['/site/request-password-reset']) ?>.
        </div>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Log in'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            <?= Html::a(Yii::t('app', 'Sign up now!'), ['/site/signup']) ?>
        </div>
    <?php ActiveForm::end(); ?>
  </div>
</div>
