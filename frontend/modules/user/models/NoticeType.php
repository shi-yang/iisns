<?php
/**
 * @link http://www.iisns.com/
 * @copyright Copyright (c) 2015 iiSNS
 * @license http://www.iisns.com/license/
 */

namespace app\modules\user\models;

use Yii;

/**
 * This is the model class for table "{{%user_notice_type}}".
 *
 * @property integer $id
 * @property string $type
 * @property string $type_title
 * @property string $type_content
 *
 * @author Shiyang <dr@shiyang.me>
 */
class NoticeType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_notice_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'type_title', 'type_content'], 'required'],
            [['type'], 'string', 'max' => 50],
            [['type_title', 'type_content'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('notice', 'ID'),
            'type' => Yii::t('notice', 'Type'),
            'type_title' => Yii::t('notice', 'Type Title'),
            'type_content' => Yii::t('notice', 'Type Content'),
        ];
    }

    /**
     * @param $key
     */
    public static function getTypeInfo($key, $cacheKey = 'noticeType')
    {
        $cache = Yii::$app->cache;
        $typesDate = $cache->get($cacheKey);
        if ($typesDate === false) {
            $typesDate = static::getTypes();
            $cache->set($typesDate, $cacheKey);
        }
        return $typesDate[$key];
    }

    private static function getTypes()
    {
        $typeList = Yii::$app->db->createCommand('SELECT * FROM {{%user_notice_type}}')->queryAll();

        $result = [];
        foreach ($typeList as $element) {
            $key = $element['type_title'];
            $value = $element['type_content'];
            $result[$element['type']] = [
                'type_title' => $key,
                'type_content' =>$value
            ];
        }
        return $result;
    }
}
