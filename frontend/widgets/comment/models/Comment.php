<?php

namespace app\widgets\comment\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "{{%comment}}".
 *
 * @property string $id
 * @property integer $entity
 * @property string $entity_id
 * @property string $content
 * @property string $parent_id
 * @property integer $user_id
 * @property integer $created_at
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['content', 'required'],
            [['id', 'entity_id', 'parent_id', 'user_id', 'created_at'], 'integer'],
            [['content'], 'string'],
            [['entity'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'table_name' => Yii::t('app', 'Table Name'),
            'content' => Yii::t('app', 'Content'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * 获取评论列表
     * @return array
     */
    public static function getCommentList($entity, $entity_id)
    {
        $query =  (new Query)->select('c.id, c.content, c.parent_id, u.username, u.avatar')
            ->from('{{%comment}} as c')
            ->join('LEFT JOIN','{{%user}} as u', 'u.id=c.user_id')
            ->where('entity=:entity AND entity_id=:entity_id AND parent_id = 0', [':entity' => $entity, ':entity_id' => $entity_id]);
        return Yii::$app->tools->Pagination($query, 15);
    }

    /**
     * This is invoked before the record is saved.
     * @return boolean whether the record should be saved.
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->user_id = Yii::$app->user->id;
                $this->created_at = time();
            }
            return true;
        } else {
            return false;
        }
    }
}
