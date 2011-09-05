-- phpMyAdmin SQL Dump
-- version 2.10.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Sep 05, 2011 at 01:31 AM
-- Server version: 5.0.41
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Database: `glitch`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `auctions`
-- 

CREATE TABLE `auctions` (
  `id` int(11) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `endtime` datetime NOT NULL,
  `rule_id` int(11) NOT NULL,
  `ts_auction_id` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `rule_id` (`rule_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `cake_sessions`
-- 

CREATE TABLE `cake_sessions` (
  `id` varchar(255) NOT NULL,
  `data` text,
  `expires` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `players`
-- 

CREATE TABLE `players` (
  `id` int(11) NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `name` varchar(255) NOT NULL,
  `tsid` varchar(16) NOT NULL,
  `oauth2_token` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `tsid` (`tsid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table structure for table `rules`
-- 

CREATE TABLE `rules` (
  `id` int(11) NOT NULL auto_increment,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `player_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `price` int(10) unsigned NOT NULL,
  `class_tsid` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL default '0',
  `name_single` varchar(255) NOT NULL,
  `name_plural` varchar(255) NOT NULL,
  `max_stack` int(11) NOT NULL,
  `base_cost` decimal(6,2) NOT NULL,
  `iconic_url` varchar(255) NOT NULL,
  `auction_count` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `player_id` (`player_id`),
  KEY `player_id_2` (`player_id`),
  KEY `player_id_3` (`player_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
