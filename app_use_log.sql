# Host: localhost  (Version: 5.7.26)
# Date: 2023-11-22 14:39:33
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "app_use_log"
#

CREATE TABLE `app_use_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `app_name` varchar(255) DEFAULT '',
  `app_package` varchar(255) DEFAULT '',
  `open_time` int(10) unsigned DEFAULT '0' COMMENT '打开时间',
  `close_time` int(10) unsigned DEFAULT '0' COMMENT '关闭时间',
  `usage_time` int(10) unsigned DEFAULT '0' COMMENT '使用时间单位秒',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

#
# Data for table "app_use_log"
#

INSERT INTO `app_use_log` VALUES (1,'测试应用','com.uiui.zyos',1700417100,1700437100,20000),(2,'测试应用','com.uiui.zyos',1700489999,1700499999,10000),(3,'测试应用','com.uiui.zyos',1700409500,1700413500,4000),(5,'测试应用','com.uiui.zyos',1700442800,1700445800,3000),(6,'游戏应用','com.jxw.game',1700446800,1700447800,1000),(7,'测试应用','com.uiui.zyos',1700582400,1700582600,200);
