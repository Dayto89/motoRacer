-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: inventariomotoracer
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `accesos`
--

DROP TABLE IF EXISTS `accesos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accesos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(20) NOT NULL,
  `seccion` varchar(100) NOT NULL,
  `sub_seccion` varchar(100) DEFAULT NULL,
  `permitido` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `fk_usuario` (`id_usuario`),
  CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`identificacion`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2174 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accesos`
--

LOCK TABLES `accesos` WRITE;
/*!40000 ALTER TABLE `accesos` DISABLE KEYS */;
INSERT INTO `accesos` VALUES (1,123,'PRODUCTO','Crear Producto',1),(2,123,'PRODUCTO','Actualizar Producto',1),(3,123,'PRODUCTO','CategorÃ­as',1),(4,123,'PRODUCTO','UbicaciÃ³n',1),(5,123,'PRODUCTO','Marca',1),(6,123,'PROVEEDOR','Crear Proveedor',1),(7,123,'PROVEEDOR','Actualizar Proveedor',1),(8,123,'PROVEEDOR','Lista Proveedor',1),(9,123,'INVENTARIO','Lista de Productos',1),(10,123,'FACTURA','Venta',1),(11,123,'FACTURA','Reporte',1),(12,123,'USUARIO','InformaciÃ³n',1),(13,123,'CONFIGURACIÃ“N','Stock',1),(14,123,'CONFIGURACIÃ“N','GestiÃ³n de Usuarios',1),(2159,324,'PRODUCTO','Crear Producto',0),(2160,324,'PRODUCTO','Actualizar Producto',0),(2161,324,'PRODUCTO','CategorÃ­as',0),(2162,324,'PRODUCTO','UbicaciÃ³n',0),(2163,324,'PRODUCTO','Marca',0),(2164,324,'PROVEEDOR','Crear Proveedor',0),(2165,324,'PROVEEDOR','Actualizar Proveedor',0),(2166,324,'PROVEEDOR','Lista Proveedor',0),(2167,324,'INVENTARIO','Lista de Productos',0),(2168,324,'FACTURA','Venta',0),(2169,324,'FACTURA','Reporte',0),(2170,324,'USUARIO','InformaciÃ³n',1),(2171,324,'CONFIGURACIÃ“N','Stock',0),(2172,324,'CONFIGURACIÃ“N','GestiÃ³n de Usuarios',0),(2173,324,'CONFIGURACIÃ“N','Copia de Seguridad',0);
/*!40000 ALTER TABLE `accesos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'Repuestos'),(2,'bateria'),(3,'carburador'),(4,'faros'),(5,'juego de pastillas de freno'),(8,'hola'),(9,'prueba'),(10,'trabajo'),(11,'prueba 2'),(12,'prueba 2'),(123,'AKT'),(154,'Autoplanet');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cliente` (
  `codigo` int(20) NOT NULL,
  `identificacion` enum('CC','TI','NIT') NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `telefono` varchar(13) NOT NULL,
  `correo` varchar(45) NOT NULL,
  PRIMARY KEY (`codigo`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (0,'CC','','','',''),(123,'CC','daniel','leonardo','321','danielleonardo@gmail.com'),(147,'NIT','edwin','castillo','741','edwincastillo@gmail.com'),(258,'CC','nicolas','castillo','852','nicolascastillo@gmail.com'),(456,'NIT','hector','leonardo','654','hectorleonardo@gmail.com'),(789,'CC','sandra','rodriguez','987','sandrarodriguez@gmail.com'),(2222222,'CC','Consumidor','Final','12345678','consumidorfinal@final.com');
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compra`
--

DROP TABLE IF EXISTS `compra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compra` (
  `codigo` int(11) NOT NULL,
  `Usuario_identificacion` int(11) NOT NULL,
  `Producto_codigo` int(11) NOT NULL,
  `OrdenProveedor_codigo` int(11) NOT NULL,
  PRIMARY KEY (`codigo`),
  UNIQUE KEY `Usuario_identificacion` (`Usuario_identificacion`),
  KEY `fk_Producto_has_OrdenProveedor_OrdenProveedor1_idx` (`OrdenProveedor_codigo`),
  KEY `fk_Producto_has_OrdenProveedor_Producto1_idx` (`Producto_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compra`
--

LOCK TABLES `compra` WRITE;
/*!40000 ALTER TABLE `compra` DISABLE KEYS */;
/*!40000 ALTER TABLE `compra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configuracion_stock`
--

DROP TABLE IF EXISTS `configuracion_stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configuracion_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `min_quantity` int(11) NOT NULL,
  `alarm_time` time DEFAULT NULL,
  `notification_method` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuracion_stock`
--

LOCK TABLES `configuracion_stock` WRITE;
/*!40000 ALTER TABLE `configuracion_stock` DISABLE KEYS */;
INSERT INTO `configuracion_stock` VALUES (1,5,'08:00:00','popup'),(2,60,'09:00:00','both');
/*!40000 ALTER TABLE `configuracion_stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factura`
--

DROP TABLE IF EXISTS `factura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factura` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `fechaGeneracion` datetime NOT NULL,
  `Usuario_identificacion` int(11) NOT NULL,
  `Cliente_codigo` int(20) NOT NULL,
  `precioTotal` double NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `fk_Usuario_has_Producto_Usuario1_idx` (`Usuario_identificacion`),
  KEY `fk_Factura_Cliente1_idx` (`Cliente_codigo`),
  CONSTRAINT `fk_Factura_Cliente1_idx` FOREIGN KEY (`Cliente_codigo`) REFERENCES `cliente` (`codigo`),
  CONSTRAINT `fk_Usuario_has_Producto_Usuario1` FOREIGN KEY (`Usuario_identificacion`) REFERENCES `usuario` (`identificacion`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura`
--

LOCK TABLES `factura` WRITE;
/*!40000 ALTER TABLE `factura` DISABLE KEYS */;
INSERT INTO `factura` VALUES (11,'2025-03-17 15:17:27',123,2222222,2608),(12,'2025-03-17 15:17:37',123,2222222,2608),(13,'2025-03-17 21:49:58',123,2222222,132476),(14,'2025-03-18 12:04:45',123,2222222,15054),(15,'2025-03-18 13:54:02',123,0,1616),(16,'2025-03-18 13:54:06',123,0,1616),(17,'2025-03-18 14:06:28',123,2222222,7527),(18,'2025-03-18 14:07:02',123,2222222,7527),(19,'2025-03-18 14:07:21',123,2222222,7527),(20,'2025-03-18 19:12:27',123,2222222,7527),(21,'2025-03-18 19:16:12',123,2222222,7527),(22,'2025-03-18 19:16:30',123,2222222,7527),(23,'2025-03-18 19:19:44',123,2222222,7527),(24,'2025-03-18 19:23:18',123,2222222,7527),(25,'2025-03-18 19:23:44',123,2222222,7527),(26,'2025-03-18 19:36:26',123,2222222,7527),(27,'2025-03-18 19:46:13',123,0,7527),(28,'2025-03-18 20:01:52',123,2222222,7527),(29,'2025-03-18 20:49:39',123,2222222,7527),(30,'2025-03-18 20:54:30',123,2222222,54949),(31,'2025-03-18 20:58:44',123,2222222,54949),(32,'2025-03-18 21:01:07',123,2222222,54949),(33,'2025-03-18 21:09:42',123,2222222,7527),(34,'2025-03-19 06:12:13',123,2222222,15054),(35,'2025-03-19 06:13:50',123,2222222,15054),(36,'2025-03-19 07:21:27',123,2222222,15054),(37,'2025-03-19 07:26:08',123,2222222,22581),(38,'2025-03-19 07:39:29',123,2222222,15054),(39,'2025-03-19 07:58:53',123,2222222,15054),(40,'2025-03-19 08:00:35',123,2222222,15054),(41,'2025-03-19 08:04:33',123,2222222,10165),(42,'2025-03-19 09:07:49',123,2222222,65254),(43,'2025-03-19 09:11:48',123,2222222,109898),(44,'2025-03-19 09:30:29',123,2222222,1561),(45,'2025-03-19 09:31:14',123,2222222,1561),(46,'2025-03-19 10:34:22',123,2222222,22581),(47,'2025-03-19 10:44:39',123,2222222,15054),(48,'2025-03-19 10:46:14',123,789,8046),(49,'2025-03-19 10:57:39',123,2222222,22581),(50,'2025-03-19 11:02:49',123,2222222,650000),(51,'2025-03-19 11:06:36',123,2222222,30108),(52,'2025-03-19 11:12:35',123,2222222,2682),(53,'2025-03-20 09:54:21',123,2222222,115212),(54,'2025-03-21 09:51:24',123,2222222,1561),(55,'2025-03-26 08:17:45',123,2222222,321321),(56,'2025-03-26 08:17:58',123,2222222,321321),(57,'2025-03-26 08:18:26',123,2222222,321321),(58,'2025-03-26 09:16:58',123,2222222,321321),(59,'2025-03-26 09:26:30',123,2222222,321321),(60,'2025-03-26 18:40:28',123,2222222,321321),(61,'2025-03-26 18:48:14',123,2222222,321321),(62,'2025-03-26 18:59:01',123,2222222,321321),(63,'2025-03-26 19:08:20',123,2222222,321321),(64,'2025-03-27 09:02:34',123,123,185200),(65,'2025-03-28 09:10:47',123,2222222,321321),(66,'2025-03-28 09:12:02',123,2222222,321321),(67,'2025-03-28 09:30:16',123,2222222,321321),(68,'2025-03-28 10:44:57',123,2222222,321321),(69,'2025-03-28 10:46:19',123,2222222,321321),(70,'2025-04-07 13:57:17',123,0,2223);
/*!40000 ALTER TABLE `factura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factura_metodo_pago`
--

DROP TABLE IF EXISTS `factura_metodo_pago`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `factura_metodo_pago` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Factura_codigo` int(11) NOT NULL,
  `metodoPago` enum('tarjeta','efectivo','transferencia') NOT NULL,
  `monto` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Factura_codigo` (`Factura_codigo`),
  CONSTRAINT `factura_metodo_pago_ibfk_1` FOREIGN KEY (`Factura_codigo`) REFERENCES `factura` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura_metodo_pago`
--

LOCK TABLES `factura_metodo_pago` WRITE;
/*!40000 ALTER TABLE `factura_metodo_pago` DISABLE KEYS */;
INSERT INTO `factura_metodo_pago` VALUES (18,11,'efectivo',2608000),(19,12,'efectivo',2608000),(20,13,'efectivo',50000),(21,13,'transferencia',82476),(22,14,'efectivo',5000),(23,14,'transferencia',10054),(24,15,'efectivo',100000),(25,15,'tarjeta',500000),(26,16,'efectivo',100000),(27,16,'tarjeta',500000),(28,16,'transferencia',1016898),(29,17,'efectivo',5000),(30,17,'tarjeta',2527),(31,18,'efectivo',5000),(32,18,'tarjeta',2527),(33,19,'efectivo',5000),(34,19,'tarjeta',2527),(35,20,'efectivo',5000),(36,20,'transferencia',2527),(37,21,'efectivo',5000),(38,21,'transferencia',2527),(39,22,'efectivo',5000),(40,22,'transferencia',2527),(41,23,'efectivo',5000),(42,23,'tarjeta',2527),(43,24,'efectivo',7527),(44,25,'efectivo',7527),(45,26,'efectivo',7527),(46,27,'efectivo',5000),(47,27,'transferencia',2527),(48,28,'efectivo',7527),(49,29,'efectivo',7527),(50,30,'efectivo',54949),(51,31,'efectivo',54949),(52,32,'efectivo',54949),(53,33,'efectivo',7527),(54,34,'efectivo',5054),(55,34,'transferencia',10000),(56,35,'efectivo',5054),(57,35,'transferencia',5000),(58,35,'transferencia',5000),(59,36,'efectivo',15054),(60,37,'efectivo',22581),(61,38,'efectivo',15054),(62,39,'efectivo',15054),(63,40,'transferencia',15054),(64,41,'efectivo',10165159),(65,42,'efectivo',65254),(66,43,'efectivo',50000),(67,43,'transferencia',59898),(68,44,'efectivo',1561949),(69,45,'efectivo',1561949),(70,46,'efectivo',22581),(71,47,'efectivo',15054),(72,48,'efectivo',8046),(73,49,'efectivo',22581),(74,50,'transferencia',650000),(75,51,'efectivo',30108),(76,52,'efectivo',2682),(77,53,'efectivo',115212),(78,54,'efectivo',1561949),(79,55,'efectivo',321321),(80,56,'efectivo',321321),(81,57,'efectivo',321321),(82,58,'efectivo',321321),(83,59,'efectivo',321321),(84,60,'efectivo',321321),(85,61,'efectivo',321321),(86,62,'efectivo',321321),(87,63,'efectivo',321321),(88,64,'efectivo',185200),(89,65,'efectivo',321321),(90,66,'efectivo',321321),(91,67,'efectivo',321321),(92,68,'efectivo',321321),(93,69,'efectivo',321321),(94,70,'efectivo',2223123);
/*!40000 ALTER TABLE `factura_metodo_pago` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marca`
--

DROP TABLE IF EXISTS `marca`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marca` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marca`
--

LOCK TABLES `marca` WRITE;
/*!40000 ALTER TABLE `marca` DISABLE KEYS */;
INSERT INTO `marca` VALUES (1,'akt'),(2,'yamaha'),(3,'bajaj'),(4,'suzuki'),(5,'honda'),(6,'ninja');
/*!40000 ALTER TABLE `marca` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notificaciones`
--

DROP TABLE IF EXISTS `notificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notificaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mensaje` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `leida` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notificaciones`
--

LOCK TABLES `notificaciones` WRITE;
/*!40000 ALTER TABLE `notificaciones` DISABLE KEYS */;
INSERT INTO `notificaciones` VALUES (1,'Producto nose bajo mÃ­nimo! Stock actual: 42','2025-03-26 23:59:01',1),(2,'Producto chazis bajo mÃ­nimo! Stock actual: 20','2025-03-26 23:59:01',1),(3,'Producto nose bajo mÃ­nimo! Stock actual: 41','2025-03-27 00:08:20',1),(4,'Producto chazis bajo mÃ­nimo! Stock actual: 20','2025-03-27 00:08:20',1),(5,'Producto nose bajo mÃ­nimo! Stock actual: 41','2025-03-27 14:02:34',1),(6,'Producto chazis bajo mÃ­nimo! Stock actual: 19','2025-03-27 14:02:34',1),(7,'Producto chaiz bajo mÃ­nimo! Stock actual: 49','2025-03-27 14:02:34',1),(8,'Producto nose bajo mÃ­nimo! Stock actual: 40','2025-03-28 14:10:47',1),(9,'Producto chazis bajo mÃ­nimo! Stock actual: 19','2025-03-28 14:10:47',1),(10,'Producto chaiz bajo mÃ­nimo! Stock actual: 49','2025-03-28 14:10:47',1),(11,'Producto nose bajo mÃ­nimo! Stock actual: 39','2025-03-28 14:12:02',1),(12,'Producto chazis bajo mÃ­nimo! Stock actual: 19','2025-03-28 14:12:02',1),(13,'Producto chaiz bajo mÃ­nimo! Stock actual: 49','2025-03-28 14:12:02',1),(14,'Producto nose bajo mÃ­nimo! Stock actual: 38','2025-03-28 14:30:16',1),(15,'Producto chazis bajo mÃ­nimo! Stock actual: 19','2025-03-28 14:30:16',1),(16,'Producto chaiz bajo mÃ­nimo! Stock actual: 49','2025-03-28 14:30:16',1),(17,'Producto nose bajo mÃ­nimo! Stock actual: 37','2025-03-28 15:44:57',1),(18,'Producto chazis bajo mÃ­nimo! Stock actual: 19','2025-03-28 15:44:57',1),(19,'Producto chaiz bajo mÃ­nimo! Stock actual: 49','2025-03-28 15:44:57',1),(20,'Producto nose bajo mÃ­nimo! Stock actual: 36','2025-03-28 15:46:19',1),(21,'Producto chazis bajo mÃ­nimo! Stock actual: 19','2025-03-28 15:46:19',1),(22,'Producto chaiz bajo mÃ­nimo! Stock actual: 49','2025-03-28 15:46:19',1),(23,'Producto fghdhf bajo mÃ­nimo! Stock actual: 36','2025-04-07 18:57:17',1),(24,'Producto chazis bajo mÃ­nimo! Stock actual: 19','2025-04-07 18:57:17',1),(25,'Producto efhedjh bajo mÃ­nimo! Stock actual: 1','2025-04-07 18:57:17',1),(26,'Producto rhefh bajo mÃ­nimo! Stock actual: 52','2025-04-07 18:57:17',1),(27,'Producto freno bajo mÃ­nimo! Stock actual: 25','2025-04-07 18:57:17',1),(28,'Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','2025-04-07 18:57:17',1),(29,'Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: 5','2025-04-07 18:57:17',1),(30,'Producto foco bajo mÃ­nimo! Stock actual: 9','2025-04-07 18:57:17',1),(31,'Producto fhdh bajo mÃ­nimo! Stock actual: 19','2025-04-07 18:57:17',1),(32,'Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 6','2025-04-07 18:57:17',1),(33,'Producto dulce bajo mÃ­nimo! Stock actual: 7','2025-04-07 18:57:17',0),(34,'Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','2025-04-07 18:57:17',0);
/*!40000 ALTER TABLE `notificaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permiso`
--

DROP TABLE IF EXISTS `permiso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permiso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permiso`
--

LOCK TABLES `permiso` WRITE;
/*!40000 ALTER TABLE `permiso` DISABLE KEYS */;
INSERT INTO `permiso` VALUES (1,'PRODUCTO'),(2,'Crear Producto'),(3,'Actualizar Producto'),(4,'Categorias'),(5,'Ubicacion'),(6,'Marca'),(7,'PROVEEDOR'),(8,'Crear Proveedor'),(9,'Actualizar Proveedor'),(10,'Lista Proveedor'),(11,'INVENTARIO'),(12,'Lista de Productos'),(13,'FACTURA'),(14,'Venta'),(15,'Reporte'),(16,'USUARIO'),(17,'Informacion'),(18,'CONFIGURACION'),(19,'Stock'),(20,'Gestion de usuarios'),(21,'Personalizacion de Reportes'),(22,'Notificaciones de Stock'),(23,'Frecuencia Automatica de Reportes');
/*!40000 ALTER TABLE `permiso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto` (
  `codigo1` int(11) NOT NULL,
  `codigo2` int(50) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `iva` double NOT NULL,
  `precio1` double NOT NULL,
  `precio2` double NOT NULL,
  `precio3` double NOT NULL,
  `cantidad` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `Categoria_codigo` int(11) NOT NULL,
  `Marca_codigo` int(11) NOT NULL,
  `UnidadMedida_codigo` int(11) NOT NULL,
  `Ubicacion_codigo` int(11) NOT NULL,
  `proveedor_nit` int(11) NOT NULL,
  PRIMARY KEY (`codigo1`),
  KEY `fk_Producto_Categoria1_idx` (`Categoria_codigo`),
  KEY `fk_Producto_Marca1_idx` (`Marca_codigo`),
  KEY `fk_Producto_UnidadMedida1_idx` (`UnidadMedida_codigo`),
  KEY `fk_Producto_Ubicacion1_idx` (`Ubicacion_codigo`),
  KEY `proveedor_nit` (`proveedor_nit`) USING BTREE,
  CONSTRAINT `fk_Producto_Categoria1` FOREIGN KEY (`Categoria_codigo`) REFERENCES `categoria` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Producto_Marca1` FOREIGN KEY (`Marca_codigo`) REFERENCES `marca` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Producto_Proveedor1` FOREIGN KEY (`proveedor_nit`) REFERENCES `proveedor` (`nit`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Producto_Ubicacion1` FOREIGN KEY (`Ubicacion_codigo`) REFERENCES `ubicacion` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Producto_UnidadMedida1` FOREIGN KEY (`UnidadMedida_codigo`) REFERENCES `unidadmedida` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto`
--

LOCK TABLES `producto` WRITE;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` VALUES (2,3,'banana',19,24567987645,321659878,316487,15,'sdgasdgg',1,1,3,3,753),(12,23,'123',19,213123,2223123,23,225356230,'16549848',3,3,4,2,157),(149,0,'fghdhf',19,2384,16849,1231849,36,'sfhdh',5,3,2,3,753),(232,0,'efhedjh',19,26519,65254,59299,1,'ssdggs',5,3,1,2,753),(369,0,'Faro',19,1619498,1561949,199494,789,'amarillo',4,3,2,3,87),(457,0,'jlijkÃ±',54275,52752,7527,7272,72,'hjkhjkh',4,3,2,2,87),(458,0,'rhefh',19,16847,2682,1987654,52,'sgsg',4,3,1,3,89849),(475,0,'freno',19,540000,650000,4250000,25,'frenos buennos',5,4,2,45,89849),(564,0,'filtro de aceite fz18 200',19,18462,9515159,453543,4,'asmknd kjas dkja sjkd kjas dkj sakjc jkas ckj sakjc ksa kc jsac',2,2,1,4,9298),(745,0,'pin pastilla freno set xt660',19,860,8191915981,5119191,5,'nn',5,3,1,3,753),(879,0,'foco',19,5620000,652000,4600000,9,'buena iluminacion',4,2,2,1,753),(895,0,'fhdh',15,194941,54949,59849,19,'fdhdfh',4,4,2,3,753),(954,0,'kit de arrastre cb 190r honda original',19,1659,6516516516,651651651,6,'dlgknsodnvosdnvoknsdklnvlksdmnvmsdomvnk',2,5,1,4,648465165),(1204,0,'dulce',19,3456346,876876,8757865,7,'r6utr6utryjtryujty',2,2,1,3,9298),(1564,0,'sdgdjhfgj',18,49494,5000000,4800000,45,'no se bndad',5,3,2,3,753),(1654,0,'AKT',19,25614949,5648949,659494,65,'adfsjyupo}+Â´p',4,4,2,3,45686);
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto_factura`
--

DROP TABLE IF EXISTS `producto_factura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto_factura` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Factura_codigo` int(11) NOT NULL,
  `Producto_codigo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precioUnitario` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Factura_codigo` (`Factura_codigo`),
  KEY `producto_factura_ibfk_2` (`Producto_codigo`),
  CONSTRAINT `producto_factura_ibfk_1` FOREIGN KEY (`Factura_codigo`) REFERENCES `factura` (`codigo`),
  CONSTRAINT `producto_factura_ibfk_2` FOREIGN KEY (`Producto_codigo`) REFERENCES `producto` (`codigo1`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_factura`
--

LOCK TABLES `producto_factura` WRITE;
/*!40000 ALTER TABLE `producto_factura` DISABLE KEYS */;
INSERT INTO `producto_factura` VALUES (76,70,12,1,2223);
/*!40000 ALTER TABLE `producto_factura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producto_has_factura`
--

DROP TABLE IF EXISTS `producto_has_factura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto_has_factura` (
  `Producto_codigo` int(11) NOT NULL,
  `Factura_codigo` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precioUnitario` double NOT NULL,
  PRIMARY KEY (`Producto_codigo`,`Factura_codigo`),
  KEY `fk_Producto_has_Factura_Factura1_idx` (`Factura_codigo`),
  KEY `fk_Producto_has_Factura_Producto1_idx` (`Producto_codigo`),
  CONSTRAINT `fk_Producto_has_Factura_Factura1` FOREIGN KEY (`Factura_codigo`) REFERENCES `factura` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Producto_has_Factura_Producto1` FOREIGN KEY (`Producto_codigo`) REFERENCES `producto` (`codigo1`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producto_has_factura`
--

LOCK TABLES `producto_has_factura` WRITE;
/*!40000 ALTER TABLE `producto_has_factura` DISABLE KEYS */;
/*!40000 ALTER TABLE `producto_has_factura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proveedor` (
  `nit` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `telefono` varchar(13) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `estado` enum('activo','inactivo') NOT NULL,
  PRIMARY KEY (`nit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedor`
--

LOCK TABLES `proveedor` WRITE;
/*!40000 ALTER TABLE `proveedor` DISABLE KEYS */;
INSERT INTO `proveedor` VALUES (9,'kawasaki','456','cra 24 # 3 apto 131 ','castillorodriguezmariana2@gmail.com','activo'),(87,'nose','43654645','dfgdrdh','dghfghfgh','activo'),(157,'ninja','3136481164','calle 15','ninja@gmail.com','activo'),(753,'victori','987','calle 86','victori1547@gmail.com','activo'),(9298,'suzuki','295198195','cra 17 n 37 -2 20','suzuki20@gmail.com','activo'),(45686,'akt','32312613','cra 16 a n 45 -30','aktparte@gmail.com','activo'),(89849,'bmw','94945151','cra 10 n 48 - 23','bmwpartes@gmail.com','activo'),(648465165,'honda','9528161','cra20 n 37 -18','hondapartes@gmail.com','activo');
/*!40000 ALTER TABLE `proveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ubicacion`
--

DROP TABLE IF EXISTS `ubicacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ubicacion` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ubicacion`
--

LOCK TABLES `ubicacion` WRITE;
/*!40000 ALTER TABLE `ubicacion` DISABLE KEYS */;
INSERT INTO `ubicacion` VALUES (1,'estanteria 4'),(2,'pasillo 4 '),(3,'cajon 3'),(4,'columna 23'),(45,'b34');
/*!40000 ALTER TABLE `ubicacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unidadmedida`
--

DROP TABLE IF EXISTS `unidadmedida`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unidadmedida` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unidadmedida`
--

LOCK TABLES `unidadmedida` WRITE;
/*!40000 ALTER TABLE `unidadmedida` DISABLE KEYS */;
INSERT INTO `unidadmedida` VALUES (1,'unidad'),(2,'unidades'),(3,'unidades'),(4,'unidades'),(5,'unidades');
/*!40000 ALTER TABLE `unidadmedida` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `identificacion` int(11) NOT NULL,
  `tipoDocumento` varchar(50) DEFAULT 'cedula de ciudadania',
  `rol` enum('administrador','gerente') DEFAULT 'gerente',
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `telefono` varchar(13) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `contraseÃ±a` varchar(255) NOT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `foto` longblob NOT NULL,
  `preguntaSeguridad` enum('Â¿CuÃ¡l es el nombre de tu primera mascota?','Â¿En quÃ© ciudad naciste?','Â¿CuÃ¡l es el nombre de tu escuela primaria?') NOT NULL,
  `respuestaSeguridad` varchar(255) NOT NULL,
  PRIMARY KEY (`identificacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (123,'cedula de ciudadania','administrador','ramiro','gonzales','123','123','nose@gmail.com','$2y$10$7UchjN72ld2G5N44/XdC/e5wfM2M/9TeNCktN5frRAh7jBS1voZp.','activo','ÿØÿà\0JFIF\0\0\0\0\0\0ÿÛ\0„\0\n\n\n\"\"$$6*&&*6>424>LDDL_Z_||§\n\n\n\"\"$$6*&&*6>424>LDDL_Z_||§ÿÂ\0•à\"\0ÿÄ\0/\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0ÿÚ\0\0\0\0ð®´šÓÕ‘7V\'LšlE2–PIA#À˜Y“Š&•Uêe¼î™gÓFÊ\\gd˜–Õ[i*Ê’Ñ*”N{D×<j›æò\"¯ž]N~Œ®è×9Vµ °ÅÔ”Ê¨e3f±æ93ìÍy#£3nè<ÅÙÌ@Ò\r0\0ô»y½¦‹¦ÌÓu.™.`0‰.DJ©€˜5ˆ¢KµËW¤ewThª\'Yv5HE2\r™ dhÈ-¬2ÒóÆùæá;d¹ÛÙÄë×ÑÃßyK£X…hÍk\"¡Ô«VDèŒ§Y2 Ç.‰93ìÀçË¢%àËÑæNpTÜ¸úW™SoRi°&1\r’9†M\rÃ\'=ñu$K%5ÎÊ¹¬èºÎ«JÉ¦¤3G˜kYÐÜ2Äh`\0LèŒrê‰xŽœ×Ê]q5É==#Ð¯(¬¥H™°–¬J•’­TM¢\'I2dÆv“ŸÌÎ<º±Ž>C©>ê™hÕ¢c\0\Z&-C$¸”—2‡„ähò¢ë:[!&µ\Z™#¡óÙÑXYo&oXÒjfÍk:-\n›šÀ\0\0	¤F{g/>}YKÊÍ3j1vjÑ`\"œÄ\Ziž”\0‚¢¢mF“)ÒLóÚL1êƒ‡>Ì^_C(ú¼ù²^êâÖ:õãÐê1,ÕLKU¦zAM™F˜óW)¹ËÑ.®[‚5PYÓÙàÎ›åÐÙä\'Mc¥jò³ZÍš©vUC,L\0!‰ŠjI#7:9eÌj[qZÉÉ¬Ò¡ÓØÆ©*ã\\Î<ºàË|déœõ3¤Ã.œÎ<»p;«;Î´\n‰ØÐ`$h•kr@È¢GŽ¹½œkeQ¹˜ºÖ4Y˜Z„jdÍLÙ®œú&ï&o¦›^:<ê®³¤º‹,š ˜MH¥¨ÇŸ¯’X¬µW6ŒÖ™ƒ’Ê%O7Z	ª\0v‹0Ïx3V—5¤…e £Y0Ïx+L÷Î^‘l¬Šl†â]^%š™Á²ÂMbag“¯š2WDVlÕH2Bœ2œ²ï+5¬ôM*(ÖóºÒó´ºŠ.¢’ê*¨LC@BMF|=¼róte¹lÐÏ.ˆ1ó\"tTtcµŒe  šVg4-$Ît“&Òè¨2 ÇY¼k{›*áXÞitŒó6Œ Ú0“¦yÑ½rn9T(r$…nYB ¡1€Uç¡¦‘©liW7c¥ETÐî(Ò¡ÙnXÐ\02U(™¹1Ïi—êÈ¦¨2z:ÅlÌÆ¬¦Œ³9´g:IœéÔèg:J»/\Zš<Ÿ1YçÑŸ&G^<²uG2:Ÿ#;=Å¬t˜ÚÒLbe\00‚¶R\ZÎ£Òm.Ö–P©°¤ÆÓK,–”áÕ¹¡&­DMÌ°©\ni*¤rQIÍŠZ\0`À…JÉšDMÉhZå±3¤­Þfi“ÄŽ[âZçŒÆŒHrÕ ªÍpï/Eóé.µ–¥1‰±FØYhíPîtKÓ=*ªi)ª˜0\nAB$]äìÔŠâ,¥³›#¶|¼ÏR|t{ãhzõçï]Fv5B (rµbM7$Í\"uËQ«•ÌFuúrÆ<[r’¬²4\0UM“žáÌo‘\"\n¨¥½p¸èèãë—f¨ÇE ºŠ4¸¤Òóº»Î“GX‚„@ÀrÒœ²³¹9ø»¼É®lŠ•«&[–mÙçèzÛyýiÔñº¹ÒV4ËD¦…qFÉ‡<ÖYÞ\\}qÏ•²sÓ:\0)¦]f“l÷³Í[à£Au\ZvrõÍoIŽ•\r¦2YWšTQu“MÞ6mXÝš¼ÃRD…H§ºÍ–&.~”x~oÓy‘äšf!”î,‹¯wŸèFúEØØìC	ÏO5;_—¥z›RÒ¨£qróíÍãË¿2LkÍYÊ,mhó¤Í¾¾n‚0éç ´³j£§§.™«¤Æå–K‚ª¥åeË¼¬Ò³¤ÕæëJÎŠ1\"‰cÅ¼ÝiY³W!ÏÒÎú?2<Çßïiò¡ç\ZïËÒièrvÆÀ°§Èõüƒ‚.,®Žõ÷ð¶=Ëäé®§7/Ï¾8ß&z4Ï‡¿ÎÔ\0Ä\rÈ‰¦ky\"¦Bï=”Ò÷”ÞjV\0Ü±ˆÍ–J4Ó6qEÔ²Ü¯6iY³Gµ ÉI”iYQ­eVlò´9; òý^*—;ÑÏ¥žŸg\'IÐ\'Š¬b)xþ¿pJ„¹J‹Š=^¾Êî×\rã‡›o?#nN›2ó=6À@&€XÒƒ±u>œÙÙÐ˜(\0€\0­ wiqe5@ÓšHUgIDƒ$,‘@¥¥VlÚ²fÏ;¹ËÇ÷|ãÅq§QVz¾w£fÍV5	ÈÜˆy·˜yK¦ëŽ}NS‘ÔÙ×ÙçuW±ÑËÔy||úaÓÇ®¦¾£Åsˆ€10\0uÕ/?VÛDjÚ¡†RLrCVÕSkw6Ž¦€\0c\0bCIá”å¦0\nr¦Tšã£O‡Üó+•µgg§æzzËêò}z×ÄqÌoÍN¹á3äéä0ÏhÔ}\\ýëuòuž.:Ï>žlwceâUÏ\néÎ24\r40:ö^\rû´Œ7¶©´\0\0\0\0&…\0“VÓM­TÑ¥Í£`6˜ÆÄ4%HI‹\n0Lu6\0Ô‰¥glçæúÜ5ãFÊÎîÌòÞyûüßK–½&¨Ç—¿˜ã4Ì&ÑÉÅèðÖ\0Xk•Ùíöqö8*FÝ˜­Ã\nÖŒkAaÐ&\0\0€\0\0\0\0CDçpKMm¦®¦Š¹£KÎÊsIM2š`©RÚˆ©ŒLhTÐÆ`†‡¦tšåµÜxg´Yær{áãz$+„ºå9Æxï&FˆåóýO8æ¡ŠÖºž¯W?MŸ3¦Zã¦—6Ž“V\0\0	¡\r\0\0 \0\0ŒC7gyƒ–º4ÇR.•›5¬èÖ²²ï;-Ã(\0ÂÌ c&Œ@Úh!¢¶Ã{†2ÆÊ¡3Ï¡KÅ¡Šð­±€\\™žZÛïÏÓ©êoŽÖ|Þ±¦:isC\0(\0\0L\0\0JÀ¢£=¢9òÓ19Z†P…ª‡-ÖAµóUv_>¦®),–60dÅL 9cPš¢ˆeTRoÑ‡EÀ2ÆÓ\0\0FˆçÇ¯)x3êåŠÎÃÎäïà2îáïÞ}}3Ððm¼tu46€ „Ð@À™U4[š°›N~þs•iºÌ]u.„ÊÖk3Jå+ÑßÍé;ôçØÒ¢‡RÊb—3CABh\04³ŠœÉu¬îÊ¼õ³£|w¼Ø;‚€\0`&)¹Œ9;¹ÎU©/ŸÁëpž‡/£¼ö\neòØgm m\nÄ#B\0š©eTÑU5ci‹=¤åÇ¿3ÏŽÜ%ÅÔ«D*Ê³YI&z¯W™Ü½u–…’Ê$RD´å¦€J.sŸ7ZÃUÞòÕ6Ï}g]²Öâ€°i¦\0\0,3Ã£(æZD¸pú<g\'ošž–xTr´æÀ\0@Ä\0!ˆ\0\04Â¥¦SLª—Væ’šb(1Ë®c‡?C5ó³ô1^û2^E¶dlèô<žé}My·kG1!$¦­ÍSi²e§$c’%Ól·M:3è¹ÓY»‹¸»)Ë±€740\0hCDç¦qŽzå.|=ü‰äáÝÍWÙÍª¶‰¦$1€\0\0\0\0T±´âÊrË¬êÍQnZP5S aŸTËÁÏé`¾f=üëÉŸNF}¼½KèoÏ¼Ö•Tš!\n[¨²šw1ÅÙÈœú^™¦ëk—¼ksw4Í\\Õ§@\0ÐSL\0\0Ï\\Ì±Û8Ç.Œ¥âÇ¯”‡6²& \0\0 ÁT±€C–6Ô2ênw%ÖuZ¼èÑÅž=0¼<¾†ùøöà¸oMtï†òÝÅi@+¸¢êjç,¶”Îêä4ZYZÍ²éUŽ¦‘´è\0`Lb YÜÅÄN:ã/?/^+Îi™ (Ó\0©\0\nšhÄ\"NU¹ciŒAB\nqET4º†·YÑ¥eFµ•&®*šhË.ˆ—‹›ÐäšåÐs{í–…Ü^”€YÕTÕ]MÜf¨d¹Õ”•J¬tš6Üºm0`\0@Ð…ÅLFZå.o’ã‡)\"Ó¤\"„\r\0Ò&Pˆ(–7,··UC-Å\ZVTmYZhH	¥Ë›¯ž^Bæo]3»t¼î¨SUSEÔÕÂË×=™ª)Œ\0A…6˜ÀÐ†	4LÔDÍI1\\òÜc™Ñ<¡Êc@À@€š\0¦\r\0\04å”å”ä)Ë-ÅQEÞTjóf„±c¾kËCJæ¦®æª“D-TÙtªá\r¥i:3U6ËiÓa`\Z`Õ\0\0\0MH&ˆ‹ˆÎ4Ê\\¸ú8ˆB]6Ë¦Ï5§6À\0HÜ°\0Ë\Z\0\0\0–S–PÔ´²iiÃ-Ã4¬èÒ³¢¥†YtfÖt\rUÍ\r4CÕR«.¦®*’­[%*°©¤\ZtÄÁ¦\r1‰€\0šhˆ¸‰Î³2ãêRùÓéM¼½)§šØÒ’S–1\Z4…b&ƒB°HÚcr&SANYD±Ô…¸¥Òó£G)ÒW%iJ›TªEJÔ¡£©«+HÕš¸¶XÄU,m:\0š\0¦10M8Ó8ŒõÈÃ.ŒÖo97|ša$Ó@  ¤‰\r\0‚€!ˆF\0ÄÆå–äªUC(AM9náš^ZM:JË\Z“R4¬w:ÙV©—¤h2Ä46¦†&6˜4À€Hä˜¬à‘¦dôæäùá“ha%”R`†0@Â¥\0\0h)Ë)Ë¦&S†[–UEE¹ei.•°vÉHQp®¥Å\nŠÛ=Y¶ËÓ;ª\0ÐP˜1‰Œ\0\0 &¤ŒvÊ1s”»Æ¹H§Š<ñ \0 A0I \0\0T414\0\0\0\040\"©¦:šK•Ô´»Î–ÜQ­gtÓDK‰ª¨¢îjçM3¤ÑÅYU\Z8¤¡i¦61€A.	Æ²ŒâÜ¹-Ã°s›¥ñÒJÐ†!€4\0\0&”\0\"\0\0\0\0\0¥T\0\0Â“—-¸¢‰v[’[¬è×Lt,EDT-iž‘m;*¦¬ªÎ’Ü…Þz&ƒT\nrÊ10Mr,¯sS›ž}Êº1$˜^ƒ8b¤ÐA€@Ä#\0L\0\0\0@\0\0*]0Ó\0 §ÝgE¹eTQ¥çf‚	ÏHZÒ¥E%¹«š(wYÚUC,@Ü…ˆ@\0$!soÉ¼úa-kÆUùÕiÏ=(ó@T4$ÂFPK\0\0b h\0\0&\0\0M¦6˜	A@)SE4Ê¨¢î(· $Õ€]Å%ÜU•QE\0ªM#\0§,¡rå4(¬Ì8÷âÍÏ`È .(i®%¦4&X°ÚD€I‚!Š€@\0\0`\0!‰Ð¡•	@Ó)ÍSEÔQBJ9qe\\ZUK²êiLª@Ü²ÄÑ°\0 §© ¬§ž/ŸE/wó\r\0,µ€ $¢@‚hC6KbÈÒ!€\0\0	€C1R¶˜45C\0ºŠ*¥”’-jášÞZ%Vuf•UKJrSE9e4#‚‰7”O/FKÌ«ì¿?s^^Öy³ÙÊK€´ª’JhŒL\0\0\0`†€!”\0@šP´ÆÀ\0‚ªh`RÊ¦:–¶HmYÒUåF×•\ZÓGyÒ7hKFŠ™ˆ1¼Fñk§6äqOG0÷åG¤üÍê¸ý ó4¼Ò@š\0Œ\0b\Z\04\0Õ\0€\n&¬@ Crá”HY!Nuá–åÕV&15*U\ZVlÙæÍ+*M«-¦T€*¢T8&\"ñºQ¦di0k†Ž8g¯–¤\0ßšUy½ÉÆÐ\00\0\0\0Mh\0\0Vˆ@C’JpË%B4R-¸eÖT]gU£Î‹rÊr-9e\0­¡iË)Ë‹¼¨§×n}îz\Z©ÎeÀáç	L– ¹eDUEEÔ%c«_>;yL®]	É±€\r \0\0\r5\0D4$Õ\0	DÐI#’@H§-\\ˆbä4qJTQUhåÛU±TRØ‰h@ÜÒ¶ˆmT3^Ž^‹Ž›ŠrÏ2\"¥\"b B`že™YbJ&«C†:33Ùj`Âh\0‰€\0bÂU¥Ì©±&„4LTªš‘&‡RÕ!+@12ª(m5§4[N›šKZsRÐ…§.Z¥T!E	Œ`ú¹z˜ëp8óË­çÑH†.+H˜RmFbETUO?\\œû\Zž{Šš `\00\0b`	‚`	„+IšµP®f¦%\\¨ i`i@i…K)ÍR×FŠu=§)y­9©iÍ+iÅR\0\Z–©ÕÏÖç¬iãŒÔÊ!\r H‚Èee´Î¨$4ËFdØUÆÔtOB|¶¹k5m5\0€\0\0\0l’„•aœé5œkss*šË*JFs¬5 (Ó˜êZÝM0;8úŠ–©ªQŒm8¦5mR61ŽRúùúÜ–zdÆSP$<ô\076f\0Ü±Ü²•kXéa®ùjŸ%¯>­mYQ£š”\0\04\nÛA9í‹+(ÚgX!RY)¤“\Z¥Ái\r€M[š[¨£JŠ+£›@šJ\\RÓN!mË)Í#©\n#¥é§‡ór\0È\0¨¤HÁi,Qª34D\r®w™oaI¯Èi•ÖÏ;]k*Êê(¦˜2¨u¡$ ÎušÊv“ú3\\V²Aa„áÛƒXšL%*jÚsEÔµ«†X…u5-ƒ!d²ë6Y\Z3}ŠÜT¼îTµ˜!¢ ’\rˆ ’Ã(× ¨fÝœ6t5+òUWq&ºc´]gFµ“µÒ ¥H‡Dºdg¾fkY3 Æ6“5 fîŒdÍj/>ž\rp›g4˜ÕµKMRºT¡@RkB€10f¬¥Þ\"aKJ“˜&†‰la-Ñ.¨ƒGfoVaËèsKÇp—§^^ŠèÀÂ<=%ê8¦‘&šá¬k¦:\Z<èÖ¢ÊrË¥@0S¤“6-3Q1Ï¢L^å¼ëX\"¬lË—ÔKâ¯a5ä?K®zÑMM£ªˆ,Y.Œ·³Žý\rØâìÚ  ‰µ1PÁ$:dÕ]MiF/FC²¢6GŸÇìñMyûâî¶SÒÏ…›/X°‚M4ÆÍôÆ×KÆÍï\Z5¬œoxjiQ`“CˆZ†nÂ\'`Ám\'9´,j®\0Úª23Þ—‘v‹Ç¯@az¸ÆîSE›B\'3e…&\r0LØfí™ÕQS»¤è$ ’¤Dùþ×Ÿ[ktºãV>HVRy  w›TšbÎƒoXÑµóÒöiÅ¼tTZ.Â\nd”\nnE\"U MMEŠkV‚œ‘jQU‹5x3HÎJyÄ»Ì\nQ®˜Ù¥ç Ú`PK¦MQR0L\n©¡€\0¹ÐLêÌ#pÊˆÒh3©Ðiž•D£ÍšÖVkYQnXú9ƒ¿£ÍêŽÚËR©ÕA£3Z£ö“%´™+—œJŽC³~.ÅÒp¤é™¢ó¸uç^5ZC‚†7+˜=\rxö:ošë¢²ÐÑª*Ñ Lu41!’ŠC:Ñ9ê¡K+ãdB\0„\"YuÑÅUÞv[–8ÒC§[«Êî—ºðÙ-§NjLîé2ó9ù{¸pŽxs]Ú­8q¾˜4èœÜÛ¬ë[0:a{Tqñz9€¦ºµáÐìèó»ŽÍqØÑÍ•R\rH1h)Â‹œàÒp£¯\\µ¦ h †ƒ4ÏššTT’40©eÔÕUE\ZVvTœÞfýÞWN^ÏW—Ý/UevUÆ…Jmyþ—\nxyts‹Lt^%…æóP^ü}ñµÕ¤ì¶Xz³%®êxµ¡êMÈuz|>Ü±w0ôÊË™‚ÈqNEi9Dºc0i·/}šíÎërH©™+Y·8¾\ZkQ\r¦$\0Ð7,·ºÎ«KÊËhZA:c¡ÛßäzzZñôKÓyZhâ©€O/^6x|~·“\\úåÐ½!Då®EÍ\"½.œºõçê.…\Z<ä<Í|›yø·ÏYËLnOboïpúk9tç—ŒeÝr³ª¹.:•·Äo¢œ½MïFhøzUtrrÇY‡-uñ¼ÊãŠ³˜ @\0\0\0Ü²ªiYÙ©4)¤gnÊÛo™Ýºa±¥EÓ[ggŸá}ÏÖ]îk®.J¡\r3Ù^ÙÑÕ×Á¦o|óDtc%.^ž=IÇ¯žÎ|º¹k¯Üñ¾–6Ý<‹æy~ç‰f58›íæöKß(ÍÉ4:ž«Ké®-µÈŽNé8ã	\\ºk…4Ç^\Z¬’K\ZT\000C0L¦UÅ—QTÁŽÌÉ¨£~ÿ\0/®=møú³v¼´²ÜÐM*ãñ~ƒÏ³ÇÓDMºá¶&³pvÉa„¬t#\Z›|RIuÏ–¹‡Òü·n_]~wd»‘UÝ¾w¯ç~×EKUaÚº*é0Š˜Ë=³3âîVù„ù©	\0\Z\0`\0\0\0\0PÂªÀR°Á/©Úk UØ O\\L€\0N€_`.6ò\n®P‘ó…N Lìûa‹ÒÀÇ Ž>PY°A§Pi×@S`\"P.>X¼A¨€°?ÿÄ\0ÿÚ\0\0\0\0\0\0!~T“0Ã€Ã\næóN<`ÑÅxhÔÇãVˆXSêè.µ„g§ÒjˆîöôÊ¥ÛqID_@x0ºÜ(oªÂ\0ßQ1\nMßã‹šMÿ\0^’2€µ™F¨g\0àHh‡JÏ\'.’ßr†_x¯(âÁ\Z­¦×\\Ø=Æžhñöë‚\0U´˜èRÐ@<rfƒU…•Â!Ñ¡ý=¾yíø@` M8ÒmËõVÄÏN=£8AÓ‚È8QU‰Pg(ÑÀ+|’Ÿµþ±à,‡ï²ŽòÙÜ|ˆµlY¸Ûyè5Œñ\r¥ÊÞÚ³|ˆð‚k?sÉ\0>»nÚ–`@t„<1Üh©rqá0¬ñ±ç×‚~ÙâxÓzê.\n0!šPÆ8pPd‹A7S*ØºD£ó\rŽ®d*î@m1÷wœA6Ž%ÐE\0l‹Y#)‚ÚD#ìÖç-Ÿîú@Ð¢”³á6Òƒ˜1ˆA@ÐAÜ¥Ã\r{:ƒÎüðÎn­W¦Æ<XWN¾Uñ 5¤‚0É¶Ù´ÓûÛ‰v&ÿ\0OÆ1æyºðXÌeVQoâG’\0\0à3pÓÂs@±Ï©´sÂY¶ÑÅd¦‘AT<‹EµXE0mŠúÉöEŸÊûT_wVºB€ÓíY\n•°Ž%Â_Tò‚$çpÂFÄQ„C5;‡ˆtI„¿¡04q!MçE4uÙ*ÈkïG6V›(Šµwëç7óÌ<ð\'Ø·‡qTÖE÷m„{>ð5ÕÞ¡,þ½îaðÃ<óÏ\"~ÄG¬K\"Š]Ã\r\"‡E0SA¢Bs¨ÛMôÍ16 ïÄÔU\"£‚Öœ€4§ÁØð6”Â°WÊDBBA*lMq¨-\0DöIcRPgŽ!‰4ðJ	ToPp·˜P<$Q7!™ÑÈ)‰Ñ­gCš…œ1Î.µ\rÑiCÇ4³¨m±„:Ò—|t]=‡Üá\n 0‡?;\"3ƒ=Öƒ\0ÂLQúq˜ídÒöã\rwŒó$Ð{‡üˆ´\\p0Ì(Ñ„‰@]©\n8<5aì?gŒ‰,ÃÀ0f@ª$QFÀ\róË\nèñtŠpg•–˜m ŽÔ¹›èP2…]7pi8Ë0ñ·#‡FZ#\Zzdº\n9G\'NÌ  <\'ÜSòÅAGJpøê¦iÃÏ›qå·ÍðÊwW£Ô\0(Sêgl,wPÓ ÂA6‹\"0ð@#ýT÷ÿ\0\\iû1âŽ\0E+Þõð\0Ã$ \00±ã«iÅ“ß,¶”ôl˜¶Â(à€±¾wc_,„Ã	¸XG|Ï	’mg8(7;ýâ\0(J#‡E8&DrÆ(ÑÏ?ÅFÕP‚ï=øÃÁ_u]‚Ã\0mE„_M÷‘Ž(Oÿ\0ÿ\0\r–°çÜë‹£Za2 \0Ï¡ÓM÷„ÅRLð—Ë:Ö1^nü5Üöã¥ž5&›4s\0š‡Eôß]Ï#ÿ\0ðÇ‡Î)y¦G~¯-Œ]‚YÀ…8AGçÒÂÂpÂCaòÿ\0;U2L¡ÛUÈ!sDhæÒO4WXtßmD”môñÛÿ\08Ã×Ý(Ô40Hhð)L€AT$ÁË¶uu\\!%p,?Ã‘Pôž0ãŒ\n\ZÎ>U$qÝ@9Í\ršÐAõr0€Ñaî!ÿ\0,´Á4Ö±3àÞÙx`„]@¶ÏŒÌG	ü°Òqô=ïî¼ùPR$H´F…FE•—eçq|(‹¨á\\ARÇ-~ƒ8xÒÊÂ\n#ÔBZÚB4Dÿ\0à¢$‰5ÙIÄ±ßßÿ\0<‘‡< t¬q[T4š|Ám†)ƒSa¹Ôl>rE³Q„\nžDYX>þ0òH†9—RŽ†ÓÎ$rs‹_aqlMÁY„µJ±U9¯àÙä–ü¡é<2 BÂ§§A¦ãÈ@ÚD;aüd´¥sL%wUQÆ;+Ž%0sÏ8Ç0x¬$¡Ú}œÓÙP•N(\01ŸIãø¸ñT-)§ÏpÓƒ|ò]p‹,Šví¾K	Éw¦p8òlq@qÈ¦¬’2(4YSG!Jc¡™,ƒäIEÆR41I’\nOçO,MRà°>{×,9ò˜8Û*åÌ22UßBK,¨çqJ¦:É#ö¤aŠø5ì7G0!	,=â¶ÊºÑ…³ŽOðsÛÀC’¡Wx¶nŠµ}µI$ˆ0y¯¡*Øóeæã‹¦ðçD¢·-—rê¶VE@lüÇ(SÒgäÒË¤ŸvÇÛz‹iáB=±ä=§[WÛÀ®)j Fø0Ï\0OxŸõÍ4ÔCžOP ÈàÁìF°¶èg ÓAD{€-Õ†½Ñdk%\r\Zq$ª!(Ó[É>‡-œžèæ¦¡ŽPø¾‰\n/ß,¾oDÂ÷…¤—¹É) AÞrƒå¾° ˆ¢Fþ#þˆ;tb*ðP[fÈU0kBs <`“2‹ï¾(ƒ$¡Ÿ¹„5ÀÅ¾QäT@z)‡†ž¬+‰x“È’Ë(’ˆÁ\"V©òëk<pÏ62ßÃ+áEuot\rÿ\0ãAÝb|A~A<\0?`t(¡w×ÜsÏÀ„\0¾ÿÄ\0ÿÚ\0\0\0\0\0\0E\"rnQóÿ\0^e”Ð°ZÆaÍu#6‡.»ª\\šº*f·­t\'^´Ñ¶5ñJThŠŸ\nFjg„Xò:×Ÿ[æÁ\"*CYM¤ñ«Pâ_áèuX)®úÃì±j¹×3&\Zž27Âí0óô§Ü?#iºJ¶5I$§‘6°ÛŒIq§Y«m¡†\r9s!¸rL{\'´±Ÿ ÛŒà¹rfEÏ³Ë¢o6JÀ_@)¤¢®).V8\\èš)ŽÃ\Z\"ú-¦·µ_M@’0Ÿüšª¢ë#*eH]b%¬€ÈQ`›G„o«òÇ¥T!˜tÍµ_íd(â¨2Ž…`0 ”Á „5”È¤qiã,:¹-xÓ¡öY!šNDÃ):•i•6–ht MÑ$Ö™ “>:»,ƒ¢‚k¢ÙðûH E”¿ænÑI2à‘Qi…l‘­m®87àaßo,b2mþæL.±—Î›Üþ\0ƒ¿b™QÃ\r>³\\‘1@Ÿ£‰ÕnA9¦¹¬×ìòfîÅ‘œ¦Âu›$ñ² Ðð¢ê¤ “«söù>)eÌ>ÖQ†\0‘—úèÂHsŽ%ÐþÃ“¤ó«*‹ C[ùgÔÏ–€†%Ud„]M”v*\0”@\nà6\"Á˜ZE†ÀlCâY­{\nP\n4b–$¬À4SÌ]T€oœo©P‚S¢œ_9Blø])B\rVÑ BPQIƒ\"ºˆk$\n^½+‰Qä”CUû\\QÕ5ÔUï• ‘|{ú(0`\r0€±!\0pÏywÏ+kÂ<‡\nSÅƒ„dÇO\\8Ù\0©Ò@c8\ZÑö]h5•00·•¦Àá²ÒÉÛB‹+_›ÿ\0ÆÔ¤hh%ðíãÏ(¦Ò8%¤\ZX‰t\nû\0YD=¡,j¼b~žú;6%\"Ÿ\0fœ0¬uT€’q\ZuM‡vG×nAîkûnŠ˜\nÌ¢!dó‡ÓŽDU[”ÅQ•N²p™ÔŒÙzšúä¹§“L¢É<\"0’eœn¡)\"«„B,Ã‰ç‡ùå¶š§\0Ø\r@K4óe  ¥W	ˆ)WàWmQ­=¨‹/®«êŠ8ßÇÐâž$ˆ$›`èQkT;w„á˜ŽnËø*¾©¤?@tyÐG-·z8è¦¨ªŽ—Â’æ}a1*ˆûŽkâ©òŽÝ0ó©À0£¦ž€ ÂsW—:â–>o§™b’»|F¢4ÒÀj¢ŽË¤ž‹¤8£C;ÏPæ&¢¬&¾ûî¤ÚP€¡Çeá	¢)/¾k@·p‰Š%UDÒ¢—d:©+0~‹ï®úFz°—$Ò\\¬»ºnÜr–++´¯B¾	1ˆúý¯šêh¤æÓMr¬ž*iW¶ÑÐF!“i}»„(¦ošû,‚¨•®£W<Ýº˜£¦h=ï®–Mtaæ˜ÍD¤‰ÑzQíª¾(%‰¸æË1Ÿ‹yÎX§ÿ\0ÿ\0ðÃ6~Š§È\0m­„)–Äêé¶iØÍ„\nŽ<»ûÿ\0ï§ÿ\0ÿ\0ÿ\0e^tØ%&N¨lšx\'­nþºmºˆajÑÑéªÒ¯ïó°ÿ\0ñRFËlÄpIUB^qè­žÊîšSZY«ç®hþÿ\0¿ÿ\0ÿ\0ÿ\0åŽi“0·¹ˆçTœŽâÿ\0+*¾©F™lª§\\“\'Âÿ\0þÿ\0ï‘Qž4QÇ:+-ÒÝ°;<¦6\\ÓŒ9”¢þÿ\0Š¢óÿ\0Ý Ê8²\n’›è£T\"‹Ñ=ï`ˆº3hÉ~Ç=1ßü¿õ&Ý<\"	áÄG¿&†.3¾Ä† ¢TRyÜ\0ÿ\0¼<ãú™`¡C.˜ôK§ö©(©pòÓ,«‚iF‘þ¿Kßóïßq$’E,d¼:†Œô‡R`»óæÛB€ö&ßÿ\0è^·UqE0h!„£\nmƒ Iïži#mðh™æR€\"ƒnŒ³ŠCˆÞUbG%”a¡7†‹§FáöŽë¡ÇÙ0FP¡L Ö~J r*G¢$F!\"ÔmÒ©Î¶¹‚¨ ø×”T4ŒýáªÈ£´°Í€µ¡`Y®Â} @ëvfAÙä¶:,U4À8\'H`+·¨:¯»v²dTÒÒfV¥â\rTô²	¦ Á\\Y6Pu‡ ÕM§Jù$\Z|e„#qÄ:F®B¤ó2ŠÕÖ]íÇæŽiõÀœÈÕ\\šJ¥Î“fÎ¿¤…sî$#/[aèe}>é‚)G QLO\rl’L»Ò8ÿ\0F,¹8 ˆ æËõ¨¤Ÿ1¬Ø$×T ¢6<IòzØ	°×“A\Z	³ÎPslÛM/çZ¶0Y?×Œ^+À+×ß¸´oh¡qD,¢R	Œœ¶”ú¯þú{ÚmŽšêROJzñ­Îº: ‹hZ¡,¤³ Xs:­§®}ÃH9Õ.8š¨f¨E¥äˆ\0aS¡{˜N+ÍÃ²_~¨ ±Ã2Ÿøc@&zš½[C³ŒA³E¹\nJž8€£ Ceà$¨ÌUá—æž¹  &žb¤ÐøÔêA%\n`À†²‘šAS¹p_áÏ‰rï¾hM*E€{Çm³…	Ü€V©rX•†Ž†h`\0í\'ƒÉšË(‚j«¢‘N…òùg‡6£ßCÒu•\\ÎY°{«xã|?Ã0ßÿ\0ÿ\0üþ\0ý/c|_ð £p7Á…Ðü\r×¿x_ÿÄ\0#\0\0\0\0\0\0\0\0\0 0\"@!2B1QÿÚ\0?\0l[Y{ØòP†)hËby2ÀËXêŠ+j†Ä¢ô²æË.¡Å£(¢Œ¿±Ž‹zÓ\r™pØÞªl½™ähcÈÉ˜Â„-èe	V¶6Y|,²Ë,Oj\Z2Äx˜±	Âb‘êÅñx–XÜY|Ñbcš\Z\Z2BB…ÍìÐØÊ¸ÙcŠV¬qZX¸µ\rT4>TÅ«Å®<˜¢µ±òR¶qZQBÝ.,F†¹-¬±CÕMŠóP‡q2Ç‚à„XË›,²ÅÉ1ˆZT44=.*âŠ*b|,E»õE—¥–XÜµE¡5þj§!¾)—­—9b#õ(òeˆ…	ýG¢ôÅz¡²ÌŸ;.¡2Ëøcò}aãõ£ýN0ÑF%¾YiEpEÂ›,L²ÌY‰—õö,²ÏF,ÄÎ0¶<P¢¢ÿ\0\np˜‡ýŸØ³Ð™b103ŒYèy±=Ç‘z¡ð¢¹£äþ0†¡JÈÇ#(²Ëã\\(hòVÈQŽt|Ÿ&YËQe–|Y\rõ\\l²øT#¢††9Hø±û	EqBÝzŽ´dŠŒYñ…ÂÖ¥ÍE‰Ã.[,Bf;42Œƒ,ºV­h‘CÒôÉÂŽíBQïZ\"õz\'-ØÄ„.!Â|/£”ÆËþe½\Z\"5	¢›ÙÆLS‹‡	JÙŒ|«KÖË–1‰KˆJVÌq[ÑSE-,EŒcä-1.ÞÆ_æâÇ¥BŠ(B…Á³/Â¥•e\n(®m\rÂ¸.QBÕ5»çzÑ[µÅC/†Z^õù”\\­ò=^•ú—F75ú+t4Vù\rõ¯Ä»fõ¯Ø·½rQ‰µþU|›ÿ\0mCBB\\Û†âŠ*h¯È—[,õ-~ª<”=¬²áÍ—¥k•nÙe–bÆXÇ\'Òånµ²ô³ÑzàÆâõL¹\\—e./T6>H®7ÙC—ª‡½J,¨{¥ÝËÕ‚\rJ+º‡wÅhÌŠšŠ(®¶XØØÞïz([5²ETÑäòy<W¥	,C…4V¬ò<J*QQEZ<bx<3ÎGœ‡€°<j\\QEy<‰O\'™óŽ”=TVì²âË,²ÏZQSP¶B>œ(j/wC.‡™{!Ç›%o[ÔÑCÄÁ‹Ý—+Z„ŠÙ¦Ë/žXÐ²ÛÉäxÃ„%El²ÆáC/…è†eŒ&X™qEEG‰E–3\'‘â3Õ†2Æá†ñ,þJèÌ‘eŠ¬pÙf8˜¡ÍÃ(¹ò,>¥\r	„ŠæÆ†Š„-²2Äð/ŒÇË2î1Ç<q2SŠ,¸C*^ËJ>E\nµz\\#<LF{Ìz…ˆ¿ˆp˜„‡Éi–¸e«þL¥éÿ\0¦&ùÿÄ\0(\0\0\0\0\0\0\0 0!\"1A2@BQaÿÚ\0?\0å›Ïw\\˜e»v]–|¯‹Ã?.^¦có>Ö}÷’ìŸï?ã/}“\\‚tN†Ç8Îrúl‡çz_xq¿WéãŽ-·ùñíÛ³¼ßcšä.N>Çc8ÎÁí‡¯éá‡ÿ\0oÔú¿[tù=ËÄ#—.\\ðåÉ.I¦ç—a±ÏŸ){8N>ÑðÎÃr\r1\\¹%Ë—$×$öGíbß?¿VÙÛæåË› ñçn\\’I’åË“ãù‰Û3¶<\röòääN»|Ôiðvë±áöòç²N™gO‘åÙgÁßaÒû#àìÌíÒGÊ|\r»f“ày÷Ävx®¥È\'å².\\¹råÉ4Ï¾NÝvî†\rÙv’O’\\‚ÿ\0DhÚI:gÄÛ·Mó‡G°’IråÉ6Iw—br»¦tÏ®LíðÇG‰ä’EÎÜ¾á’L£NPÎ\\Œ»2m5È6Ë®Ï€h<.k—.N¹sEÉ$“IõAË(bÈ‰›“iaíËžˆ#ar—$ƒ\\¾9$k¹8ÉÍ7.ó(>™Ó´’ÇY®ì Œ`¹%ÍC¤ƒÃ¹ÉÆK’YcÙ.K?<âOªäLÍŽ™.\\¾Â1¹áÝ\\‚äøšåöÉ,‰³ûX}Yo²I-ÎÉ-òø`wÌþQ£I³f¹¦%ÖD²öÃéœ»i¹œ\\‚žß‹—$’æ¹à“§M›õ:b|ÉƒL\ZM|M\ZI\"O\0™.\\ÒYÿ\0\'NÆ.é–î‚4°Mß.Ý±a†–ì®ArMc	,þVyñ!Ó\'ÕsF»$2ùsÀa‹²è×.A$Í†3dòõ3™ò4Éõx\rÛ»åÏ»|PÃbÝÓaräArÊÿ\0QfÞ¦RÙ3ä:nA1ËžË%ÈÐÃ~.XÙDåg“,Ï™®AÉ\".Ü×úß|¹²yc`\\îˆ²³—“•“dÌÏ˜hÒÄÆ˜óìHÐØ0EË¿TYýæ[&YeŸ »bì¾÷5bÄ¼ƒê±—·«ü¥™t³æ1ü®iÛvïôÁ†b?Þ«õKdÌ»|‚ÿ\0ZüNÓúF±c)aú¡²6oÕdò[³·Äˆ»»gÅ7Û·wÛ±®Ä6.†rœ¬¬™»$û]»®ÝÒö|t‹ì7e³l™§˜Ã75Ù»>}öI‚ä1”K-›,ø¾A‚ørwÏ¾Á¶?Ž–Å‰e™“lû†îRÿ\0DÛÇIË,²iÓ>EÏ`ñï›£ÀÓ3$šKº|H<âðî»íwfû²™.ÓÄƒ}ŸéÏÅ’eßgÀ\"<¹sÇ¾Ç.yš³$šI\'ÀŒ2Ãwúá“\\œo†q×&åË›ú$—4\".As·ÁN…–XYl5Í/ôåÈ5È/†ç.Ac|Á|…êãË/¾Íò\'DŸÑ—5È ‚ä‡c ¹rq½l~›?ååÍ%Í÷Ý6C\\¾.l\"4i¿SòÂ}žmöŸ\Z5ÍbA\Zæ›·êòú|›·ni»-ßeuß°caræ± ç‡e–ýO©Ú»>®]»åÛ·tÇ†9X:Äð,t¦×õ>[<²Ë.·t{	£C\rØv»íØnÝ»¬3‡¸Æ‚ ˆ$¹%žxaŠ·¯ëüy?òNÁ:=†4k±¥ðuÝ÷]°õ¹òlsÅˆ>ú¸aÞ·ê?S–ypûD<»£k²Ý†äáÛ·c]ñíÛ·nÝ»¼}\\±ÕrÇõ8±êâÆxØÏ÷q?7ïzgæÏõ¾–?›Ôÿ\0Ðÿ\0—©ëz™åßÇáÛ¾a8}3ò×5ØnÝÑ>.†gC—âýÌË÷²¿Ô3êúŸöýÌßÌ½×gÜ/IåŸ«gž»ãßó\"f<‰¹rc]»vXŸÊø²e¾óçÛ²ý§Ät0éß.KwC/ƒîsžÑ¤ÛÈie»®Ãäi‰ð’Ýö±dî7.\\Ó\Z5Û·t\\–ì°è ˜¹õ\\ß4ÅÜ}ÎÃ·LxòäŒq—tØÄl5ø–\"æ:eŸtgLètè×eÓ®vk¼»¢eØÝ¿2Ý÷ºcfˆ™Óc7 ¿nM/.ö&åÉy/¾DÎ˜Ù²ftDF¿Õ—ÛFˆ™ßÿÄ\0*\0\0\0\0\0\0\0 !01@PAQ\"`#2aÿÚ\0\0?H£ãén¢Q^Æâò¢P‘´Úm6›JÊìËx~O&}dc\\˜¹´8#X¢Q\'§ÙHŒmšPÙ\n+Õ³q|#oA.¸¢Š+\rm+Q\\eã2FÞ¥u²r²è†¯ar¬´8Ž#ÃDôÇ\ZçGÅÒë¸¢Š+Ó²ø$4(‘X®[M¦ÒŠ(¢±FÒ°øE‘®ë§÷ÃFwÚ¢Š+4PÐà8á¢P²Qån8mŠ(¯NËÊE\n8¬.Õvhq6Ž#ÄSUÜß\r/ýp¢²»4VI@h¡ÄžŸ‡§r²½6Xø/r†‰DÚK¤$QCÆŒ]‰rbîQD 8Œhœ«?Onšÿ\0ï¢¤1Ä¢\\bóeúMN=¦JÖ-#NØ]Ê(¡Ä”F†‰Àq¬WrÆx/ÎY\'ÆË,²ÍÆâË,²Ë/Ñ¡”I‰{M×ßo\r€ÑD¡d£Y¾Õ–y\Z¬î£z\'2ïÂËÅ–&X™e–Y~“(’\Z\"¶¢r¶Eð±Ìò%ØœKhû$øQC%QÄ£dä‘ö¯ìÞ„ÿ\0úob’y²ÍÃã(–Ndµhû,†,²ËÍ–Ye‰–Y¸L¿Q”jKøÍ–XÞÊK§Äêˆê¿å	§š\Z\ZGjJÊÄd)ˆÜÍÜhLT43Pl™bãe–Ye–Ybe–\'‹ôÙ,2˜‘ã5ÂÅËs\Z\Z6Ðµ?²ÓÅPÑ()gk#eãsB•á†°˜É%ˆ<YeâË,²ò˜™xL²Åé2Hy¡ö)yY¬nËCCÂ‰YX¡ÄK)ð²F ð‹,²Ë,¼Ye–^,±a	—éH™»‹ã<åŠå±¬,ÑÔ\\÷ÍÈlÜj—ÚXBÂ½)\Z¤|‘ÂD‘´®óÍá•Åp¬F„\"—+7‡\"Ë/;í¡aazR5´ˆ–EAs}èa…–Xän7‡#x¥‡è,,¯RCCB\\¶”m*½ðPbƒ#Æãxõ\ræñÌû°Þn7…3w}BõÚ(ÚQY¡\"ŠÃ+¿Œ˜Øæ‡1Ìz§Ü}§Ø}‡Úo7Y}ä„…„/Ã}èùà‘Y”‰Ìz„¦=QÌoÂÍìŽ ¦)ÝK_x~šÃc‘)‘)’Ô/·¸Œ‹,¾ÒBÊ½fñfãrª>ãî>Ãv/Ñ\rÃc‘¨ÉÈ”»êB™bì.+Ñ²ËÅŽCÕ%¯CùD¾Hõ[>Ãî#¬GXŒÄýñ“$ÍI—4Q´®i‰ˆmazw†Mšš¤µXæÙfãq»BD&)‘‘¸ÜnîÇ…“&ÍF>k†Ñ®ið/ÂœMh2}$&BDX»ñàÉ²lÔy“æ±´”GÊ$<!wl²ý6N¾‡’Qk³¦È‹—Î<$M“$û}†”ã\"q5@nóe–YeâûwÁ¢p5ôIÁ®)ˆ£OÉr‘««´_$_ ZÈÞ‹ÊË2e“ì<GÉ¹´O”@ms²Ëîßj@ÕÑ\'\n6›cˆ®¤yËÁòFnbÕ‘G\\Z¨LBÄ‰2lgðMó\\\"\"~8Å\"»kØ²ðÑ8\ZÚ&–š?J0ëçéGOY¨á\"Es‘ò0ó¹Ôvi1Ä‰/üöâo%&ò‘´ŒÇ·beú—Í£Rÿ\0	#þ~Œavkêý“oûÎ‘ä|žQòi?d3$ICP—žÚ|bEˆ—uzö_	#[LÔ\\4Ý29Èù%ñ“Iô\"Í<ëH²>\r_¼÷âˆÄŒD»ËÝÔ]‘øîÄ.R>IEQ¦Í9\ZX”Yu7\ZoüMb^{ÑD (‰wÐ½¤ðÍx]“Tò…Éø5â8Ó>²p\ZÄ\r7ÔÑÄÙ¨Y¥.†¡/=Ä…CJˆÄ¯E{HXÔ‰¯£Yøþp§ÔCC,²É«62d–\"iš‘¨3I’5#ÛŒ#¤-1GÓ^ÚÃ5 jC?Îÿ\0Íš.ðàEEæ±2O\"†u\"M	Ó7&‰¡ùì(²\Z,†¢W¨½íHšÑ%ƒ}}OŽÅ‰«%¦—MáÔÐÅŒ”%£ý\n2C²P>¶}r61iÉŸC#ñÅ¢ˆé¡D¯Y{ÌÖ¨¨ÓŽéèyÔhGÆBÃDâ5–‰“á§ÿ\0£CÆ,²óµ°úÏ­Z6›JöWº±8Y­¡fžŽßà•ŸTäÈ|y\Zq¬,Hš+3F§\r?ý\Z?Ç\n(Km6•ê?ÆB(zhúÑõ#êFÃn\\‡,Q´¢hÔ^\Z^M,X„%í?Ç:6ŽˆÖ7Ë«K:^M<!^ÃÃÂìYeûqìÐâ8±›s8š‹Oˆ½–>•–X˜Ÿµvš\Z$K35	cãñ„/jH—ÊË7\nBb}—Ú²ËÊ .Ý‰8á\r\Z±\'ŽC	ÚdÐ×fË7\nDfFB}‡Ù²Ë/(ˆ»²‰(gU‰´øñ\"?u¢Q\Zçcc‘fâ3!22ô[,±f$EÝ‘\"Š\'Q]MIô÷œGÀk‹cceá24äE÷äÉL²Ä!DEÝd³\"qÆ–&ýê6Ž$ 8JÃøFFœˆH]ÖÉÈr„$E¼Æ5‰CèÈë%ü‹Yfëü\nGÀpG¡¢¸BFœˆ¾OœÙ9a‰EawØñ#T™f›!/Á¢‡Àp%Àq\Z+(ÑdÅòf¤‡„ˆ¢1\"……ÞcÆj#RÖF5ø”Pâ8(ˆâ5\"âù3PÚ(Š$bE^ƒÆ2H”M¿E‰(“‰(Q¦@\\_)Ú(Š\"DW¤Æ1¢‰\"H—ä´J$¢J#CEDÅò‘FÑ!BôŸ	\Zü¦I‰(bEÛeP…é¾$†?Êhq%H¢$EÛyX^£àÉ1ð¯²É¢k»+Šö¤Iõ³êü¹XB»‚´ø_å²CÂÂì.1ö,r%¨=Qëc-þ[$5…„.k‚ªÇ†M“–bmükäÆVV_ÁzÌe›%˜óZæø¬¡{,œ,ž”†šÄù¬k+¶…ë1áÈzˆÜ˜ÑõÄúŠœûÈ^³(\'üTEþ•«öÐ…ë<¼8Ùõÿ\0ôzrþÏ¯Sû#§>Õþ\nô¬ó±Z6D¨—è´oüµÞBÊõ˜Ù¼ÞnÅ# âl_–»K‚²ÉM¦ä‡¨o‘¾GÚÏ¹ñ¯Î|—´ÆÇ1Éþªàù.7ê¶1Ä¦Wê.‚ì\'é±ŽGØ²\'ÙôÏúú¿³þ¯ìÿ\0§ó×…î1’(–™µð²ÿ\0ApxBí/E’c™ö#qÐqCˆð¤_ç¡eâ<×ªÍBLlÞÑqI<RcÒD¢×è®ÊÊõY¨ÉÈr/“«´O²/ùÆÕú²½vNdäH|þÆ…òóúëÙf¡!Œ¢¹?ôöÇ!“Ó²Qk²×úsd¤=CycJDôë—û+×l›Øµ\Z#4ñ-4ÉA¬ßí,®Òì¶61Ä”qd5±4ÆOCú%¿ŒYª²²»K°ØØÙ»\r†w4G_û“SSBüN>p¿]e^,¾+•–^‹Äâ<îhŽ»þE4ÉF2òOA¯]e&_u±²ËËE—‰À|-¢#û“6\'ü~5—‹,¿Y•—†<nÇƒÉàÝ‰Àj²ð¤×ƒKVÿ\0&ýEÁYyxLòx<•BÄà5\\þ‚ˆâÇÂó»>J¬Îƒ\"/ôDˆÆYcåeög£iD?ÐQ#$ø1ðeŠ\\/Œã˜/ô@‰$J,§–>jEá—Á¡¡÷×´»€†Ç&ofåýâR\Z6ð’Ê\"Ê\ZÊÃˆ F€ý•ØD1!ñ²ËË(¬©b²ŠÇô#¦¨ÔI?A\Zxù>~qEa<V„E_–°ˆ§´’ëè\"c\'ÁPˆ¡^³í>ÊÂî‡èB\"Çé\'¥Â¥»ƒí>ÚÄ<Þ±u ±c}È’\\âÄP°…•ßp6•†>Í´°¸®æœpÆ?E®\ZRà…ëP×bŠ%Evá¢U‹ôŸ¾¢}2¸^Waq|(q(¢¸QE‰]õØ¼EYÖ_\'Ü¡ðD$øYbÂîÖh¢†Š+QYÚJzñ‚^QC‰5„!jOG+½Ep¢Š(¢Š(¬m%¤J\rz°Ór!\r¾QE\r\Z‘$Y	›‰¼,Ä²ÅèÑE\n(¢ŠÍeéY?Ž=6¬®õ\n\ršûKÒ¢Š(¢Š(q\'¤N\"37aebÄX²¸®Íe£i´¡”xà‘´ú“>üRZ\r[6²Š+Qµ›õKú#ñdGã%äPŒ|w¨¢Š(¡\"Š(¢¸4j¬!ÓÃÂÊx\\SçEQEŠ6\r˜¬¬Ðôâ}(ÿ\0ŽÇ?ãã£èBÑ‚>”-8¯à¤XÙ¸¾åQE$Q]‰\ZÏ	<,7”Å•‹,±1>í1C(®»fáá›Ýš(¢±Ew«ê#¦%†,>‚e–Ye‰‰‰ú‘íÞ,±±Lo‚,\\+4Q^†Ób6Ð‘XX|/	›‹ÅŠFò/…Q]È–\'oƒx¼n7‡!²ð¤3qbx\\ëÐ¢ŠVU3È¹¬Ye—„ËÅ–)žh¢Š(¬2¸¼Jtn4ÍÅˆþx9QeŒO…’¤&YeúµÁ¬®‚ÃôlŒè„ÄÄ,QEbFÓhÖl”‡5fýÌNÈ2LL‹ã1cøã69‘‘ÂbWrËìQà}W5ßƒ¢3\"ÅÅ”QC‰(’c‘)\Z’±é˜eâH¢±BFÂHÔcò&FFóy!ev¬²Ë#ÎÇÔºì>ë‘»!3NDd.*%fHÔ\'1Ì²x¼E›ÍæìP¢l6\r†ÓWÁ«.£ÅŠBf…ÂËçfáÈÜ&C•žK¡Ô—%‡Üy„9šr\"ø.3Y\Zžsd3e“‘¼Ó6‰\n&ÓiC>KèÉÏ©cÂfš³N¸·ÊË‡!È²(ƒãcö±µ$=G§/UâÈHÓ™		åqfº5RXBÃ,²^hÇ4\"³9+PoÆòˆG¡·XÙe–^,±³på„úêP¥BÍèŸƒî¦M©#ïpf¦¤u!ê±â,Ó‘§111sÕF¤:š‹òG„Q§ˆ•Âs5õM]MÌ‘byøÑ}.…E›‡3q¸²ËÆãqdz³ë!73Lhû6±MI\Z­Å‘×LÕ_ÈµÜMF¦)¸?Yá4˜¦E‹œÍXšØ‚ <KÈ±,‰Ù)šº¦´÷c£§fŽ‘‰#S£7ÍçØo,rÍÅâ„š!Õ…bÈêY¨±ÁŸr™¨œz‘×þ¬¯ªÚdéúKƒÌ¼ƒ .r5¼3[ÈˆŒ1b$H²2èn‡2z½\ry¼N8šÆ„w3GH„8|¤9Ï°ûË|4â=%BN\"dá¸•ÄZÆ¢ÜKt\rE4jÂ¶‰õ-úK‰&D„ˆ2\"å#]t5¿ô$,GÁ<Ã©D1Cì>Âs>Â}QážF¨~|Fhx\\~D.$´Xô¤I3©¤.0aÅ5‰ÅI\Z°qd5+É-548½6}é¢o¯¨¸Å\rÖiÈ‹#ÉšªÍm#h±Ôšè,EÔ„Š¬>†ìJyÔòE“ñ‰\ZRÛ#ãkZDeÂ~©ÑF¦‘õ…qŒ\r8‰e’E’‚‘©¡D56Ÿ\"Q”Kõ¸ø%”Í)šr#…ÆHÕ(õà£\"KÉ¥+D‰.…Ó<¡ù.ƒêPÙ,3ãk4Í[Byx”‘ªùF$ %ÊäÑòhs~Òøi¾¦“\"!qfª&²È“4ðÅàÔòi2bòj/ñb%ãÃ“ãÍô4^!²rcã]_õ$MF×/ÿÄ\0#\0\0\0\0\0 !1A0@QaqP‘ÿÚ\0\0?!’{dôX ²Ë ²Îe–YÜîñxnÙ¼‹ë‘>Üjc™ „Ye–Y$d„( Æ$–Ée–Y$/›,’I$µ´œà“6¿RDþ&\0X@Ä,‚Ë,²É9–YÜñ3Ú/{-ácï‰Á¤&xž‘™!z#ÓdKòÓim·¦=Ùe–Y\'«Ò,’I$I\'MÈ2p&o16Hÿ\0È ,²,²Ë,Û,æIÕ±“_¼\rxûxæYê=àâ{²Nby;˜âKÜ’gÝèBÿ\0©‘cKàæY$ÈÉî\'ƒ$“6R\0Y³Ýâ\0úÀàAe–YÌé&÷d–LÁwžËÚ/fâ\"–YgdYà‡ƒ#œoÂÖY²a,àz‚N¹\'»ã‰6I$’LbZì²ù>žíÿ\0D,‚,²Ë<G$Øã1—¤¶û‹âÏ|>Ã0Ûm¶ÛØâIÏ^Y$ø\\=Oõ3ÒZÌ®\\âôps,™$’I$&3[(òÖ~¿í½˜ ²<Fû$ÛîÙm½CNZ8l‰[l6Ãm±Þ0Û\r¶ÿ\0Îa\'«i»2öXwx“|_—Ôs,’K$’IŒTIcÐÐ›€€È,‚Ë,²Ë&ÜB]^å°H>¥‘Ça¶‡pB‚ˆ]†xýþI>‘Ÿxrú½ÛòWÔ>ã¹%–Y¶ì’Y$“Ñ,ÐŠ»ˆ³Çe—8aÿ\0©`Äé) Í\r½G‡”ñ¨„Öa¶X{žLž?|{7þ/¶[þ©Y”px’Il_¾ÿ\0Íð¬’IŒl„À>Æp{_?¾ÈM¶ÍLûOa³`FÝ°ù9´/Šõã+cÇmˆñ=;GœÓ†má‹â“;¶ž¿þÉÍVÖßq\rîúîI%§­|õ/þÐý@þ¤’z\r¬™&‡¼		öÿ\0¤È?ÞÝ›=ÀËÛ/²Võ·?¨Ë?VÛ\r¾\0¹˜r\'§‚z¡õa†aˆð|^	dŠì=FR-‘÷\'Èmõfâ’¸?é~iˆ|LcÀÇÉÿ\0xí,ˆÄ÷ÂŒ¦Í»¤g¤}G[?oE¼—‡‰ËmèxŠm†‡›üž¦õ#Ûg¨ÁÄea÷|ø¤ Ÿk$›˜ú€ý’N€ƒgä\"¤“Ü¥ÙŸ\\¨GßG#£S7Ä1¡—\"0Ä0ø>Éã|3Èö‡Ô|’Éûæ¼V;^FI™d’IîZI$8Œ `ÿ\0Ø\ríg©NVðC\'Õ¶¢¶Ûm¼}Êp2—DCü<.[òU±/©åx!Ìð>¬!ÂI$—Ý’I0o_Ð·-8ü›pïž¬{ÎËorM¶ðbm¶Ûl6Ã_Ž¼†!†?“ÆvÄfp=GdÈO¿,öG—Å’I$’Iì’I8ýäOÔ±ŸwÆÙ­nÿ\0Ü¾q-ÂÊ$fy¶Å¶øí°ßQò0YÁÃDGòxÖör8ÉêÍ¾\'™•êßå–I$’I%ìY$’d ·9NÉäÖIØŸY§ýXÙe–^òrADC6ž$ñàÏ®Ç¶}:þ¬õVLu/Ù™$’I/»$’0YÇäAÿ\0K?Ù2&î&V)¾»ý3¤ ÷AAYÃlY$–Id–Y6{‚Ë·™2Ï\'ï&fKÓ„“«/—¦ÂõX®WöÕŸ¼m¶¶Ï\04ãmòÈàA{ „„Ax–Ãm°Û3Ä™\'Çp–YxIes$ã3$Ù1òI9[)¦/gÙ‚ØÛl½Ûm¶ÃlÄ!<r8Ž‚\"å¼mã2ñÝxD”fOû½ äj¤³Åë3$óâÉ-Î¿wQmîñ<vØqµ8i™dAGÞiil1Ež<¢?`odúÓ˜žÞ;ðeœÛg¬ñžÒKy‡?¥¤Ùâ8b‰æÛXqSØèA÷ƒ‚!†<vÛ|F›;+tüÌrêÞoûóÖq‰w„¼Þ~uãÇ‰Æ)oK-lÛ0¿<„›3&xC>\\È,æÄDC0ÃðÛe¶Ømâ[^ËÖ¦ßK7¨¶,³»/6ß®ìý^Žk°l^É|‚}-H§H‹Ùä#Àb\"\"0Ûo7ÃmàÃm¼µ§Ä¯³¹Â!ž|Œ[Ì’IÒß®¤¸7Üƒ,‰}ùä‚2Ø^Û8GÜb\";¶Ä1Ø„!M‰¶Ûm¶óm† –—«BÜ…ßR¿òË8pöžcQÕ²ö}‰ý™{[Ï¸ùÅêr–¼<-\r¶8õâOHöPõ\'ÑõèÛà[(m†aˆ.ß¶Ûm† ÃÁ¶¥ö´Â[þrgÅëÇÔwm·¡XF~ßîaÿ\0sÿ\0me{œ]fN%òVúŸ¼1õzñ–Y{!êôxí¼Ûm•¼\"a†Øa¶Þm¶ñm†Øbh[—»Ô~™ûÉSÝò³žŒPÔå–YÇŸ¿cdÀþÞ«gIt¶nJïH¼Ä¾N&ÃiÝÈ=ym¶ÛÐMŽ0Ãl0Ãm¶Ûm³lA†açªÞJ?ìè½óå­þž­r’Ó«,sâú–Yëõ½|O×|½–a?n¼ÓË]—ƒï¤,ðm¶ÛÁ”1÷…°ÃlC\r¶Ûm¶Ìðaba¾Ú—ªÉîØ·´²Ÿ“Í¶ø¿r­mmçÂõ¯a>|!	Ô6úÏ§ô×jø\0[/wÀG‰l0Ú[,6Ë,m°Û0ÃÍÕ‚Ì¼vã/Rúž—Ï*ØoN}YÞÙèsÝq¬^¸m¶øx–·§ž?Å€yx°ÃoÁ†Þ8Ž‡ä>ì¤ž¦ýæÛš7³‚3äv/|ÑÏLýÏµ¥:G&YÜóÖuöp1Ü³Å{½¾\"?žËl6ó|FÙJÛaäC„áa™izí¢I½Hl™ßÝøçÄ[îÍËØ½ŸÍ×ò\"ôA“æÌ¾$GˆAå³l<Ø!”7±`²cÏh_ÿ\0BÍö	¦VÂÉ³&çúŽ_wãŽ6„£{èôV÷ÓÏ%þJúXþXF,?‹3âDpxYäÏ‰c\r¶ƒ`7Õû`/ü/yê8Þ¨LïÍêcîÎ?ÉÚÞó~ÓòÓòyŸó¿\Z\'o±¿!þp&E¶Øá8<,æyžð†Û&dôŸ­ï\'®NÙ¶ƒ}à=F~Ù$\'Ë‹è0ü\'ý·åˆÿ\0T˜å–YüÙá\"#‚8G‹dÏ2Îç2Pr*ù<z\'Uµ{³ÇÙK\"ÑŸh›Õ?|	!>zÎÃ&ëƒ6Yþòz#§aˆˆòÎ\'ð:YäåÅ+ùù9ør™ntœdØ›¹esÜYò_ÞG\0ƒ¹ÆÏ_Ï&z<†aˆ4Ÿ²?Ádp,á×&˜•ð¾ö­ƒ}„‰–Yë†VÊ>wa†„ Ã\r¾iÓÀóØo¸ð>w&z¢—òuœXlë“ê+Ù‡£†ã,	sx0Ä)Ú6ø–OòÛm·‡?Šzµæ1è‡¨ç~ÉõØðþaIz œa•¶Û\r¾jÁ†êÞlÇ–Û/wÅñày3Åè“!¶åŽÃÝû—ÏAâÈqöIÁ¶Øm–cøáŒpál¹¾[1­!mïáòH˜¬É´Ù7Œ0—¨ þ+ÆßâGœK×ÝLæÛ\r³Ó9Žog†81,¿Áy¼”1põ_Ñ„=MO/u¤ø·Õ—øCÄˆðKNYNtmð	VÙð^#\r¶Û,¶Ûâ¶7²÷b.»ÝÇÄÐÂN¶‹7Ä&Z–ŠpˆîL|I=8¥)î‰ú†m¶y¾9¶öZOÁ½œŸ?´úäõ{ŸKïFžCmæÛþÂË8ß–|Ix±8>ìžaÃÖPÛàØ^ÛgÈ{}óaéüLõhÛïÜûMaç¶ÿ\0\"ýðˆŽÉ‰µðwÝ\'6<mñ—ÉCe1\\°k=íé˜/®ž\'òêÖÞVÙ!ðÛy¶ÛýHb\"a‡Ã8y4òÜR	üŸ¢PÃÇ‚\"8ý^Í¥½þÿ\0\rZÚÎlðß/~{o‘Øa†m‡Á”Sh¶9ÐqÖ!E{¸Àó^ÉåÎ\\?¡üöm¶Xm†|À&ðßÊø¾\"<Dpm÷`¸Âìß©™ù)Þû2=·Àî÷x[à0Ãl0Û0ÃXzñóÏpçæ#ŒÄDwõà>á×e”ÌõÙæøŽÛ6Û0Ã0ÃÔñoi¾/˜Ž3Ãd‚A<²Îo6Ûe”²ÍëÁÊ_7Ã÷»/6·ƒÃl0Äa†¤$âqŸ¼#§ ‚îÌÌÂ\\—·ïm¶ÛmóÛ|¶Þì6Û\r°Û0Ã0ÛÄ…¤¾zg„tÙú‚ˆ,þ/Ï6d’I’“6ÖÞï–ËožÛo†óa¶m†a†ÛfùŒ=Áï“ƒŒð‚\"?¦x2Ë\" ˆŒâ¤·ø\'ð8Gm†Øa†mã|C†rxÄD,’B#ü\'ç\nVV–ÞM”6Å¶ðaˆa†&Ã\r²zŒ&}àð²È!Géü^Yûžÿ\0”Cá±Ãl6Ã>¡¶M½RA<A<èü™˜C?=ì³ø\Zÿ\0”wy¾á†aŽ\rãpqàAÃì=B#ŸŸÇÙø7ØÂSòôøÙxïøÇ‰0Ãs!%‘LGƒa?Ç_J:Ø|Qÿ\0và-¶Ão†Ûþøm¾l>á†âIdAÆƒ„FŽÃýÌÙH¾¯ý,^•ÿ\0eúöÛe·Ãmãm¶Û®ÄCÍàÛl_±Êx’Y`ŽlA¾£¹Â<ø³ó†I^iÈþ1ùÏúŸÓ®Ûlsa¶Ûañ!¶PÇRÈ:xŒÁä³¬ñ›¨†P‰žyà}þ[m¶óa‡¤Cl¡†%œgï€„`ˆç–t<ß—Ì6ÖÙýã_Éÿ\0e‡ïùs,³Œ²ÏáŸâl=!áö!†8ž„àF:Duùü3Çm–~rG7x$–s,ñßþÇØa†WçU°ÄG6ÛaãóÀæAüW—¼íÿ\0)E¼dƒÃmÿ\08þ0Ã(xôGC\r¶ÃÀméýYÊÏ·©îßýtíoýqe·ü£øì[e?/¾‚80Ã\r±¸ð?ª”½Î¾ßè›exÕ¶ù¯ðýÿ\0<vÛa‡›¡¶Þw¡òýŽ›Â?€|7»ÇŒ,ÞmS§V‰²ƒå¶ÛþYæpðÛaðJŽA†Ø|‡Ïeáz¶Ù!Ÿbý¾g²QÆÔò|5ÿ\0/mèÃm±(m›ö=Cî|Á†m†\r‡Åû,ãÆözäêØ/Øÿ\0oÝ|„YOÏÿ\0€¼#„pqoÞb:taîÃo^,›måï—ƒÛ‘úü#<2Ë,ÿ\0m¶_âDGV9ûÁÃ¥‘Äc‹,ýqõÀïY$—¯2Ë$²Ë\'Ç?Á-¶Ùxsxpˆˆ‡±\"#‡Ž1¶Ùl/Ttƒãíô&Î„|’O,²ÈÛm·™üˆêóaˆŽt‹xGñÙ|\0Ë{_rÕ§Éûm¶ðÍ›<Vßá–YgöÞždpb\"Ùmá¢Øˆbm†\"<7Åyz\'“õ1Ëçý—ÿ\0“¶ð6ø-¶Ûþ;â¤se¶ØàÏÝ¶Êñ#Å¼Þï…6\'$õù)ê|È	Œ¿»éÅà‡_á–YãŸÍþ§H†[mâ¶vÖQ6Ç}[(|·¿‰«í¥”™,#ÓÁóØÜ>Þ¬¶gm¯øyg–ÿ\0R:Cl³á¶ÎÖÙD&ðA†ß\\VÃÝ˜ÔË±dIoi·6ôâÇÈÇõôÂ`½Ï¹jß<ÿ\0|Nm¶óa†Ûm†â½[l£€›0ÃÃ›m²ôZnIûi`dû¶ùð£Ê¦|ÐþÞ¼ž6Ûm¶Ûm½:mñ:=a†Øa” ƒ»1ª_p·\"&“®ÀÞá«ìŠ[zoÚøß¾!aç–êÛl¶Ûl6Ûm¥¶ÛÆÛ0Þí·Àñ-†PÛ¥|qŸ²Ê}ùRûãÍ\"­é/Soï¡yí`øŸÇ?‹ä¶Ûo6Ûm¶-¶XbbÞlGNoa¶ë‰™eŸm³r\'¸Ôû,Æ=&v[Ä†<XÞçBðVÛy²Û,¶Û¶Ûm¶Ã/a†!Žl1â6óy¶ÃËÉz¾\'1ŠYm·Ž\"dKû¾0Û{7ò÷ñ«Yþàø/_õÍ·ƒ\r¼ˆ¶zCäq{àú›—²ÙŸ3«Ñnñˆû·/ÉöeƒÀßìgƒ%^³3÷§Û|#ÀŽï–øý_Íé´ü¿áÑì›>›S€ ŒE†ûo8Æ?àe’Yá“=xðÏ‘÷ÀˆéÂ|6^—Ýñ|Þ»Ø½¦©_Þ.,’ÝdËÝ©:œ‡ŠHI-‡üI$³Œñ$’È8~ùÛÂ#¡ÍˆŽ6A~áê=õ}ñy²åó±\r8fBÛi9x^ÑïmÌb?¶Yd’Y$Ï›\"gø‘ÃäÄÂÞÂ#„E¼²Ëû„üƒw‹l¾\r·ƒÆ8Ï|g|~|²I$’d²K9œI?Ï‰†·íLvpéDYz»^§)eã;îY|ï9‘{rb>ïeêOÜáþ™e–Y$’I	že–Ydþ_½X’×ß‚DDÍ´`x%ž1\'ˆi=v\0<™àù?s!†?†s,²ÇˆÜ¾Ù$$’Ë;–Y	ó#ÔÀ}ï›î#ìs,ˆð!—{¬	YáYñü’Ë,ãÛêK:0Ù·¹0qN€;Ye“,`˜„–s,²Ë\'Òãù9ñÏ¨v|GàõcÛ~ñ™|tYXã÷›>ÂN„6ž¦)CaÂØc¡Y–Y$’Y<‰eË:z\'Ì†ÛëÀta¶\"Þ2lÜ}x¬ÌOÏ,²;–C×FÎoà0ò1ÖAY,æCÕ’I7Ù=Ye7Ã„}ƒÀæÚ†U	™á$âsâË,²Ë,²Ë,àú›c‡!2Äˆ‹ÐŽ(áÂÈ æYdúÉg,w{g†prË\'v’Ë8DG‹,‚#ÌÆÿ\0Þ2Ï“ežež\'è°m•žL–GÞþLö‹ggB$Ÿn2I%ÏAØñÎ]tâ\'ˆ‚ ²È<z^¬_öÖÙgøg2Ë ‚;>ž#ÍíâÍ †K}Špj~¡‡Ô0Ät ë%’O·ýIÏ“Nj’\rŒÁdWÙêühÿ\0EèÁÃÌ±æDøìß˜,VY$ó:÷,²Ë,ˆS™N¥¿rI2u}Œ¹,6šýÄPú†PÃ=Y\'2L½¬É7 7´€ƒa!}Ì³m-b|í7Î6üõZ|„ˆ=œà^„óm¶K,’K,³È	ØpË$\"ÆO|¿kä¶=Ã%ËeÁð2÷0ÃÀc©êÏ|<yïOV™7Ý_­öÎÏV[Éwå™¤??Ä÷k13ü\'=_Ûæ–6D:¡	–Yãñ}ff÷ØÂØÛhðx;aœ1tãsË,½ç\"lÁêöxÜ Ë}Ã×NNí¹0ö÷Âò\"öÑèYe–t8g Žg2y·±*Û½OÈ\'±‰gF^ãä0ò8œŠûÇH²ËÝ–Ye–q=Ê»6Yd»\ry±ÑâÛîß\\lÇ—óx.Í²ˆ£Á–pxæÍ“¹‡KbÙo»Ð™x}ÛÀø©¼aäC™–qŸvOR[Ó¤-†ÂßSß„É-Í#~§íþÉL9ƒ‡2È™âDx¬¼=£ˆÉU˜‡¸–|=IcH=¹–¶ñò#ÅíL½žH,¾m÷Í÷¾\'_©v²û—Õ²6Gµó{2}3ïŽogÛßÌ„ Äp ãâxm²ð6#FA%¬a~K±öü–ba†ÞúÙ-³¨AÁÁ85Òž	Šµ«lŒ&[™÷Œ¾¯Ìý[nÓíöÏRY^ëÛ|¢v|\'ÀîÛ#°‚8ñ\rõ‡ÛgƒÜ¶Û0ÃWÜnóío(÷w´w°½ÈóòÇÈå”]mõ(z[B1ÎYÛÙ|Yß–|HMyüCà[|¶c\Z{^Öu›/Ve—Àû½Û0Ä0ÃÏv/w\r§oS^”“Ý¸Þ–~­ úÚ6áa8cÖö³yõÀà¥Þ^¼%­¸ÅYo`çñÃm¶Ûmšð·{ãÁã‰1;ËÐ™ñlº1ö\"b-”–åƒcÀm·Xõ8¯´êä}½aû,>â5-oLOAÄä$mOn5Ý#\'éƒ\"xm¶Ãlø&›\Ze±‡y²Îd<&ØßÉŸ[|á0Û<1‡‰zèl}ñ0½»‡¸ÝŽ¥ó~ßÁl®Å<d…•ö¶a÷©\"¹½$ÈéÖt×•à_vS#„›O#LÑ“hÆqß–ˆûÇ§Ä†a†|\rážZ¬´àaðKq½˜ˆûÀúŸL=CîüæíèCâ=B[agûj^ŒB¾À¶øY›èœ7ÏAâŠæ1à>ž¯Bñ}^­pf ŒÅ¶ô’Æ3O¶·ÀóÛm†aëÇ¾W»/¶Öò†zÇN+Ü}°—ä}l;I1¾¬%|D¹Ñe¾äàt½8=•nYcYns>³ÿ\0Qý‹á{{H“œ^¾Ûq9iò,Ã’½QŽ2M—O¾OðØa†PÛÁ¸/n°vß%8bã}1ÊûÇÝø—»Ún0ÒyfÞŒ¬¯Røå…ìpØ;%ûÃÅÈ,28ü°ÌûØ;öÞRÙ[l{·û*%k\0ÿ\0°xŸK`Ò~†~Éî_aù#Øˆ¹¡ñiïòÇÑ}^ëÒKƒäG{½È{íî„9-ƒvI`œñ¹ddúÙ-.Gÿ\0ia1lŽ¨cÄòˆ,²Òå\'äêù—©d÷Ý‹&p\0–EŸ£ò®h²×ørÑŒú·Y^Ûlä¡ˆñïte…–Si÷&–	{#Ù=F¥ËoVBägûc³r;gÿ\0¨=«BvðÞÉè¾ó‡“ä¼Ím2Ä°ñûwÜLñ½&}™zÿ\0sÈâKÍå¡(e	K{ëa2ÉôØ!HgúKÝ¾¦„ƒoGieØFÅŒ-åÈ}OÝ¥’¿b^£Ê\":²Ée»‘®uÿ\0ˆˆçÄ¼²‘°è½DtÅÁ7Ç?<gÙ<o¥êÞÔäGÔLÙÁÿ\0Âû…ý®þ?û+’_÷6q½XðÆ#ŒÏ>²>›Ý\'ïÿÄ\0%\0\0\0!1 AQaq0‘¡Á±áÿÚ\0\0?×¯F7·‘?->·æUg¨ŽF ˆê¿b\"m¹_.æö\\ÝsMNÀÃ¦Læ#¬Ä·ümz}[§»ÑÙ&À_`ËnH‘	À×\'„ç‡O‡‚ž¾ÑÖí\nðÎwà2žÚºµßo.DŸ2„ÙÆwQÃQ3«4¨[B\rÂÙ^ËŠ8ÁÊtáÜH¾ív˜/âË}u(…Äó)üêwïf’\"{`½Ç>/ÁçˆÒƒ^ËA¾îX¸ÜqäCÀ»|íßÏVÒ2nœÓ.ïÉ—Ñ?œohðÀ(cÂR®nFíG”Ô/·í°´±ïjÈ.ØË{u¯˜5}[F3å,Ñ¥£Ô£ž÷¹}Ö¶ZvZÁº!|ž¸ŒO1íº‰;çÐæÐÃXÞ£\0ûi¢.ú\rÁ\ZZ11xZ‰¬p„É©ur¶Z0KÚZ_WdûÂ€<\\?62$\"‚vÁÖsÆjL\':Äm‹ Úïrã²Ó?Âü ­Ò•´þZ1lÏÔ’)Êð	ðiùøRL%è™>ìÛ«Ò6‘™Ãïî\r1à“!©â4z’´,/öI\\û¹íáÜBÑå\0„08u‚ðÔÑo…¿Ô/:¶úÖ7ÿ\07ê-··RõÌÀoF™¶\\öLañ×nî²o	0—Öäf³HOÂ!á¢0V£3.~áÔÍ×¨ýø=¸ðO#Ûc¬~°~±û¿«ö¿oÍ¦pø07ƒ~OPh¸H:\Z¸R»ê8Vïos2Gqd	1Éßû³N¥ÍÊ¿<=ßRFcA¡ÿ\00—liLÁ¨›ºdå÷ÞÛÿ\0VßQ\'l1\\ E+}Üwí›¶&›eýøüàáŒ–­o<áG˜¶âô—^9?/»ˆ‰ÃËc[œ3ƒm2wÃöÛ$,C3»ç®-ë›_»DØ˜‡LGÚÑü¿B{dþ%ÍzØË¹à»Ck÷#¨ý[}Ü}áýoÓõ¨×!¸ŸËDx5unÝË3ø÷p:™Ðû5•D]:½ošò—W®pÛ¸`d×€	hë‘:w{—3ãÚÛëîýcô×/×ùpÜ®‰‹“„ŸãÝ»ÉxÀaÿ\0ÃâÑîâc=)ÅÙä_\\òœ[´~ÉÁÛY\ZnS^\\f\\1Y]­²\0›½ø^U•³ÁeyÄ-¸gÿ\0Ô/üç¬&Ýs^.çKžÒëâ$àœÍÉÇasUß`»PB—ÿ\0=ù::™““^7#Åî÷6ÏGŸq<s?gr´ßQú´<7+”Y¡„öÞ¸·q{q|f)ˆWI®	«(~ívß#ß?Š·-å”8fsÎv½s9úwjÓÝÊkE¢­\"Ëp·ê.æöÛ è¹ßpÈû¾­~[ûÿ\0Ñp\\ÿ\0b·àï]ºä\"ºílé!n\\Käâ:\\£S\rõE¢Ä^÷$FêW\"TÓ†m~°„ë¾±5Â	úµûÕú\\­|¢=^-å3GŒÝCnf|´äµ.«¹–¤´E£ÿ\0¯:ø\Zñ˜Á¦Ýêä—ÚÙfÑ.™nopwTõ£À9§þ1³\0ì”ÒÝ¿åÝü“|öœAËd¥q4ŠS	çÇÓÑã\0²‰”±àW¯ç»RÐ\'¹³BâimFs·M¾×‹“§âáüÛjŸf¦úŸÓ´WêÛvŠájÁ¨&Wî=xZn^î{È\0¶å\ZÂy\'ï”V™SŸ©`R‰d“.>ãumBË‹pptÂµz´VË_òxuhà‘¸˜k;Œ@ÈðkEÇÇø†ÜPæ$«Z/KÔZúZqx>ñm¶Í¯y5mþ[qð¸á¹L„FÄ)ï\0Éy“qá\'â“´\rÃï–nAz®m–›-ØtZ7„r7³Ëë\Zn/‡ã	õ\'i §UºÕzŽ¾íŸxO‹w­Þ.Ì¬àQÄi8Kf#–u6ANRˆ–cˆ™œL>O:„GØ\r­ÝFýð[/òú\'Ã9þÇÔ3Ùhá´#E§QàbqþñûcûëäÛ&ÌãÙ>Ý¿1»xÀˆ’Ëª¹óÂA©x@&Ô`	·¶ï3ó\0KPS\n[R4ž¯Æ4”®àÀGÌ*•œf‘h`Cmî?ÿ\0ÛIyçbLët¹žØí¡ûiD=.S-ê€°hÿ\0>Jxœe(Á6¹FDá¸Ì`Ôï5Ü°p‰ë¨²\"c50Î\\ÁŸ°ÏRíûFh_D;‘îÞæáÖ\ZŒï¹F8õuá‹[g»íˆR`53ÍáäÊ09F$ð#Ô²àö?°óvÛæ\0NPÀ`€\r›f>!½±^á&™±dËâšge©O%¨ òb/\\#$Þt†*ÕhÞ¦œ/¦÷eÚ‹ãÞ±ƒØÝÙÞs{“\0&3\\Äpr®H»í¿›·œB¾òÞ8^1½[ˆFâµ»yƒì8OxƒÄC/IÎ\"o¨Â‰¼@™¶¼|Ý·TëÎå—FÏüËõ!ÒË¦Ûg{®ûÜ¦® ‘^îð˜GÌƒ€mkwŠÉ-™šœîƒ=ÓŒ2ÍênëÂSÈS–Ad–4¹x‡À£»·&ÜÛ;¹Ã«GlÀBêk@^#\0·ôÀÔµf,Æsà2sƒnànlfSEÔ\\¸cŒo¬0ÂÉkÄö?a²\rAd8ˆ³¿;>·nîÞ²qJm€Ê`Î`§f›E–Z”q·7á(Úãïx]JÁ¼ÌÍÌÁ&$l\\‹FæiŒ1Ò-‘ž$2¶Hð½2îÌ”¡EäxÞ±9K/£Äô¦ÖðÝ»s€È2‹]âä\nœöñ#qimòËEÀ&Ñ=bS	š¦µ¹~ïßœ2Ñ¾dÕvJÿ\0œ?J·¨cc_›Š[µ¥ê.½[“:aJVí®«ÒA©p#µf\r0jñ©?Ây¼O#ê4m¤©öG¥jÀþ®›F ‡†‡&ßÛW+è÷tÝk©›—˜µjwtÜÜfãîØ?\'ÆDÂ1º¶¸ú1ÏÜb]ZÍÕˆC¬Íà”d‰ýŒ»·àå”ð¢/¼ÒFÚ.þ¸ù\"ÿ\0fÀ<[M›Êôö[Õÿ\0uÌ½¸ô„`Ê|ðä/MÂºõ/üÈœcæ\\„ðéºî•êrçÀÜ²Úq=§.$;íîÕšopn-À‚\"Þ¢q`˜©x—™©´MÌap§‡£œFß‹’‹eÚ€½›1qR|Ó®ö Ôc¨AvÚ›þÇ•¶ã©v‘Q›ö]rÙj}°›VÝÛšO†ð®N8¦Ož£(î‡Ÿvqjõnn0‘ªËGˆ!áôÆÆ˜ÕÇÎw÷»dÕu9N·Bftñ÷Y;’¤‹L®\0Ú	´àåkW|ùqi2ÚçUlKtgzŠ¸šò?q¥ÿ\0hÂ·¼.Ñjƒz¶ê¬@ÆíätÄÅ»Vóƒ(ÈM¥“0±„\"–4ã\'…ûÁô4’Þõiý½§XÝÌ‘´ùßþ·2pNøá|í	´Fžw{Í¦þ\\‹ÿ\0§)á¼™rÞžëÑuZ}Z<HÂaŒF	JQàYÌËd`ÃýòîûýÛ.£©áÕÐþÚ_y²¢[w-ÿ\0q],Ï­ÃÑºwn–û›°îtîé.Dÿ\0¾9ÀÞFnVqkéqœ_<Ôñ…·âÄ\"%ƒ#y×ÞVóf¹=Ýè\'w\ZgãŒ>Y½Ã–Ù\Zs¥øÝ¹‹½_9œ›º[mäÚ»aR÷w,­A¨œ§[ÖÚ›¾¦\0a„Ô’NMÄÄc„A$DE»xÞAŠMà1ƒþ\nÙû¹ÈjWIj:“[{¾C¿ìœ‚5±?»q¨ú7z­ß=îE¾5MÖ²Ü2²å*Ám³uÅ¹ˆ|tÝk‹PºÎ-CŒ!uja,CD11ŒE­ÚÈk.£b)FmøÉw(ñt¿vÐž À×äæ‡Žµ½àw»ÔÜT½´¿yÞ¶áp»…Ë	×p?™ˆa™q9óÑÝ»­ì¹tY##z.·ÂúÚÊ51àáJQ‡‡\"D&¤™’ŒDJQj#¬™ÓvÏ«­ÃTxú-›Ñ·ë¹»}ßS~8­ûoJ7$\"8û†‹„n{þs&r-Â«OË­¡ïP\\ý^ïƒ7®®ï÷øVŸVˆŽ7‚gÎa‚gëF&¦$’L’C#òbc«Q-\'tuÓïm=º2‹=p\\w€\0Ù‡Ÿ±†\'û<ÃnB{¶Nôs+Ýõ*}1ñ/ƒt&£ã|¶„”CIq¯\rÛ—7nå7F.rˆFÖ5€„‘5‡“=bÙhuÌ¿¾àÂsöÕ‡Ÿ°÷ÓV›Fµ=Mq%¢ÜÑhƒPÜûjäŸ¶¶çøÐ×ð˜>Ú1ŒXr±;b4¯&ß†¼8x7“Ï©nXŽíe710%¨‚Qáð—X›&®î¯AºzÌ#Ö¢{m¼KØKœ# {‘ Ìá1ÿ\0ÆÞËÅ3P@’ø7ë\ZÈå™8%âx§+xÞS\0’‚!…ÁjIƒÄf?-˜´Ç6Ž¹…¾1D†Hm^™OE«nq\r\\®£9N“\Z’p¶åË‚Ô^7du?\080ÇðÅ»Â#-å7jœŒ-[Á-¹r—Â<l:_%·Âô—¹i=õÚv¾™ë›ßrB\"<w32Î\0Œƒ1=Ng¬Žðiÿ\0\0ãÈ6â!¼¦ÔFLÌò\\µñjÙ€Óûo¸½jß2·¸XÛÔf÷Wó»˜‘mË†<O]ü-¤ÏÃ$2.1wydÄ“œÛÁtÁ¢å›†#‰…ä7wqmµ³S)&übíµð“CqþN­xÎ¢<YfrÇg§·Sã)€dZýßFñï¶ëœšÔ2‰Ot¹q“]²Ý=Ü\'±ÐZÞCÉ$·Û¨ë=eÓœ.Æ4K¿«Gü´íDDxnÞ\rË\rÛ·H–&Ûnšö™VõŽg^ŒoÖýí³v­úÀ­âY-ÆÜcF/\\mQ·@¸1#ÆF\rêÙö]G¶ZÝÄ­j5ÃHÁ‚ÛÂË€œ,‘‹”F7Á;ø›Òô“Æ5xÉf=­Þé‡ví[ð‡„ÄpZ0va\n¶D+¢ÖHÆ§-ºÐ6¦m¦ñDxî#Ô.ÐkˆZ·ÞÜáe·‚\"\"Q9`e²Û¹_X´Ë%vŸ	Ü:÷%/øÊS1ÀÆí.fB÷Ûœƒ›ð!ñd†íêS…•Ün$.µ¥ f3vå—ˆˆˆ”ç7k3VH_Móa.jyŒ`q»ºÈ¡ÂÊ›zˆ‰j×·Eîä/™ë®è„#KfTGƒzðŽkjºÙ;òÁo·W»Æå·ŽW.	DaÀ¥)CÈfËðšoh-®Õ˜I{vòìÄ­Ë¿âÕkqí¸ËF­ˆC¨ŽHe–p#jæAµÍ£µgdÇ#¼>\ZŒ%J^ om·KÚÓËYjÅ¢æ1_Åéb¯Ycêæ.dAªtL&:Ž¡¸ÄG€àÃŸlÙv£s\"œxµnÞ;–Ü¸ÜÝ¸É9c\nPÇÈ17­¶è_PsÅøÝ·!N$ú”ò}Ï—Õ£Ë~œK_€ãˆËñXæ7Çû/Û›Ì›HÞîXÝ¹Î¦mÛ—‹4ÂBfxŒ›ý]œ]ÜBõ~xË£{£—XpDõlÉß¥ø\\c#âF78ç‰ê»-Ó«Rü†°é;\\ZÀ»Ã¥¼rÁp>åÇ¥²÷MòÓqÀ:Ô£—Qqò¨óâÂðàb`ñ\"Ý»s‡º3ŸpîÙéÁà1¬¨˜Kna†aÀÈˆˆ?ônðn·	©‹O‹]Àxç¾­‘×[šB0`2LÜa|QNs¾ïÈnðÌ-Îø¡—ŒÀ\'ë?†þ¤ÜI…V¬zF§˜Ê<iÆëÀ†GeñpÞ#l&­(\rî[`‚ð|¡—†YŒÞpx\0ð/ðÇÂåq9êÔËÄÎx‘¼:|!\rCxŒˆÁƒ¼ÀdÆ,BÆ|Ì&åÖ·†ÞB±¼Ë›ˆˆFoöà²Þ­x§œC;$#Õ£Â\rALa\"<K9çì˜ÿ\0alêéohÄ8Éâ¸Ü²ˆð0¡”¥–&åÏM¡”w6Ž2\rxAœ²z1éÔ#D`Œ<ŽLd»wsûqåÍªD^ðdË†g[·-¼Ž,	¼‚ÿ\0\0.dî»îkT`ŒJaˆÄG+êÄÁ˜7q·KC>º¶¹ã«ûŒˆÁn·n]ÌåÝ¸e¬·U	ãð3R×‡¦1ð˜oÂ„‚ôzð)Ì0a`Àê<Y.Ëÿ\0Î*&)Ó¦ß]³F=u\rjzˆñSÎsÔåœnßˆÃÊbn<€ánÖTÝ0ÜàÏkÈ\rA‹Ô`Œðfa)¶é×ÖÝ\\cx~Zõsùrïþséõ°[Ôù5,Û–q¿pD­à.¥(cˆd­n|:†æäLJVæ>ŒZÖ#$1’Ë3”ì‰ÝÃ…Òq†¸ïï7ÜãzÀÍïÒ6ÊæYmÛ†Ü>#wn!âa†!âß­ÚâÝkÀâHä\ZñÄC	u(¼2Ìçá€õ¯lÿ\0Œ¿Xéóp·ºˆµ†vÎâpÁŽaÁ‡nb–\rá¼x3v#k[Îš`âQ‰W<Z³Žà›”:âRÃ“qŒ‘mÂ¾Ûê]KBéZ¹º§páñ<â1—&R·„q<\\¢Måh™ÄŒm®\Z„rà–üÍÃÞVlïe#òž\r¬“SIkÀ`0áq¸†!MÆ@1,ÃÄpdpp„ÀÞ-!j…ÆZ‡xpÃn xšË‰EÛS`{O[™¸ëN¸;¬Žø8øI%©µkÖ°[Âùn†mÃCÖqx¼Jrœ[£ÔF+ÈÄAÀ,9›_\0I÷;·>Ö#µ†YŒøîFDDD8ˆ`æ3Àw8ÇRÖ°Ó7²Ü£2Ö\\2ãäm¶·Z÷5ì„!…¶Ó•œ.ò“æÿ\0™<DDDõäðzºÎq0¸Ï.CÆr\"\"#7M¯w\'‹ïÄ}.#K¶ÍýêÓ÷}“ô»Ê3vòáñ[èŒ‘ÃdG.3nXŒ>ìˆ±ž7‚\"r¸pÝÖ†ÚµÔ^v»9ë»—»O¸ÎÞÞÞíáðpÕ¬?àFHÄ<ðDG„»˜ïLDá3XX«qÌqoXFq63¢prµ47Úô¹ŸL½û´;MI“YÔåÒkFæ~	j2ùÈBÔ5†!€0Ãã¼_`C‘‹\\m„w6ónÝ¹Ã„»¹H}·zÈâÊyîë–Ð:•t(7¹Æœ,/ú›ðÉ\"%À›·’!çá¹<VåoÈ ¿¦\ràqÙà²ÀÒ0¹n¦VØ;YÚôZŽ¿ëv\'ÂI$œjÿ\0\rù#ƒüR”`å+xŽpYu/,‰àr·d¥Â¹fí‹kknŽ™íîÿ\0n¡ÖXá\')šðßøCƒ¥¶ÉÄ¼íÛ30už§ëbàˆðsçC¹sºvÃc²KfÖ,|Ãràù1ø°20ŒPÊrðÍÊb”b%8•¸BTò8â0í¸q»h­Dtu†rqïÜäÚÖÐ„ÌÏŽ¼˜Ãƒ;Œ˜’\"%™Ãoåúç1zFJ&÷)F—#\ZáÑhånùã2zAqÜðŽ¿X0¦÷–¢Ý²fæ|5¼xLÚÕ¬k-¨0Í¼7ò!Ä¥,††G, dT÷áœn×‡sÖ1=Ì›äºR_Ëáq¸„¢Û´»´Ýy±“ @D³ÛŸð0¼DDg\"h˜ÕÍÔC¸aœfPá‹vçL;e²..í–íS³jÒrŸcù\r§·i¯†ßìþú´ã¶{·û‹g†ò›ÀðÖ\ZÎ·jÖ[sÀà\"<ÄŒV\r3~YÍ,ÁÂ> pº¸HMµ­îÜîRF~gWSøæ¦\0åûkÑ–ûŒõp×ûéÃºc»~k“bdË†os#Çq‚ÀËÂ\n‡QIÁä#¦=¹\rà0–«O¹Þîdé=8Ÿä;¸–ÑwYh9O¶ñ¶ÔÛ»sA<\'§¿6·ÿ\0nLjÔ—Rág!ÂÌò˜Bp0[À?Ê\0¿¿Âan‹Fc©»wq²NiÝ¦\rD6\'ùâ\\ð£q?÷¶ƒOËn€^ÓÈ†ÖY-x8Öåad!\\ãÆ!‡nDƒ‚%»ŠÜ81Ýl´M¹šoTÈ`íá‹å?ÈÎ×¦GÄxB©Ýª°aÊMÛþ›ÒO @KLš™Î¤Õ¹Œ¸â:Å0ZW„!\nx|d†ð:ˆÁ×ÄËžÝÍJy~®Ø:Y®V¶÷jm¿[qì“Ù¬!¸Ž“¤IuqéhRA€„ƒ/œnÜ²Ë,Ë…ÂMëÜ×|äs¤xU&Õ…a½F«XPÄÞå‘1\\ÿ\0ño¬6OPæ¹O8õÄ™ªw’è6çŽÜz¹èbÖ±‡\'£>&5†gÃFYÀ|Â‹áfA¹x°(s9Þ`i›‰oÓ´àý-æmWlûL@DºpÜ2í¤Þ§	ð85æ£\ZÃ	ñ3‰m×rÇ„<€‰ÏÄaÂð\n\"!·(q–õ&&ØÅ<8[ÏE»”`Ü´K¸9[½u²€Zð“v¡Ž¦Sš¹\\#-Êq1ÀÃ†py‘)î‰¸aÜ0p¸C‚0ž4‘zÔÑÛ™¶gÞ:°ØD4÷uí»\"6Z8“K_R3Xtc~\ZŒ„[Y8MIœ±fí2Ê¼%‡ù¥Ö@a‰\\®÷=ÃÌ#Ñ\\À¿c›ÚŸ6®–ít3m9·j`ÕªpOˆñÖ!Á²âuz./—0md0`Æ±¬,7àXð“Ì­~`ž=ó9žMDR”D!2ð`I¼C‡òåKj$-Ü=Áé½öåhÝí¾YAqwqÎ \'ò[|·û¹êÕ¬Ž­ZÅŽ^ø\r!ÄŸ\"e‰‰O¯ìÒöc@†*%)JŽqˆÌqbÞü(±8+v¬T´-ÍŽ-Ã7x‡æ)8·`»”3¬˜Õ«PgYGÃc‰ÀbEšj ’#)æ–:&[vûˆ„J\"\0î.¦û­m|Þ°n$‹qhÜ6É·pžæšþ—àCÈZ‚Ö5á$ú!	&9ÌÛ€50O8	ìµ\\Í¿³ C„0žW5üK~¢ñ2M¼;ü†¸µ¨´â?w]©ÚwzKX!fàÁàD†=RjÝà|{Œf°Æ7\\ ÉƒŒ¼Ÿ‚ã`CˆÄJÕu£Ã¨×¨´÷LfÖ¦.ðœ%ZãÔ\\½¥·-K¬¤ÃòÔÜZ£p7’ˆ-ZÄ¢lˆÆí§¹Œm\"ŒÔá+‹n9ÉQ(e7»ŽØCs‹”2”6Èa´Ûj‹´	×ÉáÛ™0ïR„NÙ„ó–Dš–™½\\(1<fú\'†áå@áY«_ž%³¬R|–Hž±»à`\"‰\\§Yw.Ü\rÉöÕÊÙn„!q«‚Õ¬$“X5Z¶ÕD²Ö{G1éo”â<\0È¸.Ñ¦Ýoµ}_Œø´Á¶ÓÎ!0B00S”CùÄÃô·û„ëßQU9Kñ/(„ÂxIˆðm1ë;\\,ìO0l÷à1ÈõrŠ]ÓK;á«×„_†\rižgé{²`BŒC˜Â!€u/´tK5$ð¬ÌGwšµj!\nCx…Ý¦­´ë¦ZÎoˆDmÊ=_Ý²}BX˜D ÞTºp9_Ãi˜â#¹Î<$ì´AFèb)ˆC77/ï¢íù‰qŽÙL’I6±ÊÖS~\0DÛê0Lí	qÅ£Ý·nÀ×okdkx–$À‚ÌuÈÜ\'©[í§ÂõzCé~6¯\ZŠèœO°¢§b;m¢1ÚÉ´F¢l»åþ[GÏ¶Òø\'iºa$ÔÔÃÈ†uøÏ€eð[·ÅùIXWÝ>è/zÕnÖ0ù Ê!¸ð·|5É#}Z}`Ñz5[ÙºÖm7wÁoè\'êî¶ŸPN1{µù¹üêõ›ÅBÚsmÛÛ–ƒn.	¿·)ŸÕÂKäXå‰‡	ùß…ùxh	×%e×}\\ßíÂ\\%]ÆM2ÖÛ]Á„ÿ\0½Í™k\0­-þ¡C>SK§ìCÐšã‡G)vÔéá#dè›F*þ‹ñ·%Ù»e{‹áªÚùàÝÐ±vuÕÏ\'¸Æ°™ã1<!¥ñìÖÔËkw}§Xm´üqn²Líƒ† qn´F8Ü~:Ç1°xÕÅÄ™5ï š&ÖA»±ršáu<Ú¹Œ‡+ßkÑ_×¨íÎOrÚÀzð¦øQ•£ÀÁksu›…Ï%ÜvÚ^˜ƒh½mÝaoŽ¯ªß8Ñq\'ày~Ü-Øë÷(sÜ.QƒSÇÁ\\[¹`Üaýd#qºÄZ-–ˆûbÖØí|nNïa¯N[m˜î\rÆ™mZµ€ÃÉÀn7‹¼¾1ã>å-[\\nîšFˆ†Ù§êû$›;‹ì·ÏÀ´¸Ç‚Âkô·¢f¤ý¶[!¾ãæÒuñ:G‹9÷Úzž©§§wÒÞIêpâ``¦—wlÁv·n!¾Ü¶Ák†#ÉíÏE³˜Ñjy¹ÒÀ„·d+V÷ æ€ƒWŸýZ›Ui~¥ÏmrÀQulç¸æ£á-—µé¹âéO8>Ì{¡Ò›£âýñïÊe¦Ô\'ã%ÁÂÖð~8SPþ×o‡¯¨õh—SdËXsƒ¡‹E¶^1æOÓ¨v¯766íNÙ€ÈkÚÃ_«\\¡h^ƒ©¦ÕÇ©C‹ úµ®#pÿ\0êzË\'xø¿Õ\rRrR—5·ÿ\0Õ³ÀãÞ`x˜)Æ¡:Ïï\r½çF§»>Ùœ{y7®kóµO–\rÌß¯«„\\w›ªp†=Zˆß¶ç\ZÀ¶Û…õEËWÃ\\¥¹7îvc¢Ó~7Z!VöºÚâ;%æ: už¿îÜ„×7íž¾Ñ†õ›Þ·pÁûß¾úF‘”–V¶ä8•G¬’ÎáÖ-ÃÀða&×­k6ñmí\nÄ h€Z±?Ž#½î¤nmžíÏü-XM7[¹”×ë¸øÛ¶Á¹Ñù¿G«OüOw®-ýÜ´Ã_M÷ËÕÌÝÓp´N÷(ÀMdâÕws2Û„øC•Ãˆ]¼ÍÉÑoÿ\0’•¹p#Kg€°¬ÓÜŒ7b Ëwž!»ºy¶Åx˜Ã&k|Z·Ö¹—îÜ8Â÷±éÂÓî×K õ}ì/ÂÐòŒ\rOPþ8¹ÿ\0¶\\ßeË0†‹ƒs£ÍÙåÖ‰ýß®yã¶7¥i|!îÇðîSÞôÊÀä¶Í•Ç%Ã¶Læ¤xÊÇQjMÊïl×ËtU¼&EÆËj]tÊE÷qâ~ZœpÎ†Þ¥ŽÔ¹Íñ1#>¢x»âØ·Ù‡ÂÝ@¿ÉôI7\"š½Î#wºÝoÚaßK2êt½ŒnÕÍ[noY;›s†ÚƒY¹dG…¸eæ¤^3ÚÚK]ìx±“ÔÚ¶¸•wN­NÅhçs|Z?ìNÛgVò812A»Eæ\rë|0ØúÌ†!Á»rM³¬H.-¼µ³Üm~×?w÷<{˜¾‹÷™žâÀgÊn-ÉQ­WWp:½V¸=´åÁõéÈ˜u3Àñ>$!â\n%Ï½°Òo}q4ñqn±hÀ86Öä^íløËs¹ìæsäíÎ¼?¸AŒ%¡Ç}ø1yÇôÚ±ƒôÝ{P?åËÕŒ\\—/\\?F#°îü÷®x¬·ûqÌ;Æ¦ë½ŒwÛV¿«rG‚vg™G¦Úd:4ùîÚ×[¹r8Ö\"<ÛTIâ	¼\\/^Qx\rŒ,>Kÿ\0|“Uå—I¹«oXö+lhƒŽ/°{\\äû¹·êÙ»†j˜·Ô|;CÔ†€ùƒÊK•7IÇÜ©ß9¸m¬ÜŒBíÔMŒïV•­^çw&ÓÖ¯vc~ëhØÕï(Ô»Õi´jçÂ÷ã0ùîøÉ¸›\"à]ëû-@ùl{f§¿	!»—z)\\i«!9«©kæÐmmÜ»ˆæ§ép8¹“ÃïIt¼iÇÙ>†þqoMA<Û š\Z n3‡Ú§=Åìwb%µÚÝùqqnš‚×qpö{Œú³/¿¶žä»\rýµžÏ—}gRrl›vjc§zƒÓbXIå«V­Zð3¨rôV«Ú6<,F[Òq0Ý¨–öëÞ3O3[ÓrÄõEfþ›cüŽž3ßý71Ý©£¶Û½Ýç:.Æ¯_ü7þ|õ0òeZé8¢î8	•ê¸Ô‡r\r/RÛn#„A¬îÓÎ´6¶²wEÏÛ§7«V¿¼[#gýÅñ¯Öå\\KMDC¿žm×.ãz¿¹»W4ò÷,\\/æ½#m.#©þ¼JÆµ„ÿ\0Ã–ùdÿ\0µ¡ž‰¶zp4ò\\/u­\\§êmo¦Ù‚KÜwÌ÷QÌ:ÁîÝs÷Fÿ\0œ—Yþz÷º“êqlDŸ³|d0áðÛ†$Ä™`Ma«‚re3­Fÿ\0Ù‡œçË„¢¹.“íÓ»©<ß!Þ\\Ã­cMÂJ{é(*e€¿äÝ#­,8oÕÉ¾G¬-´FÆã~çÚûŽø– â¸„bõ‹Å7å®ÇR]ÓƒÿÙ','Â¿En quÃ© ciudad naciste?','nose'),(324,'cedula de ciudadania','gerente','julieta','vargas','54984879','calle 15','julieta@gmail.com','$2y$10$jJUQOK9zpNlFlPwU4ayPpecq6s2Oy0Y/BdHNmCXf2dldIArh/4zTi','activo','','Â¿CuÃ¡l es el nombre de tu primera mascota?','tommy');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario_permiso`
--

DROP TABLE IF EXISTS `usuario_permiso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario_permiso` (
  `usuario_id` int(11) NOT NULL,
  `permiso_id` int(11) NOT NULL,
  PRIMARY KEY (`usuario_id`,`permiso_id`),
  KEY `permiso_id` (`permiso_id`),
  CONSTRAINT `usuario_permiso_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`identificacion`),
  CONSTRAINT `usuario_permiso_ibfk_2` FOREIGN KEY (`permiso_id`) REFERENCES `permiso` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_permiso`
--

LOCK TABLES `usuario_permiso` WRITE;
/*!40000 ALTER TABLE `usuario_permiso` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario_permiso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venta`
--

DROP TABLE IF EXISTS `venta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `venta` (
  `codigo` int(11) NOT NULL,
  `Usuario_identificacion` int(11) NOT NULL,
  `Producto_codigo` int(11) NOT NULL,
  `Factura_codigo` int(11) NOT NULL,
  PRIMARY KEY (`codigo`),
  UNIQUE KEY `Usuario_identificacion` (`Usuario_identificacion`),
  KEY `fk_Producto_has_Factura_Producto1_idx` (`Producto_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venta`
--

LOCK TABLES `venta` WRITE;
/*!40000 ALTER TABLE `venta` DISABLE KEYS */;
/*!40000 ALTER TABLE `venta` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-09 10:45:30
