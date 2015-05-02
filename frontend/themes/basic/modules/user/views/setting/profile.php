<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $profile app\modules\user\models\Profile */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-md-7">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($profile, 'gender')->radioList([Yii::t('app', 'Male'), Yii::t('app', 'Female')]) ?>

        <?= $form->field($profile, 'birthdate')->textInput() ?>

        <?= $form->field($profile, 'signature')->textarea() ?>

        <?= $form->field($profile, 'address')->textarea() ?>

        <?= $form->field($profile, 'description')->textarea() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label class="control-label col-md-12"><?= Yii::t('app', 'User Avatar') ?></label>
            <div class="col-md-6">
              <div class="fileupload fileupload-new">
                <div class="fileupload-new img-preview" style="width: 150px; height: 150px;">
                  <img src="<?= Yii::getAlias('@avatar').$model->avatar ?>"  style="width: 150px; height: 150px;">
                </div>
              </div>
            </div>
            <div class="col-md-6">
                <div class="fileupload fileupload-new">
                    <div class="img-preview"></div>
                </div>
            </div>
          </div>
          <div class="clearfix"></div>
        <?= \shiyang\webuploader\Cropper::widget() ?>
    </div>
</div>

