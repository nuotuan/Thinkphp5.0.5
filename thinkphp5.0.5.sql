/*
Navicat MySQL Data Transfer

Source Server         : E431
Source Server Version : 50617
Source Host           : 127.0.0.1:3306
Source Database       : thinkphp5.0.5

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2017-03-13 08:54:03
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tp_auth
-- ----------------------------
DROP TABLE IF EXISTS `tp_auth`;
CREATE TABLE `tp_auth` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `auth` text NOT NULL,
  `remark` varchar(255) DEFAULT NULL COMMENT '描述',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_auth
-- ----------------------------
INSERT INTO `tp_auth` VALUES ('1', '超级管理员', '1,2,3,22,4,8,14', '333', '1', '0', '0');
INSERT INTO `tp_auth` VALUES ('2', '普通用户', '1,2,3,22,4', '2222', '1', '0', '0');

-- ----------------------------
-- Table structure for tp_config
-- ----------------------------
DROP TABLE IF EXISTS `tp_config`;
CREATE TABLE `tp_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '配置名称',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配置类型',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '配置说明',
  `extra` varchar(255) NOT NULL DEFAULT '' COMMENT '配置值',
  `remark` varchar(100) NOT NULL DEFAULT '' COMMENT '配置说明',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  `value` text COMMENT '配置值',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`),
  KEY `type` (`type`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_config
-- ----------------------------
INSERT INTO `tp_config` VALUES ('1', 'WEB_SITE_TITLE', '0', '网站标题', '', '网站标题前台显示标题', '1378898976', '1489040916', '1', 'SKZPHP', '0');
INSERT INTO `tp_config` VALUES ('2', 'WEB_SITE_DESCRIPTION', '2', '网站描述', '', '网站搜索引擎描述', '1378898976', '1379235841', '1', '数字资产交易平台', '1');
INSERT INTO `tp_config` VALUES ('3', 'WEB_SITE_KEYWORD', '2', '网站关键字', '', '网站搜索引擎关键字', '1378898976', '1381390100', '1', '数字资产交易平台', '8');
INSERT INTO `tp_config` VALUES ('4', 'CONFIG_TYPE_LIST', '3', '配置类型列表', '', '主要用于数据解析和页面表单的生成', '1378898976', '1484037843', '1', '0:数字\n1:字符\n2:文本\n3:数组\n4:枚举\n5:密码\n6:图片', '2');
INSERT INTO `tp_config` VALUES ('5', 'PAGES_NUM', '0', '后台每页记录数', '', '', '1379503896', '1488188765', '1', '15', '0');
INSERT INTO `tp_config` VALUES ('6', 'ALLOW_CONTROLLER', '3', '不受限控制器方法', '', '多个控制器用回车分开', '1386644047', '1488856844', '1', 'admin/Index/index\nadmin/Index/main\nadmin/Index/left_menu', '0');
INSERT INTO `tp_config` VALUES ('7', 'ALLOW_ADMIN_CONTROLLER', '3', '仅限超级管理员访问的控制器方法', '', '多个控制器用回车分开', '1386644141', '1488965451', '1', '', '0');
INSERT INTO `tp_config` VALUES ('9', 'FEEDBACK_TYPE', '2', '反馈类型', '1:建议\n2:投诉', '', '1484981996', '1484981996', '0', '', '0');
INSERT INTO `tp_config` VALUES ('12', 'BAIDU_AK', '0', '百度接口AK', '', '百度接口AK', '1488273255', '1488273255', '0', 'dAjwby1kHjWHkhj80xLSWfwN', '0');

-- ----------------------------
-- Table structure for tp_menu
-- ----------------------------
DROP TABLE IF EXISTS `tp_menu`;
CREATE TABLE `tp_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文档ID',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '标题',
  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分类ID',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `url` char(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `icon` varchar(100) NOT NULL,
  `hide` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否隐藏',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tp_menu
-- ----------------------------
INSERT INTO `tp_menu` VALUES ('1', '系统', '0', '99', '', 'fa-desktop', '0', '1');
INSERT INTO `tp_menu` VALUES ('2', '配置管理', '1', '0', 'admin/Config/index', 'fa-cog', '0', '1');
INSERT INTO `tp_menu` VALUES ('3', '菜单管理', '1', '1', 'admin/Menu/index', 'fa-tags', '0', '1');
INSERT INTO `tp_menu` VALUES ('4', '用户管理', '1', '2', 'admin/User/index', 'fa-users', '0', '1');
INSERT INTO `tp_menu` VALUES ('8', '权限管理', '1', '4', 'admin/Auth/index', 'fa-lock', '0', '1');
INSERT INTO `tp_menu` VALUES ('22', '添加栏目', '3', '0', 'admin/Menu/menuAdd', '', '0', '1');

-- ----------------------------
-- Table structure for tp_user
-- ----------------------------
DROP TABLE IF EXISTS `tp_user`;
CREATE TABLE `tp_user` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `nickname` char(16) NOT NULL DEFAULT '' COMMENT '昵称',
  `password` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '0' COMMENT '用户邮箱',
  `login` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `reg_ip` bigint(20) DEFAULT '0' COMMENT '注册IP',
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `last_login_ip` varchar(50) DEFAULT '0' COMMENT '最后登录IP',
  `last_login_address` varchar(50) DEFAULT NULL COMMENT '最后登录地址',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `auth` int(10) NOT NULL DEFAULT '0' COMMENT '权限组',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '会员状态',
  PRIMARY KEY (`uid`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='会员表';

-- ----------------------------
-- Records of tp_user
-- ----------------------------
INSERT INTO `tp_user` VALUES ('1', 'admin', '0c7540eb7e65b553ec1ba6b20de79608', 'admin@admin.cn', '38', '0', '1484213302', '0.0.0.0', ' ', '1489138355', '1', '1');
INSERT INTO `tp_user` VALUES ('4', 'ceshi', 'd93a5def7511da3d0f2d171d9c344e91', '1164922012@qq.com', '10', '1270', '1488512723', '127.0.0.1', ' ', '1488965781', '2', '1');
