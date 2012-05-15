-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 01 月 16 日 10:41
-- 服务器版本: 5.5.8
-- PHP 版本: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- 数据库: `chatlog`
--
CREATE DATABASE `chatlog` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `chatlog`;

-- --------------------------------------------------------

--
-- 表的结构 `chatlog_account`
--

CREATE TABLE IF NOT EXISTS `chatlog_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '账号id',
  `username` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '用户名',
  `password` varchar(128) NOT NULL COMMENT '密码',
  `time` int(11) NOT NULL COMMENT '加入时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `chatlog_account`
--

INSERT INTO `chatlog_account` (`id`, `username`, `password`, `time`) VALUES
(1, 'micheal', 'b78d7cd4555821042a70d9ec034b0dea', 1326709100),
(2, 'bryant', 'e5b79bbdb797144a4cbf576aef22f492', 1326709369);

-- --------------------------------------------------------

--
-- 表的结构 `chatlog_friend`
--

CREATE TABLE IF NOT EXISTS `chatlog_friend` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '朋友关系id',
  `parentusername` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '所属用户名',
  `fromname` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '主用户用户名',
  `toname` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '加好友用户名',
  `time` int(11) NOT NULL COMMENT '成为好友时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `chatlog_friend`
--

INSERT INTO `chatlog_friend` (`id`, `parentusername`, `fromname`, `toname`, `time`) VALUES
(1, 'micheal', '234707623', '494111327', 1326709100),
(2, 'bryant', '456789', '123456', 1326709369),
(3, 'micheal', '345678', '1234567', 1326709428),
(4, 'micheal', '234707623', '2342599', 1326709521);

-- --------------------------------------------------------

--
-- 表的结构 `chatlog_message`
--

CREATE TABLE IF NOT EXISTS `chatlog_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '聊天记录id',
  `parentusername` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '所属用户名',
  `fromname` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '信息发起用户id',
  `toname` int(128) NOT NULL COMMENT '信息接收用户id',
  `flag` int(32) NOT NULL COMMENT '为真时主用户fromname对从用户说',
  `message` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '聊天记录内容',
  `time` int(11) NOT NULL COMMENT '记录插入时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=104 ;

--
-- 转存表中的数据 `chatlog_message`
--

