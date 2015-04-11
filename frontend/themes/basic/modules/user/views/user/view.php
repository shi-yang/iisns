<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\LinkPager;
use app\modules\user\models\User;
use app\components\Tools;

/* @var $this yii\web\View */
/* @var $model common\models\User */
$this->title = $model->username;
$this->params['user'] = ArrayHelper::toArray($model);
$this->params['profile'] = ArrayHelper::toArray($model->profile);

?>
<?php if (!empty($model->posts['posts'])): ?>
<div class="home-post">
    <ul class="clearfix">
        <?php foreach ($model->posts['posts'] as $post): ?>
            <li class="post-item">
                <h2 class="post-title"><?= Html::a(Html::encode($post->title), ['/home/post/view', 'id' => $post->id]) ?></h2>
                <div class="post-content">
                    <?= Tools::htmlSubString($post->content, 300, $post->url) ?>
                </div>
                <div class="clearfix"></div>
                <div class="post-info">
                    <i class="glyphicon glyphicon-time icon-muted"></i> <?= Tools::formatTime($post->create_time) ?>
                </div>
          </li>
        <?php endforeach; ?>
        <?= LinkPager::widget(['pagination' => $model->posts['pages']]) ?>
    </ul>
</div>
<?php else: ?>
    <div class="no-data-found">
        <i class="glyphicon glyphicon-folder-open"></i>
        No post to display.
    </div>
<?php endif; ?>
