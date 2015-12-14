<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use backend\models\Post;
/* @var $this yii\web\View */
/* @var $model backend\models\Post */
header('Content-Type: text/html; charset=UTF-8');
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
                            return Post::getExplore_status($model->explore_status
                            );
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
    <input class=""  type="submit"  name="review" value="审核">
    <input class=""  type="submit"  name="soldout" value="下架">
    <?php ActiveForm::end();?>
</div>