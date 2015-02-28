<?php
use yii\bootstrap\Nav;

if (!isset($this->title)) {
    $this->title = Yii::$app->setting->get('siteTitle');
}

if (Yii::$app->user->isGuest) {
    $this->beginContent(__DIR__.'/main.php');
} else {
    $this->beginContent('@app/modules/user/views/layouts/user.php');
}
$this->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->setting->get('siteKeyword')]);
$this->registerMetaTag(['name' => 'description', 'content' => Yii::$app->setting->get('siteDescription')]);
?>
<div class="page-header">
  <h1><?= $this->params['title'] ?> <small><?= Yii::$app->setting->get('siteTitle') ?></small></h1>
</div>
<?= Nav::widget([
        'items' => [
            [
                'label' => '<i class="glyphicon glyphicon-home"></i> ',
                'url' => ['/explore/index'],
            ],
            [
                'label' => '<i class="glyphicon glyphicon-comment"></i> '. Yii::t('app', 'Forums'),
                'url' => ['/explore/forums'],
            ],
            [
                'label' => '<i class="glyphicon glyphicon-picture"></i> '. Yii::t('app', 'Albums'),
                'url' => ['/explore/albums'],
            ],
        ],
        'encodeLabels' => false,
        'options' => ['class' =>'nav-pills'], 
]) ?>

<?= $content; ?>

<?php $this->endContent(); ?>