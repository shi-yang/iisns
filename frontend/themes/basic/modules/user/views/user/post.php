<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
use shiyang\infinitescroll\InfiniteScrollPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Posts');
$this->params['user'] = $model;
$this->params['profile'] = $model->profile;
$this->params['userData'] = $model->userData;
?>
<div class="social-wrapper row">
    <div id="social-container">
        <?php if (!empty($posts)): ?>
            <?php foreach($posts as $post): ?>
                <article class="item widget-container fluid-height social-entry" id="<?= $post['id'] ?>">
                    <header class="widget-content">
                        <h3><?= Html::a(Html::encode($post['title']), ['/user/view/view-post', 'id' => $post['id']]) ?></h3>
                    </header>
                        <footer class="widget-footer">
                            <div class="footer-detail">
                                <?php if (Yii::$app->user->id === $model->id): ?>
                                &nbsp;
                                <a href="<?= Url::toRoute(['/home/post/delete', 'id' => $post['id']]) ?>" data-clicklog="delete" onclick="return false;" title="<?= Yii::t('app', 'Are you sure to delete it?') ?>">
                                    <span class="glyphicon glyphicon-trash"></span> <?= Yii::t('app', 'Delete') ?>
                                </a>
                                &nbsp;
                                <span class="item-line"></span>
                                <a href="<?= Url::toRoute(['/home/post/update', 'id' => $post['id']]) ?>">
                                    <span class="glyphicon glyphicon-edit"></span> <?= Yii::t('app', 'Update') ?>
                                </a>
                                &nbsp;
                                <span class="item-line"></span>
                                <?php endif ?>
                                <span class="glyphicon glyphicon-time"></span> <?= Yii::$app->formatter->asRelativeTime($post['created_at']) ?>
                            </div>
                        </footer>
                </article>
            <?php endforeach; ?>
            <?= InfiniteScrollPager::widget([
                   'pagination' => $pages,
                   'widgetId' => '#content',
            ]);?>
        <?php else: ?>
            <div class="no-data-found">
                <i class="glyphicon glyphicon-folder-open"></i>
                <?= Yii::t('app', 'No data to display.') ?>
            </div>
        <?php endif; ?>
    </div>
</div>
