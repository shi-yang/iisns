<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['title'] = Yii::t('app', 'Explore') . ' - ' . Yii::t('app', 'Albums');
$this->registerCss('
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
?>
<div class="album-index container">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_album', ['albums' => $albums]) ?>
    <div class="clearfix"></div>
    <?= LinkPager::widget([
        'pagination' => $pages,
    ]); ?>
</div>
