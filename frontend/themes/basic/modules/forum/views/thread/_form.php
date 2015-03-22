<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\forum\models\Thread */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="thread-form">
<div class="widget-container">
<?php if (!Yii::$app->user->isGuest) :?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title', [
        'template' => "<div class=\"input-group\"><span class=\"input-group-addon\">". Yii::t('app', 'Title') ."</span>{input}</div>",
        'inputOptions' => ['placeholder' => Yii::t('app', 'Optional')]
        ])->textInput(['maxlength' => 128, 'autocomplete'=>'off'])
    ?>

    <?= $form->field($model, 'content')->widget('kucha\ueditor\UEditor', [
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
                    'autotypeset', 'bold', 'italic', 'underline','blockquote', '|',
                ],
            ],
        ]
    ])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'autocomplete'=>'off']) ?>
    </div>

    <?php ActiveForm::end(); ?>

<?php else: ?>
    <h3>Welcom to <?php echo Html::encode($forumName); ?></h3>
<?php endif; ?>
</div>
</div>