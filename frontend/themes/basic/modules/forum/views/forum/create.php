<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\forum\models\Forum */

$this->title = Yii::t('app', 'Create Forum');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Forums'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forum-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
