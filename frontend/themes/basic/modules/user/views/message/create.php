<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\user\models\Message */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Message',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Messages'), 'url' => ['inbox']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['count'] = $count;
?>
<div class="message-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
