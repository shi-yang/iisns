<?php
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this yii\web\View */
?>
<?php
NavBar::begin([
    'options' => [
        'class' => 'navbar-default',
    ],
]);
$menuItems = [
    [
        'label' => '<i class="glyphicon glyphicon-comment"></i> ' . Yii::t('app', 'Forums'),
        'url' => ['/explore/index'],
        'linkOptions' => ['data-pjax' => 0]
    ],
    [
        'label' => '<i class="glyphicon glyphicon-picture"></i> ' . Yii::t('app', 'Photos'),
        'url' => ['/explore/photos'],
        'linkOptions' => ['data-pjax' => 0]
    ],
    ['label' => '<i class="glyphicon glyphicon-list-alt"></i> ' . Yii::t('app', 'Posts'), 'url' => ['/explore/posts']],
];
echo Nav::widget([
    'options' => ['class' => 'navbar-nav'],
    'encodeLabels' => false,
    'items' => $menuItems,
]);
NavBar::end();
?>

