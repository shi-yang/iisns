<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */

$this->title = Yii::$app->setting->get('siteTitle');
?>
<div class="forum-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Create Forum'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="forum-all">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'forum_name',
            'forum_desc:ntext',
            'forum_url:url',
            'user_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
        'options' => [
            'class' => 'table-responsive'
        ]
    ]); ?>
    </div>
</div>
