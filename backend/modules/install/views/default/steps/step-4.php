<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<h1><?= Yii::t('install', 'Step 4: Create administrator.'); ?></h1>
<div class="well">
    <?php
    $form = ActiveForm::begin([
        'id' => 'Administrator',
        'enableClientScript' => false,
        'enableClientValidation' => true,
        'encodeErrorSummary' => false,
    ]);
    echo $form->errorSummary($admin, [
        'class' => 'alert alert-danger'
    ]);
    ?>
    <?= $form->field($admin, 'name')->textInput(['autocomplete' => 'off', 'placeholder' => $admin->getAttributeLabel('name')]); ?>
    <?= $form->field($admin, 'password')->passwordInput(['autocomplete' => 'off', 'placeholder' => $admin->getAttributeLabel('password')]); ?>
    <?= $form->field($admin, 'email')->textInput(['autocomplete' => 'off', 'placeholder' => $admin->getAttributeLabel('email')]); ?>
    <?php
    echo \yii\bootstrap\Button::widget([
        'id' => 'backButton',
        'label' => Yii::t('install', 'Back'),
        'encodeLabel' => false,
        'options' => [
            'class' => 'btn btn-info',
            'onClick' => new \yii\web\JsExpression("
            $('#stepsMenu a:eq($previousStep)').click();
            return false;")
        ]
    ]);
    echo Html::a(Yii::t('install', 'Continue'), '', [
        'class' => 'btn btn-info',
        'style' => 'margin-left: 10px;',
        'onClick' => new \yii\web\JsExpression("
        $('#Administrator').submit();
        return false;")
    ]);
    ?>
</div>