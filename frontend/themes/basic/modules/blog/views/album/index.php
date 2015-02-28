<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Albums');
$this->params['breadcrumbs'][] = $this->title;
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

    <p>
        <?= Html::a(Yii::t('app', 'Create Album'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= ListView::widget([
        'layout' => "{items}\n{pager}",
        'dataProvider' => $dataProvider,
        'itemView' => '_album',
        'options' => [
            'tag' => 'ul',
            'class' => 'album-all'
        ],
        'itemOptions' => [
            'class' => 'album-item',
            'tag' => 'li'
        ]
    ]); ?>

</div>
