<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use shiyang\infinitescroll\InfiniteScrollPager;
use app\components\Tools;

/* @var $this yii\web\View */
/* @var $model common\models\User */
$this->title = $model->username;
$this->params['user'] = ArrayHelper::toArray($model);
$this->params['profile'] = ArrayHelper::toArray($model->profile);
$this->params['userData'] = ArrayHelper::toArray($model->userData);
?>
<div class="tab-content">
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
                    <i class="glyphicon glyphicon-time icon-muted"></i> <?= Tools::formatTime($feed->created_at) ?>
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
  <div class="tab-pane" id="photo">
    <div class="photo-list">
      
    </div><!--photo-list -->
  </div>

  <div class="tab-pane" id="music">
    
    <div class="music-list">

    </div><!-- music-list -->
    
    <button class="btn btn-white btn-block">Show More</button>
    
  </div>
  <div class="tab-pane" id="video">
    <div class="video">
    </div><!-- video -->
  </div>
  <div class="tab-pane" id="profile">
    <div class="profile-list">
      <div class="form-horizontal">
        <div class="form-group">
          <label class="col-sm-2 control-label"><?= Yii::t('app', 'Username') ?></label>
          <div class="col-sm-10">
            <p class="form-control-static"><?= Html::encode($model->username) ?></p>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label"><?= Yii::t('app', 'Email') ?></label>
          <div class="col-sm-10">
            <p class="form-control-static"><?= $model->email ?></p>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label"><?= Yii::t('app', 'Gender') ?></label>
          <div class="col-sm-10">
            <p class="form-control-static"><?= ($model->profile->gender) ? Yii::t('app', 'Female') : Yii::t('app', 'Male') ; ?></p>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label"><?= Yii::t('app', 'Birthdate') ?></label>
          <div class="col-sm-10">
            <p class="form-control-static"><?= $model->profile->birthdate ?></p>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label"><?= Yii::t('app', 'Position') ?></label>
          <div class="col-sm-10">
            <p class="form-control-static"><?= Html::encode($model->profile->address) ?></p>
          </div>
        </div>
      </div>
    </div><!-- profile-list -->
  </div>
</div>
