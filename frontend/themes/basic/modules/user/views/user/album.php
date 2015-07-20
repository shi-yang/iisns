<?php
use yii\helpers\Html;
use shiyang\infinitescroll\InfiniteScrollPager;
use app\components\Tools;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model common\models\User */
$this->title = $model->username;
$this->params['user'] = $model;
$this->params['profile'] = $model->profile;
$this->params['userData'] = $model->userData;
?>

<?= ListView::widget([
    'layout' => "{items}\n{pager}",
    'dataProvider' => $dataProvider,
    'itemView' => '_album',
    'options' => [
        'tag' => 'ul',
        'class' => 'album-all'
    ],
    'itemOptions' => [
        'class' => 'album-item col-sm-3 col-xs-6',
        'tag' => 'li'
    ]
]); ?>
