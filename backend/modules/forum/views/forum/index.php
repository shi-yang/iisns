<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = Yii::$app->setting->get('siteTitle');
?>
<div class="forum-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Create Forum'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="forum-all">
    <?php $form = ActiveForm::begin(['id' => 'all']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            'id',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return ($model->status === 0) ? 'PENDING' : 'APPROVED' ;
                }
            ],
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
    <input class="btn btn-success"  type="submit"  name="review" value="APPROVED">
    <input class="btn btn-default"  type="submit"  name="soldout" value="PENDING">
    <?php ActiveForm::end() ?>
    </div>
</div>
