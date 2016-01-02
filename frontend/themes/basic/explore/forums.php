<?php

use yii\helpers\Html;
use shiyang\masonry\Masonry;

/* @var $this yii\web\View */

// $this->params['title'] = Yii::t('app', 'Explore') . ' - ' . Yii::t('app', 'Forums');
// $this->params['breadcrumb'][] = Yii::t('app', 'Forums');
$this->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->setting->get('siteKeyword')]);
$this->registerMetaTag(['name' => 'description', 'content' => Yii::$app->setting->get('siteDescription')]);
$this->registerCss('
.item {
    float: left;
    width: 180px;
    margin: 8px;
    padding: 10px;
    background: #f6f6f6;
    color: #444;
    cursor:pointer;
    border: 1px solid #B9B9B9;
    overflow:hidden;
    text-overflow:ellipsis;
}
.item:hover {
    color: #777
}
.item .forum-name {
    border-bottom: 1px solid #ccc;
    margin: 10px 0;
    display: board;
    padding: 0 0 5px;
    font-size: 17px;
}
@media (max-width: 767px) {
 .item {
 width: 100%;
 height: 120px;
 margin: 0
 }
}
.item .forum-description {
white-space: normal;
word-wrap: break-word;
}
.item .picture img {
    width: 120px;
    height: 120px;
}
');
?>
<div class="forum-index">
    <div class="forum-all">
        <?php Masonry::begin([
            'options' => [
              'id' => 'forums'
            ],
            'pagination' => $pages
        ]); ?>
            <?= $this->render('_forum', ['forums' => $forums, 'pages' => $pages]) ?>
        <?php Masonry::end(); ?>
    </div>
</div>
