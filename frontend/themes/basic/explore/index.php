<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use nirvana\infinitescroll\InfiniteScrollPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['title'] = Yii::t('app', 'Explore');
$this->registerCss('
.index-all {
    margin-top:20px;
}
.album-all {
list-style-type: none;
}
.album-item {
    float:left;
    padding: 6px;
    border-width: 0;
    border-bottom-width: 1px\9;
    box-shadow: 0 1px 4px rgba(0,0,0,.15);
    width: 170px;
}
.album-cover {
    width:158px;
    height:158px;
}
');
$this->registerCssFile(Yii::getAlias('@web').'/css/forum/css/forum.css');
?>
<div class="index-all">
    <div class="album-all">
        <div class="panel panel-default">
          <div class="panel-heading"><?= Yii::t('app', 'Albums') ?></div>
          <div class="panel-body">
            <div class="row">
                <?php 
                    if ($this->beginCache('explore-album', ['duration' => 3600])) {
                        
                        //echo $this->render('_album', ['albums' => $albums]);
                        $this->endCache();
                    }
                ?>
            </div>
          </div>
        </div>
    </div>
    <div class="forum-all">
        <?= $this->render('_forum', ['forums' => $forums]) ?>
    </div>
</div>
