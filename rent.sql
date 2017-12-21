-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 12 月 22 日 07:19
-- 服务器版本: 5.6.12-log
-- PHP 版本: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `rent`
--
CREATE DATABASE IF NOT EXISTS `rent` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `rent`;

-- --------------------------------------------------------

--
-- 表的结构 `community`
--

CREATE TABLE IF NOT EXISTS `community` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `community`
--

INSERT INTO `community` (`id`, `name`) VALUES
(1, '儒苑'),
(2, '惠民'),
(3, '金跃'),
(4, '幸福'),
(5, '金泰');

-- --------------------------------------------------------

--
-- 表的结构 `register`
--

CREATE TABLE IF NOT EXISTS `register` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `communityid` int(11) NOT NULL,
  `address` varchar(16) NOT NULL,
  `target_communityid` int(11) NOT NULL,
  `updatetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `register`
--

INSERT INTO `register` (`id`, `userid`, `communityid`, `address`, `target_communityid`, `updatetime`) VALUES
(6, 1, 1, '10-2-1102', 2, '2017-12-21 16:00:35');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) NOT NULL,
  `mobile` varchar(16) NOT NULL,
  `password` varchar(64) NOT NULL,
  `firsttime` datetime NOT NULL,
  `updatetime` datetime NOT NULL,
  `ip` varchar(32) NOT NULL,
  `communityid` int(11) NOT NULL,
  `identification` varchar(32) NOT NULL,
  `address` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `name`, `mobile`, `password`, `firsttime`, `updatetime`, `ip`, `communityid`, `identification`, `address`) VALUES
(1, '刘美娟', '13931657890', '2226ce94cf0f3231556d320a9260f037', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 1, '131026198704114429', '10-2-1103');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
