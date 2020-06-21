/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100132
 Source Host           : localhost:3306
 Source Schema         : db_buktikas

 Target Server Type    : MySQL
 Target Server Version : 100132
 File Encoding         : 65001

 Date: 11/08/2019 12:29:43
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for bk_cek
-- ----------------------------
DROP TABLE IF EXISTS `bk_cek`;
CREATE TABLE `bk_cek`  (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `d_id` int(11) NULL DEFAULT NULL,
  `c_kontrak` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
  `c_kuitansi` varchar(1) CHARACTER SET latin1 COLLATE latin1_bin NULL DEFAULT '0',
  `c_bast` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
  `c_faktur` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
  `c_spp` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
  `c_bukti_pph` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
  `c_bap` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
  `c_l_kembali` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
  `c_lain` varchar(1) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT '0',
  PRIMARY KEY (`c_id`) USING BTREE,
  INDEX `fk_d_id_cek_dokumen`(`d_id`) USING BTREE,
  CONSTRAINT `fk_d_id_cek_dokumen` FOREIGN KEY (`d_id`) REFERENCES `bk_dokumen` (`d_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for bk_dokumen
-- ----------------------------
DROP TABLE IF EXISTS `bk_dokumen`;
CREATE TABLE `bk_dokumen`  (
  `d_id` int(10) NOT NULL AUTO_INCREMENT,
  `d_nomor` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `d_invoice` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `d_kepada` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `d_tgl_bukti` date NULL DEFAULT NULL,
  `d_faktor_pajak` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `d_status` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `d_status_role` int(11) NULL DEFAULT NULL,
  `d_file` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `d_barcode` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `d_jdok` enum('Proyek','Pabrik') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `w_kode` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`d_id`) USING BTREE,
  INDEX `fk_d_status_role_dokum_role`(`d_status_role`) USING BTREE,
  INDEX `fk_w_kode_dokumen_wilayah`(`w_kode`) USING BTREE,
  CONSTRAINT `fk_d_status_role_dokum_role` FOREIGN KEY (`d_status_role`) REFERENCES `bk_role` (`r_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_w_kode_dokumen_wilayah` FOREIGN KEY (`w_kode`) REFERENCES `bk_wilayah` (`w_kode`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for bk_history
-- ----------------------------
DROP TABLE IF EXISTS `bk_history`;
CREATE TABLE `bk_history`  (
  `h_id` int(11) NOT NULL AUTO_INCREMENT,
  `d_id` int(11) NULL DEFAULT NULL,
  `h_tgl` datetime(0) NULL DEFAULT NULL,
  `h_jabatan` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `h_status` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `h_ket` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`h_id`) USING BTREE,
  INDEX `fk_d_id_history_dokumen`(`d_id`) USING BTREE,
  CONSTRAINT `fk_d_id_history_dokumen` FOREIGN KEY (`d_id`) REFERENCES `bk_dokumen` (`d_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for bk_log
-- ----------------------------
DROP TABLE IF EXISTS `bk_log`;
CREATE TABLE `bk_log`  (
  `l_id` int(11) NOT NULL AUTO_INCREMENT,
  `d_id` int(11) NULL DEFAULT NULL,
  `r_id` int(11) NULL DEFAULT NULL,
  `l_in` datetime(0) NULL DEFAULT NULL,
  `l_out` datetime(0) NULL DEFAULT NULL,
  `l_status` enum('Accepted','Rejected','Delayed','Waiting') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `l_status_reject` int(255) NULL DEFAULT NULL,
  `l_ket` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`l_id`) USING BTREE,
  INDEX `fk_d_id_log_dokumen`(`d_id`) USING BTREE,
  CONSTRAINT `fk_d_id_log_dokumen` FOREIGN KEY (`d_id`) REFERENCES `bk_dokumen` (`d_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for bk_pengguna
-- ----------------------------
DROP TABLE IF EXISTS `bk_pengguna`;
CREATE TABLE `bk_pengguna`  (
  `p_id` int(11) NOT NULL AUTO_INCREMENT,
  `p_username` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `p_password` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `p_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `p_email` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `r_id` int(11) NULL DEFAULT NULL,
  `w_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`p_id`) USING BTREE,
  INDEX `fk_r_id_pengguna_role`(`r_id`) USING BTREE,
  INDEX `fk_w_id_pengguna_wilayah`(`w_id`) USING BTREE,
  CONSTRAINT `fk_r_id_pengguna_role` FOREIGN KEY (`r_id`) REFERENCES `bk_role` (`r_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_w_id_pengguna_wilayah` FOREIGN KEY (`w_id`) REFERENCES `bk_wilayah` (`w_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of bk_pengguna
-- ----------------------------
INSERT INTO `bk_pengguna` VALUES (1, 'admin', 'd669e852f4e8a5f7a7a1079d0410d295', 'Administrator', 'admin@admin.com', 1, NULL);
INSERT INTO `bk_pengguna` VALUES (2, 'prp4', 'd669e852f4e8a5f7a7a1079d0410d295', 'PPPP Proyek', 'a@a.com', 2, NULL);
INSERT INTO `bk_pengguna` VALUES (3, 'prkp', 'd669e852f4e8a5f7a7a1079d0410d295', 'KP Proyek', 'a@a.com', 3, NULL);
INSERT INTO `bk_pengguna` VALUES (4, 'prmp', 'd669e852f4e8a5f7a7a1079d0410d295', 'Manager Proyek', 'a@a.com', 4, NULL);
INSERT INTO `bk_pengguna` VALUES (5, 'prpic', 'd669e852f4e8a5f7a7a1079d0410d295', 'Manager Proyek PIC', 'a@a.com', 5, NULL);
INSERT INTO `bk_pengguna` VALUES (6, 'prdiv', 'd669e852f4e8a5f7a7a1079d0410d295', 'Manager Divisi Proyek', 'a@a.com', 6, NULL);
INSERT INTO `bk_pengguna` VALUES (7, 'pap4', 'd669e852f4e8a5f7a7a1079d0410d295', 'PPPP Pabrik', 'a@a.com', 7, NULL);
INSERT INTO `bk_pengguna` VALUES (8, 'pakp', 'd669e852f4e8a5f7a7a1079d0410d295', 'KP Pabrik', 'a@a.com', 8, NULL);
INSERT INTO `bk_pengguna` VALUES (9, 'pamp', 'd669e852f4e8a5f7a7a1079d0410d295', 'Manager Pabrik', 'a@a.com', 9, NULL);
INSERT INTO `bk_pengguna` VALUES (10, 'papic', 'd669e852f4e8a5f7a7a1079d0410d295', 'Manager Pabrik PIC', 'a@a.com', 10, NULL);
INSERT INTO `bk_pengguna` VALUES (11, 'padiv', 'd669e852f4e8a5f7a7a1079d0410d295', 'Manager Divisi Pabrik', 'a@a.com', 11, NULL);
INSERT INTO `bk_pengguna` VALUES (12, 'dokkon', 'd669e852f4e8a5f7a7a1079d0410d295', 'Dokumen Kontrol', 'a@a.com', 12, NULL);
INSERT INTO `bk_pengguna` VALUES (13, 'mdan', 'd669e852f4e8a5f7a7a1079d0410d295', 'Manager Pengadaan', 'a@a.com', 13, NULL);
INSERT INTO `bk_pengguna` VALUES (14, 'pajak', 'd669e852f4e8a5f7a7a1079d0410d295', 'Pajak', 'a@a.com', 14, NULL);
INSERT INTO `bk_pengguna` VALUES (15, 'sakt', 'd669e852f4e8a5f7a7a1079d0410d295', 'Staff Akutansi', 'a@a.com', 15, NULL);
INSERT INTO `bk_pengguna` VALUES (16, 'kakt', 'd669e852f4e8a5f7a7a1079d0410d295', 'KASI Akutansi', 'a@a.com', 16, NULL);
INSERT INTO `bk_pengguna` VALUES (17, 'kkeu', 'd669e852f4e8a5f7a7a1079d0410d295', 'KASI Keuangan', 'a@a.com', 17, NULL);
INSERT INTO `bk_pengguna` VALUES (18, 'mkeu', 'd669e852f4e8a5f7a7a1079d0410d295', 'Manager Keuangan', 'a@a.com', 18, NULL);
INSERT INTO `bk_pengguna` VALUES (19, 'dire', 'd669e852f4e8a5f7a7a1079d0410d295', 'Direksi', 'a@a.com', 19, NULL);
INSERT INTO `bk_pengguna` VALUES (20, 'sppab', 'd669e852f4e8a5f7a7a1079d0410d295', 'Staff Pengadaan Pabrik', 'a@a.com', 23, NULL);
INSERT INTO `bk_pengguna` VALUES (21, 'sproy', 'd669e852f4e8a5f7a7a1079d0410d295', 'Staff Pengadaan Proyek', 'a@a.com', 21, NULL);
INSERT INTO `bk_pengguna` VALUES (22, 'spus', 'd669e852f4e8a5f7a7a1079d0410d295', 'Staff Pengadaan Pusat', 'a@a.com', 22, NULL);
INSERT INTO `bk_pengguna` VALUES (23, 'kasir', 'd669e852f4e8a5f7a7a1079d0410d295', 'Kasir', 'a@a.com', 20, NULL);

-- ----------------------------
-- Table structure for bk_role
-- ----------------------------
DROP TABLE IF EXISTS `bk_role`;
CREATE TABLE `bk_role`  (
  `r_id` int(11) NOT NULL AUTO_INCREMENT,
  `r_nama` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `r_tipe` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `r_durasi` int(255) NULL DEFAULT NULL,
  `r_jenis` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`r_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 24 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of bk_role
-- ----------------------------
INSERT INTO `bk_role` VALUES (1, 'Administrator', 'admin', NULL, NULL);
INSERT INTO `bk_role` VALUES (2, 'PPPP Proyek', 'prp4', 5, 'Proyek');
INSERT INTO `bk_role` VALUES (3, 'KP Proyek', 'prkp', 3, 'Proyek');
INSERT INTO `bk_role` VALUES (4, 'Manager Proyek', 'prmp', 3, 'Proyek');
INSERT INTO `bk_role` VALUES (5, 'Manager Proyek PIC', 'prpic', 3, 'Proyek');
INSERT INTO `bk_role` VALUES (6, 'Manager Divisi Proyek', 'prdiv', 3, 'Proyek');
INSERT INTO `bk_role` VALUES (7, 'PPPP Pabrik', 'pap4', 4, 'Pabrik');
INSERT INTO `bk_role` VALUES (8, 'KP Pabrik', 'pakp', 3, 'Pabrik');
INSERT INTO `bk_role` VALUES (9, 'Manager Pabrik', 'pamp', 1, 'Pabrik');
INSERT INTO `bk_role` VALUES (10, 'Manager Pabrik PIC', 'papic', 3, 'Pabrik');
INSERT INTO `bk_role` VALUES (11, 'Manager Divisi Pabrik', 'padiv', 3, 'Pabrik');
INSERT INTO `bk_role` VALUES (12, 'Dokumen Kontrol', 'dokkon', 5, 'Pusat');
INSERT INTO `bk_role` VALUES (13, 'Manager Pengadaan', 'mdan', 3, 'Pusat');
INSERT INTO `bk_role` VALUES (14, 'Pajak', 'pajak', 3, 'Pusat');
INSERT INTO `bk_role` VALUES (15, 'Staff Akutansi', 'sakt', 3, 'Pusat');
INSERT INTO `bk_role` VALUES (16, 'KASI Akutansi', 'kakt', 3, 'Pusat');
INSERT INTO `bk_role` VALUES (17, 'KASI Keuangan', 'kkeu', 3, 'Pusat');
INSERT INTO `bk_role` VALUES (18, 'Manager Keuangan', 'mkeu', 3, 'Pusat');
INSERT INTO `bk_role` VALUES (19, 'Direksi', 'dire', 3, 'Pusat');
INSERT INTO `bk_role` VALUES (20, 'Kasir', 'kasir', 3, 'Pusat');
INSERT INTO `bk_role` VALUES (21, 'Staff Pengadaan Proyek', 'sproy', 3, 'Proyek');
INSERT INTO `bk_role` VALUES (22, 'Staff Pengadaan Pusat', 'spus', 2, 'Pusat');
INSERT INTO `bk_role` VALUES (23, 'Staff Pengadaan Pabrik', 'sppab', 3, 'Pabrik');

-- ----------------------------
-- Table structure for bk_uraian
-- ----------------------------
DROP TABLE IF EXISTS `bk_uraian`;
CREATE TABLE `bk_uraian`  (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `d_id` int(11) NULL DEFAULT NULL,
  `u_uraian` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `u_spkspp` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `u_kode_nasabah` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `u_debet` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `u_rupiah` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`u_id`) USING BTREE,
  INDEX `fk_d_id_uraian_dokumen`(`d_id`) USING BTREE,
  CONSTRAINT `fk_d_id_uraian_dokumen` FOREIGN KEY (`d_id`) REFERENCES `bk_dokumen` (`d_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for bk_wilayah
-- ----------------------------
DROP TABLE IF EXISTS `bk_wilayah`;
CREATE TABLE `bk_wilayah`  (
  `w_id` int(11) NOT NULL AUTO_INCREMENT,
  `w_nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `w_kode` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`w_id`) USING BTREE,
  INDEX `w_kode`(`w_kode`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
