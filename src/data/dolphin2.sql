/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 50744 (5.7.44)
 Source Host           : 127.0.0.1:3306
 Source Schema         : dolphin2

 Target Server Type    : MySQL
 Target Server Version : 50744 (5.7.44)
 File Encoding         : 65001

 Date: 06/05/2024 13:03:44
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for dp_admin_access
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_access`;
CREATE TABLE `dp_admin_access`  (
  `module` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '模型名称',
  `group` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '权限分组标识',
  `uid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户id',
  `nid` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '授权节点id',
  `tag` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '分组标签'
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '统一授权表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_admin_access
-- ----------------------------

-- ----------------------------
-- Table structure for dp_admin_action
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_action`;
CREATE TABLE `dp_admin_action`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `module` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '所属模块名',
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '行为唯一标识',
  `title` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '行为标题',
  `remark` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '行为描述',
  `rule` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '行为规则',
  `log` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '日志规则',
  `status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '状态',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 100 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统行为表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_admin_action
-- ----------------------------
INSERT INTO `dp_admin_action` VALUES (1, 'user', 'user_add', '添加用户', '添加用户', '', '[user|get_nickname] 添加了用户：[record|get_nickname]', 1, 1480156399, 1480163853);
INSERT INTO `dp_admin_action` VALUES (2, 'user', 'user_edit', '编辑用户', '编辑用户', '', '[user|get_nickname] 编辑了用户：[details]', 1, 1480164578, 1480297748);
INSERT INTO `dp_admin_action` VALUES (3, 'user', 'user_delete', '删除用户', '删除用户', '', '[user|get_nickname] 删除了用户：[details]', 1, 1480168582, 1480168616);
INSERT INTO `dp_admin_action` VALUES (4, 'user', 'user_enable', '启用用户', '启用用户', '', '[user|get_nickname] 启用了用户：[details]', 1, 1480169185, 1480169185);
INSERT INTO `dp_admin_action` VALUES (5, 'user', 'user_disable', '禁用用户', '禁用用户', '', '[user|get_nickname] 禁用了用户：[details]', 1, 1480169214, 1480170581);
INSERT INTO `dp_admin_action` VALUES (6, 'user', 'user_access', '用户授权', '用户授权', '', '[user|get_nickname] 对用户：[record|get_nickname] 进行了授权操作。详情：[details]', 1, 1480221441, 1480221563);
INSERT INTO `dp_admin_action` VALUES (7, 'user', 'role_add', '添加角色', '添加角色', '', '[user|get_nickname] 添加了角色：[details]', 1, 1480251473, 1480251473);
INSERT INTO `dp_admin_action` VALUES (8, 'user', 'role_edit', '编辑角色', '编辑角色', '', '[user|get_nickname] 编辑了角色：[details]', 1, 1480252369, 1480252369);
INSERT INTO `dp_admin_action` VALUES (9, 'user', 'role_delete', '删除角色', '删除角色', '', '[user|get_nickname] 删除了角色：[details]', 1, 1480252580, 1480252580);
INSERT INTO `dp_admin_action` VALUES (10, 'user', 'role_enable', '启用角色', '启用角色', '', '[user|get_nickname] 启用了角色：[details]', 1, 1480252620, 1480252620);
INSERT INTO `dp_admin_action` VALUES (11, 'user', 'role_disable', '禁用角色', '禁用角色', '', '[user|get_nickname] 禁用了角色：[details]', 1, 1480252651, 1480252651);
INSERT INTO `dp_admin_action` VALUES (12, 'user', 'attachment_enable', '启用附件', '启用附件', '', '[user|get_nickname] 启用了附件：附件ID([details])', 1, 1480253226, 1480253332);
INSERT INTO `dp_admin_action` VALUES (13, 'user', 'attachment_disable', '禁用附件', '禁用附件', '', '[user|get_nickname] 禁用了附件：附件ID([details])', 1, 1480253267, 1480253340);
INSERT INTO `dp_admin_action` VALUES (14, 'user', 'attachment_delete', '删除附件', '删除附件', '', '[user|get_nickname] 删除了附件：附件ID([details])', 1, 1480253323, 1480253323);
INSERT INTO `dp_admin_action` VALUES (15, 'admin', 'config_add', '添加配置', '添加配置', '', '[user|get_nickname] 添加了配置，[details]', 1, 1480296196, 1480296196);
INSERT INTO `dp_admin_action` VALUES (16, 'admin', 'config_edit', '编辑配置', '编辑配置', '', '[user|get_nickname] 编辑了配置：[details]', 1, 1480296960, 1480296960);
INSERT INTO `dp_admin_action` VALUES (17, 'admin', 'config_enable', '启用配置', '启用配置', '', '[user|get_nickname] 启用了配置：[details]', 1, 1480298479, 1480298479);
INSERT INTO `dp_admin_action` VALUES (18, 'admin', 'config_disable', '禁用配置', '禁用配置', '', '[user|get_nickname] 禁用了配置：[details]', 1, 1480298506, 1480298506);
INSERT INTO `dp_admin_action` VALUES (19, 'admin', 'config_delete', '删除配置', '删除配置', '', '[user|get_nickname] 删除了配置：[details]', 1, 1480298532, 1480298532);
INSERT INTO `dp_admin_action` VALUES (20, 'admin', 'database_export', '备份数据库', '备份数据库', '', '[user|get_nickname] 备份了数据库：[details]', 1, 1480298946, 1480298946);
INSERT INTO `dp_admin_action` VALUES (21, 'admin', 'database_import', '还原数据库', '还原数据库', '', '[user|get_nickname] 还原了数据库：[details]', 1, 1480301990, 1480302022);
INSERT INTO `dp_admin_action` VALUES (22, 'admin', 'database_optimize', '优化数据表', '优化数据表', '', '[user|get_nickname] 优化了数据表：[details]', 1, 1480302616, 1480302616);
INSERT INTO `dp_admin_action` VALUES (23, 'admin', 'database_repair', '修复数据表', '修复数据表', '', '[user|get_nickname] 修复了数据表：[details]', 1, 1480302798, 1480302798);
INSERT INTO `dp_admin_action` VALUES (24, 'admin', 'database_backup_delete', '删除数据库备份', '删除数据库备份', '', '[user|get_nickname] 删除了数据库备份：[details]', 1, 1480302870, 1480302870);
INSERT INTO `dp_admin_action` VALUES (25, 'admin', 'hook_add', '添加钩子', '添加钩子', '', '[user|get_nickname] 添加了钩子：[details]', 1, 1480303198, 1480303198);
INSERT INTO `dp_admin_action` VALUES (26, 'admin', 'hook_edit', '编辑钩子', '编辑钩子', '', '[user|get_nickname] 编辑了钩子：[details]', 1, 1480303229, 1480303229);
INSERT INTO `dp_admin_action` VALUES (27, 'admin', 'hook_delete', '删除钩子', '删除钩子', '', '[user|get_nickname] 删除了钩子：[details]', 1, 1480303264, 1480303264);
INSERT INTO `dp_admin_action` VALUES (28, 'admin', 'hook_enable', '启用钩子', '启用钩子', '', '[user|get_nickname] 启用了钩子：[details]', 1, 1480303294, 1480303294);
INSERT INTO `dp_admin_action` VALUES (29, 'admin', 'hook_disable', '禁用钩子', '禁用钩子', '', '[user|get_nickname] 禁用了钩子：[details]', 1, 1480303409, 1480303409);
INSERT INTO `dp_admin_action` VALUES (30, 'admin', 'menu_add', '添加节点', '添加节点', '', '[user|get_nickname] 添加了节点：[details]', 1, 1480305468, 1480305468);
INSERT INTO `dp_admin_action` VALUES (31, 'admin', 'menu_edit', '编辑节点', '编辑节点', '', '[user|get_nickname] 编辑了节点：[details]', 1, 1480305513, 1480305513);
INSERT INTO `dp_admin_action` VALUES (32, 'admin', 'menu_delete', '删除节点', '删除节点', '', '[user|get_nickname] 删除了节点：[details]', 1, 1480305562, 1480305562);
INSERT INTO `dp_admin_action` VALUES (33, 'admin', 'menu_enable', '启用节点', '启用节点', '', '[user|get_nickname] 启用了节点：[details]', 1, 1480305630, 1480305630);
INSERT INTO `dp_admin_action` VALUES (34, 'admin', 'menu_disable', '禁用节点', '禁用节点', '', '[user|get_nickname] 禁用了节点：[details]', 1, 1480305659, 1480305659);
INSERT INTO `dp_admin_action` VALUES (35, 'admin', 'module_install', '安装模块', '安装模块', '', '[user|get_nickname] 安装了模块：[details]', 1, 1480307558, 1480307558);
INSERT INTO `dp_admin_action` VALUES (36, 'admin', 'module_uninstall', '卸载模块', '卸载模块', '', '[user|get_nickname] 卸载了模块：[details]', 1, 1480307588, 1480307588);
INSERT INTO `dp_admin_action` VALUES (37, 'admin', 'module_enable', '启用模块', '启用模块', '', '[user|get_nickname] 启用了模块：[details]', 1, 1480307618, 1480307618);
INSERT INTO `dp_admin_action` VALUES (38, 'admin', 'module_disable', '禁用模块', '禁用模块', '', '[user|get_nickname] 禁用了模块：[details]', 1, 1480307653, 1480307653);
INSERT INTO `dp_admin_action` VALUES (39, 'admin', 'module_export', '导出模块', '导出模块', '', '[user|get_nickname] 导出了模块：[details]', 1, 1480307682, 1480307682);
INSERT INTO `dp_admin_action` VALUES (40, 'admin', 'packet_install', '安装数据包', '安装数据包', '', '[user|get_nickname] 安装了数据包：[details]', 1, 1480308342, 1480308342);
INSERT INTO `dp_admin_action` VALUES (41, 'admin', 'packet_uninstall', '卸载数据包', '卸载数据包', '', '[user|get_nickname] 卸载了数据包：[details]', 1, 1480308372, 1480308372);
INSERT INTO `dp_admin_action` VALUES (42, 'admin', 'system_config_update', '更新系统设置', '更新系统设置', '', '[user|get_nickname] 更新了系统设置：[details]', 1, 1480309555, 1480309642);
INSERT INTO `dp_admin_action` VALUES (43, 'cms', 'slider_delete', '删除滚动图片', '删除滚动图片', '', '[user|get_nickname] 删除了滚动图片：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (44, 'cms', 'slider_edit', '编辑滚动图片', '编辑滚动图片', '', '[user|get_nickname] 编辑了滚动图片：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (45, 'cms', 'slider_add', '添加滚动图片', '添加滚动图片', '', '[user|get_nickname] 添加了滚动图片：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (46, 'cms', 'document_delete', '删除文档', '删除文档', '', '[user|get_nickname] 删除了文档：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (47, 'cms', 'document_restore', '还原文档', '还原文档', '', '[user|get_nickname] 还原了文档：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (48, 'cms', 'nav_disable', '禁用导航', '禁用导航', '', '[user|get_nickname] 禁用了导航：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (49, 'cms', 'nav_enable', '启用导航', '启用导航', '', '[user|get_nickname] 启用了导航：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (50, 'cms', 'nav_delete', '删除导航', '删除导航', '', '[user|get_nickname] 删除了导航：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (51, 'cms', 'nav_edit', '编辑导航', '编辑导航', '', '[user|get_nickname] 编辑了导航：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (52, 'cms', 'nav_add', '添加导航', '添加导航', '', '[user|get_nickname] 添加了导航：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (53, 'cms', 'model_disable', '禁用内容模型', '禁用内容模型', '', '[user|get_nickname] 禁用了内容模型：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (54, 'cms', 'model_enable', '启用内容模型', '启用内容模型', '', '[user|get_nickname] 启用了内容模型：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (55, 'cms', 'model_delete', '删除内容模型', '删除内容模型', '', '[user|get_nickname] 删除了内容模型：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (56, 'cms', 'model_edit', '编辑内容模型', '编辑内容模型', '', '[user|get_nickname] 编辑了内容模型：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (57, 'cms', 'model_add', '添加内容模型', '添加内容模型', '', '[user|get_nickname] 添加了内容模型：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (58, 'cms', 'menu_disable', '禁用导航菜单', '禁用导航菜单', '', '[user|get_nickname] 禁用了导航菜单：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (59, 'cms', 'menu_enable', '启用导航菜单', '启用导航菜单', '', '[user|get_nickname] 启用了导航菜单：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (60, 'cms', 'menu_delete', '删除导航菜单', '删除导航菜单', '', '[user|get_nickname] 删除了导航菜单：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (61, 'cms', 'menu_edit', '编辑导航菜单', '编辑导航菜单', '', '[user|get_nickname] 编辑了导航菜单：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (62, 'cms', 'menu_add', '添加导航菜单', '添加导航菜单', '', '[user|get_nickname] 添加了导航菜单：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (63, 'cms', 'link_disable', '禁用友情链接', '禁用友情链接', '', '[user|get_nickname] 禁用了友情链接：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (64, 'cms', 'link_enable', '启用友情链接', '启用友情链接', '', '[user|get_nickname] 启用了友情链接：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (65, 'cms', 'link_delete', '删除友情链接', '删除友情链接', '', '[user|get_nickname] 删除了友情链接：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (66, 'cms', 'link_edit', '编辑友情链接', '编辑友情链接', '', '[user|get_nickname] 编辑了友情链接：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (67, 'cms', 'link_add', '添加友情链接', '添加友情链接', '', '[user|get_nickname] 添加了友情链接：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (68, 'cms', 'field_disable', '禁用模型字段', '禁用模型字段', '', '[user|get_nickname] 禁用了模型字段：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (69, 'cms', 'field_enable', '启用模型字段', '启用模型字段', '', '[user|get_nickname] 启用了模型字段：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (70, 'cms', 'field_delete', '删除模型字段', '删除模型字段', '', '[user|get_nickname] 删除了模型字段：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (71, 'cms', 'field_edit', '编辑模型字段', '编辑模型字段', '', '[user|get_nickname] 编辑了模型字段：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (72, 'cms', 'field_add', '添加模型字段', '添加模型字段', '', '[user|get_nickname] 添加了模型字段：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (73, 'cms', 'column_disable', '禁用栏目', '禁用栏目', '', '[user|get_nickname] 禁用了栏目：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (74, 'cms', 'column_enable', '启用栏目', '启用栏目', '', '[user|get_nickname] 启用了栏目：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (75, 'cms', 'column_delete', '删除栏目', '删除栏目', '', '[user|get_nickname] 删除了栏目：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (76, 'cms', 'column_edit', '编辑栏目', '编辑栏目', '', '[user|get_nickname] 编辑了栏目：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (77, 'cms', 'column_add', '添加栏目', '添加栏目', '', '[user|get_nickname] 添加了栏目：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (78, 'cms', 'advert_type_disable', '禁用广告分类', '禁用广告分类', '', '[user|get_nickname] 禁用了广告分类：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (79, 'cms', 'advert_type_enable', '启用广告分类', '启用广告分类', '', '[user|get_nickname] 启用了广告分类：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (80, 'cms', 'advert_type_delete', '删除广告分类', '删除广告分类', '', '[user|get_nickname] 删除了广告分类：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (81, 'cms', 'advert_type_edit', '编辑广告分类', '编辑广告分类', '', '[user|get_nickname] 编辑了广告分类：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (82, 'cms', 'advert_type_add', '添加广告分类', '添加广告分类', '', '[user|get_nickname] 添加了广告分类：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (83, 'cms', 'advert_disable', '禁用广告', '禁用广告', '', '[user|get_nickname] 禁用了广告：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (84, 'cms', 'advert_enable', '启用广告', '启用广告', '', '[user|get_nickname] 启用了广告：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (85, 'cms', 'advert_delete', '删除广告', '删除广告', '', '[user|get_nickname] 删除了广告：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (86, 'cms', 'advert_edit', '编辑广告', '编辑广告', '', '[user|get_nickname] 编辑了广告：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (87, 'cms', 'advert_add', '添加广告', '添加广告', '', '[user|get_nickname] 添加了广告：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (88, 'cms', 'document_disable', '禁用文档', '禁用文档', '', '[user|get_nickname] 禁用了文档：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (89, 'cms', 'document_enable', '启用文档', '启用文档', '', '[user|get_nickname] 启用了文档：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (90, 'cms', 'document_trash', '回收文档', '回收文档', '', '[user|get_nickname] 回收了文档：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (91, 'cms', 'document_edit', '编辑文档', '编辑文档', '', '[user|get_nickname] 编辑了文档：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (92, 'cms', 'document_add', '添加文档', '添加文档', '', '[user|get_nickname] 添加了文档：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (93, 'cms', 'slider_enable', '启用滚动图片', '启用滚动图片', '', '[user|get_nickname] 启用了滚动图片：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (94, 'cms', 'slider_disable', '禁用滚动图片', '禁用滚动图片', '', '[user|get_nickname] 禁用了滚动图片：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (95, 'cms', 'support_add', '添加客服', '添加客服', '', '[user|get_nickname] 添加了客服：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (96, 'cms', 'support_edit', '编辑客服', '编辑客服', '', '[user|get_nickname] 编辑了客服：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (97, 'cms', 'support_delete', '删除客服', '删除客服', '', '[user|get_nickname] 删除了客服：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (98, 'cms', 'support_enable', '启用客服', '启用客服', '', '[user|get_nickname] 启用了客服：[details]', 1, 1714970498, 1714970498);
INSERT INTO `dp_admin_action` VALUES (99, 'cms', 'support_disable', '禁用客服', '禁用客服', '', '[user|get_nickname] 禁用了客服：[details]', 1, 1714970498, 1714970498);

-- ----------------------------
-- Table structure for dp_admin_attachment
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_attachment`;
CREATE TABLE `dp_admin_attachment`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户id',
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '文件名',
  `module` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '模块名，由哪个模块上传的',
  `path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '文件路径',
  `thumb` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '缩略图路径',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '文件链接',
  `mime` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '文件mime类型',
  `ext` char(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '文件类型',
  `size` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '文件大小',
  `md5` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'sha1 散列值',
  `driver` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'local' COMMENT '上传驱动',
  `download` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '下载次数',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '上传时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT 100 COMMENT '排序',
  `status` tinyint(2) NOT NULL DEFAULT 1 COMMENT '状态',
  `width` int(8) UNSIGNED NOT NULL DEFAULT 0 COMMENT '图片宽度',
  `height` int(8) UNSIGNED NOT NULL DEFAULT 0 COMMENT '图片高度',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '附件表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_admin_attachment
-- ----------------------------

-- ----------------------------
-- Table structure for dp_admin_config
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_config`;
CREATE TABLE `dp_admin_config`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '名称',
  `title` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `group` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '配置分组',
  `type` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '类型',
  `value` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '配置值',
  `options` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '配置项',
  `tips` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '配置提示',
  `ajax_url` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '联动下拉框ajax地址',
  `next_items` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '联动下拉框的下级下拉框名，多个以逗号隔开',
  `param` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '联动下拉框请求参数名',
  `format` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '格式，用于格式文本',
  `table` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '表名，只用于快速联动类型',
  `level` tinyint(2) UNSIGNED NOT NULL DEFAULT 2 COMMENT '联动级别，只用于快速联动类型',
  `key` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '键字段，只用于快速联动类型',
  `option` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '值字段，只用于快速联动类型',
  `pid` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '父级id字段，只用于快速联动类型',
  `ak` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '百度地图appkey',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT 100 COMMENT '排序',
  `status` tinyint(2) NOT NULL DEFAULT 1 COMMENT '状态：0禁用，1启用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 40 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '系统配置表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_admin_config
-- ----------------------------
INSERT INTO `dp_admin_config` VALUES (1, 'web_site_status', '站点开关', 'base', 'switch', '1', '', '站点关闭后将不能访问，后台可正常登录', '', '', '', '', '', 2, '', '', '', '', 1475240395, 1477403914, 1, 1);
INSERT INTO `dp_admin_config` VALUES (2, 'web_site_title', '站点标题', 'base', 'text', '海豚PHP', '', '调用方式：<code>config(\'web_site_title\')</code>', '', '', '', '', '', 2, '', '', '', '', 1475240646, 1477710341, 2, 1);
INSERT INTO `dp_admin_config` VALUES (3, 'web_site_slogan', '站点标语', 'base', 'text', '海豚PHP，极简、极速、极致', '', '站点口号，调用方式：<code>config(\'web_site_slogan\')</code>', '', '', '', '', '', 2, '', '', '', '', 1475240994, 1477710357, 3, 1);
INSERT INTO `dp_admin_config` VALUES (4, 'web_site_logo', '站点LOGO', 'base', 'image', '', '', '', '', '', '', '', '', 2, '', '', '', '', 1475241067, 1475241067, 4, 1);
INSERT INTO `dp_admin_config` VALUES (5, 'web_site_description', '站点描述', 'base', 'textarea', '', '', '网站描述，有利于搜索引擎抓取相关信息', '', '', '', '', '', 2, '', '', '', '', 1475241186, 1475241186, 6, 1);
INSERT INTO `dp_admin_config` VALUES (6, 'web_site_keywords', '站点关键词', 'base', 'text', '海豚PHP、PHP开发框架、后台框架', '', '网站搜索引擎关键字', '', '', '', '', '', 2, '', '', '', '', 1475241328, 1475241328, 7, 1);
INSERT INTO `dp_admin_config` VALUES (7, 'web_site_copyright', '版权信息', 'base', 'text', 'Copyright © 2015-2017 DolphinPHP All rights reserved.', '', '调用方式：<code>config(\'web_site_copyright\')</code>', '', '', '', '', '', 2, '', '', '', '', 1475241416, 1477710383, 8, 1);
INSERT INTO `dp_admin_config` VALUES (8, 'web_site_icp', '备案信息', 'base', 'text', '', '', '调用方式：<code>config(\'web_site_icp\')</code>', '', '', '', '', '', 2, '', '', '', '', 1475241441, 1477710441, 9, 1);
INSERT INTO `dp_admin_config` VALUES (9, 'web_site_statistics', '站点统计', 'base', 'textarea', '', '', '网站统计代码，支持百度、Google、cnzz等，调用方式：<code>config(\'web_site_statistics\')</code>', '', '', '', '', '', 2, '', '', '', '', 1475241498, 1477710455, 10, 1);
INSERT INTO `dp_admin_config` VALUES (10, 'config_group', '配置分组', 'system', 'array', 'base:基本\r\nsystem:系统\r\nupload:上传\r\ndevelop:开发\r\ndatabase:数据库', '', '', '', '', '', '', '', 2, '', '', '', '', 1475241716, 1477649446, 100, 1);
INSERT INTO `dp_admin_config` VALUES (11, 'form_item_type', '配置类型', 'system', 'array', 'text:单行文本\r\ntextarea:多行文本\r\nstatic:静态文本\r\npassword:密码\r\ncheckbox:复选框\r\nradio:单选按钮\r\ndate:日期\r\ndatetime:日期+时间\r\nhidden:隐藏\r\nswitch:开关\r\narray:数组\r\nselect:下拉框\r\nlinkage:普通联动下拉框\r\nlinkages:快速联动下拉框\r\nimage:单张图片\r\nimages:多张图片\r\nfile:单个文件\r\nfiles:多个文件\r\nueditor:UEditor 编辑器\r\nwangeditor:wangEditor 编辑器\r\neditormd:markdown 编辑器\r\nckeditor:ckeditor 编辑器\r\nicon:字体图标\r\ntags:标签\r\nnumber:数字\r\nbmap:百度地图\r\ncolorpicker:取色器\r\njcrop:图片裁剪\r\nmasked:格式文本\r\nrange:范围\r\ntime:时间', '', '', '', '', '', '', '', 2, '', '', '', '', 1475241835, 1495853193, 100, 1);
INSERT INTO `dp_admin_config` VALUES (12, 'upload_file_size', '文件上传大小限制', 'upload', 'text', '0', '', '0为不限制大小，单位：kb', '', '', '', '', '', 2, '', '', '', '', 1475241897, 1477663520, 100, 1);
INSERT INTO `dp_admin_config` VALUES (13, 'upload_file_ext', '允许上传的文件后缀', 'upload', 'tags', 'doc,docx,xls,xlsx,ppt,pptx,pdf,wps,txt,rar,zip,gz,bz2,7z', '', '多个后缀用逗号隔开，不填写则不限制类型', '', '', '', '', '', 2, '', '', '', '', 1475241975, 1477649489, 100, 1);
INSERT INTO `dp_admin_config` VALUES (14, 'upload_image_size', '图片上传大小限制', 'upload', 'text', '0', '', '0为不限制大小，单位：kb', '', '', '', '', '', 2, '', '', '', '', 1475242015, 1477663529, 100, 1);
INSERT INTO `dp_admin_config` VALUES (15, 'upload_image_ext', '允许上传的图片后缀', 'upload', 'tags', 'gif,jpg,jpeg,bmp,png', '', '多个后缀用逗号隔开，不填写则不限制类型', '', '', '', '', '', 2, '', '', '', '', 1475242056, 1477649506, 100, 1);
INSERT INTO `dp_admin_config` VALUES (16, 'list_rows', '分页数量', 'system', 'number', '20', '', '每页的记录数', '', '', '', '', '', 2, '', '', '', '', 1475242066, 1476074507, 101, 1);
INSERT INTO `dp_admin_config` VALUES (17, 'system_color', '后台配色方案', 'system', 'radio', 'default', 'default:Default\r\namethyst:Amethyst\r\ncity:City\r\nflat:Flat\r\nmodern:Modern\r\nsmooth:Smooth', '', '', '', '', '', '', 2, '', '', '', '', 1475250066, 1477316689, 102, 1);
INSERT INTO `dp_admin_config` VALUES (18, 'develop_mode', '开发模式', 'develop', 'radio', '1', '0:关闭\r\n1:开启', '', '', '', '', '', '', 2, '', '', '', '', 1476864205, 1476864231, 100, 1);
INSERT INTO `dp_admin_config` VALUES (19, 'app_trace', '显示页面Trace', 'develop', 'radio', '0', '0:否\r\n1:是', '', '', '', '', '', '', 2, '', '', '', '', 1476866355, 1476866355, 100, 1);
INSERT INTO `dp_admin_config` VALUES (21, 'data_backup_path', '数据库备份根路径', 'database', 'text', '../data/', '', '路径必须以 / 结尾', '', '', '', '', '', 2, '', '', '', '', 1477017745, 1477018467, 100, 1);
INSERT INTO `dp_admin_config` VALUES (22, 'data_backup_part_size', '数据库备份卷大小', 'database', 'text', '20971520', '', '该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M', '', '', '', '', '', 2, '', '', '', '', 1477017886, 1477017886, 100, 1);
INSERT INTO `dp_admin_config` VALUES (23, 'data_backup_compress', '数据库备份文件是否启用压缩', 'database', 'radio', '1', '0:否\r\n1:是', '压缩备份文件需要PHP环境支持 <code>gzopen</code>, <code>gzwrite</code>函数', '', '', '', '', '', 2, '', '', '', '', 1477017978, 1477018172, 100, 1);
INSERT INTO `dp_admin_config` VALUES (24, 'data_backup_compress_level', '数据库备份文件压缩级别', 'database', 'radio', '9', '1:最低\r\n4:一般\r\n9:最高', '数据库备份文件的压缩级别，该配置在开启压缩时生效', '', '', '', '', '', 2, '', '', '', '', 1477018083, 1477018083, 100, 1);
INSERT INTO `dp_admin_config` VALUES (25, 'top_menu_max', '顶部导航模块数量', 'system', 'text', '10', '', '设置顶部导航默认显示的模块数量', '', '', '', '', '', 2, '', '', '', '', 1477579289, 1477579289, 103, 1);
INSERT INTO `dp_admin_config` VALUES (26, 'web_site_logo_text', '站点LOGO文字', 'base', 'image', '', '', '', '', '', '', '', '', 2, '', '', '', '', 1477620643, 1477620643, 5, 1);
INSERT INTO `dp_admin_config` VALUES (27, 'upload_image_thumb', '缩略图尺寸', 'upload', 'text', '', '', '不填写则不生成缩略图，如需生成 <code>300x300</code> 的缩略图，则填写 <code>300,300</code> ，请注意，逗号必须是英文逗号', '', '', '', '', '', 2, '', '', '', '', 1477644150, 1477649513, 100, 1);
INSERT INTO `dp_admin_config` VALUES (28, 'upload_image_thumb_type', '缩略图裁剪类型', 'upload', 'radio', '1', '1:等比例缩放\r\n2:缩放后填充\r\n3:居中裁剪\r\n4:左上角裁剪\r\n5:右下角裁剪\r\n6:固定尺寸缩放', '该项配置只有在启用生成缩略图时才生效', '', '', '', '', '', 2, '', '', '', '', 1477646271, 1477649521, 100, 1);
INSERT INTO `dp_admin_config` VALUES (29, 'upload_thumb_water', '添加水印', 'upload', 'switch', '0', '', '', '', '', '', '', '', 2, '', '', '', '', 1477649648, 1477649648, 100, 1);
INSERT INTO `dp_admin_config` VALUES (30, 'upload_thumb_water_pic', '水印图片', 'upload', 'image', '', '', '只有开启水印功能才生效', '', '', '', '', '', 2, '', '', '', '', 1477656390, 1477656390, 100, 1);
INSERT INTO `dp_admin_config` VALUES (31, 'upload_thumb_water_position', '水印位置', 'upload', 'radio', '9', '1:左上角\r\n2:上居中\r\n3:右上角\r\n4:左居中\r\n5:居中\r\n6:右居中\r\n7:左下角\r\n8:下居中\r\n9:右下角', '只有开启水印功能才生效', '', '', '', '', '', 2, '', '', '', '', 1477656528, 1477656528, 100, 1);
INSERT INTO `dp_admin_config` VALUES (32, 'upload_thumb_water_alpha', '水印透明度', 'upload', 'text', '50', '', '请输入0~100之间的数字，数字越小，透明度越高', '', '', '', '', '', 2, '', '', '', '', 1477656714, 1477661309, 100, 1);
INSERT INTO `dp_admin_config` VALUES (33, 'wipe_cache_type', '清除缓存类型', 'system', 'checkbox', 'TEMP_PATH', 'TEMP_PATH:应用缓存\r\nLOG_PATH:应用日志\r\nCACHE_PATH:项目模板缓存', '清除缓存时，要删除的缓存类型', '', '', '', '', '', 2, '', '', '', '', 1477727305, 1477727305, 100, 1);
INSERT INTO `dp_admin_config` VALUES (34, 'captcha_signin', '后台验证码开关', 'system', 'switch', '0', '', '后台登录时是否需要验证码', '', '', '', '', '', 2, '', '', '', '', 1478771958, 1478771958, 99, 1);
INSERT INTO `dp_admin_config` VALUES (35, 'home_default_module', '前台默认模块', 'system', 'select', 'index', '', '前台默认访问的模块，该模块必须有Index控制器和index方法', '', '', '', '', '', 0, '', '', '', '', 1486714723, 1486715620, 104, 1);
INSERT INTO `dp_admin_config` VALUES (36, 'minify_status', '开启minify', 'system', 'switch', '0', '', '开启minify会压缩合并js、css文件，可以减少资源请求次数，如果不支持minify，可关闭', '', '', '', '', '', 0, '', '', '', '', 1487035843, 1487035843, 99, 1);
INSERT INTO `dp_admin_config` VALUES (37, 'upload_driver', '上传驱动', 'upload', 'radio', 'local', 'local:本地', '图片或文件上传驱动', '', '', '', '', '', 0, '', '', '', '', 1501488567, 1501490821, 100, 1);
INSERT INTO `dp_admin_config` VALUES (38, 'system_log', '系统日志', 'system', 'switch', '1', '', '是否开启系统日志功能', '', '', '', '', '', 0, '', '', '', '', 1512635391, 1512635391, 99, 1);
INSERT INTO `dp_admin_config` VALUES (39, 'asset_version', '资源版本号', 'develop', 'text', '20180327', '', '可通过修改版号强制用户更新静态文件', '', '', '', '', '', 0, '', '', '', '', 1522143239, 1522143239, 100, 1);

-- ----------------------------
-- Table structure for dp_admin_hook
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_hook`;
CREATE TABLE `dp_admin_hook`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '钩子名称',
  `plugin` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '钩子来自哪个插件',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '钩子描述',
  `system` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否为系统钩子',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `status` tinyint(2) NOT NULL DEFAULT 1 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 18 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '钩子表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_admin_hook
-- ----------------------------
INSERT INTO `dp_admin_hook` VALUES (1, 'admin_index', '', '后台首页', 1, 1468174214, 1477757518, 1);
INSERT INTO `dp_admin_hook` VALUES (2, 'plugin_index_tab_list', '', '插件扩展tab钩子', 1, 1468174214, 1468174214, 1);
INSERT INTO `dp_admin_hook` VALUES (3, 'module_index_tab_list', '', '模块扩展tab钩子', 1, 1468174214, 1468174214, 1);
INSERT INTO `dp_admin_hook` VALUES (4, 'page_tips', '', '每个页面的提示', 1, 1468174214, 1468174214, 1);
INSERT INTO `dp_admin_hook` VALUES (5, 'signin_footer', '', '登录页面底部钩子', 1, 1479269315, 1479269315, 1);
INSERT INTO `dp_admin_hook` VALUES (6, 'signin_captcha', '', '登录页面验证码钩子', 1, 1479269315, 1479269315, 1);
INSERT INTO `dp_admin_hook` VALUES (7, 'signin', '', '登录控制器钩子', 1, 1479386875, 1479386875, 1);
INSERT INTO `dp_admin_hook` VALUES (8, 'upload_attachment', '', '附件上传钩子', 1, 1501493808, 1501493808, 1);
INSERT INTO `dp_admin_hook` VALUES (9, 'page_plugin_js', '', '页面插件js钩子', 1, 1503633591, 1503633591, 1);
INSERT INTO `dp_admin_hook` VALUES (10, 'page_plugin_css', '', '页面插件css钩子', 1, 1503633591, 1503633591, 1);
INSERT INTO `dp_admin_hook` VALUES (11, 'signin_sso', '', '单点登录钩子', 1, 1503633591, 1503633591, 1);
INSERT INTO `dp_admin_hook` VALUES (12, 'signout_sso', '', '单点退出钩子', 1, 1503633591, 1503633591, 1);
INSERT INTO `dp_admin_hook` VALUES (13, 'user_add', '', '添加用户钩子', 1, 1503633591, 1503633591, 1);
INSERT INTO `dp_admin_hook` VALUES (14, 'user_edit', '', '编辑用户钩子', 1, 1503633591, 1503633591, 1);
INSERT INTO `dp_admin_hook` VALUES (15, 'user_delete', '', '删除用户钩子', 1, 1503633591, 1503633591, 1);
INSERT INTO `dp_admin_hook` VALUES (16, 'user_enable', '', '启用用户钩子', 1, 1503633591, 1503633591, 1);
INSERT INTO `dp_admin_hook` VALUES (17, 'user_disable', '', '禁用用户钩子', 1, 1503633591, 1503633591, 1);

-- ----------------------------
-- Table structure for dp_admin_hook_plugin
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_hook_plugin`;
CREATE TABLE `dp_admin_hook_plugin`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hook` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '钩子id',
  `plugin` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '插件标识',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '添加时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `sort` int(11) UNSIGNED NOT NULL DEFAULT 100 COMMENT '排序',
  `status` tinyint(2) NOT NULL DEFAULT 1 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '钩子-插件对应表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_admin_hook_plugin
-- ----------------------------
INSERT INTO `dp_admin_hook_plugin` VALUES (1, 'admin_index', 'SystemInfo', 1477757503, 1477757503, 1, 1);
INSERT INTO `dp_admin_hook_plugin` VALUES (2, 'admin_index', 'DevTeam', 1477755780, 1477755780, 2, 1);

-- ----------------------------
-- Table structure for dp_admin_icon
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_icon`;
CREATE TABLE `dp_admin_icon`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图标名称',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图标css地址',
  `prefix` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图标前缀',
  `font_family` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '字体名',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '图标表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_admin_icon
-- ----------------------------

-- ----------------------------
-- Table structure for dp_admin_icon_list
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_icon_list`;
CREATE TABLE `dp_admin_icon_list`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `icon_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '所属图标id',
  `title` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图标标题',
  `class` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图标类名',
  `code` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图标关键词',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '详细图标列表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_admin_icon_list
-- ----------------------------

-- ----------------------------
-- Table structure for dp_admin_log
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_log`;
CREATE TABLE `dp_admin_log`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `action_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '行为id',
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '执行用户id',
  `action_ip` bigint(20) NOT NULL COMMENT '执行行为者ip',
  `model` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '触发行为的表',
  `record_id` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '触发行为的数据id',
  `remark` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '日志备注',
  `status` tinyint(2) NOT NULL DEFAULT 1 COMMENT '状态',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '执行行为的时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `action_ip_ix`(`action_ip`) USING BTREE,
  INDEX `action_id_ix`(`action_id`) USING BTREE,
  INDEX `user_id_ix`(`user_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '行为日志表' ROW_FORMAT = FIXED;

-- ----------------------------
-- Records of dp_admin_log
-- ----------------------------

-- ----------------------------
-- Table structure for dp_admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_menu`;
CREATE TABLE `dp_admin_menu`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '上级菜单id',
  `module` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '模块名称',
  `title` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '菜单标题',
  `icon` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '菜单图标',
  `url_type` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '链接类型（link：外链，module：模块）',
  `url_value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '链接地址',
  `url_target` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '_self' COMMENT '链接打开方式：_blank,_self',
  `online_hide` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '网站上线后是否隐藏',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT 100 COMMENT '排序',
  `system_menu` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否为系统菜单，系统菜单不可删除',
  `status` tinyint(2) NOT NULL DEFAULT 1 COMMENT '状态',
  `params` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '参数',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 340 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '后台菜单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_admin_menu
-- ----------------------------
INSERT INTO `dp_admin_menu` VALUES (1, 0, 'admin', '首页', 'fa fa-fw fa-home', 'module_admin', 'admin/index/index', '_self', 0, 1467617722, 1477710540, 1, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (2, 1, 'admin', '快捷操作', 'fa fa-fw fa-folder-open-o', 'module_admin', '', '_self', 0, 1467618170, 1477710695, 1, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (3, 2, 'admin', '清空缓存', 'fa fa-fw fa-trash-o', 'module_admin', 'admin/index/wipecache', '_self', 0, 1467618273, 1489049773, 3, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (4, 0, 'admin', '系统', 'fa fa-fw fa-gear', 'module_admin', 'admin/system/index', '_self', 0, 1467618361, 1477710540, 2, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (5, 4, 'admin', '系统功能', 'si si-wrench', 'module_admin', '', '_self', 0, 1467618441, 1477710695, 1, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (6, 5, 'admin', '系统设置', 'fa fa-fw fa-wrench', 'module_admin', 'admin/system/index', '_self', 0, 1467618490, 1477710695, 1, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (7, 5, 'admin', '配置管理', 'fa fa-fw fa-gears', 'module_admin', 'admin/config/index', '_self', 0, 1467618618, 1477710695, 2, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (8, 7, 'admin', '新增', '', 'module_admin', 'admin/config/add', '_self', 0, 1467618648, 1477710695, 1, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (9, 7, 'admin', '编辑', '', 'module_admin', 'admin/config/edit', '_self', 0, 1467619566, 1477710695, 2, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (10, 7, 'admin', '删除', '', 'module_admin', 'admin/config/delete', '_self', 0, 1467619583, 1477710695, 3, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (11, 7, 'admin', '启用', '', 'module_admin', 'admin/config/enable', '_self', 0, 1467619609, 1477710695, 4, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (12, 7, 'admin', '禁用', '', 'module_admin', 'admin/config/disable', '_self', 0, 1467619637, 1477710695, 5, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (13, 5, 'admin', '节点管理', 'fa fa-fw fa-bars', 'module_admin', 'admin/menu/index', '_self', 0, 1467619882, 1477710695, 3, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (14, 13, 'admin', '新增', '', 'module_admin', 'admin/menu/add', '_self', 0, 1467619902, 1477710695, 1, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (15, 13, 'admin', '编辑', '', 'module_admin', 'admin/menu/edit', '_self', 0, 1467620331, 1477710695, 2, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (16, 13, 'admin', '删除', '', 'module_admin', 'admin/menu/delete', '_self', 0, 1467620363, 1477710695, 3, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (17, 13, 'admin', '启用', '', 'module_admin', 'admin/menu/enable', '_self', 0, 1467620386, 1477710695, 4, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (18, 13, 'admin', '禁用', '', 'module_admin', 'admin/menu/disable', '_self', 0, 1467620404, 1477710695, 5, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (19, 68, 'user', '权限管理', 'fa fa-fw fa-key', 'module_admin', '', '_self', 0, 1467688065, 1477710702, 1, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (20, 19, 'user', '用户管理', 'fa fa-fw fa-user', 'module_admin', 'user/index/index', '_self', 0, 1467688137, 1477710702, 1, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (21, 20, 'user', '新增', '', 'module_admin', 'user/index/add', '_self', 0, 1467688177, 1477710702, 1, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (22, 20, 'user', '编辑', '', 'module_admin', 'user/index/edit', '_self', 0, 1467688202, 1477710702, 2, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (23, 20, 'user', '删除', '', 'module_admin', 'user/index/delete', '_self', 0, 1467688219, 1477710702, 3, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (24, 20, 'user', '启用', '', 'module_admin', 'user/index/enable', '_self', 0, 1467688238, 1477710702, 4, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (25, 20, 'user', '禁用', '', 'module_admin', 'user/index/disable', '_self', 0, 1467688256, 1477710702, 5, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (211, 64, 'admin', '日志详情', '', 'module_admin', 'admin/log/details', '_self', 0, 1480299320, 1480299320, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (32, 4, 'admin', '扩展中心', 'si si-social-dropbox', 'module_admin', '', '_self', 0, 1467688853, 1477710695, 2, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (33, 32, 'admin', '模块管理', 'fa fa-fw fa-th-large', 'module_admin', 'admin/module/index', '_self', 0, 1467689008, 1477710695, 1, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (34, 33, 'admin', '导入', '', 'module_admin', 'admin/module/import', '_self', 0, 1467689153, 1477710695, 1, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (35, 33, 'admin', '导出', '', 'module_admin', 'admin/module/export', '_self', 0, 1467689173, 1477710695, 2, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (36, 33, 'admin', '安装', '', 'module_admin', 'admin/module/install', '_self', 0, 1467689192, 1477710695, 3, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (37, 33, 'admin', '卸载', '', 'module_admin', 'admin/module/uninstall', '_self', 0, 1467689241, 1477710695, 4, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (38, 33, 'admin', '启用', '', 'module_admin', 'admin/module/enable', '_self', 0, 1467689294, 1477710695, 5, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (39, 33, 'admin', '禁用', '', 'module_admin', 'admin/module/disable', '_self', 0, 1467689312, 1477710695, 6, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (40, 33, 'admin', '更新', '', 'module_admin', 'admin/module/update', '_self', 0, 1467689341, 1477710695, 7, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (41, 32, 'admin', '插件管理', 'fa fa-fw fa-puzzle-piece', 'module_admin', 'admin/plugin/index', '_self', 0, 1467689527, 1477710695, 2, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (42, 41, 'admin', '导入', '', 'module_admin', 'admin/plugin/import', '_self', 0, 1467689650, 1477710695, 1, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (43, 41, 'admin', '导出', '', 'module_admin', 'admin/plugin/export', '_self', 0, 1467689665, 1477710695, 2, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (44, 41, 'admin', '安装', '', 'module_admin', 'admin/plugin/install', '_self', 0, 1467689680, 1477710695, 3, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (45, 41, 'admin', '卸载', '', 'module_admin', 'admin/plugin/uninstall', '_self', 0, 1467689700, 1477710695, 4, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (46, 41, 'admin', '启用', '', 'module_admin', 'admin/plugin/enable', '_self', 0, 1467689730, 1477710695, 5, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (47, 41, 'admin', '禁用', '', 'module_admin', 'admin/plugin/disable', '_self', 0, 1467689747, 1477710695, 6, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (48, 41, 'admin', '设置', '', 'module_admin', 'admin/plugin/config', '_self', 0, 1467689789, 1477710695, 7, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (49, 41, 'admin', '管理', '', 'module_admin', 'admin/plugin/manage', '_self', 0, 1467689846, 1477710695, 8, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (50, 5, 'admin', '附件管理', 'fa fa-fw fa-cloud-upload', 'module_admin', 'admin/attachment/index', '_self', 0, 1467690161, 1477710695, 4, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (51, 70, 'admin', '文件上传', '', 'module_admin', 'admin/attachment/upload', '_self', 0, 1467690240, 1489049773, 1, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (52, 50, 'admin', '下载', '', 'module_admin', 'admin/attachment/download', '_self', 0, 1467690334, 1477710695, 2, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (53, 50, 'admin', '启用', '', 'module_admin', 'admin/attachment/enable', '_self', 0, 1467690352, 1477710695, 3, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (54, 50, 'admin', '禁用', '', 'module_admin', 'admin/attachment/disable', '_self', 0, 1467690369, 1477710695, 4, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (55, 50, 'admin', '删除', '', 'module_admin', 'admin/attachment/delete', '_self', 0, 1467690396, 1477710695, 5, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (56, 41, 'admin', '删除', '', 'module_admin', 'admin/plugin/delete', '_self', 0, 1467858065, 1477710695, 11, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (57, 41, 'admin', '编辑', '', 'module_admin', 'admin/plugin/edit', '_self', 0, 1467858092, 1477710695, 10, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (60, 41, 'admin', '新增', '', 'module_admin', 'admin/plugin/add', '_self', 0, 1467858421, 1477710695, 9, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (61, 41, 'admin', '执行', '', 'module_admin', 'admin/plugin/execute', '_self', 0, 1467879016, 1477710695, 14, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (62, 13, 'admin', '保存', '', 'module_admin', 'admin/menu/save', '_self', 0, 1468073039, 1477710695, 6, 1, 1, '');
INSERT INTO `dp_admin_menu` VALUES (64, 5, 'admin', '系统日志', 'fa fa-fw fa-book', 'module_admin', 'admin/log/index', '_self', 0, 1476111944, 1477710695, 6, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (65, 5, 'admin', '数据库管理', 'fa fa-fw fa-database', 'module_admin', 'admin/database/index', '_self', 0, 1476111992, 1477710695, 8, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (66, 32, 'admin', '数据包管理', 'fa fa-fw fa-database', 'module_admin', 'admin/packet/index', '_self', 0, 1476112326, 1477710695, 4, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (67, 19, 'user', '角色管理', 'fa fa-fw fa-users', 'module_admin', 'user/role/index', '_self', 0, 1476113025, 1477710702, 3, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (68, 0, 'user', '用户', 'fa fa-fw fa-user', 'module_admin', 'user/index/index', '_self', 0, 1476193348, 1477710540, 3, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (69, 32, 'admin', '钩子管理', 'fa fa-fw fa-anchor', 'module_admin', 'admin/hook/index', '_self', 0, 1476236193, 1477710695, 3, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (70, 2, 'admin', '后台首页', 'fa fa-fw fa-tachometer', 'module_admin', 'admin/index/index', '_self', 0, 1476237472, 1489049773, 1, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (71, 67, 'user', '新增', '', 'module_admin', 'user/role/add', '_self', 0, 1476256935, 1477710702, 1, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (72, 67, 'user', '编辑', '', 'module_admin', 'user/role/edit', '_self', 0, 1476256968, 1477710702, 2, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (73, 67, 'user', '删除', '', 'module_admin', 'user/role/delete', '_self', 0, 1476256993, 1477710702, 3, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (74, 67, 'user', '启用', '', 'module_admin', 'user/role/enable', '_self', 0, 1476257023, 1477710702, 4, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (75, 67, 'user', '禁用', '', 'module_admin', 'user/role/disable', '_self', 0, 1476257046, 1477710702, 5, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (76, 20, 'user', '授权', '', 'module_admin', 'user/index/access', '_self', 0, 1476375187, 1477710702, 6, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (77, 69, 'admin', '新增', '', 'module_admin', 'admin/hook/add', '_self', 0, 1476668971, 1477710695, 1, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (78, 69, 'admin', '编辑', '', 'module_admin', 'admin/hook/edit', '_self', 0, 1476669006, 1477710695, 2, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (79, 69, 'admin', '删除', '', 'module_admin', 'admin/hook/delete', '_self', 0, 1476669375, 1477710695, 3, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (80, 69, 'admin', '启用', '', 'module_admin', 'admin/hook/enable', '_self', 0, 1476669427, 1477710695, 4, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (81, 69, 'admin', '禁用', '', 'module_admin', 'admin/hook/disable', '_self', 0, 1476669564, 1477710695, 5, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (183, 66, 'admin', '安装', '', 'module_admin', 'admin/packet/install', '_self', 0, 1476851362, 1477710695, 1, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (184, 66, 'admin', '卸载', '', 'module_admin', 'admin/packet/uninstall', '_self', 0, 1476851382, 1477710695, 2, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (185, 5, 'admin', '行为管理', 'fa fa-fw fa-bug', 'module_admin', 'admin/action/index', '_self', 0, 1476882441, 1477710695, 7, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (186, 185, 'admin', '新增', '', 'module_admin', 'admin/action/add', '_self', 0, 1476884439, 1477710695, 1, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (187, 185, 'admin', '编辑', '', 'module_admin', 'admin/action/edit', '_self', 0, 1476884464, 1477710695, 2, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (188, 185, 'admin', '启用', '', 'module_admin', 'admin/action/enable', '_self', 0, 1476884493, 1477710695, 3, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (189, 185, 'admin', '禁用', '', 'module_admin', 'admin/action/disable', '_self', 0, 1476884534, 1477710695, 4, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (190, 185, 'admin', '删除', '', 'module_admin', 'admin/action/delete', '_self', 0, 1476884551, 1477710695, 5, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (191, 65, 'admin', '备份数据库', '', 'module_admin', 'admin/database/export', '_self', 0, 1476972746, 1477710695, 1, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (192, 65, 'admin', '还原数据库', '', 'module_admin', 'admin/database/import', '_self', 0, 1476972772, 1477710695, 2, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (193, 65, 'admin', '优化表', '', 'module_admin', 'admin/database/optimize', '_self', 0, 1476972800, 1477710695, 3, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (194, 65, 'admin', '修复表', '', 'module_admin', 'admin/database/repair', '_self', 0, 1476972825, 1477710695, 4, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (195, 65, 'admin', '删除备份', '', 'module_admin', 'admin/database/delete', '_self', 0, 1476973457, 1477710695, 5, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (210, 41, 'admin', '快速编辑', '', 'module_admin', 'admin/plugin/quickedit', '_self', 0, 1477713981, 1477713981, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (209, 185, 'admin', '快速编辑', '', 'module_admin', 'admin/action/quickedit', '_self', 0, 1477713939, 1477713939, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (208, 7, 'admin', '快速编辑', '', 'module_admin', 'admin/config/quickedit', '_self', 0, 1477713808, 1477713808, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (207, 69, 'admin', '快速编辑', '', 'module_admin', 'admin/hook/quickedit', '_self', 0, 1477713770, 1477713770, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (212, 2, 'admin', '个人设置', 'fa fa-fw fa-user', 'module_admin', 'admin/index/profile', '_self', 0, 1489049767, 1489049773, 2, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (213, 70, 'admin', '检查版本更新', '', 'module_admin', 'admin/index/checkupdate', '_self', 0, 1490588610, 1490588610, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (214, 68, 'user', '消息管理', 'fa fa-fw fa-comments-o', 'module_admin', '', '_self', 0, 1520492129, 1520492129, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (215, 214, 'user', '消息列表', 'fa fa-fw fa-th-list', 'module_admin', 'user/message/index', '_self', 0, 1520492195, 1520492195, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (216, 215, 'user', '新增', '', 'module_admin', 'user/message/add', '_self', 0, 1520492195, 1520492195, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (217, 215, 'user', '编辑', '', 'module_admin', 'user/message/edit', '_self', 0, 1520492195, 1520492195, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (218, 215, 'user', '删除', '', 'module_admin', 'user/message/delete', '_self', 0, 1520492195, 1520492195, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (219, 215, 'user', '启用', '', 'module_admin', 'user/message/enable', '_self', 0, 1520492195, 1520492195, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (220, 215, 'user', '禁用', '', 'module_admin', 'user/message/disable', '_self', 0, 1520492195, 1520492195, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (221, 215, 'user', '快速编辑', '', 'module_admin', 'user/message/quickedit', '_self', 0, 1520492195, 1520492195, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (222, 2, 'admin', '消息中心', 'fa fa-fw fa-comments-o', 'module_admin', 'admin/message/index', '_self', 0, 1520495992, 1520496254, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (223, 222, 'admin', '删除', '', 'module_admin', 'admin/message/delete', '_self', 0, 1520495992, 1520496263, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (224, 222, 'admin', '启用', '', 'module_admin', 'admin/message/enable', '_self', 0, 1520495992, 1520496270, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (225, 32, 'admin', '图标管理', 'fa fa-fw fa-tint', 'module_admin', 'admin/icon/index', '_self', 0, 1520908295, 1520908295, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (226, 225, 'admin', '新增', '', 'module_admin', 'admin/icon/add', '_self', 0, 1520908295, 1520908295, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (227, 225, 'admin', '编辑', '', 'module_admin', 'admin/icon/edit', '_self', 0, 1520908295, 1520908295, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (228, 225, 'admin', '删除', '', 'module_admin', 'admin/icon/delete', '_self', 0, 1520908295, 1520908295, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (229, 225, 'admin', '启用', '', 'module_admin', 'admin/icon/enable', '_self', 0, 1520908295, 1520908295, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (230, 225, 'admin', '禁用', '', 'module_admin', 'admin/icon/disable', '_self', 0, 1520908295, 1520908295, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (231, 225, 'admin', '快速编辑', '', 'module_admin', 'admin/icon/quickedit', '_self', 0, 1520908295, 1520908295, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (232, 225, 'admin', '图标列表', '', 'module_admin', 'admin/icon/items', '_self', 0, 1520923368, 1520923368, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (233, 225, 'admin', '更新图标', '', 'module_admin', 'admin/icon/reload', '_self', 0, 1520931908, 1520931908, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (234, 20, 'user', '快速编辑', '', 'module_admin', 'user/index/quickedit', '_self', 0, 1526028258, 1526028258, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (235, 67, 'user', '快速编辑', '', 'module_admin', 'user/role/quickedit', '_self', 0, 1526028282, 1526028282, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (236, 6, 'admin', '快速编辑', '', 'module_admin', 'admin/system/quickedit', '_self', 0, 1559054310, 1559054310, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (237, 0, 'cms', '门户', 'fa fa-fw fa-newspaper-o', 'module_admin', 'cms/index/index', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (238, 237, 'cms', '常用操作', 'fa fa-fw fa-folder-open-o', 'module_admin', '', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (239, 238, 'cms', '仪表盘', 'fa fa-fw fa-tachometer', 'module_admin', 'cms/index/index', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (240, 238, 'cms', '发布文档', 'fa fa-fw fa-plus', 'module_admin', 'cms/document/add', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (241, 238, 'cms', '文档列表', 'fa fa-fw fa-list', 'module_admin', 'cms/document/index', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (242, 241, 'cms', '编辑', '', 'module_admin', 'cms/document/edit', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (243, 241, 'cms', '删除', '', 'module_admin', 'cms/document/delete', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (244, 241, 'cms', '启用', '', 'module_admin', 'cms/document/enable', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (245, 241, 'cms', '禁用', '', 'module_admin', 'cms/document/disable', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (246, 241, 'cms', '快速编辑', '', 'module_admin', 'cms/document/quickedit', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (247, 238, 'cms', '单页管理', 'fa fa-fw fa-file-word-o', 'module_admin', 'cms/page/index', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (248, 247, 'cms', '新增', '', 'module_admin', 'cms/page/add', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (249, 247, 'cms', '编辑', '', 'module_admin', 'cms/page/edit', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (250, 247, 'cms', '删除', '', 'module_admin', 'cms/page/delete', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (251, 247, 'cms', '启用', '', 'module_admin', 'cms/page/enable', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (252, 247, 'cms', '禁用', '', 'module_admin', 'cms/page/disable', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (253, 247, 'cms', '快速编辑', '', 'module_admin', 'cms/page/quickedit', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (254, 238, 'cms', '回收站', 'fa fa-fw fa-recycle', 'module_admin', 'cms/recycle/index', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (255, 254, 'cms', '删除', '', 'module_admin', 'cms/recycle/delete', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (256, 254, 'cms', '还原', '', 'module_admin', 'cms/recycle/restore', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (257, 237, 'cms', '内容管理', 'fa fa-fw fa-th-list', 'module_admin', '', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (258, 237, 'cms', '营销管理', 'fa fa-fw fa-money', 'module_admin', '', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (259, 258, 'cms', '广告管理', 'fa fa-fw fa-handshake-o', 'module_admin', 'cms/advert/index', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (260, 259, 'cms', '新增', '', 'module_admin', 'cms/advert/add', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (261, 259, 'cms', '编辑', '', 'module_admin', 'cms/advert/edit', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (262, 259, 'cms', '删除', '', 'module_admin', 'cms/advert/delete', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (263, 259, 'cms', '启用', '', 'module_admin', 'cms/advert/enable', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (264, 259, 'cms', '禁用', '', 'module_admin', 'cms/advert/disable', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (265, 259, 'cms', '快速编辑', '', 'module_admin', 'cms/advert/quickedit', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (266, 259, 'cms', '广告分类', '', 'module_admin', 'cms/advert_type/index', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (267, 266, 'cms', '新增', '', 'module_admin', 'cms/advert_type/add', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (268, 266, 'cms', '编辑', '', 'module_admin', 'cms/advert_type/edit', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (269, 266, 'cms', '删除', '', 'module_admin', 'cms/advert_type/delete', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (270, 266, 'cms', '启用', '', 'module_admin', 'cms/advert_type/enable', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (271, 266, 'cms', '禁用', '', 'module_admin', 'cms/advert_type/disable', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (272, 266, 'cms', '快速编辑', '', 'module_admin', 'cms/advert_type/quickedit', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (273, 258, 'cms', '滚动图片', 'fa fa-fw fa-photo', 'module_admin', 'cms/slider/index', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (274, 273, 'cms', '新增', '', 'module_admin', 'cms/slider/add', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (275, 273, 'cms', '编辑', '', 'module_admin', 'cms/slider/edit', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (276, 273, 'cms', '删除', '', 'module_admin', 'cms/slider/delete', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (277, 273, 'cms', '启用', '', 'module_admin', 'cms/slider/enable', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (278, 273, 'cms', '禁用', '', 'module_admin', 'cms/slider/disable', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (279, 273, 'cms', '快速编辑', '', 'module_admin', 'cms/slider/quickedit', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (280, 258, 'cms', '友情链接', 'fa fa-fw fa-link', 'module_admin', 'cms/link/index', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (281, 280, 'cms', '新增', '', 'module_admin', 'cms/link/add', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (282, 280, 'cms', '编辑', '', 'module_admin', 'cms/link/edit', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (283, 280, 'cms', '删除', '', 'module_admin', 'cms/link/delete', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (284, 280, 'cms', '启用', '', 'module_admin', 'cms/link/enable', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (285, 280, 'cms', '禁用', '', 'module_admin', 'cms/link/disable', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (286, 280, 'cms', '快速编辑', '', 'module_admin', 'cms/link/quickedit', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (287, 258, 'cms', '客服管理', 'fa fa-fw fa-commenting', 'module_admin', 'cms/support/index', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (288, 287, 'cms', '新增', '', 'module_admin', 'cms/support/add', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (289, 287, 'cms', '编辑', '', 'module_admin', 'cms/support/edit', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (290, 287, 'cms', '删除', '', 'module_admin', 'cms/support/delete', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (291, 287, 'cms', '启用', '', 'module_admin', 'cms/support/enable', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (292, 287, 'cms', '禁用', '', 'module_admin', 'cms/support/disable', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (293, 287, 'cms', '快速编辑', '', 'module_admin', 'cms/support/quickedit', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (294, 237, 'cms', '门户设置', 'fa fa-fw fa-sliders', 'module_admin', '', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (295, 294, 'cms', '栏目分类', 'fa fa-fw fa-sitemap', 'module_admin', 'cms/column/index', '_self', 1, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (296, 295, 'cms', '新增', '', 'module_admin', 'cms/column/add', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (297, 295, 'cms', '编辑', '', 'module_admin', 'cms/column/edit', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (298, 295, 'cms', '删除', '', 'module_admin', 'cms/column/delete', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (299, 295, 'cms', '启用', '', 'module_admin', 'cms/column/enable', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (300, 295, 'cms', '禁用', '', 'module_admin', 'cms/column/disable', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (301, 295, 'cms', '快速编辑', '', 'module_admin', 'cms/column/quickedit', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (302, 294, 'cms', '内容模型', 'fa fa-fw fa-th-large', 'module_admin', 'cms/model/index', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (303, 302, 'cms', '新增', '', 'module_admin', 'cms/model/add', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (304, 302, 'cms', '编辑', '', 'module_admin', 'cms/model/edit', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (305, 302, 'cms', '删除', '', 'module_admin', 'cms/model/delete', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (306, 302, 'cms', '启用', '', 'module_admin', 'cms/model/enable', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (307, 302, 'cms', '禁用', '', 'module_admin', 'cms/model/disable', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (308, 302, 'cms', '快速编辑', '', 'module_admin', 'cms/model/quickedit', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (309, 302, 'cms', '字段管理', '', 'module_admin', 'cms/field/index', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (310, 309, 'cms', '新增', '', 'module_admin', 'cms/field/add', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (311, 309, 'cms', '编辑', '', 'module_admin', 'cms/field/edit', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (312, 309, 'cms', '删除', '', 'module_admin', 'cms/field/delete', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (313, 309, 'cms', '启用', '', 'module_admin', 'cms/field/enable', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (314, 309, 'cms', '禁用', '', 'module_admin', 'cms/field/disable', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (315, 309, 'cms', '快速编辑', '', 'module_admin', 'cms/field/quickedit', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (316, 294, 'cms', '导航管理', 'fa fa-fw fa-map-signs', 'module_admin', 'cms/nav/index', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (317, 316, 'cms', '新增', '', 'module_admin', 'cms/nav/add', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (318, 316, 'cms', '编辑', '', 'module_admin', 'cms/nav/edit', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (319, 316, 'cms', '删除', '', 'module_admin', 'cms/nav/delete', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (320, 316, 'cms', '启用', '', 'module_admin', 'cms/nav/enable', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (321, 316, 'cms', '禁用', '', 'module_admin', 'cms/nav/disable', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (322, 316, 'cms', '快速编辑', '', 'module_admin', 'cms/nav/quickedit', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (323, 316, 'cms', '菜单管理', '', 'module_admin', 'cms/menu/index', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (324, 323, 'cms', '新增', '', 'module_admin', 'cms/menu/add', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (325, 323, 'cms', '编辑', '', 'module_admin', 'cms/menu/edit', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (326, 323, 'cms', '删除', '', 'module_admin', 'cms/menu/delete', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (327, 323, 'cms', '启用', '', 'module_admin', 'cms/menu/enable', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (328, 323, 'cms', '禁用', '', 'module_admin', 'cms/menu/disable', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (329, 323, 'cms', '快速编辑', '', 'module_admin', 'cms/menu/quickedit', '_self', 0, 1714970498, 1714970498, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (330, 0, 'journal', '期刊', '', 'module_admin', 'journal/index/index', '_self', 1, 1714971281, 1714971281, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (331, 330, 'journal', '期刊', '', 'module_admin', 'journal/index/index', '_self', 0, 1714971281, 1714971281, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (332, 331, 'journal', '新增', '', 'module_admin', 'journal/index/add', '_self', 0, 1714971281, 1714971281, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (333, 331, 'journal', '编辑', '', 'module_admin', 'journal/index/edit', '_self', 0, 1714971281, 1714971281, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (334, 331, 'journal', '删除', '', 'module_admin', 'journal/index/delete', '_self', 0, 1714971281, 1714971281, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (335, 331, 'journal', '启用', '', 'module_admin', 'journal/index/enable', '_self', 0, 1714971281, 1714971281, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (336, 331, 'journal', '禁用', '', 'module_admin', 'journal/index/disable', '_self', 0, 1714971281, 1714971281, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (337, 331, 'journal', '快速编辑', '', 'module_admin', 'journal/index/quickedit', '_self', 0, 1714971281, 1714971281, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (338, 331, 'journal', '开启采集', '', 'module_admin', 'journal/index/start', '_self', 0, 1714971281, 1714971281, 100, 0, 1, '');
INSERT INTO `dp_admin_menu` VALUES (339, 331, 'journal', '停止采集', '', 'module_admin', 'journal/index/stop', '_self', 0, 1714971281, 1714971281, 100, 0, 1, '');

-- ----------------------------
-- Table structure for dp_admin_message
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_message`;
CREATE TABLE `dp_admin_message`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid_receive` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '接收消息的用户id',
  `uid_send` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '发送消息的用户id',
  `type` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '消息分类',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '消息内容',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `read_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '阅读时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '消息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_admin_message
-- ----------------------------

-- ----------------------------
-- Table structure for dp_admin_module
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_module`;
CREATE TABLE `dp_admin_module`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '模块名称（标识）',
  `title` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '模块标题',
  `icon` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图标',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '描述',
  `author` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '作者',
  `author_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '作者主页',
  `config` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '配置信息',
  `access` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '授权配置',
  `version` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '版本号',
  `identifier` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '模块唯一标识符',
  `system_module` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否为系统模块',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT 100 COMMENT '排序',
  `status` tinyint(2) NOT NULL DEFAULT 1 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '模块表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_admin_module
-- ----------------------------
INSERT INTO `dp_admin_module` VALUES (1, 'admin', '系统', 'fa fa-fw fa-gear', '系统模块，DolphinPHP的核心模块', 'DolphinPHP', 'http://www.dolphinphp.com', '', '', '1.0.0', 'admin.dolphinphp.module', 1, 1468204902, 1468204902, 100, 1);
INSERT INTO `dp_admin_module` VALUES (2, 'user', '用户', 'fa fa-fw fa-user', '用户模块，DolphinPHP自带模块', 'DolphinPHP', 'http://www.dolphinphp.com', '', '', '1.0.0', 'user.dolphinphp.module', 1, 1468204902, 1468204902, 100, 1);
INSERT INTO `dp_admin_module` VALUES (3, 'cms', '门户', 'fa fa-fw fa-newspaper-o', '门户模块', 'CaiWeiMing', 'http://www.dolphinphp.com', '{\"summary\":0,\"contact\":\"<div class=\\\"font-s13 push\\\"><strong>\\u6cb3\\u6e90\\u5e02\\u5353\\u9510\\u79d1\\u6280\\u6709\\u9650\\u516c\\u53f8<\\/strong><br \\/>\\r\\n\\u5730\\u5740\\uff1a\\u6cb3\\u6e90\\u5e02\\u6c5f\\u4e1c\\u65b0\\u533a\\u4e1c\\u73af\\u8def\\u6c47\\u901a\\u82d1D3-H232<br \\/>\\r\\n\\u7535\\u8bdd\\uff1a0762-8910006<br \\/>\\r\\n\\u90ae\\u7bb1\\uff1aadmin@zrthink.com<\\/div>\",\"meta_head\":\"\",\"meta_foot\":\"\",\"support_status\":1,\"support_color\":\"rgba(0,158,232,1)\",\"support_wx\":\"\",\"support_extra\":\"\"}', '{\"column\":{\"title\":\"\\u680f\\u76ee\\u6388\\u6743\",\"nodes\":{\"group\":\"column\",\"table_name\":\"cms_column\",\"primary_key\":\"id\",\"parent_id\":\"pid\",\"node_name\":\"name\"}}}', '1.0.0', 'cms.ming.module', 0, 1714970498, 1714970498, 100, 1);
INSERT INTO `dp_admin_module` VALUES (4, 'journal', '期刊', 'si si-book-open', '期刊模块', 'yangweijie', 'yangweijie.cn', NULL, NULL, '1.0.0', 'journal.yangweijie.plugin', 0, 1714971281, 1714971281, 100, 1);

-- ----------------------------
-- Table structure for dp_admin_packet
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_packet`;
CREATE TABLE `dp_admin_packet`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '数据包名',
  `title` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '数据包标题',
  `author` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '作者',
  `author_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '作者url',
  `version` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tables` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '数据表名',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `status` tinyint(2) NOT NULL DEFAULT 1 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '数据包表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_admin_packet
-- ----------------------------

-- ----------------------------
-- Table structure for dp_admin_plugin
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_plugin`;
CREATE TABLE `dp_admin_plugin`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '插件名称',
  `title` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '插件标题',
  `icon` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图标',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '插件描述',
  `author` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '作者',
  `author_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '作者主页',
  `config` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '配置信息',
  `version` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '版本号',
  `identifier` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '插件唯一标识符',
  `admin` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否有后台管理',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '安装时间',
  `update_time` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT 100 COMMENT '排序',
  `status` tinyint(2) NOT NULL DEFAULT 1 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '插件表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_admin_plugin
-- ----------------------------
INSERT INTO `dp_admin_plugin` VALUES (1, 'SystemInfo', '系统环境信息', 'fa fa-fw fa-info-circle', '在后台首页显示服务器信息', '蔡伟明', 'http://www.caiweiming.com', '{\"display\":\"1\",\"width\":\"6\"}', '1.0.0', 'system_info.ming.plugin', 0, 1477757503, 1477757503, 100, 1);
INSERT INTO `dp_admin_plugin` VALUES (2, 'DevTeam', '开发团队成员信息', 'fa fa-fw fa-users', '开发团队成员信息', '蔡伟明', 'http://www.caiweiming.com', '{\"display\":\"1\",\"width\":\"6\"}', '1.0.0', 'dev_team.ming.plugin', 0, 1477755780, 1477755780, 100, 1);

-- ----------------------------
-- Table structure for dp_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_role`;
CREATE TABLE `dp_admin_role`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `pid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '上级角色',
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '角色名称',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '角色描述',
  `menu_auth` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '菜单权限',
  `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `status` tinyint(2) NOT NULL DEFAULT 1 COMMENT '状态',
  `access` tinyint(4) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否可登录后台',
  `default_module` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '默认访问模块',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '角色表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_admin_role
-- ----------------------------
INSERT INTO `dp_admin_role` VALUES (1, 0, '超级管理员', '系统默认创建的角色，拥有最高权限', '', 0, 1476270000, 1468117612, 1, 1, 0);

-- ----------------------------
-- Table structure for dp_admin_user
-- ----------------------------
DROP TABLE IF EXISTS `dp_admin_user`;
CREATE TABLE `dp_admin_user`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `nickname` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '昵称',
  `password` varchar(96) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '密码',
  `email` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '邮箱地址',
  `email_bind` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否绑定邮箱地址',
  `mobile` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '手机号码',
  `mobile_bind` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否绑定手机号码',
  `avatar` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '头像',
  `money` decimal(11, 2) UNSIGNED NOT NULL DEFAULT 0.00 COMMENT '余额',
  `score` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '积分',
  `role` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '主角色ID',
  `roles` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '副角色ID',
  `group` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '部门id',
  `signup_ip` bigint(20) UNSIGNED NOT NULL DEFAULT 0 COMMENT '注册ip',
  `create_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '更新时间',
  `last_login_time` datetime NULL DEFAULT NULL COMMENT '最后一次登录时间',
  `last_login_ip` bigint(20) UNSIGNED NOT NULL DEFAULT 0 COMMENT '登录ip',
  `sort` int(11) NOT NULL DEFAULT 100 COMMENT '排序',
  `status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '状态：0禁用，1启用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_admin_user
-- ----------------------------
INSERT INTO `dp_admin_user` VALUES (1, 'admin', '超级管理员', '$2y$10$Brw6wmuSLIIx3Yabid8/Wu5l8VQ9M/H/CG3C9RqN9dUCwZW3ljGOK', '', 0, '', 0, 0, 0.00, 0, 1, '', 0, 0, 1476065410, 1714971230, '2024-05-06 12:53:49', 127001, 100, 1);

-- ----------------------------
-- Table structure for dp_cms_advert
-- ----------------------------
DROP TABLE IF EXISTS `dp_cms_advert`;
CREATE TABLE `dp_cms_advert`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `typeid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '分类id',
  `tagname` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '广告位标识',
  `ad_type` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '广告类型',
  `timeset` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '时间限制:0-永不过期,1-在设内时间内有效',
  `start_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '开始时间',
  `end_time` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '结束时间',
  `name` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '广告位名称',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '广告内容',
  `expcontent` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '过期显示内容',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '广告表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_cms_advert
-- ----------------------------

-- ----------------------------
-- Table structure for dp_cms_advert_type
-- ----------------------------
DROP TABLE IF EXISTS `dp_cms_advert_type`;
CREATE TABLE `dp_cms_advert_type`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '广告分类表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_cms_advert_type
-- ----------------------------

-- ----------------------------
-- Table structure for dp_cms_column
-- ----------------------------
DROP TABLE IF EXISTS `dp_cms_column`;
CREATE TABLE `dp_cms_column`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '父级id',
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '栏目名称',
  `model` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '文档模型id',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '链接',
  `target` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '_self' COMMENT '链接打开方式',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '内容',
  `icon` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '字体图标',
  `index_template` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '封面模板',
  `list_template` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '列表页模板',
  `detail_template` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '详情页模板',
  `post_auth` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '投稿权限',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT 100 COMMENT '排序',
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态',
  `hide` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否隐藏',
  `rank_auth` int(11) NOT NULL DEFAULT 0 COMMENT '浏览权限，-1待审核，0为开放浏览，大于0则为对应的用户角色id',
  `type` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '栏目属性：0-最终列表栏目，1-外部链接，2-频道封面',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '栏目表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_cms_column
-- ----------------------------

-- ----------------------------
-- Table structure for dp_cms_document
-- ----------------------------
DROP TABLE IF EXISTS `dp_cms_document`;
CREATE TABLE `dp_cms_document`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '栏目id',
  `model` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '文档模型ID',
  `title` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `shorttitle` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '简略标题',
  `uid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户ID',
  `flag` set('j','p','b','s','a','f','c','h') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '自定义属性',
  `view` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '阅读量',
  `comment` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '评论数',
  `good` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '点赞数',
  `bad` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '踩数',
  `mark` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '收藏数量',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT 100 COMMENT '排序',
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态',
  `trash` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '回收站',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '文档基础表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_cms_document
-- ----------------------------

-- ----------------------------
-- Table structure for dp_cms_field
-- ----------------------------
DROP TABLE IF EXISTS `dp_cms_field`;
CREATE TABLE `dp_cms_field`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '字段名称',
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `title` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '字段标题',
  `type` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '字段类型',
  `define` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '字段定义',
  `value` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '默认值',
  `options` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '额外选项',
  `tips` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '提示说明',
  `fixed` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否为固定字段',
  `show` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否显示',
  `model` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '所属文档模型id',
  `ajax_url` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '联动下拉框ajax地址',
  `next_items` varchar(256) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '联动下拉框的下级下拉框名，多个以逗号隔开',
  `param` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '联动下拉框请求参数名',
  `format` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '格式，用于格式文本',
  `table` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '表名，只用于快速联动类型',
  `level` tinyint(2) UNSIGNED NOT NULL DEFAULT 2 COMMENT '联动级别，只用于快速联动类型',
  `key` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '键字段，只用于快速联动类型',
  `option` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '值字段，只用于快速联动类型',
  `pid` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '父级id字段，只用于快速联动类型',
  `ak` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '百度地图appkey',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT 100 COMMENT '排序',
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '文档字段表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_cms_field
-- ----------------------------
INSERT INTO `dp_cms_field` VALUES (1, 'id', 'ID', 'text', 'int(11) UNSIGNED NOT NULL', '0', '', 'ID', 0, 0, 0, '', '', '', '', '', 0, '', '', '', '', '2015-09-18 11:22:33', '2015-09-18 11:22:33', 100, 1);
INSERT INTO `dp_cms_field` VALUES (2, 'cid', '栏目', 'select', 'int(11) UNSIGNED NOT NULL', '0', '', '请选择所属栏目', 0, 0, 0, '', '', '', '', '', 0, '', '', '', '', '2015-09-18 11:22:33', '2015-09-18 11:22:33', 100, 1);
INSERT INTO `dp_cms_field` VALUES (3, 'uid', '用户ID', 'text', 'int(11) UNSIGNED NOT NULL', '0', '', '', 0, 0, 0, '', '', '', '', '', 0, '', '', '', '', '2015-09-18 11:22:33', '2015-09-18 11:22:33', 100, 1);
INSERT INTO `dp_cms_field` VALUES (4, 'model', '模型ID', 'text', 'int(11) UNSIGNED NOT NULL', '0', '', '', 0, 0, 0, '', '', '', '', '', 0, '', '', '', '', '2015-09-18 11:22:33', '2015-09-18 11:22:33', 100, 1);
INSERT INTO `dp_cms_field` VALUES (5, 'title', '标题', 'text', 'varchar(128) NOT NULL', '', '', '文档标题', 0, 1, 0, '', '', '', '', '', 0, '', '', '', '', '2015-09-18 11:22:33', '2015-09-18 11:22:33', 1, 1);
INSERT INTO `dp_cms_field` VALUES (6, 'shorttitle', '简略标题', 'text', 'varchar(32) NOT NULL', '', '', '简略标题', 0, 1, 0, '', '', '', '', '', 0, '', '', '', '', '2015-09-18 11:22:33', '2015-09-18 11:22:33', 1, 1);
INSERT INTO `dp_cms_field` VALUES (7, 'flag', '自定义属性', 'checkbox', 'set(\'j\',\'p\',\'b\',\'s\',\'a\',\'f\',\'h\',\'c\') NULL DEFAULT NULL', '', 'j:跳转\r\np:图片\r\nb:加粗\r\ns:滚动\r\na:特荐\r\nf:幻灯\r\nh:头条\r\nc:推荐', '自定义属性', 0, 1, 0, '', '', '', '', '', 0, '', '', '', '', '2015-09-18 11:22:33', '2015-09-18 11:22:33', 100, 1);
INSERT INTO `dp_cms_field` VALUES (8, 'view', '阅读量', 'text', 'int(11) UNSIGNED NOT NULL', '0', '', '', 0, 1, 0, '', '', '', '', '', 0, '', '', '', '', '2015-09-18 11:22:33', '2015-09-18 11:22:33', 100, 1);
INSERT INTO `dp_cms_field` VALUES (9, 'comment', '评论数', 'text', 'int(11) UNSIGNED NOT NULL', '0', '', '', 0, 0, 0, '', '', '', '', '', 0, '', '', '', '', '2015-09-18 11:22:33', '2015-09-18 11:22:33', 100, 1);
INSERT INTO `dp_cms_field` VALUES (10, 'good', '点赞数', 'text', 'int(11) UNSIGNED NOT NULL', '0', '', '', 0, 0, 0, '', '', '', '', '', 0, '', '', '', '', '2015-09-18 11:22:33', '2015-09-18 11:22:33', 100, 1);
INSERT INTO `dp_cms_field` VALUES (11, 'bad', '踩数', 'text', 'int(11) UNSIGNED NOT NULL', '0', '', '', 0, 0, 0, '', '', '', '', '', 0, '', '', '', '', '2015-09-18 11:22:33', '2015-09-18 11:22:33', 100, 1);
INSERT INTO `dp_cms_field` VALUES (12, 'mark', '收藏数量', 'text', 'int(11) UNSIGNED NOT NULL', '0', '', '', 0, 0, 0, '', '', '', '', '', 0, '', '', '', '', '2015-09-18 11:22:33', '2015-09-18 11:22:33', 100, 1);
INSERT INTO `dp_cms_field` VALUES (13, 'create_time', '创建时间', 'datetime', 'int(11) UNSIGNED NOT NULL', '0', '', '', 0, 0, 0, '', '', '', '', '', 0, '', '', '', '', '2015-09-18 11:22:33', '2015-09-18 11:22:33', 100, 1);
INSERT INTO `dp_cms_field` VALUES (14, 'update_time', '更新时间', 'datetime', 'int(11) UNSIGNED NOT NULL', '0', '', '', 0, 0, 0, '', '', '', '', '', 0, '', '', '', '', '2015-09-18 11:22:33', '2015-09-18 11:22:33', 100, 1);
INSERT INTO `dp_cms_field` VALUES (15, 'sort', '排序', 'text', 'int(11) NOT NULL', '100', '', '', 0, 1, 0, '', '', '', '', '', 0, '', '', '', '', '2015-09-18 11:22:33', '2015-09-18 11:22:33', 100, 1);
INSERT INTO `dp_cms_field` VALUES (16, 'status', '状态', 'radio', 'tinyint(2) UNSIGNED NOT NULL', '1', '0:禁用\r\n1:启用', '', 0, 1, 0, '', '', '', '', '', 0, '', '', '', '', '2015-09-18 11:22:33', '2015-09-18 11:22:33', 100, 1);
INSERT INTO `dp_cms_field` VALUES (17, 'trash', '回收站', 'text', 'tinyint(2) UNSIGNED NOT NULL', '0', '', '', 0, 0, 0, '', '', '', '', '', 0, '', '', '', '', '2015-09-18 11:22:33', '2015-09-18 11:22:33', 100, 1);

-- ----------------------------
-- Table structure for dp_cms_link
-- ----------------------------
DROP TABLE IF EXISTS `dp_cms_link`;
CREATE TABLE `dp_cms_link`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` tinyint(2) UNSIGNED NOT NULL DEFAULT 1 COMMENT '类型：1-文字链接，2-图片链接',
  `title` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '链接标题',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '链接地址',
  `logo` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '链接LOGO',
  `contact` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '联系方式',
  `sort` int(11) NOT NULL DEFAULT 100,
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '有钱链接表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_cms_link
-- ----------------------------

-- ----------------------------
-- Table structure for dp_cms_menu
-- ----------------------------
DROP TABLE IF EXISTS `dp_cms_menu`;
CREATE TABLE `dp_cms_menu`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '导航id',
  `pid` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '父级id',
  `column` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '栏目id',
  `page` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '单页id',
  `type` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '类型：0-栏目链接，1-单页链接，2-自定义链接',
  `title` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '菜单标题',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '链接',
  `css` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'css类',
  `rel` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '链接关系网',
  `target` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '打开方式',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT 100 COMMENT '排序',
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '菜单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_cms_menu
-- ----------------------------
INSERT INTO `dp_cms_menu` VALUES (1, 1, 0, 0, 0, 2, '首页', 'cms/index/index', '', '', '_self', '2015-09-18 11:22:33', '2015-09-18 11:22:33', 100, 1);
INSERT INTO `dp_cms_menu` VALUES (2, 2, 0, 0, 0, 2, '关于我们', 'http://www.dolphinphp.com', '', '', '_self', '2015-09-18 11:22:33', '2015-09-18 11:22:33', 100, 1);
INSERT INTO `dp_cms_menu` VALUES (3, 3, 0, 0, 0, 2, '开发文档', 'http://www.kancloud.cn/ming5112/dolphinphp', '', '', '_self', '2015-09-18 11:22:33', '2015-09-18 11:22:33', 100, 1);
INSERT INTO `dp_cms_menu` VALUES (4, 3, 0, 0, 0, 2, '开发者社区', 'http://bbs.dolphinphp.com/', '', '', '_self', '2015-09-18 11:22:33', '2015-09-18 11:22:33', 100, 1);
INSERT INTO `dp_cms_menu` VALUES (5, 1, 0, 0, 0, 2, '二级菜单', 'http://www.dolphinphp.com', '', '', '_self', '2015-09-18 11:22:33', '2015-09-18 11:22:33', 100, 1);
INSERT INTO `dp_cms_menu` VALUES (6, 1, 5, 0, 0, 2, '子菜单', 'http://www.dolphinphp.com', '', '', '_self', '2015-09-18 11:22:33', '2015-09-18 11:22:33', 100, 1);

-- ----------------------------
-- Table structure for dp_cms_model
-- ----------------------------
DROP TABLE IF EXISTS `dp_cms_model`;
CREATE TABLE `dp_cms_model`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '模型名称',
  `title` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '模型标题',
  `table` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '附加表名称',
  `type` tinyint(2) NOT NULL DEFAULT 1 COMMENT '模型类别：0-系统模型，1-普通模型，2-独立模型',
  `icon` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sort` int(11) NOT NULL DEFAULT 100 COMMENT '排序',
  `system` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否系统模型',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '内容模型表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_cms_model
-- ----------------------------

-- ----------------------------
-- Table structure for dp_cms_nav
-- ----------------------------
DROP TABLE IF EXISTS `dp_cms_nav`;
CREATE TABLE `dp_cms_nav`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tag` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '导航标识',
  `title` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '菜单标题',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '导航表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_cms_nav
-- ----------------------------
INSERT INTO `dp_cms_nav` VALUES (1, 'main_nav', '顶部导航', '2015-09-18 11:22:33', '2015-09-18 11:22:33', 1);
INSERT INTO `dp_cms_nav` VALUES (2, 'about_nav', '底部关于', '2015-09-18 11:22:33', '2015-09-18 11:22:33', 1);
INSERT INTO `dp_cms_nav` VALUES (3, 'support_nav', '服务与支持', '2015-09-18 11:22:33', '2015-09-18 11:22:33', 1);

-- ----------------------------
-- Table structure for dp_cms_page
-- ----------------------------
DROP TABLE IF EXISTS `dp_cms_page`;
CREATE TABLE `dp_cms_page`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '单页标题',
  `content` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '单页内容',
  `keywords` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '关键词',
  `description` varchar(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '页面描述',
  `template` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '模板文件',
  `cover` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '单页封面',
  `view` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '阅读量',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '单页表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_cms_page
-- ----------------------------

-- ----------------------------
-- Table structure for dp_cms_slider
-- ----------------------------
DROP TABLE IF EXISTS `dp_cms_slider`;
CREATE TABLE `dp_cms_slider`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `cover` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '封面id',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '链接地址',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `sort` int(11) UNSIGNED NOT NULL DEFAULT 100 COMMENT '排序',
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '滚动图片表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_cms_slider
-- ----------------------------

-- ----------------------------
-- Table structure for dp_cms_support
-- ----------------------------
DROP TABLE IF EXISTS `dp_cms_support`;
CREATE TABLE `dp_cms_support`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '客服名称',
  `qq` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'QQ',
  `msn` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'msn',
  `taobao` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'taobao',
  `alibaba` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'alibaba',
  `skype` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'skype',
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT 0 COMMENT '状态',
  `sort` int(11) UNSIGNED NOT NULL DEFAULT 100 COMMENT '排序',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '客服表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dp_cms_support
-- ----------------------------

-- ----------------------------
-- Table structure for dp_journal
-- ----------------------------
DROP TABLE IF EXISTS `dp_journal`;
CREATE TABLE `dp_journal`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '',
  `cover` int(11) NULL DEFAULT 0,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '类型  rss or url',
  `rule` varchar(4096) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '采集规则',
  `total` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '总已采集期数 默认为0',
  `create_time` datetime NULL DEFAULT NULL,
  `update_time` datetime NULL DEFAULT NULL,
  `sync_time` datetime NULL DEFAULT NULL COMMENT '同步时间',
  `status` int(1) UNSIGNED NULL DEFAULT 1 COMMENT '是否启用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of dp_journal
-- ----------------------------

-- ----------------------------
-- Table structure for dp_journal_content
-- ----------------------------
DROP TABLE IF EXISTS `dp_journal_content`;
CREATE TABLE `dp_journal_content`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `journal_id` int(11) UNSIGNED NULL DEFAULT 0 COMMENT '期刊id',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '期刊名称',
  `content` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '内容',
  `create_time` datetime NULL DEFAULT NULL,
  `update_time` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of dp_journal_content
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
