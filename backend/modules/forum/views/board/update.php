<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\forum\models\Board */

$this->params['forum'] = $model->forum;
?>
<div class="col-md-6">
<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 32]) ?>

    <?= ($model->parent_id !== 0) ? '' : $form->field($model, 'columns', ['options'=>['id' => 'sub-column']])->radioList([
            1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four'],
            ['unselect' => 1]) ?>

    <?= ($model->parent_id === 0) ? '' : $form->field($model, 'description')->textInput(['maxlength' => 40]) ; ?>

    <div class="form-group">
          <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>
</div>
