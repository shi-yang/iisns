<?php
/**
 * @copyright Copyright (c) 2015 Shiyang
 * @author Shiyang <dr@shiyang.me>
 * @link http://shiyang.me
 * @license http://opensource.org/licenses/MIT
 */
use yii\db\Migration;
use yii\db\Schema;

/**
 * CLass m141208_201480_blog_init
 * @package shiyang\blog\migrations
 */
class m141208_201488_setting_init extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        // MySql table options
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        // table blog_catalog
        $this->createTable(
            '{{%setting}}',
            [
                'id' => Schema::TYPE_PK,
                'parent_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
                'code' => Schema::TYPE_STRING . '(32) NOT NULL',
                'type' => Schema::TYPE_STRING . '(32) NOT NULL',
                'store_range' => Schema::TYPE_STRING . '(255)',
                'store_dir' => Schema::TYPE_STRING . '(255)',
                'value' => Schema::TYPE_TEXT . '',
                'sort_order' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 50',
            ],
            $tableOptions
        );

        // Indexes
        $this->createIndex('parent_id', '{{%setting}}', 'parent_id');
        $this->createIndex('code', '{{%setting}}', 'code');
        $this->createIndex('sort_order', '{{%setting}}', 'sort_order');

        // Add default setting
        $this->execute($this->getSettingSql());
    }

    /**
     * @return string SQL to insert first user
     */
    private function getSettingSql()
    {
        return "INSERT INTO {{%setting}} (`id`, `parent_id`, `code`, `type`, `store_range`, `store_dir`, `value`, `sort_order`) VALUES
                (11, 0, 'info', 'group', '', '', '', '50'),
                (21, 0, 'basic', 'group', '', '', '', '50'),
                (31, 0, 'smtp', 'group', '', '', '', '50'),
                (1111, 11, 'siteName', 'text', '', '', 'Your Site', '50'),
                (1112, 11, 'siteTitle', 'text', '', '', 'Your Site Title', '50'),
                (1113, 11, 'siteKeyword', 'text', '', '', 'Your Site Keyword', '50'),
                (2111, 21, 'timezone', 'select', '-12,-11,-10,-9,-8,-7,-6,-5,-4,-3.5,-3,-2,-1,0,1,2,3,3.5,4,4.5,5,5.5,5.75,6,6.5,7,8,9,9.5,10,11,12', '', '8', '50'),
                (2112, 21, 'commentCheck', 'select', '0,1', '', '1', '50'),
                (3111, 31, 'smtpHost', 'text', '', '', 'localhost', '50'),
                (3112, 31, 'smtpPort', 'text', '', '', '', '50'),
                (3113, 31, 'smtpUser', 'text', '', '', '', '50'),
                (3114, 31, 'smtpPassword', 'password', '', '', '', '50'),
                (3115, 31, 'smtpMail', 'text', '', '', '', '50')
                ";
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%setting}}');
    }
}
