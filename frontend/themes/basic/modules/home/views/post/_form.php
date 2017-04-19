<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\home\models\Post */
/* @var $form yii\widgets\ActiveForm */
/* @var $editor app\modules\home\controllers\PostController */

$model->status = 'public';
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title', [
      'template' => "<div class=\"input-group\"><span class=\"input-group-addon\">" . Yii::t('app', 'Title') . "</span>{input}</div>",
    ])->textInput(['maxlength' => 128, 'autocomplete'=>'off']) ?>

    <?php if ($editor == 'html') {
        echo $form->field($model, 'content')->widget('common\widgets\umeditor\UMeditor', [
            'clientOptions' => [
                'initialFrameHeight' => 230,
                'toolbar' => [
                    'source | undo redo | bold |',
                    'link unlink | emotion image video |',
                    'justifyleft justifycenter justifyright justifyjustify |',
                    'insertorderedlist insertunorderedlist |' ,
                    'horizontal preview fullscreen',
                ],
                'imageUrl' => Url::to(['umeditor_upload']),
            ]
        ])->label(false);
    } else {
        echo $form->field($model, 'markdown')->widget('common\widgets\editormd\Editormd', [
            'clientOptions' => [
                'placeholder' => '',
                'height' => 640,
                'imageUpload' => true,
                'imageUploadURL' => Url::to(['editormd_upload']),
                'tex' => true,
                'flowChart' => true,
                'sequenceDiagram' => true
            ]
        ])->label(false);
    } ?>

    <?= $form->field($model, 'tags', [
        'template' => "<div class=\"input-group\"><span class=\"input-group-addon\">" . Yii::t('app', 'Tags') . "</span>{input}</div>",
    ])->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'status')->radioList([
        'public' => Yii::t('app', 'Post now'),
        'private' => Yii::t('app', 'Post privately')
    ])?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
