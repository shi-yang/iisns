<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\forum\models\Board */


$this->params['forum'] = $model->forum;
if (!$model->isOneBoard()):
$this->title = $model->name.'_'.$model->forum['forum_name'];
$this->params['breadcrumbs'][] = $model->name;
endif;
?>

<?php if (!$model->isOneBoard()): ?>
<div class="col-xs-12 col-sm-12 col-md-10">
	<div class="widget-container">
<?php endif; ?>

    <?= $this->render('/thread/_form', [
        'model' => $newThread,
        'forumName' => $model->forum['forum_name']
    ]) ?>
    <?= $this->render('_threads', [
        'threads' => $model->threads['threads'],
        'model' => $model,
    ]) ?>
<?php if (!$model->isOneBoard()) echo '</div></div>'; ?>
