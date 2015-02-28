<?php

use yii\bootstrap\Alert;
use yii\grid\GridView;
use yii\helpers\Html;


$requirements = [
    [
        'name' => Yii::t('install', 'Directory') . ' frontend assets (@frontend/web/assets)',
        'result' => is_writable(Yii::getAlias('@frontend/web/assets'))
    ],
    [
        'name' => Yii::t('install', 'Directory') . ' backend assets (@backend/web/assets)',
        'result' => is_writable(Yii::getAlias('@backend/web/assets'))
    ],
    [
        'name' => Yii::t('install', 'Directory') . ' cache (@common/cache)',
        'result' => is_writable(Yii::getAlias('@common/cache'))
    ],
    [
        'name' => Yii::t('install', 'Directory') . ' frontend runtime (@frontend/runtime)',
        'result' => is_writable(Yii::getAlias('@frontend/runtime'))
    ],
    [
        'name' => Yii::t('install', 'Directory') . ' backend runtime (@backend/runtime)',
        'result' => is_writable(Yii::getAlias('@backend/runtime'))
    ]
];
$dataProvider = new \yii\data\ArrayDataProvider([
    'allModels' => $requirements
]);
$columns = [
    [
        'attribute' => 'name',
        'header' => Yii::t('install', 'Name'),
        'format' => 'text'
    ],
    [
        'attribute' => 'result',
        'header' => Yii::t('install', 'Result'),
        'format' => 'raw',
        'value' => function ($model, $key, $index, $column) {
            $content = $model['result'] ? 'OK' : Yii::t('install', 'Error');
            if (!$model['result']) {
                $this->context->result = false;
            }
            return Html::tag('span', $content, [
                'class' => $model['result'] ? 'label label-success' : 'label label-danger'
            ]);
        }
    ],
];


?>
<h1><?= Yii::t('install', 'Step 1: Verification environment.'); ?></h1>
<div class="well">
    <?= $this->render('grid', ['columns' => $columns, 'dataProvider' => $dataProvider]); ?>
    <?= $this->render('check', ['step' => $step, 'currentStep' => $currentStep]); ?>

    <?php
        echo Html::a(Yii::t('install', 'Back'), ['index', 'step' => $previousStep], ['class' => 'btn btn-default']);
        if ($this->context->result) {
            echo Html::a(Yii::t('install', 'Continue'), ['index', 'step' => $nextStep], ['class' => 'btn btn-success pull-right']);
        } else {
            echo Html::a(Yii::t('install', 'Refresh'), ['index', 'step' => $currentStep], ['class' => 'btn btn-info pull-right']);
        }
    ?>
</div>