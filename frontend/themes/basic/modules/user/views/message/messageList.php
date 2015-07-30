<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Messages');
$this->params['breadcrumbs'][] = $this->title;
$this->params['count'] = $count;
?>
<div class="panel-heading">
    <div class="input-group">
        <input type="text" class="form-control input-sm" placeholder="Search here...">
            <span class="input-group-btn">
            <button class="btn btn-default btn-sm" type="button"><i class="glyphicon glyphicon-search"></i></button>
        </span>
    </div><!-- /input-group -->
</div>
<div class="panel-body">
    <label class="label-checkbox inline">
        <input type="checkbox" id="chk-all">
         <span class="custom-checkbox"></span>
    </label>
    <a class="btn btn-sm btn-default"><i class="fa fa-trash-o"></i> Delete</a>

    <div class="pull-right">
        <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-refresh"></i></a>          
        <div class="btn-group" id="inboxFilter">
            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                All
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-right">
                <li><a href="#">Read</a></li>
                <li><a href="#">Unread</a></li>
                <li><a href="#">Starred</a></li>
                <li><a href="#">Unstarred</a></li>
            </ul>
        </div><!-- /btn-group -->
    </div>
</div>
<ul class="list-group">
    <?php foreach ($messages as $message): ?>
    <li class="list-group-item clearfix inbox-item" onclick="window.location.href='<?= Url::toRoute(['/user/message/view', 'id' => $message['id']]) ?>';return false">
        <span class="from"><?= Html::encode($message['username']) ?></span>
        <span class="detail" <?php if ($type == 'inbox' && $message['read_indicator'] == 0) echo 'style="font-weight:bold"';?>>
            <?= Html::encode($message['subject']) ?>
        </span>
        <span class="inline-block pull-right">
            <span class="time"><?= Yii::$app->formatter->asRelativeTime($message['created_at']) ?></span>       
        </span>
    </li>
    <?php endforeach ?>
</ul>
<?= LinkPager::widget([
    'pagination' => $pages,
]);?>
