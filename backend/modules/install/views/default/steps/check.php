<?php

use yii\bootstrap\Alert;

if (!$this->context->result) {
    echo Alert::widget([
        'options' => [
            'class' => 'alert-danger',
        ],
        'closeButton' => false,
        'body' => Yii::t('install', '<strong>Warning! Errors found. Please correct any errors before continuing.</strong>'),
    ]);
    $steps[$currentStep]['valid'] = false;
    Yii::$app->session->set('steps', $steps);
}
else {
    $steps[$currentStep]['valid'] = true;
    Yii::$app->session->set('steps', $steps);
}