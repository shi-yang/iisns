<?php
/**
 * iiSNS installer
 * @author       Shiyang <dr@shiyang.me>
 * @copyright    Copyright © 2015 iiSNS
 * @link         http://www.iisns.com
 */
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

use yii\base\Security;

class Install {
    private $error;
    private $link;
    private $settings = array();
    function __construct() {
        $this->checkInstall($hideError = true);
        if (!empty($_POST)) {
            foreach ($_POST as $key => $value) {
                $this->settings[$key] = $value;
            }
            $this->validate();
        }
        if (!empty($this->error)) echo $this->error;
    }
    // Run queries
    private function query($query) {
        $result = mysql_query($query);
        if (!$result) {
            echo 'Could not run query:' . mysql_error() . '<br/>';
            include_once ('footer.php');
            exit;
        }
        return $result;
    }
    // Check for all form fields to be filled out
    private function validate() {
        if (empty($this->settings['dbHost']) || empty($this->settings['dbUser']) || empty($this->settings['dbName'])
            || empty($this->settings['adminUser']) || empty($this->settings['adminPass']) || empty($this->settings['email'])
            || empty($this->settings['siteName']) || empty($this->settings['siteTitle']) || empty($this->settings['siteDescription'])) {
            $this->error = '<div class="alert alert-danger" role="alert"><strong>Error.</strong> Fill out all the details please</div>';
        }
        if(strlen($this->settings['adminPass']) < 5) {
            $this->error = '<div class="alert alert-danger" role="alert"><strong>Error.</strong> Password must be at least 5 characters.</div>';
        } else {
            $this->settings['adminPass'] = (new Security)->generatePasswordHash($this->settings['adminPass']);
        }
        // Check the database connection
        $this->dbLink();
    }
    // Check if there is a connection to the mysql server
    private function dbLink() {
        if (empty($this->error)) {
            $this->link = @mysql_connect($this->settings['dbHost'], $this->settings['dbUser'], $this->settings['dbPass']);
            if (!$this->link) {
                $this->error = '<div class="alert alert-danger" role="alert"><strong>Error.</strong> Your Database details are incorrect.</div>';
            } else {
                $this->dbSelect();
            }
        }
    }
    // Check for database selection
    private function dbSelect() {
        if (empty($this->error)) {
            $dbSelect = mysql_select_db($this->settings['dbName'], $this->link);
            if (!$dbSelect) {
                $this->error = '<div class="alert alert-danger" role="alert"><strong>Error.</strong> Database name doesn\'t exist!</div>';
            } else {
                $this->existingTables();
            }
        }
    }
    // Check for an existing installation
    private function existingTables() {
        if (empty($this->error)) {
            $this->insertSQL();
            $this->writeFile();
            $this->checkInstall();
        }
    }
    // Insert SQL data
    private function insertSQL() {
        if (empty($this->error)) {
            $now = time();
            $username = $this->settings['adminUser'];
            $password_hash = $this->settings['adminPass'];
            $auth_key = (new Security)->generateRandomString();
            $email = $this->settings['email'];

            $this->query("SET NAMES utf8;");

            $this->query("
      CREATE TABLE IF NOT EXISTS `pre_user` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `username` char(32) NOT NULL,
        `password_hash` char(60) NOT NULL,
        `password_reset_token` char(43) NOT NULL,
        `auth_key` char(32) NOT NULL,
        `role` tinyint(2) NOT NULL,
        `email` char(64) NOT NULL,
        `status` tinyint(2) NOT NULL,
        `created_at` int(10) NOT NULL,
        `updated_at` int(10) NOT NULL,
        `avatar` char(24) NOT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `id` (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10000 ;
    ");
            $this->query("
      INSERT INTO `pre_user` (`id`, `username`, `password_hash`, `auth_key`, `role`, `email`, `status`, `created_at`, `updated_at`, `avatar`) VALUES
      (10000, '{$username}', '{$password_hash}', '{$auth_key}', 10, '{$email}', 10, {$now}, {$now}, 'default/10.jpg');
      ");
            $this->query("
      CREATE TABLE IF NOT EXISTS `pre_setting` (
        `key` varchar(255) NOT NULL,
        `value` text NOT NULL,
        PRIMARY KEY (`key`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");
            $this->query("
      INSERT INTO `pre_setting` (`key`, `value`) VALUES
      ('siteName', '" . $this->settings['siteName'] . "'),
      ('siteTitle', '" . $this->settings['siteTitle'] . "'),
      ('siteDescription', '" . $this->settings['siteDescription'] . "'),
      ('siteKeyword', ''),
      ('thirdPartyStatisticalCode', '');
      ");
            $this->query("
      CREATE TABLE IF NOT EXISTS `pre_auth_assignment` (
        `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
        `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
        `created_at` int(11) DEFAULT NULL,
        PRIMARY KEY (`item_name`,`user_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    ");
            $this->query("
      INSERT INTO `pre_auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
      ('超级管理员', '10000', {$now});
    ");
            $this->query("
      CREATE TABLE IF NOT EXISTS `pre_auth_item` (
        `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
        `type` int(11) NOT NULL,
        `description` text COLLATE utf8_unicode_ci,
        `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
        `data` text COLLATE utf8_unicode_ci,
        `created_at` int(11) DEFAULT NULL,
        `updated_at` int(11) DEFAULT NULL,
        PRIMARY KEY (`name`),
        KEY `rule_name` (`rule_name`),
        KEY `idx-auth_item-type` (`type`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    ");
            $this->query("
      INSERT INTO `pre_auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
      ('/*', 2, NULL, NULL, NULL, {$now}, {$now}),
      ('超级管理员', 1, '拥有最高权限', NULL, NULL, {$now}, {$now});
    ");
            $this->query("
      CREATE TABLE IF NOT EXISTS `pre_auth_item_child` (
        `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
        `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
        PRIMARY KEY (`parent`,`child`),
        KEY `child` (`child`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    ");
            $this->query("
      INSERT INTO `pre_auth_item_child` (`parent`, `child`) VALUES
      ('超级管理员', '/*');
    ");
            $this->query("
      CREATE TABLE IF NOT EXISTS `pre_auth_rule` (
        `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
        `data` text COLLATE utf8_unicode_ci,
        `created_at` int(11) DEFAULT NULL,
        `updated_at` int(11) DEFAULT NULL,
        PRIMARY KEY (`name`)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    ");
            $this->query("
      CREATE TABLE IF NOT EXISTS `pre_explore_recommend` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `title` varchar(128) NOT NULL,
        `summary` text NOT NULL,
        `content` text NOT NULL,
        `view_count` int(11) NOT NULL,
        `user_id` int(11) DEFAULT NULL,
        `origin` varchar(50) NOT NULL COMMENT '来源',
        `username` varchar(60) NOT NULL,
        `category` char(50) NOT NULL,
        `table_id` int(11) DEFAULT NULL,
        `table_name` char(30) NOT NULL,
        `created_at` int(11) NOT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='探索页面的推荐列表' AUTO_INCREMENT=1 ;
    ");
            $this->query("
      CREATE TABLE IF NOT EXISTS `pre_favorite` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `source_id` bigint(20) NOT NULL,
        `source_table_name` varchar(255) NOT NULL,
        `created_at` text NOT NULL,
        `user_id` int(11) NOT NULL,
        PRIMARY KEY (`id`),
        KEY `user_id` (`user_id`),
        KEY `post_id` (`source_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户收藏' AUTO_INCREMENT=1 ;
    ");
            $this->query("
      CREATE TABLE IF NOT EXISTS `pre_forum` (
        `id` int(12) NOT NULL AUTO_INCREMENT,
        `forum_name` char(32) NOT NULL,
        `forum_desc` text NOT NULL,
        `forum_url` char(32) NOT NULL,
        `user_id` int(12) NOT NULL,
        `created_at` int(10) NOT NULL,
        `forum_icon` char(26) NOT NULL,
        PRIMARY KEY (`id`),
        KEY `user_id` (`user_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;
    ");
            $this->query("
      CREATE TABLE IF NOT EXISTS `pre_forum_board` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `parent_id` int(11) NOT NULL DEFAULT '0',
        `name` char(32) NOT NULL,
        `description` varchar(128) NOT NULL,
        `columns` tinyint(4) NOT NULL DEFAULT '1',
        `updated_at` int(10) DEFAULT NULL,
        `updated_by` int(11) NOT NULL,
        `forum_id` int(11) NOT NULL,
        `user_id` int(11) NOT NULL,
        PRIMARY KEY (`id`),
        KEY `forum_id` (`forum_id`),
        KEY `user_id` (`user_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;
    ");
            $this->query("
      CREATE TABLE IF NOT EXISTS `pre_forum_broadcast` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `title` varchar(128) NOT NULL,
        `content` text NOT NULL,
        `forum_id` int(11) NOT NULL,
        `user_id` int(11) NOT NULL,
        `thread_id` int(11) NOT NULL,
        `created_at` int(10) NOT NULL,
        PRIMARY KEY (`id`),
        KEY `user_id` (`user_id`),
        KEY `forum_id` (`forum_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;
    ");
            $this->query("
      CREATE TABLE IF NOT EXISTS `pre_forum_follow` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `forum_id` int(11) NOT NULL,
        `user_id` int(11) NOT NULL,
        PRIMARY KEY (`id`),
        KEY `forum_id` (`forum_id`),
        KEY `user_id` (`user_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
    ");
            $this->query("
      CREATE TABLE IF NOT EXISTS `pre_forum_post` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `content` text NOT NULL,
        `thread_id` int(11) NOT NULL,
        `user_id` int(11) NOT NULL,
        `created_at` int(10) NOT NULL,
        PRIMARY KEY (`id`),
        KEY `user_id` (`user_id`),
        KEY `thread_id` (`thread_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;
    ");
            $this->query("
      CREATE TABLE IF NOT EXISTS `pre_forum_thread` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `title` varchar(255) NOT NULL,
        `content` text NOT NULL,
        `created_at` int(10) NOT NULL,
        `user_id` int(11) NOT NULL,
        `board_id` int(11) NOT NULL,
        `post_count` int(11) NOT NULL,
        `is_broadcast` tinyint(1) NOT NULL,
        PRIMARY KEY (`id`),
        KEY `user_id` (`user_id`),
        KEY `board_id` (`board_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;
    ");
            $this->query("
      CREATE TABLE IF NOT EXISTS `pre_home_album` (
        `id` bigint(20) NOT NULL AUTO_INCREMENT,
        `name` varchar(128) NOT NULL,
        `description` varchar(128) NOT NULL,
        `cover_id` bigint(20) NOT NULL,
        `created_at` int(10) NOT NULL,
        `updated_at` int(10) NOT NULL,
        `created_by` int(11) NOT NULL,
        `enable_comment` tinyint(4) NOT NULL DEFAULT '1',
        `status` tinyint(1) NOT NULL DEFAULT '0',
        `status_password` char(60) NOT NULL,
        `status_question` varchar(255) NOT NULL,
        `status_answer` varchar(255) NOT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;
    ");
            $this->query("
      CREATE TABLE IF NOT EXISTS `pre_home_photo` (
        `id` bigint(20) NOT NULL AUTO_INCREMENT,
        `album_id` bigint(20) NOT NULL,
        `name` varchar(100) NOT NULL COMMENT '图片名称',
        `thumb` varchar(255) NOT NULL,
        `path` varchar(255) NOT NULL COMMENT '文件保存路径',
        `store_name` varchar(255) NOT NULL COMMENT '文件保存的名称',
        `created_at` int(11) NOT NULL,
        `created_by` int(11) NOT NULL,
        `is_cover` tinyint(4) NOT NULL DEFAULT '0',
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;
    ");
            $this->query("
      CREATE TABLE IF NOT EXISTS `pre_home_feed` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `type` char(50) NOT NULL,
        `content` text NOT NULL,
        `template` text NOT NULL,
        `comment_count` int(11) NOT NULL,
        `repost_count` int(11) NOT NULL,
        `feed_data` text NOT NULL,
        `user_id` int(11) NOT NULL,
        `created_at` int(11) NOT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;
    ");
            $this->query("
      CREATE TABLE IF NOT EXISTS `pre_home_post` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `title` varchar(128) NOT NULL,
        `content` text NOT NULL,
        `tags` text NOT NULL,
        `user_id` int(11) NOT NULL,
        `created_at` int(11) NOT NULL,
        `updated_at` int(11) NOT NULL,
        PRIMARY KEY (`id`),
        KEY `user_id` (`user_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;
    ");
            $this->query("
      CREATE TABLE IF NOT EXISTS `pre_user_data` (
        `user_id` int(11) NOT NULL AUTO_INCREMENT,
        `post_count` int(11) NOT NULL,
        `feed_count` int(11) NOT NULL,
        `following_count` int(11) NOT NULL,
        `follower_count` int(11) NOT NULL,
        `unread_comment_count` int(11) NOT NULL,
        `unread_message_count` int(11) NOT NULL,
        PRIMARY KEY (`user_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10000 ;
    ");
            $this->query("
      INSERT INTO `pre_user_data` (`user_id`) VALUES
      (10000);
    ");
            $this->query("
      CREATE TABLE IF NOT EXISTS `pre_user_follow` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` int(11) NOT NULL,
        `people_id` int(11) NOT NULL,
        PRIMARY KEY (`id`),
        KEY `user_id` (`user_id`),
        KEY `people_id` (`people_id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
    ");
            $this->query("
      CREATE TABLE IF NOT EXISTS `pre_user_message` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `sendfrom` int(11) NOT NULL,
        `sendto` int(11) NOT NULL,
        `subject` varchar(255) NOT NULL,
        `content` text NOT NULL,
        `created_at` int(10) NOT NULL,
        `read_indicator` tinyint(1) NOT NULL DEFAULT '0',
        `inbox` tinyint(1) NOT NULL DEFAULT '1',
        `outbox` tinyint(1) NOT NULL DEFAULT '1',
        `post_id` int(11) NOT NULL,
        PRIMARY KEY (`id`),
        KEY `sendfrom` (`sendfrom`),
        KEY `sendto` (`sendto`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
    ");
            $this->query("
      CREATE TABLE IF NOT EXISTS `pre_user_profile` (
        `user_id` int(11) NOT NULL,
        `gender` tinyint(1) NOT NULL,
        `birthdate` date DEFAULT NULL,
        `signature` varchar(120) NOT NULL,
        `address` text NOT NULL,
        `description` text NOT NULL,
        PRIMARY KEY (`user_id`),
        KEY `user_id` (`user_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");
            $this->query("
      INSERT INTO `pre_user_profile` (`user_id`) VALUES
      (10000);
    ");
            $this->query("
      ALTER TABLE `pre_auth_assignment`
      ADD CONSTRAINT `pre_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `pre_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;
      ");
            $this->query("
      ALTER TABLE `pre_auth_item`
      ADD CONSTRAINT `pre_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `pre_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;
      ");
            $this->query("
      ALTER TABLE `pre_auth_item_child`
      ADD CONSTRAINT `pre_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `pre_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
      ADD CONSTRAINT `pre_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `pre_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;
      ");
            $this->query("
      ALTER TABLE `pre_forum`
      ADD CONSTRAINT `pre_forum_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
      ");
            $this->query("
      ALTER TABLE `pre_forum_board`
      ADD CONSTRAINT `pre_forum_board_ibfk_3` FOREIGN KEY (`forum_id`) REFERENCES `pre_forum` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
      ADD CONSTRAINT `pre_forum_board_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
      ");
            $this->query("
      ALTER TABLE `pre_forum_broadcast`
      ADD CONSTRAINT `pre_forum_broadcast_ibfk_1` FOREIGN KEY (`forum_id`) REFERENCES `pre_forum` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
      ADD CONSTRAINT `pre_forum_broadcast_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
      ");
            $this->query("
      ALTER TABLE `pre_forum_follow`
      ADD CONSTRAINT `pre_forum_follow_ibfk_1` FOREIGN KEY (`forum_id`) REFERENCES `pre_forum` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
      ADD CONSTRAINT `pre_forum_follow_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
      ");
            $this->query("
      ALTER TABLE `pre_forum_post`
      ADD CONSTRAINT `pre_forum_post_ibfk_1` FOREIGN KEY (`thread_id`) REFERENCES `pre_forum_thread` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
      ADD CONSTRAINT `pre_forum_post_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
      ");
            $this->query("
      ALTER TABLE `pre_forum_thread`
      ADD CONSTRAINT `pre_forum_thread_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
      ADD CONSTRAINT `pre_forum_thread_ibfk_3` FOREIGN KEY (`board_id`) REFERENCES `pre_forum_board` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
      ");
            $this->query("
      ALTER TABLE `pre_home_post`
      ADD CONSTRAINT `pre_home_post_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
      ");
            $this->query("
      ALTER TABLE `pre_user_follow`
      ADD CONSTRAINT `pre_user_follow_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
      ADD CONSTRAINT `pre_user_follow_ibfk_4` FOREIGN KEY (`people_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
      ");
            $this->query("
      ALTER TABLE `pre_user_message`
      ADD CONSTRAINT `pre_user_message_ibfk_3` FOREIGN KEY (`sendfrom`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
      ADD CONSTRAINT `pre_user_message_ibfk_4` FOREIGN KEY (`sendto`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
      ");
            $this->query("
      ALTER TABLE `pre_user_profile`
      ADD CONSTRAINT `pre_user_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
      ");
        } else $this->error = 'Your tables already exist! I won\'t insert anything.';
    }
    private function writeFile() {
        if ($this->error == '') {
            /** Write db.php if it doesn't exist */
            $fp = @fopen("../common/config/db.php", "w");
            if (!$fp):
                echo '<div class="alert alert-warning">Could not create <code>common/config/db.php</code>, please confirm you have permission to create the file.</div>';
                return false;
            endif;
            fwrite($fp, "<?php
////////////////////
// This file contains the database access information. 
// This file is needed to establish a connection to MySQL
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host={$this->settings['dbHost']};dbname={$this->settings['dbName']}',
    'username' => '{$this->settings['dbUser']}',
    'password' => '{$this->settings['dbPass']}',
    'tablePrefix' => 'pre_',
    'enableSchemaCache' => true //No need to modify
];
      ");
            fclose($fp);
        }
    }
    private function checkInstall($hideError = false) {
        if (file_exists('../common/config/db.php')):
            echo '
  <div class="progress">
    <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
      Success.
    </div>
  </div>
  <div class="row-fluid">
    <div class="span8">
      <div class="alert alert-success"><strong>Success!</strong> Installation is completed </div>
      <p class="bg-warning">Delete or rename the install folder to prevent security risk.</p>
    </div>
  </div>
  ';
            include ('footer.php');
            exit();
        else:
            if (!$hideError) $this->error = '<div class="alert alert-error">Installation is not complete.</div>';
        endif;
    }
}
