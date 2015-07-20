<?php

use yii\helpers\Html;
use shiyang\infinitescroll\InfiniteScrollPager;

/* @var $this yii\web\View */
/* @var $model common\models\User */
$this->title = $model->username;
$this->params['user'] = $model;
$this->params['profile'] = $model->profile;
$this->params['userData'] = $model->userData;
?>
  <div class="tab-pane active" id="timeline">
    <div class="activity-list">
      <ul class="clearfix" id="content">
        <?php foreach ($model->feeds['feeds'] as $feed): ?>
            <li class="post-item">
                <div class="post-content">
                    <?php
                        if (!empty($feed->content)) {
                            echo Html::encode($feed->content);
                        } else {
                            echo strtr($feed['template'], unserialize($feed['feed_data']));
                        }
                    ?>
                </div>
                <div class="clearfix"></div>
                <div class="post-info">
                    <i class="glyphicon glyphicon-time icon-muted"></i> <?= Yii::$app->tools->formatTime($feed->created_at) ?>
                </div>
            </li>
        <?php endforeach; ?>
        <?= InfiniteScrollPager::widget([
            'pagination' => $model->posts['pages'],
            'widgetId' => '#content',
        ]) ?>
      </ul>
    </div><!-- activity-list -->
  </div>
</div>
