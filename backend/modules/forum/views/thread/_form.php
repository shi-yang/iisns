<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\forum\models\Thread */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="thread-form">
    <?php if (!Yii::$app->user->isGuest) :?>
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'id', [
            'template' => "<div class=\"input-group\"><span class=\"input-group-addon\">". Yii::t('app', 'Id') ."</span>{input}</div>",
        ])->textInput(['maxlength' => 128, 'autocomplete'=>'off'])
        ?>

        <?= $form->field($model, 'board_id', [
            'template' => "<div class=\"input-group\"><span class=\"input-group-addon\">". Yii::t('app', 'Board Id') ."</span>{input}</div>",
        ])->textInput(['maxlength' => 128, 'autocomplete'=>'off'])
        ?>

        <?= $form->field($model, 'title', [
            'template' => "<div class=\"input-group\"><span class=\"input-group-addon\">". Yii::t('app', 'Title') ."</span>{input}</div>",
        ])->textInput(['maxlength' => 128, 'autocomplete'=>'off'])
        ?>

        <?= $form->field($model, 'content')->widget('shiyang\umeditor\UMeditor', [
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

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'autocomplete'=>'off']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    <?php else: ?>
        <h3>Welcom to <?= Html::encode($forumName); ?></h3>
    <?php endif; ?>
</div>
