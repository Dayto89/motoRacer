-- Volcado de la base de datos `inventariomotoracer`
-- Fecha: 2025-06-12 11:39:17

SET FOREIGN_KEY_CHECKS=0;

-- -----------------------------
-- Estructura de la tabla `accesos`
-- -----------------------------
DROP TABLE IF EXISTS `accesos`;
CREATE TABLE `accesos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(20) NOT NULL,
  `seccion` varchar(100) NOT NULL,
  `sub_seccion` varchar(100) DEFAULT NULL,
  `permitido` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `fk_usuario` (`id_usuario`),
  CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`identificacion`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3052 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------
-- Datos de la tabla `accesos`
-- -----------------------------
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('1','123','PRODUCTO','Crear Producto','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3','123','PRODUCTO','CategorÃ­as','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('4','123','PRODUCTO','UbicaciÃ³n','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('5','123','PRODUCTO','Marca','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('8','123','PROVEEDOR','Lista Proveedor','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('9','123','INVENTARIO','Lista Productos','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('10','123','FACTURA','Ventas','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('11','123','FACTURA','Reportes','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('12','123','USUARIO','InformaciÃ³n','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('13','123','CONFIGURACIÃ“N','Stock','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('14','123','CONFIGURACIÃ“N','GestiÃ³n de Usuarios','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('15','123','CONFIGURACIÃ“N','Copia de Seguridad','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2352','222','PRODUCTO','Crear Producto','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2354','222','PRODUCTO','CategorÃ­as','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2355','222','PRODUCTO','UbicaciÃ³n','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2356','222','PRODUCTO','Marca','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2359','222','PROVEEDOR','Lista Proveedor','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2360','222','INVENTARIO','Lista de Productos','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2361','222','FACTURA','Ventas','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2362','222','FACTURA','Reporte','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2363','222','FACTURA','Lista Clientes','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2364','222','FACTURA','Lista de Notificaciones','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2365','222','USUARIO','InformaciÃ³n','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2629','777','PRODUCTO','crear producto','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2630','777','PRODUCTO','categorÃ­as','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2631','777','PRODUCTO','ubicaciÃ³n','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2632','777','PRODUCTO','marca','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2633','777','PROVEEDOR','lista proveedor','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2634','777','INVENTARIO','lista de productos','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2635','777','FACTURA','ventas','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2636','777','FACTURA','reporte','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2637','777','FACTURA','lista clientes','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2638','777','FACTURA','lista de notificaciones','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2639','777','USUARIO','informaciÃ³n','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2946','1941','PRODUCTO','crear producto','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2947','1941','PRODUCTO','categorias','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2948','1941','PRODUCTO','ubicacion','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2949','1941','PRODUCTO','marca','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2950','1941','PROVEEDOR','lista proveedor','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2951','1941','INVENTARIO','lista productos','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2952','1941','FACTURA','ventas','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2953','1941','FACTURA','reportes','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2954','1941','FACTURA','lista clientes','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2955','1941','FACTURA','lista notificaciones','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('2956','1941','USUARIO','informaciÃ³n','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3040','321','PRODUCTO','Crear Producto','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3041','321','PRODUCTO','Actualizar Producto','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3042','321','PRODUCTO','Categorias','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3043','321','PRODUCTO','Ubicacion','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3044','321','PRODUCTO','Marca','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3045','321','PROVEEDOR','Lista Proveedor','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3046','321','INVENTARIO','Lista de Productos','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3047','321','FACTURA','Ventas','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3048','321','FACTURA','Reportes','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3049','321','FACTURA','Lista Clientes','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3050','321','FACTURA','Lista de Notificaciones','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3051','321','USUARIO','InformaciÃ³n','1');

-- -----------------------------
-- Estructura de la tabla `categoria`
-- -----------------------------
DROP TABLE IF EXISTS `categoria`;
CREATE TABLE `categoria` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=888 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- -----------------------------
-- Datos de la tabla `categoria`
-- -----------------------------
INSERT INTO `categoria` (`codigo`,`nombre`) VALUES ('1','Repuestos');
INSERT INTO `categoria` (`codigo`,`nombre`) VALUES ('2','bateria');
INSERT INTO `categoria` (`codigo`,`nombre`) VALUES ('4','faros');
INSERT INTO `categoria` (`codigo`,`nombre`) VALUES ('5','juego de pastillas de freno');
INSERT INTO `categoria` (`codigo`,`nombre`) VALUES ('6','prueba');
INSERT INTO `categoria` (`codigo`,`nombre`) VALUES ('9','prueba');
INSERT INTO `categoria` (`codigo`,`nombre`) VALUES ('99','CARRO');
INSERT INTO `categoria` (`codigo`,`nombre`) VALUES ('100','hello world');
INSERT INTO `categoria` (`codigo`,`nombre`) VALUES ('123','AKT');
INSERT INTO `categoria` (`codigo`,`nombre`) VALUES ('258','carro');
INSERT INTO `categoria` (`codigo`,`nombre`) VALUES ('564','hola');
INSERT INTO `categoria` (`codigo`,`nombre`) VALUES ('879','xd');
INSERT INTO `categoria` (`codigo`,`nombre`) VALUES ('884','hola mundo ');
INSERT INTO `categoria` (`codigo`,`nombre`) VALUES ('885','soporte');

-- -----------------------------
-- Estructura de la tabla `cliente`
-- -----------------------------
DROP TABLE IF EXISTS `cliente`;
CREATE TABLE `cliente` (
  `codigo` int(20) NOT NULL,
  `identificacion` enum('CC','TI','NIT') NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `telefono` varchar(13) NOT NULL,
  `correo` varchar(45) NOT NULL,
  PRIMARY KEY (`codigo`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- -----------------------------
-- Datos de la tabla `cliente`
-- -----------------------------
INSERT INTO `cliente` (`codigo`,`identificacion`,`nombre`,`apellido`,`telefono`,`correo`) VALUES ('0','CC','prueba','nose','','');
INSERT INTO `cliente` (`codigo`,`identificacion`,`nombre`,`apellido`,`telefono`,`correo`) VALUES ('123','CC','daniel','Leonardo lo','145','danielleonardo@gmail.com');
INSERT INTO `cliente` (`codigo`,`identificacion`,`nombre`,`apellido`,`telefono`,`correo`) VALUES ('147','NIT','EDWIN','Rodriguez','158','edwincastillo@gmail.com');
INSERT INTO `cliente` (`codigo`,`identificacion`,`nombre`,`apellido`,`telefono`,`correo`) VALUES ('258','CC','Nicolas','castillo','147','nicolascastillo@gmail.com');
INSERT INTO `cliente` (`codigo`,`identificacion`,`nombre`,`apellido`,`telefono`,`correo`) VALUES ('789','CC','sandra','rodriguez','98765','sandrarodriguez@gmail.com');
INSERT INTO `cliente` (`codigo`,`identificacion`,`nombre`,`apellido`,`telefono`,`correo`) VALUES ('2222222','CC','Consumidor','Final','12455','consumidorfinal@final.com');
INSERT INTO `cliente` (`codigo`,`identificacion`,`nombre`,`apellido`,`telefono`,`correo`) VALUES ('5646456','CC','karim','perez','4645645','consumidorfinal@final.com');
INSERT INTO `cliente` (`codigo`,`identificacion`,`nombre`,`apellido`,`telefono`,`correo`) VALUES ('74182332','CC','HECTOR','LOPEZ','3102572023','leonardolpc40@gmail.com');
INSERT INTO `cliente` (`codigo`,`identificacion`,`nombre`,`apellido`,`telefono`,`correo`) VALUES ('1014473365','CC','maria','rodriguez','3222248664','msriarodriguez@gmail.com');
INSERT INTO `cliente` (`codigo`,`identificacion`,`nombre`,`apellido`,`telefono`,`correo`) VALUES ('2147483647','CC','leidy','sanchez','3202355067','LADY280H@HOTMAIL.COM');

-- -----------------------------
-- Estructura de la tabla `compra`
-- -----------------------------
DROP TABLE IF EXISTS `compra`;
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

-- -----------------------------
-- Datos de la tabla `compra`
-- -----------------------------

-- -----------------------------
-- Estructura de la tabla `configuracion_stock`
-- -----------------------------
DROP TABLE IF EXISTS `configuracion_stock`;
CREATE TABLE `configuracion_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `min_quantity` int(11) NOT NULL,
  `alarm_time` time DEFAULT NULL,
  `notification_method` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------
-- Datos de la tabla `configuracion_stock`
-- -----------------------------
INSERT INTO `configuracion_stock` (`id`,`min_quantity`,`alarm_time`,`notification_method`) VALUES ('1','5','08:00:00','popup');
INSERT INTO `configuracion_stock` (`id`,`min_quantity`,`alarm_time`,`notification_method`) VALUES ('2','60','09:00:00','both');
INSERT INTO `configuracion_stock` (`id`,`min_quantity`,`alarm_time`,`notification_method`) VALUES ('3','60','13:30:00','both');
INSERT INTO `configuracion_stock` (`id`,`min_quantity`,`alarm_time`,`notification_method`) VALUES ('4','60','07:52:00','both');
INSERT INTO `configuracion_stock` (`id`,`min_quantity`,`alarm_time`,`notification_method`) VALUES ('5','30','03:03:00','both');
INSERT INTO `configuracion_stock` (`id`,`min_quantity`,`alarm_time`,`notification_method`) VALUES ('6','30','03:03:00','both');
INSERT INTO `configuracion_stock` (`id`,`min_quantity`,`alarm_time`,`notification_method`) VALUES ('7','30',NULL,'popup');
INSERT INTO `configuracion_stock` (`id`,`min_quantity`,`alarm_time`,`notification_method`) VALUES ('8','5',NULL,'popup');
INSERT INTO `configuracion_stock` (`id`,`min_quantity`,`alarm_time`,`notification_method`) VALUES ('9','15',NULL,'popup');
INSERT INTO `configuracion_stock` (`id`,`min_quantity`,`alarm_time`,`notification_method`) VALUES ('10','15',NULL,'popup');
INSERT INTO `configuracion_stock` (`id`,`min_quantity`,`alarm_time`,`notification_method`) VALUES ('11','15',NULL,'popup');
INSERT INTO `configuracion_stock` (`id`,`min_quantity`,`alarm_time`,`notification_method`) VALUES ('12','15',NULL,'popup');
INSERT INTO `configuracion_stock` (`id`,`min_quantity`,`alarm_time`,`notification_method`) VALUES ('13','20',NULL,'popup');
INSERT INTO `configuracion_stock` (`id`,`min_quantity`,`alarm_time`,`notification_method`) VALUES ('14','20',NULL,'popup');
INSERT INTO `configuracion_stock` (`id`,`min_quantity`,`alarm_time`,`notification_method`) VALUES ('15','20',NULL,'popup');
INSERT INTO `configuracion_stock` (`id`,`min_quantity`,`alarm_time`,`notification_method`) VALUES ('16','12',NULL,'popup');
INSERT INTO `configuracion_stock` (`id`,`min_quantity`,`alarm_time`,`notification_method`) VALUES ('17','12',NULL,'popup');
INSERT INTO `configuracion_stock` (`id`,`min_quantity`,`alarm_time`,`notification_method`) VALUES ('18','14',NULL,'popup');
INSERT INTO `configuracion_stock` (`id`,`min_quantity`,`alarm_time`,`notification_method`) VALUES ('19','14',NULL,'popup');
INSERT INTO `configuracion_stock` (`id`,`min_quantity`,`alarm_time`,`notification_method`) VALUES ('20','0',NULL,'popup');
INSERT INTO `configuracion_stock` (`id`,`min_quantity`,`alarm_time`,`notification_method`) VALUES ('21','10',NULL,'popup');

