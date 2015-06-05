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

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'username')->textInput()->hint('提示：用户名和用户ID只需填一个即可') ?>

    <?= $form->field($model, 'table_id')->textInput() ?>

    <?= $form->field($model, 'table_name')->inline()->radioList(['home_post' => 'Home Post', 'forum_thread' => 'Forum Thread']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
