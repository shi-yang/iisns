<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<h1><?= Yii::t('install', 'Step 3: Configuring the database.'); ?></h1>
<div class="well">
    <?php
    $form = ActiveForm::begin([
        'id' => 'Database',
        'enableClientScript' => false,
        'enableClientValidation' => true,
        'encodeErrorSummary' => false,
    ]);
    echo $form->errorSummary($database, [
        'class' => 'alert alert-danger'
    ]);
    ?>
    <?= $form->field($database, 'type')->radioList($database->types) ?>
    <?php
    foreach ($database->safeAttributes() as $index => $attribute) {
        if($attribute == 'type')
            continue;
        $type = $attribute != 'createdb' ? ($attribute == 'password' ? 'passwordInput' : 'textInput') : 'checkbox';
        echo $form->field($database, $attribute)->$type(['autocomplete' => 'off', 'placeholder' => $database->getAttributeLabel($attribute)]);
    }
    ?>
    <?php
    echo Html::a(Yii::t('install', 'Back'), ['index', 'step' => $previousStep], ['class' => 'btn btn-default']);
    echo Html::a(Yii::t('install', 'Continue'), '', [
        'class' => 'btn btn-success pull-right',
        'style' => 'margin-left: 10px;',
        'onClick' => new \yii\web\JsExpression("
        $('#Database').submit();
        return false;")
    ]);
    ?>
</div>