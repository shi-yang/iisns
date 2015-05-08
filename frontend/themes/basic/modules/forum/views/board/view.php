<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\forum\models\Board */

$forum = $model->forum;
$this->params['forum'] = $forum;
if (!$model->isOneBoard()):
    $this->title = $model->name . '_' . $forum['forum_name'];
    $this->params['breadcrumbs'][] = $model->name;
    echo '<div class="col-xs-12 col-sm-12 col-md-10">';
    echo '<div class="widget-container">';
endif;
?>
    <?= $this->render('/thread/_form', [
        'model' => $newThread,
        'forumName' => $forum['forum_name']
    ]) ?>
    <?= $this->render('_threads', [
        'threads' => $model->threads['threads'],
        'model' => $model,
    ]) ?>
<?php if (!$model->isOneBoard()) echo '</div></div>'; ?>
