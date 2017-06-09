<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\HtmlPurifier;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $model app\widgets\comment\models\Comment */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs('
    $(".btn-comment").click(function(){
        $(".comment-form").removeClass("hidden");
        if($(this).parent().attr("class")=="media-action") {
            $(".comment-form").appendTo($(this).parent());
            $(".comment-form").find("textarea").val("");
        } else {
            $(".comment-form").appendTo($(this).parents("li").find(".media-action"));
            $(".comment-form").find("textarea").val("@"+$(this).parents(".media-heading").find("a").html()+" ");
        }
        $(".comment-form").find(".parent_id").val($(this).parents("li").attr("data-key"));
        return false;
    });
');
$this->registerCss('
    .comment-all {
        padding: 20px;
        background-color: #fff;
    }
    .comment-all header {
        margin-bottom: 21px;
    }
    .comment-all header span {
        border-bottom:1px solid #ccc; line-height:22px;
        font-size: 1.6em
    }
');
?>

<div class="comment-all">
    <header><span><?= Yii::t('app', 'Comment') ?></span></header>
    <ul class="media-list">
        <?php foreach ($commentList as $comment): ?>
        <li class="media" data-key="<?= $comment['id'] ?>">
            <div class="media-left">
                <a href="#">
                    <img class="img-circle" src="<?= Yii::getAlias('@avatar') . $comment['avatar'] ?>" style="width: 64px;height: 64px;">
                </a>
            </div>
            <div class="media-body">
                <div class="media-heading">
                    <?= Html::a(Html::encode($comment['username']), ['/user/view', 'id' => $comment['username']]) ?>
                </div>
                <div class="media-content">
                    <?= HtmlPurifier::process($comment['content']) ?>
                </div>
                <?php
                    $childComments =  (new yii\db\Query)->select('c.id, c.content, c.parent_id, u.username, u.avatar')
                        ->from('{{%comment}} as c')
                        ->join('LEFT JOIN','{{%user}} as u', 'u.id=c.user_id')
                        ->where('parent_id = :parentId', [':parentId' => $comment['id']])
                        ->all();
                ?>
                <?php foreach ($childComments as $childComment): ?>
                    <?php
                        if ($childComment['parent_id'] != $comment['id']) {
                            continue;
                        }
                    ?>
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="img-circle" src="<?= Yii::getAlias('@avatar') . $childComment['avatar'] ?>" style="width: 32px;height: 32px;">
                            </a>
                        </div>
                        <div class="media-body">
                            <div class="media-heading">
                                <?= Html::a(Html::encode($childComment['username']), ['/user/view', 'id' => $childComment['username']]) ?>
                                <span class="pull-right"><a class="btn-comment" href="javascript:;"><?= Yii::t('app', 'Reply') ?></a></span>
                            </div>
                            <?= Html::encode($childComment['content']) ?>
                        </div>
                    </div>
                <?php endforeach ?>
                <div class="media-action">
                    <a class="btn-comment" href="javascript:;"><?= Yii::t('app', 'Reply') ?></a>
                </div>
            </div>
        </li>
        <?php endforeach ?>
        <?= LinkPager::widget([
            'pagination' => $pages
        ]) ?>
    </ul>
    <div class="new-comment-form">
        <?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>
        <?= $form->field($newComment, 'content')->widget('common\widgets\umeditor\UMeditor', [
            'clientOptions' => [
                'initialFrameHeight' => 100,
                'toolbar' => ['emotion image video'],
            ]
        ])->label(false) ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Reply'), ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<div class="comment-form hidden">
    <?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>
    <?= $form->field($newComment, 'parent_id')->hiddenInput(['class' => 'parent_id'])->label(false) ?>
    <?= $form->field($newComment, 'content')->textarea(['rows' => 2])->label(false) ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Reply'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
