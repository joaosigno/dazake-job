-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 03 月 06 日 18:02
-- 服务器版本: 5.5.8
-- PHP 版本: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- 数据库: `test`
--

-- --------------------------------------------------------

--
-- 表的结构 `wp_eshop_orders`
--

CREATE TABLE IF NOT EXISTS `wp_eshop_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `checkid` varchar(255) NOT NULL DEFAULT '',
  `status` set('Sent','Completed','Pending','Failed','Deleted','Waiting') NOT NULL DEFAULT 'Pending',
  `first_name` varchar(50) NOT NULL DEFAULT '',
  `last_name` varchar(50) NOT NULL DEFAULT '',
  `company` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `phone` varchar(30) NOT NULL DEFAULT '',
  `address1` varchar(255) NOT NULL DEFAULT '',
  `address2` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(100) NOT NULL DEFAULT '',
  `state` varchar(100) NOT NULL DEFAULT '',
  `zip` varchar(20) NOT NULL DEFAULT '',
  `country` varchar(3) NOT NULL DEFAULT '',
  `reference` varchar(255) NOT NULL DEFAULT '',
  `ship_name` varchar(100) NOT NULL DEFAULT '',
  `ship_company` varchar(255) NOT NULL DEFAULT '',
  `ship_phone` varchar(30) NOT NULL DEFAULT '',
  `ship_address` varchar(255) NOT NULL DEFAULT '',
  `ship_city` varchar(100) NOT NULL DEFAULT '',
  `ship_state` varchar(100) NOT NULL DEFAULT '',
  `ship_postcode` varchar(20) NOT NULL DEFAULT '',
  `ship_country` varchar(3) NOT NULL DEFAULT '',
  `custom_field` varchar(15) NOT NULL DEFAULT '',
  `transid` varchar(255) NOT NULL DEFAULT '',
  `shipid` varchar(255) NOT NULL DEFAULT '',
  `comments` text NOT NULL,
  `thememo` text NOT NULL,
  `edited` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `downloads` set('yes','no') NOT NULL DEFAULT 'no',
  `admin_note` text NOT NULL,
  `paidvia` varchar(255) NOT NULL DEFAULT '',
  `affiliate` varchar(255) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL,
  `user_notes` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `custom_field` (`checkid`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;
