<?php

use yii\helpers\Html;
use yii\helpers\Url;
use shiyang\webuploader\MultiImage;

/* @var $this yii\web\View */
/* @var $model app\modules\blog\models\Album */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Upload');

?>

<?= MultiImage::widget(); ?>
