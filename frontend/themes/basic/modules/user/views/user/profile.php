<?php
use yii\helpers\Html;
use shiyang\infinitescroll\InfiniteScrollPager;
use app\components\Tools;

/* @var $this yii\web\View */
/* @var $model common\models\User */
$this->title = $model->username;
$this->params['user'] = $model;
$this->params['profile'] = $model->profile;
$this->params['userData'] = $model->userData;
?> 

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
