<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\user\models\Message */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['count'] = $count;
?>
<article class="inbox-read">
  <!-- Start .inbox-read -->
  <header class="inbox-header">
    <h3><?= Html::encode($model->subject) ?></h3>
  </header>
  <div class="inbox-info-bar">
    <p>
        <?= Html::a(Yii::t('app', 'Reply'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
  </div>
  <div class="inbox-content">
      <?= $model->content ?>
  </div>
</article>
