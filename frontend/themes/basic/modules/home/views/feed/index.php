<?php

use yii\helpers\Html;
use yii\helpers\Url;
use shiyang\infinitescroll\InfiniteScrollPager;
use app\components\Tools;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Feeds');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-xs-12 col-sm-8 col-md-8" >
    <div class="feed-index">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a(Yii::t('app', 'Create Feed'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    </div>
    <div class="social-wrapper row">
        <div id="social-container">
            <div id="content">
                <?php if (!empty($feeds)): ?>
                    <div id="content">
                        <?php foreach($feeds as $feed): ?>
                            <div class="item widget-container fluid-height social-entry" id="<?= $feed['id'] ?>">
                                <div class="widget-content padded">
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
                                        &nbsp;
                                        <a href="<?= Url::toRoute(['/home/feed/delete', 'id' => $feed['id']]) ?>" data-clicklog="delete" onclick="return false;" title="<?= Yii::t('app', 'Are you sure to delete it?') ?>">
                                            <span class="glyphicon glyphicon-trash"></span> <?= Yii::t('app', 'Delete') ?>
                                        </a>
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
                        No feed to display.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
