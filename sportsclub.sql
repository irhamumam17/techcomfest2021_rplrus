-- MySQL dump 10.18  Distrib 10.3.27-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: u6227930_sportsclub
-- ------------------------------------------------------
-- Server version	10.3.27-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bookings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `field_id` int(10) unsigned NOT NULL,
  `date` date NOT NULL,
  `time` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_price` int(11) NOT NULL,
  `status` enum('PENDING','ACCEPT','REJECT') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bookings_user_id_foreign` (`user_id`),
  KEY `bookings_field_id_foreign` (`field_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
INSERT INTO `bookings` (`id`, `user_id`, `field_id`, `date`, `time`, `code`, `total_price`, `status`, `created_at`, `updated_at`) VALUES (1,2,1,'2021-01-06','[\"18:00\"]','210106UaWV',30000,'ACCEPT','2021-01-05 06:04:17','2021-01-05 06:19:56'),(2,2,1,'2021-01-11','[\"16:00\",\"17:00\",\"18:00\"]','210111ivGa',90000,'ACCEPT','2021-01-06 05:02:49','2021-01-25 06:54:24'),(3,2,1,'2021-01-19','[\"14:00\"]',NULL,30000,'REJECT','2021-01-18 21:31:07','2021-01-25 06:54:38'),(4,2,1,'2021-01-19','[\"12:00\"]',NULL,30000,'PENDING','2021-01-18 22:58:52','2021-01-18 22:58:52');
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fields`
--

DROP TABLE IF EXISTS `fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `open` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `close` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fields`
--

LOCK TABLES `fields` WRITE;
/*!40000 ALTER TABLE `fields` DISABLE KEYS */;
INSERT INTO `fields` (`id`, `name`, `picture`, `category`, `address`, `location`, `open`, `close`, `price`, `created_at`, `updated_at`) VALUES (1,'Merdeka Futsal','pictures/4TNwROrus8Mzge8S5drcF8PRFov7J4RXoRpIGDON.jpeg','Futsal','Purwosari, Kec. Kota Kudus, Kabupaten Kudus, Jawa Tengah 59316','-6.8033782596515096, 110.82572183780742','08:00','18:00',35000,'2021-01-04 04:43:22','2021-01-25 07:25:19'),(2,'Markass Sport Center','pictures/8fe2vDXQAWGcD84VN0urz8Q2bXJoqBeMDddYRD4F.jpeg','Futsal','Jl. Jend. Sudirman No.184, Rendeng, Kec. Kota Kudus, Kabupaten Kudus, Jawa Tengah 59311','-6.804295496329917, 110.86131356725922','07:00','23:00',50000,'2021-01-04 04:48:48','2021-01-25 07:22:58'),(3,'Futsal Campeone Gebog','pictures/0NUK6kLLR7ZlWcHG88KEPgJfTJXfv49OCxOX2ega.jpeg','Futsal','Gebog, Gondosari, Kec. Gebog, Kabupaten Kudus, Jawa Tengah 59333','-6.736412030315176, 110.84331151449355','08:00','23:00',30000,'2021-01-04 04:57:37','2021-01-04 04:57:37'),(5,'Mars Futsal Center','pictures/JC5EEDXE9Tz9T8JiEHIf4K8JjkyGeUk4GNIItnZF.jpeg','Futsal','Area kuliner, Jl. Museum Kretek Jl. Getas Pejaten No.9, Area Sawah, Getas Pejaten, Kec. Jati, Kabupaten Kudus, Jawa Tengah 59343','-6.8267677,110.8336324','09:00','23:00',35000,'2021-01-25 07:41:57','2021-01-25 07:41:57');
/*!40000 ALTER TABLE `fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `matches`
--

DROP TABLE IF EXISTS `matches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `matches` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `field_id` int(10) unsigned NOT NULL,
  `teamReq` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teamAcc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL,
  `status` enum('WAITING','ACCEPT') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'WAITING',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `matches_user_id_foreign` (`user_id`),
  KEY `matches_field_id_foreign` (`field_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matches`
--

LOCK TABLES `matches` WRITE;
/*!40000 ALTER TABLE `matches` DISABLE KEYS */;
INSERT INTO `matches` (`id`, `user_id`, `field_id`, `teamReq`, `teamAcc`, `date`, `status`, `created_at`, `updated_at`) VALUES (1,2,1,'RPL TEAM','DG TEAM','2021-01-06','ACCEPT','2021-01-05 06:21:46','2021-01-06 05:44:29'),(2,5,1,'DKV RUS','RPL TEAM','2021-01-09','ACCEPT','2021-01-06 05:11:19','2021-01-06 05:33:14'),(3,5,1,'RPL RUS','MY TEAM','2021-01-16','ACCEPT','2021-01-06 05:45:21','2021-01-06 06:01:09'),(4,5,1,'RPL RUS',NULL,'2021-01-23','WAITING','2021-01-06 05:45:44','2021-01-06 05:45:44'),(5,5,1,'RPL RUS',NULL,'2021-01-30','WAITING','2021-01-06 05:47:26','2021-01-06 05:47:26'),(6,5,2,'RPL RUS',NULL,'2021-02-06','WAITING','2021-01-06 05:54:50','2021-01-06 05:54:50'),(7,5,3,'RPL RUS',NULL,'2021-02-13','WAITING','2021-01-06 05:55:23','2021-01-06 05:55:23'),(8,2,1,'RPL TEAM','PD TEAM','2021-01-07','ACCEPT','2021-01-06 06:39:04','2021-01-06 06:39:04'),(9,2,1,'RPL TEAM',NULL,'2021-01-17','WAITING','2021-01-06 06:39:28','2021-01-06 06:39:28');
/*!40000 ALTER TABLE `matches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_11_23_120846_penyesuaian_table_users',1),(5,'2019_12_05_134631_create_fields_table',1),(6,'2019_12_05_135104_create_bookings_table',1),(7,'2019_12_10_120606_create_schedules_table',1),(8,'2020_01_12_223018_create_matchs_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `field_id` int(10) unsigned NOT NULL,
  `date` date NOT NULL,
  `available` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'false',
  `reason` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `schedules_field_id_foreign` (`field_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedules`
--

LOCK TABLES `schedules` WRITE;
/*!40000 ALTER TABLE `schedules` DISABLE KEYS */;
INSERT INTO `schedules` (`id`, `field_id`, `date`, `available`, `reason`, `created_at`, `updated_at`) VALUES (1,3,'2021-02-12','false','Tahun Baru Imlek','2021-01-25 06:54:11','2021-01-25 06:54:11');
/*!40000 ALTER TABLE `schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `username`, `roles`, `phone`, `address`, `avatar`, `token`, `status`) VALUES (1,'Admin','admin@email.com',NULL,'$2y$10$HnYZTPkUD/ealwgdTpfBNenfwKvlv0vM79MI8/9trCUXIXSNWZq6y','bZSGM9KoR3AW0qObGoJAW0gSnswpKPTHBW4f816SORSuOiEHDNQYMBGgxFYS','2020-12-29 05:21:55','2020-12-29 05:21:55','admin','[\"ADMIN\"]','085777777777','Jl. Admin',NULL,NULL,'ACTIVE'),(2,'Ryandhika Bintang','ryandhikabintang0@gmail.com',NULL,'$2y$10$UdI2mJfYksqXlV/UxuTrbOOTSjU.sIuk5oZLED1nbnTjNStAz6Xj.',NULL,'2021-01-04 03:25:37','2021-01-22 21:02:58','ryandhikabaa','[\"CUSTOMER\"]','089636519459','Ds. Loram Wetan Rt 02 Rw 06 Kec Jati Kab Kudus',NULL,'eGQmttM-S9ec_eVeRzCtuy:APA91bGQ5Upy9fcoxUjqMdQDNlwzhg1TUFjnEcuiPdXl0Fj96_bRmUbczq37HGAtpDiuJTfBEC1cPZrr8aea7f4_vLiBMGgvO1VP_wpLnFUGg5qpaqckzsudsxnGiUyYxpI4vn1tRI_i','ACTIVE'),(4,'Nameku','a@gmail.com',NULL,'$2y$10$zNDEncrgrOTB/9gVsQpbH.axq7EJGne/ic0boZg3WGs67QWyEFd4m',NULL,'2021-01-04 19:42:24','2021-01-25 07:06:39','Usernameku','[\"CUSTOMER\"]','0273840000','Addresku',NULL,'chAWqyAAQU2iAAFXfJzn-_:APA91bGeALijious4bDfr45vGhShfLREg-D5txTMCY_xWxAKKmXuvSwZ4hbxp_ycVdbA_z2-W8M_7KAUtrdnFHp_s0L5l53VqLZ1aWfepMcMPL4PeD3BfF8BpVr22smxkpjlQL6w43yB','ACTIVE'),(5,'testing','testing@email.com',NULL,'$2y$10$pT7HeVSCNhbd8npbJtecMOLJl4fXFrEakbdLpv9V0tiQOCdcHVRFW',NULL,'2021-01-06 05:08:17','2021-01-25 07:43:09','testing','[\"CUSTOMER\"]','085123123123','unkunk',NULL,'fGvMWSeRQCaeUnhugy3WQI:APA91bGt_CjTQ2Z_ZuXp-VrWDZfw2PTJBqDE3IhajGjF5pkllE-c3C0UtInnXh7SBOCvYHIefdc6ZUjlX2Y3q7L4NDCWrkCtIbJdfcuKNO--yVWbxZ-EdmgmIPeb3em7xwXWOnMM7kay','ACTIVE');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'u6227930_sportsclub'
--

--
-- Dumping routines for database 'u6227930_sportsclub'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-01-28 22:08:49
