<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use app\modules\home\models\Album;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['title'] = Yii::t('app', 'Explore');
?>
<div class="row">
    <div class="col-md-8">
        <div class="post-all">
            <?= $this->render('forums', [
                'forums' => $forums['result'],
                'pages' => $forums['pages']
            ]) ?>
        </div>
    </div>
    <div class="col-md-4">
        <?= \shiyang\login\Login::widget([
            'title' => Yii::t('app', 'Log in'),
            'visible' => Yii::$app->user->isGuest,
        ]); ?>
<!--         <p class="bg-success" style="padding:15px;">
            <b><?= Yii::t('app', 'Recommendation') ?></b>
            <?= Html::a(Yii::t('app', 'More'), ['/explore/forums'], ['class' => 'pull-right']) ?>
        </p>
        <?php //foreach ($forums['result'] as $forum): ?>
            <div class="media recommend-forum"
                 onclick="window.location.href='<?php //Url::toRoute(['/forum/forum/view', 'id' => $forum['forum_url']]) ?>';return false">
                <div class="media-left">
                    <img class="media-object" style="height: 64px;width: 64px" src="<?php //Yii::getAlias('@forum_icon') . $forum['forum_icon'] ?>" alt="<?php //Html::encode($forum['forum_name']) ?>">
                </div>
                <div class="media-body">
                    <h4 class="media-heading"><?php //Html::encode($forum['forum_name']) ?></h4>
                    <?php //Html::encode($forum['forum_desc']) ?>
                </div>
            </div>
        <?php //endforeach ?> -->
    </div>
</div>
