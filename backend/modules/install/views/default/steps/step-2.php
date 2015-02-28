<?php

use yii\helpers\Html;

require_once(Yii::getAlias('@yii/requirements/YiiRequirementChecker.php'));
$requirementsChecker = new YiiRequirementChecker();
$gdMemo = $imagickMemo = 'Either GD PHP extension with FreeType support or ImageMagick PHP extension with PNG support is required for image CAPTCHA.';
$gdOK = $imagickOK = false;

if (extension_loaded('imagick')) {
    $imagick = new Imagick();
    $imagickFormats = $imagick->queryFormats('PNG');
    if (in_array('PNG', $imagickFormats)) {
        $imagickOK = true;
    } else {
        $imagickMemo = 'Imagick extension should be installed with PNG support in order to be used for image CAPTCHA.';
    }
}

if (extension_loaded('gd')) {
    $gdInfo = gd_info();
    if (!empty($gdInfo['FreeType Support'])) {
        $gdOK = true;
    } else {
        $gdMemo = 'GD extension should be installed with FreeType support in order to be used for image CAPTCHA.';
    }
}
$requirements = array(
    // Database :
    array(
        'name' => 'PDO extension',
        'mandatory' => true,
        'condition' => extension_loaded('pdo'),
        'by' => 'All DB-related classes',
    ),
    array(
        'name' => 'PDO SQLite extension',
        'mandatory' => false,
        'condition' => extension_loaded('pdo_sqlite'),
        'by' => 'All DB-related classes',
        'memo' => 'Required for SQLite database.',
    ),
    array(
        'name' => 'PDO MySQL extension',
        'mandatory' => false,
        'condition' => extension_loaded('pdo_mysql'),
        'by' => 'All DB-related classes',
        'memo' => 'Required for MySQL database.',
    ),
    array(
        'name' => 'PDO PostgreSQL extension',
        'mandatory' => false,
        'condition' => extension_loaded('pdo_pgsql'),
        'by' => 'All DB-related classes',
        'memo' => 'Required for PostgreSQL database.',
    ),
    // Cache :
    array(
        'name' => 'Memcache extension',
        'mandatory' => false,
        'condition' => extension_loaded('memcache') || extension_loaded('memcached'),
        'by' => '<a href="http://www.yiiframework.com/doc-2.0/yii-caching-memcache.html">MemCache</a>',
        'memo' => extension_loaded('memcached') ? 'To use memcached set <a href="http://www.yiiframework.com/doc-2.0/yii-caching-memcache.html#$useMemcached-detail">MemCache::useMemcached</a> to <code>true</code>.' : ''
    ),
    array(
        'name' => 'APC extension',
        'mandatory' => false,
        'condition' => extension_loaded('apc'),
        'by' => '<a href="http://www.yiiframework.com/doc-2.0/yii-caching-apccache.html">ApcCache</a>',
    ),
    // CAPTCHA:
    array(
        'name' => 'GD PHP extension with FreeType support',
        'mandatory' => false,
        'condition' => $gdOK,
        'by' => '<a href="http://www.yiiframework.com/doc-2.0/yii-captcha-captcha.html">Captcha</a>',
        'memo' => $gdMemo,
    ),
    array(
        'name' => 'ImageMagick PHP extension with PNG support',
        'mandatory' => false,
        'condition' => $imagickOK,
        'by' => '<a href="http://www.yiiframework.com/doc-2.0/yii-captcha-captcha.html">Captcha</a>',
        'memo' => $imagickMemo,
    ),
    // PHP ini :
    'phpSafeMode' => array(
        'name' => 'PHP safe mode',
        'mandatory' => false,
        'condition' => $requirementsChecker->checkPhpIniOff("safe_mode"),
        'by' => 'File uploading and console command execution',
        'memo' => '"safe_mode" should be disabled at php.ini',
    ),
    'phpExposePhp' => array(
        'name' => 'Expose PHP',
        'mandatory' => false,
        'condition' => $requirementsChecker->checkPhpIniOff("expose_php"),
        'by' => 'Security reasons',
        'memo' => '"expose_php" should be disabled at php.ini',
    ),
    'phpAllowUrlInclude' => array(
        'name' => 'PHP allow url include',
        'mandatory' => false,
        'condition' => $requirementsChecker->checkPhpIniOff("allow_url_include"),
        'by' => 'Security reasons',
        'memo' => '"allow_url_include" should be disabled at php.ini',
    ),
    'phpSmtp' => array(
        'name' => 'PHP mail SMTP',
        'mandatory' => false,
        'condition' => strlen(ini_get('SMTP')) > 0,
        'by' => 'Email sending',
        'memo' => 'PHP mail SMTP server required',
    ),
);
$requirements = $requirementsChecker->checkYii()->check($requirements)->result['requirements'];
$dataProvider = new \yii\data\ArrayDataProvider([
    'allModels' => $requirements
]);
$columns = [
    [
        'attribute' => 'name',
        'header' => Yii::t('install', 'Name'),
        'format' => 'text'
    ],
    [
        'attribute' => 'condition',
        'header' => Yii::t('install', 'condition'),
        'format' => 'raw',
        'value' => function ($model, $key, $index, $column) {
            if($model['warning']) {
                $content = Yii::t('install', 'Warning');
                $class = 'label-warning';
            } elseif ($model['error']){
                $content = Yii::t('install', 'Error');
                $class = 'label-danger';
            } else {
                 $content = 'OK';
                 $class = 'label-success';
            }
            if ($model['error']) {
                $this->context->result = false;
            }
            return Html::tag('span', $content, [
                'class' => "label $class"
            ]);
        }
    ],
    [
        'attribute' => 'memo',
        'header' => Yii::t('install', 'Comment'),
        'format' => 'html'
    ],
];

?>
<h1><?= Yii::t('install', 'Step 2: Verification requirements.'); ?></h1>
<div class="well">
    <?= $this->render('grid', ['columns' => $columns, 'dataProvider' => $dataProvider]); ?>
    <?= $this->render('check', ['step' => $step, 'currentStep' => $currentStep]); ?>
    <?php
        echo Html::a(Yii::t('install', 'Back'), ['index', 'step' => $previousStep], ['class' => 'btn btn-default']);
        if ($this->context->result) {
            echo Html::a(Yii::t('install', 'Continue'), ['index', 'step' => $nextStep], ['class' => 'btn btn-success pull-right']);
        } else {
            echo Html::a(Yii::t('install', 'Refresh'), ['index', 'step' => $currentStep], ['class' => 'btn btn-info pull-right']);
        }
    ?>
</div>