SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE TABLE IF NOT EXISTS `pre_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) NOT NULL  DEFAULT '0',
  `auth_key` varchar(32) NOT NULL,
  `role` tinyint(2) NOT NULL,
  `email` char(64) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `created_at` int(10) NOT NULL,
  `updated_at` int(10) NOT NULL,
  `avatar` char(24) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10000 ;

CREATE TABLE IF NOT EXISTS `pre_auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `pre_auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `pre_auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `pre_auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `pre_comment` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `entity` char(8) NOT NULL,
  `entity_id` bigint(20) NOT NULL,
  `content` text NOT NULL,
  `parent_id` bigint(20) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `created_at` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `pre_forum` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `forum_name` char(32) NOT NULL,
  `forum_desc` text NOT NULL,
  `forum_url` char(32) NOT NULL,
  `user_id` int(12) NOT NULL,
  `created_at` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `forum_icon` char(26) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;

CREATE TABLE IF NOT EXISTS `pre_forum_board` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` char(32) NOT NULL,
  `description` varchar(128) DEFAULT NULL,
  `columns` tinyint(4) NOT NULL DEFAULT '1',
  `updated_at` int(10) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `forum_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `forum_id` (`forum_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;

CREATE TABLE IF NOT EXISTS `pre_forum_broadcast` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `content` text NOT NULL,
  `forum_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `thread_id` int(11) DEFAULT NULL,
  `created_at` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `forum_id` (`forum_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;

CREATE TABLE IF NOT EXISTS `pre_forum_follow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `forum_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `forum_id` (`forum_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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

CREATE TABLE IF NOT EXISTS `pre_forum_thread` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` int(10) NOT NULL,
  `updated_at` int(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `board_id` int(11) NOT NULL,
  `post_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `board_id` (`board_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;

CREATE TABLE IF NOT EXISTS `pre_home_album` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `description` varchar(128) DEFAULT NULL,
  `cover_id` bigint(20) DEFAULT NULL,
  `created_at` int(10) NOT NULL,
  `updated_at` int(10) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `enable_comment` tinyint(4) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `status_password` char(60) DEFAULT NULL,
  `status_question` varchar(255) DEFAULT NULL,
  `status_answer` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;

CREATE TABLE IF NOT EXISTS `pre_home_photo` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `album_id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL COMMENT '图片名称',
  `thumb` varchar(255) DEFAULT NULL,
  `path` varchar(255) NOT NULL COMMENT '文件保存路径',
  `store_name` varchar(255) NOT NULL COMMENT '文件保存的名称',
  `created_at` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `is_cover` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;

CREATE TABLE IF NOT EXISTS `pre_home_feed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` char(50) NOT NULL,
  `content` text DEFAULT NULL,
  `template` text DEFAULT NULL,
  `comment_count` int(11) NOT NULL DEFAULT '0',
  `repost_count` int(11) NOT NULL DEFAULT '0',
  `feed_data` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;

CREATE TABLE IF NOT EXISTS `pre_home_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `content` text NOT NULL,
  `markdown` text DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `status` char(10) NOT NULL,
  `explore_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;

CREATE TABLE IF NOT EXISTS `pre_setting` (
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `pre_setting` (`key`, `value`) VALUES
('statisticsCode', ''),
('siteKeyword', '');

CREATE TABLE IF NOT EXISTS `pre_user_data` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_count` int(11) NOT NULL DEFAULT '0',
  `feed_count` int(11) NOT NULL DEFAULT '0',
  `following_count` int(11) NOT NULL DEFAULT '0',
  `follower_count` int(11) NOT NULL DEFAULT '0',
  `unread_notice_count` int(11) NOT NULL DEFAULT '0',
  `unread_message_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10000 ;

CREATE TABLE IF NOT EXISTS `pre_user_follow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `people_id` (`people_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
  `post_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sendfrom` (`sendfrom`),
  KEY `sendto` (`sendto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `pre_user_profile` (
  `user_id` int(11) NOT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT '0',
  `birthdate` date DEFAULT NULL,
  `signature` varchar(120) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `pre_user_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `source_url` varchar(255) NOT NULL COMMENT '来源链接，序列化数组',
  `created_at` int(10) NOT NULL,
  `is_read` tinyint(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='消息提示通知';

CREATE TABLE IF NOT EXISTS `pre_user_notice_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `type_title` varchar(255) NOT NULL,
  `type_content` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

INSERT INTO `pre_user_notice_type` (`id`, `type`, `type_title`, `type_content`) VALUES
(1, 'MENTION_ME', 'mentioned you', 'Your colleagues {name} just mentioned you in the following content: {content}.<a href="{url}" target="_blank">Go to the website>></a>'),
(2, 'NEW_COMMENT', 'comment you {title}', 'You received a new comment {content}. <a href="{url}" target="_blank">Go to the website>></a>.'),
(3, 'NEW_MESSAGE', 'You received a new message', 'You received a new private message.{content}.<a href="{url}" target="_blank">Go to the website>></a>');


ALTER TABLE `pre_auth_assignment`
  ADD CONSTRAINT `pre_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `pre_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `pre_auth_item`
ADD CONSTRAINT `pre_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `pre_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `pre_auth_item_child`
ADD CONSTRAINT `pre_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `pre_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `pre_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `pre_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `pre_forum`
  ADD CONSTRAINT `pre_forum_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `pre_forum_board`
  ADD CONSTRAINT `pre_forum_board_ibfk_3` FOREIGN KEY (`forum_id`) REFERENCES `pre_forum` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pre_forum_board_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `pre_forum_broadcast`
  ADD CONSTRAINT `pre_forum_broadcast_ibfk_1` FOREIGN KEY (`forum_id`) REFERENCES `pre_forum` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pre_forum_broadcast_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `pre_forum_follow`
  ADD CONSTRAINT `pre_forum_follow_ibfk_1` FOREIGN KEY (`forum_id`) REFERENCES `pre_forum` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pre_forum_follow_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `pre_forum_post`
  ADD CONSTRAINT `pre_forum_post_ibfk_1` FOREIGN KEY (`thread_id`) REFERENCES `pre_forum_thread` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pre_forum_post_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `pre_forum_thread`
  ADD CONSTRAINT `pre_forum_thread_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pre_forum_thread_ibfk_3` FOREIGN KEY (`board_id`) REFERENCES `pre_forum_board` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `pre_home_post`
  ADD CONSTRAINT `pre_home_post_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `pre_user_follow`
  ADD CONSTRAINT `pre_user_follow_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pre_user_follow_ibfk_4` FOREIGN KEY (`people_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `pre_user_message`
  ADD CONSTRAINT `pre_user_message_ibfk_3` FOREIGN KEY (`sendfrom`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pre_user_message_ibfk_4` FOREIGN KEY (`sendto`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `pre_user_profile`
  ADD CONSTRAINT `pre_user_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
