<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\user\models\User;
use shiyang\infinitescroll\InfiniteScrollPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'My Posts');
$this->params['breadcrumbs'][] = $this->title;

$user = Yii::$app->user->identity;
?>
<div class="album-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Post'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

</div>
<div class="social-wrapper row">
    <div id="social-container">
        <div class="col-xs-12 col-sm-8 col-md-8" id="content">
			<?php if (!empty($posts)): ?>
			    <?php foreach($posts as $post): ?>
			        <div class="item widget-container fluid-height social-entry">
			            <div class="widget-content padded">
			                <div class="profile-info clearfix">
			                    <img width="50" height="50" class="social-avatar pull-left" src="<?= Yii::getAlias('@avatar') . $user->avatar ?>" />
			                    <div class="profile-details">
			                        <a class="user-name" href="<?= Url::toRoute(['/user/view', 'id' => $user->username]) ?>">
			                            <?= Html::encode($user->username) ?>
			                        </a>
			                        <p>
			                            <em><?= \app\components\Tools::formatTime($post['create_time']) ?></em>
			                        </p>
			                    </div>
			                </div>
			                <p class="content">
			                    <?php if (!empty($post['title'])): ?>
			                        <h3><?= Html::a(Html::encode($post['title']), ['/home/post/view', 'id' => $post['id']]) ?></h3>
			                    <?php endif ?>
			                    <?= $post['content'] ?>
			                </p>
			                <a href="<?= Url::toRoute(['/home/post/delete', 'id' => $post['id']]) ?>" data-confirm="<?= Yii::t('app', 'Are you sure to delete it?') ?>" data-method="post">
			                    <span class="glyphicon glyphicon-trash"></span> <?= Yii::t('app', 'Delete') ?>
			                </a>
			                &nbsp;&nbsp;<a href="<?= Url::toRoute(['/home/post/update', 'id' => $post['id']]) ?>">
			                    <span class="glyphicon glyphicon-edit"></span> <?= Yii::t('app', 'Update') ?>
			                </a>
			            </div>
			        </div>
			    <?php endforeach; ?>
				<?= InfiniteScrollPager::widget([
			       	'pagination' => $pages,
			       	'widgetId' => '#content',
			    ]);?>
			<?php else: ?>
			    <div class="no-data-found">
			        <i class="glyphicon glyphicon-folder-open"></i>
			        No post to display.
			    </div>
			<?php endif; ?>
        </div>
    </div>
</div>
