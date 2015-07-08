SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `iisns`
--

-- --------------------------------------------------------

--
-- 表的结构 `pre_favorite`
--

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

--
-- 表的结构 `pre_forum`
--

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

--
-- 表的结构 `pre_forum_board`
--

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

--
-- 表的结构 `pre_forum_broadcast`
--

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

-- --------------------------------------------------------

--
-- 表的结构 `pre_forum_follow`
--

CREATE TABLE IF NOT EXISTS `pre_forum_follow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `forum_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `forum_id` (`forum_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `pre_forum_post`
--

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

--
-- 表的结构 `pre_forum_thread`
--

CREATE TABLE IF NOT EXISTS `pre_forum_thread` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` int(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `board_id` int(11) NOT NULL,
  `is_broadcast` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `board_id` (`board_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;

--
-- 表的结构 `pre_home_album`
--

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

--
-- 表的结构 `pre_home_photo`
--

CREATE TABLE IF NOT EXISTS `pre_home_photo` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `album_id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `created_at` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `is_cover` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;

--
-- 表的结构 `pre_home_feed`
--

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

--
-- 表的结构 `pre_home_post`
--

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

--
-- 表的结构 `pre_settings`
--

CREATE TABLE IF NOT EXISTS `pre_settings` (
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `pre_settings`
--

INSERT INTO `pre_settings` (`key`, `value`) VALUES
('siteDescription', 'A forum, a blog, and a user center.'),
('siteKeyword', 'iiSNS - Global village entrance'),
('siteName', 'iiSNS'),
('siteTitle', 'iiSNS - Global village entrance');

-- --------------------------------------------------------

--
-- 表的结构 `pre_user`
--

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

--
-- 表的结构 `pre_user_data`
--

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

--
-- 表的结构 `pre_user_follow`
--

CREATE TABLE IF NOT EXISTS `pre_user_follow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `people_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `people_id` (`people_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `pre_user_message`
--

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

--
-- 表的结构 `pre_user_profile`
--

CREATE TABLE IF NOT EXISTS `pre_user_profile` (
  `user_id` int(11) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `birthdate` date NOT NULL,
  `signature` varchar(120) NOT NULL,
  `address` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 限制导出的表
--

--
-- 限制表 `pre_forum`
--
ALTER TABLE `pre_forum`
  ADD CONSTRAINT `pre_forum_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `pre_forum_board`
--
ALTER TABLE `pre_forum_board`
  ADD CONSTRAINT `pre_forum_board_ibfk_3` FOREIGN KEY (`forum_id`) REFERENCES `pre_forum` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pre_forum_board_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `pre_forum_broadcast`
--
ALTER TABLE `pre_forum_broadcast`
  ADD CONSTRAINT `pre_forum_broadcast_ibfk_1` FOREIGN KEY (`forum_id`) REFERENCES `pre_forum` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pre_forum_broadcast_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `pre_forum_follow`
--
ALTER TABLE `pre_forum_follow`
  ADD CONSTRAINT `pre_forum_follow_ibfk_1` FOREIGN KEY (`forum_id`) REFERENCES `pre_forum` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pre_forum_follow_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `pre_forum_post`
--
ALTER TABLE `pre_forum_post`
  ADD CONSTRAINT `pre_forum_post_ibfk_1` FOREIGN KEY (`thread_id`) REFERENCES `pre_forum_thread` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pre_forum_post_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `pre_forum_thread`
--
ALTER TABLE `pre_forum_thread`
  ADD CONSTRAINT `pre_forum_thread_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pre_forum_thread_ibfk_3` FOREIGN KEY (`board_id`) REFERENCES `pre_forum_board` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `pre_home_post`
--
ALTER TABLE `pre_home_post`
  ADD CONSTRAINT `pre_home_post_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `pre_user_follow`
--
ALTER TABLE `pre_user_follow`
  ADD CONSTRAINT `pre_user_follow_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pre_user_follow_ibfk_4` FOREIGN KEY (`people_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `pre_user_message`
--
ALTER TABLE `pre_user_message`
  ADD CONSTRAINT `pre_user_message_ibfk_3` FOREIGN KEY (`sendfrom`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pre_user_message_ibfk_4` FOREIGN KEY (`sendto`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `pre_user_profile`
--
ALTER TABLE `pre_user_profile`
  ADD CONSTRAINT `pre_user_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `pre_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
