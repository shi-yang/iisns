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
        'template' => "<div class=\"input-group\"><span class=\"input-group-addon\">" . Yii::t('app', 'Sendto') . "</span>{input}</div>{error}",
    ])->textInput(['maxlength' => 32, 'autocomplete'=>'off']) ?>

    <?= $form->field($model, 'subject', [
        'template' => "<div class=\"input-group\"><span class=\"input-group-addon\">" . Yii::t('app', 'Subject') . "</span>{input}</div>{error}",
    ])->textInput(['maxlength' => 32, 'autocomplete'=>'off']) ?>

    <?= $form->field($model, 'content')->widget('shiyang\umeditor\UMeditor', [
        'clientOptions' => [
            'initialFrameHeight' => 230,
            'toolbar' => [
                'source | undo redo | bold |',
                'link unlink | emotion image video |',
                'justifyleft justifycenter justifyright justifyjustify |',
                'insertorderedlist insertunorderedlist |' ,
                'horizontal preview fullscreen',
            ],
        ]
    ])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
