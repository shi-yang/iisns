<?php
/**
 * @copyright Copyright (c) 2015 Shiyang
 * @author Shiyang <dr@shiyang.me>
 * @link http://shiyang.me
 */

namespace common\widgets\umeditor;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\widgets\InputWidget;

/**
 * UMeditor renders a editor js plugin for classic editing.
 * @see http://ueditor.baidu.com/
 * @author Baidu FLX
 * @link https://github.com/fex-team/umeditor
 */
class UMeditor extends InputWidget
{
	/**
	 * Editor options that will be passed to the editor
 	 * @see yii2-umeditor/assets/umeditor.config.js
	 */
	public $clientOptions = [];
	/**
	 * Default options that will be passed to the editor
	 */
    protected $_options;
	/**
	 * @inheritdoc
	 */
	public function init()
	{
        $this->_options = [
        	'imageUrl' => Url::to(['upload']),
        	'imagePath' => Yii::getAlias('@web/'),
            'initialFrameWidth' => '100%',
            'initialFrameHeight' => '400',
            'lang' => (strtolower(Yii::$app->language) == 'en-us') ? 'en' : 'zh-cn',
        ];
        $this->clientOptions = ArrayHelper::merge($this->_options, $this->clientOptions);
		parent::init();
	}
	/**
	 * @inheritdoc
	 */
	public function run()
	{
		if ($this->hasModel()) {
			echo Html::activeTextarea($this->model, $this->attribute, $this->options);
		} else {
			echo Html::textarea($this->name, $this->value, $this->options);
		}
		$this->registerClientScript();
	}
	/**
	 * Registers Umeditor plugin
	 */
	protected function registerClientScript()
	{
		$view = $this->getView();
		UMeditorAsset::register($view);
		$id = $this->options['id'];
		$options = Json::encode($this->clientOptions);
		$js = "window.um = UM.getEditor('$id', $options);";
		$view->registerJs($js, $view::POS_READY);
	}
}
