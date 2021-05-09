/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : demo

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 10/05/2021 02:16:39
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for family
-- ----------------------------
DROP TABLE IF EXISTS `family`;
CREATE TABLE `family`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `father_id` int(11) NULL DEFAULT NULL,
  `mother_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of family
-- ----------------------------
INSERT INTO `family` VALUES (1, '王大锤', 'men', '1990-01-01', 3, 4);
INSERT INTO `family` VALUES (2, '王尼美', 'women', '1990-02-01', 3, 4);
INSERT INTO `family` VALUES (3, '王建国', 'men', '1970-03-04', NULL, NULL);
INSERT INTO `family` VALUES (4, '李秀英', 'women', '1970-03-03', NULL, NULL);
INSERT INTO `family` VALUES (5, '赵铁柱', 'men', '2010-04-04', NULL, 2);
INSERT INTO `family` VALUES (6, '王小明', 'men', '2010-05-05', 1, NULL);
INSERT INTO `family` VALUES (7, '王大名', 'men', '1991-01-01', 3, 4);
INSERT INTO `family` VALUES (8, '王笑笑', 'women', '2011-05-05', 7, NULL);
INSERT INTO `family` VALUES (9, '王小虎', 'men', '2021-01-02', 1, NULL);
INSERT INTO `family` VALUES (10, '王小龙', 'men', '2020-02-01', 1, NULL);
INSERT INTO `family` VALUES (12, '王漂亮', 'women', '1987-02-02', 3, 4);

SET FOREIGN_KEY_CHECKS = 1;
