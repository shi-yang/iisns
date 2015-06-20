<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\HtmlPurifier;
use app\components\Tools;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Messages');
$this->params['breadcrumbs'][] = $this->title;
$this->params['count'] = $count;
?>
<ul class="messages-list">
    <?php foreach ($messages as $message ): ?>
        <li <?= ($message['read_indicator'] == false) ? 'class="unread"' : '' ;?>>
            <a href="<?= \yii\helpers\Url::toRoute(['/user/message/view', 'id' => $message['id']]) ?>">
                <div class="header">
                    <span class="action"><i class="fa fa-square-o"></i></span>
                    <span class="from"><i class="glyphicon glyphicon-user"></i> <?= Html::encode(\app\modules\user\models\User::getInfo($message['sendfrom'])['username']) ?></span>
                    <span class="date"><span class="glyphicon glyphicon-time"></span> <?= Tools::formatTime($message['created_at']) ?></span>
                </div>
                <div class="title">
                    <span class="action"><i class="fa fa-star-o"></i><i class="fa fa-star bg"></i></span>
                    <?= Html::encode($message['subject']) ?>
                </div>
            </a>
        </li>
    <?php endforeach ?>
</ul>