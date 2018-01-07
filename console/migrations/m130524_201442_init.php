<?php

use yii\db\Schema;
use yii\db\Migration;
use yii\base\Security;

class m130524_201442_init extends Migration
{
    const USER_AUTO_INCREMENT_NUM = 1000;
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_PK,
            'username' => $this->string(64),
            'auth_key' => Schema::TYPE_STRING . '(32) NOT NULL',
            'password_hash' => Schema::TYPE_STRING . ' NOT NULL',
            'password_reset_token' => Schema::TYPE_STRING,
            'email' => Schema::TYPE_STRING . ' NOT NULL',
            'role' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'avatar' => Schema::TYPE_STRING . '(64) NOT NULL'
        ], $tableOptions);

        // 输入管理员信息
        fwrite(STDOUT, 'Enter Administrator\'s name:');
        $username = trim(fgets(STDIN));
        fwrite(STDOUT, 'Enter Administrator\'s password:');
        $password = trim(fgets(STDIN));
        fwrite(STDOUT, 'Enter Administrator\'s email:');
        $email = trim(fgets(STDIN));
        $password_hash = (new Security)->generatePasswordHash($password);
        $auth_key = (new Security())->generateRandomString();
        $time = time();

        $this->insert('{{%user}}', [
            'id' => self::USER_AUTO_INCREMENT_NUM,
            'username' => $username,
            'password_hash' => $password_hash,
            'auth_key' => $auth_key,
            'email' => $email,
            'created_at' => $time,
            'updated_at' => $time,
            'avatar' => 'default/10.jpg'
        ]);

        $this->createTable('{{%comment}}', [
            'id' => $this->bigPrimaryKey(20),
            'entity' => $this->string(8),
            'entity_id' => $this->bigInteger(20),
            'content' => $this->text(),
            'parent_id' => $this->bigInteger(20),
            'user_id' => $this->integer(),
            'created_at' => $this->integer()
        ], $tableOptions);


        $this->createTable('{{%forum}}', [
            'id' => $this->primaryKey(),
            'forum_name' => $this->string(64),
            'forum_desc' => $this->text(),
            'forum_url' => $this->string(64),
            'user_id' => $this->integer(),
            'created_at' => $this->integer(),
            'status' => $this->smallInteger(),
            'forum_icon' => $this->string(32)
        ], $tableOptions);

        $this->createTable('{{%forum_board}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->defaultValue(0),
            'name' => $this->string(64),
            'description' => $this->text(),
            'columns' => $this->smallInteger()->defaultValue(1),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
            'forum_id' => $this->integer(),
            'user_id' => $this->integer()
        ], $tableOptions);

        $this->createTable('{{%forum_broadcast}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(128),
            'content' => $this->text(),
            'forum_id' => $this->integer(),
            'user_id' => $this->integer(),
            'created_at' => $this->integer()
        ], $tableOptions);

        $this->createTable('{{%forum_follow}}', [
            'id' => $this->primaryKey(),
            'forum_id' => $this->integer(),
            'user_id' => $this->integer()
        ], $tableOptions);

        $this->createTable('{{%forum_post}}', [
            'id' => $this->primaryKey(),
            'content' => $this->text(),
            'thread_id' => $this->integer(),
            'user_id' => $this->integer(),
            'created_at' => $this->integer()
        ], $tableOptions);

        $this->createTable('{{%forum_thread}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'content' => $this->text(),
            'user_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'board_id' => $this->integer(),
            'post_count' => $this->integer()->defaultValue(0)
        ], $tableOptions);

        $this->createTable('{{%home_album}}', [
            'id' => $this->bigPrimaryKey(),
            'name' => $this->string(128),
            'description' => $this->string(),
            'cover_id' => $this->bigInteger(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'enable_comment' => $this->smallInteger()->defaultValue(1),
            'status' => $this->smallInteger()->defaultValue(0),
            'status_password' => $this->char(),
            'status_question' => $this->string(),
            'status_answer' => $this->string()
        ], $tableOptions);

        $this->createTable('{{%home_photo}}', [
            'id' => $this->bigPrimaryKey(),
            'album_id' => $this->bigInteger(),
            'name' => $this->string(128),
            'thumb' => $this->string(),
            'path' => $this->string(),
            'store_name' => $this->string(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'is_cover' => $this->smallInteger()->defaultValue(0)
        ], $tableOptions);

        $this->createTable('{{%home_feed}}', [
            'id' => $this->primaryKey(),
            'type' => $this->char(64),
            'content' => $this->text(),
            'template' => $this->text(),
            'comment_count' => $this->integer(),
            'repost_count' => $this->integer(),
            'feed_data' => $this->text(),
            'user_id' => $this->integer(),
            'created_at' => $this->integer()
        ], $tableOptions);

        $this->createTable('{{%home_post}}', [
            'id' => $this->integer(),
            'title' => $this->string(),
            'content' => $this->text(),
            'markdown' => $this->text(),
            'tags' => $this->text(),
            'user_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'status' => $this->char(10),
            'explore_status' => $this->smallInteger()->defaultValue(0)
        ], $tableOptions);

        $this->createTable('{{%setting}}', [
            'key' => $this->string(),
            'value' => $this->text()
        ], $tableOptions);

        $this->insert('{{%setting}}', [
            'key' => 'statisticsCode',
            'value' => ''
        ]);

        $this->insert('{{%setting}}', [
            'key' => 'siteName',
            'value' => 'iiSNS'
        ]);

        $this->insert('{{%setting}}', [
            'key' => 'siteKeyword',
            'value' => 'iisns, yii2'
        ]);

        $this->insert('{{%setting}}', [
            'key' => 'siteTitle',
            'value' => 'iiSNS - Global Village Entrance'
        ]);

        $this->insert('{{%setting}}', [
            'key' => 'siteDescription',
            'value' => 'A forum, a blog, and a user center.'
        ]);

        $this->createTable('{{%user_data}}', [
            'user_id' => $this->primaryKey(),
            'post_count' => $this->integer()->defaultValue(0),
            'feed_count' => $this->integer()->defaultValue(0),
            'following_count' => $this->integer()->defaultValue(0),
            'follower_count' => $this->integer()->defaultValue(0),
            'unread_notice_count' => $this->integer()->defaultValue(0),
            'unread_message_count' => $this->integer()->defaultValue(0)
        ], $tableOptions);

        $this->createTable('{{%user_follow}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'people_id' => $this->integer()
        ], $tableOptions);

        $this->createTable('{{%user_message}}', [
            'id' => $this->primaryKey(),
            'sendfrom' => $this->integer(),
            'sendto' => $this->integer(),
            'subject' => $this->string(),
            'content' => $this->text(),
            'created_at' => $this->integer(),
            'read_indicator' => $this->smallInteger()->defaultValue(0),
            'inbox' => $this->smallInteger()->defaultValue(1),
            'outbox' => $this->smallInteger()->defaultValue(1),
            'post_id' => $this->integer()
        ], $tableOptions);

        $this->createTable('{{%user_profile}}', [
            'user_id' => $this->integer(),
            'gender' => $this->smallInteger()->defaultValue(0),
            'birthdate' => $this->date(),
            'signature' => $this->string(),
            'address' => $this->string(),
            'description' => $this->string()
        ], $tableOptions);

        $this->createTable('{{%user_notice}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(64),
            'title' => $this->string(),
            'content' => $this->text(),
            'from_user_id' => $this->integer(),
            'to_user_id' => $this->integer(),
            'source_url' => $this->string(),
            'created_at' => $this->integer(),
            'is_read' => $this->smallInteger()
        ], $tableOptions);

        $this->createTable('{{%user_notice_type}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(64),
            'type_title' => $this->string(),
            'type_content' => $this->string()
        ], $tableOptions);

        $this->insert('{{%user_notice_type}}', [
            'type' => 'MENTION_ME',
            'type_title' => 'mentioned you',
            'type_content' => 'Your colleagues {name} just mentioned you in the following content: {content}.<a href="{url}" target="_blank">Go to the website>></a>'
        ]);

        $this->insert('{{%user_notice_type}}', [
            'type' => 'NEW_COMMENT',
            'type_title' => 'comment you {title}',
            'type_content' => 'You received a new comment {content}. <a href="{url}" target="_blank">Go to the website>></a>.'
        ]);

        $this->insert('{{%user_notice_type}}', [
            'type' => 'NEW_MESSAGE',
            'type_title' => 'You received a new message',
            'type_content' => 'You received a new private message.{content}.<a href="{url}" target="_blank">Go to the website>></a>'
        ]);

        $this->insert('{{%user_data}}', [
            'user_id' => self::USER_AUTO_INCREMENT_NUM
        ]);

        $this->insert('{{%user_profile}}', [
            'user_id' => self::USER_AUTO_INCREMENT_NUM
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%comment}}');
        $this->dropTable('{{%forum}}');
        $this->dropTable('{{%forum_board}}');
        $this->dropTable('{{%forum_broadcast}}');
        $this->dropTable('{{%forum_follow}}');
        $this->dropTable('{{%forum_post}}');
        $this->dropTable('{{%forum_thread}}');
        $this->dropTable('{{%home_album}}');
        $this->dropTable('{{%home_photo}}');
        $this->dropTable('{{%home_feed}}');
        $this->dropTable('{{%home_post}}');
        $this->dropTable('{{%setting}}');
        $this->dropTable('{{%user_data}}');
        $this->dropTable('{{%user_follow}}');
        $this->dropTable('{{%user_message}}');
        $this->dropTable('{{%user_profile}}');
        $this->dropTable('{{%user_notice}}');
        $this->dropTable('{{%user_notice_type}}');
    }
}
