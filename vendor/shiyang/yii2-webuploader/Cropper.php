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
class Cropper extends Widget
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
		echo '<div class="uploader-container">';
        echo    '<div id="filePicker">选择文件</div>';
        echo '</div>';
		echo '<div class="cropper-wraper webuploader-element-invisible">';
        echo    '<div class="img-container">';
        echo       '<img src="" alt="" />';
        echo    '</div>';
        echo    '<div class="upload-btn">上传所选区域</div>';
        echo '</div>';
		$this->registerPlugin();
	}

	/**
	 * Registers Umeditor plugin
	 */
	protected function registerPlugin()
	{
		$view = $this->getView();

		CropperAsset::register($view);
	}
} 