<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\user\models\User;
use app\components\Tools;
use yii\helpers\HtmlPurifier;

/* @var $this yii\web\View */

$this->title=Yii::$app->user->identity->username.' - '.Yii::t('app', 'Home');
?>

<?php if (!empty($posts)): ?>
    <?php foreach($posts as $post): ?>
        <div class="item widget-container fluid-height social-entry">
            <div class="widget-content padded">
                <div class="profile-info clearfix">
                    <img width="50" height="50" class="social-avatar pull-left" src="<?= Yii::getAlias('@avatar') . User::getInfo($post['user_id'])['avatar'] ?>" />
                    <div class="profile-details">
                        <a class="user-name" href="<?= Url::toRoute(['/user/view', 'id'=>User::getInfo($post['user_id'])['username']]) ?>">
                            <?= Html::encode(User::getInfo($post['user_id'])['username']) ?>
                        </a>
                        <p>
                            <em><?= Tools::formatTime($post['create_time']) ?></em>
                        </p>
                    </div>
                </div>
                <p class="content">
                    <?php if (!empty($post['title'])): ?>
                        <h3><?= Html::a(Html::encode($post['title']), ['/blog/post/view', 'id' => $post['id']]) ?></h3>
                    <?php endif ?>
                    <?= HtmlPurifier::process($post['content']) ?>
                </p>
                <a href="<?= Url::toRoute(['/blog/post/delete', 'id' => $post['id']]) ?>" data-confirm="<?= Yii::t('app', 'Are you sure to delete it?') ?>" data-method="post">
                    <span class="glyphicon glyphicon-trash"></span> <?= Yii::t('app', 'Delete') ?>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="no-data-found">
        <i class="glyphicon glyphicon-folder-open"></i>
        No post to display.
    </div>
<?php endif; ?>