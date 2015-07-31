<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */

$this->title = Yii::t('forum', 'Board');
?>
<div class="board-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="board-all">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'name',
                'parent_id',
                'forum_id',
                'description:ntext',
                'user_id',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
