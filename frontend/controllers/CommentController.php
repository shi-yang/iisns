<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use common\components\BaseController;

/**
 * @author Shiyang <dr@shiyang.me>
 * @since 2.0
 */
class CommentController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ]
        ];
    }

    /**
     * @param string $table 评论所在的表名
     * @param integer $id 进行评论的内容的编号
     */
    public function actionCreate($table, $id)
    {
    	if (Yii::$app->request->isAjax) {
    		$id = intval($id);
	    	if ($table !== 'home_feed' && $table !== 'home_post' && $table !== 'home_photo') {
	    		return false;
	    	}
	    	$insertResult = Yii::$app->db->createCommand()->insert('{{%comment}}', [
	    		'table' => $table,
	    		'table_id' => $id,
	    		'content' => Yii::$app->request->get('content'),
	    		'user_id' => Yii::$app->user->id,
	    		'created_at' => time()
	  		])->execute();
	    	return ($insertResult) ? true : false ;
    	} else {
    		throw new ForbiddenHttpException('You are not allowed to perform this action.');
    	}
    }

}
