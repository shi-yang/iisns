<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Comment */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="comment-all">
    <ul class="media-list">
        <?php foreach ($commentList as $comment): ?>
        <?php
            if ($comment['parent_id'] != 0) {
                continue;
            }
        ?>
        <li class="media">
            <div class="media-left">
                <a href="#">
                    <img src="<?= Yii::getAlias('@avatar') . 'default/5.jpg' ?>" style="width: 64px;height: 64px;">
                </a>
            </div>
            <div class="media-body">
                <div class="media-heading">
                    shiyang
                </div>
                <div class="media-content">
                    <?= Html::encode($comment['content']) ?>
                </div>
                <?php foreach ($commentList as $childComment): ?>
                    <?php
                        if ($childComment['parent_id'] != $comment['id']) {
                            continue;
                        }
                    ?>
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img src="<?= Yii::getAlias('@avatar') . 'default/5.jpg' ?>" style="width: 64px;height: 64px;">
                            </a>
                        </div>
                        <div class="media-body">
                            <?= Html::encode($childComment['content']) ?>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </li>
        <?php endforeach ?>
    </ul>
</div>

<div class="comment-form">
    <?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>
    <?= $form->field($newComment, 'content')->textarea(['rows' => 2]) ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Reply'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
