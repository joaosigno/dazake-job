-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2011 年 12 月 09 日 05:19
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
-- 表的结构 `wfw_happy_message`
--

CREATE TABLE IF NOT EXISTS `wfw_happy_message` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `wfw_happy_message`
--


-- --------------------------------------------------------

--
-- 表的结构 `wfw_happy_user`
--

CREATE TABLE IF NOT EXISTS `wfw_happy_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `w_id` int(11) NOT NULL COMMENT '服务器id',
  `happy_id` int(11) NOT NULL COMMENT '人人网账号id',
  `happy_name` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '人人网账号用户名',
  `access_token` varchar(256) NOT NULL COMMENT 'access_token',
  `refresh_token` varchar(256) NOT NULL COMMENT 'refresh_token',
  `token_insert_time` int(11) NOT NULL COMMENT 'token获取时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `wfw_happy_user`
--

INSERT INTO `wfw_happy_user` (`id`, `w_id`, `happy_id`, `happy_name`, `access_token`, `refresh_token`, `token_insert_time`) VALUES
(6, 1, 0, '', '38918513_ec5a75be663439ab24882456c8292601', '38918513_815d90affc2c15d8188573c8e44b7641', 1323405458);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=58 ;

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
(40, 1, '', 'statu', '万服网测试。(哭)', '万服网测试。(哭)', '', '', 1322763514),
(41, 1, '', 'photo', '图片。。', '图片。。', '', 'http://fmn.rrimg.com/fmn065/20111202/1825/p_large_wzej_070300058a1a121a.jpg', 1322821740),
(42, 1, '', 'share', '56视频 - 视频列表', '56视频。', 'http://video.56.com/', '', 1322828363),
(43, 1, '', 'photo', '有擦。。', '有擦。。', '', 'http://fmn.rrimg.com/fmn062/20111202/2020/p_large_0X50_3238000482b51263.jpg', 1322828749),
(44, 1, '', 'photo', 'micheal啦啦啦。', 'micheal啦啦啦。', '', 'http://fmn.rrimg.com/fmn065/20111202/2025/p_large_6T7f_324c000482871263.jpg', 1322828798),
(45, 1, '', 'statu', '这一次。(淘气)', '这一次。(淘气)', '', '', 1323250684),
(46, 1, '', 'photo', '嗯。', '嗯。', '', 'http://fmn.rrimg.com/fmn060/20111207/1745/p_large_mjLy_7f730006ccb4121c.jpg', 1323251339),
(47, 1, '', 'photo', 'tyy', 'tyy', '', 'http://fmn.rrimg.com/fmn064/20111207/1830/p_large_e0j2_25ac000041181262.jpg', 1323253897),
(48, 1, '', 'photo', '弹弹堂', '弹弹堂', '', 'http://fmn.rrfmn.com/fmn058/20111207/1835/p_large_UeBt_07000006ca4e121a.jpg', 1323254376),
(49, 1, '', 'photo', 'fff', 'fff', '', 'http://fmn.rrimg.com/fmn061/20111207/1845/p_large_vDo0_5275000041e41263.jpg', 1323254867),
(50, 1, '', 'photo', 'pingguo .', 'pingguo .', '', 'http://fmn.rrimg.com/fmn062/20111207/1845/p_large_g8Wn_07000006cada121a.jpg', 1323254925),
(51, 1, '', 'photo', 'duoshao', 'duoshao', '', 'http://fmn.rrimg.com/fmn063/20111207/1845/p_large_uy8m_7f740006cd70121c.jpg', 1323254972),
(52, 1, '', 'photo', '', '', '', 'http://fmn.rrimg.com/fmn056/20111207/1850/p_large_kLBQ_057e0006d0d5121b.jpg', 1323255056),
(53, 1, '', 'statu', '嗯多少png轮毂测完后。(害羞)', '嗯多少png轮毂测完后。(害羞)', '', '', 1323255251),
(54, 1, '', 'photo', '热火。', '热火。', '', 'http://fmn.rrimg.com/fmn057/20111207/1855/p_large_IRWM_1aa80000423f1261.jpg', 1323255352),
(55, 1, '', 'share', '56娱乐快报：吴卓羲微博惊现张馨予床照，网友暗讽心机女博出位', '56', 'http://www.56.com/u65/v_NjUxNzU0OTQ.html', 'http://img.v19.56.com/images/27/27/yulekuaibao56i56olo56i56.com_132324895954hd.jpg?j=93576', 1323255454),
(56, 1, '', 'statu', '发发状态。(叹气)', '发发状态。(叹气)', '', '', 1323257038),
(57, 1, '', 'photo', '一个图片。', '一个图片。', '', 'http://fmn.rrimg.com/fmn062/20111207/1920/p_large_3Xft_7f6e0006d05a121c.jpg', 1323257075);

-- --------------------------------------------------------

--
-- 表的结构 `wfw_renren_user`
--

CREATE TABLE IF NOT EXISTS `wfw_renren_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `w_id` int(11) NOT NULL COMMENT '服务器id',
  `renren_id` int(11) NOT NULL COMMENT '人人网账号id',
  `renren_name` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '人人网账号用户名',
  `access_token` varchar(256) NOT NULL COMMENT 'access_token',
  `refresh_token` varchar(256) NOT NULL COMMENT 'refresh_token',
  `token_insert_time` int(11) NOT NULL COMMENT 'token获取时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `wfw_renren_user`
