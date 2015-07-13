<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
use shiyang\infinitescroll\InfiniteScrollPager;
use app\components\Tools;

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
                <div class="item widget-container fluid-height social-entry" id="<?= $post['id'] ?>">
                    <div class="widget-content">
                        <h3><?= Html::a(Html::encode($post['title']), ['/home/post/view', 'id' => $post['id']]) ?></h3>
                        <?= HtmlPurifier::process(Tools::htmlSubString($post['content'], 200, Url::toRoute(['/home/post/view', 'id' => $post['id']]))) ?>
                    </div>
                    <?php if (Yii::$app->user->id === $model->id): ?>
                        <div class="widget-footer">
                            <div class="footer-detail">
                                &nbsp;
                                <a href="<?= Url::toRoute(['/home/post/delete', 'id' => $post['id']]) ?>" onclick="return false;" title="<?= Yii::t('app', 'Are you sure to delete it?') ?>" rel="delete">
                                    <span class="glyphicon glyphicon-trash"></span> <?= Yii::t('app', 'Delete') ?>
                                </a>
                                &nbsp;
                                <span class="item-line"></span>
                                <a href="<?= Url::toRoute(['/home/post/update', 'id' => $post['id']]) ?>">
                                    <span class="glyphicon glyphicon-edit"></span> <?= Yii::t('app', 'Update') ?>
                                </a>
                            </div>
                        </div>
                    <?php endif ?>
                </div>
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
