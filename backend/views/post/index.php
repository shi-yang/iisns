<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Post */

$this->title = Yii::$app->setting->get('siteTitle');
?>
<div class="post-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a(Yii::t('app', 'Create Post'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php $form = ActiveForm::begin(['id'=>'all']);?>
    <div class="post-all">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'class' => 'yii\grid\CheckboxColumn',
                ],
                'id',
                [
                    'attribute' => 'explore_status',
                    'value' => function ($model) {
                            return $model->status;
                    },
                    'headerOptions' => ['width' => '7%']
                ],
                'title:ntext',
                [
                    'attribute' => 'content',
                    'value' => function ($model) {
                        return mb_substr($model->content, 0, 200, 'utf-8');
                    }
                ],
                'tags:ntext',
                'user_id',
                'created_at:time',
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
    <input class="btn btn-success"  type="submit"  name="review" value="APPROVED">
    <input class="btn btn-default"  type="submit"  name="soldout" value="PENDING">
    <?php ActiveForm::end();?>
</div>