<?php 
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use yii\bootstrap\Modal;
?>
<?php if ($model->getThreadCount($model->id) > 0): ?>
    <?php foreach($threads as $thread): ?>
        <div class="thread-container" id="div<?= $thread['id']; ?>">
            <div class="thread-feed">
                <div class="user-avatar hidden-xs">
                    <a class="thumbnail" href="<?= Url::toRoute(['/user/view', 'id' => $thread['username']])?>">
                        <img class="u_image img-circle" src="<?= Yii::getAlias('@avatar') . $thread['avatar'] ?>" alt="User avatar">
                    </a>
                </div>
                <div class="thread-detail" style="padding-bottom:5px">
                    <div class="thread-meta">
                        <h4 class="media-heading">
                            <a href="<?= Url::toRoute(['/forum/thread/view', 'id' => $thread['id']]) ?>"><span class="media-title" <?php //if($thread->is_broadcast) echo 'style="color:#ff6f3d"'; ?>><?= Html::encode($thread['title']); ?></span></a>
                        </h4>
                        <?= Html::a(Html::encode($thread['username']), ['/user/view', 'id'=>$thread['username']], ['class'=>'thread-nickname']); ?>
                        <span class="thread-time">| <?= \app\components\Tools::formatTime($thread['create_time']) ?></span>
                    </div>
                    <div class="thread-main">
                        <?= HtmlPurifier::process($thread['content']) ?>
                    </div>
                    <div class="pull-right thread-right">
                        <?= Html::a('<span class="glyphicon glyphicon-comment"></span> '.Yii::t('app', 'Reply'), ['/forum/thread/view', 'id' => $thread['id']]); ?> 
                        <?php if (Yii::$app->user->id == $thread['user_id'] || Yii::$app->user->id == $model->user_id): ?>
                            <a href="<?= Url::toRoute(['/forum/thread/delete', 'id' => $thread['id']]) ?>"  data-confirm="<?= Yii::t('app', 'Are you sure to delete it?') ?>" data-method="thread">
                              <span class="glyphicon glyphicon-trash"></span> <?= Yii::t('app', 'Delete') ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="jumbotron">
        <h2><?= Yii::t('app', 'No data to display.') ?></h2>
    </div>
<?php endif ?>
