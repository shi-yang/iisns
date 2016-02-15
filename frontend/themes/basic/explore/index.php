<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['title'] = Yii::t('app', 'Explore');
?>
<div class="row">
    <div class="col-md-8">
        <?php if (!empty($forums['result'])): ?>
            <div class="post-all">
                <?= $this->render('forums', [
                    'forums' => $forums['result'],
                    'pages' => $forums['pages']
                ]) ?>
            </div>
        <?php else: ?>
            <div class="jumbotron">
                <p><?= Yii::t('app', 'Nothing~') ?></p>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-md-4">
        <?= \app\widgets\login\Login::widget([
            'title' => Yii::t('app', 'Log in'),
            'visible' => Yii::$app->user->isGuest,
        ]); ?>
        <?php if (!Yii::$app->user->isGuest): ?>
        <div class="panel panel-default">
          <div class="panel-heading"><?= Yii::t('app', 'My forums') ?></div>
          <div class="panel-body" style="padding:0">
            <div class="list-group">
                <?php foreach ($myForums as $forum): ?>
                    <a class="list-group-item" href="<?= Url::toRoute(['/forum/forum/view', 'id' => $forum['forum_url']]) ?>" data-pjax="0">
                        <?= Html::encode($forum['forum_name']); ?>
                        <?php if (!$forum['status']): ?>
                            <span class="badge"><?= Yii::t('app', 'Pending') ?></span>
                        <?php endif ?>
                    </a>
                <?php endforeach; ?>
                <?= Html::a(Yii::t('app', 'Create Forum'), ['/forum/forum/create'], ['class' => 'list-group-item']) ?>
            </div>
          </div>
        </div>
        <?php endif; ?>
    </div>
</div>
