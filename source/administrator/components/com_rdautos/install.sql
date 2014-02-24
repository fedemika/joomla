
CREATE TABLE IF NOT EXISTS `jos_rdautos_categories` (
  `catid` int(20) NOT NULL auto_increment,
  `catname` varchar(100) NOT NULL,
  `decription` text NOT NULL,
  `image` varchar(50) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY  (`catid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;



INSERT INTO `jos_rdautos_categories` (`catid`, `catname`, `decription`, `image`, `alias`, `published`) VALUES
(1, 'Sportcars', 'Our sportcars collection will be here.', 'catid-1.jpg', 'Sportcars', 1);


CREATE TABLE IF NOT EXISTS `jos_rdautos_config` (
  `id` int(20) NOT NULL,
  `showfueltype` tinyint(1) NOT NULL,
  `userid` tinyint(3) NOT NULL,
  `currency` varchar(2) NOT NULL,
  `showprice` tinyint(1) NOT NULL,
  `showcolor` tinyint(1) NOT NULL,
  `showlightbox` tinyint(1) NOT NULL,
  `showmileage` tinyint(1) NOT NULL,
  `showdealer` tinyint(1) NOT NULL,
  `showprintpage` tinyint(1) NOT NULL,
  `showsend2friend` tinyint(1) NOT NULL,
  `showdoors` tinyint(1) NOT NULL,
  `showtransmission` tinyint(1) NOT NULL,
  `showgears` tinyint(1) NOT NULL,
  `showenginep` tinyint(1) NOT NULL,
  `showmotorsize` tinyint(1) NOT NULL,
  `showdate` tinyint(1) NOT NULL,
  `showaccessoires` tinyint(1) NOT NULL,
  `showrservation` tinyint(1) NOT NULL,
  `showfeatured` tinyint(1) NOT NULL,
  `showview` tinyint(1) NOT NULL,
  `lightboxheight` varchar(3) NOT NULL,
  `thumbnailheight` varchar(3) NOT NULL,
  `thumbnailwidth` varchar(3) NOT NULL,
  `lightboxwidth` varchar(3) NOT NULL,
  `catimage` tinyint(3) NOT NULL default '120',
  `showhits` tinyint(1) NOT NULL,
  `mileage` varchar(5) NOT NULL,
  `showweight` tinyint(1) NOT NULL,
  `countfeatured` tinyint(1) NOT NULL,
  `collums` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


INSERT INTO `jos_rdautos_config` (`id`, `showfueltype`, `userid`, `currency`, `showprice`, `showcolor`, `showlightbox`, `showmileage`, `showdealer`, `showprintpage`, `showsend2friend`, `showdoors`, `showtransmission`, `showgears`, `showenginep`, `showmotorsize`, `showdate`, `showaccessoires`, `showrservation`, `showfeatured`, `showview`, `lightboxheight`, `thumbnailheight`, `thumbnailwidth`, `lightboxwidth`, `catimage`, `showhits`, `mileage`, `showweight`, `countfeatured`, `collums`) VALUES
(1, 1, 62, '$', 1, 1, 1, 1, 1, 0, 1, 1, 1, 0, 1, 1, 1, 1, 0, 0, 0, '480', '80', '100', '640', 100, 1, 'Mile', 1, 2, 3);


CREATE TABLE IF NOT EXISTS `jos_rdautos_information` (
  `carid` int(20) NOT NULL auto_increment,
  `catid` int(20) NOT NULL,
  `makeid` int(20) NOT NULL,
  `modelid` int(20) NOT NULL,
  `modeltype` varchar(100) NOT NULL,
  `price` double NOT NULL,
  `mileage` mediumint(8) NOT NULL,
  `doors` tinyint(2) NOT NULL,
  `color` varchar(40) NOT NULL,
  `fueltype` tinyint(1) NOT NULL,
  `gears` mediumint(2) NOT NULL,
  `transmission` varchar(255) NOT NULL,
  `motorsize` varchar(5) NOT NULL,
  `enginepower` int(10) NOT NULL,
  `weight` varchar(25) NOT NULL,
  `featured` tinyint(1) NOT NULL,
  `availeble` tinyint(1) NOT NULL,
  `condition` tinyint(1) NOT NULL,
  `constructed` varchar(7) NOT NULL,
  `added` datetime NOT NULL,
  `updated` datetime default NULL,
  `hits` mediumint(20) NOT NULL,
  `published` tinyint(1) NOT NULL,
  `accesoires` text NOT NULL,
  `image1` varchar(255) NOT NULL,
  `image2` varchar(255) NOT NULL,
  `image3` varchar(255) NOT NULL,
  `image4` varchar(255) NOT NULL,
  `image5` varchar(255) NOT NULL,
  `image6` varchar(255) NOT NULL,
  `image7` varchar(25) NOT NULL,
  `image8` varchar(25) NOT NULL,
  `image9` varchar(25) NOT NULL,
  `image10` varchar(40) NOT NULL,
  `image11` varchar(40) NOT NULL,
  `image12` varchar(40) NOT NULL,
  PRIMARY KEY  (`carid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;



CREATE TABLE IF NOT EXISTS `jos_rdautos_makes` (
  `makeid` int(20) NOT NULL auto_increment,
  `makename` varchar(100) NOT NULL,
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY  (`makeid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=76 ;



CREATE TABLE IF NOT EXISTS `jos_rdautos_models` (
  `modelid` int(20) NOT NULL auto_increment,
  `makeid` int(20) NOT NULL,
  `model` varchar(50) NOT NULL,
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY  (`modelid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

CREATE TABLE `jos_rdautos_information_to_user` (
  `carid` int(20) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY  (`carid`,`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

ALTER TABLE `jos_rdautos_information` ADD UNIQUE `nombre_unico` ( `modeltype` ( 100 ) ); 

-- 25/04/2009 02:08a.m.
ALTER TABLE `jos_rdautos_config` ADD `template` VARCHAR( 30 ) NOT NULL ;