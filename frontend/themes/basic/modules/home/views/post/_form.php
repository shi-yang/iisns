<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\home\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title', [
      'template' => "<div class=\"input-group\"><span class=\"input-group-addon\">" . Yii::t('app', 'Title') . "</span>{input}</div>",
    ])->textInput(['maxlength' => 128, 'autocomplete'=>'off']) ?>

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
    
    <?= $form->field($model, 'tags')->textarea(['rows' => 1]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
