<?php

namespace app\modules\user\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "{{%user_message}}".
 *
 * @property integer $id
 * @property integer $sendfrom
 * @property integer $sendto
 * @property string $subject
 * @property string $content
 * @property integer $created_at
 * @property integer $read_indicator
 * @property integer $inbox
 * @property integer $outbox
 * @property integer $post_id
 *
 * @property User $sendto0
 * @property User $sendfrom0
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_message}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sendto', 'subject', 'content'], 'required'],
            [['sendfrom', 'created_at', 'read_indicator', 'inbox', 'outbox', 'post_id'], 'integer'],
            [['content'], 'string'],
            [['subject'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'sendfrom' => Yii::t('app', 'Sendfrom'),
            'sendto' => Yii::t('app', 'Sendto'),
            'subject' => Yii::t('app', 'Subject'),
            'content' => Yii::t('app', 'Content'),
            'created_at' => Yii::t('app', 'Create Time'),
            'read_indicator' => Yii::t('app', 'Read Indicator'),
            'inbox' => Yii::t('app', 'Inbox'),
            'outbox' => Yii::t('app', 'Outbox'),
            'post_id' => Yii::t('app', 'Post ID'),
        ];
    }

    /**
     * This is invoked before the record is saved.
     * @return boolean whether the record should be saved.
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                if (!empty($this->userid)) {
                    $this->sendto = $this->userid;
                } else {
                    $this->addError('sendto', Yii::t('app','User not found'));
                    return false;
                }
                $this->sendfrom = Yii::$app->user->id;
                $this->created_at = time();

                //提示用户未读消息
                Yii::$app->userData->updateKey('unread_message_count', $this->sendto, 1);
            }
            return true;
        } else {
            return false;
        }
    }

    public function getUserid()
    {
        if (is_numeric($this->sendto)) {
            $param = 'id';
        } elseif (strpos($this->sendto, '@')) {
            $param = 'email';
        } else {
            $param = 'username';
        }
        $query = new Query;
        $user = $query->select('id')->from('{{%user}}')
            ->where("{$param}=:sendto", [':sendto' => $this->sendto])
            ->scalar();
        return $user;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSendto()
    {
        return $this->hasOne(User::className(), ['id' => 'sendto']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSendfrom()
    {
        return $this->hasOne(User::className(), ['id' => 'sendfrom']);
    }
}
