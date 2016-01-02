<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Setting');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
	<div class="col-md-8">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"><?= Html::encode($this->title) ?></h3>
			</div>
		    <?= Html::beginForm() ?>
		    	<div class="box-body">
			    	<div class="form-group">
			    		<?= Html::label(Yii::t('app', 'Site Name'), 'siteName') ?>
			    		<?= Html::textInput('siteName', $settings['siteName'], ['class' => 'form-control']) ?>
			    	</div>

			    	<div class="form-group">
			    		<?= Html::label(Yii::t('app', 'Site Title'), 'siteTitle') ?>
			    		<?= Html::textInput('siteTitle', $settings['siteTitle'], ['class' => 'form-control']) ?>
			    	</div>

			    	<div class="form-group">
			    		<?= Html::label(Yii::t('app', 'Site Description'), 'siteDescription') ?>
			    		<?= Html::textarea('siteDescription', $settings['siteDescription'], ['class' => 'form-control']) ?>
			    	</div>

			    	<div class="form-group">
			    		<?= Html::label(Yii::t('app', 'Site Keyword'), 'siteKeyword') ?>
			    		<?= Html::textInput('siteKeyword', $settings['siteKeyword'], ['class' => 'form-control']) ?>
			    	</div>

			    	<div class="form-group">
			    		<?= Html::label(Yii::t('app', 'Statistics Code'), 'statisticsCode') ?>
			    		<?= Html::textarea('statisticsCode', $settings['statisticsCode'], ['class' => 'form-control']) ?>
			    	</div>
		    	</div>
		    	<div class="box-footer">
				    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
		    	</div>
		    <?= Html::endForm(); ?>
		</div>
	</div>
</div>