INSERT INTO `chatlog_message` (`id`, `parentusername`, `fromname`, `toname`, `flag`, `message`, `time`) VALUES
(1, 'micheal', '234707623', 494111327, 1, 'michealqq和bryantqq聊天', 1326709135),
(2, 'micheal', '234707623', 494111327, 1, 'michealqq和bryantqq聊天', 1326709136),
(3, 'micheal', '234707623', 494111327, 1, 'michealqq和bryantqq聊天', 1326709137),
(4, 'micheal', '234707623', 494111327, 1, 'michealqq和bryantqq聊天', 1326709139),
(5, 'micheal', '234707623', 494111327, 1, 'michealqq和bryantqq聊天', 1326709139),
(6, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709157),
(7, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709158),
(8, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709159),
(9, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709160),
(10, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709160),
(11, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709161),
(12, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709161),
(13, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709162),
(14, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709162),
(15, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709163),
(16, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709163),
(17, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709164),
(18, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709164),
(19, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709165),
(20, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709170),
(21, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709171),
(22, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709172),
(23, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709173),
(24, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709175),
(25, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709175),
(26, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709176),
(27, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709176),
(28, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709177),
(29, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709178),
(30, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709178),
(31, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709280),
(32, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709282),
(33, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709283),
(34, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709284),
(35, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709284),
(36, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709285),
(37, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709286),
(38, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709287),
(39, 'micheal', '234707623', 494111327, 0, 'michealqq和bryantqq聊天', 1326709287),
(40, 'bryant', '456789', 123456, 0, '继续聊天内容', 1326709369),
(41, 'bryant', '456789', 123456, 0, '继续聊天内容', 1326709370),
(42, 'bryant', '456789', 123456, 0, '继续聊天内容', 1326709371),
(43, 'bryant', '456789', 123456, 0, '继续聊天内容', 1326709372),
(44, 'bryant', '456789', 123456, 0, '继续聊天内容', 1326709373),
(45, 'bryant', '456789', 123456, 0, '继续聊天内容', 1326709373),
(46, 'bryant', '456789', 123456, 0, '继续聊天内容', 1326709374),
(47, 'bryant', '456789', 123456, 0, '继续聊天内容', 1326709374),
(48, 'bryant', '456789', 123456, 0, '继续聊天内容', 1326709386),
(49, 'bryant', '456789', 123456, 0, '继续聊天内容', 1326709387),
(50, 'bryant', '456789', 123456, 0, '继续聊天内容', 1326709388),
(51, 'micheal', '345678', 1234567, 1, '继续聊天内容', 1326709428),
(52, 'micheal', '345678', 1234567, 1, '继续聊天内容', 1326709431),
(53, 'micheal', '345678', 1234567, 1, '继续聊天内容', 1326709432),
(54, 'micheal', '345678', 1234567, 1, '继续聊天内容', 1326709433),
(55, 'micheal', '345678', 1234567, 1, '继续聊天内容', 1326709434),
(56, 'micheal', '345678', 1234567, 1, '继续聊天内容', 1326709434),
(57, 'micheal', '345678', 1234567, 1, '继续聊天内容', 1326709435),
(58, 'micheal', '345678', 1234567, 1, '继续聊天内容', 1326709439),
(59, 'micheal', '345678', 1234567, 1, '继续聊天内容', 1326709440),
(60, 'micheal', '345678', 1234567, 1, '继续聊天内容', 1326709441),
(61, 'micheal', '345678', 1234567, 1, '继续聊天内容', 1326709443),
(62, 'micheal', '345678', 1234567, 1, '继续聊天内容', 1326709444),
(63, 'micheal', '345678', 1234567, 1, '继续聊天内容', 1326709445),
(64, 'micheal', '345678', 1234567, 1, '继续聊天内容', 1326709446),
(65, 'micheal', '345678', 1234567, 1, '继续聊天内容', 1326709447),
(66, 'micheal', '345678', 1234567, 1, '继续聊天内容', 1326709448),
(67, 'micheal', '345678', 1234567, 1, '继续聊天内容', 1326709449),
(68, 'micheal', '345678', 1234567, 1, '继续聊天内容', 1326709450),
(69, 'micheal', '345678', 1234567, 1, '继续聊天内容', 1326709451),
(70, 'micheal', '345678', 1234567, 1, '继续聊天内容', 1326709452),
(71, 'micheal', '345678', 1234567, 1, '继续聊天内容', 1326709453),
(72, 'micheal', '345678', 1234567, 1, '继续聊天内容', 1326709454),
(73, 'micheal', '345678', 1234567, 1, '继续聊天内容', 1326709454),
(74, 'micheal', '345678', 1234567, 1, '继续聊天内容', 1326709455),
(75, 'micheal', '345678', 1234567, 1, '继续聊天内容', 1326709456),
(76, 'micheal', '345678', 1234567, 1, '继续聊天内容', 1326709457),
(77, 'micheal', '345678', 1234567, 1, '继续聊天内容', 1326709458),
(78, 'micheal', '234707623', 2342599, 1, '234707623与2342599', 1326709521),
(79, 'micheal', '234707623', 2342599, 1, '234707623与2342599', 1326709522),
(80, 'micheal', '234707623', 2342599, 1, '234707623与2342599', 1326709523),
(81, 'micheal', '234707623', 2342599, 1, '234707623与2342599', 1326709524),
(82, 'micheal', '234707623', 2342599, 1, '234707623与2342599', 1326709525),
(83, 'micheal', '234707623', 2342599, 1, '234707623与2342599', 1326709526),
(84, 'micheal', '234707623', 2342599, 1, '234707623与2342599', 1326709526),
(85, 'micheal', '234707623', 2342599, 1, '234707623与2342599', 1326709527),
(86, 'micheal', '234707623', 2342599, 1, '234707623与2342599', 1326709528),
(87, 'micheal', '234707623', 2342599, 1, '234707623与2342599', 1326709528),
(88, 'micheal', '234707623', 2342599, 1, '234707623与2342599', 1326709529),
(89, 'micheal', '234707623', 2342599, 1, '234707623与2342599', 1326709530),
(90, 'micheal', '234707623', 2342599, 1, '234707623与2342599', 1326709530),
(91, 'micheal', '234707623', 2342599, 0, '234707623与2342599', 1326709539),
(92, 'micheal', '234707623', 2342599, 0, '234707623与2342599', 1326709540),
(93, 'micheal', '234707623', 2342599, 0, '234707623与2342599', 1326709541),
(94, 'micheal', '234707623', 2342599, 0, '234707623与2342599', 1326709541),
(95, 'micheal', '234707623', 2342599, 0, '234707623与2342599', 1326709542),
(96, 'micheal', '234707623', 2342599, 0, '234707623与2342599', 1326709543),
(97, 'micheal', '234707623', 2342599, 0, '234707623与2342599', 1326709543),
(98, 'micheal', '234707623', 2342599, 0, '234707623与2342599', 1326709544),
(99, 'micheal', '234707623', 2342599, 0, '234707623与2342599', 1326709545),
(100, 'micheal', '234707623', 2342599, 0, '234707623与2342599', 1326709547),
(101, 'micheal', '234707623', 2342599, 0, '234707623与2342599', 1326709548),
(102, 'micheal', '234707623', 2342599, 0, '234707623与2342599', 1326709549),
(103, 'micheal', '234707623', 2342599, 0, '234707623与2342599', 1326709550);

-- --------------------------------------------------------

--
-- 表的结构 `chatlog_user`
--

CREATE TABLE IF NOT EXISTS `chatlog_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `parentusername` varchar(128) NOT NULL COMMENT '账号所属用户的用户名',
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '用户姓名',
  `email` varchar(128) NOT NULL COMMENT '用户Email',
  `time` int(11) NOT NULL COMMENT '用户加入时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `chatlog_user`
--

INSERT INTO `chatlog_user` (`id`, `parentusername`, `name`, `email`, `time`) VALUES
(1, 'micheal', '234707623', '', 1326709100),
(2, 'bryant', '456789', '', 1326709369),
(3, 'micheal', '345678', '', 1326709428);
