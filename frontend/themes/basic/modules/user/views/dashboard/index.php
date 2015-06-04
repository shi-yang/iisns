<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\user\models\User;
use app\components\Tools;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;
use shiyang\infinitescroll\InfiniteScrollPager;

/* @var $this yii\web\View */

$this->title=Yii::$app->user->identity->username.' - '.Yii::t('app', 'Home');
?>

<div class="feed-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($newFeed, 'content')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php if (!empty($feeds)): ?>
    <div id="content">
        <?php foreach($feeds as $feed): ?>
            <div class="item widget-container fluid-height social-entry">
                <div class="widget-content padded">
                    <div class="profile-info clearfix">
                        <img width="50" height="50" class="social-avatar pull-left" src="<?= Yii::getAlias('@avatar') . $feed['avatar'] ?>" />
                        <div class="profile-details">
                            <a class="user-name" href="<?= Url::toRoute(['/user/view', 'id'=>$feed['username']]) ?>">
                                <?= Html::encode($feed['username']) ?>
                            </a>
                            <p>
                                <em><?= Tools::formatTime($feed['created_at']) ?></em>
                            </p>
                        </div>
                    </div>
                    <p class="content">
                        <?= Html::encode($feed['content']) ?>
                    </p>
                    <?php if(Yii::$app->user->id == $feed['user_id']): ?>
                        <a href="<?= Url::toRoute(['/home/feed/delete', 'id' => $feed['id']]) ?>" data-confirm="<?= Yii::t('app', 'Are you sure to delete it?') ?>" data-method="feed">
                            <span class="glyphicon glyphicon-trash"></span> <?= Yii::t('app', 'Delete') ?>
                        </a>
                    <?php endif ?>
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
        No feed to display.
    </div>
<?php endif; ?>
