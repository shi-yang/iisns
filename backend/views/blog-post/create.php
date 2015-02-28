<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\BlogPost */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Blog Post',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-post-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
