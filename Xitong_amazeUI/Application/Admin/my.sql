drop table if EXISTS  `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(0) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `create_time`  int(11) NOT NULL,
  PRIMARY KEY (`id`)
 ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;



drop table if EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  `bookname` varchar(100) NOT NULL,
  `ISBN` varchar(20) NOT NULL,
  `press` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `picture` varchar(255) ,
  `bookzan` bigint(10) unsigned NOT NULL,
  `create_time`  int(11) NOT NULL,
  PRIMARY KEY (`id`)
 ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;


CREATE TABLE IF NOT EXISTS `bookzan` (
  `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  `bookid` bigint(10) NOT NULL,
  `username` varchar(100) NOT NULL,
  `create_time`  int(11) NOT NULL,
  PRIMARY KEY (`id`)
 ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;


CREATE TABLE IF NOT EXISTS `comments` (
  `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  `bookid` int(10) unsigned NOT NULL,
  `username` varchar(100) NOT NULL,
  `parentid` int(10) unsigned NOT NULL,
  `comment` varchar(255) NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
 ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;


CREATE TABLE IF NOT EXISTS `notes` (
  `id` bigint(10) unsigned NOT NULL AUTO_INCREMENT,
  `bookid` int(10) unsigned NOT NULL,
  `username` varchar(100) NOT NULL,
  `chapter` int(10) unsigned NOT NULL,
  `page` varchar(50) NOT NULL,
  `note` varchar(255) NOT NULL,
  `photo` varchar(100) ,
  `public` smallint(2) unsigned NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
 ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;


