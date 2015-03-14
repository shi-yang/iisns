<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>
<div class="widget-container">
  <div class="thread-form">
    <?php $form = ActiveForm::begin(['layout' => 'horizontal']); ?>
      <div class="col-sm-10">
        <div class="row">
          <div class="col-md-12"><span class="create-thread"><?php echo Yii::t('app', "What's Happening!");?></span></div>
          <div class="col-md-12">
            <?= $form->field($newBroadcast, 'title', [
              'template' => "<div class=\"input-group\"><span class=\"input-group-addon\">Title</span>{input}</div>",
            ])->textInput(['maxlength' => 128, 'autocomplete'=>'off']) ?>
          </div>
          <div class="col-md-12">
            <?= $form->field($newBroadcast, 'content', [
                'template' => '{input}{error}{hint}'
              ])->widget('kucha\ueditor\UEditor', [
                'clientOptions' => [
                    'elementPathEnabled' => false,
                    'initialFrameHeight' => 100,
                    'autosave' => false,
                    'wordCount' => false,
                    'toolbars' => [
                      [
                          'fullscreen', 'preview', 'source', 'undo', 'redo', 'insertcode',
                          'justifyleft', 'justifyright', 'justifycenter', 'justifyjustify'
                      ],
                      [
                          'emotion', 'simpleupload', 'insertimage', 'link', 'insertvideo', 'music', '|',
                          'autotypeset', 'bold', 'italic', 'underline', 'removeformat',
                          'formatmatch', 'blockquote', 'pasteplain', '|',
                      ],
                    ],
                ]
            ]) ?>
            <div class="buttons">
              <?php echo Html::submitButton(Yii::t('app','Create'), array('class'=>'btn btn-success')); ?>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group" style="margin-bottom:0"></div>
    <?php ActiveForm::end(); ?>
  </div>
</div>