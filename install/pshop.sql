SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;

DROP TABLE IF EXISTS `userinfo`;
CREATE TABLE `userinfo` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(30) NOT NULL,
  `account_password` varchar(120) NOT NULL,
  `email` varchar(50) NOT NULL,
  `userName` varchar(30) DEFAULT NULL,
  `phone_number` varchar(30) DEFAULT NULL,
  `user_address` varchar(60) DEFAULT NULL,
  `authority` varchar(10) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `commodity`
--

DROP TABLE IF EXISTS `commodity`;
CREATE TABLE `commodity` (
  `id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `price` int(20) unsigned NOT NULL,
  `amount` int(17) unsigned NOT NULL,
  `sold` int(17) unsigned NOT NULL,
  `date` date DEFAULT NULL,
  `opinion` int(3) unsigned NOT NULL,
  `opNum` int(20) unsigned NOT NULL,
  `photoName` varchar(100) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `terms`
--

DROP TABLE IF EXISTS `terms`;
CREATE TABLE `terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `taxonomy` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'category',
  `count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `terms`
--

LOCK TABLES `terms` WRITE;
INSERT INTO `terms` VALUES (1,'未分類','uncategorized','category',0);
UNLOCK TABLES;

--
-- Table structure for table `term_relationships`
--

DROP TABLE IF EXISTS `term_relationships`;
CREATE TABLE `term_relationships` (
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`term_id`),
  KEY `term_id` (`term_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `customer_id` int(5) NOT NULL,
  `commodity_id` int(20) unsigned NOT NULL,
  `amount` int(17) unsigned NOT NULL,
  `price` int(17) unsigned NOT NULL,
  `order_id` int(5) NOT NULL,
  `confirm_status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `order_id` int(5) NOT NULL AUTO_INCREMENT,
  `customer_id` int(6) NOT NULL,
  `payment_id` int(5) DEFAULT NULL,
  `confirm_status` tinyint(1) DEFAULT NULL,
  `previous_confirm_status` tinyint(4) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `inventory` tinyint(1) NOT NULL DEFAULT '0',
  `paid` varchar(10) DEFAULT NULL,
  `payment_method` varchar(10) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `ship_id` int(6) DEFAULT NULL,
  `ship_date` datetime DEFAULT NULL,
  `freight` varchar(30) DEFAULT NULL,
  `freight_price` int(17) unsigned DEFAULT NULL,
  `coupon` char(20) DEFAULT NULL,
  `coupon_price` int(17) unsigned DEFAULT NULL,
  `total_price` int(17) unsigned DEFAULT NULL,
  `final_price` int(17) unsigned DEFAULT NULL,
  `finished_date` datetime DEFAULT NULL,
  `all_finished_date` datetime DEFAULT NULL,
  `require_data` int(6) DEFAULT NULL,
  `errmsg` varchar(50) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `ship`
--

DROP TABLE IF EXISTS `ship`;
CREATE TABLE `ship` (
  `ship_id` int(5) NOT NULL AUTO_INCREMENT,
  `order_id` int(5) NOT NULL,
  `freight` varchar(30) NOT NULL,
  `customer_id` int(5) NOT NULL,
  `customer_name` varchar(30) NOT NULL,
  `customer_address` varchar(60) NOT NULL,
  `customer_phone` varchar(30) NOT NULL,
  `customer_email` varchar(50) NOT NULL,
  `ship_status` varchar(30) NOT NULL,
  PRIMARY KEY (`ship_id`,`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `ship_status`
--

DROP TABLE IF EXISTS `ship_status`;
CREATE TABLE `ship_status` (
  `ship_id` int(5) NOT NULL,
  `timestamp` datetime NOT NULL,
  `current_status` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
CREATE TABLE `coupons` (
  `coupon_id` int(5) NOT NULL AUTO_INCREMENT,
  `eng_name` varchar(255) NOT NULL DEFAULT '',
  `cht_name` varchar(255) NOT NULL DEFAULT '',
  `code` varchar(20) NOT NULL,
  `type` char(10) NOT NULL DEFAULT '',
  `discount` decimal(15,4) DEFAULT NULL,
  `shipping` tinyint(1) NOT NULL DEFAULT '1',
  `date_start` date NOT NULL,
  `date_end` date DEFAULT NULL,
  `uses_total` int(11) NOT NULL DEFAULT '0',
  `uses_limit` int(11) NOT NULL DEFAULT '-1',
  `available` tinyint(1) NOT NULL DEFAULT '1',
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`coupon_id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `coupon_used`
--

DROP TABLE IF EXISTS `coupon_used`;
CREATE TABLE `coupon_used` (
  `order_id` int(5) NOT NULL,
  `coupon_id` int(5) NOT NULL,
  `befor_final_price` int(17) unsigned NOT NULL DEFAULT '0',
  `after_final_price` int(17) unsigned NOT NULL DEFAULT '0',
  `discount` int(17) unsigned NOT NULL DEFAULT '0',
  `used_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `options`;
CREATE TABLE `options` (
  `option_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `option_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `option_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `autoload` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes',
 PRIMARY KEY (`option_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
