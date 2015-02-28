<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\Message */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="message-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'sendto', [
        'template' => "<div class=\"input-group\"><span class=\"input-group-addon\">Sendto</span>{input}</div>{error}",
    ])->textInput(['maxlength' => 32, 'autocomplete'=>'off']) ?>

    <?= $form->field($model, 'subject', [
        'template' => "<div class=\"input-group\"><span class=\"input-group-addon\">Subject</span>{input}</div>{error}",
    ])->textInput(['maxlength' => 32, 'autocomplete'=>'off']) ?>

    <?= $form->field($model, 'content')->widget('kucha\ueditor\UEditor', [
        'clientOptions' => [
            'elementPathEnabled' => false,
            'focus' => true,
            'autosave' => false,
            'toolbars' => [
                [
                    'fullscreen', 'preview', 'source', 'undo', 'redo', 'insertcode',
                    'justifyleft', 'justifyright', 'justifycenter', 'justifyjustify'
                ],
                [
                    'emotion', 'simpleupload', 'insertimage', 'link', 'insertvideo', 'music', '|',
                    'autotypeset', 'customstyle', 'fontfamily', 'fontsize',
                    'bold', 'italic', 'underline', 'strikethrough', 'removeformat',
                    'formatmatch', 'blockquote', 'pasteplain', '|',
                    'forecolor', 'backcolor', '|',
                ],
            ],
        ]
    ])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
