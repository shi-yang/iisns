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
<div class="feed-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Feed'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>
<div class="social-wrapper row">
    <div id="social-container">
        <div class="col-xs-12 col-sm-8 col-md-8" id="content">
            <?php if (!empty($feeds)): ?>
                <div id="content">
                    <?php foreach($feeds as $feed): ?>
                        <div class="item widget-container fluid-height social-entry">
                            <div class="widget-content padded">
                                <p class="content">
                                    <?= Html::encode($feed['content']) ?>
                                </p>
                                <a href="<?= Url::toRoute(['/home/feed/delete', 'id' => $feed['id']]) ?>" data-confirm="<?= Yii::t('app', 'Are you sure to delete it?') ?>" data-method="feed">
                                    <span class="glyphicon glyphicon-trash"></span> <?= Yii::t('app', 'Delete') ?>
                                </a>
                                &nbsp;&nbsp;<a href="<?= Url::toRoute(['/home/feed/update', 'id' => $feed['id']]) ?>">
                                    <span class="glyphicon glyphicon-edit"></span> <?= Yii::t('app', 'Update') ?>
                                </a>
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
