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
      background: #fcfcfc;
      margin-bottom: 20px;
      -moz-border-radius: 3px;
      -webkit-border-radius: 3px;
      border-radius: 3px;
      -moz-box-shadow: 0 3px 0 rgba(12,12,12,0.03);
      -webkit-box-shadow: 0 3px 0 rgba(12,12,12,0.03);
      box-shadow: 0 3px 0 rgba(12,12,12,0.03);
      position: relative;
}
.album-img img {
  -moz-border-radius: 3px 3px 0 0;
  -webkit-border-radius: 3px 3px 0 0;
  border-radius: 3px 3px 0 0;
}
');
?>
<div class="album-index container-fluid">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_album', ['albums' => $albums]) ?>
    <div class="clearfix"></div>
    <?= LinkPager::widget([
        'pagination' => $pages,
    ]); ?>
</div>
