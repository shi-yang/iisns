<?php

use yii\helpers\Html;
use yii\helpers\Url;
use shiyang\infinitescroll\InfiniteScrollPager;

/* @var $this yii\web\View */
/* @var $model app\modules\forum\models\Forum */

$this->title = $model->forum_name;
$this->registerMetaTag(['name' => 'keywords', 'content' => $model->forum_name]);
$this->registerMetaTag(['name' => 'description', 'content' => $model->forum_desc]);
$this->params['forum'] = $model->toArray;
?>

<div class="col-xs-12 col-sm-8 col-md-8">
  <?php if ($model->user_id === Yii::$app->user->id) :?>
    <?= $this->render('/broadcast/_form', ['newBroadcast' => $newBroadcast]) ?>
  <?php endif; ?>
  <div class="widget-container">
    <div class="thread-list">
      <?php if ($model->broadcastCount >= 1): ?>
          <?php foreach ($model->broadcasts['result'] as $broadcast):?>
              <div class="thread-item" id="div<?php echo $broadcast['id']; ?>">
                <div class="media">
                  <div class="media-body">
                    <h4 class="media-heading">
                      <div class="pull-right">
                        <?php if($broadcast['thread_id']) echo Html::a('<span class="glyphicon glyphicon-file"></span>'.Yii::t('app','Original text'), ['/forum/broadcast/view', 'id' => $broadcast['thread_id']], array('style'=>'font-size: 14px;')); ?>
                        <?php if ($model->user_id == Yii::$app->user->id) :?>
                        <a href="<?= Url::toRoute(['/forum/broadcast/delete', 'id' => $broadcast['id']]) ?>"  data-confirm="<?= Yii::t('app', 'Are you sure to delete it?') ?>" data-method="broadcast">
                          <span class="glyphicon glyphicon-remove-circle"></span>
                        </a>
                        <?php endif; ?>
                      </div>
                    </h4>
                    <a <?php if ($broadcast['thread_id']) echo 'href="/p/'.$broadcast['thread_id'].'"';?>><h3 class="media-title"><?= Html::encode($broadcast['title']) ?></h3></a>
                    <span class="thread-time">
                      <?php if ($broadcast['thread_id']): ?>
                        <span class="glyphicon glyphicon-list"></span> <?php //echo Html::encode(Broadcast::getBlockName($broadcast['thread_id'])); ?> | 
                      <?php endif; ?>
                      <span class="glyphicon glyphicon-time"></span> <?= \app\components\Tools::formatTime($broadcast['created_at']) ?>
                    </span>
                    <div class="media-content">
                        <?php echo $broadcast['content']; ?>
                    </div>
                    <div class="thread-time"></div>
                  </div>
                </div>
              </div>
          <?php endforeach; ?>
        <?= InfiniteScrollPager::widget([
            'pagination' => $model->broadcasts['pages'],
            'widgetId' => '.thread-list',
        ]);?>
        <?php else: ?>
            <div class="widget-container">
                <div style="padding:50px">
                    <h1><?= Yii::t('app', 'No data to display.') ?></h1>
                </div>
            </div>
        <?php endif ?>
    </div>
  </div>
</div>
<div class="col-xs-12 col-sm-4 col-md-4">
  <?= \shiyang\login\Login::widget(['visible' => Yii::$app->user->isGuest]); ?>
  <div class="panel panel-default">
    <div class="panel-heading">About</div>
    <div class="panel-body">
      <?= Html::encode($model->forum_desc) ?>
    </div>
  </div>
</div>