DROP TABLE IF EXISTS `new_raids`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `new_raids` (
                             `id` int(11) NOT NULL AUTO_INCREMENT,
                             `server` int(11) NOT NULL,
                             `title` varchar(200) NOT NULL,
                             `description` varchar(200) DEFAULT NULL,
                             `timestamp` varchar(20) NOT NULL,
                             `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
                             PRIMARY KEY (`id`),
                             UNIQUE KEY `new_raids_server_title_timestamp_uindex` (`server`,`title`,`timestamp`),
                             KEY `new_raids_created_at_index` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;