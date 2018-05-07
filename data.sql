/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : bs

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-05-07 10:14:01
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `bs_admin`
-- ----------------------------
DROP TABLE IF EXISTS `bs_admin`;
CREATE TABLE `bs_admin` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `pwd` varchar(32) DEFAULT NULL,
  `salt` varchar(16) DEFAULT NULL,
  `createtime` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bs_admin
-- ----------------------------
INSERT INTO `bs_admin` VALUES ('1', 'admin', '2ceded2be82eefae689a950bbafb4cfd', 'qj0tHNj0t7nqHh7E', '1521018495');

-- ----------------------------
-- Table structure for `bs_category`
-- ----------------------------
DROP TABLE IF EXISTS `bs_category`;
CREATE TABLE `bs_category` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `parent_id` int(10) NOT NULL DEFAULT '0',
  `listorder` int(10) NOT NULL COMMENT '排序号',
  `status` tinyint(2) unsigned zerofill NOT NULL DEFAULT '01' COMMENT '状态',
  `createtime` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bs_category
-- ----------------------------
INSERT INTO `bs_category` VALUES ('4', '特色', '0', '3', '01', '1523359054');
INSERT INTO `bs_category` VALUES ('3', '凉菜', '0', '0', '01', '1523352680');
INSERT INTO `bs_category` VALUES ('5', '甜食', '0', '2', '01', '1523605296');
INSERT INTO `bs_category` VALUES ('6', '热菜', '0', '0', '01', '1523783895');
INSERT INTO `bs_category` VALUES ('7', '汤', '0', '0', '01', '1523783906');

-- ----------------------------
-- Table structure for `bs_goods`
-- ----------------------------
DROP TABLE IF EXISTS `bs_goods`;
CREATE TABLE `bs_goods` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL COMMENT '商品名',
  `category_id` int(10) DEFAULT NULL,
  `listorder` int(10) DEFAULT '0' COMMENT '排序号',
  `thumb_url` varchar(100) DEFAULT NULL COMMENT '商品缩略图',
  `price` decimal(10,2) DEFAULT NULL COMMENT '商品价格',
  `originalprice` decimal(10,2) DEFAULT NULL COMMENT '商品原价',
  `status` tinyint(3) DEFAULT '0' COMMENT '是否上架 0 下架，1 上架',
  `createtime` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bs_goods
-- ----------------------------
INSERT INTO `bs_goods` VALUES ('3', '冰欺凌', '3', '0', '\\uploads\\images\\goods\\20180413\\fda2e8da2c03c7494fba802cf18764d5.jpg', '5.00', '10.00', '1', '1523605325');
INSERT INTO `bs_goods` VALUES ('2', '草莓派', '5', '1', '\\uploads\\images\\goods\\20180413\\b13e49e7640cc568fda81ea454f90f53.jpg', '11.00', '22.00', '1', '1523507272');
INSERT INTO `bs_goods` VALUES ('4', '宫保鸡丁', '4', '0', '\\uploads\\images\\goods\\20180415\\94c607f8267c53c0f196577e51a39489.png', '15.00', '20.00', '1', '1523784029');
INSERT INTO `bs_goods` VALUES ('5', '梅菜扣肉', '6', '0', '\\uploads\\images\\goods\\20180415\\f0d1a44a76ed10af27956d1dcb97673b.jpg', '25.00', '30.00', '1', '1523784236');
INSERT INTO `bs_goods` VALUES ('6', '紫菜蛋花汤', '7', '0', '\\uploads\\images\\goods\\20180415\\88693ff358e9b8ea2887964e43286cc7.jpg', '5.00', '8.00', '1', '1523784299');

-- ----------------------------
-- Table structure for `bs_nav`
-- ----------------------------
DROP TABLE IF EXISTS `bs_nav`;
CREATE TABLE `bs_nav` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `listorder` int(10) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `createtime` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bs_nav
-- ----------------------------
INSERT INTO `bs_nav` VALUES ('3', '1111', '\\uploads\\images\\navs\\20180502\\b6afac384f017ebacbdb77fac79d8eb2.jpg', '1525249323');
INSERT INTO `bs_nav` VALUES ('2', '121', '\\uploads\\images\\navs\\20180502\\db510779de2bd02311133187811453bf.jpg', '1525248835');

-- ----------------------------
-- Table structure for `bs_order`
-- ----------------------------
DROP TABLE IF EXISTS `bs_order`;
CREATE TABLE `bs_order` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ordersn` varchar(30) DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `table_id` int(10) DEFAULT NULL,
  `goodsdata` text,
  `price` decimal(10,2) DEFAULT NULL,
  `status` tinyint(3) DEFAULT NULL COMMENT '-1 取消 0待支付 1 制作中 2 已完成',
  `createtime` int(10) DEFAULT NULL,
  `finishtime` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for `bs_sysset`
-- ----------------------------
DROP TABLE IF EXISTS `bs_sysset`;
CREATE TABLE `bs_sysset` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `keywords` varchar(200) DEFAULT NULL,
  `desc` varchar(200) DEFAULT NULL,
  `js` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bs_sysset
-- ----------------------------
INSERT INTO `bs_sysset` VALUES ('1', '小餐馆', '餐馆，电子菜单', '好吃不贵，实惠', '<script src=\"\"></script>');

-- ----------------------------
-- Table structure for `bs_user`
-- ----------------------------
DROP TABLE IF EXISTS `bs_user`;
CREATE TABLE `bs_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `pwd` varchar(32) DEFAULT NULL,
  `salt` varchar(16) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0' COMMENT '0 正常 1 拉黑',
  `type` tinyint(2) DEFAULT NULL COMMENT '0普通用户 1 服务员 2后厨',
  `createtime` int(10) DEFAULT NULL,
  `credit1` decimal(5,2) DEFAULT '0.00' COMMENT '积分',
  `credit2` decimal(2,2) DEFAULT '0.00' COMMENT '余额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

