<?php

use yii\grid\GridView;

echo GridView::widget([
    'id' => 'environment-grid',
    'dataProvider' => $dataProvider,
    'layout' => '{items}',
    'columns' => $columns
]);
?>