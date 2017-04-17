<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use app\widgets\comment\Comment;

/* @var $this yii\web\View */
/* @var $model app\modules\home\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog'), 'url' => ['/home/post/index'], ['data-pjax' => 0]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel">
    <articel class="post-view">
        <header>
            <h1 class="post-title">
                <?php if ($model->status == 'private'): ?>
                    <i class="glyphicon glyphicon-lock"></i>
                <?php endif ?>
                <?= Html::encode($model->title) ?>
                <small><?= Html::a(Yii::t('app', 'Edit'), ['/home/post/update', 'id' => $model->id]) ?></small>
            </h1>
            <div class="post-meta">
                <i class="glyphicon glyphicon-time icon-muted"></i> <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?>
            </div>
        </header>
        <div class="post-content">
            <?= HtmlPurifier::process($model->content) ?>
            <?php $post_tags = $model->tags ? explode(',',$model->tags):[]; $tags_len = count($post_tags);?>
            <?php if($tags_len > 0):?>
                <p>
                    <?php $i = 1; foreach((array)$post_tags as $ptag):?>
                        <span class="label label-default"><i class="glyphicon glyphicon-tag"></i> <?= Html::encode($ptag) ?></span>
                        <?php if($i<$tags_len):?>&nbsp;&nbsp;<?php endif;?>
                        <?php $i++;?>
                    <?php endforeach;?>
                </p>
            <?php endif ?>
        </div>
    </articel>
</div>

<?= Comment::widget([
    'model' => $model,
]) ?>
