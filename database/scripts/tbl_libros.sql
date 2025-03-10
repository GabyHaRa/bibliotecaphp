DROP TABLE IF EXISTS `tbl_autores`;
CREATE TABLE `tbl_autores` (
  `autor_id` int unsigned NOT NULL AUTO_INCREMENT,
  `autor_nombre` varchar(500) COLLATE utf8mb4_spanish_ci NOT NULL,
  `autor_descripcion` text COLLATE utf8mb4_spanish_ci,
  `autor_creacion` date DEFAULT NULL,
  `autor_modificacion` date DEFAULT NULL,
  PRIMARY KEY (`autor_id`),
  KEY `idx_autor` (`autor_nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

LOCK TABLES `tbl_autores` WRITE;
INSERT INTO `tbl_autores` 
VALUES 
(
    1,
    'Shaylee Wyman',
    'Ea sapiente voluptates dolor sunt natus debitis molestias. Voluptas voluptas molestiae hic sunt sunt pariatur doloribus. A omnis quam facere qui et eum nisi. Facere aliquid numquam consequuntur qui nostrum eaque nulla.',
    NULL,
    NULL
),
(
    2,
    'Josie Considine',
    NULL,
    NULL,
    NULL
),
(
    3,
    'Jettie White',
    'Repellat expedita enim laboriosam non aut facere. Harum cum velit eligendi voluptatem culpa fugit. Doloribus minus fugit enim ea. Hic doloribus quas itaque ducimus dignissimos praesentium accusamus.',
    NULL,
    NULL
    ),
    (
        4,
        'Ms. Daniela Romaguera',
        'Fugit ullam ipsum natus ad. Omnis facilis rerum est possimus et aut. Expedita officiis illo facere eaque.',
        NULL,
        NULL
    ),
    (
        5,
        'Jazlyn Mertz',
        NULL,
        NULL,
        NULL
    ),
    (
        6,
        'Walton Waelchi V',
        NULL,
        NULL,
        NULL
    ),
    (
        7,
        'Nikita O\ Keefe',
        NULL,
        NULL,
        NULL
    ),
    (
        8,
        'Sherwood Friesen',
        'Natus nesciunt et optio ab et. Unde est vero minus. Ut quia distinctio itaque consequatur corporis modi. Tenetur rerum qui minus repellat dolorem aut perferendis at.',
        NULL,
        NULL
    ),
    (
        9,
        'Mrs. Amiya Stiedemann',
        NULL,
        NULL,
        NULL
    ),
    (
        10,
        'Maybell Towne Jr.',
        NULL,
        NULL,
        NULL
    );
UNLOCK TABLES;

DROP TABLE IF EXISTS `tbl_comentarios`;
CREATE TABLE `tbl_comentarios` (
  `comentario_id` int unsigned NOT NULL AUTO_INCREMENT,
  `comentario_texto` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `libro_id` int unsigned NOT NULL,
  `comentario_creacion` date DEFAULT NULL,
  `comentario_modificacion` date DEFAULT NULL,
  PRIMARY KEY (`comentario_id`),
  KEY `id_libro` (`libro_id`),
  CONSTRAINT `tbl_comentarios_ibfk_1` FOREIGN KEY (`libro_id`) REFERENCES `tbl_libros` (`libro_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

LOCK TABLES `tbl_comentarios` WRITE;
UNLOCK TABLES;

DROP TABLE IF EXISTS `tbl_libros`;
CREATE TABLE `tbl_libros` (
  `libro_id` int unsigned NOT NULL AUTO_INCREMENT,
  `autor_id` int unsigned NOT NULL,
  `libro_titulo` varchar(500) COLLATE utf8mb4_spanish_ci DEFAULT 'Sin título.',
  `libro_año` year DEFAULT NULL,
  `libro_idioma` varchar(23) COLLATE utf8mb4_spanish_ci DEFAULT 'Español',
  `libro_tipo` varchar(30) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `libro_pensamiento` enum('Pensamiento bioético','Pensamiento humanístico español','Pensamiento humanístico inglés','Pensamiento matemático','Pensamiento social','Pensamiento tecnológico') COLLATE utf8mb4_spanish_ci NOT NULL,
  `libro_isbn` mediumtext COLLATE utf8mb4_spanish_ci,
  `libro_resumen` mediumtext COLLATE utf8mb4_spanish_ci,
  `libro_enlace` mediumtext COLLATE utf8mb4_spanish_ci NOT NULL,
  `libro_creacion` date DEFAULT NULL,
  `libro_modificacion` date DEFAULT NULL,
  PRIMARY KEY (`libro_id`),
  KEY `idx_libro` (`libro_titulo`),
  KEY `id_autor` (`autor_id`),
  CONSTRAINT `tbl_libros_ibfk_1` FOREIGN KEY (`autor_id`) REFERENCES `tbl_autores` (`autor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

LOCK TABLES `tbl_libros` WRITE;
INSERT INTO `tbl_libros` VALUES 
(
    1,
    1,
    'Numquam esse id sit et ratione possimus fugiat nesciunt.',
    2025,
    'Español',
    'Ensayo',
    'Pensamiento humanístico inglés',
    NULL,
    'Voluptatibus impedit maiores ut repudiandae perspiciatis. Perspiciatis minima similique et doloremque nesciunt. Consequatur numquam repellendus necessitatibus.','http://dibbert.com/',NULL,NULL),(2,2,'Atque iste voluptates facilis nemo temporibus.',1975,'Inglés','Tesina','Pensamiento matemático',NULL,'Optio expedita doloremque laudantium eligendi incidunt. Optio fuga ea qui officiis dolor. Sunt quisquam et cupiditate quis. Nihil voluptatem eum aut qui corrupti.','https://www.kuphal.com/eos-iure-id-similique-libero',NULL,NULL),(3,3,'Sin título.',1971,'Español','Libro','Pensamiento bioético',NULL,'Odio et fuga natus sit voluptatem. Dicta soluta eius dolorem eum distinctio accusantium. Quisquam ut molestiae consectetur expedita sint.','http://www.weimann.info/numquam-beatae-dolor-quia-expedita-eius',NULL,NULL),(4,4,'Eaque molestiae officiis magnam ut temporibus impedit tenetur.',1998,'Español',NULL,'Pensamiento bioético','9790831354779','Officiis vel soluta esse et totam vel. Autem rem voluptatem ut sed consequatur. Aut quia aut et debitis eaque minima eveniet. Cum quam quo consequatur.','http://www.hahn.info/numquam-et-commodi-blanditiis-reprehenderit-a-et',NULL,NULL),(5,5,'Explicabo est optio exercitationem inventore.',1980,'Español',NULL,'Pensamiento bioético',NULL,'Dolorem quaerat iusto consequatur labore voluptate ipsam. Et vel et repellendus ipsum accusamus doloremque voluptatum. Quibusdam aspernatur repellat quam aliquam molestiae. Quisquam aut ipsum velit harum illo totam asperiores.','https://www.predovic.com/ducimus-fugit-magni-quos-nulla-ea-quod',NULL,NULL),(6,6,'Sin título.',2025,'Inglés',NULL,'Pensamiento tecnológico','9796462366310','Voluptatem inventore et exercitationem temporibus enim aut. Non corporis architecto quo corrupti saepe sit est. Quas vero dolorem minus non eligendi.','http://lockman.com/',NULL,NULL),(7,7,'Dolores unde consequatur ea omnis.',2013,'Español','Libro','Pensamiento humanístico inglés',NULL,'Corporis quos necessitatibus dolore voluptate distinctio et recusandae nemo. Laboriosam autem qui alias rerum consequatur quia voluptatum. Repellendus modi debitis animi et.','http://connelly.org/ut-itaque-asperiores-quod-vel-totam',NULL,NULL),(8,8,'Id illo molestias commodi voluptatem veritatis.',1989,'Español',NULL,'Pensamiento humanístico inglés',NULL,'Incidunt accusamus voluptatem sint id asperiores iste ratione laborum. Quis excepturi saepe id accusamus.','http://denesik.org/',NULL,NULL),(9,9,'Sin título.',1996,'Español','Tesina','Pensamiento tecnológico','9784633543554','Aut autem distinctio eos blanditiis molestiae. Voluptatem enim sint eos illum a veniam.','http://mraz.com/et-nulla-similique-similique-sunt-ut-vero',NULL,NULL),(10,10,'Quis laboriosam ut consectetur sint voluptatum autem.',2025,'Francés',NULL,'Pensamiento humanístico inglés','9789519760247','Maiores minima porro tenetur eaque quia accusantium. Dicta vitae quia maxime quae reiciendis temporibus ea. Libero molestias placeat ad magnam autem recusandae possimus. Eum aut molestiae esse nam qui magnam qui.','http://www.torp.com/',NULL,NULL);
UNLOCK TABLES;
ALTER DATABASE `biblioteca` CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `before_insert_libros` BEFORE INSERT ON `tbl_libros` FOR EACH ROW SET NEW.libro_año = IFNULL(NEW.libro_año, YEAR(CURDATE())) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
ALTER DATABASE `biblioteca` CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci ;

--
-- Table structure for table `tbl_libros_giu`
--

DROP TABLE IF EXISTS `tbl_libros_giu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_libros_giu` (
  `giu_id` int unsigned NOT NULL AUTO_INCREMENT,
  `autor_id` int unsigned NOT NULL,
  `giu_año` year DEFAULT NULL,
  `giu_tipo` varchar(30) COLLATE utf8mb4_spanish_ci DEFAULT 'Libro',
  `giu_isbn` text COLLATE utf8mb4_spanish_ci,
  `giu_resumen` text COLLATE utf8mb4_spanish_ci,
  `giu_enlace` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `giu_titulo` varchar(500) COLLATE utf8mb4_spanish_ci DEFAULT 'Sin título.',
  `giu_creacion` date DEFAULT NULL,
  `giu_modificacion` date DEFAULT NULL,
  PRIMARY KEY (`giu_id`),
  KEY `idx_giu` (`giu_titulo`),
  KEY `id_autor` (`autor_id`),
  CONSTRAINT `tbl_libros_giu_ibfk_1` FOREIGN KEY (`autor_id`) REFERENCES `tbl_autores` (`autor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_libros_giu`
--

LOCK TABLES `tbl_libros_giu` WRITE;
/*!40000 ALTER TABLE `tbl_libros_giu` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_libros_giu` ENABLE KEYS */;
UNLOCK TABLES;
ALTER DATABASE `biblioteca` CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `before_insert_giu` BEFORE INSERT ON `tbl_libros_giu` FOR EACH ROW SET NEW.giu_año = IFNULL(NEW.giu_año, YEAR(CURDATE())) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
ALTER DATABASE `biblioteca` CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci ;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
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

-- Dump completed on 2025-02-02 15:20:52

INSERT INTO tbl_libros 