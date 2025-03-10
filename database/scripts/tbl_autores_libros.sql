/*CREATE*/
DROP TABLE IF EXISTS `tbl_autores_libros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_autores_libros` (
  `libro_id` int(10) unsigned NOT NULL,
  `autor_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`libro_id`,`autor_id`),
  KEY `autor_id` (`autor_id`),
  CONSTRAINT `tbl_autores_libros_ibfk_1` FOREIGN KEY (`libro_id`) REFERENCES `tbl_libros` (`libro_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tbl_autores_libros_ibfk_2` FOREIGN KEY (`autor_id`) REFERENCES `tbl_autores` (`autor_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

/*INSERT*/
LOCK TABLES `tbl_autores_libros` WRITE;
/*!40000 ALTER TABLE `tbl_autores_libros` DISABLE KEYS */;
INSERT INTO `tbl_autores_libros` VALUES (1,1),(1,6),(1,10),(2,6),(2,10),(3,2),(3,6),(4,2),(4,6),(5,3),(5,7),(6,3),(6,7),(7,3),(7,7),(8,3),(8,8),(9,4),(9,8),(10,4),(10,8),(11,4),(11,8),(12,5),(12,9),(13,5),(13,9),(14,5),(14,9),(15,5),(15,9),(16,5),(16,10),(17,6),(17,10),(18,6),(18,10),(19,11),(19,12),(19,13),(19,14),(21,11),(21,12),(21,13),(21,14),(24,11),(24,12),(24,13),(24,14);
/*!40000 ALTER TABLE `tbl_autores_libros` ENABLE KEYS */;
UNLOCK TABLES;