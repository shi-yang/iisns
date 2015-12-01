<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */

namespace app\modules\home\models;

use Yii;

/**
 * This is the model class for table "{{%home_comment}}".
 *
 * @property integer $id
 * @property string $content
 * @property integer $created_at
 * @property string $author
 * @property string $email
 * @property integer $post_id
 * @property integer $user_id
 *
 * @author Shiyang <dr@shiyang.me>
 * @since 2.0
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%home_comment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'created_at', 'author', 'email', 'post_id', 'user_id'], 'required'],
            [['content'], 'string'],
            [['created_at', 'post_id', 'user_id'], 'integer'],
            [['author', 'email'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'content' => Yii::t('app', 'Content'),
            'created_at' => Yii::t('app', 'Create Time'),
            'author' => Yii::t('app', 'Author'),
            'email' => Yii::t('app', 'Email'),
            'post_id' => Yii::t('app', 'Post ID'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }
}
