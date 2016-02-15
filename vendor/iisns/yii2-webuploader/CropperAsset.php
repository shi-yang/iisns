<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */
namespace iisns\webuploader;

use yii\web\AssetBundle;

/**
 * @author Shiyang <dr@shiyang.me>
 */
class CropperAsset extends AssetBundle
{
	public $sourcePath = '@vendor/iisns/yii2-webuploader/assets';

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
