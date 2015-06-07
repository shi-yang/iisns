<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ExploreRecommend */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app','Add Recommendation');
?>

<div class="explore-recommend-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'table_id', ['inputOptions' => ['placeholder' => 'Album Id']])->textInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Add') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
