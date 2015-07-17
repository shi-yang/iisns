<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\forum\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row thread-view" id="post-form">
    <div class="col-sm-2">
        <div class="thread-meta">
            <?php if (Yii::$app->user->isGuest) :?>
                <div class="author hidden-xs">
                    <img src="<?= Yii::getAlias('@avatar') ?>default/guest.png" alt="User avatar">
                </div>
                <p style="margin: 0;font-weight: bold;white-space: normal;word-break: break-all;">
                    
                </p>
            <?php else: ?>
                <div class="author hidden-xs">
                    <img src="<?= Yii::getAlias('@avatar') . Yii::$app->user->identity->avatar ?>" alt="User avatar">
                </div>
                <p style="margin: 0;font-weight: bold;white-space: normal;word-break: break-all;">
                    <?= Html::a(Html::encode(Yii::$app->user->identity->username), ['/user/view', 'id' => Yii::$app->user->identity->username]) ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-sm-10">
        <?php if (!Yii::$app->user->isGuest) :?>
            <?php $form = ActiveForm::begin(); ?>

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

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        <?php else: ?>
            <h3>Please <?= Html::a('login', ['/site/login']) ?> to leave a comment.</h3>
        <?php endif; ?>
    </div>
</div>