-- -----------------------------
-- Estructura de la tabla `factura`
-- -----------------------------
DROP TABLE IF EXISTS `factura`;
CREATE TABLE `factura` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `fechaGeneracion` datetime NOT NULL,
  `Usuario_identificacion` int(11) NOT NULL,
  `nombreUsuario` varchar(1000) NOT NULL,
  `apellidoUsuario` varchar(100) NOT NULL,
  `Cliente_codigo` int(20) NOT NULL,
  `nombreCliente` varchar(100) NOT NULL,
  `apellidoCliente` varchar(100) NOT NULL,
  `telefonoCliente` int(50) NOT NULL,
  `identificacionCliente` int(50) NOT NULL,
  `cambio` int(100) NOT NULL,
  `precioTotal` double NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `observacion` text DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  KEY `fk_Usuario_has_Producto_Usuario1_idx` (`Usuario_identificacion`),
  KEY `fk_Factura_Cliente1_idx` (`Cliente_codigo`),
  CONSTRAINT `fk_Factura_Cliente1_idx` FOREIGN KEY (`Cliente_codigo`) REFERENCES `cliente` (`codigo`),
  CONSTRAINT `fk_Usuario_has_Producto_Usuario1` FOREIGN KEY (`Usuario_identificacion`) REFERENCES `usuario` (`identificacion`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=200 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- -----------------------------
-- Datos de la tabla `factura`
-- -----------------------------
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('17','2025-03-18 14:06:28','123','','','2222222','','','0','0','0','7527','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('18','2025-03-18 14:07:02','123','','','2222222','','','0','0','0','7527','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('19','2025-03-18 14:07:21','123','','','2222222','','','0','0','0','7527','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('20','2025-03-18 19:12:27','123','','','2222222','','','0','0','0','7527','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('21','2025-03-18 19:16:12','123','','','2222222','','','0','0','0','7527','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('22','2025-03-18 19:16:30','123','','','2222222','','','0','0','0','7527','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('23','2025-03-18 19:19:44','123','','','2222222','','','0','0','0','7527','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('24','2025-03-18 19:23:18','123','','','2222222','','','0','0','0','7527','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('25','2025-03-18 19:23:44','123','','','2222222','','','0','0','0','7527','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('26','2025-03-18 19:36:26','123','','','2222222','','','0','0','0','7527','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('27','2025-03-18 19:46:13','123','','','0','','','0','0','0','7527','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('28','2025-03-18 20:01:52','123','','','2222222','','','0','0','0','7527','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('29','2025-03-18 20:49:39','123','','','2222222','','','0','0','0','7527','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('30','2025-03-18 20:54:30','123','','','2222222','','','0','0','0','54949','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('31','2025-03-18 20:58:44','123','','','2222222','','','0','0','0','54949','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('32','2025-03-18 21:01:07','123','','','2222222','','','0','0','0','54949','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('33','2025-03-18 21:09:42','123','','','2222222','','','0','0','0','7527','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('34','2025-03-19 06:12:13','123','','','2222222','','','0','0','0','15054','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('35','2025-03-19 06:13:50','123','','','2222222','','','0','0','0','15054','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('36','2025-03-19 07:21:27','123','','','2222222','','','0','0','0','15054','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('37','2025-03-19 07:26:08','123','','','2222222','','','0','0','0','22581','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('38','2025-03-19 07:39:29','123','','','2222222','','','0','0','0','15054','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('39','2025-03-19 07:58:53','123','','','2222222','','','0','0','0','15054','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('40','2025-03-19 08:00:35','123','','','2222222','','','0','0','0','15054','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('42','2025-03-19 09:07:49','123','','','2222222','','','0','0','0','65254','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('43','2025-03-19 09:11:48','123','','','2222222','','','0','0','0','109898','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('44','2025-03-19 09:30:29','123','','','2222222','','','0','0','0','1561','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('45','2025-03-19 09:31:14','123','','','2222222','','','0','0','0','1561','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('46','2025-03-19 10:34:22','123','','','2222222','','','0','0','0','22581','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('47','2025-03-19 10:44:39','123','','','2222222','','','0','0','0','15054','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('48','2025-03-19 10:46:14','123','','','789','','','0','0','0','8046','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('49','2025-03-19 10:57:39','123','','','2222222','','','0','0','0','22581','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('50','2025-03-19 11:02:49','123','','','2222222','','','0','0','0','650000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('51','2025-03-19 11:06:36','123','','','2222222','','','0','0','0','30108','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('52','2025-03-19 11:12:35','123','','','2222222','','','0','0','0','2682','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('53','2025-03-20 09:54:21','123','','','2222222','','','0','0','0','115212','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('54','2025-03-21 09:51:24','123','','','2222222','','','0','0','0','1561','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('55','2025-03-26 08:17:45','123','','','2222222','','','0','0','0','321321','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('56','2025-03-26 08:17:58','123','','','2222222','','','0','0','0','321321','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('57','2025-03-26 08:18:26','123','','','2222222','','','0','0','0','321321','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('58','2025-03-26 09:16:58','123','','','2222222','','','0','0','0','321321','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('59','2025-03-26 09:26:30','123','','','2222222','','','0','0','0','321321','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('60','2025-03-26 18:40:28','123','','','2222222','','','0','0','0','321321','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('61','2025-03-26 18:48:14','123','','','2222222','','','0','0','0','321321','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('62','2025-03-26 18:59:01','123','','','2222222','','','0','0','0','321321','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('63','2025-03-26 19:08:20','123','','','2222222','','','0','0','0','321321','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('64','2025-03-27 09:02:34','123','','','123','','','0','0','0','185200','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('65','2025-03-28 09:10:47','123','','','2222222','','','0','0','0','321321','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('66','2025-03-28 09:12:02','123','','','2222222','','','0','0','0','321321','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('67','2025-03-28 09:30:16','123','','','2222222','','','0','0','0','321321','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('68','2025-03-28 10:44:57','123','','','2222222','','','0','0','0','321321','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('69','2025-03-28 10:46:19','123','','','2222222','','','0','0','0','321321','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('70','2025-04-07 13:57:17','123','','','0','','','0','0','0','2223','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('71','2025-04-11 09:28:32','123','','','789','','','0','0','0','14708','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('72','2025-04-21 11:37:26','123','','','0','','','0','0','0','6516','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('73','2025-04-23 11:34:17','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('74','2025-04-23 11:34:19','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('75','2025-04-23 11:34:20','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('76','2025-04-23 11:34:21','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('77','2025-04-23 11:34:21','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('78','2025-04-23 11:34:21','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('79','2025-04-23 11:34:21','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('80','2025-04-23 11:34:22','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('81','2025-04-23 11:34:24','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('82','2025-04-23 11:34:24','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('83','2025-04-23 11:34:24','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('84','2025-04-23 11:34:24','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('85','2025-04-23 11:34:24','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('86','2025-04-23 11:34:25','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('87','2025-04-23 11:34:25','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('88','2025-04-23 11:34:25','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('89','2025-04-23 11:34:25','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('90','2025-04-23 11:34:25','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('91','2025-04-23 11:34:26','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('92','2025-04-23 11:34:47','123','','','123','','','0','0','0','652682','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('93','2025-04-23 11:34:50','123','','','123','','','0','0','0','652682','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('94','2025-04-23 11:34:52','123','','','123','','','0','0','0','652682','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('95','2025-04-23 11:34:53','123','','','123','','','0','0','0','652682','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('96','2025-04-23 11:34:53','123','','','123','','','0','0','0','652682','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('97','2025-04-23 11:38:08','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('98','2025-04-23 11:38:08','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('99','2025-04-23 11:38:08','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('100','2025-04-23 11:38:08','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('101','2025-04-23 11:38:09','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('102','2025-04-23 11:38:09','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('103','2025-04-23 11:38:09','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('104','2025-04-23 11:38:09','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('105','2025-04-23 11:38:12','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('106','2025-04-23 11:38:12','123','','','123','','','0','0','0','24575','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('107','2025-04-23 11:38:36','123','','','258','','','0','0','0','650000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('108','2025-04-23 11:38:37','123','','','258','','','0','0','0','650000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('109','2025-04-23 11:38:37','123','','','258','','','0','0','0','650000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('110','2025-04-23 11:38:37','123','','','258','','','0','0','0','650000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('111','2025-04-23 11:38:37','123','','','258','','','0','0','0','650000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('112','2025-04-23 11:38:38','123','','','258','','','0','0','0','650000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('113','2025-04-23 11:38:38','123','','','258','','','0','0','0','650000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('114','2025-04-23 11:38:38','123','','','258','','','0','0','0','650000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('115','2025-04-23 11:38:38','123','','','258','','','0','0','0','650000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('116','2025-04-23 11:38:38','123','','','258','','','0','0','0','650000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('117','2025-04-23 11:38:39','123','','','258','','','0','0','0','650000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('118','2025-04-23 11:38:39','123','','','258','','','0','0','0','650000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('119','2025-04-23 11:41:14','123','','','147','','','0','0','0','109898','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('120','2025-04-23 11:41:15','123','','','147','','','0','0','0','109898','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('121','2025-04-23 11:41:16','123','','','147','','','0','0','0','109898','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('122','2025-04-23 11:41:16','123','','','147','','','0','0','0','109898','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('123','2025-04-23 11:41:16','123','','','147','','','0','0','0','109898','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('124','2025-04-23 11:41:16','123','','','147','','','0','0','0','109898','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('125','2025-04-23 11:41:16','123','','','147','','','0','0','0','109898','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('126','2025-04-23 11:41:16','123','','','147','','','0','0','0','109898','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('127','2025-04-23 11:41:17','123','','','147','','','0','0','0','109898','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('128','2025-04-23 11:41:17','123','','','147','','','0','0','0','109898','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('129','2025-04-23 11:41:17','123','','','147','','','0','0','0','109898','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('130','2025-04-23 11:41:17','123','','','147','','','0','0','0','109898','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('131','2025-04-23 11:41:18','123','','','147','','','0','0','0','109898','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('132','2025-04-23 11:41:18','123','','','147','','','0','0','0','109898','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('133','2025-04-23 11:41:18','123','','','147','','','0','0','0','109898','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('134','2025-04-23 11:41:18','123','','','147','','','0','0','0','109898','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('135','2025-04-23 11:43:36','123','','','147','','','0','0','0','13033','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('136','2025-04-23 11:44:36','123','','','258','','','0','0','0','6516','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('137','2025-04-23 11:44:36','123','','','258','','','0','0','0','6516','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('138','2025-04-23 11:44:36','123','','','258','','','0','0','0','6516','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('139','2025-04-23 11:44:36','123','','','258','','','0','0','0','6516','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('140','2025-04-23 11:44:37','123','','','258','','','0','0','0','6516','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('141','2025-04-23 11:44:37','123','','','258','','','0','0','0','6516','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('142','2025-04-23 11:44:38','123','','','258','','','0','0','0','6516','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('143','2025-04-23 11:45:08','123','','','147','','','0','0','0','2682','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('144','2025-04-24 11:24:36','123','','','789','','','0','0','0','876876','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('145','2025-04-24 11:24:49','123','','','789','','','0','0','0','876876','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('146','2025-04-24 11:31:44','123','','','258','','','0','0','0','876876','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('147','2025-04-29 06:45:18','123','','','258','','','0','0','0','38060','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('148','2025-04-29 06:52:31','123','','','123','','','0','0','0','650000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('149','2025-04-29 06:55:12','123','','','789','','','0','0','0','2682','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('150','2025-04-29 06:57:07','123','','','258','','','0','0','0','7527','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('151','2025-04-29 06:58:34','123','','','258','','','0','0','0','7527','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('152','2025-04-29 06:59:47','123','','','123','','','0','0','0','7527','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('153','2025-04-29 07:00:30','123','','','258','','','0','0','0','7527','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('154','2025-05-05 06:34:54','123','','','123','','','0','0','0','876876','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('155','2025-05-08 06:34:24','123','','','0','','','0','0','0','876876','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('156','2025-05-08 06:35:13','123','','','0','','','0','0','0','876876','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('157','2025-05-08 07:03:40','123','','','0','','','0','0','0','5000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('158','2025-05-09 06:31:58','123','','','258','','','0','0','0','5000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('159','2025-05-09 06:33:20','123','','','147','','','0','0','0','5000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('160','2025-05-09 06:34:02','123','','','123','','','0','0','0','50000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('161','2025-05-15 07:25:01','123','','','0','','','0','0','0','120000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('162','2025-05-15 07:56:20','123','','','0','','','0','0','0','1590','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('163','2025-05-19 08:30:23','123','','','123','','','0','0','0','54949','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('164','2025-05-23 10:16:14','123','','','147','','','0','0','0','6733','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('165','2025-05-27 10:51:21','123','','','789','','','0','0','0','3506','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('166','2025-05-28 11:26:22','123','','','2222222','','','0','0','0','5000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('167','2025-05-29 11:03:09','123','','','123','','','0','0','0','124000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('168','2025-05-29 11:42:16','123','','','789','','','0','0','0','1240','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('169','2025-05-30 07:55:09','123','','','258','','','0','0','0','494984','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('170','2025-05-30 08:19:26','123','','','123','','','0','0','0','1270','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('171','2025-05-30 10:03:30','123','','','0','','','0','0','0','302949','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('172','2025-05-30 10:04:51','123','','','1014473365','','','0','0','0','1240','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('173','2025-06-02 12:22:50','123','','','147','','','0','0','0','1270','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('174','2025-06-02 12:35:12','123','','','123','','','0','0','0','1270000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('175','2025-06-02 19:31:59','123','','','147','','','0','0','0','3631504','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('176','2025-06-02 20:31:11','123','','','0','','','0','0','0','1600000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('177','2025-06-03 07:42:51','123','','','123','','','0','0','0','8191915981','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('178','2025-06-03 08:00:22','123','','','789','','','0','0','0','120000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('179','2025-06-03 11:11:15','123','','','0','','','0','0','0','54949','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('180','2025-06-04 08:06:01','123','','','0','','','0','0','0','1270000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('181','2025-06-04 10:33:47','123','','','0','','','0','0','0','120000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('182','2025-06-04 10:34:13','123','','','2222222','','','0','0','30000','1270000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('183','2025-06-05 06:52:24','123','','','0','','','0','0','0','120000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('184','2025-06-05 06:53:06','123','','','2222222','','','0','0','0','8191915981','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('185','2025-06-05 08:16:34','123','','','0','','','0','0','0','8191915981','0',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('186','2025-06-05 08:23:22','123','','','0','','','0','0','0','210000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('187','2025-06-05 08:24:31','123','','','5646456','','','0','0','0','3720000','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('188','2025-06-05 11:40:20','123','Daniel','Lopez','2222222','Consumidor','Final','12455','2222222','0','8191915981','0',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('189','2025-06-05 18:04:38','123','Daniel','Lopez','789','sandra','rodriguez','98765','789','0','8191915981','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('190','2025-06-05 18:54:08','123','Daniel','Lopez','5646456','karim','perez','4645645','5646456','0','8191915981','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('191','2025-06-05 23:22:46','123','Daniel','Lopez','0','','','0','0','2201825','2201825','0',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('192','2025-06-05 23:26:00','123','Daniel','Lopez','0','karim','perez','4645645','0','2147483647','16390262111','0',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('193','2025-06-07 12:45:18','123','Daniel','Lopez','2222222','Consumidor','Final','12455','2222222','0','8192715981','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('194','2025-06-07 12:45:40','123','Daniel','Lopez','2222222','Consumidor','Final','12455','2222222','2147483647','8192715981','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('195','2025-06-07 12:47:31','123','Daniel','Lopez','258','Nicolas','castillo','147','258','2147483647','8191915981','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('196','2025-06-07 12:49:02','123','Daniel','Lopez','258','Nicolas','castillo','147','258','2147483647','8191915981','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('197','2025-06-07 12:49:31','123','Daniel','Lopez','0','HECTOR','LOPEZ','2147483647','74182332','0','8192715981','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('198','2025-06-07 22:35:16','123','Daniel','Lopez','258','Nicolas','castillo','147','258','1345','1345','1',NULL);
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`) VALUES ('199','2025-06-07 23:31:26','123','Daniel','Lopez','5646456','karim','perez','4645645','5646456','1335','1345','1',NULL);

-- -----------------------------
-- Estructura de la tabla `factura_metodo_pago`
-- -----------------------------
DROP TABLE IF EXISTS `factura_metodo_pago`;
CREATE TABLE `factura_metodo_pago` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Factura_codigo` int(11) NOT NULL,
  `metodoPago` enum('tarjeta','efectivo','transferencia') NOT NULL,
  `monto` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Factura_codigo` (`Factura_codigo`),
  CONSTRAINT `factura_metodo_pago_ibfk_1` FOREIGN KEY (`Factura_codigo`) REFERENCES `factura` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=253 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------
-- Datos de la tabla `factura_metodo_pago`
-- -----------------------------
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('29','17','efectivo','5000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('30','17','tarjeta','2527');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('31','18','efectivo','5000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('32','18','tarjeta','2527');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('33','19','efectivo','5000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('34','19','tarjeta','2527');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('35','20','efectivo','5000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('36','20','transferencia','2527');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('37','21','efectivo','5000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('38','21','transferencia','2527');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('39','22','efectivo','5000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('40','22','transferencia','2527');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('41','23','efectivo','5000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('42','23','tarjeta','2527');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('43','24','efectivo','7527');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('44','25','efectivo','7527');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('45','26','efectivo','7527');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('46','27','efectivo','5000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('47','27','transferencia','2527');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('48','28','efectivo','7527');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('49','29','efectivo','7527');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('50','30','efectivo','54949');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('51','31','efectivo','54949');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('52','32','efectivo','54949');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('53','33','efectivo','7527');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('54','34','efectivo','5054');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('55','34','transferencia','10000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('56','35','efectivo','5054');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('57','35','transferencia','5000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('58','35','transferencia','5000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('59','36','efectivo','15054');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('60','37','efectivo','22581');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('61','38','efectivo','15054');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('62','39','efectivo','15054');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('63','40','transferencia','15054');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('65','42','efectivo','65254');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('66','43','efectivo','50000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('67','43','transferencia','59898');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('68','44','efectivo','1561949');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('69','45','efectivo','1561949');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('70','46','efectivo','22581');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('71','47','efectivo','15054');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('72','48','efectivo','8046');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('73','49','efectivo','22581');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('74','50','transferencia','650000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('75','51','efectivo','30108');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('76','52','efectivo','2682');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('77','53','efectivo','115212');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('78','54','efectivo','1561949');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('79','55','efectivo','321321');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('80','56','efectivo','321321');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('81','57','efectivo','321321');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('82','58','efectivo','321321');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('83','59','efectivo','321321');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('84','60','efectivo','321321');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('85','61','efectivo','321321');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('86','62','efectivo','321321');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('87','63','efectivo','321321');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('88','64','efectivo','185200');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('89','65','efectivo','321321');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('90','66','efectivo','321321');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('91','67','efectivo','321321');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('92','68','efectivo','321321');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('93','69','efectivo','321321');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('94','70','efectivo','2223123');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('95','71','efectivo','14708487446');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('96','72','efectivo','100000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('97','72','transferencia','6516471465');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('98','73','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('99','74','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('100','75','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('101','76','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('102','77','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('103','78','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('104','79','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('105','80','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('106','81','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('107','82','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('108','83','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('109','84','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('110','85','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('111','86','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('112','87','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('113','88','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('114','89','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('115','90','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('116','91','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('117','92','efectivo','30000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('118','92','tarjeta','622682');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('119','93','efectivo','30000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('120','93','tarjeta','622682');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('121','94','efectivo','30000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('122','94','tarjeta','622682');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('123','95','efectivo','30000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('124','95','tarjeta','622682');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('125','96','efectivo','30000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('126','96','tarjeta','622682');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('127','97','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('128','98','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('129','99','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('130','100','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('131','101','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('132','102','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('133','103','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('134','104','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('135','105','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('136','106','efectivo','24575747943');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('137','107','efectivo','50000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('138','107','tarjeta','600000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('139','108','efectivo','50000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('140','108','tarjeta','600000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('141','109','efectivo','50000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('142','109','tarjeta','600000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('143','110','efectivo','50000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('144','110','tarjeta','600000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('145','111','efectivo','50000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('146','111','tarjeta','600000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('147','112','efectivo','50000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('148','112','tarjeta','600000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('149','113','efectivo','50000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('150','113','tarjeta','600000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('151','114','efectivo','50000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('152','114','tarjeta','600000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('153','115','efectivo','50000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('154','115','tarjeta','600000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('155','116','efectivo','50000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('156','116','tarjeta','600000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('157','117','efectivo','50000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('158','117','tarjeta','600000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('159','118','efectivo','50000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('160','118','tarjeta','600000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('161','119','efectivo','109898');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('162','120','efectivo','109898');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('163','121','efectivo','109898');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('164','122','efectivo','109898');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('165','123','efectivo','109898');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('166','124','efectivo','109898');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('167','125','efectivo','109898');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('168','126','efectivo','109898');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('169','127','efectivo','109898');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('170','128','efectivo','109898');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('171','129','efectivo','109898');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('172','130','efectivo','109898');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('173','131','efectivo','109898');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('174','132','efectivo','109898');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('175','133','efectivo','109898');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('176','134','efectivo','109898');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('177','135','efectivo','13033033032');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('178','136','efectivo','6516516516');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('179','137','efectivo','6516516516');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('180','138','efectivo','6516516516');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('181','139','efectivo','6516516516');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('182','140','efectivo','6516516516');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('183','141','efectivo','6516516516');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('184','142','efectivo','6516516516');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('185','143','efectivo','2682');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('186','144','efectivo','876876');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('187','145','efectivo','876876');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('188','146','efectivo','876876');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('189','147','efectivo','38060636');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('190','148','efectivo','100000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('191','148','tarjeta','550000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('192','149','tarjeta','2682');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('193','150','tarjeta','7527');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('194','151','tarjeta','7527');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('195','152','tarjeta','7527');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('196','153','tarjeta','7527');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('197','154','efectivo','30000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('198','154','tarjeta','846876');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('199','155','efectivo','100000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('200','155','tarjeta','776876');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('201','156','efectivo','100000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('202','156','tarjeta','776876');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('203','157','efectivo','5000000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('204','158','efectivo','5000000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('205','159','efectivo','5000000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('206','160','efectivo','50000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('207','161','efectivo','100000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('208','161','tarjeta','20000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('209','162','efectivo','1590000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('210','163','efectivo','100000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('211','164','efectivo','6733333754');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('212','165','efectivo','3506876');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('213','166','efectivo','50000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('214','166','transferencia','4950000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('215','167','efectivo','124000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('216','168','efectivo','1240000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('217','169','efectivo','494984984');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('218','170','tarjeta','1270000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('219','171','efectivo','50000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('220','171','tarjeta','2000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('221','172','efectivo','1240000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('222','173','efectivo','1270000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('223','174','efectivo','1270000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('224','175','efectivo','100000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('225','175','tarjeta','40000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('226','176','efectivo','30000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('227','176','tarjeta','1503000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('228','176','transferencia','67000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('229','178','tarjeta','120000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('230','179','efectivo','100000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('231','180','efectivo','2000000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('232','181','efectivo','120000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('233','182','efectivo','1300000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('234','183','efectivo','120000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('235','184','efectivo','8191915981');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('236','185','efectivo','8191915981');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('237','186','efectivo','210000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('238','187','efectivo','3720000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('239','188','efectivo','8191915981');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('240','189','efectivo','8191915981');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('241','190','efectivo','8191915981');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('242','191','efectivo','2201825');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('243','192','efectivo','16390262111');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('244','193','transferencia','8192715981');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('245','194','efectivo','8192715981');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('246','195','efectivo','8191915981');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('247','196','efectivo','8191915981');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('248','197','transferencia','8192715981');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('249','198','efectivo','1345');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('250','199','efectivo','1335');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('251','199','','5');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('252','199','transferencia','5');

-- -----------------------------
-- Estructura de la tabla `marca`
-- -----------------------------
DROP TABLE IF EXISTS `marca`;
CREATE TABLE `marca` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2222225 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- -----------------------------
-- Datos de la tabla `marca`
-- -----------------------------
INSERT INTO `marca` (`codigo`,`nombre`) VALUES ('1','akt');
INSERT INTO `marca` (`codigo`,`nombre`) VALUES ('2','yamaha');
INSERT INTO `marca` (`codigo`,`nombre`) VALUES ('3','bajaj');
INSERT INTO `marca` (`codigo`,`nombre`) VALUES ('4','suzuki');
INSERT INTO `marca` (`codigo`,`nombre`) VALUES ('5','honda');
INSERT INTO `marca` (`codigo`,`nombre`) VALUES ('6','ninja');
INSERT INTO `marca` (`codigo`,`nombre`) VALUES ('7','ninja');
INSERT INTO `marca` (`codigo`,`nombre`) VALUES ('8','NKD');

-- -----------------------------
-- Estructura de la tabla `notificaciones`
-- -----------------------------
DROP TABLE IF EXISTS `notificaciones`;
CREATE TABLE `notificaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mensaje` text NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `leida` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1006 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------
-- Datos de la tabla `notificaciones`
-- -----------------------------
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('76','Producto FRENO bajo mÃ­nimo! Stock actual: 25','','2025-04-23 11:34:21','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('77','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:21','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('85','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:21','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('88','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:21','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('89','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:34:21','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('90','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:34:21','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('91','Producto rhefh bajo mÃ­nimo! Stock actual: 52','','2025-04-23 11:34:21','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('92','Producto FRENO bajo mÃ­nimo! Stock actual: 25','','2025-04-23 11:34:21','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('93','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:21','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('94','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -14','','2025-04-23 11:34:21','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('95','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:34:21','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('96','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:21','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('97','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:34:21','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('98','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:34:21','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('99','Producto rhefh bajo mÃ­nimo! Stock actual: 52','','2025-04-23 11:34:21','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('100','Producto FRENO bajo mÃ­nimo! Stock actual: 25','','2025-04-23 11:34:21','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('101','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:21','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('102','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -17','','2025-04-23 11:34:21','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('103','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:34:21','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('104','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:21','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('105','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:34:21','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('106','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:34:21','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('107','Producto rhefh bajo mÃ­nimo! Stock actual: 52','','2025-04-23 11:34:22','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('108','Producto FRENO bajo mÃ­nimo! Stock actual: 25','','2025-04-23 11:34:22','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('109','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:22','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('110','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -20','','2025-04-23 11:34:22','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('111','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:34:22','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('112','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:22','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('113','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:34:22','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('114','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:34:22','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('115','Producto rhefh bajo mÃ­nimo! Stock actual: 52','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('116','Producto FRENO bajo mÃ­nimo! Stock actual: 25','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('117','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('118','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -23','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('119','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('120','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('121','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('122','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('123','Producto rhefh bajo mÃ­nimo! Stock actual: 52','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('124','Producto FRENO bajo mÃ­nimo! Stock actual: 25','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('125','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('126','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -26','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('127','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('128','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('129','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('130','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('131','Producto rhefh bajo mÃ­nimo! Stock actual: 52','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('132','Producto FRENO bajo mÃ­nimo! Stock actual: 25','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('133','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('134','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -29','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('135','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('136','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('137','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('138','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('139','Producto rhefh bajo mÃ­nimo! Stock actual: 52','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('140','Producto FRENO bajo mÃ­nimo! Stock actual: 25','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('141','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('142','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -32','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('143','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('144','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('145','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('146','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('147','Producto rhefh bajo mÃ­nimo! Stock actual: 52','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('148','Producto FRENO bajo mÃ­nimo! Stock actual: 25','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('149','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('150','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -35','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('151','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('152','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('153','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('154','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('155','Producto rhefh bajo mÃ­nimo! Stock actual: 52','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('156','Producto FRENO bajo mÃ­nimo! Stock actual: 25','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('157','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('158','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -38','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('159','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('160','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('161','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('162','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('163','Producto rhefh bajo mÃ­nimo! Stock actual: 52','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('164','Producto FRENO bajo mÃ­nimo! Stock actual: 25','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('165','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('166','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -41','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('167','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('168','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('169','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('170','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('171','Producto rhefh bajo mÃ­nimo! Stock actual: 52','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('172','Producto FRENO bajo mÃ­nimo! Stock actual: 25','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('173','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('174','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -44','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('175','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('176','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('177','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('178','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('179','Producto rhefh bajo mÃ­nimo! Stock actual: 52','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('180','Producto FRENO bajo mÃ­nimo! Stock actual: 25','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('181','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('182','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -47','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('183','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('184','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('185','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('186','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('187','Producto rhefh bajo mÃ­nimo! Stock actual: 52','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('188','Producto FRENO bajo mÃ­nimo! Stock actual: 25','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('189','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('190','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -50','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('191','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('192','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('193','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('194','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:34:25','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('195','Producto rhefh bajo mÃ­nimo! Stock actual: 52','','2025-04-23 11:34:26','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('196','Producto FRENO bajo mÃ­nimo! Stock actual: 25','','2025-04-23 11:34:26','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('197','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:26','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('198','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -53','','2025-04-23 11:34:26','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('199','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:34:26','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('200','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:26','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('201','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:34:26','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('202','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:34:26','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('203','Producto rhefh bajo mÃ­nimo! Stock actual: 51','','2025-04-23 11:34:48','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('204','Producto FRENO bajo mÃ­nimo! Stock actual: 24','','2025-04-23 11:34:48','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('205','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:48','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('206','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -53','','2025-04-23 11:34:48','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('207','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:34:48','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('208','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:48','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('209','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:34:48','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('210','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:34:48','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('211','Producto rhefh bajo mÃ­nimo! Stock actual: 50','','2025-04-23 11:34:50','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('212','Producto FRENO bajo mÃ­nimo! Stock actual: 23','','2025-04-23 11:34:50','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('213','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:50','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('214','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -53','','2025-04-23 11:34:50','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('215','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:34:50','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('216','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:50','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('217','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:34:50','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('218','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:34:50','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('219','Producto rhefh bajo mÃ­nimo! Stock actual: 49','','2025-04-23 11:34:52','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('220','Producto FRENO bajo mÃ­nimo! Stock actual: 22','','2025-04-23 11:34:52','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('221','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:52','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('222','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -53','','2025-04-23 11:34:52','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('223','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:34:52','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('224','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:52','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('225','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:34:52','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('226','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:34:52','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('227','Producto rhefh bajo mÃ­nimo! Stock actual: 48','','2025-04-23 11:34:53','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('228','Producto FRENO bajo mÃ­nimo! Stock actual: 21','','2025-04-23 11:34:53','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('229','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:53','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('230','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -53','','2025-04-23 11:34:53','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('231','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:34:53','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('232','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:53','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('233','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:34:53','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('234','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:34:53','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('235','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:34:53','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('236','Producto FRENO bajo mÃ­nimo! Stock actual: 20','','2025-04-23 11:34:53','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('237','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:53','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('238','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -53','','2025-04-23 11:34:53','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('239','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:34:53','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('240','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:34:53','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('241','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:34:53','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('242','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:34:53','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('243','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('244','Producto FRENO bajo mÃ­nimo! Stock actual: 20','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('245','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('246','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -56','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('247','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('248','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('249','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('250','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('251','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('252','Producto FRENO bajo mÃ­nimo! Stock actual: 20','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('253','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('254','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -59','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('255','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('256','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('257','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('258','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('259','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('260','Producto FRENO bajo mÃ­nimo! Stock actual: 20','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('261','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('262','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -62','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('263','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('264','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('265','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('266','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('267','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('268','Producto FRENO bajo mÃ­nimo! Stock actual: 20','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('269','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('270','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -65','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('271','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('272','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('273','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('274','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:38:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('275','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('276','Producto FRENO bajo mÃ­nimo! Stock actual: 20','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('277','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('278','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -68','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('279','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('280','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('281','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('282','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('283','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('284','Producto FRENO bajo mÃ­nimo! Stock actual: 20','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('285','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('286','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -71','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('287','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('288','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('289','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('290','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('291','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('292','Producto FRENO bajo mÃ­nimo! Stock actual: 20','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('293','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('294','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -74','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('295','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('296','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('297','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('298','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('299','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('300','Producto FRENO bajo mÃ­nimo! Stock actual: 20','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('301','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('302','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -77','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('303','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('304','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('305','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('306','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:38:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('307','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:38:12','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('308','Producto FRENO bajo mÃ­nimo! Stock actual: 20','','2025-04-23 11:38:12','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('309','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:12','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('310','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -80','','2025-04-23 11:38:12','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('311','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:38:12','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('312','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:12','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('313','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:38:12','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('314','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:38:12','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('315','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:38:12','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('316','Producto FRENO bajo mÃ­nimo! Stock actual: 20','','2025-04-23 11:38:12','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('317','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:12','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('318','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:38:12','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('319','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:38:12','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('320','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:12','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('321','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:38:12','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('322','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:38:12','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('323','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:38:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('324','Producto FRENO bajo mÃ­nimo! Stock actual: 19','','2025-04-23 11:38:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('325','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('326','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:38:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('327','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:38:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('328','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('329','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:38:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('330','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:38:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('331','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('332','Producto FRENO bajo mÃ­nimo! Stock actual: 18','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('333','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('334','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('335','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('336','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('337','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('338','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('339','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('340','Producto FRENO bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('341','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('342','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('343','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('344','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('345','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('346','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('347','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('348','Producto FRENO bajo mÃ­nimo! Stock actual: 16','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('349','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('350','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('351','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('352','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('353','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('354','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('355','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('356','Producto FRENO bajo mÃ­nimo! Stock actual: 15','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('357','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('358','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('359','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('360','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('361','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('362','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:38:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('363','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('364','Producto FRENO bajo mÃ­nimo! Stock actual: 14','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('365','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('366','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('367','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('368','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('369','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('370','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('371','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('372','Producto FRENO bajo mÃ­nimo! Stock actual: 13','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('373','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('374','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('375','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('376','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('377','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('378','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('379','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('380','Producto FRENO bajo mÃ­nimo! Stock actual: 12','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('381','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('382','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('383','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('384','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('385','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('386','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('387','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('388','Producto FRENO bajo mÃ­nimo! Stock actual: 11','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('389','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('390','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('391','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('392','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('393','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('394','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('395','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('396','Producto FRENO bajo mÃ­nimo! Stock actual: 10','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('397','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('398','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('399','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('400','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('401','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('402','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:38:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('403','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:38:39','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('404','Producto FRENO bajo mÃ­nimo! Stock actual: 9','','2025-04-23 11:38:39','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('405','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:39','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('406','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:38:39','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('407','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:38:39','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('408','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:39','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('409','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:38:39','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('410','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:38:39','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('411','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:38:39','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('412','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-23 11:38:39','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('413','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:39','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('414','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:38:39','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('415','Producto fhdh bajo mÃ­nimo! Stock actual: 17','','2025-04-23 11:38:39','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('416','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:38:39','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('417','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:38:39','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('418','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:38:39','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('419','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:41:14','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('420','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-23 11:41:14','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('421','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:14','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('422','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:41:14','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('423','Producto fhdh bajo mÃ­nimo! Stock actual: 15','','2025-04-23 11:41:14','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('424','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:14','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('425','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:41:14','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('426','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:41:14','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('427','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:41:15','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('428','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-23 11:41:15','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('429','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:15','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('430','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:41:15','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('431','Producto fhdh bajo mÃ­nimo! Stock actual: 13','','2025-04-23 11:41:15','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('432','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:15','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('433','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:41:15','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('434','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:41:15','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('435','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('436','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('437','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('438','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('439','Producto fhdh bajo mÃ­nimo! Stock actual: 11','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('440','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('441','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('442','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('443','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('444','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('445','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('446','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('447','Producto fhdh bajo mÃ­nimo! Stock actual: 9','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('448','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('449','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('450','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('451','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('452','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('453','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('454','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('455','Producto fhdh bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('456','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('457','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('458','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('459','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('460','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('461','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('462','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('463','Producto fhdh bajo mÃ­nimo! Stock actual: 5','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('464','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('465','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('466','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('467','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('468','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('469','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('470','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('471','Producto fhdh bajo mÃ­nimo! Stock actual: 3','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('472','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('473','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('474','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('475','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('476','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('477','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('478','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('479','Producto fhdh bajo mÃ­nimo! Stock actual: 1','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('480','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('481','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('482','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:41:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('483','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('484','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('485','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('486','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('487','Producto fhdh bajo mÃ­nimo! Stock actual: -1','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('488','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('489','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('490','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('491','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('492','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('493','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('494','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('495','Producto fhdh bajo mÃ­nimo! Stock actual: -3','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('496','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('497','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('498','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('499','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('500','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('501','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('502','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('503','Producto fhdh bajo mÃ­nimo! Stock actual: -5','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('504','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('505','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('506','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('507','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('508','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('509','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('510','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('511','Producto fhdh bajo mÃ­nimo! Stock actual: -7','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('512','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('513','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('514','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:41:17','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('515','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('516','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('517','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('518','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('519','Producto fhdh bajo mÃ­nimo! Stock actual: -9','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('520','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('521','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('522','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('523','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('524','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('525','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('526','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('527','Producto fhdh bajo mÃ­nimo! Stock actual: -11','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('528','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('529','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('530','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('531','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('532','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('533','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('534','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('535','Producto fhdh bajo mÃ­nimo! Stock actual: -13','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('536','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('537','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('538','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('539','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('540','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('541','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('542','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('543','Producto fhdh bajo mÃ­nimo! Stock actual: -15','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('544','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('545','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('546','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:41:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('547','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:43:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('548','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-23 11:43:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('549','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:43:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('550','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:43:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('551','Producto fhdh bajo mÃ­nimo! Stock actual: -15','','2025-04-23 11:43:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('552','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 2','','2025-04-23 11:43:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('553','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:43:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('554','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:43:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('555','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('556','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('557','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('558','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('559','Producto fhdh bajo mÃ­nimo! Stock actual: -15','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('560','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 1','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('561','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('562','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('563','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('564','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('565','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('566','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('567','Producto fhdh bajo mÃ­nimo! Stock actual: -15','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('568','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: 0','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('569','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('570','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('571','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('572','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('573','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('574','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('575','Producto fhdh bajo mÃ­nimo! Stock actual: -15','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('576','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: -1','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('577','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('578','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('579','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('580','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('581','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('582','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('583','Producto fhdh bajo mÃ­nimo! Stock actual: -15','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('584','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: -2','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('585','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('586','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:44:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('587','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:44:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('588','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-23 11:44:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('589','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:44:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('590','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:44:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('591','Producto fhdh bajo mÃ­nimo! Stock actual: -15','','2025-04-23 11:44:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('592','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: -3','','2025-04-23 11:44:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('593','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:44:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('594','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:44:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('595','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:44:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('596','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-23 11:44:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('597','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:44:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('598','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:44:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('599','Producto fhdh bajo mÃ­nimo! Stock actual: -15','','2025-04-23 11:44:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('600','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: -4','','2025-04-23 11:44:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('601','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:44:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('602','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:44:37','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('603','Producto rhefh bajo mÃ­nimo! Stock actual: 47','','2025-04-23 11:44:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('604','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-23 11:44:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('605','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:44:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('606','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:44:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('607','Producto fhdh bajo mÃ­nimo! Stock actual: -15','','2025-04-23 11:44:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('608','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: -5','','2025-04-23 11:44:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('609','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:44:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('610','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:44:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('611','Producto rhefh bajo mÃ­nimo! Stock actual: 46','','2025-04-23 11:45:08','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('612','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-23 11:45:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('613','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-23 11:45:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('614','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-23 11:45:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('615','Producto fhdh bajo mÃ­nimo! Stock actual: -15','','2025-04-23 11:45:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('616','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: -5','','2025-04-23 11:45:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('617','Producto dulce bajo mÃ­nimo! Stock actual: 7','','2025-04-23 11:45:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('618','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-23 11:45:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('619','Producto rhefh bajo mÃ­nimo! Stock actual: 46','','2025-04-24 11:24:36','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('620','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-24 11:24:36','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('621','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-24 11:24:36','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('622','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-24 11:24:36','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('623','Producto fhdh bajo mÃ­nimo! Stock actual: -15','','2025-04-24 11:24:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('624','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: -5','','2025-04-24 11:24:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('625','Producto dulce bajo mÃ­nimo! Stock actual: 6','','2025-04-24 11:24:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('626','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-24 11:24:36','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('627','Producto rhefh bajo mÃ­nimo! Stock actual: 46','','2025-04-24 11:24:49','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('628','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-24 11:24:49','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('629','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-24 11:24:49','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('630','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-24 11:24:49','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('631','Producto fhdh bajo mÃ­nimo! Stock actual: -15','','2025-04-24 11:24:49','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('632','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: -5','','2025-04-24 11:24:49','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('633','Producto dulce bajo mÃ­nimo! Stock actual: 5','','2025-04-24 11:24:49','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('634','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-24 11:24:49','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('635','Producto rhefh bajo mÃ­nimo! Stock actual: 46','','2025-04-24 11:31:44','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('636','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-24 11:31:44','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('637','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 4','','2025-04-24 11:31:44','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('638','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-24 11:31:44','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('639','Producto fhdh bajo mÃ­nimo! Stock actual: -15','','2025-04-24 11:31:44','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('640','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: -5','','2025-04-24 11:31:44','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('641','Producto dulce bajo mÃ­nimo! Stock actual: 4','','2025-04-24 11:31:44','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('642','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-24 11:31:44','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('643','Producto rhefh bajo mÃ­nimo! Stock actual: 46','','2025-04-29 06:45:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('644','Producto FRENO bajo mÃ­nimo! Stock actual: 8','','2025-04-29 06:45:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('645','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 0','','2025-04-29 06:45:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('646','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-29 06:45:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('647','Producto fhdh bajo mÃ­nimo! Stock actual: -15','','2025-04-29 06:45:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('648','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: -5','','2025-04-29 06:45:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('649','Producto dulce bajo mÃ­nimo! Stock actual: 4','','2025-04-29 06:45:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('650','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-29 06:45:18','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('651','Producto rhefh bajo mÃ­nimo! Stock actual: 46','','2025-04-29 06:52:31','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('652','Producto FRENO bajo mÃ­nimo! Stock actual: 7','','2025-04-29 06:52:31','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('653','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 0','','2025-04-29 06:52:31','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('654','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-29 06:52:31','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('655','Producto fhdh bajo mÃ­nimo! Stock actual: -15','','2025-04-29 06:52:31','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('656','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: -5','','2025-04-29 06:52:31','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('657','Producto dulce bajo mÃ­nimo! Stock actual: 4','','2025-04-29 06:52:31','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('658','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-29 06:52:31','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('659','Producto rhefh bajo mÃ­nimo! Stock actual: 45','','2025-04-29 06:55:12','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('660','Producto FRENO bajo mÃ­nimo! Stock actual: 7','','2025-04-29 06:55:12','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('661','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 0','','2025-04-29 06:55:12','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('662','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-29 06:55:12','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('663','Producto fhdh bajo mÃ­nimo! Stock actual: -15','','2025-04-29 06:55:12','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('664','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: -5','','2025-04-29 06:55:12','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('665','Producto dulce bajo mÃ­nimo! Stock actual: 4','','2025-04-29 06:55:12','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('666','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-29 06:55:12','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('667','Producto rhefh bajo mÃ­nimo! Stock actual: 45','','2025-04-29 06:57:07','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('668','Producto FRENO bajo mÃ­nimo! Stock actual: 7','','2025-04-29 06:57:07','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('669','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 0','','2025-04-29 06:57:07','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('670','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-29 06:57:07','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('671','Producto fhdh bajo mÃ­nimo! Stock actual: -15','','2025-04-29 06:57:07','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('672','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: -5','','2025-04-29 06:57:07','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('673','Producto dulce bajo mÃ­nimo! Stock actual: 4','','2025-04-29 06:57:07','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('674','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-29 06:57:07','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('675','Producto rhefh bajo mÃ­nimo! Stock actual: 45','','2025-04-29 06:58:34','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('676','Producto FRENO bajo mÃ­nimo! Stock actual: 7','','2025-04-29 06:58:34','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('677','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 0','','2025-04-29 06:58:34','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('678','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-29 06:58:34','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('679','Producto fhdh bajo mÃ­nimo! Stock actual: -15','','2025-04-29 06:58:34','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('680','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: -5','','2025-04-29 06:58:34','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('681','Producto dulce bajo mÃ­nimo! Stock actual: 4','','2025-04-29 06:58:34','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('682','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-29 06:58:34','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('683','Producto rhefh bajo mÃ­nimo! Stock actual: 45','','2025-04-29 06:59:47','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('684','Producto FRENO bajo mÃ­nimo! Stock actual: 7','','2025-04-29 06:59:47','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('685','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 0','','2025-04-29 06:59:47','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('686','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-29 06:59:47','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('687','Producto fhdh bajo mÃ­nimo! Stock actual: -15','','2025-04-29 06:59:47','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('688','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: -5','','2025-04-29 06:59:47','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('689','Producto dulce bajo mÃ­nimo! Stock actual: 4','','2025-04-29 06:59:47','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('690','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-29 06:59:47','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('691','Producto rhefh bajo mÃ­nimo! Stock actual: 45','','2025-04-29 07:00:30','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('692','Producto FRENO bajo mÃ­nimo! Stock actual: 7','','2025-04-29 07:00:30','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('693','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 0','','2025-04-29 07:00:30','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('694','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-04-29 07:00:30','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('695','Producto fhdh bajo mÃ­nimo! Stock actual: -15','','2025-04-29 07:00:30','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('696','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: -5','','2025-04-29 07:00:30','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('697','Producto dulce bajo mÃ­nimo! Stock actual: 4','','2025-04-29 07:00:30','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('698','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-04-29 07:00:30','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('699','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 0','','2025-05-05 06:34:54','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('700','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-05-05 06:34:54','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('701','Producto fhdh bajo mÃ­nimo! Stock actual: -15','','2025-05-05 06:34:54','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('702','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: -5','','2025-05-05 06:34:54','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('703','Producto dulce bajo mÃ­nimo! Stock actual: 3','','2025-05-05 06:34:55','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('704','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-05-05 06:34:55','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('705','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 0','','2025-05-08 06:34:24','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('706','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-05-08 06:34:24','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('707','Producto fhdh bajo mÃ­nimo! Stock actual: -15','','2025-05-08 06:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('708','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: -5','','2025-05-08 06:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('709','Producto dulce bajo mÃ­nimo! Stock actual: 2','','2025-05-08 06:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('710','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-05-08 06:34:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('711','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 0','','2025-05-08 06:35:13','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('712','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-05-08 06:35:13','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('713','Producto fhdh bajo mÃ­nimo! Stock actual: -15','','2025-05-08 06:35:13','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('714','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: -5','','2025-05-08 06:35:13','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('715','Producto dulce bajo mÃ­nimo! Stock actual: 1','','2025-05-08 06:35:13','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('716','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 45','','2025-05-08 06:35:13','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('717','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 0','','2025-05-08 07:03:40','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('718','Producto pin pastilla freno set xt660 bajo mÃ­nimo! Stock actual: -83','','2025-05-08 07:03:40','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('719','Producto fhdh bajo mÃ­nimo! Stock actual: -15','','2025-05-08 07:03:40','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('720','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: -5','','2025-05-08 07:03:40','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('721','Producto dulce bajo mÃ­nimo! Stock actual: 1','','2025-05-08 07:03:40','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('722','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 44','','2025-05-08 07:03:40','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('723','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 0','','2025-05-09 06:31:58','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('724','Producto fhdh bajo mÃ­nimo! Stock actual: 15','','2025-05-09 06:31:58','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('725','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: -5','','2025-05-09 06:31:58','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('726','Producto dulce bajo mÃ­nimo! Stock actual: 1','','2025-05-09 06:31:58','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('727','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 43','','2025-05-09 06:31:58','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('728','Producto dfg bajo mÃ­nimo! Stock actual: 18','','2025-05-09 06:31:58','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('729','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 0','','2025-05-09 06:33:20','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('730','Producto fhdh bajo mÃ­nimo! Stock actual: 15','','2025-05-09 06:33:20','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('731','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: -5','','2025-05-09 06:33:20','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('732','Producto dulce bajo mÃ­nimo! Stock actual: 1','','2025-05-09 06:33:20','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('733','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 42','','2025-05-09 06:33:20','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('734','Producto dfg bajo mÃ­nimo! Stock actual: 18','','2025-05-09 06:33:20','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('735','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 0','','2025-05-09 06:34:02','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('736','Producto fhdh bajo mÃ­nimo! Stock actual: 15','','2025-05-09 06:34:02','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('737','Producto kit de arrastre cb 190r honda original bajo mÃ­nimo! Stock actual: -5','','2025-05-09 06:34:02','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('738','Producto dulce bajo mÃ­nimo! Stock actual: 1','','2025-05-09 06:34:02','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('739','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 42','','2025-05-09 06:34:02','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('740','Producto dfg bajo mÃ­nimo! Stock actual: 17','','2025-05-09 06:34:02','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('741','Producto bolsas bajo mÃ­nimo! Stock actual: 20','','2025-05-15 07:25:01','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('742','Producto guantes bajo mÃ­nimo! Stock actual: 44','','2025-05-15 07:25:01','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('743','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 0','','2025-05-15 07:25:01','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('744','Producto fhdh bajo mÃ­nimo! Stock actual: 15','','2025-05-15 07:25:01','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('745','Producto dulce bajo mÃ­nimo! Stock actual: 1','','2025-05-15 07:25:01','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('746','Producto cascos bajo mÃ­nimo! Stock actual: 49','','2025-05-15 07:25:01','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('747','Producto maletas bajo mÃ­nimo! Stock actual: 20','','2025-05-15 07:25:01','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('748','Producto vestuario bajo mÃ­nimo! Stock actual: 14','','2025-05-15 07:25:01','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('749','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 42','','2025-05-15 07:25:01','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('750','Producto dfg bajo mÃ­nimo! Stock actual: 17','','2025-05-15 07:25:01','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('751','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-05-15 07:25:01','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('752','Producto bolsas bajo mÃ­nimo! Stock actual: 20','','2025-05-15 07:56:20','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('753','Producto guantes bajo mÃ­nimo! Stock actual: 44','','2025-05-15 07:56:20','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('754','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 0','','2025-05-15 07:56:20','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('755','Producto fhdh bajo mÃ­nimo! Stock actual: 15','','2025-05-15 07:56:20','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('756','Producto dulce bajo mÃ­nimo! Stock actual: 1','','2025-05-15 07:56:20','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('757','Producto cascos bajo mÃ­nimo! Stock actual: 49','','2025-05-15 07:56:20','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('758','Producto maletas bajo mÃ­nimo! Stock actual: 20','','2025-05-15 07:56:20','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('759','Producto vestuario bajo mÃ­nimo! Stock actual: 14','','2025-05-15 07:56:20','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('760','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 42','','2025-05-15 07:56:20','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('761','Producto dfg bajo mÃ­nimo! Stock actual: 17','','2025-05-15 07:56:20','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('762','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-05-15 07:56:20','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('763','Producto Jdlebejsoe bajo mÃ­nimo! Stock actual: 35','','2025-05-15 07:56:20','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('764','Producto bolsas bajo mÃ­nimo! Stock actual: 20','','2025-05-19 08:30:23','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('765','Producto guantes bajo mÃ­nimo! Stock actual: 44','','2025-05-19 08:30:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('766','Producto filtro de aceite fz18 200 bajo mÃ­nimo! Stock actual: 0','','2025-05-19 08:30:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('767','Producto fhdh bajo mÃ­nimo! Stock actual: 14','','2025-05-19 08:30:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('768','Producto dulce bajo mÃ­nimo! Stock actual: 1','','2025-05-19 08:30:23','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('769','Producto cascos bajo mÃ­nimo! Stock actual: 49','','2025-05-19 08:30:23','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('770','Producto maletas bajo mÃ­nimo! Stock actual: 20','','2025-05-19 08:30:23','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('771','Producto vestuario bajo mÃ­nimo! Stock actual: 14','','2025-05-19 08:30:23','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('772','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 42','','2025-05-19 08:30:23','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('773','Producto dfg bajo mÃ­nimo! Stock actual: 17','','2025-05-19 08:30:23','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('774','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-05-19 08:30:23','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('775','Producto Jdlebejsoe bajo mÃ­nimo! Stock actual: 35','','2025-05-19 08:30:23','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('776','Producto bolsas bajo mÃ­nimo! Stock actual: 20','','2025-05-23 10:16:14','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('777','Producto guantes bajo mÃ­nimo! Stock actual: 44','','2025-05-23 10:16:14','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('778','Producto fhdh bajo mÃ­nimo! Stock actual: 14','','2025-05-23 10:16:14','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('779','Producto dulce bajo mÃ­nimo! Stock actual: 1','','2025-05-23 10:16:14','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('780','Producto cascos bajo mÃ­nimo! Stock actual: 48','','2025-05-23 10:16:14','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('781','Producto maletas bajo mÃ­nimo! Stock actual: 19','','2025-05-23 10:16:14','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('782','Producto vestuario bajo mÃ­nimo! Stock actual: 14','','2025-05-23 10:16:14','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('783','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 42','','2025-05-23 10:16:14','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('784','Producto dfg bajo mÃ­nimo! Stock actual: 17','','2025-05-23 10:16:14','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('785','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-05-23 10:16:14','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('786','Producto Jdlebejsoe bajo mÃ­nimo! Stock actual: 34','','2025-05-23 10:16:14','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('787','Producto bolsas bajo mÃ­nimo! Stock actual: 20','','2025-05-27 10:51:21','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('788','Producto guantes bajo mÃ­nimo! Stock actual: 44','','2025-05-27 10:51:21','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('789','Producto fhdh bajo mÃ­nimo! Stock actual: 14','','2025-05-27 10:51:21','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('790','Producto dulce bajo mÃ­nimo! Stock actual: 0','','2025-05-27 10:51:21','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('791','Producto cascos bajo mÃ­nimo! Stock actual: 47','','2025-05-27 10:51:21','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('792','Producto maletas bajo mÃ­nimo! Stock actual: 18','','2025-05-27 10:51:21','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('793','Producto vestuario bajo mÃ­nimo! Stock actual: 13','','2025-05-27 10:51:21','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('794','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 42','','2025-05-27 10:51:21','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('795','Producto dfg bajo mÃ­nimo! Stock actual: 17','','2025-05-27 10:51:21','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('796','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-05-27 10:51:21','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('797','Producto Jdlebejsoe bajo mÃ­nimo! Stock actual: 34','','2025-05-27 10:51:21','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('798','Producto bolsas bajo mÃ­nimo! Stock actual: 20','','2025-05-28 11:26:22','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('799','Producto guantes bajo mÃ­nimo! Stock actual: 44','','2025-05-28 11:26:22','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('800','Producto fhdh bajo mÃ­nimo! Stock actual: 14','','2025-05-28 11:26:22','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('801','Producto dulce bajo mÃ­nimo! Stock actual: 5','','2025-05-28 11:26:22','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('802','Producto cascos bajo mÃ­nimo! Stock actual: 47','','2025-05-28 11:26:22','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('803','Producto maletas bajo mÃ­nimo! Stock actual: 18','','2025-05-28 11:26:22','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('804','Producto vestuario bajo mÃ­nimo! Stock actual: 13','','2025-05-28 11:26:22','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('805','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 41','','2025-05-28 11:26:22','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('806','Producto dfg bajo mÃ­nimo! Stock actual: 17','','2025-05-28 11:26:22','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('807','Producto pastillas freno bajo mÃ­nimo! Stock actual: 23','','2025-05-28 11:26:22','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('808','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-05-28 11:26:22','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('809','Producto Jdlebejsoe bajo mÃ­nimo! Stock actual: 34','','2025-05-28 11:26:22','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('810','Producto bolsas bajo mÃ­nimo! Stock actual: 19','','2025-05-29 11:03:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('811','Producto guantes bajo mÃ­nimo! Stock actual: 44','','2025-05-29 11:03:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('812','Producto fhdh bajo mÃ­nimo! Stock actual: 14','','2025-05-29 11:03:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('813','Producto dulce bajo mÃ­nimo! Stock actual: 5','','2025-05-29 11:03:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('814','Producto cascos bajo mÃ­nimo! Stock actual: 47','','2025-05-29 11:03:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('815','Producto maletas bajo mÃ­nimo! Stock actual: 18','','2025-05-29 11:03:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('816','Producto vestuario bajo mÃ­nimo! Stock actual: 13','','2025-05-29 11:03:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('817','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 41','','2025-05-29 11:03:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('818','Producto dfg bajo mÃ­nimo! Stock actual: 17','','2025-05-29 11:03:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('819','Producto pastillas freno bajo mÃ­nimo! Stock actual: 23','','2025-05-29 11:03:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('820','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-05-29 11:03:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('821','Producto Jdlebejsoe bajo mÃ­nimo! Stock actual: 34','','2025-05-29 11:03:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('822','Producto bolsas bajo mÃ­nimo! Stock actual: 19','','2025-05-29 11:42:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('823','Producto guantes bajo mÃ­nimo! Stock actual: 44','','2025-05-29 11:42:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('824','Producto fhdh bajo mÃ­nimo! Stock actual: 14','','2025-05-29 11:42:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('825','Producto dulce bajo mÃ­nimo! Stock actual: 5','','2025-05-29 11:42:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('826','Producto cascos bajo mÃ­nimo! Stock actual: 47','','2025-05-29 11:42:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('827','Producto maletas bajo mÃ­nimo! Stock actual: 18','','2025-05-29 11:42:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('828','Producto vestuario bajo mÃ­nimo! Stock actual: 12','','2025-05-29 11:42:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('829','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 41','','2025-05-29 11:42:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('830','Producto dfg bajo mÃ­nimo! Stock actual: 17','','2025-05-29 11:42:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('831','Producto pastillas freno bajo mÃ­nimo! Stock actual: 23','','2025-05-29 11:42:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('832','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-05-29 11:42:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('833','Producto Jdlebejsoe bajo mÃ­nimo! Stock actual: 34','','2025-05-29 11:42:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('834','Producto bolsas bajo mÃ­nimo! Stock actual: 19','','2025-05-30 07:55:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('835','Producto guantes bajo mÃ­nimo! Stock actual: 44','','2025-05-30 07:55:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('836','Producto fhdh bajo mÃ­nimo! Stock actual: 14','','2025-05-30 07:55:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('837','Producto dulce bajo mÃ­nimo! Stock actual: 5','','2025-05-30 07:55:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('838','Producto cascos bajo mÃ­nimo! Stock actual: 47','','2025-05-30 07:55:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('839','Producto maletas bajo mÃ­nimo! Stock actual: 18','','2025-05-30 07:55:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('840','Producto vestuario bajo mÃ­nimo! Stock actual: 12','','2025-05-30 07:55:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('841','Producto sdgdjhfgj bajo mÃ­nimo! Stock actual: 41','','2025-05-30 07:55:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('842','Producto dfg bajo mÃ­nimo! Stock actual: 17','','2025-05-30 07:55:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('843','Producto pastillas freno bajo mÃ­nimo! Stock actual: 23','','2025-05-30 07:55:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('844','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-05-30 07:55:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('845','Producto Jdlebejsoe bajo mÃ­nimo! Stock actual: 34','','2025-05-30 07:55:09','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('846','Producto bolsas bajo mÃ­nimo! Stock actual: 19','','2025-05-30 08:19:26','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('847','Producto fhdh bajo mÃ­nimo! Stock actual: 14','','2025-05-30 08:19:26','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('848','Producto dulce bajo mÃ­nimo! Stock actual: 5','','2025-05-30 08:19:26','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('849','Producto maletas bajo mÃ­nimo! Stock actual: 17','','2025-05-30 08:19:26','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('850','Producto vestuario bajo mÃ­nimo! Stock actual: 12','','2025-05-30 08:19:26','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('851','Producto dfg bajo mÃ­nimo! Stock actual: 17','','2025-05-30 08:19:26','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('852','Producto pastillas freno bajo mÃ­nimo! Stock actual: 23','','2025-05-30 08:19:26','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('853','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-05-30 08:19:26','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('854','Producto bolsas bajo mÃ­nimo! Stock actual: 17','','2025-05-30 10:03:30','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('855','Producto fhdh bajo mÃ­nimo! Stock actual: 13','','2025-05-30 10:03:30','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('856','Producto dulce bajo mÃ­nimo! Stock actual: 5','','2025-05-30 10:03:30','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('857','Producto maletas bajo mÃ­nimo! Stock actual: 17','','2025-05-30 10:03:30','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('858','Producto vestuario bajo mÃ­nimo! Stock actual: 12','','2025-05-30 10:03:30','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('859','Producto dfg bajo mÃ­nimo! Stock actual: 17','','2025-05-30 10:03:30','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('860','Producto pastillas freno bajo mÃ­nimo! Stock actual: 23','','2025-05-30 10:03:30','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('861','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-05-30 10:03:30','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('862','Producto bolsas bajo mÃ­nimo! Stock actual: 17','','2025-05-30 10:04:51','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('863','Producto fhdh bajo mÃ­nimo! Stock actual: 13','','2025-05-30 10:04:51','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('864','Producto dulce bajo mÃ­nimo! Stock actual: 5','','2025-05-30 10:04:51','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('865','Producto maletas bajo mÃ­nimo! Stock actual: 17','','2025-05-30 10:04:51','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('866','Producto vestuario bajo mÃ­nimo! Stock actual: 11','','2025-05-30 10:04:51','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('867','Producto dfg bajo mÃ­nimo! Stock actual: 17','','2025-05-30 10:04:51','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('868','Producto pastillas freno bajo mÃ­nimo! Stock actual: 23','','2025-05-30 10:04:51','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('869','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-05-30 10:04:51','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('870','Producto fhdh bajo mÃ­nimo! Stock actual: 13','','2025-06-02 12:22:50','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('871','Producto dulce bajo mÃ­nimo! Stock actual: 5','','2025-06-02 12:22:50','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('872','Producto vestuario bajo mÃ­nimo! Stock actual: 11','','2025-06-02 12:22:50','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('873','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-06-02 12:22:50','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('874','Producto fhdh bajo mÃ­nimo! Stock actual: 13','','2025-06-02 12:35:12','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('875','Producto dulce bajo mÃ­nimo! Stock actual: 5','','2025-06-02 12:35:12','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('876','Producto vestuario bajo mÃ­nimo! Stock actual: 11','','2025-06-02 12:35:12','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('877','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-06-02 12:35:12','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('878','Producto fhdh bajo mÃ­nimo! Stock actual: 13','','2025-06-02 19:31:59','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('879','Producto dulce bajo mÃ­nimo! Stock actual: 1','','2025-06-02 19:31:59','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('880','Producto vestuario bajo mÃ­nimo! Stock actual: 11','','2025-06-02 19:31:59','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('881','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-06-02 19:31:59','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('882','Producto llantas bajo mÃ­nimo! Stock actual: 8','','2025-06-02 20:31:11','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('883','Producto fhdh bajo mÃ­nimo! Stock actual: 13','','2025-06-02 20:31:11','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('884','Producto dulce bajo mÃ­nimo! Stock actual: 1','','2025-06-02 20:31:11','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('885','Producto vestuario bajo mÃ­nimo! Stock actual: 11','','2025-06-02 20:31:11','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('886','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-06-02 20:31:11','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('887','Producto llantas bajo mÃ­nimo! Stock actual: 8','','2025-06-03 07:42:51','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('888','Producto fhdh bajo mÃ­nimo! Stock actual: 13','','2025-06-03 07:42:51','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('889','Producto dulce bajo mÃ­nimo! Stock actual: 1','','2025-06-03 07:42:51','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('890','Producto vestuario bajo mÃ­nimo! Stock actual: 11','','2025-06-03 07:42:51','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('891','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-06-03 07:42:51','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('892','Producto llantas bajo mÃ­nimo! Stock actual: 8','','2025-06-03 08:00:22','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('893','Producto fhdh bajo mÃ­nimo! Stock actual: 13','','2025-06-03 08:00:22','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('894','Producto dulce bajo mÃ­nimo! Stock actual: 1','','2025-06-03 08:00:22','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('895','Producto vestuario bajo mÃ­nimo! Stock actual: 11','','2025-06-03 08:00:22','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('896','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-06-03 08:00:22','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('897','Producto llantas bajo mÃ­nimo! Stock actual: 8','','2025-06-03 11:11:15','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('898','Producto fhdh bajo mÃ­nimo! Stock actual: 12','','2025-06-03 11:11:15','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('899','Producto dulce bajo mÃ­nimo! Stock actual: 1','','2025-06-03 11:11:15','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('900','Producto vestuario bajo mÃ­nimo! Stock actual: 11','','2025-06-03 11:11:15','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('901','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-06-03 11:11:15','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('902','Producto llantas bajo mÃ­nimo! Stock actual: 8','','2025-06-04 08:06:01','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('903','Producto dulce bajo mÃ­nimo! Stock actual: 1','','2025-06-04 08:06:01','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('904','Producto vestuario bajo mÃ­nimo! Stock actual: 11','','2025-06-04 08:06:01','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('905','Producto llantas bajo mÃ­nimo! Stock actual: 8','','2025-06-04 10:33:47','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('906','Producto fhdh bajo mÃ­nimo! Stock actual: 12','','2025-06-04 10:33:47','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('907','Producto dulce bajo mÃ­nimo! Stock actual: 1','','2025-06-04 10:33:47','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('908','Producto vestuario bajo mÃ­nimo! Stock actual: 11','','2025-06-04 10:33:47','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('909','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-06-04 10:33:47','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('910','Producto llantas bajo mÃ­nimo! Stock actual: 8','','2025-06-04 10:34:13','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('911','Producto fhdh bajo mÃ­nimo! Stock actual: 12','','2025-06-04 10:34:13','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('912','Producto dulce bajo mÃ­nimo! Stock actual: 1','','2025-06-04 10:34:13','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('913','Producto maletas bajo mÃ­nimo! Stock actual: 13','','2025-06-04 10:34:13','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('914','Producto vestuario bajo mÃ­nimo! Stock actual: 11','','2025-06-04 10:34:13','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('915','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-06-04 10:34:13','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('916','Producto llantas bajo mÃ­nimo! Stock actual: 8','','2025-06-05 06:52:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('917','Producto fhdh bajo mÃ­nimo! Stock actual: 12','','2025-06-05 06:52:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('918','Producto dulce bajo mÃ­nimo! Stock actual: 1','','2025-06-05 06:52:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('919','Producto maletas bajo mÃ­nimo! Stock actual: 13','','2025-06-05 06:52:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('920','Producto vestuario bajo mÃ­nimo! Stock actual: 11','','2025-06-05 06:52:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('921','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-06-05 06:52:24','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('922','Producto llantas bajo mÃ­nimo! Stock actual: 8','','2025-06-05 06:53:06','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('923','Producto fhdh bajo mÃ­nimo! Stock actual: 12','','2025-06-05 06:53:06','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('924','Producto dulce bajo mÃ­nimo! Stock actual: 1','','2025-06-05 06:53:06','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('925','Producto maletas bajo mÃ­nimo! Stock actual: 13','','2025-06-05 06:53:06','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('926','Producto vestuario bajo mÃ­nimo! Stock actual: 11','','2025-06-05 06:53:06','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('927','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-06-05 06:53:06','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('928','Producto llantas bajo mÃ­nimo! Stock actual: 8','','2025-06-05 08:16:34','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('929','Producto fhdh bajo mÃ­nimo! Stock actual: 12','','2025-06-05 08:16:34','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('930','Producto dulce bajo mÃ­nimo! Stock actual: 1','','2025-06-05 08:16:34','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('931','Producto maletas bajo mÃ­nimo! Stock actual: 13','','2025-06-05 08:16:34','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('932','Producto vestuario bajo mÃ­nimo! Stock actual: 11','','2025-06-05 08:16:34','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('933','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-06-05 08:16:34','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('934','Producto llantas bajo mÃ­nimo! Stock actual: 8','','2025-06-05 08:23:22','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('935','Producto fhdh bajo mÃ­nimo! Stock actual: 12','','2025-06-05 08:23:22','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('936','Producto dulce bajo mÃ­nimo! Stock actual: 1','','2025-06-05 08:23:22','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('937','Producto maletas bajo mÃ­nimo! Stock actual: 13','','2025-06-05 08:23:22','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('938','Producto vestuario bajo mÃ­nimo! Stock actual: 11','','2025-06-05 08:23:22','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('939','Producto llantas bajo mÃ­nimo! Stock actual: 0','','2025-06-05 08:23:22','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('940','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-06-05 08:23:22','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('941','Producto llantas bajo mÃ­nimo! Stock actual: 8','','2025-06-05 08:24:31','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('942','Producto fhdh bajo mÃ­nimo! Stock actual: 12','','2025-06-05 08:24:31','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('943','Producto dulce bajo mÃ­nimo! Stock actual: 1','','2025-06-05 08:24:31','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('944','Producto maletas bajo mÃ­nimo! Stock actual: 13','','2025-06-05 08:24:31','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('945','Producto vestuario bajo mÃ­nimo! Stock actual: 8','','2025-06-05 08:24:31','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('946','Producto llantas bajo mÃ­nimo! Stock actual: 0','','2025-06-05 08:24:31','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('947','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-06-05 08:24:31','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('948','Producto llantaskike bajo mÃ­nimo! Stock actual: 8','','2025-06-05 11:40:20','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('949','Producto fhdh bajo mÃ­nimo! Stock actual: 12','','2025-06-05 11:40:20','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('950','Producto dulce bajo mÃ­nimo! Stock actual: 1','','2025-06-05 11:40:20','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('951','Producto maletas bajo mÃ­nimo! Stock actual: 13','','2025-06-05 11:40:20','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('952','Producto vestuario bajo mÃ­nimo! Stock actual: 8','','2025-06-05 11:40:20','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('953','Producto llantas bajo mÃ­nimo! Stock actual: 0','','2025-06-05 11:40:20','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('954','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-06-05 11:40:20','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('955','Producto llantaskike bajo mÃ­nimo! Stock actual: 8','','2025-06-05 18:04:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('956','Producto fhdh bajo mÃ­nimo! Stock actual: 12','','2025-06-05 18:04:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('957','Producto dulce bajo mÃ­nimo! Stock actual: 1','','2025-06-05 18:04:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('958','Producto maletas bajo mÃ­nimo! Stock actual: 13','','2025-06-05 18:04:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('959','Producto vestuario bajo mÃ­nimo! Stock actual: 8','','2025-06-05 18:04:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('960','Producto llantas bajo mÃ­nimo! Stock actual: 0','','2025-06-05 18:04:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('961','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-06-05 18:04:38','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('962','Producto llantaskike bajo mÃ­nimo! Stock actual: 8','color rojo','2025-06-05 18:54:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('963','Producto fhdh bajo mÃ­nimo! Stock actual: 12','fdhdfh','2025-06-05 18:54:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('964','Producto dulce bajo mÃ­nimo! Stock actual: 1','r6utr6utryjtryujty','2025-06-05 18:54:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('965','Producto maletas bajo mÃ­nimo! Stock actual: 13','bonitos','2025-06-05 18:54:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('966','Producto vestuario bajo mÃ­nimo! Stock actual: 8','bonitos','2025-06-05 18:54:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('967','Producto llantas bajo mÃ­nimo! Stock actual: 0','llanta color negro','2025-06-05 18:54:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('968','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-06-05 18:54:08','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('969','Producto llantaskike bajo mÃ­nimo! Stock actual: 8','color rojo','2025-06-05 23:22:46','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('970','Producto fhdh bajo mÃ­nimo! Stock actual: 11','fdhdfh','2025-06-05 23:22:46','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('971','Producto dulce bajo mÃ­nimo! Stock actual: 0','r6utr6utryjtryujty','2025-06-05 23:22:46','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('972','Producto maletas bajo mÃ­nimo! Stock actual: 12','bonitos','2025-06-05 23:22:46','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('973','Producto vestuario bajo mÃ­nimo! Stock actual: 8','bonitos','2025-06-05 23:22:46','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('974','Producto llantas bajo mÃ­nimo! Stock actual: 0','llanta color negro','2025-06-05 23:22:46','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('975','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-06-05 23:22:46','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('976','Producto llantaskike bajo mÃ­nimo! Stock actual: 7','color rojo','2025-06-05 23:26:00','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('977','Producto fhdh bajo mÃ­nimo! Stock actual: 10','fdhdfh','2025-06-05 23:26:00','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('978','Producto dulce bajo mÃ­nimo! Stock actual: 0','r6utr6utryjtryujty','2025-06-05 23:26:00','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('979','Producto maletas bajo mÃ­nimo! Stock actual: 12','bonitos','2025-06-05 23:26:00','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('980','Producto vestuario bajo mÃ­nimo! Stock actual: 8','bonitos','2025-06-05 23:26:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('981','Producto llantas bajo mÃ­nimo! Stock actual: 0','llanta color negro','2025-06-05 23:26:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('982','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','','2025-06-05 23:26:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('983','Producto llantaskike bajo mÃ­nimo! Stock actual: 7','nose','2025-06-07 12:49:02','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('984','Producto fhdh bajo mÃ­nimo! Stock actual: 10','nose','2025-06-07 12:49:02','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('985','Producto dulce bajo mÃ­nimo! Stock actual: 0','nose','2025-06-07 12:49:02','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('986','Producto luz bajo mÃ­nimo! Stock actual: 2','nose','2025-06-07 12:49:02','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('987','Producto maletas bajo mÃ­nimo! Stock actual: 12','nose','2025-06-07 12:49:02','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('988','Producto vestuario bajo mÃ­nimo! Stock actual: 8','nose','2025-06-07 12:49:02','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('989','Producto llantas bajo mÃ­nimo! Stock actual: 0','nose','2025-06-07 12:49:02','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('990','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','nose','2025-06-07 12:49:02','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('991','Producto llantaskike bajo mÃ­nimo! Stock actual: 7','nose','2025-06-07 12:49:31','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('992','Producto fhdh bajo mÃ­nimo! Stock actual: 10','nose','2025-06-07 12:49:31','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('993','Producto dulce bajo mÃ­nimo! Stock actual: 0','nose','2025-06-07 12:49:31','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('994','Producto luz bajo mÃ­nimo! Stock actual: 2','nose','2025-06-07 12:49:31','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('995','Producto maletas bajo mÃ­nimo! Stock actual: 12','nose','2025-06-07 12:49:31','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('996','Producto vestuario bajo mÃ­nimo! Stock actual: 8','nose','2025-06-07 12:49:31','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('997','Producto llantas bajo mÃ­nimo! Stock actual: 0','nose','2025-06-07 12:49:31','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('998','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','nose','2025-06-07 12:49:31','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('999','Producto llantaskike bajo mÃ­nimo! Stock actual: 7','nose','2025-06-07 22:35:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1000','Producto dulce bajo mÃ­nimo! Stock actual: 0','nose','2025-06-07 22:35:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1001','Producto luz bajo mÃ­nimo! Stock actual: 1','nose','2025-06-07 22:35:16','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1003','Producto vestuario bajo mÃ­nimo! Stock actual: 8','nose','2025-06-07 22:35:16','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1004','Producto llantas bajo mÃ­nimo! Stock actual: 0','nose','2025-06-07 22:35:16','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1005','Producto gdxgdxhf bajo mÃ­nimo! Stock actual: 12','nose','2025-06-07 22:35:16','1');

-- -----------------------------
-- Estructura de la tabla `permiso`
-- -----------------------------
DROP TABLE IF EXISTS `permiso`;
CREATE TABLE `permiso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------
-- Datos de la tabla `permiso`
-- -----------------------------
INSERT INTO `permiso` (`id`,`nombre`) VALUES ('1','PRODUCTO');
INSERT INTO `permiso` (`id`,`nombre`) VALUES ('2','Crear Producto');
INSERT INTO `permiso` (`id`,`nombre`) VALUES ('3','Actualizar Producto');
INSERT INTO `permiso` (`id`,`nombre`) VALUES ('4','Categorias');
INSERT INTO `permiso` (`id`,`nombre`) VALUES ('5','Ubicacion');
INSERT INTO `permiso` (`id`,`nombre`) VALUES ('6','Marca');
INSERT INTO `permiso` (`id`,`nombre`) VALUES ('7','PROVEEDOR');
INSERT INTO `permiso` (`id`,`nombre`) VALUES ('8','Crear Proveedor');
INSERT INTO `permiso` (`id`,`nombre`) VALUES ('9','Actualizar Proveedor');
INSERT INTO `permiso` (`id`,`nombre`) VALUES ('10','Lista Proveedor');
INSERT INTO `permiso` (`id`,`nombre`) VALUES ('11','INVENTARIO');
INSERT INTO `permiso` (`id`,`nombre`) VALUES ('12','Lista de Productos');
INSERT INTO `permiso` (`id`,`nombre`) VALUES ('13','FACTURA');
INSERT INTO `permiso` (`id`,`nombre`) VALUES ('14','Venta');
INSERT INTO `permiso` (`id`,`nombre`) VALUES ('15','Reporte');
INSERT INTO `permiso` (`id`,`nombre`) VALUES ('16','USUARIO');
INSERT INTO `permiso` (`id`,`nombre`) VALUES ('17','Informacion');
INSERT INTO `permiso` (`id`,`nombre`) VALUES ('18','CONFIGURACION');
INSERT INTO `permiso` (`id`,`nombre`) VALUES ('19','Stock');
INSERT INTO `permiso` (`id`,`nombre`) VALUES ('20','Gestion de usuarios');
INSERT INTO `permiso` (`id`,`nombre`) VALUES ('21','Personalizacion de Reportes');
INSERT INTO `permiso` (`id`,`nombre`) VALUES ('22','Notificaciones de Stock');
INSERT INTO `permiso` (`id`,`nombre`) VALUES ('23','Frecuencia Automatica de Reportes');

-- -----------------------------
-- Estructura de la tabla `producto`
-- -----------------------------
DROP TABLE IF EXISTS `producto`;
CREATE TABLE `producto` (
  `codigo1` int(11) NOT NULL,
  `codigo2` varchar(200) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `iva` double NOT NULL,
  `precio1` double NOT NULL,
  `precio2` double NOT NULL,
  `precio3` double NOT NULL,
  `cantidad` int(11) NOT NULL,
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

-- -----------------------------
-- Datos de la tabla `producto`
-- -----------------------------
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1','0','Tornillo','19','50000','30000','0','30','885','4','2','10','9298');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('2','0','Tornillo','19','0','0','0','2','885','2','1','3','2147483647');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('3','0','Tornillo','19','50000','30000','0','30','885','4','2','10','9298');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('73','0','Martillo','19','7000','30000','60000','58','2','6','2','1','43534');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('158','12','Prueba','19','12000','124000','147000','34','99','3','2','3','0');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('452','011','BOLSAS','19','12000','124000','147000','15','2','1','1','1','753');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('745','0','pin pastilla freno set xt660','19','860','8191915981','5119191','70','1','2','1','4','9298');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1232','0','bolsas','19','12000','124000','147000','14','2','1','1','1','0');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1234','234','luz','19','1234','1345','13425','30','6','4','1','5','648465165');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1278','1246','maletas','19','120000','1270000','12400000','12','2','2','1','2','9298');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1425','012','maria','19','12000','124000','0','13','9','2','2','3','753');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1472','1234','vestuario','19','147000','1240000','2000000','8','2','2','1','2','753');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1532','2567','PASTILLAS FRENO BEST ','19','18000','15000','10000','50','1','2','1','1','648465165');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1564','0','sdgdjhfgj','18','49494','5000000','4800000','40','5','3','1','3','753');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('12351','12461','Pruebaa','19','15000','15000','230000','12','2','5','2','2','753');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('54154','5652','daniel','19','45114','51455','416474','1','884','1','2','1','9298');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1234556','0','pastillas freno','19','350000','400000','450000','17','123','1','1','2','9298');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('65497868','2147483647','sdfsd','19','647','494984984','681981651','7650','2','2','1','1','45686');

-- -----------------------------
-- Estructura de la tabla `producto_factura`
-- -----------------------------
DROP TABLE IF EXISTS `producto_factura`;
CREATE TABLE `producto_factura` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Factura_codigo` int(11) NOT NULL,
  `Producto_codigo` int(11) NOT NULL,
  `nombreProducto` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precioUnitario` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Factura_codigo` (`Factura_codigo`),
  KEY `producto_factura_ibfk_2` (`Producto_codigo`),
  CONSTRAINT `producto_factura_ibfk_1` FOREIGN KEY (`Factura_codigo`) REFERENCES `factura` (`codigo`),
  CONSTRAINT `producto_factura_ibfk_2` FOREIGN KEY (`Producto_codigo`) REFERENCES `producto` (`codigo1`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=233 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------
-- Datos de la tabla `producto_factura`
-- -----------------------------
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('77','71','745','','1','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('82','73','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('83','74','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('84','75','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('85','76','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('86','77','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('87','78','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('88','79','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('89','80','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('90','81','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('91','82','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('92','83','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('93','84','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('94','85','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('95','86','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('96','87','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('97','88','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('98','89','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('99','90','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('100','91','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('111','97','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('112','98','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('113','99','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('114','100','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('115','101','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('116','102','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('117','103','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('118','104','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('119','105','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('120','106','745','','3','8191');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('171','157','1564','','1','5000');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('172','158','1564','','1','5000');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('173','159','1564','','1','5000');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('179','164','1278','','1','1270');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('182','165','1278','','1','1270');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('183','165','1472','','1','1240');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('185','166','1564','','1','5000');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('187','168','1472','','1','1240');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('188','169','65497868','','1','494984');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('189','170','1278','','1','1270');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('192','172','1472','','1','1240');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('193','173','1278','','1','1270');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('194','174','1278','','1','1270000');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('198','177','745','','1','8191915981');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('201','180','1278','','1','1270000');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('203','182','1278','','1','1270000');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('205','184','745','','1','8191915981');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('206','185','745','','1','8191915981');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('208','187','1472','','3','1240000');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('209','188','745','pin pastilla freno set xt660','1','8191915981');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('210','189','745','pin pastilla freno set xt660','1','8191915981');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('211','190','745','pin pastilla freno set xt660','1','8191915981');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('213','191','1278','maletas','1','1270000');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('215','192','745','pin pastilla freno set xt660','2','8191915981');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('218','192','1532','accesorios','1','1200');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('220','192','1564','sdgdjhfgj','1','5000000');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('223','193','1234556','pastillas freno','2','400000');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('224','193','745','pin pastilla freno set xt660','1','8191915981');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('225','194','1234556','pastillas freno','2','400000');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('226','194','745','pin pastilla freno set xt660','1','8191915981');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('227','195','745','pin pastilla freno set xt660','1','8191915981');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('228','196','745','pin pastilla freno set xt660','1','8191915981');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('229','197','1234556','pastillas freno','2','400000');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('230','197','745','pin pastilla freno set xt660','1','8191915981');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('231','198','1234','luz','1','1345');
INSERT INTO `producto_factura` (`id`,`Factura_codigo`,`Producto_codigo`,`nombreProducto`,`cantidad`,`precioUnitario`) VALUES ('232','199','1234','luz','1','1345');

-- -----------------------------
-- Estructura de la tabla `proveedor`
-- -----------------------------
DROP TABLE IF EXISTS `proveedor`;
CREATE TABLE `proveedor` (
  `nit` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `telefono` varchar(13) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `correo` varchar(45) NOT NULL,
  PRIMARY KEY (`nit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- -----------------------------
-- Datos de la tabla `proveedor`
-- -----------------------------
INSERT INTO `proveedor` (`nit`,`nombre`,`telefono`,`direccion`,`correo`) VALUES ('0','yuyu','hytygj','cra 11 n 19','yuyu');
INSERT INTO `proveedor` (`nit`,`nombre`,`telefono`,`direccion`,`correo`) VALUES ('753','cable','565468','cra 17 n 37 -2 20','iugniug');
INSERT INTO `proveedor` (`nit`,`nombre`,`telefono`,`direccion`,`correo`) VALUES ('789','BWS','651651','cra 16 a n 45 -30','consumidorfinal@final.com');
INSERT INTO `proveedor` (`nit`,`nombre`,`telefono`,`direccion`,`correo`) VALUES ('9298','ninja','8484684','Cra 40 N 6-50','hbbibv');
INSERT INTO `proveedor` (`nit`,`nombre`,`telefono`,`direccion`,`correo`) VALUES ('43534','prueba','35345','cra 16 a n 45 -30','hfghfghfh');
INSERT INTO `proveedor` (`nit`,`nombre`,`telefono`,`direccion`,`correo`) VALUES ('45686','akt','641684684','kunhiuh','ibgiugbiu');
INSERT INTO `proveedor` (`nit`,`nombre`,`telefono`,`direccion`,`correo`) VALUES ('648465165','HONDA','9528161','cra20 n 37 -18','hondapartes@gmail.com');
INSERT INTO `proveedor` (`nit`,`nombre`,`telefono`,`direccion`,`correo`) VALUES ('2147483647','BVJHBVHJ','51651','jhvuhvluvkjhv','nose@nose.com');

-- -----------------------------
-- Estructura de la tabla `ubicacion`
-- -----------------------------
DROP TABLE IF EXISTS `ubicacion`;
CREATE TABLE `ubicacion` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- -----------------------------
-- Datos de la tabla `ubicacion`
-- -----------------------------
INSERT INTO `ubicacion` (`codigo`,`nombre`) VALUES ('1','estanteria 4');
INSERT INTO `ubicacion` (`codigo`,`nombre`) VALUES ('2','pasillo 4 ');
INSERT INTO `ubicacion` (`codigo`,`nombre`) VALUES ('3','cajon 3');
INSERT INTO `ubicacion` (`codigo`,`nombre`) VALUES ('4','columna 23');
INSERT INTO `ubicacion` (`codigo`,`nombre`) VALUES ('5','prueba');
INSERT INTO `ubicacion` (`codigo`,`nombre`) VALUES ('10','PISO 5');

-- -----------------------------
-- Estructura de la tabla `unidadmedida`
-- -----------------------------
DROP TABLE IF EXISTS `unidadmedida`;
CREATE TABLE `unidadmedida` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- -----------------------------
-- Datos de la tabla `unidadmedida`
-- -----------------------------
INSERT INTO `unidadmedida` (`codigo`,`nombre`) VALUES ('1','Generico');
INSERT INTO `unidadmedida` (`codigo`,`nombre`) VALUES ('2','Original');

-- -----------------------------
-- Estructura de la tabla `usuario`
-- -----------------------------
DROP TABLE IF EXISTS `usuario`;
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
  `codigo_recuperacion` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`identificacion`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- -----------------------------
-- Datos de la tabla `usuario`
-- -----------------------------
INSERT INTO `usuario` (`identificacion`,`tipoDocumento`,`rol`,`nombre`,`apellido`,`telefono`,`direccion`,`correo`,`contraseÃ±a`,`estado`,`foto`,`codigo_recuperacion`) VALUES ('123','cedula de ciudadania','administrador','estiven','Lopez','4543545','123','deicy.caro.v@gmail.com','$2y$10$Vfp52DNVcxYASdGsMoWkpOCIAwDlWoqoh7CmesYMr8JJObfZrgN/K','activo','ÿØÿà\0JFIF\0\0\0\0\0\0ÿÛ\0„\0	\Z*#\Z%!1!1)+./.383-7(-.+\n\n\n\r\Z7%%/-7.2277.5-51--+8-5//--755-05,-+5+7/55+5+..+-.7--/ÿÀ\0\0·\"\0ÿÄ\0\0\0\0\0\0\0\0\0\0\0\0\0\0ÿÄ\0A\0\0\0\0\0\0!1AQaq‘¡±Á\"2BRbrÑ#4²áðs’¢Â&6C‚âÿÄ\0\Z\0\0\0\0\0\0\0\0\0\0\0\0\0ÿÄ\0)\0\0\0\0\0\0\0\0\0!1AQÁaá2q‘ÑÿÚ\0\0\0?\0î \0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\Z>šñ§ƒèåZñIÍZ0¾Ùäì›ð½ü€Ý·evXÃc©T“TêBmn£$íèÏ›—«[ûÚõy,ÎR“º½›ÞÖßCªáz©¥K\Z”quéÉ;æŽL×îi/ƒ!™ôJk§D7Ïû\"U%žq¼e+[3\\íÊêÌÉ&ˆ\0\0\0\0\0\0|~)RÀÔ«-¡I÷¨¦þGÎ|O¤˜ŒG•Z•fœ¶Q”²Á=rÆ)Ùió#ki*×o¢ã¤ñÍTƒŸÝRŽoK™\')àÝWÐ­Âhâ#‰«Î1›iFÉ¾ÍÓÄèœ\rR•F¥iVq³Œæ’›ƒZ)[vš–½–3,LCd\02À\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0EzÏÃçèN#ð¨Íë$ÿ\0RTFºÄ›ÿ\0”1ŠnSŠŠŒUÛÍ$´KVb{3Üß«ŽPÄÔ§RSYéÕr9Y©Ãx¥{hÎ·‰ÃÉqWÛIG.UOìÊ|›wÛºÞd#ª®\rRŽ½z‹$ª8B9’m$÷’ä›’Ó°W”¥ô-(ÍYÞ2ú:óoK®ë¦¦»†mÝç„—Nss“rnMe»mýžI++wšPQ¦’äTM\0\0\0\0\0/ÃûNZ›ûPœ}bÑÀ:À©c*T¥:žÎ«Qpmé§Öºæícè}l˜*’ìŒšïi3’uSÀ*®2ñi¸Æ•9[2´¥9+i®‹7¸×mn!:ö—OÅðÛQ¢©ÕtiÒµã¤ –‹M¹k©WÌñUç)æ¼’Š²JKD»w½ûû‹’¬Ý%&ó-%IÛ7>ß¢Uû<—”SyšÕÞîï{7ÎÚy\\§§*™TÓ}»íÛ³2\r{ÃÂÐ”yÊ-z··†c`\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0ÍzZ1úÏnåÍ¿\0<©6êd‹·Þw¹w¿q]:[%ã»~-êÊo\Zt¹ü\\›ø³”§-%õU=ó_ê»ù]Û±ïb6´V&ÓÚˆ™C\nœ¡)Z›n4å%f”edìù[V¼‘³Æáj8)SªEit²Ïºk±û·#©i®­Þíóorå:Õ\"’I$¶Z4¼.¶î<ÿ\0ÆiYµo7:×²õø“:˜ž©ÇûJQmZ÷^_Z2\\¤¬ýÒ+‚®á]Ýé7vßßNê^vkÐ”·¡ÙârkÈÇçª¦\\sŽÞYz\rø½Hã-$¬Òj:&âÕî¥îñ7‘•âšç©e­è\0\0\0Zpo9;Z6Š]ŽÉ·ï^†6\'\0£‹öÐº½ÕHÅµ;j­´“KÄÈ¬­ZW–TÖl×µœw½ôÚÞŒÇÁqU‹„´|¹*‰lãñ¶è…­H˜‹O_Fb\'S0ºð¹ð‰F£KxÊ6ºì×ŸöŠ0øÙJ›§-*§’ImµóÇðµªïÐq<7*3p–öV´üSZKñ|J°8Of¥V¬³T’Y¥¢QŠÚ*Ü—¼n|ÚÑè¿¯Ú[A{ßè—¼È,ábýÞòyŸuö^JÈ¼M€\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0ÄÃ6Ôåe›4•›å—wõ2ÌlF\ZõTãõ—}”—c„Y–w¬¶ü±_¯3¤t¿q\Z‰]ÅÛK]©x÷ÛÞfæýãqÒ_jÓ7õ0¸Ö\"OãeäãÉße-´ï4rq~.SÞ%<vòÚ%¥„ïöZñ·êS95>îÅß©U)Þš{_´¬ð}¥ÛWÃcí1‘I;&¥,É«$û÷½¬HiÖËG.òMÅ.nÛ_ºÖmšŽ\r&±S—ÙË·÷[nÏÃKy›jn)Z¥\'»ßÎO³ûG°ðŒqN4Lzî~>žU¦rL{,B†y(5u,ÍjŸáù>KÄÙF6ŠKe¡M\ZyiÛÕö·»+:jà\0\0\05EK‡OKåY—ŒuýW™SºÖ/Îß©/ÅÉ,,Ü¶Êïáb#A¿d³oeÍøìDZ–Žý~ô˜eRâU©µifdÓ“ò’wø•b8¤ñö¦ãŸG¾«ž­->W1ÌŽ+qhÞ’v^Ô­Âçg½ë‚ÖÜOO¯öÙ›\r\"&ña&Z$HïŒý¥7®ªNMj£-×.VktoèIºmY´›]ŽÚžµËV\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0Ýj1”m%—ƒ4\\w:š†kÞ/[j–Ü´¾ú’žu•Å*ÑÇÓ6¢§¹ZíY½#}û•ùQ–Ø¦1t´§ŽkÝ»3ªbaä—˜Ž*\ri$û“Múº¬Ü¥y7\'Û\'‰LUž—^\r¯Äý§ïëü}×?;ôv®Jõ¦šµã‹ýMÝ:j+D—ÃxÄÑ©ši\'k}+M[Âw$œ?¬ŠñiV§\n‹¶7„¾hípðÛ\Zã´ï_ê¦[Åï6‡QâÔñ\\>5©ÞÏFžñ’Ý>ó<²Ö\0\0\0\0Öñê–Á%÷¤—–­üõJñÖ’^&GX˜ÙÑá4êB×ö™uÖÙ£-mÛô}ç\'Åb\'RwœÜŸ~¾í‘ÆæøvNV4Î«·‡‘\\tÖººt1p{N>¨Éá±SÇA;¤ó.ZýüŽG×?5¡™†âµéÍ8VœmªúM¥äÍX|Ør×%m½JWåÅë5˜wXá ¾Ï«oâ_8µ.™ã¢ÿ\0ˆoóB›øÄÚ`ºÆÄÅþòê.äàýÚ{Žò“ªƒEÑ~“ÓÆS–X¸N6Í	YèùÅ­Ñ½\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0DúÁàÄðøÎ’½Jm»sœéwÝ\'êK\0<Î3q’i­ÓM5â™áÔzÖ¡ÀiÉÅ]UŠ½•í–|ÎWì—`l4êMªp”ÚWj	».×m‘Ü;/î&½áò©Áq±§,’©’’—$í)Jöîø‘¬O¯g²)©ÞÖQm>ôÖwÓz²ÁÊŸFóKÿ\0$å5ùl¢½rÜ––°”0°„U”c¥Ø’².€\0\0\0ë.–n‹IýÙÓ—¾ßî9ÚúmK7E±²ôiüŽ(>¯‹Hªä¯«L>n”F\\¡	ËÖÑ_ÌÎ£_…Pœ¯:4äû\\\"ßÀ\rFœ§QFr“åÛ~Höµ)B«Œâã%£RVi÷£½Æ„)P—³„cdßÑŠ[xo¤|CˆËÚFSS“’©ÚÝõ¶Ò×`$]Ta$ñÕªý˜ÅCÆMßÜ—½,tìú1I8å”³M¦¬îÛµü¬H@\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0ˆu¢ÿ\0é¥þ,-é/•ÎNtÞ¶+Û†P‡mG/òÅ¯÷ë‡`Ýl}:QÞrQðOwä®ü€éÝáÎŸEi}ê³•OXIGý1D««Œ{]ß„u%æS*J¥«(´’ìJ2H­û¢­æÝþÀ\0\0\0\0\05=+ÿ\0¶±?áÏàpã³tû“¢•ÿ\0Xÿ\0šId‘Õ>ØzõßÚjšðŽ¯Þ×¡?5}áß³ð*4­f£y~ik/{6€YÅÿ\0\r/[ƒpÀë¾«Å·§ÅqÃOÁü\njëRšï¿¢v÷ü\0¹Ji%Ø’ô+\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0mÖÕEûV\Z<òÔ~\nñKçèaõS…Rã•*5¬)Ùw9;]y\'ê^ë„âjñ©V7:iFpÕ«+»Ç}Ûägu]ÃêÓ«^U!(\'%5}e{\'¨.#‹ÉZš³z¹;w&’ómjkpxÉGyß3½ÕÛMn²~]tÜ÷áqá½Œ £iF«’mÝ»¦»¬j§Wªà—m*´æ¯á&šgN¢”‹º|ÑQÁ`ñõ89äŽ”dœ“’”ê®jJ:X˜€\0\0\0ëJª]\ZKœªÁ/,Íû‘è^TéMµ¢–nç•7ñDÛ¬®^¼){g<Ò’‹Y“–‰Ùï³Û]MWü.´zM	Î”ã©ÝÎ.*ùmmwÜ®\0‰ÖËƒvWoè¥ÛéwäjñøÉÊ¤eµ;¥ª“}¶ìÝ[¼Éé&S	†œ!5+þñ]5f­·y¡Xn)­<=_Ë9AûôWÆÆ­+Åø®i™$#Ûã.òðùªœš«IFý®JW±*àÞÛþÚrû[},›níçkš\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0;×†møÞ\Z7¸¹CZ“—}—„®cÊrJ¥VöM7å•`ÿ\0…‹Þêúv½X€\0\0\0\0\0\0\0bW§š»]±¢“¹w|gåó?þOñ‹ò¿Š<ÁÍIJI§y=µÛO•üÀÈ\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0`SR7¦ÕítÕÖêý€GÝz“§4Ý£S[­Ô\\RËf½åîtåìê/£«R[w«rùx\Zª]­j|B²Ke8©¯G\"çüˆCE^…UÛ:rƒÿ\0K`K!$ãtÓ]¨ôÐô…b)bêT¯Z2Ì’TéÅ¨BÜõÝ›à\0\0\0\0\0\04<B­IcjE4¡—%ù­›ñÝ¢Œ1Ó­i-ê+Gø£ßÛíÛÇtj¬±õ*ÒÆT§ÝÂPH\'d´NÖØ±Äžß/Å*sOÑ;\'¡‰„þ¬“îæ¼VèºG¸FåGˆËZ¼«UqÉ¶HF7NÊ7}„„\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0ÿÙ','891215');
INSERT INTO `usuario` (`identificacion`,`tipoDocumento`,`rol`,`nombre`,`apellido`,`telefono`,`direccion`,`correo`,`contraseÃ±a`,`estado`,`foto`,`codigo_recuperacion`) VALUES ('222','cedula de ciudadania','gerente','mariana','castillo','3222231035','cra 11 n 19 - 31','castillorodriguezmariana2@gmail.com','$2y$10$9yq9.LUjO9IDFeQgapOpf.8.3qsAkeBUXT7Jmv3vGM5MKYRD4sHcS','activo','','187048');
INSERT INTO `usuario` (`identificacion`,`tipoDocumento`,`rol`,`nombre`,`apellido`,`telefono`,`direccion`,`correo`,`contraseÃ±a`,`estado`,`foto`,`codigo_recuperacion`) VALUES ('321','cedula de ciudadania','gerente','Marlen','Salcedo','413235','Calle 5','marlen.salcedo.09@gmail.com','$2y$10$YzMHD71DatwGRMBpfL6cOuqf6c4aXzOoIBxZ.ORcQY3gyh24dMk0K','activo','',NULL);
INSERT INTO `usuario` (`identificacion`,`tipoDocumento`,`rol`,`nombre`,`apellido`,`telefono`,`direccion`,`correo`,`contraseÃ±a`,`estado`,`foto`,`codigo_recuperacion`) VALUES ('777','cedula de ciudadania','gerente','Gabriel','Rodriguez','3102659825','sogamoso','mejorarmlg@gmail.com','$2y$10$zJ7lKau1ZEJbLv2SC9GS3um0GhTpH1W6iPDNbbOEs1M3.zxYMwgaK','activo','',NULL);
INSERT INTO `usuario` (`identificacion`,`tipoDocumento`,`rol`,`nombre`,`apellido`,`telefono`,`direccion`,`correo`,`contraseÃ±a`,`estado`,`foto`,`codigo_recuperacion`) VALUES ('1941','cedula de ciudadania','gerente','Daniel','Lopez','3004401797','CRA 16A n 19 - 30','juanperez123@gmail.com','$2y$10$Mi1TySDAzfq6CKzyLqYnXeIDkWZa9tNWRj9KigO5vucA0jir3Itu.','activo','',NULL);

-- -----------------------------
-- Estructura de la tabla `usuario_permiso`
-- -----------------------------
DROP TABLE IF EXISTS `usuario_permiso`;
CREATE TABLE `usuario_permiso` (
  `usuario_id` int(11) NOT NULL,
  `permiso_id` int(11) NOT NULL,
  PRIMARY KEY (`usuario_id`,`permiso_id`),
  KEY `permiso_id` (`permiso_id`),
  CONSTRAINT `usuario_permiso_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`identificacion`),
  CONSTRAINT `usuario_permiso_ibfk_2` FOREIGN KEY (`permiso_id`) REFERENCES `permiso` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------
-- Datos de la tabla `usuario_permiso`
-- -----------------------------

-- -----------------------------
-- Estructura de la tabla `venta`
-- -----------------------------
DROP TABLE IF EXISTS `venta`;
CREATE TABLE `venta` (
  `codigo` int(11) NOT NULL,
  `Usuario_identificacion` int(11) NOT NULL,
  `Producto_codigo` int(11) NOT NULL,
  `Factura_codigo` int(11) NOT NULL,
  PRIMARY KEY (`codigo`),
  UNIQUE KEY `Usuario_identificacion` (`Usuario_identificacion`),
  KEY `fk_Producto_has_Factura_Producto1_idx` (`Producto_codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- -----------------------------
-- Datos de la tabla `venta`
-- -----------------------------

-- -----------------------------
-- Estructura de la tabla `verificaciones`
-- -----------------------------
DROP TABLE IF EXISTS `verificaciones`;
CREATE TABLE `verificaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `correo` varchar(45) NOT NULL,
  `codigo` varchar(6) NOT NULL,
  `fecha_envio` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=210 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------
-- Datos de la tabla `verificaciones`
-- -----------------------------
INSERT INTO `verificaciones` (`id`,`correo`,`codigo`,`fecha_envio`) VALUES ('3','diuejh45','168482','2025-05-28 10:03:38');
INSERT INTO `verificaciones` (`id`,`correo`,`codigo`,`fecha_envio`) VALUES ('4','diuejh45@gmail.com','334895','2025-05-28 10:03:51');
INSERT INTO `verificaciones` (`id`,`correo`,`codigo`,`fecha_envio`) VALUES ('17','danielabron297@gmail.com','376459','2025-05-30 06:13:06');
INSERT INTO `verificaciones` (`id`,`correo`,`codigo`,`fecha_envio`) VALUES ('50','ctskiller89gmailcom','711675','2025-06-04 10:56:08');
INSERT INTO `verificaciones` (`id`,`correo`,`codigo`,`fecha_envio`) VALUES ('51','ctskiller@89gmail.com','710289','2025-06-04 10:59:11');
INSERT INTO `verificaciones` (`id`,`correo`,`codigo`,`fecha_envio`) VALUES ('52','marlen.salcedo.09@gail.com','670445','2025-06-04 11:06:42');
INSERT INTO `verificaciones` (`id`,`correo`,`codigo`,`fecha_envio`) VALUES ('90','danielbaron297@gmail.com','759424','2025-06-06 08:01:05');
INSERT INTO `verificaciones` (`id`,`correo`,`codigo`,`fecha_envio`) VALUES ('120','deicy.cao.v@gmail.com','667401','2025-06-06 21:16:04');
INSERT INTO `verificaciones` (`id`,`correo`,`codigo`,`fecha_envio`) VALUES ('146','alexluqueear@gmail.com','881140','2025-06-07 23:01:05');
INSERT INTO `verificaciones` (`id`,`correo`,`codigo`,`fecha_envio`) VALUES ('204','marlen.salcedo.09@gmail.com','588178','2025-06-12 07:57:16');

SET FOREIGN_KEY_CHECKS=1;