--

INSERT INTO `wfw_renren_user` (`id`, `w_id`, `renren_id`, `renren_name`, `access_token`, `refresh_token`, `token_insert_time`) VALUES
(5, 1, 363524545, '麦克', '38918513_313546543c5ab9e035b0a5327280e2cd', '38918513_6b75a17a7f6d9da5e0f35d760f9e45df', 1323405291);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- 转存表中的数据 `wfw_sina_message`
--

INSERT INTO `wfw_sina_message` (`id`, `w_id`, `name`, `messages`, `thum_pic`, `src_pic`, `addTime`) VALUES
(6, 1, '', '测试测试。。[吃惊]http://t.cn/SAeVQG', 'http://ww1.sinaimg.cn/thumbnail/6a8403d6jw1dngq9kp8u1j.jpg', '', 0),
(7, 2, '', '很晚了。。', '', '', 0),
(8, 0, '', '可爱。', '', '', 0),
(9, 2, '', '还没睡的孩子。', '', '', 1322680820),
(10, 1, '', 'Micheal', 'http://ww1.sinaimg.cn/thumbnail/6a8403d6jw1dnod35qbv8j.jpg', '', 1322817125),
(11, 1, '', '', '', '', 1322817202),
(12, 1, '', 'micheal tooo. ..', 'http://ww4.sinaimg.cn/thumbnail/6a8403d6jw1dnod4wvxd7j.jpg', 'http://ww4.sinaimg.cn/large/6a8403d6jw1dnod4wvxd7j.jpg', 1322817225),
(13, 1, '', '苹果。。', 'http://ww2.sinaimg.cn/thumbnail/6a8403d6jw1dnodb9q5hhj.jpg', 'http://ww2.sinaimg.cn/large/6a8403d6jw1dnodb9q5hhj.jpg', 1322817594),
(14, 1, '', '提醒大家。快要吃饭拉。', 'http://ww4.sinaimg.cn/thumbnail/6a8403d6jw1dnodtt6wgwj.jpg', 'http://ww4.sinaimg.cn/large/6a8403d6jw1dnodtt6wgwj.jpg', 1322818600),
(15, 2, '', '视频发布。http://t.cn/SbxR44', '', '', 1322820552),
(16, 2, '', '[礼物]新年快乐。', 'nacheal', '', 1322821204),
(17, 2, 'nacheal', '继续。。。尝试看看。', '', '', 1322821240),
(18, 1, 'nacheal', '密码', 'http://ww4.sinaimg.cn/thumbnail/6a8403d6jw1dnog52gbbdj.jpg', 'http://ww4.sinaimg.cn/large/6a8403d6jw1dnog52gbbdj.jpg', 1322823413),
(19, 1, 'nacheal', '放飞', 'http://ww4.sinaimg.cn/thumbnail/6a8403d6jw1dnoghianl9j.jpg', 'http://ww4.sinaimg.cn/large/6a8403d6jw1dnoghianl9j.jpg', 1322824133),
(20, 1, 'nacheal', '方法', 'http://ww4.sinaimg.cn/thumbnail/6a8403d6jw1dnogkotutaj.jpg', 'http://ww4.sinaimg.cn/large/6a8403d6jw1dnogkotutaj.jpg', 1322824316),
(21, 1, '', '', '', '', 1322824396),
(22, 1, 'nacheal', '可爱的人人', 'http://ww1.sinaimg.cn/thumbnail/6a8403d6jw1dnogmlkg4xj.jpg', 'http://ww1.sinaimg.cn/large/6a8403d6jw1dnogmlkg4xj.jpg', 1322824427),
(23, 2, 'nacheal', '[呵呵]开心。', 'http://ww2.sinaimg.cn/thumbnail/6a8403d6jw1dnqu6d9nlqj.jpg', 'http://ww2.sinaimg.cn/large/6a8403d6jw1dnqu6d9nlqj.jpg', 1323002033);

-- --------------------------------------------------------

--
-- 表的结构 `wfw_sina_user`
--

CREATE TABLE IF NOT EXISTS `wfw_sina_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `w_id` int(11) NOT NULL COMMENT '服务器id',
  `s_id` int(11) NOT NULL COMMENT '微博账号id',
  `access_token` varchar(256) NOT NULL COMMENT 'access_token',
  `refresh_token` varchar(256) NOT NULL COMMENT 'refresh_token',
  `token_insert_time` int(11) NOT NULL COMMENT 'token获取时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- 转存表中的数据 `wfw_sina_user`
--

INSERT INTO `wfw_sina_user` (`id`, `w_id`, `s_id`, `access_token`, `refresh_token`, `token_insert_time`) VALUES
(14, 1, 0, '', '', 0),
(15, 2, 0, '2.009rNwwBpmj8GBc913763e93vXCwFD', '', 1323001949);

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
