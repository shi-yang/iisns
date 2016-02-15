<?php

use yii\helpers\Html;
use app\modules\forum\models\Board;

/* @var $this yii\web\View */
/* @var $model app\modules\forum\models\Forum */

$this->title = $model->forum_name;
$this->registerMetaTag(['name' => 'keywords', 'content' => $model->forum_name]);
$this->registerMetaTag(['name' => 'description', 'content' => $model->forum_desc]);
$this->params['forum'] = $model->toArray;
?>

<div class="col-xs-12 col-sm-8 col-md-8">
    <?php if ($model->boardCount > 1): ?>
        <?= $this->render('_boards',[
            'forum' => $model,
            'boards' => $model->boards,
        ]); ?>
    <?php elseif ($model->boardCount == 1 && $model->boards[0]->parent_id != Board::AS_CATEGORY): ?>
        <?= $this->render('/board/view', [
                    'model'=>$model->boards[0], 
                    'newThread'=>$newThread,
                ]
            );
        ?>
    <?php else: ?>
        <div class="jumbotron">
            <h2><?= Yii::t('app', 'No board!'); ?></h2>
            <?php if (Yii::$app->user->id == $model->user_id) : ?>
                <?= Html::a(Yii::t('app', 'Add a board'), ['/forum/forum/update', 'id' => $model->forum_url, 'action' => 'board'], ['class' => 'btn btn-success']) ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
<div class="col-xs-12 col-sm-4 col-md-4">
    <?= \app\widgets\login\Login::widget([
        'title' => Yii::t('app', 'Log in'),
        'visible' => Yii::$app->user->isGuest
    ]); ?>
    <div class="panel panel-default">
      <div class="panel-heading">About</div>
      <div class="panel-body">
        <?= Html::encode($model->forum_desc) ?>
      </div>
    </div>
</div>
