-- MySQL dump 10.13  Distrib 5.6.17, for Win64 (x86_64)
--
-- Host: localhost    Database: diancan
-- ------------------------------------------------------
-- Server version	5.6.17-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `dish`
--

DROP TABLE IF EXISTS `dish`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dish` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '菜品ID',
  `dish_menu_id` int(11) NOT NULL COMMENT '菜单ID',
  `dish_name` varchar(20) NOT NULL COMMENT '菜品名称',
  `dish_price` float NOT NULL COMMENT '菜品价格（单位：元）',
  `dish_open_time` char(1) DEFAULT NULL COMMENT '开放时间(0:全月开放,1:上半月,2:下半月)',
  `dish_click_count` int(11) DEFAULT '0' COMMENT '菜品被点击次数',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dish`
--

LOCK TABLES `dish` WRITE;
/*!40000 ALTER TABLE `dish` DISABLE KEYS */;
INSERT INTO `dish` VALUES (1,2,'手撕包菜饭',8,'0',2,'2014-12-01 02:47:26','2014-12-01 02:47:26'),(2,2,'小炒茄子饭',9,'0',0,'2014-12-01 02:47:26','2014-12-01 02:47:26'),(3,2,'四季豆炒肉饭',12,'0',0,'2014-12-01 02:47:26','2014-12-01 02:47:26'),(4,2,'莲藕肉片饭',12,'0',0,'2014-12-01 02:47:26','2014-12-01 02:47:26'),(5,2,'韭菜炒/煎蛋饭',10,'0',0,'2014-12-01 02:47:26','2014-12-01 02:47:26'),(6,2,'洋葱炒蛋饭',10,'0',2,'2014-12-01 02:47:26','2014-12-01 02:47:26'),(7,2,'青椒炒/煎蛋饭',10,'0',0,'2014-12-01 02:47:26','2014-12-01 02:47:26'),(8,2,'酸辣大白菜饭',10,'0',0,'2014-12-01 02:47:26','2014-12-01 02:47:26'),(9,2,'青炒土豆丝饭',10,'0',1,'2014-12-01 02:47:26','2014-12-01 02:47:26'),(10,2,'酸辣土豆丝饭',10,'0',1,'2014-12-01 02:47:26','2014-12-01 02:47:26'),(11,2,'麻婆豆腐饭',10,'0',3,'2014-12-01 02:47:26','2014-12-01 02:47:26'),(12,2,'清炒时蔬饭',10,'0',1,'2014-12-01 02:47:26','2014-12-01 02:47:26'),(14,1,'炒时蔬',2,'0',0,'2014-12-01 02:47:26','2014-12-01 02:47:26'),(15,1,'米饭250g(小)',2,'0',2,'2014-12-01 02:47:26','2014-12-01 02:47:26'),(16,1,'米饭350g(大)',3,'0',2,'2014-12-01 02:47:26','2014-12-01 02:47:26'),(17,1,'海带丝',3,'0',5,'2014-12-01 02:47:26','2014-12-01 02:47:26'),(18,1,'攸干肉片',8,'1',1,'2014-12-01 02:47:26','2014-12-01 02:47:26'),(19,1,'火腿炒蛋',8,'1',0,'2014-12-01 02:47:26','2014-12-01 02:47:26'),(21,1,'小炒肉',8,'1',0,'2014-12-01 02:47:26','2014-12-01 02:47:26'),(22,1,'番茄炒蛋',8,'1',0,'2014-12-01 02:47:26','2014-12-01 02:47:26'),(23,1,'土豆回锅肉',8,'1',0,'2014-12-01 02:47:26','2014-12-01 02:47:26'),(24,1,'鱼香肉丝',8,'1',0,'2014-12-01 23:50:35','2014-12-01 23:50:35'),(25,1,'肉末蒸水蛋',4,'1',0,'2014-12-01 23:56:41','2014-12-01 23:56:41'),(26,1,'虾米冬瓜',5,'1',1,'2014-12-01 23:57:54','2014-12-01 23:57:54'),(28,1,'包菜粉丝',5,'1',1,'2014-12-02 00:16:25','2014-12-02 00:16:25'),(29,1,'香辣土豆丝',5,'1',1,'2014-12-02 00:18:32','2014-12-02 00:18:32'),(30,1,'酸辣藕片',5,'1',1,'2014-12-02 00:22:45','2014-12-02 00:22:45'),(31,1,'干锅花菜',8,'1',0,'2014-12-02 00:28:01','2014-12-02 00:28:01'),(32,1,'豆角肉丝',8,'1',0,'2014-12-02 00:29:18','2014-12-02 00:29:18'),(34,1,'尖椒炒蛋',8,'1',0,'2014-12-02 00:30:31','2014-12-02 00:30:31'),(35,1,'红烧茄子',8,'1',0,'2014-12-02 00:30:48','2014-12-02 00:30:48'),(36,1,'萝卜牛腩',9,'1',0,'2014-12-02 00:31:35','2014-12-02 00:31:35'),(37,1,'小炒鸡',9,'1',0,'2014-12-02 00:32:13','2014-12-02 00:32:13'),(38,1,'土豆烧排骨',9,'1',1,'2014-12-02 00:32:55','2014-12-02 00:32:55'),(39,1,'红烧带鱼',9,'1',0,'2014-12-02 00:33:24','2014-12-02 00:33:24'),(40,2,'红萝卜肉丝饭',12,'0',0,'2014-12-03 23:23:49','2014-12-03 23:23:49'),(44,3,'开心每一天',12,'0',0,'2014-12-04 00:59:30','2014-12-04 00:59:30'),(45,3,'小鸡炖蘑菇',23,'0',0,'2014-12-04 01:00:24','2014-12-04 01:00:24');
/*!40000 ALTER TABLE `dish` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dish_menu`
--

DROP TABLE IF EXISTS `dish_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dish_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '菜单ID',
  `menu_name` varchar(20) NOT NULL COMMENT '菜单名称',
  `menu_telephone` varchar(20) NOT NULL COMMENT '联系电话',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dish_menu`
--

LOCK TABLES `dish_menu` WRITE;
/*!40000 ALTER TABLE `dish_menu` DISABLE KEYS */;
INSERT INTO `dish_menu` VALUES (1,'A菜单(饭饭之辈)','61619026','2014-11-30 17:37:09','2014-11-30 17:37:09'),(2,'B菜单(赣湘木桶饭)','86105551 26037722','2014-11-30 17:37:09','2014-11-30 17:37:09'),(3,'C菜单(鲜粉人家)','86105550 26037712','2014-11-30 17:37:09','2014-11-30 17:37:09');
/*!40000 ALTER TABLE `dish_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fund`
--

DROP TABLE IF EXISTS `fund`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fund` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户资金ID',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `user_balance` int(11) DEFAULT '0' COMMENT '余额',
  `user_total_amount` int(11) DEFAULT '0' COMMENT '总计充值金额',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fund`
--

LOCK TABLES `fund` WRITE;
/*!40000 ALTER TABLE `fund` DISABLE KEYS */;
INSERT INTO `fund` VALUES (1,1,0,0,'2014-12-02 18:04:07','2014-12-02 18:04:07'),(2,2,0,0,'2014-12-02 18:04:07','2014-12-02 18:04:07'),(3,3,-16,0,'2014-12-02 18:04:07','2014-12-02 18:04:07'),(4,4,0,0,'2014-12-02 18:04:07','2014-12-02 18:04:07'),(5,5,-15,0,'2014-12-02 18:04:07','2014-12-02 18:04:07'),(6,6,0,0,'2014-12-02 18:04:07','2014-12-02 18:04:07'),(7,7,0,0,'2014-12-02 18:04:07','2014-12-02 18:04:07'),(8,8,0,0,'2014-12-02 18:04:07','2014-12-02 18:04:07');
/*!40000 ALTER TABLE `fund` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_record`
--

DROP TABLE IF EXISTS `order_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_record` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '订单记录ID',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `dish_menu_id` int(11) DEFAULT NULL COMMENT '菜单ID',
  `dish_menu_name` varchar(20) NOT NULL COMMENT '菜单名称',
  `dish_id` int(11) DEFAULT NULL COMMENT '菜品ID',
  `dish_name` varchar(20) NOT NULL COMMENT '菜品名称',
  `dish_price` float(10,2) NOT NULL COMMENT '菜品价格',
  `dish_count` int(11) NOT NULL COMMENT '菜品数量',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_record`
--

LOCK TABLES `order_record` WRITE;
/*!40000 ALTER TABLE `order_record` DISABLE KEYS */;
INSERT INTO `order_record` VALUES (1,3,1,'A菜单(饭饭之辈)',15,'米饭250g(小)',2.00,1,'2014-12-04 18:23:02','2014-12-04 18:23:02'),(2,3,1,'A菜单(饭饭之辈)',38,'土豆烧排骨',9.00,1,'2014-12-04 18:23:02','2014-12-04 18:23:02'),(3,3,1,'A菜单(饭饭之辈)',28,'包菜粉丝',5.00,1,'2014-12-04 18:23:02','2014-12-04 18:23:02'),(4,5,1,'A菜单(饭饭之辈)',15,'米饭250g(小)',2.00,1,'2014-12-04 18:23:30','2014-12-04 18:23:30'),(5,5,1,'A菜单(饭饭之辈)',26,'虾米冬瓜',5.00,1,'2014-12-04 18:23:30','2014-12-04 18:23:30'),(6,5,1,'A菜单(饭饭之辈)',18,'攸干肉片',8.00,1,'2014-12-04 18:23:30','2014-12-04 18:23:30'),(7,5,2,'B菜单(赣湘木桶饭)',1,'手撕包菜饭',8.00,2,'2014-12-04 18:23:37','2014-12-04 18:23:37'),(8,5,2,'B菜单(赣湘木桶饭)',10,'酸辣土豆丝饭',10.00,1,'2014-12-04 18:23:37','2014-12-04 18:23:37');
/*!40000 ALTER TABLE `order_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recharge_record`
--

DROP TABLE IF EXISTS `recharge_record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recharge_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '充值消费记录ID',
  `user_id` int(11) NOT NULL COMMENT '充值消费用户ID',
  `change_amount` int(11) NOT NULL COMMENT '充值或消费金额',
  `createor` int(11) DEFAULT NULL COMMENT '创建用户ID',
  `type` tinyint(3) unsigned NOT NULL COMMENT '1.点餐 2 充值 3. 退款',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recharge_record`
--

LOCK TABLES `recharge_record` WRITE;
/*!40000 ALTER TABLE `recharge_record` DISABLE KEYS */;
INSERT INTO `recharge_record` VALUES (1,3,-16,3,1,'2014-12-04 18:23:02','2014-12-04 18:23:02'),(2,5,-15,5,1,'2014-12-04 18:23:30','2014-12-04 18:23:30'),(3,5,0,5,1,'2014-12-04 18:23:37','2014-12-04 18:23:37');
/*!40000 ALTER TABLE `recharge_record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `user_name` varchar(20) NOT NULL COMMENT '用户名',
  `user_spell` varchar(10) DEFAULT NULL COMMENT '用户名简拼',
  `user_sex` char(1) NOT NULL COMMENT '性别(m:男,f:女,x:未知)',
  `user_role` char(1) DEFAULT '0' COMMENT '角色(0:普通用户,1:管理员)',
  `user_praise` int(11) DEFAULT '0' COMMENT '点赞数',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '用户状态1, 5, 10',
  `created_at` datetime NOT NULL COMMENT '创建时间',
  `updated_at` datetime NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_spell` (`user_spell`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'周华辉','zhh','m','0',0,1,'2014-11-30 11:27:40','2014-11-30 11:27:40'),(2,'饶瑟','rs','f','0',0,1,'2014-11-30 11:27:40','2014-11-30 11:27:40'),(3,'贺世英','hsy','f','0',9,1,'2014-11-30 11:27:40','2014-11-30 11:27:40'),(4,'李威','lw','m','0',0,1,'2014-11-30 11:27:40','2014-11-30 11:27:40'),(5,'汪航洋','why','m','0',0,1,'2014-11-30 11:27:40','2014-11-30 11:27:40'),(6,'张进','zj','m','0',0,1,'2014-11-30 11:27:40','2014-11-30 11:27:40'),(7,'张波','zb','m','0',0,1,'2014-11-30 11:27:40','2014-11-30 11:27:40'),(8,'罗蓓','lb','f','0',5,1,'2014-11-30 11:27:40','2014-11-30 11:27:40');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-12-04 19:44:54
