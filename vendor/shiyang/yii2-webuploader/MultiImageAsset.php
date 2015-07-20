<?php
/**
 * @copyright Copyright (c) 2015 Shiyang
 * @link http://shiyang.me
 */

namespace shiyang\webuploader;

use yii\web\AssetBundle;

class MultiImageAsset extends AssetBundle
{
	public $sourcePath = '@vendor/shiyang/yii2-webuploader/assets';

	public $css = [
	  	'webuploader.css',
		'multi.css',
	];

	public $js = [
		'dist/webuploader.min.js',
		'multi.upload.js',
	];

	public $depends = [
		'yii\web\JqueryAsset'
	];
}
