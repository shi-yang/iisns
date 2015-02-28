<?php
/**
 * @copyright Copyright (c) 2015 Shiyang! Consulting Group LLC
 * @link http://shiyang.me
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
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
		'dist/webuploader.js',
		'multi.upload.js',
	];

	public $depends = [
		'yii\web\JqueryAsset'
	];
} 