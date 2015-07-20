<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ExploreRecommend */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="explore-recommend-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 128]) ?>

    <?= $form->field($model, 'summary')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'content', [
        'template' => '{input}{error}{hint}'
    ])->widget('shiyang\umeditor\UMeditor', [
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

    <?= $form->field($model, 'origin')->textInput() ?>
    
    <?= $form->field($model, 'username')->textInput() ?>

    <?= $form->field($model, 'table_id')->textInput()->hint('提示：如果填了上面的内容，Table Id 及 Table Name 都不用填。Table ID 是指那个帖子的ID，而Table Name是指帖子所在表。') ?>

    <?= $form->field($model, 'table_name')->inline()->radioList(['home_post' => 'Home Post', 'forum_thread' => 'Forum Thread']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
