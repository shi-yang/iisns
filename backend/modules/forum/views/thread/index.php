<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */

$this->title = Yii::$app->setting->get('siteTitle');
?>
<div class="thread-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Create Thread'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="thread-all">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'id',
                'title:ntext',
                [
                    'attribute' => 'content',
                    'value' => function ($model) {
                        return mb_substr($model->content, 0, 200, 'utf-8');
                    }
                ],
                'user_id',
                'created_at:time',
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
