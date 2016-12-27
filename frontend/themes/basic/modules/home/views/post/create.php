<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\home\models\Post */

$this->title = Yii::t('app', 'Create Post');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
if ($editor == 'html')
    $url = Html::a('切换到MarkDown编辑器', ['editor' => 'markdown'], ['data-pjax' => 0]);
else
    $url = Html::a('切换到Html编辑器', ['editor' => 'html'], ['data-pjax' => 0]);
?>
<div class="post-create">

    <h1><?= Html::encode($this->title) ?><small><?= $url ?></small></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'editor' => $editor
    ]) ?>

</div>
