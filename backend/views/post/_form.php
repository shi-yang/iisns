<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content', [
        'template' => '{input}{error}{hint}'
    ])->widget('common\widgets\umeditor\UMeditor', [
        'clientOptions' => [
            'initialFrameHeight' => 100,
            'toolbar' => [
                'source | undo redo | bold |',
                'link unlink | emotion image video |',
                'justifyleft justifycenter justifyright justifyjustify |',
                'insertorderedlist insertunorderedlist |' ,
                'horizontal preview fullscreen',
            ],
        ]
    ])->label(false) ?>

    <?= $form->field($model, 'tags')->textarea(['rows' => 2]) ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
