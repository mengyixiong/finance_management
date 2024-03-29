/*
 Navicat Premium Data Transfer

 Source Server         : 本地
 Source Server Type    : MySQL
 Source Server Version : 80031
 Source Host           : localhost:3306
 Source Schema         : finance

 Target Server Type    : MySQL
 Target Server Version : 80031
 File Encoding         : 65001

 Date: 30/03/2024 00:42:16
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for system_menus
-- ----------------------------
DROP TABLE IF EXISTS `system_menus`;
CREATE TABLE `system_menus`  (
  `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '菜单ID',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL COMMENT '组件名称',
  `title` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '' COMMENT '名称',
  `pid` smallint UNSIGNED NOT NULL DEFAULT 0 COMMENT '父级id',
  `icon` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '' COMMENT '图标',
  `rank` tinyint NOT NULL DEFAULT 1 COMMENT '排序',
  `mark` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '' COMMENT '备注',
  `path` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '路径',
  `route` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '路由',
  `is_header` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否顶部菜单1是0否',
  `is_show` tinyint UNSIGNED NOT NULL DEFAULT 1 COMMENT '是否为隐藏菜单0=隐藏菜单,1=显示菜单',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '删除时间',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `create_by` smallint NOT NULL DEFAULT 0 COMMENT '创建人',
  `update_by` smallint NOT NULL DEFAULT 0 COMMENT '更新人',
  `delete_by` smallint NULL DEFAULT NULL COMMENT '删除人',
  `type` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'M' COMMENT 'M为菜单，B为按钮',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `pid`(`pid` ASC) USING BTREE,
  INDEX `is_show`(`is_show` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3506 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci COMMENT = '菜单表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of system_menus
-- ----------------------------
INSERT INTO `system_menus` VALUES (1, 'Welcome', '首页', 0, '', 0, '', '/welcome/system_menu', 'welcome:index', 0, 1, '2024-03-30 00:17:01', NULL, '2024-03-30 00:17:24', 0, 0, NULL, 'M');
INSERT INTO `system_menus` VALUES (2, 'FinanceData', '基础资料', 0, '', 1, '', '/finance_data', 'finance_data', 0, 1, '2024-03-30 00:06:08', NULL, '2024-03-30 00:17:23', 0, 0, NULL, 'M');
INSERT INTO `system_menus` VALUES (3, 'AccountingSubject', '会计科目', 2, '', 2, '', '/finance_data/accounting_subject', 'inance_data:accounting_subject:index', 0, 1, '2024-03-30 00:07:42', NULL, '2024-03-30 00:27:45', 0, 0, NULL, 'M');
INSERT INTO `system_menus` VALUES (4, 'Currency', '币别汇率', 2, '', 3, '', '/finance_data/currency', 'finance_data:currency:index', 0, 1, '2024-03-30 00:08:27', NULL, '2024-03-30 00:27:45', 0, 0, NULL, 'M');
INSERT INTO `system_menus` VALUES (5, 'System', '系统设置', 0, '', 4, '', '/system', 'system', 0, 1, '2024-03-30 00:13:48', NULL, '2024-03-30 00:17:20', 0, 0, NULL, 'M');
INSERT INTO `system_menus` VALUES (6, 'SystemUser', '管理员', 5, '', 5, '', '/system/system_user', 'system:system_user:index', 0, 1, '2024-03-30 00:14:35', NULL, '2024-03-30 00:27:49', 0, 0, NULL, 'M');
INSERT INTO `system_menus` VALUES (7, 'SystemRole', '角色管理', 5, '', 6, '', '/system/system_role', 'system:system_role:index', 0, 1, '2024-03-30 00:15:45', NULL, '2024-03-30 00:27:49', 0, 0, NULL, 'M');
INSERT INTO `system_menus` VALUES (8, 'SystemMenu', '菜单管理', 5, '', 6, '', '/system/system_menu', 'system:system_menu:index', 0, 1, '2024-03-30 00:16:22', NULL, '2024-03-30 00:27:49', 0, 0, NULL, 'M');

-- ----------------------------
-- Table structure for system_role
-- ----------------------------
DROP TABLE IF EXISTS `system_role`;
CREATE TABLE `system_role`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '身份管理id',
  `role_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '' COMMENT '身份管理名称',
  `desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '描述',
  `level` tinyint UNSIGNED NOT NULL DEFAULT 0 COMMENT '管理员等级',
  `status` tinyint UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '删除时间',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `create_by` smallint NOT NULL DEFAULT 0 COMMENT '创建人',
  `update_by` smallint NOT NULL DEFAULT 0 COMMENT '更新人',
  `delete_by` smallint NULL DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `role_name`(`role_name` ASC) USING BTREE,
  INDEX `status`(`status` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci COMMENT = '身份管理表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of system_role
-- ----------------------------
INSERT INTO `system_role` VALUES (1, '管理员', '', 0, 1, '2024-03-29 21:28:54', NULL, '2024-03-29 21:28:54', 0, 0, NULL);

-- ----------------------------
-- Table structure for system_user
-- ----------------------------
DROP TABLE IF EXISTS `system_user`;
CREATE TABLE `system_user`  (
  `id` smallint UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '表ID',
  `username` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '' COMMENT '账号',
  `head_pic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '头像',
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '密码',
  `real_name` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '姓名',
  `roles` json NOT NULL COMMENT '权限(menus_id)',
  `last_ip` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '最后一次登录ip',
  `login_count` int UNSIGNED NOT NULL DEFAULT 0 COMMENT '登录次数',
  `status` tinyint UNSIGNED NOT NULL DEFAULT 1 COMMENT '状态 1有效0无效',
  `dept` int NOT NULL DEFAULT 0 COMMENT '部门',
  `last_time` datetime NULL DEFAULT NULL COMMENT '最后一次登录时间',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `delete_time` datetime NULL DEFAULT NULL COMMENT '删除时间',
  `update_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `create_by` smallint NOT NULL DEFAULT 0 COMMENT '创建人',
  `update_by` smallint NOT NULL DEFAULT 0 COMMENT '更新人',
  `delete_by` smallint NULL DEFAULT NULL COMMENT '删除人',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `account`(`username` ASC) USING BTREE,
  INDEX `status`(`status` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '后台管理员表' ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of system_user
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
