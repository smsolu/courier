-- MySQL dump 10.13  Distrib 5.7.14, for Win32 (AMD64)
--
-- Host: localhost    Database: courier
-- ------------------------------------------------------
-- Server version	5.7.14-log

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
-- Table structure for table `direccion`
--

DROP TABLE IF EXISTS `direccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `direccion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) DEFAULT NULL,
  `id_pais` int(11) NOT NULL,
  `id_provincia` int(11) NOT NULL,
  `observaciones` text,
  `localidad` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `numero` varchar(50) DEFAULT NULL,
  `barrio_zona` varchar(255) DEFAULT NULL,
  `codigo_postal` varchar(50) DEFAULT NULL,
  `interseccion` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `celular` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_direccion_pais` (`id_pais`),
  KEY `fk_direccion_provincia` (`id_provincia`),
  KEY `fk_direccion_empresa` (`id_empresa`),
  CONSTRAINT `fk_direccion_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_direccion_pais` FOREIGN KEY (`id_pais`) REFERENCES `pais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_direccion_provincia` FOREIGN KEY (`id_provincia`) REFERENCES `provincia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `direccion`
--

LOCK TABLES `direccion` WRITE;
/*!40000 ALTER TABLE `direccion` DISABLE KEYS */;
/*!40000 ALTER TABLE `direccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `direccion_internacional`
--

DROP TABLE IF EXISTS `direccion_internacional`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `direccion_internacional` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `descripcion` varchar(20) DEFAULT NULL,
  `esp` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_direccioninternacional_empresa` (`id_empresa`),
  CONSTRAINT `fk_direccioninternacional_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `direccion_internacional` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `direccion_internacional`
--

LOCK TABLES `direccion_internacional` WRITE;
/*!40000 ALTER TABLE `direccion_internacional` DISABLE KEYS */;
INSERT INTO `direccion_internacional` VALUES (1,NULL,'Miami','Culmer Station, Miami, Florida 33136, Estados Unidos ',NULL,1,0);
/*!40000 ALTER TABLE `direccion_internacional` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empresa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` VALUES (1,'courier');
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `envio`
--

DROP TABLE IF EXISTS `envio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `envio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_entidad` int(11) DEFAULT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  `id_direccion_internacional` int(11) DEFAULT NULL,
  `id_direccion_envio` int(11) DEFAULT NULL,
  `id_estado` int(11) DEFAULT NULL,
  `id_cotizacion` int(11) DEFAULT NULL,
  `total_cotizacion` decimal(10,2) DEFAULT '0.00',
  `total_peso` decimal(10,2) DEFAULT '0.00',
  `total_valor_bienes` decimal(10,2) DEFAULT '0.00',
  `status` tinyint(4) DEFAULT '0',
  `fechayhora_creacion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_envio_empresa` (`id_empresa`),
  CONSTRAINT `fk_envio_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `envio`
--

LOCK TABLES `envio` WRITE;
/*!40000 ALTER TABLE `envio` DISABLE KEYS */;
/*!40000 ALTER TABLE `envio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `envio_estado`
--

DROP TABLE IF EXISTS `envio_estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `envio_estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_envio` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `fechayhrora` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `envio_estado`
--

LOCK TABLES `envio_estado` WRITE;
/*!40000 ALTER TABLE `envio_estado` DISABLE KEYS */;
/*!40000 ALTER TABLE `envio_estado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `envio_producto`
--

DROP TABLE IF EXISTS `envio_producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `envio_producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_envio` int(11) NOT NULL,
  `producto` varchar(255) NOT NULL,
  `peso` decimal(10,2) DEFAULT '0.00',
  `valor_bien` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `producto_envio` (`id_envio`),
  CONSTRAINT `producto_envio` FOREIGN KEY (`id_envio`) REFERENCES `envio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `envio_producto`
--

LOCK TABLES `envio_producto` WRITE;
/*!40000 ALTER TABLE `envio_producto` DISABLE KEYS */;
/*!40000 ALTER TABLE `envio_producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado`
--

DROP TABLE IF EXISTS `estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) DEFAULT NULL,
  `codigo` varchar(50) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `esp` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_estado_empresa` (`id_empresa`),
  CONSTRAINT `fk_estado_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado`
--

LOCK TABLES `estado` WRITE;
/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
INSERT INTO `estado` VALUES (1,NULL,'PENDCOT','Pendiente de Cotización','El pedido fue generado por el usuario y aguarda la cotización de la empresa.',1,0),(2,NULL,'COTIZADO','Cotizado','El pedido fue cotizado y espera la aceptación del usuario.',1,0),(3,NULL,'RECHAZADO','Rechazado','El pedido fue rechazado por la empresa.',1,0),(4,NULL,'ACEPTADO','Aceptado','La cotización fue aceptada por el cliente y esta a la espera de realizar el pago.',1,0),(5,NULL,'CANCELADO','Cancelado','La cotización fue rechazada por el cliente y ha cancelado el envío.',1,0),(6,NULL,'PAGO','Pago Aprobado','El cliente ingresa correctamente los datos del pago y finaliza la operación. ',1,0);
/*!40000 ALTER TABLE `estado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fos_group`
--

DROP TABLE IF EXISTS `fos_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fos_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `fos_group_index02` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fos_group`
--

LOCK TABLES `fos_group` WRITE;
/*!40000 ALTER TABLE `fos_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `fos_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fos_user`
--

DROP TABLE IF EXISTS `fos_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fos_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fos_user_index03` (`username_canonical`),
  UNIQUE KEY `fos_user_index04` (`email_canonical`),
  KEY `fk_fos_user_empresa` (`id_empresa`),
  CONSTRAINT `fk_fos_user_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fos_user`
--

LOCK TABLES `fos_user` WRITE;
/*!40000 ALTER TABLE `fos_user` DISABLE KEYS */;
INSERT INTO `fos_user` VALUES (1,1,'admin','admin','sm@sm.com','sm@sm.com',1,'djfoov7t1z40kccgsc88g40o0sk8ww4','$2y$13$djfoov7t1z40kccgsc88guJfUarbJwZ215B47UbxxHEWQIlnOcDDW','2016-10-02 20:47:54',0,0,NULL,NULL,NULL,'a:1:{i:0;s:26:\"ROLE_ADMINISTRADOR_ESTUDIO\";}',0,NULL);
/*!40000 ALTER TABLE `fos_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fos_user_fos_group`
--

DROP TABLE IF EXISTS `fos_user_fos_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fos_user_fos_group` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`),
  KEY `fos_user_fos_group_index02` (`user_id`),
  KEY `fos_user_fos_group_index03` (`group_id`),
  CONSTRAINT `FK_8D2E96FFA76ED395` FOREIGN KEY (`user_id`) REFERENCES `fos_user` (`id`),
  CONSTRAINT `FK_8D2E96FFFE54D947` FOREIGN KEY (`group_id`) REFERENCES `fos_group` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fos_user_fos_group`
--

LOCK TABLES `fos_user_fos_group` WRITE;
/*!40000 ALTER TABLE `fos_user_fos_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `fos_user_fos_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pais`
--

DROP TABLE IF EXISTS `pais`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `entidad_nacionalidad_index02` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pais`
--

LOCK TABLES `pais` WRITE;
/*!40000 ALTER TABLE `pais` DISABLE KEYS */;
INSERT INTO `pais` VALUES (1,'ARG','Argentina',0);
/*!40000 ALTER TABLE `pais` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provincia`
--

DROP TABLE IF EXISTS `provincia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provincia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pais` int(11) DEFAULT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `provincia_codigo` (`codigo`),
  KEY `fk_provincia_pais` (`id_pais`),
  CONSTRAINT `fk_provincia_pais` FOREIGN KEY (`id_pais`) REFERENCES `pais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provincia`
--

LOCK TABLES `provincia` WRITE;
/*!40000 ALTER TABLE `provincia` DISABLE KEYS */;
INSERT INTO `provincia` VALUES (1,1,'CABA','Ciudad Autónoma de Buenos Aires',0),(2,1,'BA','Buenos Aires',0),(4,1,'CT','Catamarca',0),(5,1,'CC','Chaco',0),(6,1,'CH','Chubut',0),(7,1,'CB','Córdoba',0),(8,1,'CR','Corrientes',0),(9,1,'ER','Entre Ríos',0),(10,1,'FO','Formosa',0),(11,1,'JY','Jujuy',0),(12,1,'LP','La Pampa',0),(13,1,'LR','La Rioja',0),(14,1,'MZ','Mendoza ',0),(15,1,'MN','Misiones',0),(16,1,'NQ','Neuquén',0),(17,1,'RN','Río Negro',0),(18,1,'SA','Salta',0),(19,1,'SJ','San Juan',0),(20,1,'SL','San Luis',0),(21,1,'SC','Santa Cruz',0),(22,1,'SF','Santa Fe',0),(23,1,'SE','Santiago del Estero',0),(24,1,'TF','Tierra del Fuego, Antártida e Islas del Atlántico Sur',0),(25,1,'TM','Tucumán',0);
/*!40000 ALTER TABLE `provincia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tiporesponsabilidadiva`
--

DROP TABLE IF EXISTS `tiporesponsabilidadiva`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tiporesponsabilidadiva` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `esp` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `entidad_tiporesponsabilidadiva_index02` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tiporesponsabilidadiva`
--

LOCK TABLES `tiporesponsabilidadiva` WRITE;
/*!40000 ALTER TABLE `tiporesponsabilidadiva` DISABLE KEYS */;
INSERT INTO `tiporesponsabilidadiva` VALUES (1,'1','Responsble Inscripto',0,1),(2,'2','Monotributista',0,1),(3,'3','Responsable No Inscripto',0,1),(4,'4','No Responsable',0,1),(5,'5','Exento',0,1);
/*!40000 ALTER TABLE `tiporesponsabilidadiva` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `Id` int(11) NOT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  `id_direccion` int(11) DEFAULT '0',
  `id_tipo_responsabilidad_iva` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `codigo` varchar(255) DEFAULT NULL,
  `nombre_pila` varchar(255) DEFAULT NULL,
  `nombre_apellido` varchar(255) DEFAULT NULL,
  `Observaciones` text,
  `nro_cuit` varchar(255) NOT NULL,
  `nro_documento` varchar(255) DEFAULT NULL,
  `nro_ingresosbrutos` varchar(50) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `EstadoCivil` smallint(6) DEFAULT '0',
  `Email` varchar(255) DEFAULT NULL,
  `TipoPersona` tinyint(4) DEFAULT '0' COMMENT '0-Fisica | 1 - Juridica',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `entidad_index04` (`id_direccion`),
  KEY `fk_usuario_tiporesponsabilidadiva` (`id_tipo_responsabilidad_iva`),
  KEY `fk_usuario_empresa` (`id_empresa`),
  CONSTRAINT `fk_usuario_empresa` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_tiporesponsabilidadiva` FOREIGN KEY (`id_tipo_responsabilidad_iva`) REFERENCES `tiporesponsabilidadiva` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'courier'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-10-02 16:08:45
