<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['title'] = Yii::t('app', 'Explore');
?>
<div class="row">
    <div class="col-md-8">
        <?php if (!Yii::$app->user->isGuest): ?>
            <p>
                <?= Html::a(Yii::t('app', 'Create Forum'), ['/forum/forum/create'], ['class' => 'btn btn-success']) ?>
            </p>
        <?php endif ?>
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
    </div>
</div>
