<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\components\Tools;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use shiyang\infinitescroll\InfiniteScrollPager;

/* @var $this yii\web\View */

$this->title=Yii::$app->user->identity->username.' - '.Yii::t('app', 'Home');
?>

<div class="item widget-container share-widget fluid-height clearfix">

    <div class="widget-content padded">
        <?php $form = ActiveForm::begin([
            'enableClientValidation' => false,
            'options' => ['id' => 'create-feed']
        ]); ?>
        <?= $form->field($newFeed, 'content', ['inputOptions' => ['placeholder' => Yii::t('app', 'Record people around, things around.')]])->textarea(['rows' => 3])->label(false) ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php if (!empty($feeds)): ?>
    <div id="content">
        <?php foreach($feeds as $feed): ?>
            <div class="item widget-container fluid-height social-entry" id="<?= $feed['id'] ?>">
                <div class="widget-content padded">
                    <div class="profile-info clearfix">
                        <a class="pull-left" href="<?= Url::toRoute(['/user/view', 'id'=>$feed['username']]) ?>" rel="author">
                            <img width="50" height="50" class="social-avatar" src="<?= Yii::getAlias('@avatar') . $feed['avatar'] ?>" alt="@<?= $feed['username'] ?>"/>
                        </a>
                        <div class="profile-details">
                            <a class="user-name" href="<?= Url::toRoute(['/user/view', 'id'=>$feed['username']]) ?>" rel="author">
                                <?= Html::encode($feed['username']) ?>
                            </a>
                            <p>
                                <em><?= Tools::formatTime($feed['created_at']) ?></em>
                            </p>
                        </div>
                    </div>
                    <p class="content">
                        <?php
                            if (!empty($feed['content'])) {
                                echo Html::encode($feed['content']);
                            } else {
                                echo strtr($feed['template'], unserialize($feed['feed_data']));
                            }
                        ?>
                    </p>
                </div>
                <div class="widget-footer">
                    <div class="footer-detail">
                        <?php if(Yii::$app->user->id == $feed['user_id']): ?>
                            &nbsp;
                            <a href="<?= Url::toRoute(['/home/feed/delete', 'id' => $feed['id']]) ?>" data-clicklog="delete" onclick="return false;" title="<?= Yii::t('app', 'Are you sure to delete it?') ?>">
                                <span class="glyphicon glyphicon-trash"></span> <?= Yii::t('app', 'Delete') ?>
                            </a>
                            &nbsp;
                            <span class="item-line"></span>
                        <?php endif ?>
                        <a href="javascript:;" onclick="setRepostFormAction(<?= $feed['id'] ?>)" data-toggle="modal" data-target="#repost-modal">
                            <span class="glyphicon glyphicon-share-alt"></span> <?= Yii::t('app', 'Repost') ?>
                        </a>
                    </div>
                    <div class="comment">
                        <div class="comment-box">
                            <div class="comment-input" data-clicklog="comment" placeholder="<?= Yii::t('app', 'Comment') ?>"><a href="javascript:void(0);"><?= Yii::t('app', 'Comment') ?></a></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?= InfiniteScrollPager::widget([
            'pagination' => $pages,
            'widgetId' => '#content',
        ]);?>
    </div>
<?php else: ?>
    <div class="no-data-found">
        <i class="glyphicon glyphicon-folder-open"></i>
        <?= Yii::t('app', 'No feed to display. Go to ') ?><?= Html::a(Yii::t('app', 'Explore') . '?', ['/explore/index']) ?>
    </div>
<?php endif; ?>
<?php
Modal::begin([
    'header' => '<h4>' . Yii::t('app', 'Repost') . '</h4>',
    'options' => ['id' => 'repost-modal']
]);
$newFeed->setScenario('repost');
?>
    <?php $form = ActiveForm::begin([
        'options' => ['id' => 'repost-feed'],
        'action' => ['/home/feed/create?id=']
    ]); ?>
    <?= $form->field($newFeed, 'content')->textarea(['rows' => 3, 'id' => 'repost-feed-content'])->label(false) ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Repost'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
<?php Modal::end() ?>

<script type="text/javascript">
    function setRepostFormAction (id) {
        var action = document.getElementById("repost-feed").action;
        document.getElementById("repost-feed").action = action + id;
    }
</script>
