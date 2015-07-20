<?php
/**
 * @copyright Copyright (c) 2015 Shiyang
 * @link http://shiyang.me
 */
namespace shiyang\webuploader;

use yii\web\AssetBundle;

class CropperAsset extends AssetBundle
{
	public $sourcePath = '@vendor/shiyang/yii2-webuploader/assets';

	public $css = [
	  	'webuploader.css',
		'cropper.css',
	];

	public $js = [
		'dist/webuploader.min.js',
		'cropper.js',
		'cropper.uploader.js',
	];

	public $depends = [
		'yii\web\JqueryAsset'
	];
}
