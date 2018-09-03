-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- โฮสต์: localhost
-- เวลาในการสร้าง: 10 พ.ค. 2012  20:11น.
-- รุ่นของเซิร์ฟเวอร์: 5.1.54
-- รุ่นของ PHP: 5.3.5-1ubuntu7.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- ฐานข้อมูล: `mygrade`
--

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `avgrade`
--

CREATE TABLE IF NOT EXISTS `avgrade` (
  `addcre` varchar(4) DEFAULT NULL,
  `addpoint` varchar(4) DEFAULT NULL,
  `tolcre` varchar(4) DEFAULT NULL,
  `tolpoint` varchar(4) DEFAULT NULL,
  `code` varchar(10) NOT NULL DEFAULT '',
  `name` varchar(35) DEFAULT NULL,
  `cre1` char(3) DEFAULT NULL,
  `cre2` char(3) DEFAULT NULL,
  `cre3` char(3) DEFAULT NULL,
  `cre4` char(3) DEFAULT NULL,
  `cre5` char(3) DEFAULT NULL,
  `cre6` char(3) DEFAULT NULL,
  `cre7` char(3) DEFAULT NULL,
  `cre8` char(3) DEFAULT NULL,
  `cre9` char(3) DEFAULT NULL,
  `tolcre1` char(3) DEFAULT NULL,
  `tolcre2` char(3) DEFAULT NULL,
  `tolcre3` char(3) DEFAULT NULL,
  `tolcre4` char(3) DEFAULT NULL,
  `tolcre5` char(3) DEFAULT NULL,
  `tolcre6` char(3) DEFAULT NULL,
  `tolcre7` char(3) DEFAULT NULL,
  `tolcre8` char(3) DEFAULT NULL,
  `tolcre9` char(3) DEFAULT NULL,
  `point1` varchar(4) DEFAULT NULL,
  `point2` varchar(4) DEFAULT NULL,
  `point3` varchar(4) DEFAULT NULL,
  `point4` varchar(4) DEFAULT NULL,
  `point5` varchar(4) DEFAULT NULL,
  `point6` varchar(4) DEFAULT NULL,
  `point7` varchar(4) DEFAULT NULL,
  `point8` varchar(4) DEFAULT NULL,
  `point9` varchar(4) DEFAULT NULL,
  `tolpoint1` varchar(4) DEFAULT NULL,
  `tolpoint2` varchar(4) DEFAULT NULL,
  `tolpoint3` varchar(4) DEFAULT NULL,
  `tolpoint4` varchar(4) DEFAULT NULL,
  `tolpoint5` varchar(4) DEFAULT NULL,
  `tolpoint6` varchar(4) DEFAULT NULL,
  `tolpoint7` varchar(4) DEFAULT NULL,
  `tolpoint8` varchar(4) DEFAULT NULL,
  `tolpoint9` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `grade`
--

CREATE TABLE IF NOT EXISTS `grade` (
  `code` varchar(10) NOT NULL DEFAULT '',
  `semes` varchar(6) NOT NULL DEFAULT '',
  `tcode` varchar(9) NOT NULL DEFAULT '',
  `level` varchar(4) DEFAULT NULL,
  `tsubject` varchar(45) DEFAULT NULL,
  `credit` int(2) DEFAULT NULL,
  PRIMARY KEY (`code`,`semes`,`tcode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
