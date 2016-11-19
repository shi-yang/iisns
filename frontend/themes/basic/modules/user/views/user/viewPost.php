<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/* @var $this yii\web\View */
/* @var $model app\modules\home\models\Post */

$this->title = $model->title . '_' . $model->user['username'];
$this->params['user'] = $model->user;
$this->params['profile'] = $model->userProfile;
$this->params['userData'] = $model->userData;
?>
<div class="post-view">
    <h1 class="post-title"><?= Html::encode($model->title) ?></h1>
    <div class="post-meta"><i class="glyphicon glyphicon-time icon-muted"></i> <?= Yii::$app->formatter->asRelativeTime($model->created_at) ?></div>
    <div class="post-content">
       <?= HtmlPurifier::process($model->content) ?>
    </div>
       <?php $post_tags = $model->tags ? explode(',',$model->tags):array(); $tags_len = count($post_tags);?>
    <?php if($tags_len > 0):?>
        <span class="tags">
            <?php $i = 1; foreach((array)$post_tags as $ptag):?>
            <span class="label label-default"><i class="glyphicon glyphicon-tag"></i> <?= Html::encode($ptag) ?></span>
            <?php if($i<$tags_len):?>&nbsp;&nbsp;<?php endif;?>
            <?php $i++;?>
            <?php endforeach;?>
        </span>
    <?php endif;?>
</div>
<?= app\widgets\comment\Comment::widget([
    'model' => $model,
]) ?>
