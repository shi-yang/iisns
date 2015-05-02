<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */

$this->title = Yii::$app->setting->get('siteTitle');
$this->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->setting->get('siteKeyword')]);
$this->registerMetaTag(['name' => 'description', 'content' => Yii::$app->setting->get('siteDescription')]);
$this->registerCssFile(Yii::getAlias('@web').'/css/forum/css/forum.css');
?>
<div class="forum-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a(Yii::t('app', 'Create Forum'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif ?>

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
    ]); ?>
    </div>
</div>
