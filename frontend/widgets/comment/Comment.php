<?php

namespace app\widgets\comment;

use Yii;
use yii\base\Widget;

class Comment extends Widget
{
    public $tableId;
    public $tableName;
    public function run()
    {
        $connection = Yii::$app->db;
        $commentList = $connection->createCommand('SELECT * FROM {{%comment}} WHERE table_id=:tableId AND table_name=:tableName')
            ->bindValues([':tableId' => $this->tableId, ':tableName' => $this->tableName])
            ->queryAll();
        $newComment = new \app\models\Comment();
        if ($newComment->load(Yii::$app->request->post())) {
            $newComment->table_id = $this->tableId;
            $newComment->table_name = $this->tableName;
            if ($newComment->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Create successfully.'));
                return Yii::$app->getResponse()->refresh();
            } else {
                print_r($newComment->getErrors());
            }
        }
        return $this->render('comment', [
            'commentList' => $commentList,
            'newComment' => $newComment,
        ]);
    }
}
