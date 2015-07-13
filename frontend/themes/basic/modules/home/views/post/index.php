<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
use shiyang\infinitescroll\InfiniteScrollPager;
use app\components\Tools;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'My Posts');
$this->params['breadcrumbs'][] = $this->title;

$user = Yii::$app->user->identity;
?>
<div class="social-wrapper row">
    <div id="social-container">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-offset-1 col-lg-6" id="content">
            <div class="post-index">
                <h1><?= Html::encode($this->title) ?></h1>
                <p>
                    <?= Html::a(Yii::t('app', 'Create Post'), ['create'], ['class' => 'btn btn-success']) ?>
                </p>
            </div>
            <?php if (!empty($posts)): ?>
                <?php foreach($posts as $post): ?>
                    <div class="item widget-container fluid-height social-entry" id="<?= $post['id'] ?>">
                        <div class="widget-content padded">
                            <p class="content">
                                <h3><?= Html::a(Html::encode($post['title']), ['/home/post/view', 'id' => $post['id']]) ?></h3>
                                <?= HtmlPurifier::process(Tools::htmlSubString($post['content'], 300, Url::toRoute(['/home/post/view', 'id' => $post['id']]))) ?>
                            </p>
                        </div>
                        <div class="widget-footer">
                            <div class="footer-detail">
                                &nbsp;
                                <a href="<?= Url::toRoute(['/home/post/delete', 'id' => $post['id']]) ?>" data-clicklog="delete" onclick="return false;" title="<?= Yii::t('app', 'Are you sure to delete it?') ?>">
                                    <span class="glyphicon glyphicon-trash"></span> <?= Yii::t('app', 'Delete') ?>
                                </a>
                                &nbsp;
                                <span class="item-line"></span>
                                <a href="<?= Url::toRoute(['/home/post/update', 'id' => $post['id']]) ?>">
                                    <span class="glyphicon glyphicon-edit"></span> <?= Yii::t('app', 'Update') ?>
                                </a>
                            </div>
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
                    <?= Yii::t('app', 'No data to display.') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
