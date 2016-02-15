<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */
namespace iisns\webuploader;

use Yii;

/**
 * 多图上传
 *
 * @author Shiyang <dr@shiyang.me>
 */
class MultiImage extends WebUploader
{
	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();
	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		$this->registerClientScript();
		return $this->render('multi');
	}

	/**
	 * Registers Umeditor plugin
	 */
	protected function registerClientScript()
	{
		$view = $this->getView();
		MultiImageAsset::register($view);
	}
}
