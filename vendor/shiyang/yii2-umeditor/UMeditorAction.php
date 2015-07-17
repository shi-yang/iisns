<?php
/**
 * @copyright Copyright (c) 2015 Shiyang
 * @author Shiyang <dr@shiyang.me>
 * @link http://shiyang.me
 */

namespace shiyang\umeditor;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;

class UMeditorAction extends Action
{
    /**
     * @var array
     */
    public $config = [];
    /**
     * Default config
     */
    public $_config = [];
    public function init()
    {
        //close csrf
        Yii::$app->request->enableCsrfValidation = false;
        //Default config
        $this->_config = [
            'savePath' => 'uploads/umeditor/' ,             //存储文件夹
            'maxSize' => 1000 ,                   //允许的文件最大尺寸，单位KB
            'allowFiles' => ['.gif' , '.png' , '.jpg' , '.jpeg' , '.bmp'],  //允许的文件格式
        ];
        //load config file
        $this->config = ArrayHelper::merge($this->_config, $this->config);
        parent::init();
    }

    public function run()
    {
        $up = new Uploader('upfile', $this->config);
        $callback = Yii::$app->request->get('callback');
        $info = $up->getFileInfo();
        /**
         * return data
         */
        if($callback) {
            echo '<script>'.$callback.'('.json_encode($info).')</script>';
        } else {
            echo json_encode($info);
        }
    }
}