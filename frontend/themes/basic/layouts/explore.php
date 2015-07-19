<?php

use yii\bootstrap\Nav;
use yii\widgets\Breadcrumbs;

if (!isset($this->title)) {
    $this->title = Yii::$app->setting->get('siteTitle');
}
if (Yii::$app->user->isGuest) {
    $this->beginContent(__DIR__.'/main.php');
} else {
	$this->registerCssFile('@web/css/site.css');
    $this->beginContent('@app/modules/user/views/layouts/user.php');
}
$this->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->setting->get('siteKeyword')]);
$this->registerMetaTag(['name' => 'description', 'content' => Yii::$app->setting->get('siteDescription')]);
?>
<div class="page-header">
  <h1><?= $this->params['title'] ?> <small><?= Yii::$app->setting->get('siteTitle') ?></small></h1>
</div>
<?= Breadcrumbs::widget([
	'homeLink' => ['label' => Yii::t('app', 'Explore'), 'url' => ['/explore/index']],
	'links' => isset($this->params['breadcrumb']) ? $this->params['breadcrumb'] : [],
]) ?>
<?= $content; ?>
<?php $this->endContent(); ?>
