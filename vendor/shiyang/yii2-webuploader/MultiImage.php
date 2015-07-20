<?php
/**
 * @copyright Copyright (c) 2015 Shiyang
 * @link http://shiyang.me
 */
namespace shiyang\webuploader;

use Yii;
use yii\base\Widget;

/**
 * 多图上传
 */
class MultiImage extends Widget
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
