<?php
use yii\helpers\Html;
use yii\helpers\Url;
use shiyang\infinitescroll\InfiniteScrollPager;
?>

<?php if ($model->getThreadCount($model->id) > 0): ?>
    <div class="threads" id="content" style="background-color: #fff;">
        <?php foreach($threads as $thread): ?>
            <article class="thread-item" id="<?= $thread['id'] ?>">
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tbody>
                        <tr>
                            <td width="48" valign="middle" align="center">
                                <a href="<?= Url::toRoute(['/user/view', 'id' => $thread['username']])?>" rel="author">
                                    <img class="media-object img-user-avatar img-circle" src="<?= Yii::getAlias('@avatar') . $thread['avatar'] ?>" alt="User avatar">
                                </a>
                            </td>
                            <td width="10"></td>
                            <td width="auto" valign="middle">
                                <h2><?= Html::a(Html::encode($thread['title']), ['/forum/thread/view', 'id' => $thread['id']]) ?></h2>
                                <small style="color: #aaa">
                                    <strong><?= Html::a(Html::encode($thread['username']), ['/user/view', 'id' => $thread['username']], ['class' => 'thread-nickname', 'rel' => 'author']); ?></strong>
                                        &nbsp;•&nbsp; 
                                    <time title="<?= Yii::t('app', 'Last Reply Time') ?>">
                                        <span class="glyphicon glyphicon-time"></span> <?= Yii::$app->formatter->asRelativeTime($thread['updated_at'])?>
                                    </time>
                                    <?php if ($thread['user_id'] == Yii::$app->user->id || $model['user_id'] == Yii::$app->user->id): ?>
                                        &nbsp;•&nbsp; 
                                        <a href="<?= Url::toRoute(['/forum/thread/delete', 'id' => $thread['id']]) ?>" data-clicklog="delete" onclick="return false;" title="<?= Yii::t('app', 'Are you sure to delete it?') ?>">
                                            <span class="glyphicon glyphicon-trash"></span> <?= Yii::t('app', 'Delete') ?>
                                        </a>
                                    <?php endif; ?>
                                </small>
                            </td>
                            <td width="50" align="right" valign="middle" title="<?= Yii::t('app', 'Reply') ?>">
                                <?= Html::a('<span class="glyphicon glyphicon-comment"></span> ' . $thread['post_count'], ['/forum/thread/view', 'id' => $thread['id']], ['class' => 'badge']); ?> 
                            </td>
                        </tr>
                    </tbody>
                </table>
            </article>
        <?php endforeach; ?>
    </div>
    <?= InfiniteScrollPager::widget([
        'pagination' => $model->threads['pages'],
        'widgetId' => '#content',
    ]);?>
<?php else: ?>
    <div class="jumbotron">
        <h2><?= Yii::t('app', 'No data to display.') ?></h2>
    </div>
<?php endif ?>
