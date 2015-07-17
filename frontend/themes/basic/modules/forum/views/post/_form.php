<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\forum\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>
<section class="post-area">
    <div class="row">
        <div class="post-user col-sm-2">
            <?php if (Yii::$app->user->isGuest) :?>
                <div class="hidden-xs">
                    <img class="img-circle" src="<?= Yii::getAlias('@avatar') ?>default/guest.png" alt="User avatar">
                </div>
            <?php else: ?>
                <div class="hidden-xs">
                    <img src="<?= Yii::getAlias('@avatar') . Yii::$app->user->identity->avatar ?>" alt="User avatar">
                </div>
            <?php endif; ?>
        </div>
        <div class="post-form col-sm-10">
            <?php if (!Yii::$app->user->isGuest) :?>
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'content')->widget('shiyang\umeditor\UMeditor', [
                    'clientOptions' => [
                        'initialFrameHeight' => 100,
                        'toolbar' => [
                            'link unlink | emotion image video',
                        ],
                    ]
                ])->label(false) ?>
                <div class="form-group">
                    <?= Html::submitButton(Yii::t('app', 'Reply'), ['class' => 'btn btn-success']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            <?php else: ?>
                <h3>Please <?= Html::a('login', ['/site/login']) ?> to leave a comment.</h3>
            <?php endif; ?>
        </div>
    </div>
</section>
