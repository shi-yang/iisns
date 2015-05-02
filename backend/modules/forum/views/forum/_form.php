<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\forum\models\Forum */
/* @var $form yii\widgets\ActiveForm */
$domain = Yii::$app->request->hostInfo;
?>

<div class="forum-form">

    <?php $form = ActiveForm::begin();?>

    <?= $form->field($model, 'forum_name')->textInput(['maxlength' => 32, 'autocomplete'=>'off']) ?>

    <?= $form->field($model, 'forum_desc')->textarea(['rows' => 6, 'autocomplete'=>'off', 'maxlength' => 128]) ?>

    <?= $form->field($model, 'forum_url', [
        'template' => "<div class=\"input-group\"><span class=\"input-group-addon\">{$domain}/forum/</span>{input}</div>{error}",
    ])->textInput(['maxlength' => 32, 'autocomplete'=>'off']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>