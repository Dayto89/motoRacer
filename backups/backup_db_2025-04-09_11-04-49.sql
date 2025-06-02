-- SQLBook: Code
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
INSERT INTO `accesos` VALUES (1,123,'PRODUCTO','Crear Producto',1),(2,123,'PRODUCTO','Actualizar Producto',1),(3,123,'PRODUCTO','Categorías',1),(4,123,'PRODUCTO','Ubicación',1),(5,123,'PRODUCTO','Marca',1),(6,123,'PROVEEDOR','Crear Proveedor',1),(7,123,'PROVEEDOR','Actualizar Proveedor',1),(8,123,'PROVEEDOR','Lista Proveedor',1),(9,123,'INVENTARIO','Lista de Productos',1),(10,123,'FACTURA','Venta',1),(11,123,'FACTURA','Reporte',1),(12,123,'USUARIO','Información',1),(13,123,'CONFIGURACIÓN','Stock',1),(14,123,'CONFIGURACIÓN','Gestión de Usuarios',1),(2159,324,'PRODUCTO','Crear Producto',0),(2160,324,'PRODUCTO','Actualizar Producto',0),(2161,324,'PRODUCTO','Categorías',0),(2162,324,'PRODUCTO','Ubicación',0),(2163,324,'PRODUCTO','Marca',0),(2164,324,'PROVEEDOR','Crear Proveedor',0),(2165,324,'PROVEEDOR','Actualizar Proveedor',0),(2166,324,'PROVEEDOR','Lista Proveedor',0),(2167,324,'INVENTARIO','Lista de Productos',0),(2168,324,'FACTURA','Venta',0),(2169,324,'FACTURA','Reporte',0),(2170,324,'USUARIO','Información',1),(2171,324,'CONFIGURACIÓN','Stock',0),(2172,324,'CONFIGURACIÓN','Gestión de Usuarios',0),(2173,324,'CONFIGURACIÓN','Copia de Seguridad',0);
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
INSERT INTO `categoria` VALUES (1,'Repuestos'),(2,'bateria'),(3,'carburador'),(4,'faros'),(5,'juego de pastillas de freno'),(8,'hola'),(9,'prueba'),(10,'trabajo'),(11,'prueba 2'),(12,'prueba 2'),(14,'cine'),(123,'AKT'),(154,'Autoplanet');
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
INSERT INTO `notificaciones` VALUES (1,'Producto nose bajo mínimo! Stock actual: 42','2025-03-26 23:59:01',1),(2,'Producto chazis bajo mínimo! Stock actual: 20','2025-03-26 23:59:01',1),(3,'Producto nose bajo mínimo! Stock actual: 41','2025-03-27 00:08:20',1),(4,'Producto chazis bajo mínimo! Stock actual: 20','2025-03-27 00:08:20',1),(5,'Producto nose bajo mínimo! Stock actual: 41','2025-03-27 14:02:34',1),(6,'Producto chazis bajo mínimo! Stock actual: 19','2025-03-27 14:02:34',1),(7,'Producto chaiz bajo mínimo! Stock actual: 49','2025-03-27 14:02:34',1),(8,'Producto nose bajo mínimo! Stock actual: 40','2025-03-28 14:10:47',1),(9,'Producto chazis bajo mínimo! Stock actual: 19','2025-03-28 14:10:47',1),(10,'Producto chaiz bajo mínimo! Stock actual: 49','2025-03-28 14:10:47',1),(11,'Producto nose bajo mínimo! Stock actual: 39','2025-03-28 14:12:02',1),(12,'Producto chazis bajo mínimo! Stock actual: 19','2025-03-28 14:12:02',1),(13,'Producto chaiz bajo mínimo! Stock actual: 49','2025-03-28 14:12:02',1),(14,'Producto nose bajo mínimo! Stock actual: 38','2025-03-28 14:30:16',1),(15,'Producto chazis bajo mínimo! Stock actual: 19','2025-03-28 14:30:16',1),(16,'Producto chaiz bajo mínimo! Stock actual: 49','2025-03-28 14:30:16',1),(17,'Producto nose bajo mínimo! Stock actual: 37','2025-03-28 15:44:57',1),(18,'Producto chazis bajo mínimo! Stock actual: 19','2025-03-28 15:44:57',1),(19,'Producto chaiz bajo mínimo! Stock actual: 49','2025-03-28 15:44:57',1),(20,'Producto nose bajo mínimo! Stock actual: 36','2025-03-28 15:46:19',1),(21,'Producto chazis bajo mínimo! Stock actual: 19','2025-03-28 15:46:19',1),(22,'Producto chaiz bajo mínimo! Stock actual: 49','2025-03-28 15:46:19',1),(23,'Producto fghdhf bajo mínimo! Stock actual: 36','2025-04-07 18:57:17',1),(24,'Producto chazis bajo mínimo! Stock actual: 19','2025-04-07 18:57:17',1),(25,'Producto efhedjh bajo mínimo! Stock actual: 1','2025-04-07 18:57:17',1),(26,'Producto rhefh bajo mínimo! Stock actual: 52','2025-04-07 18:57:17',1),(27,'Producto freno bajo mínimo! Stock actual: 25','2025-04-07 18:57:17',1),(28,'Producto filtro de aceite fz18 200 bajo mínimo! Stock actual: 4','2025-04-07 18:57:17',1),(29,'Producto pin pastilla freno set xt660 bajo mínimo! Stock actual: 5','2025-04-07 18:57:17',1),(30,'Producto foco bajo mínimo! Stock actual: 9','2025-04-07 18:57:17',1),(31,'Producto fhdh bajo mínimo! Stock actual: 19','2025-04-07 18:57:17',1),(32,'Producto kit de arrastre cb 190r honda original bajo mínimo! Stock actual: 6','2025-04-07 18:57:17',1),(33,'Producto dulce bajo mínimo! Stock actual: 7','2025-04-07 18:57:17',0),(34,'Producto sdgdjhfgj bajo mínimo! Stock actual: 45','2025-04-07 18:57:17',0);
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
INSERT INTO `producto` VALUES (2,3,'banana',19,24567987645,321659878,316487,15,'sdgasdgg',1,1,3,3,753),(12,23,'123',19,213123,2223123,23,225356230,'16549848',3,3,4,2,157),(149,0,'fghdhf',19,2384,16849,1231849,36,'sfhdh',5,3,2,3,753),(232,0,'efhedjh',19,26519,65254,59299,1,'ssdggs',5,3,1,2,753),(369,0,'Faro',19,1619498,1561949,199494,789,'amarillo',4,3,2,3,87),(457,0,'jlijkñ',54275,52752,7527,7272,72,'hjkhjkh',4,3,2,2,87),(458,0,'rhefh',19,16847,2682,1987654,52,'sgsg',4,3,1,3,89849),(475,0,'freno',19,540000,650000,4250000,25,'frenos buennos',5,4,2,45,89849),(564,0,'filtro de aceite fz18 200',19,18462,9515159,453543,4,'asmknd kjas dkja sjkd kjas dkj sakjc jkas ckj sakjc ksa kc jsac',2,2,1,4,9298),(745,0,'pin pastilla freno set xt660',19,860,8191915981,5119191,5,'nn',5,3,1,3,753),(879,0,'foco',19,5620000,652000,4600000,9,'buena iluminacion',4,2,2,1,753),(895,0,'fhdh',15,194941,54949,59849,19,'fdhdfh',4,4,2,3,753),(954,0,'kit de arrastre cb 190r honda original',19,1659,6516516516,651651651,6,'dlgknsodnvosdnvoknsdklnvlksdmnvmsdomvnk',2,5,1,4,648465165),(1204,0,'dulce',19,3456346,876876,8757865,7,'r6utr6utryjtryujty',2,2,1,3,9298),(1564,0,'sdgdjhfgj',18,49494,5000000,4800000,45,'no se bndad',5,3,2,3,753),(1654,0,'AKT',19,25614949,5648949,659494,65,'adfsjyupo}+´p',4,4,2,3,45686);
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
  `contraseña` varchar(255) NOT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `foto` longblob NOT NULL,
  `preguntaSeguridad` enum('¿Cuál es el nombre de tu primera mascota?','¿En qué ciudad naciste?','¿Cuál es el nombre de tu escuela primaria?') NOT NULL,
  `respuestaSeguridad` varchar(255) NOT NULL,
  PRIMARY KEY (`identificacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (123,'cedula de ciudadania','administrador','ramiro','gonzales','123','123','nose@gmail.com','$2y$10$7UchjN72ld2G5N44/XdC/e5wfM2M/9TeNCktN5frRAh7jBS1voZp.','activo','����\0JFIF\0\0\0\0\0\0��\0�\0\n\n\n\"\"$$6*&&*6>424>LDDL_Z_||�\n\n\n\"\"$$6*&&*6>424>LDDL_Z_||���\0��\"\0��\0/\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0��\0\0\0\0𮴚�՝�7V\'L�lE2�PIA#��Y��&�U�e��g�F�\\gd���[i*ʒ�*�N{D�<j���\"��]N~����9V� ��Ԕʨ�e3�f���93��y#�3n�<���@�\r0\0��y������u.�.�`0�.DJ���5��K��W�ewTh�\'Yv5HE2\r��dh�-�2�������;d��ۏ�������yK�X�h�k\"�ԫVD茧Y2���.�93���ˢ%����NpTܸ�W�SoRi�&1\r�9�M\r�\'=�u$K%5�ʹ��ΫJɦ�3G�kY��2�h`\0L�r�x����]q5�==#Н�(��H����J���TM�\'I2�d�v����<���>C��>�hբc\0\Z&-C$���2���h��:[!&��\Z�#����XYo&oX�jf�k:-\n���\0\0	�F{g/>}YK��3j1vj�`\"��\Zi��\0���mF�)�L��L1ꃇ>�^_C(����^���:����1,�L�KU�zAM�F��W)���.�[�5PY���Λ����\'Mc�j�Z͚�vUC,L\0!��jI�#7:9e�j[qZɝ��ҡ��Ʃ*�\\�<���|d��3���.��<�p;�;δ\n���`$h�kr@ȢG����keQ����4Y�Z�jd�Lٮ��&�&o��^:<ꮳ���,���MH��ǟ��X��W6�֙���%O7Z	�\0v�0�x3V�5��e��Y0�x+L�Ν^��l��l��]^%�����Mbag���2WDVl�H2B�2���+5��M*(���󴺊.���*�LC@BMF|=�r�te�l��.�1��\"tTtc��e  �Vg4-$�t�&��2���Y�k{�*�X�it��6���0��yѽrn9T(r$�nYB �1�U硦��liW7c�ET��(ҡ�nX�\02U(��1�i���Ȧ�2z:�l�Ƭ���9�g:I����g:J�/\Z�<�1Y�џ&G^<�uG2:�#;=Ŭt���Lbe\00��R\ZΣ�m.֖P�����K,���չ�&�DM̰�\ni*�rQI͊Z\0`��JɚDM�hZ�3���fi�Ď[�Z�Ɛ�Hr� �͝p�/E��.���1��F�Yh�P�tK�=*�i)��0\nAB$]��Ԋ�,���#�|��R|t{�hz���]Fv5B (r�bM7$�\"u�Q���Fu�r�<[r���4\0UM����o�\"\n���p�����f��E ��4����ΓGX��@�rҜ���9���ɮl���&[�m���z�y�i���V4��D��qFɇ<�Y�\\}qϕ�s�:\0)�]f�l���[�Au\Zvr��oI��\r�2YW��TQu�M�6mXݚ��RD�H��͖&.~�x~o�y��f!��,��w��F�E���C	�O5;_��z�R���q�r��͍�˿2Lk�Y�,mh����n�0�� ��j���.�����K����e˼�ҳ����JΊ1\"�cż�iY�W�!�ҏ��?2<���i���\Z���i�rvƍ���������.,�����=��鮧7/�Ͼ8�&z4χ��Ԑ\0�\rȉ�ky\"�B�=�����jV\0ܱ�͖J4�6qEԲ��6iY�G� �I�iYQ�eVl�9; ��^*�;�ϥ��g\'I�\'���b)x���pJ��J��=^����\r㇛o?#nN�2�=6�@&�X҃�u>���И(\0��\0��wiqe5@��HUgID�$,�@��Vlڲf�;����|�ōq�QVz��w�f�V5	�܈y��yK��}NS������uW����y||�a�Ǯ����s��10\0u�/?V�Djڡ��RLrCV�Skw6���\0c\0bCI�卦0\nr�T��O���+��gg��zz���}z��q�o�N���3���0�h�}\\��u�u�.:�>�lwce�U�\n��24\r40:�^\r���7���\0\0\0\0&�\0�V�M�Tѥͣ`6���4%HI�\n�0Lu6\0ԉ�gl����5�F������y���K��&�Ǘ���4�&������\0Xk����q�8*Fݘ��\n֌kAa�&\0\0�\0\0\0\0CD�pKMm������K��sIM2�`�Rڈ��LhT��`���t���xg�Y�r{��z$+���9�x�&F����O8桊ֺ��W?M�3�Z㦗6��V\0\0	�\r\0\0 \0\0�C7gy���4�R.��5��ֲ��;-�(\0��̠c&�@�h!����{�2���3ϡKŏ��𭱀�\\���Z���ө�o��|ޱ�:isC\0(\0�\0�L\0\0J���=�9��19Z�P���-�A��Uv_>��),�6�0d�L�9cP���eTRoчE�2��\0\0F��ǯ)x3��������2����}}3��m�tu46�����@��U4[���N~�s�i��]u.���k3J�+����;���Ң�R�b�3CABh\04����u��ʼ���|w��;��\0`&)��9;��U�/���p��/���\ne��gm�m\n�#B\0��eT�U5ci�=��ǿ3ώ�%�ԫD*ʳYI&�z�W�ܽu����$RD�卦�J.s�7Z�U��՝6�}g]��‰i��\0\0,3ã(�ZD�p�<g\'o���xTr���\0@�\0!�\0\04¥��SL��V撚b(1ˮc�?C5��1^�2^E�dl��<��}My�kG1!$���Si�e�$c�%�l�M:3��Y����)˱�740\0hCD�q�z�.|=������W�ͪ���$1��\0\0\0\0T����rˬ��QnZP5S�a�T����`�f=��ɟNF}��K�oϼ֕T�!\n[���w1��Ȝ�^���k��ksw4�\\Ս�@\0�SL\0\0�\\̱�8�.���ǯ��6�&�\0\0 �T��C�6��2�nw�%�uZ�����=0�<������oMt����i@�+���j�,�����4ZYZͲ�U�����\0`Lb Y���N:�/?/^+�i� (�\0�\0\n�h�\"NU�ci�AB\nqET4���YѥeF��&�*�h�.��������s{햅�^��Y�T�]M�f�d����J�t�6ܺm0`\0@Ѕ�LFZ�.o���)\"Ӑ�\"�\r\0��&P��(�7,��UC-�\ZVTmYZhH	�˛��^B�o]3�t��SUSE�����=��)��\0A�6��І	4L�D�I1\\��c��<��c@�@��\0�\r\0\04���)�-�QE�Tj�f��c�k�CJ榮檓D-T�t��\r�i:3U6�i�a`\Z`�\0\0\0MH&����4�\\��8�B]6˦�5�6�\0Hܰ\0��\Z\0\0\0�S�P�Դ�ii�-�4��ҳ���Ytf�t\rU�\r4C�R�.��*��[%*���\Zt���\r1��\0�h���γ2��R���M��)�����S�1\Z4�b&�B�H�cr&SANYD�ԅ����G)�W%iJ�T�EJԡ���+H՚��X�U,m:\0�\0�10M8�8����.��o97|�a$�@  ���\r\0���!�F\0����UC(AM9n�^ZM:J�\Z�R4�w:�V���h�2�46���&6�4��H䘬���d�����ha%�R`��0@¥�\0\0h)�)˦&S�[�UEE�ei�.��v�HQp���\n��=Y����;�\0�P�1��\0\0 &��v�1s����H��<� \0 A0I�\0\0T414\0\0\0\040\"��:�K�Դ�Ζ�Q�gt�DK�����j�M3���YU�\Z8��i��61�A.	Ʋ��ܹ-��s����JІ!�4\0\0&�\0\"\0\0\0\0\0�T\0\0�-���v[�[���Lt,EDT-i��m;*���Β܅�z&�T\nr�10Mr,�sS��}ʺ1$�^�8b��A�@�#\0L\0\0\0@\0\0*]0�\0 ��gE�eTQ��f�	�HZ��E%���(w�Y�UC,@܅�@\0$!so���a-kƏU���i�=(�@T4$�FPK\0\0b h\0\0&\0\0M�6�	A@)SE4ʨ��(� $Հ]�%�U�QE\0��M#\0�,�r�4(��8����`Ƞ.(i��%�4&X��D�I�!��@\0\0`\0!����	�@�)�SE�QBJ9qe\\ZUK��iL�@ܲ�Ѱ\0 �� ���/�E/w�\r\0,���$�@�hC6Kb��!�\0\0	�C1R��45C\0��*���-j��Z%Vuf�UKJrSE9e4#��7�O/FK̫�?s^^�y���K����Jh�L\0\0\0`��!�\0@�P���\0��h`R���:��HmY�U�Fו\Z��G�y�7hKF���1�F�k�6�qOG0��G����� �4��@�\0��\0b\Z\04\0�\0�\n&�@��Cr�HY!Nu����V&15�*U�\ZVl���+*M�-�T�*�T8&\"�Q�di0k��8g���\0ߚUy����\00\0\0\0Mh\0\0V�@C�Jp�%B4R-�e�T]gU�΋r�r-9e\0��i�)ˋ����n}�z\Z��e���	L���eDUEE�%c�_>;yL��]	�ɱ�\r \0\0\r5\0D4$�\0�	D�I#�@H�-\\�b�4qJTQUh��U�TR؉h@�Ҷ�mT3^�^����r�2\"�\"b�B`�e�YbJ&�C�:33�j`�h\0��\0b�U�̩�&�4LT���&�R�!+@12�(m5�4[N��KZsRЅ�.Z�T!E	�`��z��p8�����H�.+H�RmFbETUO?\\��\Z�{���`\00\0b`	�`	�+I��P�f�%\\���i`i@i�K)�R�F�u=�)y�9�i�+i�R\0\Z�������i����!\r H��ee�Ψ�$4�Fd�U��tOB|��k5m5\0�\0\0\0l���a��5�kss*��*JFs�5 (���Z�M0;8�����Q�m8�5mR61�R���ܖzd�SP$<�\076f\0ܱܲ�kX�a��j�%�>�mYQ���\0\04\n�A9퐋+(�gX!RY)��\Z��i\r�M[�[��J�+��@�J\\R�N!m�)�#�\n#������r\0�\0��H�i,Q�34D\r�w�oaI��i���;]k*��(��2�u�$��u��v��3\\V�Aa��ۃX�L%*j�sEԵ��X�u5-�!d��6Y\Z3}��T��T��!����\r����(� �fݜ6t5+�UWq&�c�]gF���Ҡ�H�D�dg�fkY3���6�5�fd�j/>�\rp�g4�յKMR�T�@RkB�10f����\"aKJ��&���la-�.��GfoVa��sK�p��^^����<=%�8��&��k�:\Z<�֢�r˥@0S��6-3Q1ϢL^��X\"�l˗�K�a5�?K��z�MM���,Y.������\r������ ���1P�$:d�]MiF/FC��6G����My���S�υ�/X��M4�����K���\Z5��oxjiQ`�C�Z�n�\'`�m\'9�,j�\0ڪ23ޗ�v�ǯ@az���SE�B\'3e�&\r0L�f��Q��S���$����D���ן[kt��V>HVRy� w��T�b΃oXѵ���iżtTZ.�\nd�\nnE�\"U MME�kV���jQU�5x3H�JyĻ�\nQ��٥��`PK�MQR0L\n���\0��L��#pʍ���h3��i��D�͚�VkYQnX�9�������R��A�3Z���%��+���J�C�~.��p�院�u�^5ZC��7�+�=\rx�:o�뢲�Ѫ*� Lu41!��C:�9�K+�dB\0�\"Yu��U�v[�8�C���[����-�NjL��2��9�{�p�xs]ڭ8q��4��۬�[0:a{Tq�z9����������q��͕R\rH1h)���p��\\�� h ��4ύ��TT�40�e��UE\ZVvT���f��WN^�W��/UevUƅJmy��\nxyts�Lt^�%���P^�}�դ�Xz�%���x����M�uz|>ܱw0��˙��qNEi9D�c0i�/}����rH��+Y�8�\ZkQ\r�$\0�7,��ΫK��hZA:c����zzZ��K�yZh⩀O/^6x|~��\\��н!D�E�\"�.�����.�\Z<�<�|�y���Y�L�nObo�p�k9t��e�r���.:���o���M�Fh�zUtrr�Y�-u��㊳���@\0\0\0ܲ�iY٩4)�gn���o���a��E�[gg��}��]�k�.J�\r3�^������o|�Dtc�%.^�=Iǯ��|��k���6�<���y~�f58����K�(��4:��K�-�ȎN�8�	\\�k�4�^\Z��K\ZT\00�0C0L�UŗQT���ɨ�~�\0/�=m���v�����M*��~�ϳ��DM��&�pv�a���t#\Z�|RIuϖ�����n_]~wd��U��w��~�EK�Uaں*�0���=�3��V����	\0\Z\0`\0\0\0\0Pª�R��/��k�U� O\\L�\0N�_`.6�\n�P��N L���a���� �>PY�A�Pi�@S`\"P.>X�A���?��\0��\0\0\0\0\0\0!~T��0À�\n��N<`��xh���V�XS��.��g���j�������qID_@x0��(o��\0��Q1\nM�㋚M�\0^�2���F�g\0�Hh�J�\'.��r�_x�(��\Z���\\�=ƞh���\0U���R��@<rf�U��!ѡ�=�y��@` M8�m��V��N=�8Aӂ�8QU�Pg(��+|������,������|��lY��y�5��\r���ڳ|���k?s��\0>�nږ�`@t�<1�h�rq�0���ׂ~��x�z�.\n0!��P�8pPd�A7S*غD��\r��d�*�@m1�w�A6�%�E\0l�Y#)��D#���-���@Т���6���1�A@�Aܥ�\r{:�����n�W��<XWN�U��5���0ɶٴ��ۉv&�\0O�1�y��X�eVQo�G�\0\0�3p��s@�ϩ�s�Y���d��AT<�E�XE0m����E���T�_wV�B���Y\n���%�_T�$�p�F�Q�C�5;��tI���04q!M�E4u�*�k�G6V�(��w��7��<�\'ط�qT�E��m�{>�5�ޡ,����a��<��\"~�G�K\"�]�\r\"�E0SA�Bs��M��16 ���U\"��֜�4�����6���W�DBBA�*lMq�-\0D�IcRPg�!�4�J	ToP�p��P�<$Q7!���)�ѭgC���1�.��\r��iC�4��m��:җ|t]=���\n 0�?;\"3�=փ\0�LQ��q��dҐ��\rw��$�{����\\p0�(ф�@]�\n�8<5a�?g��,��0f@�$QF�\r��\n��t�pg���m �Թ��P2�]7pi8�0��#�FZ#\Zzd�\n9G\'N�  �<\'�S��AGJp��i�ϛq����wW��\0(S�gl�,wP� �A6�\"0�@#�T��\0\\i�1�\0E+���\0�$�\00��i���,���l���(����wc_,��	�XG|ϝ	��mg8(7;��\0(J#�E8&Dr�(���?�F�P���=���_�u]��\0�mE�_M���(O�\0�\0\r����닣Za2 \0���M���RL��:�1^n�5����5&�4s\0��E��]�#�\0�Ǉ�)y�G~�-�]�Y��8AG����p�Ca���\0;U2L��U�!sDh��O4WXt�mD�m����\08���(�40Hh�)L�AT$���uu\\!%�p,?��P��0�\n\Z�>U$q�@9�\r��A�r0��a�!�\0,��4��3���x`�]@�ό�G	���q�=���PR$H�F�FE��e�q|(���\\AR�-~�8x���\n#�BZ�B4�D�\0��$�5�Iı���\0<��< t�q[T4�|�m�)�Sa��l>rE��Q�\n�DYX>�0�H�9�R����$rs�_aqlM��Y��J�U9�������<2 B§�A���@�D;a�d��sL%wUQ�;+�%0s�8�0x�$��}���P�N(\01�I����T-)���pӃ|�]p�,�v��K	�w�p�8�lq@qȦ��2(4YSG!Jc��,��IE�R41I�\nO�O,MR�>{�,9�8�*��22U�BK,��qJ�:��#���a��5�7G0!	,=�ʺх��O�s��C��Wx�n��}�I$�0y��*��e�㋦��D��-�r�VE@l���(S�g��ˤ�v��z�i�B=��=�[W���)j�F�0�\0Ox���4�C�OP������F���g �AD{�-Ն��dk%\r\Zq$�!(�[�>�-���榡�P���\n/�,�oD�������)�A�r�徰���F�#��;tb�*�P[f�U0kBs��<`�2��(�$����5�žQ�T@z)����+�x�Ȓ�(���\"V���k��<p�62��+�Euot\r�\0�A�b|A~A<\0?`t(�w��s���\0���\0��\0\0\0\0\0\0E\"rnQ��\0^e�аZ�a�u#6�.��\\��*f��t\'^�Ѷ5�JTh��\nFjg�X�:ן[��\"*CYM��P�_��uX)����j��3&\Z�27��0����?#i�J�5I$��6��یIq�Y�m��\r9s!�rL{\'��� ی�rfEϳ��o6J�_@)���).V8\\�)��\Z\"�-����_M@�0������#*eH]b�%���Q`�G�o��ǥT!�t͵_�d(�2��`0 ����5�Ȥqi�,:�-xӡ�Y!�ND�):�i�6�ht�M�$֙ �>:�,���k����H E���n�I2��Qi�l��m�87�a�o,b2m��L.��Λ��\0��b�Q�\r>�\\�1@����nA9������f�ő���u��$� ��ꤠ��s��>)e�>�Q�\0�����Hs�%�������*� C[�g�ϖ��%Ud�]M�v*\0�@\n�6�\"��ZE��lC�Y�{�\nP\n4b�$��4S�]T�o�o�P�S���_9Bl�])B\rV� B�PQI�\"��k$\n^�+�Q�CU�\\Q�5�U����|{��(0`\r0��!\0p�yw�+k�<�\nS����d�O\\8�\0��@c8\Z��]h5�00���������B�+_��\0�Ԥhh%����(��8%�\ZX�t\n�\0YD=�,j�b~��;6%\"��\0f�0�uT��q\ZuM�vG�nA�k�n��\n̢!d�ӎDU[��Q�N�p�Ԍ�z�������L��<\"0��e�n�)\"��B,É��嶚�\0�\r@K4�e� �W	�)W�WmQ�=��/���8����$�$�`�QkT;w�ᘎn��*���?@ty�G-�z8覨����}a1*���k���0���0������sW�:�>o��b��|F��4��j��ˤ����8�C;�P�&��&����P���e�	�)/�k@�p��%UDҢ�d:�+0~���Fz��$�\\���n�r��++��B�	1������h��ӏMr��*i�W���F!�i}��(�o��,�����W<�ݺ���h=ﮖMta��D���zQ���(%����1��y�X��\0�\0��6~���\0m��)����i�̈́\n�<���\0��\0�\0�\0e^t�%&N�l�x\'�n��m��aj��������\0�RF�l�pIUB^q譞��SZY��h��\0��\0�\0�\0�i�0����T����\0+*��F�l��\\�\'��\0��\0�Q�4Q�:+-�ݰ�;<�6\\ӌ9����\0����\0ݠ�8�\n����T\"��=�`��3h�~�=1����&�<\"	��G�&�.3�Ć��TRy�\0�\0�<����`�C.��K���(�p��,��iF���K����q$�E,d�:���R`����B���&��\0�^�UqE0h!��\nm� I�i#m�h��R�\"�n���C��UbG%�a�7���F�������0FP�L��~J r*G�$F!\"�mҩζ��� �הT4���ȣ��̀��`Y��}�@�vfA��:,U4�8\'H`+��:��v��dT��fV��\rT��	���\\Y6Pu� �M�J�$\Z|e�#q�:F�B��2���]���i������\\�J�Γfο��s�$#/[a�e}>�)G�QLO\rl�L��8�\0F,��8 ��������1��$םT��6<I�z�	�דA\Z	��Psl��M/�Z�0Y?׌^+�+�߸�oh�qD,�R	��������{�m���ROJz�κ:��hZ�,�� Xs:���}�H9�.8��f�E��\0aS�{�N+�ò_~� ��2��c�@&z��[C��A�E�\nJ�8�� Ce��$��U�枹��&�b�����A%\n`�����AS��p_�ωr�hM*E�{�m��	��V�rX����h`\0�\'�ɚ�(�j����N���g�6��C�u�\\�Y�{�x�|?�0��\0�\0��\0�/c|_� �p7����\r׿x_��\0#\0\0\0\0\0\0\0\0\0 0\"@!2B1Q��\0?\0l[Y{��P�)h�by2��X�+j�Ģ����.���(������z�\r�p�ުl���hc�ɘ-�e	V�6Y|,��,Oj\Z2�x��	�b��ŝ�x�X�Y|�bc�\Z\Z2BB��������c�V�qZX��\rT4>TūŮ<�����R�qZQB�.,F��-��C�M��P�q2ǂ��X˛,���1�ZT44=.*�*b|,E��E���XܵE�5�j�!�)���9b#�(�e��	��G���z��̟;.�2ˏ�c�}a����N0�F%�YiEpE,L��Y����,��F,��0�<�P���\0\np����سЙb103�Y�y�=Ǒz�𢹣��0��J��#(���\\(h�V�Q�t|�&Y�Qe�|Y\r�\\l��T#���9H����	EqB�z��d��Y���֥�E��.[,Bf;42��,�V�h�C������BQ�Z\"�z\'-�Ą.!�|/�����e�\Z\"5	�����LS���	Jٌ|�K�˖1�K�JV�q[�SE-,E�c�-1.��_��ǥB�(B���/¥�e\n(�m\r¸.QB�5��z�[��C/�Z^����\\��=^���F75�+t4V�\r��Ļf��ط�rQ���U|��\0mCBB\\ۆ�*h�ȗ[,�-~�<�=���͗�k�n�e�b�X�\'��n�����z����L�\\�e./T6>H�7�C����J,�{������\rJ+��w�h̊��(��X����z([5�ET���y<�W�	,C�4V��<J*QQEZ<bx<3�G����<j\\QEy<�O\'��=TV���,��ZQSP�B>�(j/wC.���{!Ǜ%o[��C���ݗ+Z�����/�X�в���xÄ�%El���C/��e�&X�qEEG�E�3\'��3��2����,�J�̑e��p�f8����(��,>�\r	���Ɔ��-�2��/���2�1�<q2S�,�C*^�J>E\n�z\\#<LF{�z����p����i���e��L���\0�&����\0(\0\0\0\0\0\0\0 0!\"1A2@BQa��\0?\0��w�\\�e�v]�|���?�.^�c�>�}����?�/}�\\�tN���8�r�l��z_xq�W��-����۳��c��.N�>�c8��퇯���\0o���[t�=��#�.\\���.I��a�ϟ){8N�>э���r\r1\\�%˗$�$�G�b�?�V����˛ ��n\\�I��˓����3�<\r����N��|�i�v�����N�gO���g��a��#�����G�|\r�f��y��vx����\'�.\\�r��4ρ�N�v�\r�v�O�\\��\0Dh�I:g�۷M�G��Ir��6Iw�br��tρ�L���G��E�ܾ�L�NP�\\��2m5�6ˮπh<.k�.N�sE�$�I�A�(bȉ��ia�˞�#ar�$�\\�9$k��8��7.�(>�Ӵ��Y�� �`�%�C��Ý���K�Yc�.K?<�O��L͎�.\\��1���\\��������,���X}Yo�I-��-��`�w��Q�I�f��%�D���霻i��\\�����$�����M��:b|ɃL\ZM|M\ZI\"O\0�.\\�Y�\0\'N�.��4�M�.ݱa����ArMc	,�Vy�!�\'�sF�$2�s�a����.A$͆3d��3��4��x\rۻ���|P�b��ar�Ar��\0QfަR�3�:nA1˞�%���~.X�D�g��,ϙ�A�\".����|��yc`\\�����d�Ϙh��Ƙ��H��0E˿TY��[&Ye� ��b��5�bļ�걗�����t��1��i�v����b?ޫ�Kd̻|��\0Z�N��F�c)a���6o�d�[��Ĉ��g�7۷w۱��6.�r�����$�]�����|t��7e�l�����75ٻ>}�I��1�K-�,��A��r�wϾ��?��ŉe��l���R�\0D��I�,�i�>E�`���3$�K�|H<����wf����.�ă}���Œe�g�\"<�sǾ�.y��$�I\'���2�w���\\�o�q�&�˛�$�4\".As��N��XYl5�/���5�/��.Ac|�|����/���\'D���5� ���c �rq�l~�?���%���6C\\�.l\"4i�S��}�m��\Z5�bA\Z曷���|��ni�-�eu��car� �e��O����>�]��۷tǆ9X:��,t���>[<��.�t{	�C\r�v���nݻ�3��Ƃ �$�%�xa�����y?�N�:=�4k���u��]����lsň�>��a޷�?S�yp�D<��k�݆��۷c]��۷nݻ�}\\���r��8����x���q?7�zg�����?���\0��\0���z���ǁ�۾a8}3��5�n��>.�gC���������3�������̽�g�/I埫g�����\"f<��rc]�vX����e���۲���t0��.KwC/��s�Ѥ�ȏie����i������d�7.\\�\Z5۷t\\��� ���\\�4��}�÷Lx���q�t��l5��\"�:e�tgL�t��eӮvk���e�ݿ2����cf���c7 �nM/.�&��y/�DΘٲftDF�՗�F�����\0*\0\0\0\0\0\0\0 !01@PAQ\"`#2a��\0\0?H���n��Q^���P���m6�J���x~O&}dc\\���8#X�Q\'��H�m�P�\n+ճq|#oA.���+\rm+Q\\e�2Fޥu�r�膯ar��8�#�D��\Z�G��븢�+Ӳ�$4(�X�[M�Ҋ(��FҰ�E�����Fwڢ�+4P��8�P�Q�n�8m�(�N��E\n8�.�vhq6�#�SU��\r/�p���4VI@h�Ğ���r��6X�/r��D�K�$QCƌ]�rb�QD�8�h��?On��\01Ģ\\b�e�MN=�J�-#N�]�(�ĔF���q�Wr�x/�Y\'��,�����,��/ѡ�I�{M��o�\r��D�d�Y�Ֆy\Z��z\'2���Ŗ&X�e�Y~�(�\Z\"��r�E���%؜Kh�$�QC%Qģd����ބ�\0�ob�y����(�Nd�h�,�,��͖Ye��Y�L�Q�jK�͖X��K������	��\Z\ZGjJ��d)����hLT43Pl�b�e�Ye�Ybe�\'���,2���5���s\Z\Z6е?���P�()gk#e�sB������%�<Ye��,��xL���2Hy��)yY�n�CCYX��K)�F���,��,�Ye�^,�a	��H����<����,��\\���l�j���XB��)\Z�|��D�������p�F�\"�+7�\"�/;��aazR5���EAs}�a��X�n7�#x���,,�RCCB\\��m*��Pb�#���x�\r������n7�3w}B��(�QY�\"��+�����1�z��}��}��o7Y}䄅�/�}����Y���z��=Q�o��쎠�)�K_�x~��c�)�)��/����,��B��f�f�r�>��>�v/я\r�c���Ȕ��B��b�.+Ѳ�ō�C�%�C�D�H�[>��#�GX����$�I�4Q��i���mazw�M����X��f�q�BD&)����n�ǅ�&�F>k�Ѯi��/Mh2}$&BDX���ɲl�y�汴�G�$<!wl��6N���Qk��ȋ���<$M�$�}���\"q5@�n�e�Ye��w��p5�I��)��O�r����_$_ Z�ދ��2e��<Gɹ�O�@�ms����j@��\'\n6�c���y���FnbՑ�G\\Z�LBĉ2lg�M�\\\"\"~8�\"�kز��8\Z�&���?J0���GOY��\"Es��0��vi1ĉ/���o%&򑴌Ƿbe��ͣR�\0	#�~�avk���o�Α�|�Q�i?d3$I�CP���|bE��uz�_	#[L�\\4�29��%�I�\"�<�H�>\r_���ČD����]����.R>IEQ��9\ZX��Yu7\Zo�Mb^{�D (�wн���x]�T򏍅��5�8�>�p\Z�\r7���٨Y�.��/=ąCJ�įE{HXԉ��Y��p��CC,�ɫ62d�\"i���3I�5#ی#�-1G�^��5�jC?��\0͚.���EE�2O\"�u\"M	�7&����(�\Z,���W���H��%���}}O�ŉ�%��M���Ō�%��\n2C�P>�}r61iɟC#�Ţ��D�Y{�ց��ӎ��y�hG�B�D�5�����\0�C�,����ϭZ6�J�W��8Y��f������T��|y\Zq�,H�+3F�\r?�\Z?�\n(Km6��?�B(zh���#�F�n\\�,Q��hԏ^\Z^M,X�%�?Ǐ:6���7��K:^M<!^����Ye�q���8���s8���O���>��X���v�\Z$K35	c��/jH���7\nBb}�ڲ�� .��8�\r\Z�\'��C	�d��f�7\nDfFB}�ٲ�/(����(gU����\"?u�Q\Z�cc�f�3!22�[,�f$Eݑ\"�\'Q]MI���G�k�cce�24�E���L��!DE�d�\"qƖ&��6�$�8J��FF��H]���r�$E��5�C���%��Yf��\nG�pG���BF���O��9a�Eaw��#T�f�!/����p%�q\Z+(�d��f�����1\"���c�j#R�F5��P�8�(��5�\"��3P�(�$bE^��2H�M��E�(��(�Q�@\\_)�(�\"DW��1��\"H��J$�J#CED��F�!B��	\Z��I�(�bE�eP���$�?�hq%H�$E�yX^���1��ɢk�+���I�����XB����_�C���.1�,r%�=Q�c-�[$5��.k��ǆM��bm�k��VV_�z�e�%��Z����{,�,�������k+���1��z�ܘ��������^�(\'�TE�����Ѕ�<�8���\0�zr�ϯS�#�>��\n���Z6D���o���B���ټ�n�#��l_��K���M�䇨o��G�Ϲ��|����1�����.7�1ĦW�.��\'鱎G؏�\'������������\0�����1�(�����\0ApxB�/E�c��#q�qC��_�e�<ת�BLl��qI<Rc�D������Y���r/���O�/������vNd�H|�ƅ�����f�!���?���!�ӲQk���sd�=CycJD�덗�+�l�ص\Z#4�-4�A���,���61Ĕqd5�4�OC�%��Y����K���ٻ\r�w4G_��SSB�N>p�]e^,�+��^���<�h���E4�F2�OA�]e&_u����E���|-�#��6\'�~5��,�Y���<nǃ��݉�j��׃KV�\0&�E�YyxL�x<�B��5\\�������>J���\"/�D��Yc�e�g�iD?�Q#$�1�e�\\/��/�@�$J,��>jE�����״����&of���R\Z6��\"�\Z�È�F����D1!���(��b����#���I?A\Zx��>~qEa<V�E_��������\"c\'��P��^��>�����B\"��\'�������>��<�ޱu �c}Ȓ\\��P����p6��>������p�?E�\ZR���P�b�%Ev��U�����}2�^Waq|(q(��QE�]�ؼEY�_\'ܡ�D$�Yb���h���+QY�Jz񍐂^�QC�5�!jOG+�Ep��(��(�m%�J\rz��r!\r��QE\r\Z�$Y	���,Ĳ���E\n(���e�Y?�=6����\n\r��KҢ�(��(q\'�N\"37aeb�X����e�i���x�����>��RZ\r[6��+Q���K�#�dG�%�P�|w���(�\"�(��4j�!����x\\S�EQE�6\r������}(�\0��?���Bт>�-8��Xٸ��QE$Q]�\Z�	�<,7�ŕ�,�1>�1C(��f�ᛍݚ(��Ew��#�%�,>�e�Ye�������,��Lo�,\\+4Q^��b6БXX|/	��ŊF�/�Q]Ȗ\'o�x�n7�!��3qbx\\�Т�VU3ȹ�Ye���Ŗ)��h��(�2��Jtn4�ň�x9Qe�O����&Ye��������l����,QEbF�h�l��5f��N�2LL��1c��69����bWr��Q�}W5߃�3\"�ŔQC�(�c�)\Z���e�H��BF�H�c�&FF�y!ev���#��Ժ�>��!3NDd.*%fH�\'1̲x�E����P�l6\r��W��.�ŊBf�����f���&C��K�ԗ%��y��9�r\"�.3Y\Z�sd3e����6�\n&�iC>K��ϩc�f��N�����!Ȳ(��c���$=G�/U��Hә		�qf�5RXB�,�^h�4\"�9+Po���G��X�e�^,��p����P�B��蟃�M�#�pf��u!��,ӑ�111s�F�:���G�Q����s5�M]M̑by��}.�E��3q������qdz��!73Lh�6�MI\Z�ő�L�_ȵ�MF�)�?Y�4��E���X�؂ <Kȱ,��)�����c��f���#S�7���o,r��ℚ!���b��Y�����r���z�������d��K���� .r5�3[Ȉ��1b$H�2�n�2z�\ry�N8�Ƅw3GH�8|�9ϰ��|4�=%BN\"dḕ�ZƢ�Kt\rE4j���-�K��&D��2\"�#]t5��$,G�<éD1C�>�s>�}Q�F�~|Fhx\\~D.$�X��I3��.0�a�5��I\Z�qd5+�-548�6}�o����\r�iȋ#ɚ��m#h�Ԛ�,EԄ��>��Jy��E��\ZR�#�kZDe�~��F����q�\r8�e�E�����D56�\"Q�K���%��)�r#��HՁ(�����\"Kɥ+D��.��<��.��P�,3�k4�[Byx����F$ %ʏ���hs~��i���\"!qf�&�ȓ4�����i2b�j/�b%������4^!�rc�]�_�$�MF�/��\0#\0\0\0\0\0 !1A0@QaqP����\0\0?!�{d�X �� ��e�Y���xnټ��>�jc� �Ye�Y$d�(��$��e�Y$/�,�I$�����6�RD�&\0X�@�,��,��9�Y��3�/{-�c����&x���!z#�dK��im��=�e�Y\'��,�I$I\'M�2p&o16H�\0Ƞ�,�,��,�,�Iձ�_�\rx�x�Y�=��{�Nby;��Kܒg��B�\0��cK��Y$���\'�$�6R\0Y���\0���Ae�Y��&�d�L�w���/f�\"�YgdY���#�o��Y�a,�z�N�\'��6I$�LbZ��>���\0D,�,��<G$��1�������|>�0�m����I�^Y$�\\=O�3�Z̮\\��ps,�$�I$&3[(��~���� �<F�$���m�CNZ8l�[l6�m��0�\r��\0�a\'�i�2�Xwx�|_��s,�K$�I�TIc�Л���,��,��&܍B]^�H>���a��pB���]�x��I>��xr����W�>�%�Y��Y$��,Њ����e�8a�\0�`��) �\r�G����a�X{�L��?|{7�/�[��Y�px�Il_��\0��I�l���>�p{_�?�ȏM��L�Oa�`Fݰ�9�/���+c��m��=;G��Ӂ�m���;������V��q\r���I%��|�/���@���z\r��&��		��\0���?�ݛ=���/�V��?��?V�\r�\0��r\'��z��a�a��|^	d��=FR-��\'�m�f��?�~i�|Lc����\0x�,�������g�}G[?oE�����m�x�m�������#�g���ea�|�� �k$������N��g�\"���ܥٟ\\�G�G#�S7�1��\"0�0�>��|3����|����V;^FI�d�I�ZI$8��`�\0��\r�g��NV�C\'ն���m�}�p2�DC�<.[�U�/��x!��>�!�I$�ݒI0o_з-8��p��{��orM��bm��l6�_���!�?��v�fp=Gd�O�,�G�ŒI$�I�I8��OԱ�w�٭n�\0ܾq-��$fy�Ŷ����Q�0Y��DG�x��r8��;\'�����I$�I%�Y$�d �9N���I�؟Y��X�e�^��rADC6�$��ϮǶ}:���VLu/ٙ$�I/�$�0Y��A�\0K?�2&�&V)���3� �AAY�lY$�Id�Y6{����2�\'�&fKӄ��/����X�W�՟�m���\04�m���A{���Ax��m��3ę\'�p�YxIe�s$�3$�1�I9[)�/gق؝�l��m��l�!<r8��\"�m�2��xD�fO����j����3$���-οwQm��<v�q�8i�dAG�iil1E�<�?`od��Ә��;�e��g���Ky�?����8b���XqS��A���!�<v�|F�;+t��r��o���q�w���~u�ǉ�)oK-l�0�<��3&xC>\\�,��DC0���e��m�[^�֦�K7��,��/6����^�k�l^�|�}-H�H���#�b\"\"0�o7�m��m���į���!�|�[̒I�����7��,�}��2�^�8G�b\";��1؄!M���m��m� ���B܅�R���8p��cQղ�}���{[ϸ���r��<-\r�8��OH�P�\'�����[(m�a�.���m� �������[�rg����wm��XF~��a�\0s�\0me{�]fN%�V���1�z�Y{!��x���m��\"a��a��m��m��bh[���~���S�򳞌�P��Yǟ�cd��ޫgIt�nJ�H�ľN&�i��=ym���M�0�l0�m��m�lA�a��J?�������r�ӫ,s���Y���|O�|��a?n���]���,�m����1����lC\r��m���aba�ڗ���ط����Ͷ��r�mm����a>|!	�6�ϧ�ׁj�\0[/w�G�l0�[,6�,m��0��Ղ̼v�/R����*�oN}Y���s�q�^�m��x����?��y�x��o����8����>줞���ۚ7��3�v/|��L�ϵ�:G&Y���u�p1ܳ�{��\"?��l6�|F�J�a�C��a�iz��I�Hl������[���ؽ����\"�A��̾$G�A�l<؏!�7�`�c�h_�\0B��	�V�ɳ&���_w�6��{��V���%�J�X�XF,?�3�DpxY�ωc\r��`7��`/�/y�8ިL���c��?����~����y��\Z\'o��!�p&E���8<,�y����&d����\'�Nٶ�}�=F~�$\'ˋ�0�\'����\0T��Y���\"#�8G�d�2��2Pr*�<z\'U�{���K\"џh��?|	!>z��&�6Y��z#�a����\'�:Y���+��9�r�nt�d؛�es�Y�_��G\0����_�&z<�a��4��?��dp,��&������}���Y�V�>wa�� �\r�i����o��>w&z���u�Xl��+ه���,�	sx0�)�6��O��m��?�z��1臨�~�����aIz �a���\r�j����lǖ�/w���y3��!�������A��q�I���m�c��p�l��[1�!m���H��ɴ�7��0�� �+���G�K��L��\r��9�og�81,��y��1p�_ф=MO/u���՗�CĈ�KNYNtm�	V��^#\r��,���7��b.������N��7�&Z��p��L|I=8�)����m�y�9��ZO����?����{�K�F�Cm�����8ߖ|Ix�8>�a���P���^�g�{}�a��L��h����Ma��\0\"����ɉ��w�\'6<m��Ce1\\�k=��/��\'����V�!��y���Hb\"a��8y4��R	���P�ǂ\"8�^ͥ���\0\rZ��l��/~{o��a�m����Sh�9Џq�!E{���^���\\?���m�Xm�|�&�����\"<Dpm�`�����ߩ��)��2=����x[�0�l0�0�Xz���p��#��Dw��>��e���������6�0�0���oi�/��3�d�A<��o6�e������_7���/6���l0�a��$␏q��#�� ������\\���m��m��|���6�\r��0�0�ą���zg�t����,�/�6d�I��6����o��o��a�m�a��f��=�����\"?�x2�\" ��⤷�\'�8Gm��a�m�|C�rx�D,�B#�\'�\nVV��M�6Ŷ�a�a�&�\r�z�&}����!G��^�Y���\0�C��l6�>��M�RA<A<����C?=��\Z�\0�wy��a�\r�pq�A��=B#������7��S����x��ǉ0�s!%�LG�a?�_J:�|Q�\0v�-��o����m�l>��IdA���F�����H���,^��\0e���e��m�m����C���l_��x�Y`�lA����<���I^i��1�������lsa��a�!�P�R�:x��������P��y�}�[m��a��Cl��%�g`���t<ߗ�6����_��\0e���s,������l=!��!�8���F:Du��3�m�~rG7x$�s,�����a�W�U��G6�a����A�W����\0)E�d��m�\08�0�(x�GC\r���m��Y�Ϸ����t�o�qe�����[e?/��80�\r���?���ξ�萛e�xն�����\0<v�a�����w������?�|7�ǌ,�mS�V������Y�p��a�J�A��|��e�z��!�b��g�Q���|5�\0/m��m�(m��=C�|��m�\r���,���z���/��\0o�|�YO��\0��#�pqo�b:ta��o^,�m�ۑ��#<2�,�\0m�_�DGV9��å��c�,�q���Y$��2�$��\'�?�-��xsxp�����\"#��1��l/Tt����&΄|�O,���m������a��t�xG��|\0�{_rէ��m��͛<V��Yg�ޞdpb\"�m��؈bm�\"<7�yz\'��1�����\0���6�-���;��se����ݶ��#ż��6\'$��)�|�	�������_�Y����H�[m�v�Q6�}[(|���������,#�����>ެ�gm��yg��\0R:Cl�����D&�A��\\V�ݘ�˱dIoi�6��������`�Ϲj�<�\0|Nm��a��m��[l���0�Ûm��ZnI�i`d�������|��޼�6�m��m�:m�:=a��a����1�_p�\"&�������[zo��߾!a���l��l6�m�����0�����-�P��|q���}�R���\"��/So�y�`���?���o6�m�-�Xbb�lGNoa�돉�e�m�r\'���,�=&v[Ć<X��B�V�y��,����m��/a�!�l1�6�y����z�\'1�Ym��\"dK��0�{7���Y���/_�ͷ�\r���zC��q{�����ٟ3��n���/��e����g�%�^�3���|#������_�������>�S� �E��o8�?�e�Y�=x�ϑ�����|6^���|޻ؽ��_�.,��d�ݩ:���HI-��I$���$��8~���#�͈��6A~��=�}�y���\r8fB�i9x^��m�b?�Yd�Y$��\"g������ށ�#�E��������w�l�\r���8�|g|~|�I$�d�K9�I?�ω���Lvp�DYz��^�)e�;�Y|�9�{rb>�e�O����e�Y$�I	�e�Yd��_�X����DDʹ`x%�1\'�i=v\0<���?s!�?�s,�ǈܾ�$$��;�Y	�#���}��#�s,��!�{�	Y�Y����,���K:0ٷ�0qN�;�Ye�,`����s,��\'���9�Ϩv|G��c�~�|tYX���>�N�6��)Ca��c�Y�Y$�Y<�e��:z\'̆���ta�\"�2l�}x��O�,�;�C�F�o�0�1�AY,�CՒI7�=Ye�7�Ä}����چU	��$�s��,��,��,���c�!2Ĉ�Ў(��� �Yd��g,w{g�pr�\'v��8DG�,�#̝��\0�2ϓe�e�\'�m��L�G��L��ggB$�n2I%�A���]t�\'�� ��<z^�_���g�g2� �;>�#���͠�K}�pj~���0�t �%�O��IϓNj�\r��dW���h�\0E��Á̱�D��ߘ,VY$�:�,��,�S�N��rI2u}��,6���P��P�=Y\'2L���7��7����a!}̳m-b|�7�6���Z|��=��^��m�K,�K,��	�p�$�\"�O|�k�=�%�e��2�0��c���|<y�OV�7ݐ_����V[�w噤??��k13�\'=_��6D:�	�Y��}ff�����h�x;a�1t�s�,��\"l���x� �}��NN��0����\"���Ye�t8g �g2y��*۽O�\'��gF^��0�8����H��ݖYe�q=��6Yd�\ry������\\lǗ�x.Ͳ����px��͓��Kb�o�Йx}�����a�C��q�vOR[Ӥ-���S߄�-�#~����L9��2ș�Dx��=���U����|=Ic�H=�����#��L��H,�m����\'_�v���ղ6G��{2}3�og��̄ �p ��xm���6#FA%�a~K�����ba����-��A��85Ҟ	���l�&[�������[n����RY^��|�v|\'���#��8�\r���g�ܶ�0�W�n��o(�w�w��������]m�(z[B1�Y��|Yߖ|HMy�C�[|�c\Z{^�u�/V�e�����0�0��v/w\r�oS^��ݸޖ~����6�a8c���y����^�%���Yo`���m��m��{���1;�Й�l�1�\"b-���c�m�X�8����}�a�,>�5-oLOA��$mOn5�#\'�\"xm��l�&�\Ze��y��d<�&��ɟ[|�0�<1��z�l}�0����ݎ��~��l��<d����a��\"��$���tו�_vS#��O#L���h�qߖ��ǧĆa�|\r�Z���a�Kq�������L=C�����C�=B[ag�j^�B����Y��7�A��1�>��B�}^�pf��Ŷ���3O�����m�a�ǾW�/���z�N+�}���}l;�I1��%|D��e���t�8=�nYcYns>��\0Q����{{H��^��q9i�,Ò�Q�2M�O�O��a�P���/n�v�%8b�}1��������n0�yfތ��R���p�;%����,28�����;��R�[l{��*%k\0�\0�x�K`�~��~��_a�#؈���i����}^��K��G{��{��9-�vI`��dd�ٝ-.G�\0ia1l��c��,���\'�����d�݋&p\0�E���h�׏�rь��Y^�l䡈��te��Si�&�	{#�=F��oVB�g�c�r;g�\0�=�Bv�������m2İ��w�L�&}�z�\0s��K��(e	K{�a2���!Hg�Kݾ���oGie�FŌ-��}Oݥ��b^��\":��e���u�\0���ļ����Dt��7�?<g�<o�����G�L���\0�������?�+�_�6q�X��#��>�>��\'���\0%\0\0\0!1 AQaq0��������\0\0?ׯF7��?->��Ug��F����b\"m�_.��\\�sMN��æL�#�ķ�mz}[����&�_`�nH�	��\'��O����ѝ��\n��w�2�ں��o.D�2���wQ��Q�3�4�[B\r��^ˊ8��t��H��v�/��}u(���)��w�f�\"{`��>/����^�A��X��q�C��|���V�2n��.�ɗ�?�oh��(c�R�nF�G�ԁ/�������j�.��{u��5}[F3�,���ԣ���}��ZvZ��!|���O1���;�����Xޣ\0�i�.�\r�\ZZ11xZ��p�ɩur�Z0K�Z_Wd���<�\\?6�2$\"�v��s�jL\':�m����r��?�� �ҕ��Z1l�Ԓ)��	�i��RL%�>�۫�6�����\r1��!��4z��,/�I\\�����B��\0�08u���эo���/:���7�\07�-��R���oF��\\�La�םn��o	0���f�HO�!�0V�3.~���ר��=��O#�c�~�~������oͦp�07�~OPh�H:\Z�R��8V�os2Gqd	1����N��ʿ<=�RFcA��\00�liL�����d�����\0V�Q\'l�1\\ E+}�w훶&�e����጖�o<�G�����^9?/�����c[�3�m2w���$,C3��-�_�Dؘ�LG����B{d�%�z��˹�Ck�#��[}�}��o����!���Dx5un��3��p:���5�D]:�o��W�p۸`d׀	h�:w{�3������c��/��pܮ������ݻ�x�a�\0�����c=)���_\\�[�~���Y\ZnS^\\f\\1Y]��\0���^U���ey�-�g�\0�/��&�s^.�K����$�����asU�`�PB��\0=�::����^7#���6�G�q<s?gr��Q��<7+�Y���޸�q{q|f)�WI�	�(~�v�#�?��-�8fs�v�s9�wj���kE��\"˝p��.��۠��p����~[��\0�p\\�\0b���]��\"��l�!n\\K��:\\�S\r�E��^�$F�W\"T��m~��뾱5�	������\\�|�=^-�3G���Cnf|�䝵.�����E��\0�:�\Z�������ُf�.�nop�wT���9��1��\0��ݿ����|��A�d�q4�S	��ӝ��\0�����W�灻R�\'��B�imFs�M�׋������j�f���ӴW��v��j��&W�=xZn^�{�\0��\Z�y\'�V�S��`R�d�.>�umBˋpptµz�V�_�xuh����k;�@��kE�����P�$�Z/K�Z�Zqx>�m���y5m�[q��L�F�)�\0�y�q�\'⓴\r��nAz�m���-�tZ7�r7���\Zn/��	�\'i��U��z���xO�w��.̬�Q�i8Kf#�u6ANR��c���L>�O:�Gؐ\r��F���[/���\'�9���3�h�#E�Q�bq���c����&����>ݿ1�x���˪���A�x@&�`	����3�\0KP�S\n[R4���4�����G�*��f�h`Cm��?�\0�Iy�bL�t������iD=.S-����h�\0>Jx�e(�6�FD��`��5ܰp����\"c50�\\����R��Fh_D;������\Z��F8�u�[g��R`53����09F$�#Բ���?��v��\0NP�`�\r�f>!��^�&��d��g�e�O%� ��b/\\#$�t�*�hަ�/��eڋ�ޱ�����s{�\0&3\\�pr�H������B���8^1�[�F⵻y��8Ox��C/I�\"o��@����|ݷT���F����!�˦�g{��ܦ���^��G̃�mkw��-����=��2��n��S�S�Ad�4�x�����&�۝;�ëGl�B�k@^#\0���Ե�f,�s�2s�n�nlfSE�\\�c�o�0��k��?a�\rAd8���;>�n�޲qJm��`�`�f�E��Z�q�7�(���x]J������&$l\\�F�i�1�-��$2�H�2����E�xޱ9K/������ݻs���2�]��\n���#qim��E�&�=bS	����~���2Ѿd�vJ�\0�?J��cc_��[���.�[�:aJV����A�p#�f\r0j�?�y�O#�4m���G�j����F ���&��W+��t�k�����jwt��f���?\'�D�1����1��b]Z�ՈC����d��������/��F�.���\"�\0f�<[M����[��\0u̽��`�|��/Mº�/�Ȝc�\\������r��ܲ�q=�.$;��՚opn-��\"ޢq`��x����M�ap����Fߋ��eڀ��1q�R|Ӯ���c�Avڛ�Ǖ���v�Q��]r�j}��V�ۚO��N8�O��(v�qj�nn0���G�!���Ƙ���w��d�u9N�Bft��Y;���L�\0�	���kW|�qi2��UlKtgz����?q��\0h·�.�j�z���@���t�ŻV�(�M��0��\"�4�\'����4���i���X��������2pN��|�	�F�w{ͦ�\\��\0�)Ἑrޞ��uZ}Z<H�a�F	JQ�Y��d`�������.�������_y���[w-�\0q],ϭ�Ѻwn�����t��.D��\0�9��FnVqk�q�_<�����\"%�#y��V�f�=��\'w\Zg��>Y�Ö�\Zs��ݹ��_9���[m�ڻaR�w,�A���[�ڛ��\0a�ԒNM��c�A$DE�x�A�M�1��\n����jWIj:�[{�C�윂5�?�q��7z��=�E�5�Mֲ�2��*�m�uŹ�|t�k�P��-C�!uja,CD11�E���k.�b)Fm��w(�t�vО ���懎���w���T���y޶�p����	�p?��a�q9��ݻ��tY##z.�����51��JQ��\"D&����DJQj#���vϫ��Tx�-���빻}�S~8��oJ7$\"8����n{�s&r-«O˭��P\\�^�7�����V�V��7�g�a�g�F&�$�L�C#�bc�Q-\'tu��m=�2�=p\\w�\0ه���\'�<�nB{�N�s+��*}1�/�t&��|���CIq�\rۗ7n�7F.r�F�5����5��=b�hu̿���s�Շ����V�F�=Mq%���h�P��j䟶������>�1�Xr�;b4��&߆�8x7��ϩnX��e710%��Q���X�&��A�z�#��{m�K�K�# {� ��1�\0����3P@��7�\Z��8%�x�+x�S\0��!��jI��f?-���6����1D�Hm^�OE�nq\r\\���9N�\Z�p��ˁ��^7du?\080ǁ�Ż�#-�7j��-[�-�r��<l:_%�����i=��v����rB\"<w32�\0��1=Ng���i�\0\0��6�!���FL��\\��jـ��o���j�2��X��f�W����mˆ<O]�-���$2.1wydē���t�����#���7wqm��S)&�b���Cq�N�x΢<Yfrǁg��S�)�dZ��F��뜚�2�Ot�q�]��=�\'��Z�C�$�ۨ�=eӜ.�4K��G���DDxn�\r�\r۷H�&�n���V���g^�o����v�����Y-��cF/\\m�Q�@�1#�F\r���]G��Z���j5�H����ˀ�,���F7�;������5x�f=���v�[𐇄�pZ0va\n�D+��HƧ-��6�m��Dx�#�.�k�Z����e��\"\"Q9`e�۹_X��%v�	��:�%/��S1���.fB�ۜ���!�d���S���n$.�� f3v������7k3VH_M�a.jy�`q������ʛz��j׷E��/���#KfTG�z��kj��;��o�W�����W.	Da��)C���f��oh-���I{v��ĭ˿��kq���F��C��He�p#j�A����gd�#�>\Z�%�J^ om��K���YjŢ�1_��b�Yc��.dA�tL&:����G��ßlُv�s\"�x�n�;�ܸ�ݸ�9c\nPǐ�17���_Ps��ݷ!N$���}��գ�~�K_�����X�7��/̛ۛH��XݹΦmۗ�4�Bfx���]�]�B�~xˣ{��XpD�l�ߥ�\\�c�#��F78���-ӫR����;\\Z��å�r�p>�����M��q�:ԣ�Qq������b`�\"ݻs��3�p�����1���Kna�a�Ȉ�?�n�n�	��O�]�x羭��׏[�B0`2L�a|QNs���n���-������\'�?����I�V�zF���<i�����Ge�p�#l&�(\r�[`��|���Y��px\0�/����q9�����x��:|!\rCx������d�,B�|�&�����B��ː���F�o���ޭx��C;$#գ\rALa\"<K9���\0al��oh�8��ܲ��0����&��M��w6�2\rxA��z1��#D`�<�Ld�ws�q�ͪD^�dˆg[�-��,	���\0\0.d��kT`�Ja��G+����7q�KC>��������n�n]��ݸe��U	��3Rׇ�1�o��z�)�0a`��<Y.��\0�*&)Ӧ�]��F=u\rjz��S�s��n߈���bn<��n�T�0���k�\rA��`��fa)�����\\cx~Z�s�r��s���[��5,ۖq�pD��.�(c�d�n|:���LJV�>�Z�#$1��3���Å�q����7��z����6��Ymۆ�>#wn!�a�!�߭���k��H�\Z��C	u(��2�����l�\0��X��p�����v��p��a���nb�\r�x3v#k[Κ`�Q�W<Z�����:�RÓq��m¾��]KB�Z���p��<�1�&R��q<\\�M�h�Čm�\Z�r������Vl�e#��\r��S�Ik�`0�q��!M�@1,��pdpp���-!j��Z�xpÍn x�ˉE�S`{O[���N�;���8�I%��kְ[��n�m�C�qx�Jr�[��F+��A�,9�_\0I�;�>�#��Y���FDDD8�`�3��w8�Rְ�7�ܣ2�\\2��m��Z�5석!��ӕ�.���\0�<DDD���z��q0��.C�r\"\"#7M�w\'���}.#K�������}����3v���[����dG�.3nX�>숱�7�\"r�p�ֆڵ�^v�9뻗�O��������pլ?�FH�<�DG����LD�3XX�q�qoXFq63�pr�47����L���;MI�Y���kF�~	j2��B�5��!�0���_`C��\\m�w6�nݹÄ��H}�z���y���:�t(7���,/����\"%����!���<V�o� ��\r�q����0�n�V�;Y��Z���v\'�I$�j�\0\r�#��R�`�+x�pYu/,��r��d���f�kkn�����\0n��X�\')����C����ļ��30u���b���s��C�s��v�c�Kf�,|�r��1���2�0�P�r���b�b%8��BT�8�0���q�h�Dtu�rq�����Є�ώ��Ã;����\"%��o���1zFJ&�)F�#\Z��h�n��2zAq����X0����ݲf�|5�xL�լk-�0ͼ7�!ĥ,��G, dT��nׇs�1=̛�R_˝�q��������y�� @D�۟�0�DDg\"h����C�a�fP�v�L;e�..��S�j�r�c�\r��i��������{���g�����\Zηj�[s��\"<ČV\r3�~Y�,��> p��HM�����RF~gWS��\0��k�����p���úc�~k��bdˆos#�q����\n�QI��#�=�\r�0��O���d�=�8��;���wYh9O���ۻsA<\'��6��\0nLjԗR�g!���Bp0[�?�\0���an�Fc��wq��Niݦ\rD6\'��\\�q?���O�n�^�Ȇ�Y-x8��ad!\\��!�nD��%���8�1��l�M��oT�`���?��צG�xB�ݪ�a�M����O @KL��Τչ���:�0ZW�!\nx|d��:����˞��Jy~��:Y�V��jm�[q�٬!����Iu�q�hRA����/��nܲ�,˅�M���|�s�xU&Յa�F�XP���1\\�\0�o�6OP�O�8�ę�w��6���z��b���\'��>&5�g�FY�|�fA�x�(s9�`i��oӴ��-�m�Wl�L@D�p�2��ާ	�85��\Z�	�3�m�rǄ<����a��\n\"!�(q��&�&��<8[�E��`ܴK�9�[�u��Z��v����S��\\#-�q1�Æpy�)���a�0p�C�0�4�z��ۙ�g�:��D4�u��\"6Z8�K_R3Xtc~\Z��[Y8MI��f�2ʼ%����@a�\\��=��#ѐ\\��c�ڟ6���t3m9�j`ժpO���!���uz./�0md0`Ʊ�,7�X���~`�=�9�MDR�D!2�`I�C���Kj$-�=����h���YAqwq� \'�[�|����լ��ZŎ^�\r!��\"e��O����c@�*%)J�q��qb��(�8+�v�T�-͎-��7x��)8�`��3��իPgYG�c��bE�j �#)��:&[v���J\"\0�.���m|��n$�qh�6��p�����CȐZ��5�$�!	&9�ۀ50O8	�\\Ϳ� C�0�W5�K~��2M�;�������?w]��wzKX!f���D�=Rj��|{�f��7\\ ��������`C��J�u�è�ר��Lf֦.�%Z��\\���-K������Z�p7��-Z��l������m\"���+�n9�Q(e7���Cs��2�6�a��j��	���ۙ0�R�N���D����\\(1<f�\'���@�Y�_�%��R|�H����`\"�\\�Yw.�\r�����n�!q��լ$�X5Z��D��{G1�o��<\0ȸ.���o�}_�������!0B00S�C���������QU9K�/(��xI��m1�;\\,�O0l��1��r�]�K;�ׄ_�\ri�g�{�`B�C��!�u/�tK5$��Gw��j!\nCx�ݦ��덦Z�o��Dm�=_ݲ}BX�D �T�p9_�i��#��<$�AF�b)��C77/����q��L�I6���S~\0D��0L�	qţݷn��ok�dkx�$���u��\'�[�����zC�~6�\Z��O���b;m�1�ɴF�l���[G϶��\'i�a$���Ȑ�u�πe�[���IXW�>��/z�n�0� �!��|5�#}Z}`�z5[ٍ��m7w�o�\'�P�N1{�������ŝB�sm�ۖ�n.	��)���K�X則�	�߅�xh	�%�e�}\\���\\%]��M2֝�]���\0�͙k\0�-��C>SK��CК�G)v���#�d�F*���%ٻe{������бvu��\'�ư��1<!������kw}�Xm��qn�L탆 qn�F8�~:��1�x��ę5� �&�A��r��u<ڹ��+�k�_ר��Or��z��Q����ksu����%�v�^��h�m�ao����8�q\'�y~�-���(s�.Q�S���\\[�`�a�d#q��Z-���b���|nN�a�N[m��\r��mZ�����n7���1�>�-[\\n�F��٧��$�;���������k���f���[!����u�:G��9��z����w��I�p�``���wl�v�n!��܁��k�#���E����jy�����d+V� 揀�W��Z�Ui~��mr�Qul���-��鹁��O�8>�{��қ������e��\'�%����~8SP��o����h�Sd�Xs���E�^1�OӨv�766�Nـ�k���_�\\�h^�����ǩC�����#p��\0�z��\'x���\rRrR�5��\0ճ���`x�)ơ:��\r��F��>��{y7�k�O�\r̍߯��\\w��p�=Z�߶�\Z��ۅ�E�W��\\��7�vc��~7Z!V����;%�: u���܄�7ힾц�����p��߾�F���V��8�G�����-����a&׭k6�m�\n� �h�Z�?�#��nm����-XM7[�����۶�����G�O�Ow�-�ܴ�_M������p�N�(�Md��ws2ۄ�C��È]����o�\0���p#Kg����܌7b �w�!��y��x��&k|Z�ֹ���8��������K��}�/���\rOP�8��\0��\\�e�0���s����։�߮y�㶐7�i|!����S�����͕�%��L�x��QjM��l��tU�&E��j]t�E�q�~Z�p��ޥ�Թ��1#>�x��طه��@���I7\"���#w��o�a�K2�t��n�͝[noY;�s�ڃY�dG��e��^3��K]�x���ڶ���wN��N�h�s|Z?�N�gV�812A�E�\r�|0��̆!��rM��H.-����m~�?w�<{��������g�n�-�Q�WWp:�V�=�����Șu3��>$!�\n%Ͻ��o}q4�qn�h�86��^�l��s���s��Ν�?�A�%��}�1yǍ�ڱ���{P?��Ռ\\�/\\?F#������x����q�;Ʀ뽌w�V��rG�vg�G��d:4����[�r8�\"<��TI�	�\\/^Qx\r�,>K�\0|�U�I��oX�+lh��/�{\\�����ٻ�j���|;CԆ����K�7I�ܩ�9�m�܌B�ԝM��V��^�w&�֯vc~�h���(Ի�i�j����0����ɸ�\"�]��-@�l{f��	!��z)\\i�!9��k��mmܻ����p8����It�i���>��qoMA<� �\Z n3�ڧ=��wb%����qqn���qp�{���/����\r���ϗ}gRrl�vjc�z��bXI�V�Z�3�r�V��6<,F[�q0ݨ����3O3[�r��Ef��c���3��71ݩ��۽��:.Ư_�7�|�0�eZ�8��8	��ԇr\r/R�n#�A�����6��wE�ۧ7�V��[#g������\\KMDC��m�.�z����W4��,\\/��#m.#���JƵ��\0Ö�d�\0�����zp4�\\/u�\\��mo�قK�w��Q�:���s�F�\0���Y�z����qlD��|d0��ۆ$ę`Ma��re3�F�\0ه��˄��.��ӻ��<�!�\\ícM�J{�(*e����#�,8o�ɾG�-�F��~������ ���b��ŏ7��R]Ӄ��','¿En qué ciudad naciste?','nose'),(324,'cedula de ciudadania','gerente','julieta','vargas','54984879','calle 15','julieta@gmail.com','$2y$10$jJUQOK9zpNlFlPwU4ayPpecq6s2Oy0Y/BdHNmCXf2dldIArh/4zTi','activo','','¿Cuál es el nombre de tu primera mascota?','tommy');
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

-- Dump completed on 2025-04-09 11:04:50
