-- MySQL dump 10.13  Distrib 8.0.36, for Linux (x86_64)
--
-- Host: localhost    Database: usk
-- ------------------------------------------------------
-- Server version	8.0.36-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `expenditures`
--

DROP TABLE IF EXISTS `expenditures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expenditures` (
  `id` int NOT NULL AUTO_INCREMENT,
  `amount` float NOT NULL,
  `payment_date` datetime NOT NULL,
  `payment_reference` varchar(100) NOT NULL,
  `paid_to_who` varchar(255) NOT NULL,
  `remarks` text NOT NULL,
  `uuid` varchar(100) NOT NULL,
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expenditures`
--

LOCK TABLES `expenditures` WRITE;
/*!40000 ALTER TABLE `expenditures` DISABLE KEYS */;
/*!40000 ALTER TABLE `expenditures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fee_past_dues`
--

DROP TABLE IF EXISTS `fee_past_dues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fee_past_dues` (
  `id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NOT NULL,
  `fee_for_month` varchar(100) NOT NULL,
  `past_due_days` int NOT NULL DEFAULT '0',
  `penalty` float NOT NULL,
  `penalty_paid` float NOT NULL DEFAULT '0',
  `paid_status` tinyint(1) NOT NULL DEFAULT '0',
  `current_balance` float NOT NULL DEFAULT '0',
  `outstanding_amount` float NOT NULL DEFAULT '0',
  `last_paid_amount` float NOT NULL DEFAULT '0',
  `payment_id` int DEFAULT NULL,
  `uuid` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fee_past_dues`
--

LOCK TABLES `fee_past_dues` WRITE;
/*!40000 ALTER TABLE `fee_past_dues` DISABLE KEYS */;
INSERT INTO `fee_past_dues` VALUES (1,13,'January 2024',30,45000,0,0,0,45000,0,NULL,'9b785ff3-0371-4af3-92f3-2f23f9b6603b','2024-02-02 00:40:28','2024-03-02 23:58:01');
/*!40000 ALTER TABLE `fee_past_dues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `id_types`
--

DROP TABLE IF EXISTS `id_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `id_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `id_types`
--

LOCK TABLES `id_types` WRITE;
/*!40000 ALTER TABLE `id_types` DISABLE KEYS */;
INSERT INTO `id_types` VALUES (1,'National Id','2023-03-28 19:41:11','2023-03-28 19:41:11'),(2,'Driving Licence','2023-03-28 19:41:11','2023-03-28 19:41:11');
/*!40000 ALTER TABLE `id_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `installments`
--

DROP TABLE IF EXISTS `installments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `installments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `installment_no` int NOT NULL,
  `installment_amount` float NOT NULL,
  `current_balance` float DEFAULT '0',
  `outstanding_amount` float NOT NULL,
  `penalt_amount` float NOT NULL DEFAULT '0',
  `past_due_days` int NOT NULL DEFAULT '0',
  `past_due_amount` float DEFAULT NULL,
  `penalt_amount_paid` float DEFAULT '0',
  `last_paid_amount` float NOT NULL DEFAULT '0',
  `date_of_last_payment` date DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `last_paid_date` date DEFAULT NULL,
  `loan_contract_id` int NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'OPEN',
  `uuid` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `installments`
--

LOCK TABLES `installments` WRITE;
/*!40000 ALTER TABLE `installments` DISABLE KEYS */;
INSERT INTO `installments` VALUES (1,1,72000,72000,0,0,0,NULL,0,72000,NULL,'2024-03-08',NULL,1,'CLOSED','9b49ad9d-e04b-4fbc-8b96-ebce04a68cec','2024-02-08 18:51:17','2024-03-02 20:16:08'),(2,2,72000,0,72000,0,0,NULL,0,0,NULL,'2024-04-08',NULL,1,'OPEN','9b49ad9d-e2bc-404e-b51e-4a28fc2c8719','2024-02-08 18:51:17','2024-02-08 18:51:17'),(3,3,72000,0,72000,0,0,NULL,0,0,NULL,'2024-05-08',NULL,1,'OPEN','9b49ad9d-e5b5-404a-86d0-51687dd71d0e','2024-02-08 18:51:17','2024-02-08 18:51:17'),(4,1,735000,0,735000,36750,0,771750,0,0,NULL,'2024-03-02',NULL,2,'OPEN','9b5fcbef-b98f-40d7-9da4-0365e127be8c','2024-02-19 18:44:16','2024-03-02 23:50:02'),(5,1,324000,0,324000,0,0,NULL,0,0,NULL,'2024-03-19',NULL,3,'OPEN','9b6103ef-b7cf-4278-bf1e-51f575f28b8e','2024-02-20 09:16:41','2024-02-20 09:16:41'),(6,2,324000,0,324000,0,0,NULL,0,0,NULL,'2024-04-19',NULL,3,'OPEN','9b6103ef-b9ca-45a1-81d4-c283cab2218d','2024-02-20 09:16:41','2024-02-20 09:16:41'),(7,3,324000,0,324000,0,0,NULL,0,0,NULL,'2024-05-19',NULL,3,'OPEN','9b6103ef-bbd2-4657-9a10-e37180022a01','2024-02-20 09:16:41','2024-02-20 09:16:41');
/*!40000 ALTER TABLE `installments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loan_applications`
--

DROP TABLE IF EXISTS `loan_applications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `loan_applications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NOT NULL,
  `amount` float NOT NULL,
  `total_loan_amount` float DEFAULT NULL,
  `plan` int NOT NULL,
  `installment_amount` float DEFAULT NULL,
  `fee_amount` float DEFAULT NULL,
  `interest_amount` float DEFAULT NULL,
  `interest_rate` float DEFAULT NULL,
  `loan_type_id` int NOT NULL,
  `level` varchar(20) DEFAULT 'initiated',
  `loan_code` varchar(20) DEFAULT NULL,
  `uuid` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loan_applications`
--

LOCK TABLES `loan_applications` WRITE;
/*!40000 ALTER TABLE `loan_applications` DISABLE KEYS */;
INSERT INTO `loan_applications` VALUES (1,11,200000,216000,1,216000,0,16000,0.8,2,'CANCELED','USKL8687211','9b47ba52-fe9d-4668-add6-c6e7bbf29d52','2024-02-07 19:35:09','2024-02-07 19:39:22'),(2,11,200000,216000,3,72000,0,16000,0.8,2,'CANCELED','USKL2030952','9b47bbd4-c939-4962-8818-cfa9cd767354','2024-02-07 19:39:22','2024-02-07 19:42:57'),(3,11,200000,216000,3,72000,0,16000,0.8,2,'GRANTED','USKL9715464','9b47bd1b-f5de-4d78-8380-11f1c18b7aa1','2024-02-07 19:42:57','2024-02-08 18:51:17'),(4,8,900000,990000,1,990000,0,90000,10,1,'initiated','USKL3815776','9b57da48-7311-444b-9ebd-9d256ae2fcdc','2024-02-15 19:57:46','2024-02-15 19:57:46'),(5,10,700000,735000,1,735000,0,35000,5,1,'GRANTED','USKL1900981','9b592e8d-2d84-443e-9865-9e1f409209b9','2024-02-16 11:49:13','2024-02-19 18:44:16'),(6,8,900000,972000,3,324000,0,72000,0.8,2,'GRANTED','USKL9794923','9b593d38-aaef-4181-a0b3-37cd9d9493fa','2024-02-16 12:30:15','2024-02-20 09:16:41');
/*!40000 ALTER TABLE `loan_applications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loan_contracts`
--

DROP TABLE IF EXISTS `loan_contracts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `loan_contracts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NOT NULL,
  `loan_application_id` int NOT NULL,
  `loan_type_id` varchar(20) DEFAULT NULL,
  `total_amount` float NOT NULL,
  `total_loan_amount` float DEFAULT NULL,
  `installment_amount` float NOT NULL,
  `plan` int NOT NULL,
  `fee_amount` float DEFAULT NULL,
  `interest_amount` float DEFAULT NULL,
  `interest_rate` float DEFAULT NULL,
  `excess_amount` float DEFAULT '0',
  `status` varchar(20) NOT NULL,
  `current_balance` float NOT NULL DEFAULT '0',
  `outstanding_amount` float NOT NULL,
  `contract_code` varchar(20) NOT NULL,
  `start_date` date DEFAULT NULL,
  `disbursment_date` date DEFAULT NULL,
  `expected_end_date` date DEFAULT NULL,
  `past_due_days` int DEFAULT NULL,
  `highest_past_due_days` int NOT NULL DEFAULT '0',
  `past_due_amount` float DEFAULT NULL,
  `penalt_amount` float DEFAULT NULL,
  `penalt_amount_paid` float DEFAULT NULL,
  `uuid` varchar(100) NOT NULL,
  `created_by` int NOT NULL,
  `date_of_last_payment` date DEFAULT NULL,
  `last_payment_amount` float DEFAULT NULL,
  `next_payment_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loan_contracts`
--

LOCK TABLES `loan_contracts` WRITE;
/*!40000 ALTER TABLE `loan_contracts` DISABLE KEYS */;
INSERT INTO `loan_contracts` VALUES (1,11,3,'2',200000,216000,72000,3,0,16000,0.8,0,'GRANTED',72000,144000,'USKL9715464','2024-02-08','2024-02-08','2024-05-08',NULL,0,0,0,0,'9b49ad9d-da35-403a-b79b-8ef0d80b65e2',4,'2024-03-02',72000,'2024-04-08','2024-02-08 18:51:17','2024-03-02 20:16:08'),(2,10,5,'1',700000,735000,735000,1,0,35000,5,0,'GRANTED',0,735000,'USKL1900981','2024-01-31','2024-01-22','2024-03-02',0,0,771750,36750,NULL,'9b5fcbef-b43c-4abc-a0c9-b0d502c6df39',8,NULL,NULL,NULL,'2024-02-19 18:44:16','2024-03-02 23:50:02'),(3,8,6,'2',900000,972000,324000,3,0,72000,0.8,0,'GRANTED',0,972000,'USKL9794923','2024-02-19','2024-02-19','2024-05-19',NULL,0,NULL,NULL,NULL,'9b6103ef-b147-46b3-909f-b48cfb1f1e27',8,NULL,NULL,NULL,'2024-02-20 09:16:41','2024-02-20 09:16:41');
/*!40000 ALTER TABLE `loan_contracts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loan_guarantors`
--

DROP TABLE IF EXISTS `loan_guarantors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `loan_guarantors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NOT NULL,
  `loan_application_id` int NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Pending',
  `comment` text,
  `uuid` varchar(100) NOT NULL,
  `attended_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loan_guarantors`
--

LOCK TABLES `loan_guarantors` WRITE;
/*!40000 ALTER TABLE `loan_guarantors` DISABLE KEYS */;
INSERT INTO `loan_guarantors` VALUES (1,1,1,'Pending',NULL,'9b47ba53-00ff-4193-828d-270d26630ca4',NULL,'2024-02-07 19:35:09','2024-02-07 19:35:09'),(2,10,1,'Pending',NULL,'9b47ba53-02ed-455a-a5b8-e1511d5e103f',NULL,'2024-02-07 19:35:09','2024-02-07 19:35:09'),(3,12,1,'Pending',NULL,'9b47ba53-04f1-483e-820f-dcc0107dfb3a',NULL,'2024-02-07 19:35:09','2024-02-07 19:35:09'),(4,1,2,'Pending',NULL,'9b47bbd4-cbc5-45ff-a2b1-0c353779e747',NULL,'2024-02-07 19:39:22','2024-02-07 19:39:22'),(5,10,2,'Pending',NULL,'9b47bbd4-ceac-4813-be4f-51bd9c507052',NULL,'2024-02-07 19:39:22','2024-02-07 19:39:22'),(6,12,2,'Pending',NULL,'9b47bbd4-d0af-42c8-bbe9-bf34bc830e14',NULL,'2024-02-07 19:39:22','2024-02-07 19:39:22'),(7,1,3,'Approved',NULL,'9b47bd1b-f802-4a79-8035-f43e86695bba','2024-02-07','2024-02-07 19:42:57','2024-02-07 23:47:39'),(8,12,3,'Approved',NULL,'9b47bd1b-fab7-4db1-b262-026ad34b74f0','2024-02-08','2024-02-07 19:42:57','2024-02-08 10:58:08'),(9,1,4,'Approved',NULL,'9b57da48-7585-4b4e-b5cb-6898d56f8cdd','2024-02-16','2024-02-15 19:57:46','2024-02-16 09:56:06'),(10,9,4,'Approved',NULL,'9b57da48-775d-460f-a519-cd84ee05ab34','2024-02-15','2024-02-15 19:57:46','2024-02-15 21:44:34'),(11,1,5,'Approved',NULL,'9b592e8d-333a-4dee-9195-e8d3dac83aab','2024-02-16','2024-02-16 11:49:14','2024-02-16 12:39:56'),(12,11,5,'Approved',NULL,'9b592e8d-3575-4a9d-96a5-bb0a0542a994','2024-02-19','2024-02-16 11:49:14','2024-02-19 11:08:46'),(13,1,6,'Approved',NULL,'9b593d38-ad58-4a79-9011-6cb90743c03b','2024-02-16','2024-02-16 12:30:15','2024-02-16 12:40:01'),(14,9,6,'Approved',NULL,'9b593d38-af0e-43c0-973c-c347f58f7397','2024-02-16','2024-02-16 12:30:15','2024-02-16 13:00:55');
/*!40000 ALTER TABLE `loan_guarantors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loan_types`
--

DROP TABLE IF EXISTS `loan_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `loan_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loan_types`
--

LOCK TABLES `loan_types` WRITE;
/*!40000 ALTER TABLE `loan_types` DISABLE KEYS */;
INSERT INTO `loan_types` VALUES (1,'Emergency Loan','2023-03-28 21:24:53','2023-03-28 21:24:53'),(2,'Normal Loan','2023-03-28 21:24:53','2023-03-28 21:24:53');
/*!40000 ALTER TABLE `loan_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member_references`
--

DROP TABLE IF EXISTS `member_references`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `member_references` (
  `id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NOT NULL,
  `refer_member_id` int NOT NULL,
  `uuid` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_references`
--

LOCK TABLES `member_references` WRITE;
/*!40000 ALTER TABLE `member_references` DISABLE KEYS */;
/*!40000 ALTER TABLE `member_references` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member_saving_summaries`
--

DROP TABLE IF EXISTS `member_saving_summaries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `member_saving_summaries` (
  `id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NOT NULL,
  `stock` float NOT NULL DEFAULT '0',
  `current_stock` float DEFAULT '0',
  `holded_stock` float NOT NULL DEFAULT '0',
  `last_stock_amount` float NOT NULL DEFAULT '0',
  `last_purchase_date` datetime DEFAULT NULL,
  `stock_for_month` varchar(255) DEFAULT NULL,
  `fee_for_month` varchar(100) DEFAULT NULL,
  `fees` float DEFAULT NULL,
  `past_due_days` int NOT NULL DEFAULT '0',
  `stock_penalty` float NOT NULL DEFAULT '0',
  `fee_past_due_days` int NOT NULL DEFAULT '0',
  `fee_penalty` float DEFAULT '0',
  `uuid` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_fee_purchase_date` date DEFAULT NULL,
  `last_fee_amount` float NOT NULL DEFAULT '0',
  `stock_penalty_excess_paid` float DEFAULT NULL,
  `stock_current_pdd` int DEFAULT '0',
  `fee_penalty_excess_paid` float NOT NULL DEFAULT '0',
  `fee_current_pdd` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_saving_summaries`
--

LOCK TABLES `member_saving_summaries` WRITE;
/*!40000 ALTER TABLE `member_saving_summaries` DISABLE KEYS */;
INSERT INTO `member_saving_summaries` VALUES (1,1,385000,0,0,200000,'2024-02-27 00:00:00','February 2024','February 2024',30000,0,0,0,0,'9b3969c3-f4eb-45ee-bdbe-d2b31a2076ec','2024-01-31 13:48:18','2024-02-27 11:23:56','2024-02-27',15000,NULL,0,0,0),(2,8,300000,0,0,250000,'2024-02-15 00:00:00','February 2024','January 2024',15000,0,0,0,0,'9b3987d3-f0fd-470e-9731-2786d0af47c7','2024-01-31 15:12:22','2024-02-15 22:44:33','2024-01-31',15000,NULL,0,0,0),(3,9,170000,0,0,85000,'2024-02-27 00:00:00','February 2024','February 2024',30000,0,0,0,0,'9b39c591-6080-4bcd-b366-936902e54f1a','2024-01-31 18:05:00','2024-02-27 17:31:37','2024-02-27',15000,NULL,0,0,0),(4,12,240000,0,0,140000,'2024-02-09 00:00:00','February 2024','February 2024',30000,0,0,0,0,'9b39c7a1-97f1-4845-b35f-c93498ba43bd','2024-01-31 18:10:46','2024-02-09 18:32:07','2024-02-09',15000,NULL,0,0,0),(5,11,100000,0,0,50000,'2024-03-02 00:00:00','February 2024','February 2024',30000,0,0,0,0,'9b39c7de-a0ed-4e10-9773-19a487330acd','2024-01-31 18:11:26','2024-03-02 20:16:40','2024-03-02',15000,NULL,0,0,0),(6,10,200000,0,0,100000,'2024-02-27 00:00:00','February 2024','February 2024',30000,0,0,0,0,'9b3bde8d-7f9a-4cf5-bf32-6518575f84ae','2024-02-01 22:06:31','2024-02-27 18:04:45','2024-02-27',15000,NULL,0,0,0),(7,13,0,0,0,0,NULL,NULL,NULL,NULL,30,45000,30,45000,'9b3c0ebb-3c00-4530-8823-3b0bb5f9e83a','2024-02-02 00:21:14','2024-03-02 23:58:01',NULL,0,NULL,30,0,30);
/*!40000 ALTER TABLE `member_saving_summaries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `members` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) NOT NULL,
  `dob` date DEFAULT NULL,
  `member_reg_id` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `id_type_id` int NOT NULL,
  `id_number` varchar(50) NOT NULL,
  `member_type` int DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Active',
  `uuid` varchar(100) NOT NULL,
  `created_by` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES (1,'Luhangano','Erasto','Lupenza','255683130185','1993-10-06','Usk0123','lupenza10@gmail.com',1,'19931006111040000129',NULL,'Active','9ae64647-aa98-47de-b3a3-64024fffd158',1,'2023-12-21 05:55:39','2023-12-21 05:55:39'),(8,'Noel','Mathew','Sumbe','255713510645','1991-05-11','USK93731','noelsumbe@gmail.com',1,'19910511161020000120',1,'Active','9b2d525f-993e-4155-a532-df3f9ab320f3',1,'2024-01-25 13:32:58','2024-01-25 13:32:58'),(9,'Lazaro','Isaac','Lazaro','255627322093','1993-05-19','USK34500','lazaroisaac36@gmail.com',1,'19930519171060000123',1,'Active','9b2d5fdf-e85d-406f-ba5a-10f0548c51b7',1,'2024-01-25 14:10:43','2024-01-25 14:10:43'),(10,'Dickson','Namson','Fissoo','255788581698','1992-06-10','USK98855','fissoonamson98@gmail.com',1,'1992061017108000124',1,'Active','9b2d8fbf-7db7-40da-99a0-9974a487b23c',1,'2024-01-25 16:24:35','2024-01-25 16:24:35'),(11,'Frank','Martin','Daniel','255684469338','1995-12-12','USK66137','Kessyfra@gmail.com',1,'199512122341170000126',1,'Active','9b2ebcd9-4ee0-4e57-8a42-2152654b2314',1,'2024-01-26 06:26:31','2024-01-26 06:26:31'),(12,'Fortunatus','Edes','Shao','255658840898','1993-09-14','USK49781','fortunatus.edes@gmail.com',1,'19930914161040000121',1,'Active','9b395084-a2a9-4c1c-b8d8-7844fa4b4545',1,'2024-01-31 12:37:43','2024-01-31 12:37:43'),(13,'Amedeus','Raphael','Kimaro','255785122441','1996-06-01','USK87773','amedeusraphael.ar@gmail.com',1,'19930601141220000227',1,'Active','9b3951b5-e0a7-40c4-85f5-a0f3f47e1b12',1,'2024-01-31 12:41:03','2024-01-31 12:41:03');
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2016_06_01_000001_create_oauth_auth_codes_table',2),(6,'2016_06_01_000002_create_oauth_access_tokens_table',2),(7,'2016_06_01_000003_create_oauth_refresh_tokens_table',2),(8,'2016_06_01_000004_create_oauth_clients_table',2),(9,'2016_06_01_000005_create_oauth_personal_access_clients_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(2,'App\\Models\\User',1),(3,'App\\Models\\User',1),(3,'App\\Models\\User',4),(3,'App\\Models\\User',5),(3,'App\\Models\\User',6),(3,'App\\Models\\User',7),(3,'App\\Models\\User',8),(3,'App\\Models\\User',9);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `client_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `client_id` bigint unsigned NOT NULL,
  `scopes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_auth_codes`
--

LOCK TABLES `oauth_auth_codes` WRITE;
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_clients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
INSERT INTO `oauth_clients` VALUES (1,NULL,'Laravel Personal Access Client','QAynzw2osVGWzsuIBHy2oQOXikga8s4wzwXJZjdW',NULL,'http://localhost',1,0,0,'2022-12-06 10:52:02','2022-12-06 10:52:02'),(2,NULL,'Laravel Password Grant Client','A2LjUZ63QWeYDhu5qC4E7zCLUHdKDWECKHA3KiTl','users','http://localhost',0,1,0,'2022-12-06 10:52:02','2022-12-06 10:52:02');
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_personal_access_clients`
--

DROP TABLE IF EXISTS `oauth_personal_access_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_personal_access_clients`
--

LOCK TABLES `oauth_personal_access_clients` WRITE;
/*!40000 ALTER TABLE `oauth_personal_access_clients` DISABLE KEYS */;
INSERT INTO `oauth_personal_access_clients` VALUES (1,1,'2022-12-06 10:52:02','2022-12-06 10:52:02');
/*!40000 ALTER TABLE `oauth_personal_access_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_requests`
--

DROP TABLE IF EXISTS `payment_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `amount` float NOT NULL,
  `payment_reference` varchar(100) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `loan_contract_id` int DEFAULT NULL,
  `member_id` int NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `added_by` int NOT NULL,
  `approved_by` int DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `payment_for_month` varchar(20) DEFAULT NULL,
  `comment` text,
  `attended_date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_requests`
--

LOCK TABLES `payment_requests` WRITE;
/*!40000 ALTER TABLE `payment_requests` DISABLE KEYS */;
INSERT INTO `payment_requests` VALUES (1,185000,'101AGD224031B202-1','2024-01-31','stock',NULL,1,'9b394b44-e7c9-46bb-bfab-8fd7b7bc37ba',1,8,1,'January 2024',NULL,NULL,'2024-01-31 12:23:02','2024-01-31 13:48:25'),(2,15000,'101AGD224031B202-2','2024-01-31','fee',NULL,1,'9b394b86-00f8-41f1-a6f7-f009c88216f5',1,8,1,'January 2024',NULL,NULL,'2024-01-31 12:23:45','2024-01-31 13:48:18'),(3,15000,'101AGD124031A2BG','2024-01-31','fee',NULL,8,'9b3985a0-e47d-4487-85f4-c8055b967aa3',4,8,1,'January 2024',NULL,NULL,'2024-01-31 15:06:13','2024-01-31 15:13:25'),(4,50000,'101AGD124031A258','2024-01-31','stock',NULL,8,'9b3985f2-4910-4533-a3c9-4b4c97c11822',4,8,1,'January 2024',NULL,NULL,'2024-01-31 15:07:06','2024-01-31 15:12:22'),(5,15000,'MKFT0J3KLS1XOT9E0343C-1','2024-01-31','fee',NULL,9,'9b39a84e-5774-4fd8-aa7e-1ae87644657d',5,8,1,'January 2024',NULL,NULL,'2024-01-31 16:43:11','2024-01-31 18:05:09'),(6,85000,'MKFT0J3KLS1XOT9E0343C-2','2024-01-31','stock',NULL,9,'9b39a87c-11bc-4ed7-a977-1fcb2ac5891c',5,8,1,'January 2024',NULL,NULL,'2024-01-31 16:43:41','2024-01-31 18:05:00'),(7,50000,'211FTM2240310631-1','2024-01-31','stock',NULL,11,'9b39c617-2209-4c4b-9723-8a6182807b7d',7,8,1,'January 2024',NULL,NULL,'2024-01-31 18:06:28','2024-01-31 18:11:36'),(8,15000,'211FTM2240310631-2','2024-01-31','fee',NULL,11,'9b39c64d-ab19-4e61-bc95-57d65039a302',7,8,1,'January 2024',NULL,NULL,'2024-01-31 18:07:04','2024-01-31 18:11:26'),(9,100000,'410FTM2240310014-1','2024-01-31','stock',NULL,12,'9b39c731-3e95-4816-8220-35a9fdda375e',8,8,1,'January 2024',NULL,NULL,'2024-01-31 18:09:33','2024-01-31 18:10:58'),(10,15000,'410FTM2240310014-2','2024-01-31','fee',NULL,12,'9b39c76a-8155-493a-a8c2-65ffe336293d',8,8,1,'January 2024',NULL,NULL,'2024-01-31 18:10:10','2024-01-31 18:10:46'),(11,100000,'18D61113A929E948','2024-01-31','stock',NULL,10,'9b39ee5e-dea6-461b-a549-d5198abcc8fa',6,8,1,'January 2024',NULL,NULL,'2024-01-31 19:59:06','2024-02-01 22:08:26'),(12,15000,'18D61113A929E948','2024-01-31','fee',NULL,10,'9b39eede-cc7a-42f9-8785-a6ead49f62ef',6,8,2,'January 2024','rejected','2024-02-07 08:31:40','2024-01-31 20:00:30','2024-02-07 08:31:40'),(13,100000,'101AGD224032D6ML','2024-02-01','stock',NULL,10,'9b3bbb94-5be7-47bf-b8f0-15bee76f975b',6,8,2,'January 2024','rejected','2024-02-07 08:31:24','2024-02-01 20:28:44','2024-02-07 08:31:24'),(14,15000,'101AGD224032D6ML','2024-02-01','fee',NULL,10,'9b3bbbd9-881c-446f-85d5-56efd98250b0',6,8,1,'January 2024',NULL,NULL,'2024-02-01 20:29:29','2024-02-01 22:06:31'),(15,140000,'410FTM2240400510-1','2024-02-09','stock',NULL,12,'9b4ba897-a723-4e06-8d20-4b73b96764b1',8,8,1,'February 2024',NULL,NULL,'2024-02-09 18:28:53','2024-02-09 18:32:07'),(16,15000,'410FTM2240400510-2','2024-02-09','fee',NULL,12,'9b4ba8dd-5965-45bb-80ad-48a2a015e51e',8,8,1,'February 2024',NULL,NULL,'2024-02-09 18:29:39','2024-02-09 18:31:26'),(17,250000,'101AGD224046C1DC','2024-02-15','stock',NULL,8,'9b57da16-c52f-4257-92e7-0438a0d041f0',4,8,1,'February 2024',NULL,NULL,'2024-02-15 19:57:13','2024-02-15 22:44:33'),(18,200000,'101AGD2240589395-1','2024-02-27','stock',NULL,1,'9b6f42ee-f872-44a7-8186-1f37d05eea93',1,8,1,'February 2024',NULL,NULL,'2024-02-27 11:14:26','2024-02-27 11:23:56'),(19,15000,'101AGD2240589395-2','2024-02-27','fee',NULL,1,'9b6f4319-4c32-4d90-8d37-9fb7a2b97f22',1,8,1,'February 2024',NULL,NULL,'2024-02-27 11:14:54','2024-02-27 11:23:48'),(20,15000,'206FTM2240580048','2024-02-27','fee',NULL,9,'9b6fc7e8-a34f-452e-97be-872efa2c625e',5,8,1,'February 2024',NULL,NULL,'2024-02-27 17:26:15','2024-02-27 17:31:20'),(21,85000,'206FTM2240580048-2','2024-02-27','stock',NULL,9,'9b6fc826-4348-45ce-8a0b-0de8dde44928',5,8,1,'February 2024',NULL,NULL,'2024-02-27 17:26:56','2024-02-27 17:31:37'),(22,100000,'101AGD224058C1T1','2024-02-27','stock',NULL,10,'9b6fc9b2-8649-4a7f-8682-0e4b2bca6bca',6,8,1,'February 2024',NULL,NULL,'2024-02-27 17:31:15','2024-02-27 17:32:03'),(23,15000,'101AGD224058C1T1 2','2024-02-27','fee',NULL,10,'9b6fca46-e8f3-47cd-aeed-0a4ec92bf304',6,8,2,'February 2024','rejected','2024-02-27 18:05:02','2024-02-27 17:32:53','2024-02-27 18:05:02'),(24,15000,'101AGD224058C1T1-2','2024-02-27','fee',NULL,10,'9b6fcc22-49f1-4206-9202-0fa0ab460aa7',6,8,1,'February 2024',NULL,NULL,'2024-02-27 17:38:04','2024-02-27 18:04:45'),(25,15000,'101AGD124059C1JO','2024-02-28','fee',NULL,8,'9b73dd83-deca-427e-a785-f83bba121ca7',4,NULL,0,'February 2024',NULL,NULL,'2024-02-29 18:09:59','2024-02-29 18:09:59'),(26,735000,'101AGD324060B07T','2024-02-29','loan',2,10,'9b73f17e-8b65-471a-98f6-fb49b9bde3a5',6,NULL,0,NULL,NULL,NULL,'2024-02-29 19:05:51','2024-02-29 19:05:51'),(27,15000,'211FTM2240620588-1','2024-03-02','fee',NULL,11,'9b7738d9-b4a6-4daf-a5f7-3eafdbf66042',7,8,1,'February 2024',NULL,NULL,'2024-03-02 10:12:52','2024-03-02 20:16:40'),(28,50000,'211FTM2240620588-2','2024-03-02','stock',NULL,11,'9b77393e-20ec-47d9-992d-d32aa1fbc2af',7,8,1,'February 2024',NULL,NULL,'2024-03-02 10:13:57','2024-03-02 20:16:27'),(29,72000,'211FTM2240620588-3','2024-03-02','loan',1,11,'9b7739b9-3203-4d6e-b15b-60df0bfe2cf2',7,8,1,NULL,NULL,NULL,'2024-03-02 10:15:18','2024-03-02 20:16:08');
/*!40000 ALTER TABLE `payment_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NOT NULL,
  `amount` float NOT NULL,
  `payment_reference` varchar(100) NOT NULL,
  `added_by` int NOT NULL,
  `uuid` varchar(100) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_type` varchar(30) DEFAULT NULL,
  `payment_for_month` varchar(30) DEFAULT NULL,
  `loan_contract_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,1,15000,'101AGD224031B202-2',8,'9b3969c3-f41d-49df-af5e-04e449cc0dcd','2024-01-31','fee','January 2024',NULL,'2024-01-31 13:48:18','2024-01-31 13:48:18'),(2,1,185000,'101AGD224031B202-1',8,'9b3969ce-834a-4100-a130-f292e6db24e5','2024-01-31','stock','January 2024',NULL,'2024-01-31 13:48:25','2024-01-31 13:48:25'),(3,8,50000,'101AGD124031A258',8,'9b3987d3-f052-4410-9395-3c40faf3b697','2024-01-31','stock','January 2024',NULL,'2024-01-31 15:12:22','2024-01-31 15:12:22'),(4,8,15000,'101AGD124031A2BG',8,'9b398833-fb90-49d5-a4b9-677eac8a2ba7','2024-01-31','fee','January 2024',NULL,'2024-01-31 15:13:25','2024-01-31 15:13:25'),(5,9,85000,'MKFT0J3KLS1XOT9E0343C-2',8,'9b39c591-5fd4-480d-a1a6-709dfa3e52f6','2024-01-31','stock','January 2024',NULL,'2024-01-31 18:05:00','2024-01-31 18:05:00'),(6,9,15000,'MKFT0J3KLS1XOT9E0343C-1',8,'9b39c59e-542f-4d75-a47a-0e32adefdd3d','2024-01-31','fee','January 2024',NULL,'2024-01-31 18:05:09','2024-01-31 18:05:09'),(7,12,15000,'410FTM2240310014-2',8,'9b39c7a1-9744-4be1-a0a8-c364d868b36a','2024-01-31','fee','January 2024',NULL,'2024-01-31 18:10:46','2024-01-31 18:10:46'),(8,12,100000,'410FTM2240310014-1',8,'9b39c7b2-9ddf-45b3-8f42-d29ebf254aca','2024-01-31','stock','January 2024',NULL,'2024-01-31 18:10:58','2024-01-31 18:10:58'),(9,11,15000,'211FTM2240310631-2',8,'9b39c7de-a046-49a4-8bdd-f74974f30f99','2024-01-31','fee','January 2024',NULL,'2024-01-31 18:11:26','2024-01-31 18:11:26'),(10,11,50000,'211FTM2240310631-1',8,'9b39c7ed-cf8e-4249-b89b-525fef1e832b','2024-01-31','stock','January 2024',NULL,'2024-01-31 18:11:36','2024-01-31 18:11:36'),(11,10,15000,'101AGD224032D6ML',8,'9b3bde8d-7ee9-4214-b432-2cd3d53a4e35','2024-02-01','fee','January 2024',NULL,'2024-02-01 22:06:31','2024-02-01 22:06:31'),(12,10,100000,'18D61113A929E948',8,'9b3bdf3b-dffb-43a6-b186-e68b508e798c','2024-01-31','stock','January 2024',NULL,'2024-02-01 22:08:26','2024-02-01 22:08:26'),(13,12,15000,'410FTM2240400510-2',8,'9b4ba981-94a4-45c5-abad-c94bb080d56f','2024-02-09','fee','February 2024',NULL,'2024-02-09 18:31:26','2024-02-09 18:31:26'),(14,12,140000,'410FTM2240400510-1',8,'9b4ba9be-e697-4c33-8f90-f363faffe369','2024-02-09','stock','February 2024',NULL,'2024-02-09 18:32:07','2024-02-09 18:32:07'),(15,8,250000,'101AGD224046C1DC',8,'9b5815ee-39a8-459f-8fc9-89551991894b','2024-02-15','stock','February 2024',NULL,'2024-02-15 22:44:33','2024-02-15 22:44:33'),(16,1,15000,'101AGD2240589395-2',8,'9b6f4648-4788-4f19-b7a9-cd38e7569e20','2024-02-27','fee','February 2024',NULL,'2024-02-27 11:23:48','2024-02-27 11:23:48'),(17,1,200000,'101AGD2240589395-1',8,'9b6f4654-ec41-4b2d-816c-881c286120ba','2024-02-27','stock','February 2024',NULL,'2024-02-27 11:23:56','2024-02-27 11:23:56'),(18,9,15000,'206FTM2240580048',8,'9b6fc9b9-b0d7-4ca5-8070-07bebbef4064','2024-02-27','fee','February 2024',NULL,'2024-02-27 17:31:20','2024-02-27 17:31:20'),(19,9,85000,'206FTM2240580048-2',8,'9b6fc9d3-0dce-4e4c-8ee2-1ad3bfcb8c00','2024-02-27','stock','February 2024',NULL,'2024-02-27 17:31:37','2024-02-27 17:31:37'),(20,10,100000,'101AGD224058C1T1',8,'9b6fc9fb-384d-421c-a8bd-39747044bea9','2024-02-27','stock','February 2024',NULL,'2024-02-27 17:32:03','2024-02-27 17:32:03'),(21,10,15000,'101AGD224058C1T1-2',8,'9b6fd5ad-729b-4b77-95de-e0ded0bcdc2d','2024-02-27','fee','February 2024',NULL,'2024-02-27 18:04:45','2024-02-27 18:04:45'),(22,11,72000,'211FTM2240620588-3',8,'9b781098-5ae4-4920-90d1-8767a2b4f350','2024-03-02','loan',NULL,1,'2024-03-02 20:16:08','2024-03-02 20:16:08'),(23,11,50000,'211FTM2240620588-2',8,'9b7810b6-0fb5-44f0-b842-f38343415e25','2024-03-02','stock','February 2024',NULL,'2024-03-02 20:16:27','2024-03-02 20:16:27'),(24,11,15000,'211FTM2240620588-1',8,'9b7810c9-bd0a-4784-91a6-53f96f3a1e42','2024-03-02','fee','February 2024',NULL,'2024-03-02 20:16:40','2024-03-02 20:16:40');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payouts`
--

DROP TABLE IF EXISTS `payouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `amount` float NOT NULL,
  `payment_reference` varchar(50) NOT NULL,
  `payment_date` date NOT NULL,
  `bank_account_no` varchar(50) NOT NULL,
  `created_by` int NOT NULL,
  `updated_by` int DEFAULT NULL,
  `uuid` varchar(100) NOT NULL,
  `member_id` int NOT NULL,
  `loan_contract_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payouts`
--

LOCK TABLES `payouts` WRITE;
/*!40000 ALTER TABLE `payouts` DISABLE KEYS */;
INSERT INTO `payouts` VALUES (1,200000,'080257ED28A8','2024-02-08','21110016381',4,NULL,'9b49ad9d-eb8a-4768-96c9-6f737302d862',11,1,'2024-02-08 18:51:17','2024-02-08 18:51:17'),(2,700000,'225IBFT240220511','2024-01-22','23610003247',8,NULL,'9b5fcbef-be42-458b-8906-cf32d8f6a7b0',10,2,'2024-02-19 18:44:16','2024-02-19 18:44:16'),(3,900000,'225IBFT240500537','2024-02-19','20610003342',8,NULL,'9b6103ef-c0d9-4c1a-92c9-c4abe4787d62',8,3,'2024-02-20 09:16:41','2024-02-20 09:16:41');
/*!40000 ALTER TABLE `payouts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_categories`
--

DROP TABLE IF EXISTS `permission_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permission_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_categories`
--

LOCK TABLES `permission_categories` WRITE;
/*!40000 ALTER TABLE `permission_categories` DISABLE KEYS */;
INSERT INTO `permission_categories` VALUES (1,'User Permission','User Permissions','2023-02-22 19:51:35','2023-02-22 19:51:35'),(2,'Role Permission','Role Permissions','2023-02-22 19:51:35','2023-02-22 19:51:35');
/*!40000 ALTER TABLE `permission_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'Create Member','Ability to create member','Web','2024-01-23 04:18:35','2024-01-23 04:18:35'),(2,'Approve Payment','Ability to approve payment','Web','2024-01-23 04:18:55','2024-01-23 04:18:55');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uuid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guard_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Super Admin',NULL,NULL,'web','2023-03-28 15:53:40','2023-03-28 15:53:40'),(2,'Admin',NULL,NULL,'web','2023-03-28 15:54:01','2023-03-28 15:54:01'),(3,'Member',NULL,NULL,'web','2023-03-28 17:11:51','2023-03-28 17:11:51');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_past_due`
--

DROP TABLE IF EXISTS `stock_past_due`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stock_past_due` (
  `id` int NOT NULL AUTO_INCREMENT,
  `member_id` int NOT NULL,
  `stock_for_month` varchar(100) NOT NULL,
  `past_due_days` int NOT NULL DEFAULT '0',
  `penalty` float NOT NULL,
  `penalty_paid` float NOT NULL DEFAULT '0',
  `paid_status` tinyint(1) NOT NULL DEFAULT '0',
  `outstanding_amount` float NOT NULL DEFAULT '0',
  `current_balance` float NOT NULL DEFAULT '0',
  `last_paid_amount` float NOT NULL DEFAULT '0',
  `payment_id` int DEFAULT NULL,
  `uuid` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_past_due`
--

LOCK TABLES `stock_past_due` WRITE;
/*!40000 ALTER TABLE `stock_past_due` DISABLE KEYS */;
INSERT INTO `stock_past_due` VALUES (2,13,'January 2024',30,45000,0,0,45000,0,0,NULL,'9b785ee0-94c7-46d6-a0fa-bee78fc06745','2024-02-03 11:35:01','2024-03-02 23:55:01');
/*!40000 ALTER TABLE `stock_past_due` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `password_change_status` int NOT NULL DEFAULT '0',
  `password_change_date` date DEFAULT NULL,
  `uuid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Luhangano Lupenza','lupenza10@gmail.com','255683130185','2023-05-23 20:27:53','$2y$10$qPyWP.e56HYzioPzxJz4VOA9efzt5sgO2nMzvp/q8i3UygXhZNIiW',NULL,'Active',1,'2023-12-21','9ae64647-aa98-47de-b3a3-64024fffd158',1,NULL,NULL),(4,'Noel Sumbe','noelsumbe@gmail.com','255713510645',NULL,'$2y$10$x2XxCO3uF6QFpwMyf4HP1uQufkh/RWb3dIlbZ3Xo6RqPGFZhQFeSe',NULL,'Active',1,'2024-01-25','9b2d525f-beb2-43a8-a9ef-e0f06c6f1cb8',8,'2024-01-25 13:32:58','2024-01-25 13:33:53'),(5,'Lazaro Lazaro','lazaroisaac36@gmail.com','255627322093',NULL,'$2y$10$ol60HI9Kcm9W55ka6ni9Fe9Hk80KZA6oyzjM17ajYD0A8GcNcbrju',NULL,'Active',1,'2024-01-25','9b2d5fe0-0495-4b10-baae-74901af5c28a',9,'2024-01-25 14:10:43','2024-01-25 15:08:34'),(6,'Dickson Fissoo','fissoonamson98@gmail.com','255788581698',NULL,'$2y$10$SLsQPPZhvy90yljASG0.kOugE/vC3bouPiO5OfdDeR5ZLq//SmrXm',NULL,'Active',1,'2024-01-25','9b2d8fbf-9ee7-4dd7-8124-e45fbc53f172',10,'2024-01-25 16:24:35','2024-01-25 16:39:11'),(7,'Frank Daniel','Kessyfra@gmail.com','255684469338',NULL,'$2y$10$aCW0vy.o08Q2R7.oyjPjc.CZJ7g.L7F5D5.sS2m6DFdGL3CooIp/W',NULL,'Active',1,'2024-01-27','9b2ebcd9-6f7e-4bf7-862e-d7058663316b',11,'2024-01-26 06:26:31','2024-01-27 10:21:07'),(8,'Fortunatus Shao','fortunatus.edes@gmail.com','255658840898',NULL,'$2y$10$bVMEIKH/AaA7.quJJYI9yeJWBRMjBcQFVa6/GCNVhyGBw2JqaIAAu',NULL,'Active',1,'2024-01-31','9b395084-bfbe-4910-8e17-6c26f6ef2ed5',12,'2024-01-31 12:37:43','2024-01-31 13:43:06'),(9,'Amedeus Kimaro','amedeusraphael.ar@gmail.com','255785122441',NULL,'$2y$10$tYX5ni5xsyekE0uCdpUqaeNKoo/QEaBAZ3tYglRarGZdOAz6GeR.q',NULL,'Active',1,'2024-01-31','9b3951b5-fc26-4b9a-9b16-e699436ab3e3',13,'2024-01-31 12:41:03','2024-01-31 12:56:01');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-03-03  9:12:50
