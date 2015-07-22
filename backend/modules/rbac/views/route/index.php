<?php

use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use backend\modules\rbac\AdminAsset;

/**
 * @var yii\web\View $this
 */
$this->title = Yii::t('rbac-admin', 'Routes');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>
<p>
    <?= Html::a(Yii::t('rbac-admin', 'Create route'), ['create'], ['class' => 'btn btn-success']) ?>
</p>

<div>
    <div class="row">
        <div class="col-lg-5">
            <div class="input-group">
                <span class="input-group-addon"><?= Yii::t('rbac-admin', 'Avaliable') ?>:</span>
                <input type="text" class="form-control" id="search-avaliable" placeholder="Search">
                <span class="input-group-addon"><a href="#" id="btn-refresh"><span class="glyphicon glyphicon-refresh"></span></a></span>
            </div>
            <select class="form-control" id="list-avaliable" multiple size="20" style="width: 100%">
            </select>
        </div>
        <div class="col-lg-1">
            <br><br>
            <a href="#" id="btn-add" class="btn btn-success">&gt;&gt;</a><br>
            <a href="#" id="btn-remove" class="btn btn-danger">&lt;&lt;</a>
        </div>
        <div class="col-lg-5">
            <div class="input-group">
                <span class="input-group-addon"><?= Yii::t('rbac-admin', 'Assigned') ?>:</span>
                <input type="text" class="form-control" id="search-assigned" placeholder="Search">
            </div>
            <select class="form-control" id="list-assigned" multiple size="20" style="width: 100%">
            </select>
        </div>
    </div>
</div>
<?php
AdminAsset::register($this);
$properties = Json::htmlEncode([
        'assignUrl' => Url::to(['assign']),
        'searchUrl' => Url::to(['search']),
    ]);
$js = <<<JS
yii.admin.initProperties({$properties});

$('#search-avaliable').keydown(function () {
    yii.admin.searchRoute('avaliable');
});
$('#search-assigned').keydown(function () {
    yii.admin.searchRoute('assigned');
});
$('#btn-add').click(function () {
    yii.admin.assignRoute('assign');
    return false;
});
$('#btn-remove').click(function () {
    yii.admin.assignRoute('remove');
    return false;
});
$('#btn-refresh').click(function () {
    yii.admin.searchRoute('avaliable',1);
    return false;
});

yii.admin.searchRoute('avaliable', 0, true);
yii.admin.searchRoute('assigned', 0, true);
JS;
$this->registerJs($js);

