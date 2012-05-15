-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2011 年 12 月 01 日 18:53
-- 服务器版本: 5.5.8
-- PHP 版本: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- 数据库: `tellyouw_wfw`
--
CREATE DATABASE `tellyouw_wfw` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `tellyouw_wfw`;

-- --------------------------------------------------------

--
-- 表的结构 `wfw_renren_message`
--

CREATE TABLE IF NOT EXISTS `wfw_renren_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `w_id` int(11) NOT NULL COMMENT '服务器用户id',
  `name` varchar(256) COLLATE utf8_bin NOT NULL COMMENT '人人网用户名',
  `type` varchar(64) COLLATE utf8_bin NOT NULL COMMENT '内容类型',
  `prefix` varchar(64) COLLATE utf8_bin NOT NULL COMMENT '内容前缀',
  `messages` varchar(512) COLLATE utf8_bin NOT NULL COMMENT '内容主题',
  `url` varchar(256) COLLATE utf8_bin NOT NULL COMMENT '分享网址',
  `img` varchar(256) COLLATE utf8_bin NOT NULL COMMENT '图片',
  `addTime` int(11) NOT NULL COMMENT '发表时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=41 ;

--
-- 转存表中的数据 `wfw_renren_message`
--

INSERT INTO `wfw_renren_message` (`id`, `w_id`, `name`, `type`, `prefix`, `messages`, `url`, `img`, `addTime`) VALUES
(34, 1, '', 'statu', '多少。。', '多少。。', '', '', 1322755903),
(35, 1, '', 'photo', '哈哈哈', '哈哈哈', '', 'http://fmn.rrimg.com/fmn057/20111202/0015/p_large_xdC1_3257000468a71263.jpg', 1322756376),
(36, 1, '', 'photo', '飞', '飞', '', 'http://fmn.rrimg.com/fmn062/20111202/0025/p_large_9Ilf_058600055cdc121b.jpg', 1322756842),
(37, 1, '', 'statu', '状态。', '状态。', '', '', 1322761057),
(38, 1, '', 'photo', '匹配', '匹配', '', 'http://fmn.rrimg.com/fmn060/20111202/0135/p_large_VRBQ_7f6f000561b9121c.jpg', 1322761092),
(39, 1, '', 'share', '56流行音乐网-汇聚最新的非主流音乐 2011好听的歌 网络歌曲伤感歌曲等流行音乐排行榜单', '', 'http://www.565656.com/', 'http://www.565656.com/upload/Album/20117619161456710.jpg', 1322761142),
(40, 1, '', 'statu', '万服网测试。(哭)', '万服网测试。(哭)', '', '', 1322763514);

-- --------------------------------------------------------

--
-- 表的结构 `wfw_renren_user`
--

CREATE TABLE IF NOT EXISTS `wfw_renren_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `w_name` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '服务器用户名',
  `w_id` int(11) NOT NULL COMMENT '服务器id',
  `renren_id` int(11) NOT NULL COMMENT '人人网账号id',
  `renren_name` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '人人网账号用户名',
  `access_token` varchar(256) NOT NULL COMMENT 'access_token',
  `refresh_token` varchar(256) NOT NULL COMMENT 'refresh_token',
  `token_insert_time` int(11) NOT NULL COMMENT 'token获取时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `wfw_renren_user`
--

INSERT INTO `wfw_renren_user` (`id`, `w_name`, `w_id`, `renren_id`, `renren_name`, `access_token`, `refresh_token`, `token_insert_time`) VALUES
(1, 'micheal', 1, 363524545, '麦克', '170068|6.c1c26d215dff7071e337ff9525c545c4.2592000.1325354400-363524545', '170068|7.924920f1e755a82a6482d0a2ddba6766.5184000.1327946400-363524545', 1322762002),
(2, 'bryant', 2, 363524545, '麦克', '170068|6.3dd5036efb093fa27a26ed636f383f01.2592000.1325336400-363524545', '170068|7.4365c1f91e3b6f24cf86690ec414ab07.5184000.1327928400-363524545', 1322743567),
(3, '', 0, 0, '', '', '', 0),
(4, '', 0, 0, '', '', '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `wfw_sina_message`
--

CREATE TABLE IF NOT EXISTS `wfw_sina_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `w_id` int(11) NOT NULL COMMENT '服务器用户id',
  `name` varchar(256) NOT NULL COMMENT 'sina微博用户名',
  `messages` varchar(1024) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '微博信息主体',
  `thum_pic` varchar(256) NOT NULL COMMENT '小图片',
  `src_pic` varchar(256) NOT NULL COMMENT '原图',
  `addTime` int(11) NOT NULL COMMENT '发表时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `wfw_sina_message`
--

INSERT INTO `wfw_sina_message` (`id`, `w_id`, `name`, `messages`, `thum_pic`, `src_pic`, `addTime`) VALUES
(6, 1, '', '测试测试。。[吃惊]http://t.cn/SAeVQG', 'http://ww1.sinaimg.cn/thumbnail/6a8403d6jw1dngq9kp8u1j.jpg', '', 0),
(7, 2, '', '很晚了。。', '', '', 0),
(8, 0, '', '可爱。', '', '', 0),
(9, 2, '', '还没睡的孩子。', '', '', 1322680820);

-- --------------------------------------------------------

--
-- 表的结构 `wfw_sina_user`
--

CREATE TABLE IF NOT EXISTS `wfw_sina_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `w_name` varchar(256) NOT NULL COMMENT '服务器用户名',
  `w_id` int(11) NOT NULL COMMENT '服务器id',
  `s_id` int(11) NOT NULL COMMENT '微博账号id',
  `s_name` varchar(256) NOT NULL COMMENT '微博账号用户名',
  `access_token` varchar(256) NOT NULL COMMENT 'access_token',
  `refresh_token` varchar(256) NOT NULL COMMENT 'refresh_token',
  `token_insert_time` int(11) NOT NULL COMMENT 'token获取时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `wfw_sina_user`
--

INSERT INTO `wfw_sina_user` (`id`, `w_name`, `w_id`, `s_id`, `s_name`, `access_token`, `refresh_token`, `token_insert_time`) VALUES
(1, 'jason', 3, 0, '', 'ca2a9554bde9d753f751a80516682822', '', 0),
(9, 'tom', 4, 0, '', 'ca2a9554bde9d753f751a80516682822', '', 1322236397),
(10, 'amy', 5, 0, '', 'ca2a9554bde9d753f751a80516682822', '', 1322237310),
(11, 'micheal', 1, 0, '', '2.009rNwwBpmj8GB67da789bd43ZhsdC', '', 1322752369),
(12, 'bryant', 2, 0, '', '2.009rNwwBpmj8GB67da789bd43ZhsdC', '', 1322680744);

-- --------------------------------------------------------

--
-- 表的结构 `wfw_user`
--

CREATE TABLE IF NOT EXISTS `wfw_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(256) NOT NULL COMMENT '用户名',
  `password` varchar(256) NOT NULL COMMENT '密码',
  `other` varchar(256) NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `wfw_user`
--

INSERT INTO `wfw_user` (`id`, `name`, `password`, `other`) VALUES
(1, 'micheal', '723d505516e0c197e42a6be3c0af910e', ''),
(2, 'bryant', '723d505516e0c197e42a6be3c0af910e', ''),
(3, 'jason', '723d505516e0c197e42a6be3c0af910e', ''),
(4, 'tom', 'e10adc3949ba59abbe56e057f20f883e', ''),
(5, 'amy', 'e10adc3949ba59abbe56e057f20f883e', '');
