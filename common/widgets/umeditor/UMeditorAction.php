<?php
/**
 * @copyright Copyright (c) 2015 Shiyang
 * @author Shiyang <dr@shiyang.me>
 * @link http://shiyang.me
 */

namespace common\widgets\umeditor;

use Yii;
use yii\base\Action;
use yii\helpers\ArrayHelper;
use common\components\Uploader;

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
        $this->_config = [
            'savePath' => 'uploads/user/' ,             //存储文件夹
            'maxSize' => 2048 ,//允许的文件最大尺寸，单位KB
            'allowFiles' => ['.gif' , '.png' , '.jpg' , '.jpeg' , '.bmp'],  //允许的文件格式
        ];
        //load config file
        $this->config = ArrayHelper::merge($this->_config, $this->config);
        parent::init();
    }

    public function run()
    {
        $up = new Uploader('upfile', $this->config, 'editor');
        $callback = Yii::$app->request->get('callback');
        $info = $up->getFileInfo();
        //存入数据库
        Yii::$app->db->createCommand()->insert('{{%home_photo}}', [
            'name' => $info['name'],
            'path' => Yii::getAlias('@web/uploads/user/') . Yii::$app->user->id . '/' . $info['name'], //存储路径
            'store_name' => $info['name'], //保存的名称
            'album_id' => 0,
            'created_at' => time(),
            'created_by' => Yii::$app->user->id, 
        ])->execute();
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
