<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div class="widget-container">
  <div class="thread-form">
    <?php $form = ActiveForm::begin(); ?>
      <span class="create-thread"><?= Yii::t('app', "What's Happening!");?></span>

      <?= $form->field($model, 'title', [
        'template' => '<div class="input-group"><span class="input-group-addon">' . Yii::t('app', 'Title') . '</span>{input}</div>',
      ])->textInput(['maxlength' => 128, 'autocomplete'=>'off']) ?>

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

      <div class="buttons">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'autocomplete'=>'off']) ?>
      </div>
    <?php ActiveForm::end(); ?>
  </div>
</div>