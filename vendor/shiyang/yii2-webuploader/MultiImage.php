<?php
/**
 * @copyright Copyright (c) 2015 Shiyang! Consulting Group LLC
 * @link http://shiyang.me
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace shiyang\webuploader;

use yii\base\Widget;
use Yii;

/**
 * Umeditor renders a editor js plugin for classic editing.
 * @see http://ueditor.baidu.com/
 * @author Baidu FLX
 * @link https://github.com/fex-team/umeditor
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
		$this->registerPlugin();
		return $this->render('multi');
	}

	/**
	 * Registers Umeditor plugin
	 */
	protected function registerPlugin()
	{
		$view = $this->getView();

		MultiImageAsset::register($view);
	}
} 