<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\blog\models\Album */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="album-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 128]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 128]) ?>

    <div class="form-group field-album-privilege_type">
        <label class="control-label" for="album-privilege_type"><?= Yii::t('app', 'Privilege Setting') ?></label>
        <input type="hidden" name="Album[privilege_type]" value="0">
        <div id="album-privilege_type">
            <label><input type="radio" name="Album[privilege_type]" value="0" onclick="$('#filed_password').hide();$('#filed_question').hide();" checked> <?= Yii::t('app', 'Public') ?></label>
            <label><input type="radio" name="Album[privilege_type]" value="1" onclick="$('#filed_password').show();$('#filed_question').hide();"> <?= Yii::t('app', 'With password') ?></label>
            <label><input type="radio" name="Album[privilege_type]" value="2" onclick="$('#filed_password').hide();$('#filed_question').show();"> <?= Yii::t('app', 'With Q&A') ?></label>
            <label><input type="radio" name="Album[privilege_type]" value="3" onclick="$('#filed_password').hide();$('#filed_question').hide();"> <?= Yii::t('app', 'Private') ?></label>
        </div>
    </div>

    <div id="filed_password" style="display: none;">
        <?= $form->field($model, 'privilege_password')->textInput() ?>
    </div>

    <div id="filed_question" style="display: none;">
        <?= $form->field($model, 'privilege_question')->textInput()->hint(Yii::t('app', 'eg: My name?')) ?>

        <?= $form->field($model, 'privilege_answer')->textInput()->hint(Yii::t('app', 'eg: Jack')) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
