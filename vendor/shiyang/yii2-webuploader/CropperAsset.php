<?php
/**
 * @copyright Copyright (c) 2015 Shiyang! Consulting Group LLC
 * @link http://shiyang.me
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
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
		'dist/webuploader.js',
		'cropper.js',
		'cropper.uploader.js',
	];

	public $depends = [
		'yii\web\JqueryAsset'
	];
} 