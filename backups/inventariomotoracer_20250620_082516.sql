-- Volcado de la base de datos `inventariomotoracer`
-- Fecha: 2025-06-20 08:25:16

/*!40101 SET NAMES utf8mb4 */;
/*!40101 SET CHARACTER SET utf8mb4 */;

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
) ENGINE=InnoDB AUTO_INCREMENT=3302 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------
-- Datos de la tabla `accesos`
-- -----------------------------
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('1','123','PRODUCTO','Crear Producto','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3','123','PRODUCTO','Categorias','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('4','123','PRODUCTO','Ubicacion','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('5','123','PRODUCTO','Marca','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('8','123','PROVEEDOR','Lista Proveedor','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('9','123','INVENTARIO','Lista Productos','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('10','123','FACTURA','Ventas','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('11','123','FACTURA','Reportes','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('12','123','USUARIO','InformaciÃ³n','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('13','123','CONFIGURACION','Stock','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('14','123','CONFIGURACION','Gestion de Usuarios','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('15','123','CONFIGURACION','Copia de Seguridad','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('16','123','FACTURA','Lista Clientes','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('17','123','FACTURA','Lista Notificaciones','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3246','222','PRODUCTO','crear producto','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3247','222','PRODUCTO','categorias','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3248','222','PRODUCTO','ubicacion','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3249','222','PRODUCTO','marca','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3250','222','PROVEEDOR','lista proveedor','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3251','222','INVENTARIO','lista productos','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3252','222','FACTURA','ventas','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3253','222','FACTURA','reporte','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3254','222','FACTURA','lista clientes','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3255','222','FACTURA','lista notificaciones','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3256','222','USUARIO','informaciÃ³n','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3279','1941','PRODUCTO','crear producto','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3280','1941','PRODUCTO','categorias','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3281','1941','PRODUCTO','ubicacion','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3282','1941','PRODUCTO','marca','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3283','1941','PROVEEDOR','lista proveedor','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3284','1941','INVENTARIO','lista productos','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3285','1941','FACTURA','ventas','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3286','1941','FACTURA','reportes','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3287','1941','FACTURA','lista clientes','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3288','1941','FACTURA','lista notificaciones','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3289','1941','USUARIO','informaciÃ³n','1');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3290','321','PRODUCTO','crear producto','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3291','321','PRODUCTO','actualizar producto','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3292','321','PRODUCTO','categorias','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3293','321','PRODUCTO','ubicacion','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3294','321','PRODUCTO','marca','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3295','321','PROVEEDOR','lista proveedor','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3296','321','INVENTARIO','lista productos','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3297','321','FACTURA','ventas','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3298','321','FACTURA','reportes','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3299','321','FACTURA','lista clientes','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3300','321','FACTURA','lista notificaciones','0');
INSERT INTO `accesos` (`id`,`id_usuario`,`seccion`,`sub_seccion`,`permitido`) VALUES ('3301','321','USUARIO','informaciÃ³n','1');

-- -----------------------------
-- Estructura de la tabla `categoria`
-- -----------------------------
DROP TABLE IF EXISTS `categoria`;
CREATE TABLE `categoria` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=919 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- -----------------------------
-- Datos de la tabla `categoria`
-- -----------------------------
INSERT INTO `categoria` (`codigo`,`nombre`) VALUES ('903','Clutch');
INSERT INTO `categoria` (`codigo`,`nombre`) VALUES ('904','Cambios');
INSERT INTO `categoria` (`codigo`,`nombre`) VALUES ('905','Frenos');
INSERT INTO `categoria` (`codigo`,`nombre`) VALUES ('906','Motor');
INSERT INTO `categoria` (`codigo`,`nombre`) VALUES ('907','Encendido');
INSERT INTO `categoria` (`codigo`,`nombre`) VALUES ('908','Carburador');
INSERT INTO `categoria` (`codigo`,`nombre`) VALUES ('909','Suspencio');
INSERT INTO `categoria` (`codigo`,`nombre`) VALUES ('910','Electrico');
INSERT INTO `categoria` (`codigo`,`nombre`) VALUES ('911','Rodamientos');
INSERT INTO `categoria` (`codigo`,`nombre`) VALUES ('913','Trasmision');
INSERT INTO `categoria` (`codigo`,`nombre`) VALUES ('914','Lubricantes');
INSERT INTO `categoria` (`codigo`,`nombre`) VALUES ('915','prueba');
INSERT INTO `categoria` (`codigo`,`nombre`) VALUES ('917','moto');

-- -----------------------------
-- Estructura de la tabla `cliente`
-- -----------------------------
DROP TABLE IF EXISTS `cliente`;
CREATE TABLE `cliente` (
  `codigo` int(20) NOT NULL,
  `identificacion` enum('CC','TI','RC','CE','NIT','PA','PEP','PPT','PT') NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `telefono` varchar(13) NOT NULL,
  `correo` varchar(45) NOT NULL,
  PRIMARY KEY (`codigo`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- -----------------------------
-- Datos de la tabla `cliente`
-- -----------------------------
INSERT INTO `cliente` (`codigo`,`identificacion`,`nombre`,`apellido`,`telefono`,`correo`) VALUES ('0','CC','Esteban','Hernandez','3221456215','estebanhernandez45@gamil.com');
INSERT INTO `cliente` (`codigo`,`identificacion`,`nombre`,`apellido`,`telefono`,`correo`) VALUES ('123','CC','Daniel','Lopez','145','danielleonardo@gmail.com');
INSERT INTO `cliente` (`codigo`,`identificacion`,`nombre`,`apellido`,`telefono`,`correo`) VALUES ('147','NIT','EDWIN','Rodriguez','158','edwincastillo@gmail.com');
INSERT INTO `cliente` (`codigo`,`identificacion`,`nombre`,`apellido`,`telefono`,`correo`) VALUES ('258','CC','Nicolas','castillo','1478','nicolascastillo@gmail.com');
INSERT INTO `cliente` (`codigo`,`identificacion`,`nombre`,`apellido`,`telefono`,`correo`) VALUES ('789','CC','sandra','rodriguez','98765','sandrarodriguez@gmail.com');
INSERT INTO `cliente` (`codigo`,`identificacion`,`nombre`,`apellido`,`telefono`,`correo`) VALUES ('2222222','CC','Consumidor','Final','12455','consumidorfinal@final.com');
INSERT INTO `cliente` (`codigo`,`identificacion`,`nombre`,`apellido`,`telefono`,`correo`) VALUES ('5646456','CC','karim','perez','4645645','consumidorfinal@final.com');
INSERT INTO `cliente` (`codigo`,`identificacion`,`nombre`,`apellido`,`telefono`,`correo`) VALUES ('74182332','CC','HECTOR','LOPEZ','3102572023','leonardolpc40@gmail.com');
INSERT INTO `cliente` (`codigo`,`identificacion`,`nombre`,`apellido`,`telefono`,`correo`) VALUES ('1014473365','CC','maria','rodriguez','3222248664','msriarodriguez@gmail.com');
INSERT INTO `cliente` (`codigo`,`identificacion`,`nombre`,`apellido`,`telefono`,`correo`) VALUES ('2147483647','CC','leidy','sanchez','3202355067','LADY280H@HOTMAIL.COM');

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
  `productos_resumen` longtext DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  KEY `fk_Usuario_has_Producto_Usuario1_idx` (`Usuario_identificacion`),
  KEY `fk_Factura_Cliente1_idx` (`Cliente_codigo`),
  CONSTRAINT `fk_Factura_Cliente1_idx` FOREIGN KEY (`Cliente_codigo`) REFERENCES `cliente` (`codigo`),
  CONSTRAINT `fk_Usuario_has_Producto_Usuario1` FOREIGN KEY (`Usuario_identificacion`) REFERENCES `usuario` (`identificacion`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=219 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- -----------------------------
-- Datos de la tabla `factura`
-- -----------------------------
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`,`productos_resumen`) VALUES ('210','2025-06-17 23:23:55','123','Daniel Leonardo','Lopez Baron','2222222','Consumidor','Final','12455','2222222','0','6000','1',NULL,'[{\"id\":\"18576\",\"nombre\":\"MANIGUETA CLUTCH BOXER CT                                            â€“\\n                                            \\n                                                $6,000.00\",\"cantidad\":1,\"precio\":6000}]');
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`,`productos_resumen`) VALUES ('211','2025-06-17 23:27:57','123','Daniel Leonardo','Lopez Baron','2222222','Consumidor','Final','12455','2222222','0','11000','1',NULL,'[{\"id\":\"18576\",\"nombre\":\"MANIGUETA CLUTCH BOXER CT                                            â€“\\n                                            \\n                                                $11,000.00\",\"cantidad\":1,\"precio\":11000}]');
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`,`productos_resumen`) VALUES ('212','2025-06-17 23:28:10','123','Daniel Leonardo','Lopez Baron','2222222','Consumidor','Final','12455','2222222','0','11000','1',NULL,'[{\"id\":\"18576\",\"nombre\":\"MANIGUETA CLUTCH BOXER CT                                            â€“\\n                                            \\n                                                $11,000.00\",\"cantidad\":1,\"precio\":11000}]');
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`,`productos_resumen`) VALUES ('213','2025-06-17 23:29:40','123','Daniel Leonardo','Lopez Baron','2222222','Consumidor','Final','12455','2222222','0','11000','1',NULL,'[{\"id\":\"18576\",\"nombre\":\"MANIGUETA CLUTCH BOXER CT                                            â€“\\n                                            \\n                                                $11,000.00\",\"cantidad\":1,\"precio\":11000}]');
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`,`productos_resumen`) VALUES ('214','2025-06-17 23:32:13','123','Daniel Leonardo','Lopez Baron','2222222','Consumidor','Final','12455','2222222','0','6000','1',NULL,'[{\"id\":\"18576\",\"nombre\":\"MANIGUETA CLUTCH BOXER CT                                            â€“\\n                                            \\n                                                $6,000.00\",\"cantidad\":1,\"precio\":6000}]');
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`,`productos_resumen`) VALUES ('215','2025-06-18 11:04:27','123','Daniel Leonardo','Lopez Baron','2222222','Consumidor','Final','12455','2222222','0','16800','1',NULL,'[{\"id\":\"23996\",\"nombre\":\"PALANCA CAMBIOS DISCOVER 100\\/XCD                                            â€“\\n                                            \\n                                                $16,800.00\",\"cantidad\":1,\"precio\":16800}]');
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`,`productos_resumen`) VALUES ('216','2025-06-18 11:11:59','123','Daniel Leonardo','Lopez Baron','123','Daniel','Leonardo lo','145','123','0','6000','1',NULL,'[{\"id\":\"18576\",\"nombre\":\"MANIGUETA CLUTCH BOXER CT                                            â€“\\n                                            \\n                                                $6,000.00\",\"cantidad\":1,\"precio\":6000}]');
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`,`productos_resumen`) VALUES ('217','2025-06-19 07:36:23','123','Daniel Leonardo','Lopez Baron','2222222','Consumidor','Final','12455','2222222','0','43200','0','Error de digitacion','[{\"id\":\"18576\",\"nombre\":\"MANIGUETA CLUTCH BOXER CT                                            â€“\\n                                            \\n                                                $6,000.00\",\"cantidad\":1,\"precio\":6000},{\"id\":\"23996\",\"nombre\":\"PALANCA CAMBIOS DISCOVER 100\\/XCD                                            â€“\\n                                            \\n                                                $16,800.00\",\"cantidad\":1,\"precio\":16800},{\"id\":\"31955\",\"nombre\":\"DIAFRAGMA CBF 125\\/150 CON CORTINA VITRIX 9903                                            â€“\\n                                            \\n                                                $20,400.00\",\"cantidad\":1,\"precio\":20400}]');
INSERT INTO `factura` (`codigo`,`fechaGeneracion`,`Usuario_identificacion`,`nombreUsuario`,`apellidoUsuario`,`Cliente_codigo`,`nombreCliente`,`apellidoCliente`,`telefonoCliente`,`identificacionCliente`,`cambio`,`precioTotal`,`activo`,`observacion`,`productos_resumen`) VALUES ('218','2025-06-19 19:52:03','1941','Daniel','Lopez','2222222','Consumidor','Final','12455','2222222','0','6000','1',NULL,'[{\"id\":\"18576\",\"nombre\":\"MANIGUETA CLUTCH BOXER CT                                            â€“\\n                                            \\n                                                $6,000.00\",\"cantidad\":1,\"precio\":6000}]');

-- -----------------------------
-- Estructura de la tabla `factura_metodo_pago`
-- -----------------------------
DROP TABLE IF EXISTS `factura_metodo_pago`;
CREATE TABLE `factura_metodo_pago` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Factura_codigo` int(11) NOT NULL,
  `metodoPago` varchar(200) NOT NULL,
  `monto` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Factura_codigo` (`Factura_codigo`),
  CONSTRAINT `factura_metodo_pago_ibfk_1` FOREIGN KEY (`Factura_codigo`) REFERENCES `factura` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=281 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------
-- Datos de la tabla `factura_metodo_pago`
-- -----------------------------
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('269','210','efectivo','6000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('270','211','efectivo','11000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('271','212','efectivo','11000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('272','213','efectivo','11000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('273','214','efectivo','6000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('274','215','efectivo','16800');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('275','216','efectivo','1500');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('276','216','credito','2500');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('277','216','transferencia','2000');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('278','217','efectivo','4320');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('279','217','transferencia','38880');
INSERT INTO `factura_metodo_pago` (`id`,`Factura_codigo`,`metodoPago`,`monto`) VALUES ('280','218','efectivo','6000');

-- -----------------------------
-- Estructura de la tabla `marca`
-- -----------------------------
DROP TABLE IF EXISTS `marca`;
CREATE TABLE `marca` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2222239 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- -----------------------------
-- Datos de la tabla `marca`
-- -----------------------------
INSERT INTO `marca` (`codigo`,`nombre`) VALUES ('2222227','Japan');
INSERT INTO `marca` (`codigo`,`nombre`) VALUES ('2222228','Vitrix');
INSERT INTO `marca` (`codigo`,`nombre`) VALUES ('2222229','Petrobras');
INSERT INTO `marca` (`codigo`,`nombre`) VALUES ('2222230','Castrol');
INSERT INTO `marca` (`codigo`,`nombre`) VALUES ('2222231','Motul');
INSERT INTO `marca` (`codigo`,`nombre`) VALUES ('2222232','Liqui Moly');
INSERT INTO `marca` (`codigo`,`nombre`) VALUES ('2222233','Mobil');
INSERT INTO `marca` (`codigo`,`nombre`) VALUES ('2222234','EduardoÃ±o');
INSERT INTO `marca` (`codigo`,`nombre`) VALUES ('2222235','Valvoline');
INSERT INTO `marca` (`codigo`,`nombre`) VALUES ('2222236','Eni');
INSERT INTO `marca` (`codigo`,`nombre`) VALUES ('2222238','PRUEBA');

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
) ENGINE=InnoDB AUTO_INCREMENT=1431 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------
-- Datos de la tabla `notificaciones`
-- -----------------------------
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1052','Producto PALANCA CAMBIOS DISCOVER 100/XCD bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1053','Producto DIAFRAGMA CBF 125/150 CON CORTINA VITRIX 9903 bajo mÃ­nimo! Stock actual: 3','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1054','Producto MANIGUETA FRENO  BEST /KMX 125 JAPAN bajo mÃ­nimo! Stock actual: 5','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1055','Producto BALANCIN BOXER CT 102/DISC 125UG/PLATINO 125D bajo mÃ­nimo! Stock actual: 3','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1056','Producto **PEDAL FRENO AKT 110SPECIAL NV VITRIX 990390 bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1057','Producto BOMBA DE ACEITE PULSAR 135/XCD125/PLATINO 125 bajo mÃ­nimo! Stock actual: 3','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1058','Producto CADENILLA DISTRIBUCION PULSAR 150NS/AS 150 VI bajo mÃ­nimo! Stock actual: 5','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1059','Producto EJE CAMBIOS AX 100 bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1060','Producto PALANCA CAMBIOS BOXER CT 100 bajo mÃ­nimo! Stock actual: 5','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1061','Producto PALANCA CAMBIOS BEST 125 bajo mÃ­nimo! Stock actual: 5','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1062','Producto PALANCA CAMBIOS  CD 100 bajo mÃ­nimo! Stock actual: 3','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1063','Producto PALANCA CAMBIOS AKT 125 SL bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1064','Producto MANIGUETA FRENO XTZ125 / KMX CROMO JAPAN bajo mÃ­nimo! Stock actual: 5','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1065','Producto MANIGUETA FRENO BOXER-PLATINO JAPAN bajo mÃ­nimo! Stock actual: 6','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1066','Producto MANIGUETA CLUTCH AKT 125 bajo mÃ­nimo! Stock actual: 8','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1067','Producto MANIGUETA CLUTCH PULSAR 180 bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1068','Producto MANIGUETA FRENO VIVAX 115  FRENO BANDA JAPAN bajo mÃ­nimo! Stock actual: 3','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1069','Producto MANIGUETA CLUTCH GS 125 JAPAN bajo mÃ­nimo! Stock actual: 5','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1070','Producto MANIGUETA FRENO FZ 16 JAPAN bajo mÃ­nimo! Stock actual: 7','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1071','Producto MANIGUETA FRENO PULSAR UG/NS/GIXXER bajo mÃ­nimo! Stock actual: 8','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1072','Producto PASTILLAS FRENO TRASERAS XTZ 250 bajo mÃ­nimo! Stock actual: 6','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1073','Producto PASTILLAS FRENO AKT 110 JAPAN bajo mÃ­nimo! Stock actual: 9','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1074','Producto PASTILLAS FRENO NS 200 TRASERAS bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1075','Producto PASTILLAS FRENO PULSAR 180 bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1076','Producto PASTILLAS FRENO BWS 125 MV bajo mÃ­nimo! Stock actual: 6','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1077','Producto PASTILLA FRENO CRIPTON 115  JAPAN bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1078','Producto PASTILLAS FRENO BWS X 125 bajo mÃ­nimo! Stock actual: 5','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1079','Producto PASTILLA FRENO RTX 150 TRASERAS JAPAN bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1080','Producto PASTILLA FRENO NS 200 TRASERAS bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1081','Producto PEDAL CAMBIOS DISCOVER ST 125/150 VITRIX 9903 bajo mÃ­nimo! Stock actual: 3','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1082','Producto Kit biela   best 125 vitrix bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1083','Producto BALANCIN PULSAR 180UG/II/220/DISC 135 PASADOR bajo mÃ­nimo! Stock actual: 1','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1084','Producto MANIGUETA CLUTCH CB 110/ECO bajo mÃ­nimo! Stock actual: 6','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1085','Producto MANIGUETA FRENO BWS 125 bajo mÃ­nimo! Stock actual: 8','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1086','Producto MANIGUETA CLUTCH NS 200 PULSAR JAPAN bajo mÃ­nimo! Stock actual: 7','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1087','Producto MANIGUETA  FRENO XTZ 125  CROMADA JAPAN bajo mÃ­nimo! Stock actual: 5','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1088','Producto ANILLOS AKT TTR 150/EVO NE 150/ APACHE 160 2  bajo mÃ­nimo! Stock actual: 5','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1089','Producto BALANCIN CR4 162 JUEGO X 2 ADM/ESC VITRIX bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1090','Producto **PEDAL DE CRANK ECO 100 bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1091','Producto BALINERA 6204 2RS VITRIX PORTA PLATO GN/AKT E bajo mÃ­nimo! Stock actual: 6','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1092','Producto BALANCIN  CRIPTON 115 FI JUEGO X 2 ADMIS Y ES bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1093','Producto CADENILLA DISTRIBUCION XTZ125/YBR 125/LIBERO  bajo mÃ­nimo! Stock actual: 6','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1094','Producto **DIAFRAGMA BWS 125 COMPLETO VITRIX 990390703 bajo mÃ­nimo! Stock actual: 3','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1095','Producto CADENILLA DISTRIBUCION MRX 150/RTX150/BWS 125 bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1096','Producto BOMBA ACEITE AKT 110S/WAVE 100/110/ECO100/ VI bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1097','Producto BALANCIN BOXER CT100/BM100/PLATINO 100/110 BO bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1098','Producto CAPUCHON BUJIA GN125/GS 125/EN 125 VITRIX bajo mÃ­nimo! Stock actual: 6','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1099','Producto **PEDAL CAMBIOS PULSAR 180II/ BLACK TEC bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1100','Producto PEDAL CRANK FLEX 125 AKT VITRIX 9903907038316 bajo mÃ­nimo! Stock actual: 1','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1101','Producto ARBOL DE LEVAS PULSAR 135  VITRIX bajo mÃ­nimo! Stock actual: 1','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1102','Producto REFRIGUERANTE  BASE DE AGUA PETROBRAS bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1103','Producto **CAUCHOS CAMPANA GN 125/GS 125 VITRIX 990390 bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1104','Producto BALANCIN NKDR/TTR/125/150/EVO NE 125 JUEGO PO bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1105','Producto **PEDAL DE CRANK AGILITY 125 VITRIX 990390703 bajo mÃ­nimo! Stock actual: 1','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1106','Producto KIT CILINDRO CB 125 F VITRIX bajo mÃ­nimo! Stock actual: 1','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1107','Producto BALINERA6202 2RS VITRIX CAMPDTK/XTZ 125/DISCO bajo mÃ­nimo! Stock actual: 8','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1108','Producto BALANCIN FZ 16/ SZR JUEGO X 2 DMI Y ESC VITRI bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1109','Producto **PEDAL DE CAMBIOS PULSAR180 UG - PULSAR 200/ bajo mÃ­nimo! Stock actual: 3','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1110','Producto BALANCINES AKT DYNAMID 125 SCOOTER 125/150 JU bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1111','Producto KIT PISTON AKTT110/ACTIVE 110   O.50  VITRIX bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1112','Producto ARBOL LEVAS DISCOVER 100 S/BM 150/DISCOVER 12 bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1113','Producto AMORTIGUADOR YBR 125 SD TRASERO JUEGO X 2 VIT bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1114','Producto BALANCIN AGILITY 125 JUEGO X 2 ADMI Y ESC VIT bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1115','Producto ANILLOS BEST 125/VIVA 115/VIVAX 115 VITRIX bajo mÃ­nimo! Stock actual: 3','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1116','Producto BUJE PORTA PLATO CRIPTON 110/RX 115 VITRIX bajo mÃ­nimo! Stock actual: 8','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1117','Producto CDI YBR 125/XTZ125(2006-2008) VITRIX bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1118','Producto BALANCINES CR5/TTR180/TTX180/XM180/ JUEGO X 2 bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1119','Producto CDI LIBERO 125/YBR 125ESD VITRIX bajo mÃ­nimo! Stock actual: 1','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1120','Producto BALANCIN PULSAR 150 AS/150 NS JUEGO X2 ADMI Y bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1121','Producto BALANCIN PULSAR 125NSJUEGO X2 ADMI /ESC VITRI bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1122','Producto CARBURADOR NKD 125/SPORT S VITRIX bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1123','Producto **BARRA TELESCOPICA NKD/AKT 125SL /CG 125  JU bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1124','Producto CDI CRIPTON 110 VITRIX bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1125','Producto CLUTCH DE UNA VIA Y/O BENDIX BWS 125 VITRIX bajo mÃ­nimo! Stock actual: 3','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1126','Producto ACEITE CASTROL ACTEVO  20W 50 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1127','Producto BALANCIN PULSAR NS 200 JUEGO X2 ADMISION Y ES bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1128','Producto VALVULINA MOTUL SCOOTER 80W 90 150 ML bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1129','Producto LUBRICANTE CADENA MOTUL  C4 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1130','Producto ACEITE MOTUL 5100 15W 50 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1131','Producto ACEITE MOTUL 7100 10W 40 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1132','Producto ACEITE MOTUL 7100 10W 50 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1133','Producto ACEITE MOTUL 7100 20W 50 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1134','Producto ACEITE MOTUL 5100 20W 50 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1135','Producto ACEITE MOTUL 5000 20W 50 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1136','Producto ACEITE CASTROL POWER 20W50 4T bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1137','Producto HIDRAULICO MOBIL AW68 1/4 LUDESOL bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1138','Producto REFRIGERANTE STD 1/4 TERPEL VERDE LUDESOL bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1139','Producto ACEITE MOBIL  20W50 4T TAPA AMARILLA bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1140','Producto REFRIGERANTE MOBIL  1/4 COOLANT  CORROSION IN bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1141','Producto Banda de freno boxer/ japan 101014 bajo mÃ­nimo! Stock actual: 6','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1142','Producto LIQUIDO PARA FRENOS HIDRAULICOS DOT 3 240 ML bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1143','Producto ACEITE VALVOLINE 4T 20W50 PREMIUM bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1144','Producto ACEITE VALVOLINE 10W40 SEMISINTETICO bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1145','Producto ACEITE ENI 20W50 RIDE SPECIAL MA2 L bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:04:27','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1146','Producto MANIGUETA CLUTCH BOXER CT bajo mÃ­nimo! Stock actual: 9','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1147','Producto PALANCA CAMBIOS DISCOVER 100/XCD bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1148','Producto DIAFRAGMA CBF 125/150 CON CORTINA VITRIX 9903 bajo mÃ­nimo! Stock actual: 3','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1149','Producto MANIGUETA FRENO  BEST /KMX 125 JAPAN bajo mÃ­nimo! Stock actual: 5','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1150','Producto BALANCIN BOXER CT 102/DISC 125UG/PLATINO 125D bajo mÃ­nimo! Stock actual: 3','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1151','Producto **PEDAL FRENO AKT 110SPECIAL NV VITRIX 990390 bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1152','Producto BOMBA DE ACEITE PULSAR 135/XCD125/PLATINO 125 bajo mÃ­nimo! Stock actual: 3','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1153','Producto CADENILLA DISTRIBUCION PULSAR 150NS/AS 150 VI bajo mÃ­nimo! Stock actual: 5','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1154','Producto EJE CAMBIOS AX 100 bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1155','Producto PALANCA CAMBIOS BOXER CT 100 bajo mÃ­nimo! Stock actual: 5','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1156','Producto PALANCA CAMBIOS BEST 125 bajo mÃ­nimo! Stock actual: 5','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1157','Producto PALANCA CAMBIOS  CD 100 bajo mÃ­nimo! Stock actual: 3','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1158','Producto PALANCA CAMBIOS AKT 125 SL bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1159','Producto MANIGUETA FRENO XTZ125 / KMX CROMO JAPAN bajo mÃ­nimo! Stock actual: 5','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1160','Producto MANIGUETA FRENO BOXER-PLATINO JAPAN bajo mÃ­nimo! Stock actual: 6','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1161','Producto MANIGUETA CLUTCH AKT 125 bajo mÃ­nimo! Stock actual: 8','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1162','Producto MANIGUETA CLUTCH PULSAR 180 bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1163','Producto MANIGUETA FRENO VIVAX 115  FRENO BANDA JAPAN bajo mÃ­nimo! Stock actual: 3','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1164','Producto MANIGUETA CLUTCH GS 125 JAPAN bajo mÃ­nimo! Stock actual: 5','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1165','Producto MANIGUETA FRENO FZ 16 JAPAN bajo mÃ­nimo! Stock actual: 7','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1166','Producto MANIGUETA FRENO PULSAR UG/NS/GIXXER bajo mÃ­nimo! Stock actual: 8','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1167','Producto PASTILLAS FRENO TRASERAS XTZ 250 bajo mÃ­nimo! Stock actual: 6','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1168','Producto PASTILLAS FRENO AKT 110 JAPAN bajo mÃ­nimo! Stock actual: 9','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1169','Producto PASTILLAS FRENO NS 200 TRASERAS bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1170','Producto PASTILLAS FRENO PULSAR 180 bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1171','Producto PASTILLAS FRENO BWS 125 MV bajo mÃ­nimo! Stock actual: 6','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1172','Producto PASTILLA FRENO CRIPTON 115  JAPAN bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1173','Producto PASTILLAS FRENO BWS X 125 bajo mÃ­nimo! Stock actual: 5','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1174','Producto PASTILLA FRENO RTX 150 TRASERAS JAPAN bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1175','Producto PASTILLA FRENO NS 200 TRASERAS bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1176','Producto PEDAL CAMBIOS DISCOVER ST 125/150 VITRIX 9903 bajo mÃ­nimo! Stock actual: 3','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1177','Producto Kit biela   best 125 vitrix bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1178','Producto BALANCIN PULSAR 180UG/II/220/DISC 135 PASADOR bajo mÃ­nimo! Stock actual: 1','nose','2025-06-18 11:11:59','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1179','Producto MANIGUETA CLUTCH CB 110/ECO bajo mÃ­nimo! Stock actual: 6','nose','2025-06-18 11:12:00','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1180','Producto MANIGUETA FRENO BWS 125 bajo mÃ­nimo! Stock actual: 8','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1181','Producto MANIGUETA CLUTCH NS 200 PULSAR JAPAN bajo mÃ­nimo! Stock actual: 7','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1182','Producto MANIGUETA  FRENO XTZ 125  CROMADA JAPAN bajo mÃ­nimo! Stock actual: 5','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1183','Producto ANILLOS AKT TTR 150/EVO NE 150/ APACHE 160 2  bajo mÃ­nimo! Stock actual: 5','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1184','Producto BALANCIN CR4 162 JUEGO X 2 ADM/ESC VITRIX bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1185','Producto **PEDAL DE CRANK ECO 100 bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1186','Producto BALINERA 6204 2RS VITRIX PORTA PLATO GN/AKT E bajo mÃ­nimo! Stock actual: 6','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1187','Producto BALANCIN  CRIPTON 115 FI JUEGO X 2 ADMIS Y ES bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1188','Producto CADENILLA DISTRIBUCION XTZ125/YBR 125/LIBERO  bajo mÃ­nimo! Stock actual: 6','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1189','Producto **DIAFRAGMA BWS 125 COMPLETO VITRIX 990390703 bajo mÃ­nimo! Stock actual: 3','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1190','Producto CADENILLA DISTRIBUCION MRX 150/RTX150/BWS 125 bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1191','Producto BOMBA ACEITE AKT 110S/WAVE 100/110/ECO100/ VI bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1192','Producto BALANCIN BOXER CT100/BM100/PLATINO 100/110 BO bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1193','Producto CAPUCHON BUJIA GN125/GS 125/EN 125 VITRIX bajo mÃ­nimo! Stock actual: 6','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1194','Producto **PEDAL CAMBIOS PULSAR 180II/ BLACK TEC bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1195','Producto PEDAL CRANK FLEX 125 AKT VITRIX 9903907038316 bajo mÃ­nimo! Stock actual: 1','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1196','Producto ARBOL DE LEVAS PULSAR 135  VITRIX bajo mÃ­nimo! Stock actual: 1','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1197','Producto REFRIGUERANTE  BASE DE AGUA PETROBRAS bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1198','Producto **CAUCHOS CAMPANA GN 125/GS 125 VITRIX 990390 bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1199','Producto BALANCIN NKDR/TTR/125/150/EVO NE 125 JUEGO PO bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1200','Producto **PEDAL DE CRANK AGILITY 125 VITRIX 990390703 bajo mÃ­nimo! Stock actual: 1','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1201','Producto KIT CILINDRO CB 125 F VITRIX bajo mÃ­nimo! Stock actual: 1','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1202','Producto BALINERA6202 2RS VITRIX CAMPDTK/XTZ 125/DISCO bajo mÃ­nimo! Stock actual: 8','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1203','Producto BALANCIN FZ 16/ SZR JUEGO X 2 DMI Y ESC VITRI bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1204','Producto **PEDAL DE CAMBIOS PULSAR180 UG - PULSAR 200/ bajo mÃ­nimo! Stock actual: 3','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1205','Producto BALANCINES AKT DYNAMID 125 SCOOTER 125/150 JU bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1206','Producto KIT PISTON AKTT110/ACTIVE 110   O.50  VITRIX bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1207','Producto ARBOL LEVAS DISCOVER 100 S/BM 150/DISCOVER 12 bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1208','Producto AMORTIGUADOR YBR 125 SD TRASERO JUEGO X 2 VIT bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1209','Producto BALANCIN AGILITY 125 JUEGO X 2 ADMI Y ESC VIT bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1210','Producto ANILLOS BEST 125/VIVA 115/VIVAX 115 VITRIX bajo mÃ­nimo! Stock actual: 3','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1211','Producto BUJE PORTA PLATO CRIPTON 110/RX 115 VITRIX bajo mÃ­nimo! Stock actual: 8','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1212','Producto CDI YBR 125/XTZ125(2006-2008) VITRIX bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1213','Producto BALANCINES CR5/TTR180/TTX180/XM180/ JUEGO X 2 bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1214','Producto CDI LIBERO 125/YBR 125ESD VITRIX bajo mÃ­nimo! Stock actual: 1','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1215','Producto BALANCIN PULSAR 150 AS/150 NS JUEGO X2 ADMI Y bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1216','Producto BALANCIN PULSAR 125NSJUEGO X2 ADMI /ESC VITRI bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1217','Producto CARBURADOR NKD 125/SPORT S VITRIX bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1218','Producto **BARRA TELESCOPICA NKD/AKT 125SL /CG 125  JU bajo mÃ­nimo! Stock actual: 4','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1219','Producto CDI CRIPTON 110 VITRIX bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1220','Producto CLUTCH DE UNA VIA Y/O BENDIX BWS 125 VITRIX bajo mÃ­nimo! Stock actual: 3','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1221','Producto ACEITE CASTROL ACTEVO  20W 50 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1222','Producto BALANCIN PULSAR NS 200 JUEGO X2 ADMISION Y ES bajo mÃ­nimo! Stock actual: 2','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1223','Producto VALVULINA MOTUL SCOOTER 80W 90 150 ML bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1224','Producto LUBRICANTE CADENA MOTUL  C4 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1225','Producto ACEITE MOTUL 5100 15W 50 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1226','Producto ACEITE MOTUL 7100 10W 40 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1227','Producto ACEITE MOTUL 7100 10W 50 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1228','Producto ACEITE MOTUL 7100 20W 50 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1229','Producto ACEITE MOTUL 5100 20W 50 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1230','Producto ACEITE MOTUL 5000 20W 50 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1231','Producto ACEITE CASTROL POWER 20W50 4T bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1232','Producto HIDRAULICO MOBIL AW68 1/4 LUDESOL bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1233','Producto REFRIGERANTE STD 1/4 TERPEL VERDE LUDESOL bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1234','Producto ACEITE MOBIL  20W50 4T TAPA AMARILLA bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1235','Producto REFRIGERANTE MOBIL  1/4 COOLANT  CORROSION IN bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:12:00','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1236','Producto Banda de freno boxer/ japan 101014 bajo mÃ­nimo! Stock actual: 6','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1237','Producto LIQUIDO PARA FRENOS HIDRAULICOS DOT 3 240 ML bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:12:00','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1238','Producto ACEITE VALVOLINE 4T 20W50 PREMIUM bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1239','Producto ACEITE VALVOLINE 10W40 SEMISINTETICO bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:12:00','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1240','Producto ACEITE ENI 20W50 RIDE SPECIAL MA2 L bajo mÃ­nimo! Stock actual: 0','nose','2025-06-18 11:12:00','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1241','Producto MANIGUETA CLUTCH BOXER CT bajo mÃ­nimo! Stock actual: 8','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1242','Producto PALANCA CAMBIOS DISCOVER 100/XCD bajo mÃ­nimo! Stock actual: 3','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1243','Producto DIAFRAGMA CBF 125/150 CON CORTINA VITRIX 9903 bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1244','Producto MANIGUETA FRENO  BEST /KMX 125 JAPAN bajo mÃ­nimo! Stock actual: 5','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1245','Producto BALANCIN BOXER CT 102/DISC 125UG/PLATINO 125D bajo mÃ­nimo! Stock actual: 3','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1246','Producto **PEDAL FRENO AKT 110SPECIAL NV VITRIX 990390 bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1247','Producto BOMBA DE ACEITE PULSAR 135/XCD125/PLATINO 125 bajo mÃ­nimo! Stock actual: 3','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1248','Producto CADENILLA DISTRIBUCION PULSAR 150NS/AS 150 VI bajo mÃ­nimo! Stock actual: 5','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1249','Producto EJE CAMBIOS AX 100 bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1250','Producto PALANCA CAMBIOS BOXER CT 100 bajo mÃ­nimo! Stock actual: 5','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1251','Producto PALANCA CAMBIOS BEST 125 bajo mÃ­nimo! Stock actual: 5','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1252','Producto PALANCA CAMBIOS  CD 100 bajo mÃ­nimo! Stock actual: 3','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1253','Producto PALANCA CAMBIOS AKT 125 SL bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1254','Producto MANIGUETA FRENO XTZ125 / KMX CROMO JAPAN bajo mÃ­nimo! Stock actual: 5','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1255','Producto MANIGUETA FRENO BOXER-PLATINO JAPAN bajo mÃ­nimo! Stock actual: 6','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1256','Producto MANIGUETA CLUTCH AKT 125 bajo mÃ­nimo! Stock actual: 8','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1257','Producto MANIGUETA CLUTCH PULSAR 180 bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1258','Producto MANIGUETA FRENO VIVAX 115  FRENO BANDA JAPAN bajo mÃ­nimo! Stock actual: 3','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1259','Producto MANIGUETA CLUTCH GS 125 JAPAN bajo mÃ­nimo! Stock actual: 5','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1260','Producto MANIGUETA FRENO FZ 16 JAPAN bajo mÃ­nimo! Stock actual: 7','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1261','Producto MANIGUETA FRENO PULSAR UG/NS/GIXXER bajo mÃ­nimo! Stock actual: 8','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1262','Producto PASTILLAS FRENO TRASERAS XTZ 250 bajo mÃ­nimo! Stock actual: 6','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1263','Producto PASTILLAS FRENO AKT 110 JAPAN bajo mÃ­nimo! Stock actual: 9','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1264','Producto PASTILLAS FRENO NS 200 TRASERAS bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1265','Producto PASTILLAS FRENO PULSAR 180 bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1266','Producto PASTILLAS FRENO BWS 125 MV bajo mÃ­nimo! Stock actual: 6','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1267','Producto PASTILLA FRENO CRIPTON 115  JAPAN bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1268','Producto PASTILLAS FRENO BWS X 125 bajo mÃ­nimo! Stock actual: 5','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1269','Producto PASTILLA FRENO RTX 150 TRASERAS JAPAN bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1270','Producto PASTILLA FRENO NS 200 TRASERAS bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1271','Producto PEDAL CAMBIOS DISCOVER ST 125/150 VITRIX 9903 bajo mÃ­nimo! Stock actual: 3','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1272','Producto Kit biela   best 125 vitrix bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1273','Producto BALANCIN PULSAR 180UG/II/220/DISC 135 PASADOR bajo mÃ­nimo! Stock actual: 1','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1274','Producto MANIGUETA CLUTCH CB 110/ECO bajo mÃ­nimo! Stock actual: 6','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1275','Producto MANIGUETA FRENO BWS 125 bajo mÃ­nimo! Stock actual: 8','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1276','Producto MANIGUETA CLUTCH NS 200 PULSAR JAPAN bajo mÃ­nimo! Stock actual: 7','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1277','Producto MANIGUETA  FRENO XTZ 125  CROMADA JAPAN bajo mÃ­nimo! Stock actual: 5','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1278','Producto ANILLOS AKT TTR 150/EVO NE 150/ APACHE 160 2  bajo mÃ­nimo! Stock actual: 5','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1279','Producto BALANCIN CR4 162 JUEGO X 2 ADM/ESC VITRIX bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1280','Producto **PEDAL DE CRANK ECO 100 bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 07:36:23','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1281','Producto BALINERA 6204 2RS VITRIX PORTA PLATO GN/AKT E bajo mÃ­nimo! Stock actual: 6','nose','2025-06-19 07:36:23','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1282','Producto BALANCIN  CRIPTON 115 FI JUEGO X 2 ADMIS Y ES bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 07:36:23','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1283','Producto CADENILLA DISTRIBUCION XTZ125/YBR 125/LIBERO  bajo mÃ­nimo! Stock actual: 6','nose','2025-06-19 07:36:23','1');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1284','Producto **DIAFRAGMA BWS 125 COMPLETO VITRIX 990390703 bajo mÃ­nimo! Stock actual: 3','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1285','Producto CADENILLA DISTRIBUCION MRX 150/RTX150/BWS 125 bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1286','Producto BOMBA ACEITE AKT 110S/WAVE 100/110/ECO100/ VI bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1287','Producto BALANCIN BOXER CT100/BM100/PLATINO 100/110 BO bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1288','Producto CAPUCHON BUJIA GN125/GS 125/EN 125 VITRIX bajo mÃ­nimo! Stock actual: 6','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1289','Producto **PEDAL CAMBIOS PULSAR 180II/ BLACK TEC bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1290','Producto PEDAL CRANK FLEX 125 AKT VITRIX 9903907038316 bajo mÃ­nimo! Stock actual: 1','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1291','Producto ARBOL DE LEVAS PULSAR 135  VITRIX bajo mÃ­nimo! Stock actual: 1','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1292','Producto REFRIGUERANTE  BASE DE AGUA PETROBRAS bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1293','Producto **CAUCHOS CAMPANA GN 125/GS 125 VITRIX 990390 bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1294','Producto BALANCIN NKDR/TTR/125/150/EVO NE 125 JUEGO PO bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1295','Producto **PEDAL DE CRANK AGILITY 125 VITRIX 990390703 bajo mÃ­nimo! Stock actual: 1','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1296','Producto KIT CILINDRO CB 125 F VITRIX bajo mÃ­nimo! Stock actual: 1','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1297','Producto BALINERA6202 2RS VITRIX CAMPDTK/XTZ 125/DISCO bajo mÃ­nimo! Stock actual: 8','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1298','Producto BALANCIN FZ 16/ SZR JUEGO X 2 DMI Y ESC VITRI bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1299','Producto **PEDAL DE CAMBIOS PULSAR180 UG - PULSAR 200/ bajo mÃ­nimo! Stock actual: 3','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1300','Producto BALANCINES AKT DYNAMID 125 SCOOTER 125/150 JU bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1301','Producto KIT PISTON AKTT110/ACTIVE 110   O.50  VITRIX bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1302','Producto ARBOL LEVAS DISCOVER 100 S/BM 150/DISCOVER 12 bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1303','Producto AMORTIGUADOR YBR 125 SD TRASERO JUEGO X 2 VIT bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1304','Producto BALANCIN AGILITY 125 JUEGO X 2 ADMI Y ESC VIT bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1305','Producto ANILLOS BEST 125/VIVA 115/VIVAX 115 VITRIX bajo mÃ­nimo! Stock actual: 3','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1306','Producto BUJE PORTA PLATO CRIPTON 110/RX 115 VITRIX bajo mÃ­nimo! Stock actual: 8','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1307','Producto CDI YBR 125/XTZ125(2006-2008) VITRIX bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1308','Producto BALANCINES CR5/TTR180/TTX180/XM180/ JUEGO X 2 bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1309','Producto CDI LIBERO 125/YBR 125ESD VITRIX bajo mÃ­nimo! Stock actual: 1','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1310','Producto BALANCIN PULSAR 150 AS/150 NS JUEGO X2 ADMI Y bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1311','Producto BALANCIN PULSAR 125NSJUEGO X2 ADMI /ESC VITRI bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1312','Producto CARBURADOR NKD 125/SPORT S VITRIX bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1313','Producto **BARRA TELESCOPICA NKD/AKT 125SL /CG 125 JU bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1314','Producto CDI CRIPTON 110 VITRIX bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1315','Producto CLUTCH DE UNA VIA Y/O BENDIX BWS 125 VITRIX bajo mÃ­nimo! Stock actual: 3','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1316','Producto ACEITE CASTROL ACTEVO  20W 50 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1317','Producto BALANCIN PULSAR NS 200 JUEGO X2 ADMISION Y ES bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1318','Producto VALVULINA MOTUL SCOOTER 80W 90 150 ML bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1319','Producto LUBRICANTE CADENA MOTUL  C4 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1320','Producto ACEITE MOTUL 5100 15W 50 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1321','Producto ACEITE MOTUL 7100 10W 40 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1322','Producto ACEITE MOTUL 7100 10W 50 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1323','Producto ACEITE MOTUL 7100 20W 50 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1324','Producto ACEITE MOTUL 5100 20W 50 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1325','Producto ACEITE MOTUL 5000 20W 50 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1326','Producto ACEITE CASTROL POWER 20W50 4T bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1327','Producto HIDRAULICO MOBIL AW68 1/4 LUDESOL bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1328','Producto REFRIGERANTE STD 1/4 TERPEL VERDE LUDESOL bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1329','Producto ACEITE MOBIL  20W50 4T TAPA AMARILLA bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1330','Producto REFRIGERANTE MOBIL  1/4 COOLANT  CORROSION IN bajo mÃ­nimo! Stock actual: 8','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1331','Producto Banda de freno boxer/ japan 101014 bajo mÃ­nimo! Stock actual: 6','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1332','Producto LIQUIDO PARA FRENOS HIDRAULICOS DOT 3 240 ML bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1333','Producto ACEITE VALVOLINE 4T 20W50 PREMIUM bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1334','Producto ACEITE VALVOLINE 10W40 SEMISINTETICO bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1335','Producto ACEITE ENI 20W50 RIDE SPECIAL MA2 L bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 07:36:23','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1336','Producto MANIGUETA CLUTCH BOXER CT bajo mÃ­nimo! Stock actual: 7','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1337','Producto PALANCA CAMBIOS DISCOVER 100/XCD bajo mÃ­nimo! Stock actual: 3','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1338','Producto DIAFRAGMA CBF 125/150 CON CORTINA VITRIX 9903 bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1339','Producto MANIGUETA FRENO  BEST /KMX 125 JAPAN bajo mÃ­nimo! Stock actual: 5','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1340','Producto BALANCIN BOXER CT 102/DISC 125UG/PLATINO 125D bajo mÃ­nimo! Stock actual: 3','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1341','Producto **PEDAL FRENO AKT 110SPECIAL NV VITRIX 990390 bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1342','Producto BOMBA DE ACEITE PULSAR 135/XCD125/PLATINO 125 bajo mÃ­nimo! Stock actual: 3','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1343','Producto CADENILLA DISTRIBUCION PULSAR 150NS/AS 150 VI bajo mÃ­nimo! Stock actual: 5','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1344','Producto EJE CAMBIOS AX 100 bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1345','Producto PALANCA CAMBIOS BOXER CT 100 bajo mÃ­nimo! Stock actual: 5','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1346','Producto PALANCA CAMBIOS BEST 125 bajo mÃ­nimo! Stock actual: 5','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1347','Producto PALANCA CAMBIOS  CD 100 bajo mÃ­nimo! Stock actual: 3','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1348','Producto PALANCA CAMBIOS AKT 125 SL bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1349','Producto MANIGUETA FRENO XTZ125 / KMX CROMO JAPAN bajo mÃ­nimo! Stock actual: 5','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1350','Producto MANIGUETA FRENO BOXER-PLATINO JAPAN bajo mÃ­nimo! Stock actual: 6','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1351','Producto MANIGUETA CLUTCH AKT 125 bajo mÃ­nimo! Stock actual: 8','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1352','Producto MANIGUETA CLUTCH PULSAR 180 bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1353','Producto MANIGUETA FRENO VIVAX 115  FRENO BANDA JAPAN bajo mÃ­nimo! Stock actual: 3','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1354','Producto MANIGUETA CLUTCH GS 125 JAPAN bajo mÃ­nimo! Stock actual: 5','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1355','Producto MANIGUETA FRENO FZ 16 JAPAN bajo mÃ­nimo! Stock actual: 7','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1356','Producto MANIGUETA FRENO PULSAR UG/NS/GIXXER bajo mÃ­nimo! Stock actual: 8','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1357','Producto PASTILLAS FRENO TRASERAS XTZ 250 bajo mÃ­nimo! Stock actual: 6','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1358','Producto PASTILLAS FRENO AKT 110 JAPAN bajo mÃ­nimo! Stock actual: 9','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1359','Producto PASTILLAS FRENO NS 200 TRASERAS bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1360','Producto PASTILLAS FRENO PULSAR 180 bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1361','Producto PASTILLAS FRENO BWS 125 MV bajo mÃ­nimo! Stock actual: 6','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1362','Producto PASTILLA FRENO CRIPTON 115  JAPAN bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1363','Producto PASTILLAS FRENO BWS X 125 bajo mÃ­nimo! Stock actual: 5','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1364','Producto PASTILLA FRENO RTX 150 TRASERAS JAPAN bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1365','Producto PASTILLA FRENO NS 200 TRASERAS bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1366','Producto PEDAL CAMBIOS DISCOVER ST 125/150 VITRIX 9903 bajo mÃ­nimo! Stock actual: 3','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1367','Producto Kit biela   best 125 vitrix bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1368','Producto BALANCIN PULSAR 180UG/II/220/DISC 135 PASADOR bajo mÃ­nimo! Stock actual: 1','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1369','Producto MANIGUETA CLUTCH CB 110/ECO bajo mÃ­nimo! Stock actual: 6','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1370','Producto MANIGUETA FRENO BWS 125 bajo mÃ­nimo! Stock actual: 8','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1371','Producto MANIGUETA CLUTCH NS 200 PULSAR JAPAN bajo mÃ­nimo! Stock actual: 7','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1372','Producto MANIGUETA  FRENO XTZ 125  CROMADA JAPAN bajo mÃ­nimo! Stock actual: 5','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1373','Producto ANILLOS AKT TTR 150/EVO NE 150/ APACHE 160 2  bajo mÃ­nimo! Stock actual: 5','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1374','Producto BALANCIN CR4 162 JUEGO X 2 ADM/ESC VITRIX bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1375','Producto **PEDAL DE CRANK ECO 100 bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1376','Producto BALINERA 6204 2RS VITRIX PORTA PLATO GN/AKT E bajo mÃ­nimo! Stock actual: 6','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1377','Producto BALANCIN  CRIPTON 115 FI JUEGO X 2 ADMIS Y ES bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1378','Producto CADENILLA DISTRIBUCION XTZ125/YBR 125/LIBERO  bajo mÃ­nimo! Stock actual: 6','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1379','Producto **DIAFRAGMA BWS 125 COMPLETO VITRIX 990390703 bajo mÃ­nimo! Stock actual: 3','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1380','Producto CADENILLA DISTRIBUCION MRX 150/RTX150/BWS 125 bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1381','Producto BOMBA ACEITE AKT 110S/WAVE 100/110/ECO100/ VI bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1382','Producto BALANCIN BOXER CT100/BM100/PLATINO 100/110 BO bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1383','Producto CAPUCHON BUJIA GN125/GS 125/EN 125 VITRIX bajo mÃ­nimo! Stock actual: 6','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1384','Producto **PEDAL CAMBIOS PULSAR 180II/ BLACK TEC bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1385','Producto PEDAL CRANK FLEX 125 AKT VITRIX 9903907038316 bajo mÃ­nimo! Stock actual: 1','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1386','Producto ARBOL DE LEVAS PULSAR 135  VITRIX bajo mÃ­nimo! Stock actual: 1','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1387','Producto REFRIGUERANTE  BASE DE AGUA PETROBRAS bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1388','Producto **CAUCHOS CAMPANA GN 125/GS 125 VITRIX 990390 bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1389','Producto BALANCIN NKDR/TTR/125/150/EVO NE 125 JUEGO PO bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1390','Producto **PEDAL DE CRANK AGILITY 125 VITRIX 990390703 bajo mÃ­nimo! Stock actual: 1','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1391','Producto KIT CILINDRO CB 125 F VITRIX bajo mÃ­nimo! Stock actual: 1','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1392','Producto BALINERA6202 2RS VITRIX CAMPDTK/XTZ 125/DISCO bajo mÃ­nimo! Stock actual: 8','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1393','Producto BALANCIN FZ 16/ SZR JUEGO X 2 DMI Y ESC VITRI bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1394','Producto **PEDAL DE CAMBIOS PULSAR180 UG - PULSAR 200/ bajo mÃ­nimo! Stock actual: 3','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1395','Producto BALANCINES AKT DYNAMID 125 SCOOTER 125/150 JU bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1396','Producto KIT PISTON AKTT110/ACTIVE 110   O.50  VITRIX bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1397','Producto ARBOL LEVAS DISCOVER 100 S/BM 150/DISCOVER 12 bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1398','Producto AMORTIGUADOR YBR 125 SD TRASERO JUEGO X 2 VIT bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1399','Producto BALANCIN AGILITY 125 JUEGO X 2 ADMI Y ESC VIT bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1400','Producto ANILLOS BEST 125/VIVA 115/VIVAX 115 VITRIX bajo mÃ­nimo! Stock actual: 3','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1401','Producto BUJE PORTA PLATO CRIPTON 110/RX 115 VITRIX bajo mÃ­nimo! Stock actual: 8','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1402','Producto CDI YBR 125/XTZ125(2006-2008) VITRIX bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1403','Producto BALANCINES CR5/TTR180/TTX180/XM180/ JUEGO X 2 bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1404','Producto CDI LIBERO 125/YBR 125ESD VITRIX bajo mÃ­nimo! Stock actual: 1','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1405','Producto BALANCIN PULSAR 150 AS/150 NS JUEGO X2 ADMI Y bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1406','Producto BALANCIN PULSAR 125NSJUEGO X2 ADMI /ESC VITRI bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1407','Producto CARBURADOR NKD 125/SPORT S VITRIX bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1408','Producto **BARRA TELESCOPICA NKD/AKT 125SL /CG 125 JU bajo mÃ­nimo! Stock actual: 4','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1409','Producto CDI CRIPTON 110 VITRIX bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1410','Producto CLUTCH DE UNA VIA Y/O BENDIX BWS 125 VITRIX bajo mÃ­nimo! Stock actual: 3','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1411','Producto ACEITE CASTROL ACTEVO  20W 50 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1412','Producto BALANCIN PULSAR NS 200 JUEGO X2 ADMISION Y ES bajo mÃ­nimo! Stock actual: 2','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1413','Producto VALVULINA MOTUL SCOOTER 80W 90 150 ML bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1414','Producto LUBRICANTE CADENA MOTUL  C4 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1415','Producto ACEITE MOTUL 5100 15W 50 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1416','Producto ACEITE MOTUL 7100 10W 40 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1417','Producto ACEITE MOTUL 7100 10W 50 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1418','Producto ACEITE MOTUL 7100 20W 50 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1419','Producto ACEITE MOTUL 5100 20W 50 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1420','Producto ACEITE MOTUL 5000 20W 50 bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1421','Producto ACEITE CASTROL POWER 20W50 4T bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1422','Producto HIDRAULICO MOBIL AW68 1/4 LUDESOL bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1423','Producto REFRIGERANTE STD 1/4 TERPEL VERDE LUDESOL bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1424','Producto ACEITE MOBIL  20W50 4T TAPA AMARILLA bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1425','Producto REFRIGERANTE MOBIL  1/4 COOLANT  CORROSION IN bajo mÃ­nimo! Stock actual: 8','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1426','Producto Banda de freno boxer/ japan 101014 bajo mÃ­nimo! Stock actual: 6','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1427','Producto LIQUIDO PARA FRENOS HIDRAULICOS DOT 3 240 ML bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1428','Producto ACEITE VALVOLINE 4T 20W50 PREMIUM bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1429','Producto ACEITE VALVOLINE 10W40 SEMISINTETICO bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 19:52:03','0');
INSERT INTO `notificaciones` (`id`,`mensaje`,`descripcion`,`fecha`,`leida`) VALUES ('1430','Producto ACEITE ENI 20W50 RIDE SPECIAL MA2 L bajo mÃ­nimo! Stock actual: 0','nose','2025-06-19 19:52:03','0');

-- -----------------------------
-- Estructura de la tabla `producto`
-- -----------------------------
DROP TABLE IF EXISTS `producto`;
CREATE TABLE `producto` (
  `codigo1` bigint(20) unsigned NOT NULL,
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
  `proveedor_nit` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`codigo1`),
  KEY `fk_Producto_Categoria1_idx` (`Categoria_codigo`),
  KEY `fk_Producto_Marca1_idx` (`Marca_codigo`),
  KEY `fk_Producto_UnidadMedida1_idx` (`UnidadMedida_codigo`),
  KEY `fk_Producto_Ubicacion1_idx` (`Ubicacion_codigo`),
  KEY `proveedor_nit` (`proveedor_nit`) USING BTREE,
  CONSTRAINT `fk_Producto_Categoria1` FOREIGN KEY (`Categoria_codigo`) REFERENCES `categoria` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Producto_Marca1` FOREIGN KEY (`Marca_codigo`) REFERENCES `marca` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Producto_Proveedor1` FOREIGN KEY (`proveedor_nit`) REFERENCES `proveedor` (`nit`) ON UPDATE CASCADE,
  CONSTRAINT `fk_Producto_Ubicacion1` FOREIGN KEY (`Ubicacion_codigo`) REFERENCES `ubicacion` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Producto_UnidadMedida1` FOREIGN KEY (`UnidadMedida_codigo`) REFERENCES `unidadmedida` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- -----------------------------
-- Datos de la tabla `producto`
-- -----------------------------
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('18576','0','MANIGUETA CLUTCH BOXER CT','19','5000','6000','11000','7','903','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('23996','0','PALANCA CAMBIOS DISCOVER 100/XCD','19','14000','16800','24000','3','904','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('31955','vh10369','DIAFRAGMA CBF 125/150 CON CORTINA VITRIX 9903','19','16303','20400','24000','2','908','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('101133','0','MANIGUETA FRENO  BEST /KMX 125 JAPAN','19','6900','9600','12000','5','905','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('101771','0','PASTILLAS FRENO XTZ-TS 125','19','14','17','22','10','905','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('321321','VB10542','BALANCIN BOXER CT 102/DISC 125UG/PLATINO 125D','19','23','28','33','3','906','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('512951','VA50046','**PEDAL FRENO AKT 110SPECIAL NV VITRIX 990390','19','21','27','32','2','907','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('651651','VB10309','BOMBA DE ACEITE PULSAR 135/XCD125/PLATINO 125','19','23','28','34','3','906','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('651891','VB10315','CADENILLA DISTRIBUCION PULSAR 150NS/AS 150 VI','19','12','15','18','5','906','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1010510','0','EJE CAMBIOS AX 100','19','17','20','27','2','904','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1010718','0','PALANCA CAMBIOS BOXER CT 100','19','15600','18700','25000','5','904','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1010721','0','PALANCA CAMBIOS BEST 125','19','16','20','24','5','904','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1010724','0','PALANCA CAMBIOS  CD 100','19','15','18','24','3','904','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1010744','0','PALANCA CAMBIOS AKT 125 SL','19','15','18','25','2','904','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1011034','0','MANIGUETA FRENO XTZ125 / KMX CROMO JAPAN','19','6','9','12','5','905','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1011070','0','MANIGUETA FRENO BOXER-PLATINO JAPAN','19','6','9','12','6','905','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1011075','0','MANIGUETA CLUTCH AKT 125','19','6','7','11','8','905','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1011086','0','MANIGUETA CLUTCH PULSAR 180','19','6','10','12','4','903','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1011088','0','MANIGUETA FRENO VIVAX 115  FRENO BANDA JAPAN','19','6700','10000','12000','3','905','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1011089','0','MANIGUETA CLUTCH GS 125 JAPAN','19','6700','9600','12000','5','903','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1011091','0','MANIGUETA FRENO FZ 16 JAPAN','19','6700','9000','11000','7','905','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1011093','0','MANIGUETA FRENO PULSAR UG/NS/GIXXER','19','6','7','11','8','905','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1017711','0','PASTILLAS FRENO BEST 125','19','14000','17000','22000','12','905','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1017714','0','PASTILLAS FRENO TRASERAS XTZ 250','19','14','17','22','6','905','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1017728','0','PASTILLAS FRENO AKT 110 JAPAN','19','14','18','22','9','905','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1017740','0','PASTILLAS FRENO NS 200 TRASERAS','19','14','17','22','4','905','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1017744','0','PASTILLAS FRENO PULSAR 180','19','14600','17500','22000','4','905','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1017756','0','PASTILLAS FRENO BWS 125 MV','19','14','17','22','6','905','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1017757','0','PASTILLA FRENO CRIPTON 115  JAPAN','19','14','18','22','4','905','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1017775','0','PASTILLAS FRENO BWS X 125','19','16','19','26','5','905','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1017776','0','PASTILLA FRENO RTX 150 TRASERAS JAPAN','19','15250','18700','22000','2','905','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('1017779','0','PASTILLA FRENO NS 200 TRASERAS','19','14','17','22','4','905','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('3219191','VB40083','PEDAL CAMBIOS DISCOVER ST 125/150 VITRIX 9903','19','28917','35700','42000','3','904','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('4561561','VS10129','Kit biela   best 125 vitrix','19','53','64','76','2','906','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('8941591','VB10434','BALANCIN PULSAR 180UG/II/220/DISC 135 PASADOR','19','29','35','42','1','906','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('10110101','0','MANIGUETA CLUTCH CB 110/ECO','19','6','8','11','6','903','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('10110117','0','MANIGUETA FRENO BWS 125','19','6500','8000','11000','8','905','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('10110124','0','MANIGUETA CLUTCH NS 200 PULSAR JAPAN','19','6700','9000','11000','7','903','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('10110125','0','MANIGUETA  FRENO XTZ 125  CROMADA JAPAN','19','6','9','11','5','903','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('12383123','VA10206','ANILLOS AKT TTR 150/EVO NE 150/ APACHE 160 2 ','19','21896','27200','32000','5','906','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('14561561','VB10381','BALANCIN CR4 162 JUEGO X 2 ADM/ESC VITRIX','19','19','23','28','2','906','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('28798451','VH40040','**PEDAL DE CRANK ECO 100','19','24','30','35','2','907','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('31298489','VU10063','BALINERA 6204 2RS VITRIX PORTA PLATO GN/AKT E','19','3','5','6','6','911','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('31351531','VY10416','BALANCIN  CRIPTON 115 FI JUEGO X 2 ADMIS Y ES','19','18','22','26','4','906','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('31864561','VY10122','CADENILLA DISTRIBUCION XTZ125/YBR 125/LIBERO ','19','16','19','23','6','906','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('35418135','VY10381','**DIAFRAGMA BWS 125 COMPLETO VITRIX 990390703','19','19','25','30','3','908','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('35486151','VV10003','CADENILLA DISTRIBUCION MRX 150/RTX150/BWS 125','19','21','25','30','4','906','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('45345345','VA10027','BOMBA ACEITE AKT 110S/WAVE 100/110/ECO100/ VI','19','12','16','19','2','906','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('51265181','VB10093','BALANCIN BOXER CT100/BM100/PLATINO 100/110 BO','19','31','38','45','2','906','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('51351531','VS20042','CAPUCHON BUJIA GN125/GS 125/EN 125 VITRIX','19','2','3','4','6','910','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('51695195','VA40049','**PEDAL CAMBIOS PULSAR 180II/ BLACK TEC','19','15589','19600','23000','2','904','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('51951891','VA40077','PEDAL CRANK FLEX 125 AKT VITRIX 9903907038316','19','23920','30000','35000','1','907','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('51951981','VB10083','ARBOL DE LEVAS PULSAR 135  VITRIX','19','55','66','78','1','906','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('62300269','0','REFRIGUERANTE  BASE DE AGUA PETROBRAS','19','7000','11000','13000','4','914','2222229','2','22','9015817900');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('65165151','VS50020','**CAUCHOS CAMPANA GN 125/GS 125 VITRIX 990390','19','9','12','15','4','911','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('91981971','VA10316','BALANCIN NKDR/TTR/125/150/EVO NE 125 JUEGO PO','19','18','22','26','4','906','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('98489191','VK40025','**PEDAL DE CRANK AGILITY 125 VITRIX 990390703','19','19','24','29','1','907','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('165191891','VH10343','KIT CILINDRO CB 125 F VITRIX','19','119952','145000','171000','1','906','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('315131561','VU10043','BALINERA6202 2RS VITRIX CAMPDTK/XTZ 125/DISCO','19','3','5','6','8','911','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('316514321','VY10050','BALANCIN FZ 16/ SZR JUEGO X 2 DMI Y ESC VITRI','19','45','55','65','4','906','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('321651951','VB40030','**PEDAL DE CAMBIOS PULSAR180 UG - PULSAR 200/','19','36','45','53','3','904','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('445383453','VA10158','BALANCINES AKT DYNAMID 125 SCOOTER 125/150 JU','19','20468','25500','30000','4','906','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('453453453','VA10002','KIT PISTON AKTT110/ACTIVE 110   O.50  VITRIX','19','32','39','46','2','906','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('515619589','VB10512','ARBOL LEVAS DISCOVER 100 S/BM 150/DISCOVER 12','19','38','45','54','2','906','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('518651321','VY40067','AMORTIGUADOR YBR 125 SD TRASERO JUEGO X 2 VIT','19','117453','142800','168000','4','909','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('919814981','VK10007','BALANCIN AGILITY 125 JUEGO X 2 ADMI Y ESC VIT','19','19','23','28','4','906','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('941891621','VS10035','ANILLOS BEST 125/VIVA 115/VIVAX 115 VITRIX','19','16779','20400','24000','3','906','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('3513514531','VY40102','BUJE PORTA PLATO CRIPTON 110/RX 115 VITRIX','19','3','8','10','8','913','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('3516514531','VY20007','CDI YBR 125/XTZ125(2006-2008) VITRIX','19','48','54','68','2','910','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('4834531298','va10297','BALANCINES CR5/TTR180/TTX180/XM180/ JUEGO X 2','19','24','29','34','2','906','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('6541531351','VY20080','CDI LIBERO 125/YBR 125ESD VITRIX','19','45','52','64','1','910','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('8912651651','VB10351','BALANCIN PULSAR 150 AS/150 NS JUEGO X2 ADMI Y','19','24','29','34','2','906','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('8914321651','VB10573','BALANCIN PULSAR 125NSJUEGO X2 ADMI /ESC VITRI','19','22','27','32','2','906','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('9551971748','VA40010','CARBURADOR NKD 125/SPORT S VITRIX','19','54','66','78','2','906','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('9849489156','VH60004','**BARRA TELESCOPICA NKD/AKT 125SL /CG 125 JU','19','96','118','120000','4','909','2222228','2','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('35156153132','VY20036','CDI CRIPTON 110 VITRIX','19','24','29','35','2','910','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('35418614891','VY10213','CLUTCH DE UNA VIA Y/O BENDIX BWS 125 VITRIX','19','0','52','61','3','903','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('79191217672','0','ACEITE CASTROL ACTEVO  20W 50','19','23','30','33','0','914','2222230','2','22','8909009431');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('84151265189','VB10063','BALANCIN PULSAR NS 200 JUEGO X2 ADMISION Y ES','19','35','43','51','2','905','2222228','1','22','8600762794');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('3374650016597','0','VALVULINA MOTUL SCOOTER 80W 90 150 ML','19','7','10','16','0','914','2222231','2','22','9000672751');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('3374650239002','0','LUBRICANTE CADENA MOTUL  C4','19','33','37','50','0','914','2222231','2','22','9000672751');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('3374650247205','0','ACEITE MOTUL 5100 15W 50','19','26','41','44','0','914','2222231','2','22','9000672751');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('3374650247304','0','ACEITE MOTUL 7100 10W 40','19','55','60','65','0','914','2222231','2','22','9000672751');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('3374650247359','0','ACEITE MOTUL 7100 10W 50','19','24','30','50','0','914','2222231','2','22','9000672751');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('3374650247410','0','ACEITE MOTUL 7100 20W 50','19','47','64','65','0','914','2222231','2','22','9000672751');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('3374650299440','0','ACEITE MOTUL 5100 20W 50','19','35','42','44','0','914','2222231','2','22','9000672751');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('3374650303123','0','ACEITE MOTUL 5000 20W 50','19','32','33','35','0','914','2222231','2','22','9000672751');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('4008177191206','0','ACEITE CASTROL POWER 20W50 4T','19','29','36','39','0','914','2222230','2','22','8909009431');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('7704790204466','0','HIDRAULICO MOBIL AW68 1/4 LUDESOL','19','16','20','22','0','914','2222233','2','22','9003874750');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('7704790204787','0','REFRIGERANTE STD 1/4 TERPEL VERDE LUDESOL','19','4','5','9','0','914','2222233','2','22','9003874750');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('7704790205357','0','ACEITE MOBIL  20W50 4T TAPA AMARILLA','19','26','27','30','0','914','2222233','2','22','9012494137');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('7704790300977','0','REFRIGERANTE MOBIL  1/4 COOLANT  CORROSION IN','19','5000','10000','12000','8','914','2222233','2','22','9015817900');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('7707036900191','0','Banda de freno boxer/ japan 101014','19','16','19','23','6','905','2222227','1','22','8914090064');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('7709990212914','0','LIQUIDO PARA FRENOS HIDRAULICOS DOT 3 240 ML','19','6','7','9','0','914','2222233','2','22','9003874750');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('7862101152063','0','ACEITE VALVOLINE 4T 20W50 PREMIUM','19','19','22','30','0','914','2222235','2','22','9000672751');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('7862101152070','0','ACEITE VALVOLINE 10W40 SEMISINTETICO','19','20','24','30','0','914','2222235','2','22','9000672751');
INSERT INTO `producto` (`codigo1`,`codigo2`,`nombre`,`iva`,`precio1`,`precio2`,`precio3`,`cantidad`,`Categoria_codigo`,`Marca_codigo`,`UnidadMedida_codigo`,`Ubicacion_codigo`,`proveedor_nit`) VALUES ('8003699012578','0','ACEITE ENI 20W50 RIDE SPECIAL MA2 L','19','25','27','35','0','914','2222236','2','22','9000672751');

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
  CONSTRAINT `producto_factura_ibfk_1` FOREIGN KEY (`Factura_codigo`) REFERENCES `factura` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=272 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------
-- Datos de la tabla `producto_factura`
-- -----------------------------

-- -----------------------------
-- Estructura de la tabla `proveedor`
-- -----------------------------
DROP TABLE IF EXISTS `proveedor`;
CREATE TABLE `proveedor` (
  `nit` bigint(20) unsigned NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `telefono` varchar(13) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `correo` varchar(45) NOT NULL,
  PRIMARY KEY (`nit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- -----------------------------
-- Datos de la tabla `proveedor`
-- -----------------------------
INSERT INTO `proveedor` (`nit`,`nombre`,`telefono`,`direccion`,`correo`) VALUES ('149','fdghj','532453','fgfhjkl','gkgkl@gh');
INSERT INTO `proveedor` (`nit`,`nombre`,`telefono`,`direccion`,`correo`) VALUES ('15164','gdhfdjfhm','256194','hffjf','dthj@dhdth');
INSERT INTO `proveedor` (`nit`,`nombre`,`telefono`,`direccion`,`correo`) VALUES ('1264946','sdfrhgdh','1654984','ghgjkhgjhkll','hfdj@dfhf');
INSERT INTO `proveedor` (`nit`,`nombre`,`telefono`,`direccion`,`correo`) VALUES ('8600762794','Omniparts','601 5803730','Autopista BogotÃ¡ â€“ Medellin KM 1.8','omniparts@omniparts.com.co');
INSERT INTO `proveedor` (`nit`,`nombre`,`telefono`,`direccion`,`correo`) VALUES ('8909009431','Corbeta','018000914066','Km 3.5 vÃ­a BogotÃ¡ - Mosquera','coldecom@colcomercio.com.co');
INSERT INTO `proveedor` (`nit`,`nombre`,`telefono`,`direccion`,`correo`) VALUES ('8914090064','Distrimotos','63354522','Av 30 Agosto 83 - 15','paulavallejo@cassarella.com');
INSERT INTO `proveedor` (`nit`,`nombre`,`telefono`,`direccion`,`correo`) VALUES ('9000672751','Megacomercial','3144077536','Calle 21 35 46 â€“ San Benito','contacto@megacomercial.co');
INSERT INTO `proveedor` (`nit`,`nombre`,`telefono`,`direccion`,`correo`) VALUES ('9003874750','Lubesol','3158009233','Manzana J Lote J5 ET 2','servicioalcliente@lubesolsas.com');
INSERT INTO `proveedor` (`nit`,`nombre`,`telefono`,`direccion`,`correo`) VALUES ('9009793746','Granados y CompaÃ±Ã­a','3165232825','Calle 21 N 15 - 28','granadoscom@grana.com');
INSERT INTO `proveedor` (`nit`,`nombre`,`telefono`,`direccion`,`correo`) VALUES ('9012494137','Auteco','46046119','Autopista MedellÃ­n BogotÃ¡ km 32','servicioalcliente@auteco.com.co');
INSERT INTO `proveedor` (`nit`,`nombre`,`telefono`,`direccion`,`correo`) VALUES ('9015817900','LubrimanÃ­','3103275512','Cra 4 N 28 - 54 Mani','facuracion@lubrimanisaszomac.com');

-- -----------------------------
-- Estructura de la tabla `ubicacion`
-- -----------------------------
DROP TABLE IF EXISTS `ubicacion`;
CREATE TABLE `ubicacion` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- -----------------------------
-- Datos de la tabla `ubicacion`
-- -----------------------------
INSERT INTO `ubicacion` (`codigo`,`nombre`) VALUES ('1','estanteria 4');
INSERT INTO `ubicacion` (`codigo`,`nombre`) VALUES ('2','pasillo 4 ');
INSERT INTO `ubicacion` (`codigo`,`nombre`) VALUES ('4','columna 23');
INSERT INTO `ubicacion` (`codigo`,`nombre`) VALUES ('10','PISO 5');
INSERT INTO `ubicacion` (`codigo`,`nombre`) VALUES ('17','piso tres');
INSERT INTO `ubicacion` (`codigo`,`nombre`) VALUES ('18','piso 9');
INSERT INTO `ubicacion` (`codigo`,`nombre`) VALUES ('22','UBICAR');
INSERT INTO `ubicacion` (`codigo`,`nombre`) VALUES ('28','Danielfet');

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
  `contrasena` varchar(255) NOT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `foto` longblob NOT NULL,
  `codigo_recuperacion` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`identificacion`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- -----------------------------
-- Datos de la tabla `usuario`
-- -----------------------------
INSERT INTO `usuario` (`identificacion`,`tipoDocumento`,`rol`,`nombre`,`apellido`,`telefono`,`direccion`,`correo`,`contrasena`,`estado`,`foto`,`codigo_recuperacion`) VALUES ('123','cedula de ciudadania','administrador','Daniel Leonardo','Lopez Baron','3004401797','123','danielbaron297@gmail.com','$2y$10$8TpIGt7XzhCBZkoLBgSMCOBPzkeMZWqYFzzVeh6eaa9B6Hmmq/L4S','activo','ÿØÿà\0JFIF\0\0`\0`\0\0ÿÛ\0C\0	\n\n			\n\n		\r\r\nÿÛ\0C	ÿÀ\0+Ï\"\0ÿÄ\0\0\0\0\0\0\0\0\0\0\0	\nÿÄ\0µ\0\0\0}\0!1AQa\"q2‘¡#B±ÁRÑð$3br‚	\n\Z%&\'()*456789:CDEFGHIJSTUVWXYZcdefghijstuvwxyzƒ„…†‡ˆ‰Š’“”•–—˜™š¢£¤¥¦§¨©ª²³´µ¶·¸¹ºÂÃÄÅÆÇÈÉÊÒÓÔÕÖ×ØÙÚáâãäåæçèéêñòóôõö÷øùúÿÄ\0\0\0\0\0\0\0\0	\nÿÄ\0µ\0\0w\0!1AQaq\"2B‘¡±Á	#3RðbrÑ\n$4á%ñ\Z&\'()*56789:CDEFGHIJSTUVWXYZcdefghijstuvwxyz‚ƒ„…†‡ˆ‰Š’“”•–—˜™š¢£¤¥¦§¨©ª²³´µ¶·¸¹ºÂÃÄÅÆÇÈÉÊÒÓÔÕÖ×ØÙÚâãäåæçèéêòóôõö÷øùúÿÚ\0\0\0?\0ýS¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(ÇÞ·ñ×‚5ïÝ¹Hµ½:âÅœ™Pß þøóð6óMý›?j\r9~6hO>º¸³¿I-üß³³ÄéÂ¡:‚Êà€r¼ŽÕûK^/ñëà?ìóñ†$¸ø¯o¥ÙßÛ.ÄÕ#½ŽÎí	”ýåƒO­Lüíñ·ìowâk]cÇŸ\0þ)x[âVŸÉ{6¦Î#Õ ‰s›ns€zd7¢×£ÿ\0Á4ÿ\0gÿ\0ÝüD“ãgˆ´›«\rE¶šÛMkˆš3yw òØ aó\"!?ˆ¨ìqôGÁÿ\0‚ÿ\0±ŸÀ=BëÇ¾øŸ¢É¨ZÇ%·ö¦¥â›Y…®õÁ\\)TˆÍyÏÂ?ø(„~Yx›Á?üQ/Š.´MVa£ëZ\r¨ž-RÑÙqÊª•ÎvŒ?†Ÿx×˜|wý¢¾þÎº.­|B›P+«\\=½¤âidd]ÎpYT\0É\'ø…|—ã_ø*ö–ãøsð®êcÈIµ«¥èLp–ü·þ5ògí	ûTüLý¤Ž–¾:³Ñm-4i&’Ê\r6ÕãT2\r–wvc„^ô\nÇßðôÙ¿þÏñ§Óû.þ?^ëð;ã×€h?Üx³áü—ÿ\0e³º6w_[ˆfŽ@ªÜ€Ì!Þ¿\n«ëoØöÃð·ìïoªx7Ç\Z\rìÚ>·|—gP²ÃÉjá|Ñ7&\0$ƒ‘èhÖZ+Á¾5ð¯ÄZx«Ázõž¯¥^®ènmd§ÕN9V‚§\ryí9û\\øöoÒ–Öølx¦ö\"ö:<2i\'lþê?C‚[©\'»Ñ_‹ÿ\0moÚ3âf¡-ÕÏÄMG@´sòØhXÂƒÓ(ÛÛþÆ¸}/ãßÇ\réo4¿Œ4·•NrºíÎÔÃb(Ýú+ó3öyÿ\0‚—xÃCÔ-<7ñÚÖ´g\"/í«hvÞÛçÒ¨!eQÆp“ót¯Ò=^Ñ¼Q¢Ùx‹Ãº•¾¡¦ê0­Å­Õ»‡ŽXØd0\"\Zó?à¢³ßÃïê¾	Ô‡‰o¯t[¹,nå°ÓãxhØ«¨g•Km`F@ÇV×íûjü)ýŸšMâgñŠ\net>E>Aìn8‹ýÞ[§æ¿ |kâi¼iã-{Æ7©k.»©ÝjolJÄÓÊÒò@-ŒûP4Õ-\'þ\n]û7êÚ¥¦–‘x²Ý®æHYôÈü´,ÀÛe\'ö¾®VVPÊrÈ5üõZ\\Ígu\rå¾°H²&F~e9¨¯µüÿ\0Nø±¤ùvž6ð‡5ˆc–žuœüzå	ú( ,~„ükøwÅ¯„þ)øs$Ëkšt–ðÈßv9Æ\Z&>ÂEB~•øñàÿ\0ÙGã‡Œ¾!ê\rm<!-†§¢7üM.5`µ²BNÙR(À¥AÜ@5÷—„à©5uX¼UáŸè‘ó8·Šêÿ\0Gÿ\0ŽS>\0|xðí\r\'Äy~0|FðÍ¦ƒâë¥°Ñ|#}¨Åmu”@®ó–\r¹ò§\nÇæV<(\r›µà¿ìãð+â\'ÃûïŠ¾ø‰âÿ\0\ZÇikog¡Ä³Á¦I³MÆO#qãƒ•œzüÓá°Úæ¿ñ£T²–\r:;_ì.GRÌŽÙ—ÕP\"©>­ŽÆ½7Ã¿±Oì3ÿ\0	!»±ñ´:ÃÛÍóirxªÚXUåØ‚Õõï‡´ïèú=®‘ák;M.Î1µ½Š\"CŠªœô .iQE(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0ù/öìý­<kû:¯‡<;ðÿ\0MÓÛT×á¸¹–öú#*ÛÇ\"\Z\0±,Ù-\0ñð¾¹ûxþÕ\Zæï3â…ÅnÖ6vðcèU2+íÏø(÷À|Vø¡x³Á:\rÖ­­xZêT{[8L“Ík>ÀûUym­\Z€·½|Aðçöý¤~#\\*ÇàŸYŸ½y¯³@=B0óðSAHóýãçÇ†O|^ñ…ômÖ)u«/þø´~UÅ]_^Þ¶ûËÉçoYd,Zöß‹Ÿ	þüµ—Ã7Ÿ¥ñßŽ\0+4:)X´½9ú–VËÊãû‹·ÜŽ•Gàoì•ñ›ãÕÄsø[Ãía¢1ùõ­IZ@;ì8&Sì€ûâžeà¿ÜxÓÆ\Zƒín	µÍJÛMŽfBÂ6šUŒ1’ìàzWè„?à”^	µ1Éã¿ŠZÖ FÅ¥ÚÅj§ÛtžaÇá\\àýš|;û|_ø;ãë­jMvÃSÕ$Ñõ«»È`¶»š2°Ëã÷`Ç,Ä™È¯Ñ:	lð_þÂÿ\0²ÿ\0ƒV6ƒáž­4xýî±#Þn>¥ì?M¸®_ö²øyû Íàý#Ã?µë/Á¦L×Zd:†Úë»YR‰Ã!Âçäê£‘^Ãñ÷â¥¿Á„~#ø‰$k-ÆhËctšíþHPû+œs€kÊg?ÙwIµÓáø½ñÂÎ?üGñ4k¨ÞM« ¸Nó\0u‚ÜB€€HèF\0PÊø+ÿ\0ßñN£“kñóÇ–70HÛQ–ÞÚ7\'ó½Qø‘_Bx‹þ	«ðVøeýƒà}CR¶ÖÆn¬|Est·1`0²„Uâ q±AÈ\'œú§‚|)àŸþñ~“ñÂzµkgâWI·W±ˆ4C HÂ2ÈÀ!½ëçSâ®¿ûëÞ,ø_¨^Üë¾¿ÑäÖ|öÙ\ZG¶¹26nÇªrqÙAêÆ€8ÙKø±û.x·âÄ¿šóNðï‚4#¨jZ{6ë{ë–$Z´,xùÂ¾y<é_|Añßˆ¾&xÏVñ×Šï^ëSÖ.\Zâgf$(<*.z*¨\n£°Q_RÂÎñ×ÄOØ³â§Œ¼aâKÝ[UÕüU¦ÙÜÉ4„¬Và«¬h½tQÇã_P0¢Š(WÚÿ\0°GÆ¯\\xÆŸ³Þ“âµ½Ô´;ÝCÂww;ôŒ–3Ð6wŽ\n1šø¢½—ö9¾¼±ý¦þIdÌMa!`½ÑÕ•‡ÓÐ#Ùÿ\0e?ØcÄ¿¯ßâWÆkJÃÃÏtòyR9ûf¯(o‹¶JÇ»!Ÿï1Î=G³ühýŠ?b?‡÷Sø£ÇŸµï[_1x4ë}R\ržëOo$Ì8=ÛÕÁøöÓÖ~ünø§à_j×Z·„lõ-dè±ÌÍ,–—Ë\'‘dž\"}»6ôRA¯}ý›g/ÙAûA|}³Å>:ñr.©:’	­´›i0ðÃ.\n«*yû¼ŒA5x3áüVOXJ¿\ZüdÆÞâ9^D‚Òr¬Wqh¤!Ç?2ñÜWÞÞ ø%ðâžŸ¥­|9ð–»ÔA¡¿K(YÞ28):\rÄcÑ«—ðNƒá/‹Ò|Oð¼\'áýcLÐ|]6co&Ÿî-E¤A!ƒË.r=x¯.økcª~É¿´U‡Àøµ+Ëß†ßcšçÃiu)‘´»èÆç·„Œë¹PrwÆŸðMÙÏÄÛæÐWÄ¸<¯Ø/„±gÝ\'WãÙJô¯ÿ\0jïØvOÙ¿ÂvÞ8±ñé×4û«ô±I`b–2ÊÌ°b¤|¤tE~¹WÍ?ðP/ØØþÏ÷~û½æ±ãBÓHÒmä@Ìf2«3 <‚ª§‘Óp ?Á*r¤‚+cIñ§Œ<?(›Añf³¦È:=¥ô°°üQ…}¥ñƒþ	â½G\\øCâ!­Ë²5Ö“~V9ÚP£“ XÎ°}Í|‡gáÛ/xÉ¼?ñ›Â~\"±†#åÞ[C‹[è=U*ßB0GB:Ð3¬Ðÿ\0koÚ[ÃûE‡Æ¯J ½¾k±ÿ\0‘·W¥x?þ\nAûJxwRµ›\\×4ÏXG\"ùö·štjdOâH‚08èsŒö4Cûê_¼4|qû9üIÑ<s¥c÷–37Øõ+fÿ\0žrÆr¡¸=YsÛ#šã<ûþÐ\Z÷ÄM+ÁúÏÂ¿iPMy\ZÞ_]Y:ÚÁáæHfÇ–@Pq‚rp\0~ÌøX·ñƒ§kö±¼pêV‘]Æ¯÷•d@ÀqšÐ¨m-mìma±´‰c‚Þ5Š4^ŠŠ0\0úSPHQE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0WÃß¶¥çí}âï‰VŸþéz…¿„µ»4Ùy¦¯—ö‚Gï…ÅÏü²Uçår¤}ì_pÑ@~ÏðN/‡VÛÄŸ¤‡Æ \\IöFR4ëgôØy˜Wãýšû\nÞÚÞÎÞ;[;xà†%q¨U@:\0\0T´Pñsá?ƒþ5x\ZûÀ>6³y´ûÍ²$‘6Ùmæ_¹,mÙ”“ìA ä^ìÛû\\øN(ô¿\0þ×RM¥Û¨ŽÞ-kGI¥Ž1Â©‘·–ÀïÅ}aE\0~~Óßÿ\0k-?áï‰~&|nÓ¼c èvºæ“g£ÇnÎ‘È3&õE8PI ×ÓÞ ñ×Ž¼}á½/Fø)áÈæµñ6‡âø®úaaèBìE>lÓÎÀ/˜t¯XÕ´½?\\Òï4]ZÖ;«BÞK[˜$Ybu*êG¡Æ¾M±ðí)û\'ÝÜØ|Ò ø™ðÒk—¸¶ðýÍ×“©iAÎJE#péø7_ºIPýŸÿ\0fÏ²\\Úçˆ´ÝKJø…g¬Ê¿Ú\Z-¬ò[\\˜Ð’·0<ÇËiÎæ6À<|õâðT/i>&ñ7€4[{Yíu+-\"]BöÒåBÜZ–B‘J ®d‘“×Þ¾¾ý¡¿kOÃý…ðïöRÔ¼3¨Ïû¶Õ|K|¢Ú×<oØQã¯ý\r|ëûLþÂ´ß§Å¦ñv§ãŸêWÈuûH,ËùÒLØØ(Ýµc b€<ÿ\0öCŠ?‰_þ.þÎÛÇöŸ‰t˜µ\n3Ç™{fÛŠ÷o}WË×óÚ\\KkuE4.c’6*Àà‚=A¯zðçìõû[üÖt¯‹\ZOÂ~ÎãD™oa–8ÒvP¿xIl\\)\\«×¢|Rø;áÿ\0Ú£D¹ø÷û<[§ü$å|Ïx,0P]p\Z{t8Ü¬C1¯o›+@Ïh©ï¬/´»É´ýJÎ{K«v),3ÆRHØve<ƒõ¨(WÓ?°‡†íí~\"k_\Z¼@ž_‡¾è×:½Ìí÷MÉ–Ç«œþÈõ¯2ø+û<üJøí­-„tw‹L‰³}­])ŽÆÊ1Ë3Èx$÷FOáÍ{§Ä‰±á;ÙöGÐu?izuÂÞø«\\±„¿ö½÷N\\|«\n‘Á\'iÚ1¹`GÊ~&ñ×‰üMªx¢øfãU¾šúQ×æ’Bä~f¿h´_ˆ,ñÇÂÿ\0\nƒ¾·¼]A¶—ûjúäEa¦†c+*,³#ûµP29u¯Ì\rö)ý¡§ñ¶á/|;Õt;}nò;vÔ¤g·¶CË;¼LÊ0 œ3Àï_nøwàÏí!û!ÆmþÜCñ3Àò‘=×‡u)ÞúÞl2KwápØÎy?tžH«ð3ö[øùû.ø›Ä^<ÐüE¢xö-\\˜ï4_:[9¯\"Þí	$™nÌ6T‡oœQûU^xâÿ\0Å_¾øwuqáo\Z,·^\"Ý¨[«O£ÆJ´Ñ‚Ã;¢qŒp;WKqûJ~Õ-Oì~ÈšÎ‰ªËû³¨x†ûm•±<9DÞ^·C]ßìÿ\0û<ê_u[â§ÄïÂOñ+ÄÈRÔ‚í‚Ö.··\\\r¨0p3´`Å8©¾þÜ¬¾\\µ–ŒGsÿ\0Ì*D5¯ðëöL×mü}¦üRøññoQøâ\r-¤C-¸¶²°sÕÖ Ä3 ñÈ}E\nà¾,ü\rø_ñ»GþÆøá[]D\"•·ºËº¶Î9ŠUù— ã88ä\Zïh Ì‰_±ßíû+ëïñ3öqñV««i‘H,Ô}¾É,Ð\0Râ<ã¢ŸR£¯Ð/‚º×üEð«ÃZßÅ-&-3Å7–B]JÖ4ØË¹_áb›I^Ä‘Ú»j(ÂŠ( AEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEP_!ÁB¿io|ð¾‰àÿ\0‡·Í§k¾\'ó¤“Q@–¶±mËÈ ;³cw`§G×µù¡ÿ\0`ÿ\0’ƒà?û\\ÿ\0èñ@Ñòç†iŽÞñ~(Ò~*x‘¯RA#­BKˆ¥çñÈJ0=0E{Oí¬ÜYé¿ÿ\0k¯„òMá\r[ÇÖwI«ÿ\0eJÑ\"jV²å`d!ò¸ÁÙ“’I?&×Ôßwüßá$²rÑø³THý”½Ñ?¨ d0þÜÅV±[üvøàˆ“Æ¡PšÜX^È÷¥g§EŽ”åý©?g-(ý«Ã?±7† ¼2É¨kÒÞÆ­ÿ\0\\Úæ+åÚ(Ûþ\'~Ö_>/ÙÇà¸ïlü7á©JÛÅ x~ØZZH[oÎã§íö¯Yý¦>$kÿ\0³-Ž‰û2|½\rE¥év×ž$Õ,[eæ§¨L›Ÿt£æU\n{Ñ@¯–>,mñÃ0³d>žzf½›þ\n+IûXxÑXñØ~Ÿc„ÿ\0Z\0Äø=û]|nøOâËMi<w¬k:oœ¿oÓuKÇºŠæüÊ<ÂÅÃ.8ê2í&‘©[ëZM–±iŸ\"úÞ;˜³ýÇPÃô5ü÷×ïÂr[áoƒXõ>Óÿ\0ôž:ÎªŠ( AEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEPEyi€ÿ\0ï$Ó|gñ?D²¾‡‰-o>xÏ£GfSÇB+Ïäÿ\0‚…~É±Èc?§8îº%ñ˜†€>Ž¯Íø+ü”ÿ\0Ø\Zëÿ\0GŠú¢?ÛûöO‘w/Å½¤Þç|‰ÿ\0:ñ&ã|2ñW‡o>×¦jÞšîÒ}Œ¾dO*•l0d„P4|M_{xcáO…þ#þÂ¿æø‰ãëoø_@Öµ]GP½š=óM¹¸DHøÝ‹`uî@=+â¿‡~¸øãÏxÖCºî¥o§«ždKc¾\'ð¯qý¹¼{÷Äè¾\røcýÁÿ\0í¢ÑtÛ8ÏÈfXÓÏ”Ží»äÉÏÜÏñ\ZhÝ|Býü(M—‡þø³ÆmÊ/õrk?7ý­È\0Ýj¼?c{¦òuØäÅ	êÖÞ+¼Þ?ñåþuóöƒ~~È<I¦GðgÄZßÃ¯[ÝÁqk£xŠO>Îô¤ŠÆ8çÜÌŒ¶IÆíÃÁ@£hÿ\0jï1R7­‹Ž¿èpŽ?*ùæ¥·•\'†FŽHØ:2œ#Aìkë—+ñÃöUðí¨*?Š¼?~Þ×î€ùîÕUšÔ€çÖSí@&Wï‡Âoù%~\rÿ\0±Nÿ\0Òhëð>¿g ý§>	üðg|-ñ#Æk¤jw^Ó5 6sËº‹b¶cF´N1œñ@™ï´WÏ~ßÿ\0²„}~\'çýÝ&ðÿ\0(ªæ—ûuþÊº´Ë,áfà«;˜ñ/÷Edx_Åþñ¶–šßƒüE¦ëV}Û‹”š<ú¤àûk^€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n+Å5ð‚l[Rñ‡Š4­ÕF|Ûë¸àSôÜFO°¯š¾#ÁI¿gÏ¬¶¾›Sñ}òp«a•oŸy¥Çê­@W×ç/íËûhøšóÄ×Ÿþê7±ZËö-cR²\'íWí6Ð2œ…íb>flÀç‚ø•ÿ\08øÙâµ–ÇÀúN“áGÊ‰c_µ]cýùÁø úÔðMŸ‡:ÄoŽúŸ¼Q¿ÿ\0„VÈêQyÃvëùež¥GšÃý §µµ¯„?ðLˆ~6ÒíüIñGÅ±xU/N¶1Àno€lÞ†*¨Ç\'#$Žüñ^¥ÿ\0ðýÍÿ\0ðÿ\0}ßEsáøtï€ÿ\0è®kÿ\0ø/‡ükÇà£~·øu\'ÂOYßKyƒáwÓã¸‘B¼«Š¡ˆq_ª5ò/íÕû8øoâ¤Ú/ÄÏ|Rµðg‡¼/fö—³Ëb÷,Þl«°¨Väãâ€Løö7Š9¿j‡+ È\ZÊ7â¨Ä~ W?ñÊK\\øùã»{[Yîï\'ñ6 ‘Åm$ŽEÃ€Œ’x¯®ÿ\0f_ÙËövÇPüXø{ûD]ëü:ž-ST7š)´¶XÈ|n•Ø+ò3Ò¸ˆ_µÇÃ†)ñß³ì¥ÖõBæî÷ÆºÌk–’Y0µ†0I\0ž£ªçšy_„b_Ú[Æ«}oðÚëK¶nDºÄÑØŒzí”†ý+¢¸ÿ\0‚yþÒQÆ^ÏJðî ê3åZë¶ìÿ\0€$f¼Æ¾/|B¹{¯üHñªÎsåÍ} ‰}–5!{\0sV\"ñ•0¸ÒõÝFÎPr$·ºxØªh¦øðOâÇÂ¹JxûÀ:Îí«q=«yÙ”eç^Íày^oø\'ßÄ‹y9KéÒÇžÌÉ\nœ~\0W5ðÿ\0öÓøåàØFâ\ry<máÙ—u£x•>ÛÑ÷]ï—_np08¯©¾èÿ\0³íIðgÅ?	þ\ZÞ\\|:ÔµNßÄ:¶ŠP]y\rPÆÑI]ñƒ¡Ê“÷@\"€?8kõsÇ±…ÿ\0iMá÷ŽµÏjº4Ö>	Ò´•·´¶Õ•¥Ks’f#ìŠùOýœfxŠø7ö¤¹]zêélmíõOÏIpÏ±c\r»©cŠýbðŽ†Þðž‹á·¸¶“§[X™BàHbSv;gnq@3â£ÿ\0Ÿø{ü?<D?íÊ\n¡ªÿ\0Á\'|4mûã¦·ANÁu¦FÑ“Û;\\?:ûîŠsñÏÅý£¿`¿ˆ6Zõž¤Ð[\\I‹{û6y4ÝIÉ†d àrŒ7ª{×éÏìßñëÃÿ\0´?Ã[Oi1­­ìmö]VÃvM¥Ò€YGr‡!”÷Ô\Z¹ûCü1Ñ¾.|ñ7ƒu‹8æi¬%žÊF\\´q¡h¤SØ†ê	\r~xÿ\0Á6~1ø{áŸÄø_Æ¾(²Ñ´~År_\\ ûd2|¿3aT”w‘œ\nsõVŠ¯c¨éú¥²^i—Ö÷vò¬°J²#fRA«(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢šÎ±©’F\nª2Xœ\0(ÔW‘|Hý¬¿gß…jñø£â^“%âg6:t¢òç>…\"Ý°ÿ\0½ŠùgâGügMåµøKðÞk¬d%î½/–¤úù±$}dØP?@ë‡ñçÇ„?ay<uñAÒ$@OÙæ½CpßîÂ	vü~H|Hý¶?hÿ\0‰†XµˆWz5œ¿zÏBf±‹Ý%öÌÇÞ¼Bêîêúáî¯n¥¸šC—’W.Ì}ÉäÐ;§¿¿à©\n4?2Óáçƒõ¿\\&@¸ºÛejO±%¤?Š/ã_,üFÿ\0‚‰~Ò<Zézí„¬¥Êˆ´Ks¡ë´…¤ÝJûb¾c¢ØÑ×<Iâ/_6¥â]{QÕ¯’××O<ŒO\\³’MgQE\nûóþ	7ÿ\0#Ä?_±XèÉkà:ûïþ	7ÿ\0#\'Ä?úñ°ÿ\0Ñ’Ð&~QEóü+þMSÅõÞÃÿ\0J£¯¤+æÿ\0ø(Wüš§Š¿ë½‡þ•G@ž_²ÿ\0Æø\'LñwÂ_ŠžÕ5|CŠÚÖî]*EK»Ycs±×q\0®XÏðŽ}câÇÁØà×.¼ã/|\\]VÎ(f•m\rœ¨XÖDÃ}œsµ…|sáÿ\0ùi¿õùþ†+ë_Û†÷àœ?´wˆ#ñ—†üqy«=7Î—MÖí-­ˆû;v¤–’0ùqœ±ÉÉã¥¬þÿ\0Á=&ð®ã\rWâOÅOÕæž?ûA­VK‘	Q$ˆ‰jÇ`fÛ¸àCQ¯Âø&›0_ø^ž?8æHù\n¼/ö“ÜxÃMÖ<8›|}¤Û	*GŠ W‹«0”KŽ²oâä”õïŽ>ÿ\0Á?~øšóÂ¾ ñWÆµÙìo2ßìC<n¡ã–\'ò0ñº2²°ê®ßH±ý•e¿økö¡ørŸ<Iâ·YxrÛV¸µH£Æï:Ç\Z ƒÝóžÇ„ø²çáž›à\0i´ê~+ƒIyÑ58,ä·Ód“u”WFky‹È³(vÆñƒž6öŸ´,Þ›ö5ø(Þ±Ôí4£ªkg‡RºŽâá|û·Iq«|Ù#009ë@-ð_T¹Öÿ\0hÏëW»>ÑãM:êmƒ½ïQ›°É5û¥_„?\0äºü:ÿ\0±¯Iÿ\0Ò¸«÷z€aEPI[RÇöuÖîžKçþù5üùÞÿ\0Çäÿ\0õÕ¿™¯è+VmºUëz[ÈñÓ_Ï­çü~Oÿ\0]ùšŽ“Á¾%|6»Kßøë[Ð¤VÝ¶Îñãýž0v8ö`E}=ðßþ\n}ñ«Ã&;Ohº7‹l×¥1›;¿®øÿ\0vûu¯è gëoÃŸø)7ì÷ãFŠÏÄrjÞ¼~ûJ{lûMn=ÙV¾“ð¿Ž<ã{%Ô|âÍ\\µa»ÍÓ¯c¸_Ä¡8ükùÿ\0­Oø§ÄÞ¾]OÂ¾\"ÔôkÄ9[>îKyÑƒ@Xþè¯È?†ÿ\0ðQ_Ú7Àk®­«ØxºÍ05¨YæÇ´Ñ²¾}ÛwÐ×Ô¿\rÿ\0à©	õï.Ïâ?…5]6¸¶{iîId_ûá¾´\nÇÚôWà_	¾([¥Ç€~!hzË8Ï‘ox¿hO÷¡b$_ÅEvÔ(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢±<SãoxÄê^2ñN•¢ZŸ:þî8ý‘š\0Û¢¾Nøÿ\0(ýŸ|ç[x^MSÆ‘åTiðy6å‡¬²ãuVöÍ|µñþ\nyñ»ÄË5Ÿ‚4}Âv²«\"Fnî”{Hø@~‰@ì~¥êz®—¢ÙÉ¨ë\Zµ¬C2Oq*Ç\ZýYˆ¼â7íåû6|;Y¡ÿ\0„Ý|E}Ñt8þÕ–Ãæ‚\"þ_’^4ø©ñ#â5Ó]øëÇ:Þ¶ää-åì’\"ÿ\0º„íQì\0®ZØû¿âGüOÆz–Óág€l4hÎBÞjÒ©±ê#]¨§¡ä°ú×Ë_iŽ¤øM¾$k–ïÿ\0.qMö{oûõÔ?ˆ5æ´P×“EP0¢Š(\0¢Š(\0¢Šë<\rð—âgÄ»¥´ðu­qÙ¶î´´vÞ“{’\0ru÷ßüoþFOˆgþœl?ôdµåSÿ\0Á;þ5h?uÿ\0ˆž9¾Ñô+}L¸ÔšÀMö›©|¤/³÷»\\àäï8ô5êŸðI¹ã&ø…m¸ok\0öHó	Ÿ¤4T7—vº}¤××³¤6öÑ´ÓHç\nˆ –b{\05òÎ›ÿ\0*ýšï<Aq¢Þ^kú}´341êSéÛ­¦\0ãzùlÒ=FPj	>¬¯›ÿ\0à¡òjž*ÿ\0®öúU{þ-|2ø•n·>ñæ‰®+.í–wˆò(ÿ\0j<ïSì@¯ÿ\0‚…ÿ\0Éªx«þ»ØéTtù	áÿ\0ùi¿õùþ†+éoÛãÁÞ.Õ¿iÏ_é>Õïm¤²Ó6Íoc,ˆØ²„2©b¾iðÿ\0ü‡´ßúü‡ÿ\0CõíÙñ3âG†ÿ\0ié^øâ].Æ;=1£µ²Õ§‚$-c	8DpI$àu&‚Ž/Å3ŸàŸƒ|7ð†ïÃ:·¯éíq«kQë–ítÉ®Ö6KHA#c‘\ZQý÷ÚyC\\’|{¾VVÿ\0…[ðÜí9ÿ\0‘u?øªë|Qà[ã§†t/Œ¶:¶‡§ë:«M¥ëË¬jÐiéuyj±¨º…§ey‘<fM¤‘ b~ø®Y?g\ZHÊ«â¯‡ÿ\01ÇüŽZwô–—þ6xcÄ<IÆèš†©¤xÞ3~«iÏö¥Â\\Y¾Àvùn>@å›GŠô/ŽZ~¡¤þÅ¬5K‹;˜õ-k|74r.gr2¬\Zá¾-xëÆu‹ƒ>ñ6¯ Øx)\ZÊê]6úkS©_¾æåö2îþXóÒ4OS]ïÇ­gXñìcð?V×µkÍJú}KZóno\'i¥“¸Éc€\0äô#ðþK¯Ã¯û\ZôŸý+Š¿wëðƒàü—O‡_ö5é?úW~îI,pÆóM\"Ç\Z)ff8\nRIè(Ex×ÄoÚÿ\0övø`²Gâ‰zeÍâd}‹Ko¶Ï‘Øˆ²ñüDVoÀoÛ/áí	â[ÿ\0ø=ukRÎs:œ	Ú¢hŠ»gƒƒƒœppö­kþ@÷ÿ\0õë/þ‚kùöºÿ\0©¿ë£:þ¼A2[è:•Ä‡	œÎß@„šþ~.›uÄ¬;»Ö¢:(¢‚‚Š( Š( 	m®®læ[‹;‰`•VHÜ«)ö#‘^ßðßöØý£þ$VºWÄVÊ,bÓZ_¶¦8ùw?ïq•†;W…Ñ@£?à«\ZDâ?Š¿.-\\ád¾Ñf&{±†L0G\'ë_Rü=ý«ÿ\0gß‰Þ\\>ø¤É1‹+é~ÉqŸ@’íÜÝÍ~Ò«2°e$ÐŽÔ\nÇô0®²*ÉVV QN¯Ã‡_´¯Ç/…rGÿ\0oÄfÞÞ3‘g=Á¸¶ÿ\0¿ReGà}Gðëþ\n­ã-=¡µø¥ð÷OÕ¡Y.ô‰ZÖl{ËrÈÇØJcô®Šùïá¿íáû6|GhíSÆëáëé:Zë±ý“ŸA)&\"}·óÚ½óOÔtýZÒ;ý.úÞòÖQ˜æ·•dÇ³) Ð\"ÅQ@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@ûtxÛÅ¿g{ÄÞ	×n´}R«(RîÙ¶È‰%Â+€{d3_Žš÷‰<CâBM[ÄÚî¡«^Êr÷×/<õg$×ëŸüYw~Ê>&>—šiÿ\0É¸«ñî‚QE(¢Š\0(¢Š\0(©mmn¯®#³³·–ây˜$qD…Øô\0IúWº|7ý‡ÿ\0i/‰‹Õ‡€&Ñ´÷Çúfµ\"Ù®q~õ¾ª„{ÐƒQ_£ß\rÿ\0à•\Z%¯—yñ_â-ÅóðÍe¢ÃäÆ=Aš@Y¾¡V¾¦øqû,üøT\"“Â?\r´¤»‡•½¼íw9õK¸ƒôÅ¹ùðçöføëñ[dž	øo«]Ú¿ü¾M¶·×Ì”ªŸÀ“_S|9ÿ\0‚Tøªùa½ø£ñÏJC‚ö:Tâ\\z\\ª©ú+Wé*ª¢…E\n£ \0RÐ+Ÿ?ü;ý„ÿ\0f¯‡~UÄ>‹]½Ýkr²ÄwòÛ÷CðJ÷›+6Ö;-:Î[x—lpÃDAèSÑ@Œox~ø?\\ð­Çú­gM¹ÓßýÙbd?ú~T~Âþ<“à?íA/ƒ|aþ…µçx^ðJvˆ.ÄÊb\'Ó÷‘ìçþz\Zýp¯Îÿ\0ø(—ì¥ª6¥?í	ðçMyP¨“Ä–¶ãç‰qx rF\0ŽAºn \Z>Îý ¼!â¿|ñ‡ƒ<x–ÚÎ±¥ÍklÎÛD›†\Z2ßÃ½w&{n¯Äï|/ø…ð·V}â„uíX¨P’c<£Œ«Ž:©\"¾ýý“à¢¼Ñôï‡/Î©ZªZÚxÔ›{”UÁ)\'\\È~SÔ‘Í}·y§ø;â‡ÄwÖzOˆ´]B0Ê$HîmæCÐŒåOÔPƒÞñE×‚¼m¡x²ÎîâÚM\'P·»2[±W\n’+0õ\0ŒWè?í]û\\|	ø×û2x‹Að_Œ3­ÜIdë¥ÝÛÉÁÛq6ÝÃk`NÖ<\nõoþ	Íû=j2²ñ~‹m«hbÖò;É4ë;Ö’”`ÛvÈ¬QI…8Ç@+–ý¿¾üÒ~kß´‡Ú>›â+‹Aí¸·oÞNŠÛ‚a[!PzÐ3óÃÿ\0òÓëòýW×Ÿ·…¾ß~ÑZÝï‹¾)jú.¥5Žœd³·ðÏÛ0-#U\"_´&ì€6Œg×È^ÿ\0ö›ÿ\0_ÿ\0èb¾ƒÿ\0‚†6ïÚ‹_ÝÓô±ÿ\0’që@Î\'ö“ò´Ïižðì…¼¢éVßð‹ºœ¥Í¤È²ÉužòK3HÏÝXlþ^G^ó¯k¾ðOÃx\'âG‚‰üAmÖ¨-å¾šÍ´›¶I ·fˆåÚLö·ÜŽ2íŽI¼}ðophþÀ\0=Ä—§úŠvž*Ñ~øŸÀ~ñGÅo_økÅWº[Âÿ\0eÑÿ\0´þÂò­.eýì~[lSêYbVã©ì¿h›?Ø~Çm|/­Üjúlz–²!¼¸³û#Ë™œœÅ½öàä}ãœg½yíi%ç­¼y§å¼7âí>ývÞÕb6`v6ììüUê\Z!+ûü›±Ôµ‘ùÜKþáõM;CøÃàmkX¼ŠÒÂÃÄšmÕÕÄ­µ!‰.cgv=€PI>Õöÿ\0íÉûe|%ø…ðžëáŸÂ¯^jZ…íô\ruqmm,Víl…‹¦÷\n[,€8¯†þèšg‰¾,x/ÃzÕ·Ú4íWÄ:uÜ;ŠùËs\Z:är2¬FG­~¾øóö7øã/‡2ü7Ó|\'gá‹I\'†áo4‹hãºq™IpA †ÏZŸŠ½kë_ØWö~øÛñÂß,<?}£xoI¹3ÝjW‰ä¥ÄJ¼Q«a¤ÞÜœç¥}íð‡ö3øðe£¾Ð|#©«G†þÓÖº[Õ#ÿ\0€¨>õÑ|`ý£¾ü	Ó^ãÇ~*¶‚íS÷\Z]¯ï¯&8à,KÊƒýæÚ¾ôÌÚóâ¦Ÿð—àŠµÛ‹€—ÚœšN™~i.®¢ã×h,çÙ\r|[ÿ\0Íø+ xúûÆÞ.ñÇ…ôýgD‚Ö&oí–hžwo1ÈÜª‰Èé¾¼·âoÄ¯‹¿·ÆkøkH•mFIÒ–OÜØÛîùî\'~›°Ag>G`R~üÐ¾ü1Ñþhl%ûfKË­»Zîéù–Sõ<ÙBŽÔcÅ~#Á7gŸ,·²Ô<!}&J¾ŸpÒAŸxd$¢•¯–>$Á0~4xgÌºð·¥x¾Ød¬A…•Î?Ý‘Šô~Õú¥Esð;Ç?\n¾$|3¼6>>ðN¯¡ÊÚí™Q¿Ýºß®V¿¡;í?OÕ-d±Ôìmîíå]²C<K\"0ô*À‚+Á~$~Â³oÄ†’êo.|ù?jÐäû!Ï¼`Ïâ´çã5÷—Äoø%W‹¬Z[Ï…¿¬uHz¥ž­·˜{y‰¹ñ_-üFý™þ;|(i[Æß\ru{Kh²Mä‹›]¿Þób,€wä‚;â€¹æ4QE\n(¢€\n(¢€\nêüñ[âWÃK¿¶xÇ\ZÎ†ùË-Û¤oþôyØßˆ5ÊQ@Ð†“4³é6SÌÅä’Þ6võb “Vê¦»t›%ô·Œã¢­Ð@QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QEó_üIw~Éþ+?ÝºÓOþNÃ_ûÿ\0\\þÉ~0>“é‡ÿ\0\'à¯ÇJ\nAEP0­/øgÄ^,Ô£Ñü1¡ßj·²ýÛ{;v•ÏnŠ½~žþÎ?°Oì÷/Ãÿ\0\nøûÅZ÷‰µ-cJ´Ôž=Bí…´o,JåDQí$a÷{×ÖÞð—…ü§®“á?éº=šãXÚ¤)Ç¨P3@®~Nü7ÿ\0‚sþÑž8hn<A£ÙøBÂ\\;T¸F›oˆ#,àû6Þ•õ\'ÃŸø%¿Â?´7_<U«ø²eÁ{xGØ-˜úŒÒôqøWÚ”P+œo€~\rü+ø[“ðûÀZ6†Jíim­‡œÃÑ¥9vüI®ÊŠ(QE\0QE\0QE\0R2¬ŠQÔ2°ÁdKE\0|sñëþ	·ð×â5Íß‰>êð†ëS³M%°ŒÍ§ÜHrOÉÐ’Hå2£%|}y¡þØ°þ¬o­äÔô%¦ÿ\0_në{¤]óyE-Œ|Á_éÅ~ÃÔW6Ö÷–òZ^[Ç<)I#‘C+©à‚JsáŸ‚¿ðT/ëñ«Ã­áë“…m[Oß=«ž^‘þÿ\0\nõÚãâ—ìå®|$±ðÄ¯ˆ—º~“ã˜bÔ4Û­\"ÎK™&‚)A\"áB“´|Ø\'\'\rg|lÿ\0‚uüøö[Á±7‚5ÉAo6Â=ör?«Û\0÷ØW×šùGþ\nà«Ï‡\Z/ÁŸê7Ý]è>–ÂY¡$†9nPy\0ûÐ%—ƒ?àŸö7–÷‘üsø€ío*Ê èg©ê½ªÚ_ö´Ô¼WñSÖþk–RøjK{Híd½ðÝ›ÊÌ\"É“qI÷Ãc\'§N+åúíü+ðóÃ¾$Ò¢Ô/¾.øKA¹‘˜5Ž¤·ÂXðÄZ;w‘ÈÃ8<P3Ðþ ü?ñçÇ¡añÃÀ~ÔµëŸo‹^³ÓíZ_ìíJÝQ|£ˆåB’ ÆæA÷+_ÙŸö€‘‚¯Áÿ\0dñÿ\0 é?Â´h)_ÂzÆ“ðwEœ6…à»E6—Qð5)îãŽyï²:¬„ OHãAÁÈ¯,‡RÔ u’Bæ6S•e•ð4î^5ø¥âï‚vÚ_Á_ÞZA/…_í©®tûkß7T˜«\\\"yñ¸D‹É€Æ6nr+Õnþ4~Î¿¾øÀÿ\0¾#ëú7‰<7qwqpú6‚‚72JûØãå”û sœóšòßø/Kø¥á\nüWñ\'Ä\rÂzæ½i%® šÓN¥%£Vú/&)B«–2Fäg\'+âm\Z×ÃúÕÆ“gâ\r;[†\r»o´ó!‚\\¨?/˜ˆÜg*9ë@PøEýƒ<ãoø¾×ã§ŽäŸCÕ-u(’ã@>[<2¬Šl{¶’£8çúñ£öµø3ð;I²¼ñF½%Õþ­bšŽ™¦ÙBÏ=Ô’tÚˆJ‘¹Èèzâ¿«õ7Ç±,?´~½ðóÇ¾\"ñ“i~Ó<£é’YÚAºîåÓÌ‘°ìvÆ¤Lì1àñÞ€>wøµÿ\0øáñzëþ?„º<¾´¼Ãz~nµ;rù›~Bx8AÞ\"ð‡þ	Ïñ§â…÷ü$ß5)<\'cvÿ\0h™îØ]jW[ŽI)¿äcë!ÏªšýøKðá/Á\r4X|:ð}¦Ÿ+.Ù¯Ÿ2ÝÏÓ;æ|±ÚQØ\nô:sÎ¾üøgðÃÿ\0Ø?t¶yU~Ù})ó.¯’~Š0£°è´Q@‚Š( Š( Š( &øû)þÏÿ\0<é¼]ðÓKkÉ²Mõ’›KÇø·ÂT±ÿ\0{#Ô\Zùgâ\'ü—E¸óo>üL¹³nJXë6¢e=xó£*W·T5÷ýçâ×ÄØöøf³]ê_®5M:ÿ\0§hò¥ÚêQ˜¿ð$á³Á=¬ÏouËxäR¬¤uA¯è^¸ß|øWñFÝ­þ xFÖ÷.Ï6æØyÊ?Ù•pëõ(Ÿ‚ÔWÛÿ\0·wìð›àOôïˆµlžÿ\0YN}>k¯>GŠY2¥Ác–<_P0¢Š(ý\nX®Ûuô‰è*zŽÛkè ~•%Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@9ÿ\0ÁBWwì“ãSýÙ4Ãÿ\0•q_Žû%ÿ\0]ß²/Ž÷N–ò¥k_´‚Š( gîÇìîÛ¾ü;o_é‡ÿ\0%’½¼çöomß³ÿ\0Ãvõð¶™ÿ\0¤É^AEPEPEPEPEPEPEP^ûJþÈ~	ý¦.ô]KÄž!Õô‹Í)`†K,‰#vC+©èGc­{Åðòÿ\0Á(þíùþ&x°Ÿhí‡þÉ_~Ô?ô?µ†z«y¨ÙéÐÚÊ—D¬e$ ì\0p_ŽÕû‰_•¿·gÄ7Ãß´Ç‰´›¯…ÞÖd†ßO?lÔmîwÝgÃ™WŒà`t£ÌõoøVëð—áêüh_ÿ\0o}žôéßØf´dy£ìÿ\0jó‡O3Ïò±ÎÎ¼l®R3û/ù‹æ\'Å\r»†~m?§åW?heñž±¦|eÐ­[ûÆ6¨ZÆ\r2âÒ(àšËîªmF=ctêrkÊWMÔ‚-Áf8\0DÜŸÊžûDÇqÄ!öLÂ6Ú}£x_Ë$Åý“å#oû]|Ïúiæf¾›ýš?àŸ¾7|Ð¾%ëž9ñŸ{«‘%½¢Aå\'—<‘ŒnBy^¦¼?ÆÞ2³øcá¿\nü&×<áÿ\0ë>µšmIµˆ¦ìÙ®œKö(ŒR&`‚àç<€c?¥±¯o®þÌþÕm´=?HŽs{‹==]`r”;3sŒœ“É4<V?ø%/ÂU‘ZO‰^-t•	l2=3²¾ÓÑ4›ME°Ðl7m6Ö+HwŸ.4\n¹=Î\0«´PHQE\0QE\0QE\0QE\0QE\0QE\0QEñ‡üI±ðÃ£×ÅPé%Í~Y×êGüY¿âÆxa}|Yþ‘ÝWå½ ¥UÜÁ}N)*[UÝu\núÈ£õ gô+KEQE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0|õÿ\0\0]ß²7Gû:aÿ\0Ê•­~4×ì×íò»¿dŸúg§ŸËP¶¯ÆZ\nAEP3÷Göimß³ÇÃFõð¦—ÿ\0¤Ñ×¥W˜þÌ-»ösøfêTÓål‚½:‚Š( Š( Š( Š( Š( Š( Š( Š( ¿,ÿ\0n‚Þ6ñ—í-âME“@·úz »×ìmeÊÚD§1Ë*¸äq‘Èäq_©•øÿ\0ÿ\0Çü5Wˆ1ÿ\0>\Zvð(\Z9ˆ<ñÇÀµ°ø+àjšžSq®Þiw’[KR¸Dw%ñD›#Œô;Y‡\\‚þÑ_ƒ¯Æoäó­Üýž»mcEð¾x#Æ?¼hÞ×%K½6Þëû6Ké5>Ù‘!ÕòÉx¾\"\0r†¹hüð5¤UoÚ`¤ŒŸøDîøå:¯\Z|1ñÆ«]/ãG…¤Ò¢›Å)/öÕ¾¡ª[XìÔá*“Éžéæ$™Y2¹ÚÎêq_¥¿±7†µO~Í~ðþ³ö_µÛ}³Ìû-Ôw1ü×r°Ä‘3#pGCÁÈ¯Ê¯Ú9äÓü~<`¡<9á‹(,|>å&±d­Ð#†3—31õr;Wêüüÿ\0Æ\'ø+Ûíÿ\0ú[5\0Ï¡è¢Š	\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€>(ÿ\0‚¬7üYO\n/¯ŠPÿ\0ä¥Çø×åÝ~Ÿÿ\0ÁV›þ,ï„W×ÄÀÿ\0ä¬ßã_˜‚¬é‹»R´_ïOÿ\0Ç…V«Úï×4õþõÔCÿ\0þƒh¢Š\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€<öò]ß²gÇý0±?ù?o_Œ5ûCûv.ïÙ?â\0ÿ\0§[Cÿ\0“°Wâõ ¢Š(û“û,¶ïÙ¿á¡ÿ\0©_O”*+Ô«Ê?eÝû5ü5?õ-ÙÊ1^¯AEPEPEPEPEPEPEPEP_•Ÿ·_‰~ÙþÓ\'³ñ7Ã[WÔ ƒOY®¡×´m›8™@ÉlaX¼œšýS¯ÊŸÛïà×Äß~Ó\Zïˆ¼/ðÿ\0Ä\Z½†¥ea\"ÜØéÒÏd·HˆÜŠFA¥GŠþÑÖñÞx›Hñ—‡Aÿ\0„3^Òm¿á\ZEû¶¶ðF±Kh@àIªáñ÷‹o<½y%{ßŒ<m®|\nðþ‹ðRÏNÑ¯5æÔ¼Cý¯¤ÚêQÛ_\\¬d[B·â?.%ŒI´dg¢¹(ÿ\0hoE\"È¾ðT‚?â‰Ò{Û½Œ5ø[Àþð—ÅOÜx“Å\Z~—$²}—S6RéöSÉæÚÚÎB9‘Â1p6,ª¼ô¤ÿ\0±æƒ}û4xJëÃ:,úNœÿ\0mòm&»ûKÇ‹¹CfB«»$ÓŒâ¿3>)ü:ñ¯ÅÍV|+«ëÚ7ÝßG§ÚÉrÚv¤¸Vòlªï;ãÏXÝGPkôÛö%ðÎ·áÙÁzˆ´»­;QŽ;¹\'µº‰£–-÷s2†V\0‚T©Áõ L÷*(¢‚BŠ( Š( Š( Š( Š( Š( Š( ‡ÿ\0à«mÿ\0—Á«ëâ&?•´Ÿã_˜•úoÿ\0]oøµÞ\n_]~Cÿ\0’ïþ5ù‘AH+KÃ+¿ÄšJÿ\0zúÿ\0‘³k_Áë¿Åº\"{Q¶ùhýQEQE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0xOíÊ»¿e/ˆ#þœ­ÏþMÃ_‹UûSûo.ïÙWâÿ\0¨|\'ÿ\0&b¯Åj\nAEP3÷öImß³?Ãcÿ\0Rý¨ü—ëuãÿ\0²ný™>ú€À?,Šö\n\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\nðÚ·ödÿ\0††ðå£è>(¸ð÷Š4€ÂÂñf‘`•‚ÑL¨rWŒ†\0•9ê	ïPæoÄßØ+ö€ø•ý•âi¬tHüY&ÃÄI¨ Ð„[{ÈÈRK<XY7\0wÆ[ø«ˆ_ø&_í,HÜžþÂŸý…~´Ñ@î|¡þÁÿ\05ÏxwÃ:çˆ×Ã_<!`±¼a}«LÄ=ÍÁ6§›  ;–5AŒŠû·NÓí4>ÛKÓá[ZBC$íE\0(Éäð*Í(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0ø[þ\n¾ßñmü¾ºäçÿ\0%Ïø×æm~—ÁXþ-ÿ\0€××X¹?”ükóF‚Vß×w|>¾º¥¨ÿ\0ÈËX•Ð|=]þ>ðÒÿ\0{X³ù(û÷EP@QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QEâ¶Âîý–>!ÿ\0Ø5þLE_Šuûaûi.ïÙoâ ÿ\0¨P?”Ñ×â} ¢Š(ûoû¶ïÙ‡áÉÿ\0¨,còfì•âß±“ný—~ú„ùHâ½¦‚Š( Š( Š( Š( Š( Š( Š( Š( Š( Š( Š( Š( Š( Š( Š( Š( Š( Š( Š( ƒà¬Mÿ\0GÃõõÕoþAOñ¯Íjý%ÿ\0‚²7üR?×R¿?ù\n/ñ¯Íª\nA]\'ÃUÝñÂ«ë­ØüŽ•Í×Qð­wüOð‚ÿ\0{^ÓÇþL%?|è¢Š\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€<cöË]ß²÷ÄQÿ\0Pv?”‰_‰uûoûb.ïÙ‡â0ÿ\0¨,‡ÿ\0ZüH ¤QE?k¿b¶Ýû,ü;?õaùM ¯m¯ýˆÛwì­ððÿ\0Ô>Qù\\Ê+Üh (¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¬OxãÁ¾µ‚ûÆž,Ñô+{©–Þ	5+Øí–iY‚¬h\\ÌI\0ÉÈ¯\rý±¿m¿þÆúw‡dñ_„µÍ~ÿ\0Å_lþÍ·ÓÌIû7“æyÒ;e?ãâ<mGÏÍÓ€}Ey—ì×ñ›þ\Zà†>2Â>41âX®&\ZÚ¾ÑöqÌ°…ó6&âDyÎÑÖ¿?nÿ\0Ú“öÒÿ\0i¿ˆþÒ>7xËJÐ4eílôý3V–Ê(á¸LBWpçø³š\0ýÕ–XáæšEŽ8Ô³»’I=qWÿ\0~éLTøÇà{6+¸ÚFHõù¤Wç÷ìCñKUÔà™µMsY»¾ÔôüN‚{«†–W2iQË.Ä“™$aÏ¡¯É\n\0þ¡<Iñ+á×ƒ|7oã/xûÃš‡ï<¡o«jZ¬Ösy‹º=“HÁr‚W2+™Ò¿iŸÙ¿]½MÐÿ\0h/†Ú…Ü¬;{_ØK#’@\0*ÊI$?_	ÿ\0ÁMõO³Á=~éñ¶\Zúÿ\0Ãû‡ª&pÇÿ\0)_”º·~×´zxÚ$[ˆoíÜÿ\0\ZG9]Ãþø	 êBŠø‡þ\nÅûDø£àÀ}3ÂþÖ®tÇºƒØýºÖSöö {ƒ¯*Ì^ò9#àƒŠüwøWñÃã/ÀÏYøÓá¿u½å§ûVgû-ñ\r†DO—:’0ÁüÅ\0FŸ>%Y|øWâ¯ŠzŽ›6£mám.}NKH\\#Î#Rv<)=2zWçWÂoø+Å_´—€þøwáß‡¼+áoëpY^	¥–þý¢9Ý‰¿w\ZäùäHõ­Ûöæñ6©ûü&ø©àÍA¸Óþ(»èzµŸÚ­&0¯—soÃ+„$€ÊÅq_:þÏ?·Gì«ài^$øûø{DÖ4«„¸µ×¼$…íäo[k™;gþ{üPíÍçûB|·øˆß	uˆÚ6ã·†èh÷óýšyTžY“)*s¶2Ä`äq^‡@Q@Q@Q@Q@Q@Q@ÿ\0ÁY›þ)Ÿ‡ë}¨Ÿü‡ø×æõ~ŽÁZþ$_\rWÖïT?øå¿ø×ç ®·á\nïø±à¥þ÷ˆ´Ñÿ\0“1×%]Á•ÝñƒÀ«ëâ]0äÔtýê¢Š( (¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0ñÿ\0Úùw~ÌŸÇý@§?–+ñ¿oÿ\0k…Ýû3üH_ú€\\ÿ\0*ü@ ¤QE?ia¶Ýû)ü>?ôåp?+¹…{µx/ì&Û¿dÿ\0‡çþnÇå{8¯z €¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¯™à¢ß\Z<qð#ö\\×<mðã\\:?ˆe¿±Ó­/VåhD³0ªÈ¬»Œjàdg#_MWÀðZ-cì?²ß‡´´oŸSñ­š°õ,ïÿ\0ãÁ(òÅŸ¾&ø›ÅšgÄoˆ^(Öuý^á“Pµ¾Õ/^âI9ÙFÖbJ¨’\'P£\0màcú?ÿ\0ÁšCMø©Û6è¦_<mê®ºsÐWÁ¼-ý—ðoàWŠ<½¿ÛžÕ£\'ÔÁ¯êùH?Jû#þ\n›¬ÂQû8~Ë*Ý¼ê~–ì·¯a¦½\0}Åÿ\0Ë“Íý‡>7¥¾¤¿–§v?¥~C~ÞÚ]Æ¡ûo|PÒìÐ¼÷:èX—»;Añ\'~·ÿ\0Á.¤ó?a_†~«ý°¿–¯y_›_´“kªÿ\0ÁY—E¾ÿ\0mCâW†íæÿ\0®r½oÑ\0?öOñÐÑÿ\0`Ú»Eiö}ž”Œý¾fµ8úìP~¢¾3ºÑæ³Ñ´ý^\\…Ô$cìÇ°góf…z‡‚¼Muà…>ßIå\\ëVúLEŸ½%–­oÈ±ªŸ<>t_„õÓ®hZµñõ;u‹¸?„#ðÅ\0}Ýÿ\0JÕ<¯ÙöpÑwÇÝµÖ=|­2ÏþFýkà¿Œž\Z„¾·—´êž:?Þß­ê£?’øWØ¿ðU\rWÌø3û,hêØÙàù®}wZéª¿úþuàß¶‡±þ~ÍwÛ1öÏ…vßŽo®fÿ\0ÛÖ€>•ÿ\0‚ÌkRkšOÀâäÇw¢jw«ÏyVÀ“ú\nó/Ú‹MÓíàœ¿²ÜÐÙÄ“d«…€–gy9ÿ\0i°O©·?à§Ú§öÏÂoÙ[TÝ»í¿ÅÖ}|Ëm=³_{þÆ?\rþüJýˆ~xwâg‚¼9â[c£ÊöÖºÍ„7AXÏ)fŒH¤«c¯<\n\0ü¸ø¹#ø\'gÀ(Y‰\râ¯2@&QüÉüëÙ?dÿ\0ø&€j/Ù§Bø­ÿ\0+^ðÇˆõ»ëy±k\rå‘Xn4\"#å¸8^zG°®Óþàü-øcðwÁ?<3a hêšíÄ61ùpÆî-ÝÊ¯l³“Ç5óOì»ÿ\0ý¡¾hþøAà¹¼9sá˜µ=±Úê\Z_˜ãí¤ýâ:9ùˆçŒý(Sþ\nÉ„ý³uûuéo£iÂÕõ¯Oý ?o?Úàïˆþx‹áoŽš=7[øEáËýKF¾….¬./7\\¤ÌcnQ‹&Òñ²1 œ\0+Êà«òoý¶¼`¿óÏOÒÿ\0$a?Ö¾}ø™ãøK<7ðÒÖI<Éü=á£Ì}6jÚ„±Â)£…\0K^\ZÔ§Ö|9¥kQ¢M}eÌ‹v†xÕˆ$ã\'Ö´«À¼x#ÃÃÓJ´ÿ\0Ñ+[”\0QE\0QE\0QE\0QE\0QEùùÿ\0joø•ü1_[Xÿ\0ã¶¿ã_œõú\'ÿ\0joô?†+é&®KJüì ¤Úü]ß¼¿õ2éŸúUqUÜü]ß\Z¼?êeÓô¦:~ñQEQE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0y?í^»ÿ\0fßˆËëáû¯ý¿+÷#ö¦]ÿ\0³§ÄEõðý×þ_†ô‚Š( gìçìÛ¿d¿\0{C|?ò~â½þ¾}ý›?²o}’øäôõôÙ$HÑ¤‘‚¢ÌÇ ©§PEPEPEPEP_™?ð\\-kìþøUáÝøûv­©^íõò!…3ø}£õ¯Ójü‹ÿ\0‚àë^¾øw~MŽ©^íôóæ‰3øýŸô ˜ÿ\0i|=Õ¿eßÙ£Ãþñ^™©kþÒ5øuëiÃÍ`g½ŽxVP>émòœx÷¯Yý´µøH`ÏÙ3TÝ»ÈÓoôüÿ\0×àƒù…y·Çÿ\0ØþoìµðÏöŒoM¬Kñû5¥Ó–-ÒÀ^X=Ú/™æ¹¨Œ®v®zàt­/ŒÚ¿öÇüöz…›shÞ&ñ6žÇ¸ÍÃLå ü1@§_ðJÙ7þÃ×þyÏ¬/þU.õ¯ÏÚ+ýþ\nélÿ\0Ýøá9?1`Õæÿ\0à¢_´—À‡:oÂß‡zž…¥I<–éw¥,òƒ4¯+åÉçævÅwÿ\0´eì—?ðU\r/T›Kx*éð0	{]5ÏºÐ~×>þÔ_<:ŠbŠ/j’DƒÜKròÄ=þGOÊ½öÅðùð×Â¿ÙšÄ¦ß?á„Wßøy=ÇþÖÏãZ¿ðU/ÿ\0Â9ûlxÖácÙ·m¦jq÷¬¢Ïã$N\Zí¿à©þ“à†V?,il4ý¸Æß\'	Ãm\0Aÿ\0<Õ<í7ötÑ÷qkð³NºÇ§šª¿ûGô¯¾7þÑ\Z§Æß|1ðŽ¡á{*?†^‹ÃvÓÛÌî×±\"Æ¢I+8|Æ½kþ\n9ªý¿Æ_,Õ²ºÁ¿BG£2Ï!ý*íà¡ÿ\0²OÂ?Ùßá_Â|5ðýÞ¨xš“\\’kù®ÓkwRF!>f”áq×ØP/íÝª[öyý’.7dGðñ­óÿ\0\\–Ö,~]l~ØŒ±þÀ¿²t9k=Qñÿ\0~¿Æ®~Ñõ¯Á5ÿ\0gZ¬·Pø=OHÕ¼¥,b¶žñâI›Ñ[UB}f_ÃãüNøãŸ\nxOáßˆ<I{ªhžK‹iìŠE˜¸<ª›Ws–`¿x±\0\00\0ï¿î.$ý‚ÿ\0f?´Lò4º—ŒØbNÔ¾…\0ç°_zÿ\0Á;dïÙ×âgìðûâŽþèZ·ˆæ¸Ô¥mRHÙ.]¡Õ.\"]I*#@3Ù@é_\"~Þµ‚¿²ì£ðßÄVÏm«ZiÞ%¾Ô-Ü|ð\\]Merñ7ûH×º\Zñ?…?·OíWðKÁö?þüXŸGðö˜%–-¤Ø]$>lÏ4›Lð;s$ŽÝ‹8 Lÿ\0‚š*ÞÁ@<Wi\"+©}V>×‚?àUóÄï	·€þ%x³ÀÎ¬­áÝrÿ\0I!ºƒopñsïòWÓðPÖ’ãþ\n%âˆåbÍöï\r£:“¦Xg§¹5Èÿ\0ÁF¼|ûh|MÓÖê:”ZÄG³ý®Þ;‡aÿ\0m$qõ€?~üÇ‚ôûÚÿ\0è¥­ºÅðWü‰ºýƒ-ôRÖÕ\0QE\0QE\0QE\0QE\0QE\0~zÁZ[÷_×ý­[ÿ\0mkó¾¿C?à­\róü4_Aªý&¯Ï:\nA]çÀ5Ýñ¿À+ÿ\0S&ÿ\0¥	\\zìø»¾:xêdÓÿ\0ôzP3÷nŠ( €¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢’Ô\0´Rn£u\0-›¨Ü(h¢Š\0(¢“u\0-›¨Ý@E&ê7PÑE%\0-›¨Ý@E&ê7PÑIºÔ\0´Rn£u\0-Rf€ŠMÔn 1ý§—wìõñ	ê_»ÿ\0Ð\r~×ïÇOêÞ,ø9ã/èmw¨êz=Íµ¬\n@2HÈB®I\0dúšü™ÿ\0†ýªÿ\0è’Þàu¯ÿ\0 hðZ+Þ¿á…j¿ú$·Ÿøkÿ\0Çhÿ\0†ýªÿ\0è’Þàu¯ÿ\0 w?Fÿ\0`Ýû\'ø\'Ûíãÿ\0\'g¯¡«Å?cø³á§ìóáøãG}3Y°k¿´Z¼ˆå7ÜÈëÊ§*Àð{×µn ‘$Ž9ch¥EtpU•†A¨#½\n«\ZˆãPª£\n `KºÔ\0´RRÐE&ê7PÑIºÔ\0´Rn£u\0-qž6ø+ðoâf¡¯ñá/ƒ<W}kÙ ºÖô[éb‹qo-^hÙ•w3 ã$žõÙn£u\0s\"øYðÇÅÞ°ðO‹>ø_Zðî—å#QÑíîl­|¨ÌqyPH†4ØŒÈ»@Â’¬[Ùßöºðí¯„.¾|>›B±¸’ò×K“Ã6Miò\0T„Å±€\0°\0kÐ¨ *ÿ\0†Ný–èÚ~á§ñšÚÔ~üÖ<Nž6Õ¾ø÷ÄQIÑê÷³’õ^E…„íÖ8ÂåB(À®ë\"ŒŠ\0ó¯~Î?~*k«â‰¼+â]Y`KQ{©i‘O0‰I*›˜g\0³`{šŸâÀ‚¯¬õ/‰Ÿ\nü3â{­>³ZÍªiÑÎÐEÛ°árs]öEå¾\'ý–g\Z^Zßø·à—ƒµ{›+(4Ûio4˜¤h­a]±B¤Ž€:]þ\rü)ø«¦éú7ÄŸ‡º‰lt¦/co©Ù$ñÛ±P¤ `Bü ;\nìr(È {Ã?ü	àßÅðóÂÞÒ4ÏCÐ¦oh‹h#•Ùå_+v»Hå†0Kõ®Âß²_ìÏàŸÇã¯	üðn—®Á\'›å¾—\Z›wë¾ÆØ˜v(Žq^³‘FE\0r¾:øMð¯â²?þøSÅ§Mó>Åý»£[_ý›ÌÛæy~r6ÍÛvÜgbç ®Wþ;öYÿ\0£iøUÿ\0„nÿ\0ÆkÕ2(È Ä\0~ø·Ä’øËÅ_<¬ø‚wŽIu]CÃvw’<j«4ÒF\\•TEROT‚âÿ\0€¿~!k-â?|ð/‰ugakýcÃ¶w—‹Â©’XÙˆ†p+ºÍ-\02a¶†;{xR(¢P‘ÆŠQ@À\0\0µ>Š(\0¢“4dPÑI‘FE\0-™dPÑI‘FE\0-™¥ Îßø+C¤ü6_úg©ŸÖÞ¿=«ôþ\nÌßñ0øp¾êGÿ\0‚¾.øQðwâÆ¿Â+ðë@“R½XÌÓ1aP þ)$o•A<õ$AHâëÑ?gUÝñãáúÿ\0ÔÇaÿ\0£–½gþÇûSÐ­¤àâñ®ËàÏìûGx7âÇ„|Y¯xoK‹MÒ5‹[Ë§MVeŠ91\nIÀé@\\ýL¢“\"ŒŠ	ŠLŠ2(h¤È£4\0´QE\0RQ‘@E&E\0´RdQ‘@E&E\0´Rn´\0QE&hh¤È£\"€ŠLŠ2(h¤È£\"€ŠLŠ2(h¤¥ Š( Š( Š( Š( Š( Š( Š( Š( ßvÓµAlp	Æ\Zø[âoü	>øëWø{ãoÙ÷Y³Õ´{ƒËýµIU‘“ó#.Opkî¶¯Îßø+ï‚|2¾\rð_ÄHô¨“Ä\r«6‘%âŒ<–¦$¿÷¶ºäg¦æõ hOø|W„è†ëø:‹ÿ\0Qÿ\0ŠðýÝcÿ\0Qñªü¾¢ØýAÿ\0‡ÅxGþˆn±ÿ\0ƒ¨¿øÕ}û%þÙ~ý«£ñ\r¾•á«Ÿê^0<–W7k;M»€•\nªð\n‘Ž2¾¢¿ëÙ¿d_Ž3~Ïÿ\0|?ã«‰œhï#Xkq%œ£k]„¬ƒÝ(½ëKQA4W%Ä,‘J¡ÑÔä2žA¸©h$k\Zøÿ\0ö‘ÿ\0‚Žxö{ø™qðÉ|	}â{Ëx¥½žÛPH	_\'ÉÁF$…ÚIãïWÓ_<}¢ü/ðˆ>!x‚M¶\Z„·ÒŽï±ITí3aG¹ü÷øóÆZÇÄ?\Zk~:ñÆ]G^¿šþá³œ<Ž[höÀö£ôþáú!ºÇþ¢ÿ\0ãTÃâ¼#ÿ\0D7Xÿ\0ÁÔ_üj¿/¨ v?Páñ^ÿ\0¢¬àê/þ5^Ûû*~ÜÖÿ\0µGŒµ/h\nu\rÛH°ûuÞ¡q©$È„¸DjÆ	f%ˆç¢5~(×êOüîÎÕ|ñ\nùmÐ\\>­gK·æ(!r>™$þ4GèXïY~\'ñ?‡ü ßx«ÅZµ¶™¤éµÅÝÝÃíŽ(ÇROôêN\0¨¼aâÿ\0øÂúŸŒü]ªG§hú=»]^\\É’±Æ½N$ô\0I Wãí‘ûkx³ö˜×[CÑÍÆà=>bl´Ýø{¶\'¸ÇÞ<eS¢ç¹æ%së_Á_¾iúÕåŽƒð—[Õtø&híï_RŽÜÜ 8å˜Ø¨=@\'8ëŽ•Ÿÿ\0ŠðýÝcÿ\0Qñªü¾¢ØýAÿ\0‡ÅxGþˆn±ÿ\0ƒ¨¿øÕðø¯ÿ\0Ñ\rÖ?ðuÿ\0\Z¯Ëê(¨?ðø¯ÿ\0Ñ\rÖ?ðuÿ\0\Z£þáú!ºÇþ¢ÿ\0ãUù}Ecõþáú!ºÇþ¢ÿ\0ãUè?¿à¨Ÿþ*xÖßÁž*ðÕç‚\Zÿ\0Ù_ß_$ÖÒLH7p«åg<1ù{8¯ÇÚZÇô¤Ž¬¡•ƒ+‚9TW—ÒÖ{²¥„1´›}p	Çé_“_±7ü7[ø_&ð§ã%ÍÎ¯á\'dµÓõ6&K%xUC€L°8ûËÛ#å¯Õ½VHæÐï&·#ÚHÊ}ABEì~Íÿ\0†ðŒ3Iü(ý`ìb¹þÚ‹œÏ*gü>+Â?ôCuüEÿ\0Æ«ó÷þ?\'ÿ\0®­üÍAAV?Páñ^ÿ\0¢¬àê/þ5Gü>+Â?ôCuüEÿ\0Æ«òúŠÇêü>+Â?ôCuüEÿ\0Æ¨ÿ\0‡ÅxGþˆn±ÿ\0ƒ¨¿øÕ~_Q@XýAÿ\0‡ÅxGþˆn±ÿ\0ƒ¨¿øÕðø¯ÿ\0Ñ\rÖ?ðuÿ\0\Z¯Ëê(¨?ðø¯ÿ\0Ñ\rÖ?ðuÿ\0\Z«š7üçÂzÆ±c¤GðKV¯®b¶Wmj2»ÉWl×å•møþGMþÂ–¿ú5hÑÂ·ZÕT³0U$ž1H¿t}+òÓöïÿ\0‚‚]xºMGàÇÀýRK}\ríurd’ø‚CÁ	à¬]C0åú/Þ	=Óã7ü3á?Ã^x/Âþ½ñ¢éÍå]jVwñÃmç¼‘’­æm<éžµÂÿ\0Ãâ¼#ÿ\0D7Xÿ\0ÁÔ_üj¿/¨ «¨?ðø¯ÿ\0Ñ\rÖ?ðuÿ\0\Z£þáú!ºÇþ¢ÿ\0ãUù}Ecõþáú!ºÇþ¢ÿ\0ãTÃâ¼#ÿ\0D7Xÿ\0ÁÔ_üj¿/¨ ,~ ÿ\0Ãâ¼#ÿ\0D7Xÿ\0ÁÔ_üjµ</ÿ\0{økªkö:w‰>ëZ&›q0ŽãP]B;Ÿ³)ãy‰cRÀwÁÎ3€zWåUéÃ~$Ð|]¡Ùx›Ã\Zµ®§¥ê0­Å­Ý¬ã–6­:ü4ý“mˆ³¶¶*Òë~¼›uþ‰,œ!%wMnOú¹p½>ëwý¤ømñÃ?¼£|Cð}Ô—\ZF·n.mšHÌnH*Êy0 ûŽ29 MXé˜VOŠ¤ñ4>¿—Á¶ú|úÚBZÆ-AÝ-ä”tY>e¦GLÖÅ5¨ù“ã/ø*ŸÆÿ\0‡þ&Ô<ã€º—¬is.­g¼¸Œ?A Ž Ž+þ	ñ+þˆï†¿ð:ãü*ŸüòÂÆßâß‚¯ ³†;‹½_>eŒ—lä.â9l@ÏJø‚ÐOø|\'Ä¯ú#¾\Zÿ\0Àëð£þ	ñ+þˆï†¿ð:ãü+óîŠÇè\'ü>âWýß\ràuÇøQÿ\0„ø•ÿ\0DwÃ_øqþù÷Ecôþ	ñ+þˆï†¿ð:ãü(ÿ\0‡Â|Jÿ\0¢;á¯ü¸ÿ\0\nüû¢€±ûðþ\nðwâSÛh?íÏ5ÉXF&üÍ6V8MÖ.ç \n?½_fXj:¥œ:†›yÝ¥Â	!ž	‘È§£+.AÔWóe^Åð/ö³øáû=ÞGÿ\0‹¦}$I¾mü™ì%õýÙ?!?ÞB§Þ€±ûçš	¯ýioøj/†xæoÿ\0a^iúƒi—vëqçFò¬q¹xÉ\0…>`àò1Ôõ­¯ÚcöˆðÇìÓðÖãÇÞ\"³žþy%zmŒYêé*…ðB(\nX±ì2x ’ÚöŠø{û7ø&_xæûtÒîMÓa#í7ó‘ŽÀwcÀ€?7üâFã·àï†öçŒßÏœ~Uñ·ÆŸ~>øõã›¿|@ÕZêîrRÞÝx‚Îåa‰…GæO$“\\Xýÿ\0‡Â|Jÿ\0¢;á¯ü¸ÿ\0\n?áðŸ¿èŽøkÿ\0®?Â¿>è ,~‚Ãá>%Ñð×þ\\…ðøO‰_ôG|5ÿ\0×á_ŸtP?A?áðŸ¿èŽøkÿ\0®?Âø|\'Ä¯ú#¾\Zÿ\0Àëð¯Ïº(¯ÿ\0²¿ü£Áÿ\0<Aÿ\07ÄÍ&ÏÁºýÜ»t¹àµ•Þqˆ‹¿).s€xn\09àýª\Z¿šÅfV¬A ŽÕúEÿ\0þý¼üY©x‹CýŸþ+}£[\ZŒ‚ÏCÖKn¸‰‚ü°ÎOúÄÀáþðèr:höoÛ£àŽ¿ho‰\r¼\'àûQµ½µôº–¥0>EŒ%á˜Ž¬pv¨ä‘è	Ñá/|ý~Ý\\5Õ¾‘¢éq}£SÕn±ö‹Ù{ eØ“µtÈ\0W ü@ñ×‡þx\'Zñÿ\0Š®\r\'B³{Ë§Ž2í±{*ŽI\'\0{šüGý«ÿ\0kŸþÔ+ûF dÒ¼+§H²tHäÊEÛÍ”¿)úàwÈSéßÁ`¼M¿„>é2èÉ3-”š…ä«pñ\"§Ê¤õÀÎ3ÔÖgü>âWýß\ràuÇøWçÝÇè\'ü>âWýß\ràuÇøQÿ\0„ø•ÿ\0DwÃ_øqþù÷Ecôþ	ñ+þˆï†¿ð:ãü(ÿ\0‡Â|Jÿ\0¢;á¯ü¸ÿ\0\nüû¢€±ú	ÿ\0„ø•ÿ\0DwÃ_øqþè?¿à¬ºOŠ|i‡þ2x.ËÂúMî\"‡U°šI’ÞRÀ:·\"?V\\ã¸ÆHüº¢€±ý&éú…Ž©e¥¦ÞCwiu\ZÍðH9Q†U•‡ÁUŠü]ýŒÿ\0nßþÏz…·‚<YöÀwSû#I™ôÒÇ™-Éþrc<HÁÎf¡º†kD¾V\"\'ŒJ	þéþT	«õõž›g>¡¨ÝÃkkm–i¦\"FŠ2Y˜ð\0Í~x|fÿ\0‚´ZøgÇzÂéþ$ÐìtuKû‰!ûL Í¯ü³è<žN1ŠñÛ“öóÖ¾8_^|1øiqq¦xÖcÄÀ”›Ye?yÇ!dGß‚Ý€øÂ€Hýÿ\0‡Â|Jÿ\0¢;á¯ü¸ÿ\0\n?áðŸ¿èŽøkÿ\0®?Â¿>è v?A?áðŸ¿èŽøkÿ\0®?Âø|\'Ä¯ú#¾\Zÿ\0Àëð¯Ïº( ŸðøO‰_ôG|5ÿ\0×áGü>âWýß\ràuÇøWçÝÑïÿ\0Á`5©üKa>éÖÚ’„¼ŸL»‘î\"CÁtWù[q‘œu¯ÑO‡ÿ\0|ñCÂ¶6ð&½m«húŒbHn lã Ž:£Œà«`ƒÁüæ×´þÌ¿µ_ÄÙÅCTð½Ñ¾Ð¯$_í]âCö{µé¸Ï9@èãèr8 ,~ön¬OxËÃ_ü1¨øËÆ\Z¼\Zf¥@×WS62x\0I Me|%ø•¢ü`øo |Lðõ½Ä\Zˆ-Ô0Ü\0$’¬­Ž2HÈëŒ×åWü«öñ¯~-êŸÒFÓ¼-àû¡	´ŽCþt<½3€ØUè¼žI V=#ÅðXEâB/|%ÒgÑv[µÉRâHÂ´ŠŸ*“×\0œg­eÿ\0Ãá>%Ñð×þ\\…~}Ñ@ì~‚Ãá>%Ñð×þ\\…ðøO‰_ôG|5ÿ\0×á_ŸtP?A?áðŸ¿èŽøkÿ\0®?Âø|\'Ä¯ú#¾\Zÿ\0Àëð¯Ïº( ŸðøO‰_ôG|5ÿ\0×áGü>âWýß\ràuÇøWçÝÝÙöÀðoíGá‰\Z¢Ñü]¦(:¦ŠeÜBð<øIåâ$ã=Tðz‚~„¿œÿ\0‡?|_ð§ÆZo<\r¬K¦êú\\ÂXeŒðÃ<ÆëÑÑ‡§‚\r~ãþÉ¿´Ž“ûO|+‹ÇVzciº•ÁÓu{>JEv±£·–Çï#+«ã8<ŠÑíTRRÐ ¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(¥|ÿ\0~ÿ\0’/à¯û\Z?öÒjûÙºWÁ?ðWïù\"þ\nÿ\0±£ÿ\0m& Ê\n(¢‚ÂŠ( Úø&×Ç_ø[Ÿ\0íü3«ßyþ!ð3.óseäµmÆÖSí°óÜÄ}kë2x¯ÃoØ7ã¿ü(¯ÚG¾Õ/>ñüIuÇ\n‘Èu1ôÙ.ÂO÷Kú×î¡¨Yé:}Î©¨\\$–p½Äò¹ÂÇ\Z)fb}\0ÐK???à­_[Hðžð3F½Û>»\'ö¶°¨yÑ6!½šL¶?éõ¯ËzôÏÚGâýçÇ_>\'ø•pÎ-õ+²–7ü²³Œ…}¾Eû“^g@ÐQE+õ?þ÷ÿ\0$ßâý†­ôKWå…~§ÿ\0Áÿ\0ä›ü@ÿ\0°Õ¯þ‰jÏ£nŸù4Ÿ‰ö	ú>:ü#¯ÝÏÛ§þM\'â_ý‚GþŽ¿èQE\n+[Ã^ñ?ŒµÒ|\'áýCX½XÌÆÞÆÝ¦F¶¨\'\0‘Ï¸®£þÇú$~.ÿ\0Á<ÿ\0üM\0p4Wq{ð;ã&›g>¡¨|-ñUµ­¬M4óK¥L©j	fbW\0\0	$úW@Q@4ùØÿ\0×Ìú¯èÁÿ\0äQoûÿ\0í*þsôùØÿ\0×Ìú¯èÁÿ\0äQoûÿ\0í*	gó•{ÿ\0“ÿ\0×Vþf ©ïãòúêßÌÔQE\0QE\0QE\0·àù4û\nZÿ\0èÕ¬JÛð?üŽšý…-ôjÐôjÿ\0ê[ýßé_Î‰?äbÕ?ëöýkú>õ-þïô¯çÄŸò1jŸõû?þŒ4ŒÚ(¢‚‚Š±aa}ª^Á¦é¶“]]\\È\"†P³Èäà*É$ö®ÛþÇú$~.ÿ\0Á<ÿ\0üM\0p4W}ÿ\0\nã‡ý?àžþ&¸CO¾Òo§Ó5;9­nídhg‚d(ñºœe<‚c@è¢Š\0+÷Oöÿ\0“Gøuÿ\0`ùô¢Zü,¯Ý?ØþMá×ýƒåÿ\0Ò‰h>ƒ¦µ:šÔ~UÁ`¿ä¨øþÀSÿ\0èúø¾ÿ\0ÿ\0‚ÁÉQðý€§ÿ\0ÑõðQ@ÂŠ÷ŸþÂ¿µoŠ´-?ÄºÂ+»½7T¶ŽîÒáu+Âê\r0# ƒ‚­øw¿í‰ÿ\0DVóÿ\0¶ü~\\ùÚŠöÏ~Åÿ\0´ßÃ\nê6ñ·Â»­3DÒ£Þ]¶¡g ‰KªLÌy`8­x\n(¢€?\\?à‘¿òo¾#ÿ\0±®ý%·¦Á\\¿ä‚xkþÆxÿ\0ôžjü7þM÷Äö5Ïÿ\0¤¶ôÏø+—üO\rØÏþ“ÍA=OÉ*(¢‚‚Š+Ð~üøÅñªßPºø[àKÿ\0Å¥<qÞ5³F<–1@w°êºzPŸQ^óÿ\0%û\\Ñ×?ïí¿ÿ\0®wÇÿ\0²¯í	ð·Ã72øð¿TÑt[WŽ9¯\'xJ#;@v¹<±§z\0òŠ(¢€\nöÿ\0Ø—þN¿á—ý‡cÿ\0ÐZ¼B½¿ö%ÿ\0“¯øeÿ\0aØÿ\0ô ×_ÛsþM?âoý€ßÿ\0CJü¯ÞOÛsþM?âoý€ßÿ\0CJü H(¢ŠWSðçá¾.xˆøOáÇ†nuÝ\\[½×ÙmÙùH@fùÈ‡~õêðÂ_µÇýýsþþÛÿ\0ñÊ\0ðj+ÛõoØŸö§Ð´«ÝsVø3¬ÛXéÖò]]LÒA¶(£RÎÇgA?…x…\0QE\0XÓÿ\0ä!mÿ\0]“ÿ\0BýYÿ\0È¯ýƒ×ÿ\0EŠþrtÿ\0ù[×dÿ\0Ð…FÖò+Áÿ\0`õÿ\0Ñb‚Yüäêñýsÿ\0]Ÿÿ\0B5^¬jñýsÿ\0]Ÿÿ\0B5^‚‚Š+GÃ¾Ö¼Y¯XxgÃº|—Ú¦©p–¶vÑ\Zi\\áTd’Os@ÔW¼ÿ\0Ã	~×ôCõÏûûoÿ\0Ç(ÿ\0†ý®?è‡ëŸ÷ößÿ\0ŽPƒQWu­Tðî±}áýnÍí5\r6âK[«wÆè¥F*êqÆAqT¨\0¢Š(÷göÿ\0“Gøkÿ\0`·ÿ\0Ò‰kòoöäÿ\0“±ø“ÿ\0aƒÿ\0¢Ò¿Y?aù4†¿öý(–¿&ÿ\0nOù;‰?ö?ú-(%nxUQAAEöfÿ\0­ý¡õÍÇZ´×¼°jÑ]Fú`Á$PÃ?ºëƒ@Ñ_lÃ¦hïúø3ÿ\0¦ÿ\0ãUóGÇO‚~+ýŸ¾ Ü|7ñ¥Õ„úµ¼7.ö23ÄVUÜ¸, çx GŸQE+õ—þ	ÿ\0$+Æö6¿þ‘ÛWäÕ~²ÿ\0Á ÿ\0ä…xÃþÆ×ÿ\0Ò;jÏ¼îŠZEû¢–‚BŠ( Š( Š( Š( Š( Š( Š( n•ðOüûþH¿‚¿ìhÿ\0ÛI«ïfé_ÿ\0Á_¿ä‹ø+þÆý´š€?((¢Š\n(¢€\ný	ø‹ûq/‰¿`=+Âñë\0xïV”xWR¿{ökuV’ãé$F$\'ûÒ?¥~{Q@‚Š( aEP_©ÿ\0ðG¿ù&ÿ\0?ì5kÿ\0¢Z¿,+õ?þ÷ÿ\0$ßâý†­ôKP&}ûtÿ\0É¤üKÿ\0°Hÿ\0Ññ×á~î~Ý?òi?ÿ\0ì?ô|uøG@ ¢Š(öoüþN‚ïþÅ[ïýo_°Ýkñçþ	?ÿ\0\'Awÿ\0b­÷þŽ·¯ØuïA,àþ=Éø‹ÿ\0bž¯ÿ\0¤r×óÏ_ÐÇÇ¯ù!ìSÕÿ\0ôŽZþyèQE4ùØÿ\0×Ìú¯èÚÒÜ^x~Vb¢k5w¦SýkùÉÑÿ\0ä/cÿ\0_1ÿ\0èB¿£ÍþAV_õïþ‚(%ŸŸ“Á|4Ï1øá¬‚ì[ØÑq“ŸùëMÿ\0‡:ø;þ‹†³ÿ\0‚X¿øí~‰Q@\\üÒñÇü_Â^ð^½â¨~3ê÷/£i—7ëi(Å8R|Î3·÷¯Ízþˆ>4ÉñÇý‹šþ“I_ÎýAEP2{+quy©m¢iV=Þ™ f¿M4ÿ\0ø#ÿ\0ƒïl-¯ãv°¦xRR¿ØÑq¹AÇúßzüÐÑÿ\0ä/cÿ\0_1ÿ\0èB¿£­þ@ºwýzÅÿ\0 \nÏÏÏøs¯ƒ¿è¸k?ø%‹ÿ\0ŽÕÍþ	á\rX°Õ×ãf±+XÜÅr#:<@1F\rŒùœgú\rE¹œBÃÑM8>$ÿ\0‘‹Tÿ\0¯Ùÿ\0ôa¯èþoõoþé¯çÄŸò1jŸõû?þŒ43h¢Š\n=#öoÿ\0’ýð÷þÆ;ýµý×óéû7ÿ\0É~ø{ÿ\0c‡þŽZþƒ‚X•üüþÓŸòpÿ\0ÿ\0ìfÔ?ôsWôÕüü~ÓŸòpÿ\0ÿ\0ìfÔ?ôsPó*(¢‚‚¿tÿ\0`ù4‡_ö—ÿ\0J%¯ÂÊýÓýÿ\0äÑþØ>_ý(–3è:kS©­A\'åWüþJ€ÿ\0ì?þ¯€+ïÿ\0ø,ü•ÿ\0Ø\ný_\0PPQEþƒ¿gù ?¿ìYÓ¿ô+Ñ¶×œþÍÿ\0ò@¾Ø³§é:W£æ‚\0ý¼ÿ\0äÑþ$Ø6?ý(Š¿\nk÷[öóÿ\0“Gø‘ÿ\0`Øÿ\0ô¢*ü) ¤QE?\\?à‘¿òo¾#ÿ\0±®ý%·¦Á\\¿ä‚xkþÆxÿ\0ôžjü7þM÷Äö5Ïÿ\0¤¶ôÏø+—üO\rØÏþ“ÍA=OÉ*(¢‚‚¿Nÿ\0àŽ_ò.üQÿ\0¯Ý+ÿ\0EÜ×æ%~ÿ\0Á¿ä]ø£ÿ\0_ºWþ‹¹ LýÇzù[þ\nmÿ\0&ƒâúÿ\0Òÿ\0ô²:ú¨ýÚùWþ\nmÿ\0&ƒâúÿ\0Òÿ\0ô²:	?h¢Š\nöÿ\0Ø—þN¿á—ý‡cÿ\0ÐZ¼B½¿ö%ÿ\0“¯øeÿ\0aØÿ\0ô ×_ÛsþM?âoý€ßÿ\0CJü¯ÞOÛsþM?âoý€ßÿ\0CJü H(¢Š}ÿ\0¦ÿ\0“¥ûoÿ\0ô8kö4×ã—ü›þN•ÿ\0ìY¿ÿ\0Ðá¯ØÕïA,â~7Éñ÷ýŠú¯þ’I_Ï\rF´ÿ\0|9ñW…ô¿/íºÆ‹}amæ6ÔóeÑ7Ã,2kò[þOûSÁ¿ø7þ5@#ãŠ+ìøu?íMýÿ\0ÿ\0àÝÿ\0øÕðêÚ›ûþ\rÿ\0Á»ÿ\0ñªsä\r?þBßõÙ?ô!_ÑµŸüŠðØ=ôX¯ÈÛOø%_íI\rÔ3;ø;lr+jïÐÿ\0Ï*ýwŽÞK_­¬¸ß\r˜±Ó!0h?œMCþ?®ë³ÿ\0èF«ÕCþ?®ë³ÿ\0èF«ÐPW©þËòr\r¿ìf°ÿ\0ÑË^Y^§û,ÉÈ|6ÿ\0±šÃÿ\0G-\0@R¯Z\rÏ_íÿ\0%Ûâý\ZŸþ”É^_xüVÿ\0‚eþÒž2øâÏhíá1a­kW·öÞvªêþT³3®áå0ÈÍr¿ðêÚ›ûþ\rÿ\0Á»ÿ\0ñª\n¹ñÅö?ü:Ÿö¦þÿ\0ƒðnÿ\0üjøu?íMýÿ\0ÿ\0àÝÿ\0øÕsôKöÿ\0“Gøkÿ\0`·ÿ\0Ò‰kòoöäÿ\0“±ø“ÿ\0aƒÿ\0¢Ò¿cf‡>\"øGðÁß<XmN¯¡Xµ½×Ùe2E¸Êïò±#;Wã—íÉÿ\0\'cñ\'þÃÿ\0E¥G…QEý|9ÿ\0’áûYè„¯ç6¿¢¿ßXéŸü;¨jWZÚÁ¡ÙÉ,ÓH#QY\0{š	gQ_ŒðT/ù;-[þÁ\ZwþŠ¯³>?ÁP>ü7[ál\'ÇZôDÇæÄÆ-:éóMŒÉHÁûÂ¿.~4üdñ—ÇŸˆß<u%©Ôï’8¶ZÃåÅH»QdœÜ’M\0ŽŠ(  ¯Ö_ø$ü¯ØÚÿ\0úGm_“UúËÿ\0ƒÿ\0’ãû_ÿ\0Hí¨>ð_º)iîŠZ	\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€ºWÁ?ðWïù\"þ\nÿ\0±£ÿ\0m&¯½›¥|ÿ\0~ÿ\0’/à¯û\Z?öÒj\0ü ¢Š(,(¢Š\0(¢Š\0(¢Š\0(¢Š\0+õ?þ÷ÿ\0$ßâý†­ôKWå…~§ÿ\0Áÿ\0ä›ü@ÿ\0°Õ¯þ‰jÏ£nŸù4Ÿ‰ö	ú>:ü#¯ÝÏÛ§þM\'â_ý‚GþŽ¿èQE>Íÿ\0‚Oÿ\0ÉÐ]ÿ\0Ø«}ÿ\0£­ëö{×ãÇüþN‚ïþÅ[ïýo_°ëÞ‚YÁüzÿ\0’ñþÅ=_ÿ\0Hå¯çž¿¡_òBþ\"ÿ\0Ø§«ÿ\0éµüóÐ(¢Š\n.hÿ\0ò±ÿ\0¯˜ÿ\0ô!_Ñîÿ\0 »/ú÷ÿ\0Aüáhÿ\0ò±ÿ\0¯˜ÿ\0ô!_Ñîÿ\0 »/ú÷ÿ\0AË´QE8ŸòG¼qÿ\0bæ£ÿ\0¤ÒWó¿_ÑÆù#Þ8ÿ\0±sQÿ\0Òi+ùß ¤QE.hÿ\0ò±ÿ\0¯˜ÿ\0ô!_ÑÖƒÿ\0 ];þ½bÿ\0Ð8º?ü…ìëæ?ýWôu ÿ\0ÈNÿ\0¯X¿ôA,Ð¢Š(ßêßýÓü«ùÀñ\'üŒZ§ý~Ïÿ\0£\rGó«÷Oò¯çÄŸò1jŸõû?þŒ4\r´QE‘û7ÿ\0É~ø{ÿ\0c‡þŽZþƒ¿Ÿ?Ù¿þK÷Ãßûì?ôr×ô´Á«ùøý§?äáþ#ÿ\0ØÍ¨èæ¯è«ùøý§?äáþ#ÿ\0ØÍ¨èæ æTQE~éþÀÿ\0òhÿ\0¿ì/þ”K_…•û§ûÿ\0É£ü:ÿ\0°|¿úQ-gÐtÖ§SZ‚OÊ¯ø,ü•ÿ\0Ø\ný_\0Wßÿ\0ðX/ù*>ÿ\0°ÿ\0ú>¾\0  ¢Š(ýþÎ?ò@~ÿ\0Ø³§é:WñûöØøû>Å=ˆ<HºÇˆ£]Iežä7a)ÎØGûä@kòßÆŸ·§Çoü:Ñ~økVO	xGÒíô¶þÊfK«´Š5LÉ9;†q÷ShÁÁÍ|å,²M#Í4$’1ff9,ORIêh&ÇÔ?´Çüâçí	c{á8mü-àÛÌ$ÚU©ËtªÁ—Î”1äµBŽ9Í|·EQ]WÃß…¿>+kIáÿ\0‡~Õ5ëÖ`líÙÖ,ÿ\0÷cì@ Ôoø$oü›ïˆÿ\0ìkŸÿ\0IméŸðW/ù ž\Zÿ\0±ž?ý\'š½Kö\nýž¼qû8ü½ðŸÄ	´öÕuM]õC\r”ÆU\ZFÌ@ŒçðMyoüËþH\'†¿ìgÿ\0Iæ ž§ä•QAA_§ðG/ù~(ÿ\0×î•ÿ\0¢îkó¿Nÿ\0àŽ_ò.üQÿ\0¯Ý+ÿ\0EÜÐ&~Œæ¾Sÿ\0‚™ÉŸ²ŠUX¦¡¦+`çíqJú®¾Iÿ\0‚’hz>“û$øÚëKÓ-­&Õ5}2îõáŒ)¸›í0§˜ä}æÚˆ2{( “ñŠŠ( °¯oý‰äëþØv?ý«Ä+Ûÿ\0b_ù:ÿ\0†_öÿ\0Aj\0ýuý·?äÓþ&ÿ\0Ø\rÿ\0ô4¯Áºýäý·?äÓþ&ÿ\0Ø\rÿ\0ô4¯Áº‚Š( gØÿ\0ðJoù:Wÿ\0±fÿ\0ÿ\0C†¿cW½~9Á)¿äé_þÅ›ÿ\0ý\Zý^ôÃo½}éÔP!»}èÛïN¢€·Þ«êñãsÿ\0\\Ÿÿ\0A5jªêñãsÿ\0\\Ÿù\Z\0þnõøþ¹ÿ\0®Ïÿ\0¡\Z¯V5øþ¹ÿ\0®Ïÿ\0¡\Z¯Aa]ÂZü7ø£á__YKyoáýVßP–Þ\nò¬nª“À\'ë¢€?TáðŸÿ\0èø›ÿ\0méWþðÍ˜/ü)ÿ\0rqÿ\0¶õù[O‹ýb¼(éEÔ£Ö´{\rb(Ú4¿¶ŠåQ¹*C\0~™«»}ëÀò$øwþÁVŸú%k~‚Fí÷£o½:Š\0e~þÜŸòv?ì0ôZWîñêkð‡öäÿ\0“±ø“ÿ\0aƒÿ\0¢Ò£Â¨¢Š\n\nõ/Šß´ÇÆoŒÖZ|es&‹§C½®“mˆm#TP«”_¾ØQó>Mym\0QE\0QVô­\'T×u+}EÓ®oï®ä[Û[DÒK+žŠª ’~•öÇÀø%Åo}—\\ø½©Çà½\\9³jN¾›>äYØ’?»@ˆm­®/.#µ³·’y¥`‘Ç\Z–gcÀ\0I\'µ~Äÿ\0Á/þü@ø_ð?\\¶øá[ýãXñjv÷Ñùr½¹¶”?2e‘†ÇJö?‚?²_À¿€6ñ·€ünuP I¬_ââúCÇ\"F 8Î(ö¯cÛ@›~è¥¢ŠQE\0QE\0QE\0QE\0QE\0QE\0QE\0#t¯‚à¯ßòEüÿ\0cGþÚM_{7Jø\'þ\nýÿ\0$_Á_ö4í¤ÔùAEPXQE\0QE\0QE\0QE\0WêüïþI¿Äû\rZÿ\0è–¯Ë\nýOÿ\0‚=ÿ\0É7øÿ\0a«_ýÔ	ŸFþÝ?òi?ÿ\0ì?ô|uøG_»Ÿ·OüšOÄ¿ûý~Ð(¢Š}›ÿ\0Ÿÿ\0“ »ÿ\0±Vûÿ\0G[×ì:÷¯Çø$ÿ\0üßýŠ·ßú:Þ¿a×½³ƒøõÿ\0$/â/ýŠz¿þ‘Ë_Ï=C¿ä…üEÿ\0±OWÿ\0Ò9kùç QE\\Ñÿ\0ä/cÿ\0_1ÿ\0èB¿£ÝþAv_õïþ‚+ùÂÑÿ\0ä/cÿ\0_1ÿ\0èB¿£ÝþAv_õïþ‚(%—h¢Šq?\Z?äxãþÅÍGÿ\0I¤¯ç~¿¢òG¼qÿ\0bæ£ÿ\0¤ÒWó¿AH(¢Š\\Ñÿ\0ä/cÿ\0_1ÿ\0èB¿£­þ@ºwýzÅÿ\0 \nþqtùØÿ\0×Ìú¯èëAÿ\0.ÿ\0^±è‚Y¡EP\")¿Õ¿û§ùWóâOùµOúýŸÿ\0F\Zþæÿ\0Vÿ\0îŸå_Î‰?äbÕ?ëöýh\Z3h¢Š\n=#öoÿ\0’ýð÷þÆ;ýµý->³ü—ï‡¿ö1Øèå¯è1h%ƒWóñûNÉÃüGÿ\0±›Pÿ\0ÑÍ_Ð;WóñûNÉÃüGÿ\0±›Pÿ\0ÑÍ@#Ì¨¢Š\n\nýÓýÿ\0äÑþØ>_ý(–¿+÷Oöÿ\0“Gøuÿ\0`ùô¢ZÏ é­N¦µŸ•_ðX/ù*>ÿ\0°ÿ\0ú>¾\0¯¿ÿ\0à°_òT|ÿ\0`)ÿ\0ô}|AAEP0¢Š(\0®ãágÁ/ŠŸ\Zµ¢|3ðN¥­Ì¬ÓCöàœfY›	ÿ\0xjã-gû-Ô7>LSyR,ž\\«”|íaÜâ¿I?foø)ÿ\0ÃÏ\rèö>øð¾ÃÂv°…†ï	Ø¬v+À¤¶Ý¹=Êÿ\0wÐ¯ðþ	7¡éŸf×ÿ\0hRäaÿ\0°ô™-ÔðvË?øäar+ïOøÁt8|5à?éÚ™\0Â[Ù@±¯Ôã–>¤äžõ_À?¾üRÑÓ^øwã-#ÄLi,n’S#;dPwFÜò¬•Ôî Bmâ¾ÿ\0‚¹Éð×ýŒñÿ\0é<Õ÷Aé_ÿ\0Á\\¿ä‚xkþÆxÿ\0ôžj~IQEöOìû`ü1ý—tŸ\ZXüBÒ¼Ew\'ˆn,fµ:U¬2…¬Á·ù’¦ïÏzøÚŠ~½ÿ\0ÃÛ?f¯ú~ à¶×ÿ\0’kÅ?lOø(\'ÁOßµŸ†^Ñ<[mªê6sE&£epÂHÙdÈ8S—­~wÑ@X(¢Šíÿ\0±/üÃ/ûÇÿ\0 µx…{ìKÿ\0\'_ðËþÃ±ÿ\0è-@®¿¶çüšÄßû¿þ†•ø7_¼Ÿ¶çüšÄßû¿þ†•ø7@QEûþ	Mÿ\0\'Jÿ\0ö,ßÿ\0èp×ìj÷¯Ç/ø%7ü+ÿ\0Ø³ÿ\0¡Ã_±«Þ‚Xê(¢Q@UÔ?ãÆçþ¹?ò5jªêñãsÿ\0\\Ÿù\Z\0þnõøþ¹ÿ\0®Ïÿ\0¡\Z¯V5øþ¹ÿ\0®Ïÿ\0¡\Z¯AaEåV‘‚F¥™Ž\0$Ðiñ¬O÷…Mý›©Ð>çþý7øSâÓu/1?â_s÷‡ü²oð è¯Àò$øwþÁVŸú%k~°|ðO‡#J´ÿ\0Ñ+[ÔQE\00õ5øCûrÉØüIÿ\0°Áÿ\0Ñi_»Ç©¯ÂÛ“þNÇâOý†þ‹J\n¢Š(((¢½#â§ìïñàÜ6wÞ9ðmí¾—¨AÅ¦«m-”Ë\"†P&hl0Êœ0ô 7¢Š(ðÍ-¼©4<rFÁ•Ñ°ÊGBèkêÏ€¿ðQÿ\0_Í¾“âKáãŸD«³Õ¥?h…üò¸qÀ¼vÀíò…ýÉøûxþÏßÅ®›câtðçˆgUS¤kN¶îò|°ÈNÉ¹<;÷E}­P{×óX¬ÊÁ”G ŽÕúùÿ\0¥ñ‹<]ð_Å>$Ôµq¤øì¬MõËÌmíÅ¬\"Bä•@Yˆ^ƒ\'	£íš)îŠZQE\0QE\0QE\0QE\0QE\0QE\0QE\0#t¯‚à¯ßòEüÿ\0cGþÚM_{7Jø\'þ\nýÿ\0$_Á_ö4í¤ÔùAEPY5³Þ]ÁgiäXÔ·@XÏçVuíSðÎ¹¨xsZµkmCKº–Îêë±±W_ÀƒFƒÿ\0!Í;þ¾áÿ\0ÐÅ}Cÿ\00øRßi}KÄpìÓ<moµo…ÀY°#¸_sæ!ûh(äú(¢€\n(¢€\n(¢€\nýOÿ\0‚=ÿ\0É7øÿ\0a«_ýÕùa_©ÿ\0ðG¿ù&ÿ\0?ì5kÿ\0¢Z3èßÛ§þM\'â_ý‚GþŽ¿ë÷söéÿ\0“Iø—ÿ\0`‘ÿ\0£ã¯Â:Q@Ï³à“ÿ\0òtö*ßèëzý‡^õøñÿ\0Ÿÿ\0“ »ÿ\0±Vûÿ\0G[×ì:÷ –p¿ä…üEÿ\0±OWÿ\0Ò9kùç¯ècã×ü¿ˆ¿ö)êÿ\0úG-<ô\n(¢‚‹š?ü…ìëæ?ýWô{£ÿ\0È.Ëþ½ãÿ\0ÐE8Z?ü…ìëæ?ýWô{£ÿ\0È.Ëþ½ãÿ\0ÐE²íQ@Ž\'ãGü‘ïØ¹¨ÿ\0é4•üï×ôAñ£þH÷Ž?ì\\ÔôšJþwè)Q@Ëš?ü…ìëæ?ýWôu ÿ\0ÈNÿ\0¯X¿ô_Î.ÿ\0!{úùÿ\0Býh?òÓ¿ëÖ/ý\0PK4(¢ŠE7ú·ÿ\0tÿ\0*þp<Iÿ\0#©ÿ\0_³ÿ\0èÃ_ÑüßêßýÓü«ùÀñ\'üŒZ§ý~Ïÿ\0£\rFmQAG¤~Íÿ\0ò_¾ÿ\0ØÇaÿ\0£–¿ Å¯çÏöoÿ\0’ýð÷þÆ;ýµý-°jþ~?iÏù8ˆÿ\0ö3jú9«újþ~?iÏù8ˆÿ\0ö3jú9¨y•QAA_º°?üš?Ã¯ûËÿ\0¥×áe~éþÀÿ\0òhÿ\0¿ì/þ”K@™ô5©ÔÖ “ò«þÿ\0%GÀöŸÿ\0G×À÷ÿ\0üþJ€ÿ\0ì?þ¯€(((¢ŠWìÁŸÙà7ÇïÙGá­×Ž|Z»ø~k\Zi× ògQ‰1Ä…|Çñ»þ	SñkÁKq­|%Öm¼k¦¡f[_³ê½€Sû¹?ýšsáª+SÄžñ/ƒµi´h\Z†¨Û²Úß[<§nUÀ=«.‚þ xãáÎ±ˆ<âÍ[@Ôc#\Z}ÓÀÌ:ím¤SÝNAî+î/ðVO\Zø|[h<1ˆìP„m_KE†ø/÷ž2DR‘íåûæ¿?h Gô3ðoãgÃ¯^5øi­6£§,ÆÚmð´RA8Uc«SÆG<\ZùOþ\nåÿ\0$Ã_ö3Çÿ\0¤óSÿ\0à‘¿òo¾#ÿ\0±®ý%·¦Á\\¿ä‚xkþÆxÿ\0ôžj~IQEQVm4ÝFü1±ÓînBcw“>ÜôÎZŠÑÿ\0„wÄôÔ?ðÿ\0Â¢¸Ñõ{8Œ÷z]ä¯$ª?1@è¢Š\0+Ûÿ\0b_ù:ÿ\0†_öÿ\0Ajñ\nöÿ\0Ø—þN¿á—ý‡cÿ\0ÐZ€?]mÏù4ÿ\0‰¿öý\r+ðn¿y?mÏù4ÿ\0‰¿öý\r+ðn ¢Š(ö?ü›þN•ÿ\0ìY¿ÿ\0Ðá¯ØÕï_Ž_ðJoù:Wÿ\0±fÿ\0ÿ\0C†¿cW½°É£&¸ßŒ×7üsygq$Áá½NH¥Š¼n¶²ÊG ‚Wàwü.O‹ÿ\0ôU|aÿ\0ƒË¯þ.€JçôG“FM;Ÿð¹>/ÿ\0ÑUñ‡þ.¿øº?ár|_ÿ\0¢«ãü]ñtè&«êñãsÿ\0\\_ÿ\0A5üõéÿ\0>/5õ²·ÅOf@A×.¹ù‡ûuýZ³Iá˜d‘‹3X©f\'$Ÿ.€jÇó¨ÇõÏývýÕz±¨ÇõÏývýÕz\n\nõÙv(çý¢þC4k$oâKeeÈaæ¯µåÕê²Çüœ‡Ãoû¬?ôrÐïoü#ÿ\0¡{Lÿ\0ÀHÿ\0ÂøF|7ÿ\0Bö›ÿ\0€‘ÿ\0…j/Þ¡ºÐ@ÕUE\nŠ(À ìšüøññkâ­ÆÏØØüLñ]½½¿‰5â†-jå4ª‡À\0p\0®þ\'Åÿ\0ú*¾0ÿ\0Áå×ÿ\0@ìDy4d×ó¹ÿ\0“âÿ\0ý_àòëÿ\0‹£þ\'Åÿ\0ú*¾0ÿ\0Áå×ÿ\0@Xþˆ«ð‡öäÿ\0“±ø“ÿ\0aƒÿ\0¢Ò¿[¿b]STÖÿ\0e‡z¦³©]_ÞÜi®Ó\\ÝLÒË!óägbI8©¯ÉÛ“þNÇâOý†þ‹JEPPWôIáMEñ\'Â­Dñ‘eªi×zœsÚ^[¬ÐÊ¦á‘ÁVQ_ÎÝF_äŸø_þÀÖ_ú!(%Ÿ~ÐßðJß\0øÌ\\ø‹à^¤žÖ.t«¦gÓ&n¸Rx?\rËÓ\n+ó/â—Â¿|ñ¥ï€~!iÙÚÍˆW’!*È¬Œ2Ž¬¤‚¤r?Zþ‰Ïø¿ÿ\0Bÿ\0“²Õ¿ì§èª3äº(¢‚‚¿YàòB¼aÿ\0ckÿ\0éµ~MWë/üþHWŒ?ìmý#¶ LûÁ~è¥¤_º)h$(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0Fé_ÿ\0Á_¿ä‹ø+þÆý´š¾ön•ðOüûþH¿‚¿ìhÿ\0ÛI¨ò‚Š( ²þƒÿ\0!Í;þ¾áÿ\0ÐÅ~²ÿ\0ÁW¾ÿ\0Â]ð?Mø™goºïÀ÷ãÎe_›ì—mOŸa „ûsï_“Zü‡4ïúû‡ÿ\0CýüKð.™ñ3áÿ\0ˆ>ë\0}_Óæ±‘›Ô…oø`þ	ŸÎ^Ðõ/ëš‡‡u›f·¿Ó.d´¹‰º¤‘±V˜5B…tü®|Hñe—„|?û«½ò3c\"(£BòH}•á\\å~„ÿ\0Á6>cáßÄ¯šÅ®ö-þ…£o^ÞA{‰Wÿ\0@ßùíEP_©ÿ\0ðG¿ù&ÿ\0?ì5kÿ\0¢Z¿,+õ?þ÷ÿ\0$ßâý†­ôKP&}ûtÿ\0É¤üKÿ\0°Hÿ\0Ññ×á~î~Ý?òi?ÿ\0ì?ô|uøG@ ¢Š(öoüþN‚ïþÅ[ïýo_°ã½~<Á\'ÿ\0äè.ÿ\0ìU¾ÿ\0ÑÖõö·íaÿ\0øuû?Çsá?	µ·Š¼n3YC7ú>žßÞ¸uÏÌ?ç˜ù¸çm³Ô?kˆþøwðÆ’xËÄvšaÕôCMÓã•ÿ\0yus-³¢G\Z™‰fÀàrp+ð2»?Šß>!ülñdþ3ø‘â9õ]Fo•7|±@£Š1ò¢@>¹5ÆP4¬QE.hÿ\0ò±ÿ\0¯˜ÿ\0ô!_Ñîÿ\0 »/ú÷ÿ\0Aüáhÿ\0ò±ÿ\0¯˜ÿ\0ô!_Ñîÿ\0 »/ú÷ÿ\0AË´QE8ŸòG¼qÿ\0bæ£ÿ\0¤ÒWó¿_ÑÆù#Þ8ÿ\0±sQÿ\0Òi+ùß ¤QE.hÿ\0ò±ÿ\0¯˜ÿ\0ô!_ÐÄÏ‰P|#øGÄÈL¶zPÓâ¯Þû;ËJWÕ‚3=@¯çÿ\0Gÿ\0½ý|Çÿ\0¡\ný¼ý´¿äÎüOÿ\0`ëýgÐÖÖš¥¾¥§Ü$ö·p¤ðÊ‡+$l¡•î ÕŠøËþ	³ñù|yðê_„> ½/®x>0Ö[ÛæŸL$Ç¯”ÇaôS}›A$S«÷Oò¯çÄŸò1jŸõû?þŒ5ýÍþ­ÿ\0Ý?Ê¿œÈÅª×ìÿ\0ú0Ð4fÑEzGìßÿ\0%ûáïýŒvú9kúüùþÍÿ\0ò_¾ÿ\0ØÇaÿ\0£–¿i¿hÏÚ³áOì× ½÷ŒueºÖçˆ¾Ÿ¡Z¸7wg±#þY¦z»q×<P&zŸ‰<Máÿ\0è—~%ñV³g¥iv™nnî¥ÅŽåù5üü|tñ&ãŒ¾5ñW‡î¾Ó¦jÚååå¤Û\nù‘<¬ÊØ`È#‚+²ý¤¿kOŠŸ´Æ¸n<Y¨ÚFm?Cµr-­Áè[¡•ÿ\0ÛoÃŠñ: ¢Š(WîŸìÿ\0&ðëþÁòÿ\0éDµøY_º°?üš?Ã¯ûËÿ\0¥Ð&}Mju5¨$üªÿ\0‚ÁÉQðý€§ÿ\0Ñõð}ÿ\0ÿ\0‚ÿ\0’£à?ûOÿ\0£ëà\n\n\n(¢Ÿ½±_üšŸÃû\0AüÚ½³mxŸìWÿ\0&§ðÃþÀ3^ÛAÉðSørûöZñˆï4>}[Nº°û%ô–Èn u\Z°IÜ © €y¿köÃþ\nYÿ\0&ƒâßúúÓô²*üO ¤QE?\\?à‘¿òo¾#ÿ\0±®ý%·¦Á\\¿ä‚xkþÆxÿ\0ôžjü7þM÷Äö5Ïÿ\0¤¶ôÏø+—üO\rØÏþ“ÍA=OÉ*(¢‚‚¿M¿à6vw^øžnma˜­î•20ØýÝÏ­~d×éßüËþEßŠ?õû¥è»šÏÐßì/þ–¿÷åÂ¾Zÿ\0‚˜iöÿ\0²/‰¤·±·Åþ™†HÔøû¸õ‰ûµò¯üÛþMÄÿ\0õÿ\0¥ÿ\0édtüU¢Š((+Ûÿ\0b_ù:ÿ\0†_öÿ\0Ajñ\nöÿ\0Ø—þN¿á—ý‡cÿ\0ÐZ€?]mÏù4ÿ\0‰¿öý\r+ðn¿y?mÏù4ÿ\0‰¿öý\r+ðn ¢Š(ö?ü›þN•ÿ\0ìY¿ÿ\0Ðá¯ØÐq_Ž_ðJrö¤rxÃ:‡þ‡\r}eûYÁI<ð.üðvKOxµwÃ5ê¶ë5Ç‘ÄÎ?º§hÇ\'µ³Ûÿ\0koŒß>üñE¿üIoey¯h·Úv™b§}ÍÜÒÀñ¨HÇ%Aa–?(îkð^º/|Bñ§Å]øÇÇ¾\"»Öu{ÖÝ-ÅÃäÙTGeP\0ô®v­Š( e?þBßõÙ?ô!_ÑµŸüŠðØ=ôX¯ç\'Oÿ\0…·ývOýWômgÿ\0\"¼ö_ý(%ŸÎN¡ÿ\0×?õÙÿ\0ô#UêÆ¡ÿ\0×?õÙÿ\0ô#Uè(+Ôÿ\0eù9†ßö3Xèå¯,¯Sý–?ää>ØÍaÿ\0£–€? \nç|ñÁ¼1wã/xŠÏEÒ,—t—/ŒžÊ‹ÕØô\n “ØW‰~ÔŸ·ÂßÙ¶Òm¦OxÍ“0èv²óz=Ä€ô;OÌGAŽkòã—í\rñGö„ñ;x—â6¾÷\"2EŒ#Ëµ³Cü1Æ8²Ç,qÉ4‘ñcÄšoŒ>(x»Åš3HÖ\ZÎ·{}jd]¬b–guÈìpGÊQEQ@»?°üš?Ã_û¿þ”K_“·\'üÄŸûý•úÉûÿ\0É£ü5ÿ\0°[ÿ\0éDµù7ûrÉØüIÿ\0°Áÿ\0ÑiA+sÂ¨¢Š\n\nþŒ¾ÿ\0É?ð¿ý¬¿ôBWó›_Ñ—ÃŸù\'þÿ\0°5—þˆJ	gDÕø¿ÿ\0Bÿ\0“²Õ¿ì§èªý jü_ÿ\0‚¡ÉÙjßöÓ¿ôU\0’è¢Š\n\nýeÿ\0‚Aÿ\0É\nñ‡ý¯ÿ\0¤vÕù5_¬¿ðH?ù!^0ÿ\0±µÿ\0ôŽÚ3ïû¢–‘~è¥ ¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(¥|ÿ\0~ÿ\0’/à¯û\Z?öÒjûÕ«áßø*GÃŒ_>h1øÁqë:‡îäÕu9­gÝ{ˆÙ ÀÝV$•,Ùþh~FÑJÊÊÅYH àƒÚ’‚Ëúü‡4ïúû‡ÿ\0Cý\"Wów ÿ\0ÈsNÿ\0¯¸ô1_Ò%³ñsþ\nað·þïí5©ë–v¾N›ã;Xu›}«…mÎ¿˜…Ïýt¯“ëõßþ\n¹ð©¼]ð/Mø‘enïÀÚ€i˜˜YÝŠO¨æ}kò\"£GÃžÕ¼Yâ\r7Âú£Ýj:µÜVV¯Y%‘‚¢þ$ŠýêðßÃ-3àçìÎß\rt¥C‡ák›ydQ:³¹–CîÎXþ5ùÅÿ\0­ø\"¾:øÅ}ñ[Xµ2iž„]Ãå}F`Ë×b	Ø”üTþ#É=ñGýoôCÐþs¨¢ŠúŸÿ\0{ÿ\0’oñþÃV¿ú%«òÂ¿Sÿ\0àòMþ Øj×ÿ\0DµgÑ¿·OüšOÄ¿ûý~×ô™}aeªXÏ¦êVpÝÚ]FÐÏÑ‡ŽTa†VSÁpA¯ÏOÚ«þ	w¥ëKyãÙÅcÓïù–oM& »›y]¿tzüòóÁQÅLü¾¢´¼Gá½Â\Zåç†üQ£Ýéz¥„†›K¨ŒrÄã±SY´tþø•ão†\Z†¡«x_¸Ñ¯µ=>].{«|	~Ï##:«uBv/Ì¸8Ï<×74Ó\\JóÜJòI#gv%˜ž¤“ÔÓ( Š( ŠtqÉ4‹1³ÈìUFKÀ\0¦¾Ùý˜?à™Ÿ¾(ý“ÅßžçÁÞ$ÐÙíS¨_ÆpF?¸RÞq»ÑyÍ>WøKðÏÇŸ|m§xgá÷†/u­E§Ú;tùb@Ã/#œ,j?¼Ä\nþ†tØd·°µ‚UÃÇ\n#¸!@5Éü*ø;ðßà§†£ðŸÃ?\nÚhÖ†“Ê¥¸p1¾Y—‘¸êÇé]¨ZØ´QE8ŸòG¼qÿ\0bæ£ÿ\0¤ÒWó¿_Ò›¢²•e­Áœ×Äÿ\0µü?áßÅEºñgÁóiàß6édµXÛû:ýøà 8·oöcÕyÍLü„¢ºÿ\0Š	~\"|ñD¾ø“á‹­SæT—“&q¾9•‘}Ôšä((¹£ÿ\0È^Çþ¾cÿ\0Ð…~Þ~Ú_òg~\'ÿ\0°uþŽŠ¿ôùØÿ\0×Ìú¯ÛÏÛKþLïÄÿ\0ö±ÿ\0ÑÑP&~S|ø¥¯|ø¢üCðì¬\'Òî¦„6Í¹#Í…½™r=ŽjýÂøoñÃß¼\r£xÿ\0Â×\"m7ZµKˆÿ\0½6ôd`TU5ø_\\~Àµ?ü)Ïÿ\0Â·ñ¥ùOø–àyrÈNÝ:ù¶ªËÐâ7ÀVì>Vìr?W¦ÿ\0Vÿ\0îšþp<Iÿ\0#©ÿ\0_³ÿ\0èÃ_ÒÞ”är+äOÚ£þ	Ýð×ãªÝx·À¿fðt¯q9´Ô“‰âbå¢ŒóÈjÆj+·ø·ðgâGÀïKàÿ\0‰^¸Ò¯“-6˜ûI‹•u<t9Á\0ñ\\E\Zžñ&­àïi¾*Ðn\rKI¹K»IY„•U¶žŠwŠ|WâOk×~\'ñv¹y«ê·òy—wr™$‘½Éü€è\0\0VM\0QE\0QE}û3þÃ_ÿ\0hë‹}^ÞÍ¼9áaæk×Ñe\\g‘Y\r1ëÈÂú° Ÿ´}Vñ§m¢èZmÎ¡¨^H°ÛÚÛDÒK+“€ªª	$ûWï\'ìà|9ý›|\ràß\ZiO¦ë:~žÂêÑÝY¡/+¸V*HÎÖàðyÏÙïöLø;û7éŠž	ÐR}rX|«Ívðy——px‰	\0ìL\\žkÙÂúÐKc©­N¦µ?*¿à°_òT|ÿ\0`)ÿ\0ô}|_ÿ\0Á`¿ä¨øþÀSÿ\0èúø‚‚Š( gïGìWÿ\0&§ðÃþÀ3^Û^%ûÿ\0É©ü0ÿ\0°Ì×¶ÐAò×ü³þMÅ¿õõ¦ÿ\0édUøŸ_¶ðRÏù4ÿ\0×Ö›ÿ\0¥‘Wâ} ¢Š(úáÿ\0ÿ\0“}ñýsÿ\0é-½;þ\nÛku?ìÿ\0 \\Am,‘[ø–™Õ	XÔÁ*‚Äp${‘Mÿ\0‚Fÿ\0É¾øþÆ¹ÿ\0ô–Þ¾ØÕ´/^Ó.t]sM¶¿°½ŒÃqksÉ¨z«+pGÖ‚^çóoE~—þÕðK˜æû_Ž?fÅÙ\'2MáY¥ù[¹6ÓHÜ×7?F-~në\Z6­áÝRëC×´Û?P²ÃqksŽXœuVSÈ4¥_§ðG/ù~(ÿ\0×î•ÿ\0¢îkó¿Nÿ\0àŽ_ò.üQÿ\0¯Ý+ÿ\0EÜÐý?v¾Uÿ\0‚›É øŸþ¿ô¿ý,Ž¾ª?v¾Uÿ\0‚›É øŸþ¿ô¿ý,Ž‚OÅZ(¢‚Â½Óö´ººý«þ}–ÚY¼e%“ËBÛ#eŽ:ë]oì¿ûüXý¡š×Äš¤oáOK†þÖºˆ4·KÁÅ¼$†|ŽŽpž„ô¯ÒÃ?²ïìà¼D´Ñ¤¹Ë’î]×\Zž­\"ŒíXóü#¹íÖ\\è?m+[«ßÙWâe½¼³ÊÚ¥c1Ã)8ž\0\'ð¯ÁjýÆøûs|!øíªKáÒøk^yš;=?Q¶ÇŸ•£\0›ˆë;¹ãwZóoÚ«þ	¯à‹ÞxËáZxGÅŒ\Zi-QÓõôd1þòÕyÍZTWSñ#á‡>ø¢çÁ¿<7u¢êÖÜ´3\0C¯gGRUÔöe$W-AF¯‡üSâO\nËyqá­nóL–þÒK™-fhÚ[w ¼dŽv¶Ñ‘ß—IE\0QE\0U­/KÔµ­BÛIÑìg½½¼‘a··‚2òJìpTrI5úû0ÿ\0Á,õ­q¬üeûFM&•`vË†­¤iNóæFýÐ<‚‹óú•#øïà_À/ŠŸ|U‹ðÛÂóêÞTk»ÇýÝ¥¢äÒÊß*ñÑFXö¿~cµ’ÛA[7ù¤ŠÌDvó’U/øÂ?ü;ká?xvÇDÒ,Æ!´³ˆ\"/«ìÇ»“ÜÖîÚÙüÛë·6Z½íå¼OÄ‘ÉŠUÑƒUä{\Z§_¸¿´ÿ\0ì9ðŸö’µŸX’Ù<9ã- C¯ZC–“â Ê³1“†Ž8?‘¿ÿ\0f¿Š¿³Ÿˆÿ\0°þ!èF;iØý‡T·>e¥êŽèã¡õFÃNôç–Uí\\Õ¼7¬Yëú¡5Ž£a2ÜZÜÂÛd†E9VSØƒÞ¨Ñ@Éï¯¯µKÉµ\rJò{»«—2M<Ò’G<–f<’}MAE\0QE(ˆU“ÐPWCà?‡þ4øâK_øÃwºÞ¯vÀGmkâ@ÜÇî¢ŒŒ³£¹¯©¿fø&çÄßŒÂÓÅŸ\ZøJ]³Feˆ5õü|G Ä¤ó¸ú+WêwÁß_þøpxgá…mô¨)¹¸æK‹·å•²Ì{ã88\\Ëý—¾ø‹á7Àü;ñbÛ®±¢éþMâÛÉæF²4ŽûCt8ÜG¥~<þÝ¶wvŸµÄ_µZËŸªyÑùˆWz×¹ê#Ò¿vvšóo³ÏÂÚAþÃø™áX/Ú%\"Òú2b»´cüQÊ¸aÏ;NT÷\\þ}(¯®¿i¿ø\'7Åo‚?kñG‚o\Zx>ÒµÍ´Ao,“ÒhA%€þúdq’¥|ABWôeðçþIÿ\0…ÿ\0ì\reÿ\0¢¿œÚþŒ¾ÿ\0É?ð¿ý¬¿ôBPK:&¯Åÿ\0ø*ü–­ÿ\0`;ÿ\0EWíWâÿ\0üþNËVÿ\0°Fÿ\0¢¨|—EèþüVøï®ÿ\0`|1ðÖ­*0Gmj§ø¥•ÈUñœžÀÐQçõúÙÿ\0‹²¼µøâ›‹›I¢ŠëÅRI¼eVU–êYIûÃ ŒŽàÓÿ\0goø%¿Ã?\0|h»ÆºØ*éáZ-:Õø8*7òøSýÊûwOÓìt»4Ý2ÎK;XÖ ‚0‘ÄŠ0ªª8\0\0Ùe~è¥¤¥ AEPEPEPEPEPEPEPR§Q@+þÓÿ\0ðOÿ\0„ÿ\0´]x“E†/	xÒ@_ûRÎÃvüŸô˜AòO.0þ¥±Šü¢øéû6üZýž5ã£|Eðä[ÊÄZjvù’Îìz¤ c8ê§;ŠþÍbø»Á¾ñæƒuá\Zx~ÇYÒoWlö—‰#NB;Èí@Ó?=þCšwý}Ãÿ\0¡Šþ‘W­~e~ÐŸðK}KAÖ#ñ·ìów&¡cÒÜ\\xvò@&‚~Ï+Þ\0?¾n:±â¿MW­\0ÎgâW´ß‰ŸüCðûXâÓÄ\Ztú|Œìó€øîTá¿\nþxõïêžñ¡á}RÜÇ¨i—’ØÜEÜK”aùƒ_ÒWçgŒcÄñ\'üzßV¸ÓwxJþÕ|m{û¿Ý™£\"6‹Ð–¸TbgjOþÅß—àGìÿ\0áß^Z,ZÝüÚšÁÇÌn¦ù¶Ÿ÷bÀkÔ~#É=ñGý¯¿ôC×FµÎ|Gÿ\0’{âû_è‡ ç:Š(  ¯Ôÿ\0ø#ßü“ˆö\Zµÿ\0Ñ-_–úŸÿ\0{ÿ\0’oñþÃV¿ú%¨?A—¥&ÚUéKA\'þÐÿ\0²¯Â_ÚSCûŽt#V·Œ¥†·g„¼´ï€Ý3Õ#Óšü‹ý¦?bÿ\0‹_³MóÝëVÛ~’B¶ºýŒGÉ# 2d˜ä1 öc_ºõOUÒtÝkO¸Ò5>ÞúÆî3Å½ÄbHåCÕYXAô4çómE~›þÕ_ðK›Kï¶xçöoÙkpKM?…æ[¹û,Œ~C×÷mÇ<é_¶ß\r~ ^xÓþÍ·ƒuy<N\'û1Ò…«ý¤IèS¹<cœâœÕ{ÀÙSãí«Oh\r—…»Öos•¸ï—ÇÎØþý5öŸìÇÿ\0¯µµûŒhë¡<À‰SÃrþìwæe?7º\'í•úáÿ\0h~Ñí|?áÏKÓ,£[ÚZB±EŽÊª0(Ïžf_Ø;áìë¶½5²ø£ÆH ¾·}àÿ\0£BIX¹{—ÿ\0kµ}/¶”qKA!EPEPHE-Ç|PøKðóã\'†fðÄŸÙëZt¹*³.$…ÈÆø¤\\4l=Tƒ_–¿µü7âÂß¶øÃàü—>/ð¼Y•ìögR²OB‹þ½G?2\0Øê¼f¿^é»hÏæçKŽHu«8¦‘Òê5ea‚¤8È#µ~Ý~Ú_òg~\'ÿ\0°uþŽŠ³ÿ\0hïØ\'áÇ‹¿øJô¸Â~/IçS±„ywlqq >OñŒ7¹éW¿n™­tOÙ#ÄöW·(®ÐÙYÆç¤žt`ÿ\0|“øPã¥QAGéWü÷öÂÄV6¾&j€jÖˆ\"ðþ¡pÿ\0ñ÷éjäÿ\0ËEpÿ\0ã¨ûÀ­=vw—Z}Ü7ö7[ÜÛH²Ã4lUãu9VR95ú­ûþÚ´Ëo†¿¯¢·ñµŒA-®í]^$P7g§œ?‰‹¨î\0KGÑÿ\0þü?øÉá[|HðÕ®±¦\\„”bH[´‘H0Ñ¸þòkò›ö©ÿ\0‚o|@ø6/<eð½®¼_áÏ™$Iuÿ\0n5ÿ\0Zƒûê>ª:×ìE&(ŸÍa‚)+ö?ö©ÿ\0‚rü:øÙö¯|9û7„<`û¤Ã,u		÷Ñ¸ÇŸ=y¿)~\'|\Zø•ðÅÏàˆ¼ÓuPÛaM»Òä®VE<}ÓßŠsŠ®¿áÂ_ˆŸ<K„þøZ÷ZÔe#rÂ˜Ž\'åác_ö˜_YþÌ_ðLoüJ[oüh–ëÂ}²Å`ª¿Ú7ˆyåO)õ`[ý‘Ö¿P¾ü#øwðkÃqxOá·…¬ô]=0\\B¹’vþü²´îÄûP>Iý˜à˜žønÖž/øÙ5¯‹¼EE¦ªŸìÛ7àŒƒÍÃÝ€_öN3_qAo\r¼)oo\nEJ4EUG\0\08\0T»ih$Lb–Š()´úJ\0üáÿ\0‚—~Ìßþ&x–ßâ—†lìüKáÝÇìÐéºm».¡g;™	&p[\')‚ððM~fMÖÓ=½Ä/±±WÔ«)AkúPÆ+æßÚKöø3ûD,úÔ–#Ã-“,5½6\r3vûD\\,£Ž¼7ûT\r3ðöŠöŸÚöGøÉû8ê\rÿ\0	¦‚n´I$+k­ØæKI‡ÜG178ÚàsÓ=kÅ¨(ýèýŠÿ\0äÔþØækÛkÄ¿b¿ù5?†ö\0ƒùšöÚ>Zÿ\0‚–É ø·þ¾´ßý,Š¿ëöÃþ\nYÿ\0&ƒâßúúÓô²*üO ¤QE?\\?à‘¿òo¾#ÿ\0±®ý%·¯¹ká¯ø$oü›ïˆÿ\0ìkŸÿ\0ImëîZ	b^ûH~È	i}(i¿Ùþ!‚?.Ë^²P. ôW	“ºý9ÁSÍ{•!Z~~Ñß²ÅÏÙ«U+âÍ/ûG@™öÙëÖ(Ík7¢¿xŸý–ü	ë_fÿ\0Á¿ä]ø£ÿ\0_ºWþ‹¹¯Ð­wAÑ|M¤]xÄzM¦§¦ßFb¹´º…eŠd?ÂÊÃW˜|	ý™>þÎÚÇŒ/>›«m7Å××-¦ÊÛã²x„£lL~m‡ÍèÙÆ:ú¹ëÇî×Ê¿ðSoù4ÿ\0×þ—ÿ\0¥‘×ÕGî×œü|ø+¡þÐ_\rî¾x“T»°Óo¯-.n$µæ²Ã2ÊQKp»¶íÎ3œP#ð‹áwÂ/ˆŸ¼M„~ø^ïXÔ&a»Ê\\E\nçåü±¨îXŠýDý™ÿ\0à›\r~\rÛAãß×v(ñ˜ûPŠS·JÓv€Û°Øó™pN÷ù}Õê>(ø‡û3þÂ¾Ã:.e§\\·ÛhÚxó/¯äæs–äõy®=+ó·öˆý²>+~Ð7Si÷·­¡x_wî´KH‡83¿fÁï…ôQA[Ÿ^~ÑßðRx2;¯|	··ÖõxpÚÃ¨û¡Ê_ùnF8<\'ûÝ+óŸÆÞ:ñÄoÜø«Ç ¼Ö5K¦Ì—2n g!TtUáT\0;\nÂ§Á×SGmmË4Ì#Ž4\\³±8\0Ô“@ƒðà÷ˆ>9|RÑüáó$?h”M{v£‹;T É)> p=X¨ï_¹ZN—‹¥Yhö’LðØÛÇmM#I#*(PY›%›’y&¾xý‡f˜þü7]_Ä©ÿ\0	‰ãŽçQb£u¬XÌv ÿ\0³œ·«a_JP&p¾|3øñáwðŸÄÏÁ©Ûrmçå.-ãç†Uùð3ƒƒŒGù5ûSÁ=¾&ük¿xMgñw‚—ûdÿ\0¥Y\'\\D¹àgbü¼d…é_´t×Ee*êX`ƒÐŠçóYE~¹~Õ?ðLÿ\0üNž4ø.-|+â†I4à»tëçÿ\0t¨sýåùIê½ëórÙ—ãµÇÄÇøCÃ]`ø¦6ù­_\"¦qæ™såù|}ýÛ}èÏ0¯¢?f¿Ø{ãí<Z¥…‰ð÷…wâ]wP…„l;ùðÓ¦Õ…}¿û1ÿ\0Á/üðý¬üañÆâßÅzò•4”ñ.´~¿6y¸`}pžÇ­}Ñkioco¼vöð Ž(£P¨ˆ¨\0Ïýÿ\0d_ƒ¿³nš«àí^ëÒ¦Û½zùD—s\0Bž‘\'û)ë“Í{fßZZZ	\n(¢€mbxÃÁ¾ñ÷‡îü)ãMÏYÒ/“eÅ¥ÜAãqøô#±#µnQ@”ÿ\0µ_üÄ^\rûoŽ¿gï´kº\"æi¼?!-{h¹ÿ\0–NgQž‡ç\0|\rsksgq%¥å¼°O’)«£ ƒÈ>Æ¿¤ýµó?íEûü*ý£¡›^‚4ðÇŒ¶’šÍœ ‹–ÀncàH8ûÀ†§¥LüC¢½sâÇì«ñ»à÷Ž­¼âOÞÝ^jSyZ\\ú|mq¡žžS(äú©Ãâ¾Äý˜ÿ\0à•÷W_dñ‡ítÖÑ²Çá›9Awqs:”tÊ\'<ýáÒŸü\nýš¾-~Ñ\ZèÒ>ønI­b`.õKŒÇeh8ÉyÁ8çhËÂ¿V?fø\'ÏÂ_€+gâm~4ñ\"Pÿ\0ÚWqbÞÑúÿ\0£ÀI\nAèí–ã#nq_JxWÂ^ðF‡káŸè6:>•d» ´³…bŠ1ìsÜõ=ë\\P+‰¶––Š˜Í-\0Ìb¾Oý¦¿àÿ\0	~;¯øY\"ðgŒeÌ†úÒÚÝ¿_ôˆ\'Ÿ0ÜäîÆ+ë:M¾”üýürý›>.~Ï:áÑþ#xfX-älZêvù–Êèz¤ c?ì¶wûÃðçþIÿ\0…ÿ\0ì\reÿ\0¢­ø«Â~ñ¶‡uáŸhVZÆ•z»n,ï!Ybg#*} ö«ú}®—cm¦ØB!¶´‰ †0I	\Z.Õ\\žx\0he†¯È?ø(\'ÃŸ|Pý´µü?ð¾¡®jsé:vØ-!/´yxÜç¢/«1\0WëãUK}+M¶¾¹Ôítûh¯/v›„‰D“lPì[ž”?;¿g_ø%›bÖþ&ý¢µ…¿—‡Ó%e‰OÜ)Þ…cÀÿ\0h×è/…|#áŸèvÞ\Zð~c£iv‹¶K8(}uõ\'“[ih˜¥¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0nÚÓ¨ 5“›çyKæÛ¿o8ëŒúT´P\næþ#ÿ\0É=ñGý¯¿ôC×K\\×Äù\'ž)?õ¾ÿ\0Ñ@ÎuQAa_©ÿ\0ðG¿ù&ÿ\0?ì5kÿ\0¢Z¿,+õ?þ÷ÿ\0$ßâý†­ôKP&~ƒ/JZEéKA!EPJúUÐtXõ‰<Cdº¤°‹y/Eº‰Ú rÉÅA\'Œâ´h …õ§QE\0QE\0QE\0QE\0QE\0QE\0&+òËþ\nMÇKˆÖ~6×$¿ð-Ã½Ç‡E¼\"+xÏFŽP¿ze˜ò¤Œ‘_©ÕÅ|`øKá?žÔ¼ãA%¥êÊ£Í´œ²hÉèÊOâ2£ðfŠô?ŽŸ|eðÇ·~ñ}¯ÝÌÖ7ˆ“{lX„•¾9T‚\ryåXÓõí&úßTÒï&´¼´‘f‚x\\¤‘:œ«+Ag\"«Ñ@ª±ŸíÑ¥üTµ³økñZþÄ‚+KùHulgÉ6#£uñ_e×óÏÓ[Ê“ÛÈñÉGF!•‡ ‚9Wè/ì‹ÿ\0\rû2Ùü7øý¨±vÃaâI2Hè.½»	\0ÿ\0{ûÔÑú%ŠÏÔ4\rWº²½Õ´[+Ë6S5œ·ë#ÛHFÆXŽ2*å­Õµí¼wvwOÊ9bpÈêzG{Š–\rÛøRÒÑ@Q@Q@Q@&ßJZ(–©¥iºÖŸ>“­iÖ×Ö7HcžÚæ%–)TõVV0ö5ðí5ÿ\0±ð÷‰\rß‹¿g‹¨4=E·K\'‡®œýŽc×Hra\'²¶S‘‚‚¿B©¥hÊe_\nøƒÀÿ\0³¿€|#â­2];WÒtˆío-eÆè¥V9S‚Aúƒ^¯M§1 –¿à¥Ÿòh>-ÿ\0¯­7ÿ\0K\"¯Äúýzÿ\0‚§|^ðo‡~Kð’êôËâ_Omqkk	ŠÞ	ÕÚi?º¤¦ÕîI>†¿!h)Q@Ï×ø$oü›ïˆÿ\0ìkŸÿ\0ImëîZøkþ	ÿ\0&ûâ?û\Zçÿ\0Ò[zû–‚X´QE«jÖ:M”ú–©{²&¸¸‘cŽ$–fb\0ÔÖ7¾!x7á†.üaã­zÛIÒ¬×/4ÍË7dE»Ê&¿(ÿ\0k/ÛcÅŸ´ÔÞðÏÚ4?Ã\'îí7mžÿ\0‡¸ ãÉæÚçÑ?ÿ\0o}{öŠð·ÃŸ	ëPèþÑµèÿ\0·u™&U]Ac9l>p°>¯Çn=ûIÁK..\rß„?gØš¾h¤ñ%Ì;uÛDÃèî3è½ëóîŠbæ±¬jÞ Ô®5sRºÔ/îÜÉ=ÍÌ­$²±êY˜’MS¢Š÷çü·öMmRîÛãïÄ-3ý\nÙ·xnÎeÿ\0[(?ñöÊ…ƒÔå»ù/ìOû\"ê¼MŒ<]g$Ñçÿ\0HfÊJeÁû<|r½7·aÀäñúåccg¥Ù[éºu¬VÖ¶±¬0C…HÑFT\0\0ŠÙ=QA!EPJúS|µó<Íƒywcœzf¤¢€m-PEPEPEPHV–Š\0£Vef@YT‘ÈíÅ;o­:Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0J6óKE\0&(¥¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€«ãïø)7ˆ~>ißÛEøIá{ëPI‰µ]<™.-í@9‹Ë_™ca’ò\0ã$×Ø4Ö@ÊU”0<{Ðó[ÓƒÁ•û!ûPÿ\0Á8>|h[¿|8[_ø½ÁÜBN½~§Î‰(Äõ‘9êJ±¯ÊßŒ_þ(|ñ+ø_â_…îtÉòM½ÈRö·i’7Ã(ù\\qõÀ4s¯Ôÿ\0ø#ßü“ˆö\Zµÿ\0Ñ-_–ú•ÿ\0z»·o|C±Y”Îšµœ­y\napÓ þT?B×¥-\"ô¥ ¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(\0¢Š(Ë¿hoÙûÁ¿´GfðŸ‰¡^Àm+REýí•ÆÒï!ãrw±\0ÆŸ‹ßüiðOÆ÷ÞñÆšö÷v¬Z	ÂŸ&ò³DÄ|ÈØüAÁWï=yoíû<xöˆðlž\Zñe¨‚ú\0Ï¦j°Æ¿h²—mb2PœnNŒ=Lü6¢½ãgÀß|ñ„ÞñÖšcn^ÎúÆÚö,ñ$N@Ï¸<ƒÔWŸPPQEô§ìÃûo|AýŸäƒÃz·›â?îù´Ù¤ýõ 9$Û98^NJ”ÿ\0²NkõGáOÆO‡\Z¼7Š>øŠßQ¶8C·¯ýÉ¢?27×ƒÔ9¯ÁªéþüLñ×ÂŸAâ¿\0x’óGÔ`#/„$ËýÉîÈ‡º°\"4~úQ_~Î?ðQï|@[o|dÞñ‘\Zêòé—\'§,ÌL}åÿ\0ht¯²íî º†;›Y£šT<rFÁ•”ô Ž ’J(¢€\n(¢€\n(¢€\n(¢€\n(¢€˜§Q@&~×°/ƒÿ\0i‰üqáýbmÇ\nÆ·2»Igvª0©2rSa“§9V¯ÉŒ~(|	ñ#ø_âg…n´»ŒŸ³Ü-mv€‘¾GÊãŽÜŽà\Zþ†\núW3ñá·~*xnãÂ_¼/a­éw*A†î-ˆÆøØòŽ3Ã)zÐ4ÏçFŠûÃö¢ÿ\0‚`øËÀFóÆ_ÚçÅ@ÓK£ÈÛõ;QÉ\"0	Ð\0¼éÃu¯….­nl®%³¼·–	ás‘J…]pUä{\Z~µÿ\0Á#äß|Gÿ\0c\\ÿ\0úKo_r×Ã?ðHÖSû?ø‘ÃÅS3ÈÍ­½}™âï\ZxOÀ:þ%ñ§ˆltm2ÕwIsy2Æ£Øg–cÙFI=fÝxGíû`ü1ýì^ËP¹]oÅ2&ë}ÎUó8ÃNÜù)ß${_\'þÒðRÍW\\[¯	|·›K±pb—_ºmÔžöèîÇ£7Íìµðž¡¨_ê·³jZ¥õÅåÝË™&¸¸‘¤’F=Y™‰,O© =ãwíñ+ãÿ\0‰?á ñö±¾(Izu¾ä´³SŒˆÐ“ÉÀËX÷5æôQAAEP_BþÈß²_‰?hÏ®£¨G>à.qý§¨íÁ¸e*M¬¼…[–è äò@:²?ìkâÚW‹Ä^ ŽçHð-œÀ]^í)-ñ˜­²>ŒýÜñ_­Þð†üáÛ	øGG¶Ó4­:!\r½µ¼aU@îqÕRÇ’I\'šØ¾ðŸ‡¼\ráÍ?Â~ÒáÓ´­.·µ·…p¨Š0=É=I<’I<Ö½À|5øëðÇâî±â]À>\"\Z•ï„oM†«’éåJ—‚À‘ÆFGwôQE\0QE\0VG‹<YáßøoPñw‹µh4ÍJ®o.çl$Q¯R{“ØÉ$YŸ\r~(xâÿ\0…`ñ·ÃŸ[ëZ=ÄÜBvÈ‡Œ¬+8 pAèE\0uTQE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0&Úæ~ |7ð?Å?\rÜxGâ†,5½.åNè.¢±°@tn¨ã<2Gc]=%\0~QþÓßðK¯x/í~0ø=Ï‰t`Í,šÄBÕy?ºnê:ÃôûÇšËÿ\0‚SøÊïÁ´&½ðëYY¬Ïˆô‰\"6Ó©F[»g ©ä0C0Æ3Í~·í¯1ñgìéð»Å_<=ñuô1¦ø¿Ã—ks©§â.d4S€1*2³/#pÏP;žœ´êjÓ¨QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QEÄ|_ø7à?Ž¹ð_t”º¶”·¸Pörà,.AÚÃ?B2 â¿#iÙ7Çÿ\0³Ž¸Ï¨Dú¯…î¤Ûa­CòÛ9\"9Gü³“§CØžßµ5â/è^,Ñnü;âm&×RÓ/£0ÜZÜÆ9õçÚ¦>´WÛµWüÃ^ð+^xëà•½Î³áåÌ×\Z>L—–C©1ñ™£ñ÷€ÅÖ¾%txÝ£‘J²¬¬0AŠ( a^ëðöÈøÅðhtý\'V:×‡¿y¢jNÒBªzù-Ðžÿ\0/ËžªkÂ¨ Ùo€ÿ\0¶ÿ\0ÁŽ	m¥PxkÄ“|¿Ù\ZœŠ¦Gÿ\0¦2ýÉ á¿Ù¯¡kùåVd`èÅYNAkèÏ‚·wÇƒio£Ïª¯Štˆ_°jìÒ<iéÙÞœtrJ	±ûE|ÙðgöùøñkÈÓµ\r`øGZ—jý‹YuŽ9ãˆçcrxÎÒ}+éfŠâ$ž	HäPÈèÙV¡u}Q@Q@Q@Q@%-fø‡Ä¾ðž—6¹ârÇIÓíÆén¯nuå˜@\Zkæÿ\0ÚgöøCûFÃ>µ%šøoÅåw®iñ*™˜t1ô˜{œ8ÀÃcŠóï_ðSO†¾ûNð›K—Åº¢eúLÃ§£r2ß—ð\0ïWÍžÿ\0‚”|zÑ|q/ˆ|]&Ÿ®è·Žú:Û¬Âƒþ}Ý~daêÅ³ß=hjý„~ü`ý•¾3xŸàßÄ}-ßÃÞ\'´7º6±k—²ºº·<…oàv…˜”l7îÇ^µáðQèüy§þÐWz‰<G©_èwVê\Z¼Ó´.»]#Aò©#äã$mÉ¯Ñ¯ÿ\0´Â¯ÚGMCÁ:ÔcQ‰7Ýi7L©{jqÉ)Ÿ™yÆõÈ÷í_7ÿ\0ÁRþ¶µðûÃŸìmó7‡o\ZÆñ€çì÷ÚOû²(ð3@#ó*Š(  ¢ŠÕðÇ…|GãMr×Ã^Ño5mRõöAki’G?AØw\'Þ€2«í?ÙöÖ~$5—ÄOŒV·:O…Ã,öš[\r—:šðAló\'×ï0éÍ{ì§ÿ\0õÐ~µ§>4Ck­ø‘\nÍk¥ÞYØ7P\\‰¤²;g­}¬ªB¨\0\0¨%²ž£i>Òít=M¶Óôû–k[xÄqÅ\ZŒU\0*íP ¯€?àš_òW¿hOûGþ•]×ßõðüKþJ÷í	ÿ\0cÿ\0Ò«º}[ñëöŒøû:éš©ãåÔZ/êi¥Ú­”VW#%ß$aTuÆO<^¡¬‘¬‹÷XC_ÁYäMø]ÿ\0cSè¡_vÙÿ\0Ç¤õÍ 	«ÊüYûG|=ðoÆÏ|Õ—Q>#ñl=›Ån\ZÞ0¡Ê‰9¼¶ÆéÎ3^©_~Ðò“‚¿õâ¿ú\rÍ>ÇøÇ\'`øYâ›¯‰šZj^¶ÒçŸUµhüÏ6Ý³(^	<q‚9Ç\"¹Ù?Pø5¬|ÑuŸ€þ}Â—²O$VrÇ²e˜HRC\'ÌÛ›+×qàj×íYÿ\0&×ñ/þÅ›ïýÕñwÃ¿ŽÚÇÀø&>‘âoÊ±xƒUÔîô.B¹òd–æRòÜª+‘þÑZ}}ñ›öÃýŸ¾]¾“ã¯Aý°‹–Ò¬#k«¥ôÞ‰‘Û\"¼¿Ã?ðT/Ù{^ÕMÕ/¼Cáõ‘°—:–˜D\'Ü˜Ë=È«?±÷ìcà†þÒþ!|AÑmüQñÄ6é©ê\ZŽª‚èÚ¼À?—ùŸïÝÎ8¯ üið—áŸÄ=øÓÀº&«ap†6Ž{4%sÝ\rÈÃ±R \r¿ø“Ãþ.Ñm<Gá}jÏVÒï£Û^YÌ²Å*êÊpjÎ¡¨éúMŒú¦©{¬m,÷È8–f<\0s_œšŠ£ÿ\0‚s~Ô—uo^IðsÆ:së‰tí1Ó_÷€ÇWŒà|Êñ“È~KÏßðRo5ˆÔ<ðL»ýä¤îu­Ó<‡bÝæ8ûî`(Ùã_ø)gì·áRMÇÄšŸ‰f‰Š»è¶\r4YvÈÅUÇº’+¨øOûv~Í?5(4Çk¦ëL#†ÃX…­$•ÏQ›äfö\r“ØW ü3øð‡áƒ‡|à=&Âcó›d’ærÞ–fÜž¼Ÿ¦+Ïÿ\0iOØßáGÇï\nÞ¨ðÝ†âØ`vÒõ«V	’p	A)AûÈËc!²Gb\r\0}E|…ÿ\0ÝøÝâï‰?u¿‡¿®%¹ñÃ«õÒ¥¸™‹K%¹#Ë:4r&OP«žrkëÚyŒ?hŸ‡ž	øÉáOºÔ—ÿ\0ð‘øÂšÄÅoºvÑ#ç‚ÅÓœf½B¾\ný¤?å%?ëÉô+šûÖ…ygÁ?Ú?á×ÇÍKÅÚ_P3x/P]?PûU¿”®Ìd\nñœœ©1H9Áùzr+Ô«à?ø%¿üŽ_´ýŒVú6þ~Õ]STÓt=:ãWÖ5{HÚk‹‹‰qÄ€d³1àêjÕ~~ÔZ§‰¿joÚÛCýŽô½róIðn‹\njž(kfÚ÷XA+z¨Ñ¢0÷p0êž4ÿ\0‚™~Ë~Ô¤ÒôÝ{Wñ<Ð±W}Oibã©9Uaî¤Šì>\rþÜŸ³ŸÆíNøgÆŸÙúÝÁÛ›«Âm&™¿»o‘Ûý•bOa^…ðçàoÂ_„úð\'€ô}6Ö\nÎ-Uæ˜ÒÊÀ¼Œ}XšóÚwö1ø_ñÛÂ·×šo‡¬´/Z@Ói:ÖŸ\nÛËö…‘fØ˜…°~aœ‚ gÑUç¿hƒlãºøŸã«\r\"YÔµ½žL·SÝ!@\\|cÞ¾`ýšloØÿ\0Ç^-ñóÿ\0|\'ŽK	^nMá#m¡ç%‹üŒz¹êMQý‰ÿ\0fM\'âî”j¯Ú&ÜxÇÅ-º’óM·Ô¿{kkl…o)¾V$ƒµNUT.s@Xî4ÿ\0ø*Oì¯{ª\r>}KÄvVìÛVö}%¼“ï…%Àÿ\0€×Ó~øàŸ‰žƒÅ~ñ6Ÿ®é7?êî¬æ¹U‡UaÝX;Šn©ðßáî¹¤¾ƒ¬x@½Ó]<¶µŸM…âÛÓJà~å¾ýŸ¾þÉvþ9øŸà{}bÂÂêÁï¯ôÖ¾2ÚC\nÒ\"6V<Œ³A@@ø¡ñ›áÁ}uß‰Þ4Ó´i2!fYÈÆDq®^CÈû ã½|íÿ\0Lý•ÿ\0µÛüKöbû>ÝýÞH÷Æwãþ^Oû!ü_Û+ÄÚ÷íYûGFÚüjOcáígccF>`c<4i¹UW¡evlšûÙ¾x	´¿ì6ðF€tÝž_Øÿ\0³aòvwfÝ¸öÅ3¾ü_økñ“Bÿ\0„‹áŸŒ4ýzÉNÙ\r´Ÿ¼…¿»$gö`*çÄ‰^øWáù|SñÅZ~ƒ¥Äv›‹ÉB†nÊƒï;Ê “^uðïöIø-ð{âv£ñkáæ—¨hW·örZÜi¶×…tÝ¬Á™Äá¾Q£°ð×ƒü[ðŸöÀý£üSñ#öšø¢hþð•À³ðÏ†õMj;8î†æ\0íg—	ºB¸,Î£8 £uOø*wìÃc¨5­›x«R¶FÚ÷¶ÚN!ÿ\0;+øWºü\Zý¤¾ü|µ–o†>6´Ôî-ÐIqbá¡»OhœÆˆd{×9¥|fýŒ4=.=Fø“ð’ËN‰<´µ·Ô´ôˆ/Lm\rŠøëö½Ò¿gµŸíû)ü\\ðF‡ãï_Esq¦h:Í¶ÍB\"À1KhÛ ²µ“~A ÓZÍñ‰|?àýëÄ~*Ö¬´.Å<Ë‹ËÉ–(¢_Vf \nñ›_Úëá®‰û6øoöñö­µ¥Ep¶1g¸½Ø|Ëxœ¹óÀì\0É WÌþøyñ£þ\n%â‹oˆ_þÝàï‚ö™toÂíÚš»!8ù²ÇŽ¢1Õ¨Ö¼Gÿ\0>ý–ôMIôÝ7T×õáÃÜiº[¾ ÈT‘îzgÁ¿Ûö}øë{à_Aý±*–].þ6µº|uØ®\0|²MwžøIðÇáî‹‡¼à=I°Bˆíì£°1—lnvõ,I5ó×í‘ûøâGõ_ˆ_´;\rüBðý»êV:†–¢ÔÝ4_;G(Œ\rÌ@;_ïÇ8â€>³¯:ø½ûB|øa÷Äÿ\0Xé:–·´É–êp:”…võÆ=ëÃgÚãPñ\'ì[«ülñ[ÝÀö—–Ú–FÏµÏƒt2ŒŸ6ìWœ~Ä³®›ñâÎçö´ý¢¡ÿ\0„»_ñ5ôÍ¤Yê?¼´µ·ŽFMÞS|­ó§*ª ã\' ºµÿ\0‚¨~Ì3jKkp¾+¶´vÚ/¤ÒsõÂ±üv¾šøoñOáïÅß§Š¾ø²Ã^Ó¶4¶²dÆýÒD8dof\0Õëïø\'TÓ_EÔ¼¢]iò\'–Ö³iñ<%}\nÆ?\nüëý©¼¬~À?´Ÿ?³œ¿Ùžñ9›LÕ4)Y¤³K’…—OÜ8,?+\'\07?L(¢ŠQE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0QE\0”´Pt¥¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0(¢Š\0+å¿Úkö\rø{ñ½n¼Qá·ð¯Œ\\\Zêñk|ÿ\0ôñ\Zôcÿ\0=æç$5}IE\0~\rüXø1ñàŸˆ›Ã_|9>›pÙ0M÷à¹AüqH>WqÜ\\E~ýxëá÷‚þ&x~xëÃ¶zÆ™p>hn;O÷•‡Ìî¤\Züìý¢?àš>&ðÏÚ¼Qð.êm{LAæ6‰rÃíÐŽþSð³c†ãø\\øbŠµªiz–‹¨\\i:ÆŸqe{k!Š{{ˆÌrFãª²žAúÕZQE\0ëÿ\0jOŽäŠ/øÚïû66ÉÒ¯ÚlØw[Ÿ“>¨Tû×“Ñ@¥ß	ÿ\0à©ž\rÕ–=;ãƒî´;“…:†•››cîÑÞ\'à^¾»ø{ñáÅk1}ð÷Ç\ZV´›w4vóbdÿ\0z&Ã¯â~U?RÔ4›¨ïô»ë‹;˜Žèæ·•£t>¡”‚(èNŠüoøoû}~Ò_Ò+6ñt~#°ìÚÔsiF$üØý+ê‡ÿ\0ðUoßG·Ä¯‡zž•?I.´©–æï±öºý2Ô\nÇÞWÍ:×üCö\\Ò´Xõk_^ê“H¹6šdþzŸFóPßUóïÄOø*Ö£2Ékð¯á¤V£·šÝÇ˜ÞÄC\0~.h£ä¿jï€¿<Ø<]ñÅµÁÿ\0‰u‰7W$ú;?àD\nüžø™ûY|ø²²Ûx³â%úØËœØØbÒßiþ±¸¼O½y33bI=I ,}íñoþ\nâ-@Ï¦üðd:T\'*šž±‰§?í,*v!ôÜÏî;WÆ>+|Fø©©[âŒµ=ràP]NLqdçÆ0ˆ=”\nå( aEP3GÃþ\"×¼\'¬ZøƒÃ:½Þ—©YH$·ºµ•£’6Ãkì¿\rþÝ6¾xƒàí\nÅ6±¦½­Ÿ‰-¡ÊyëóB×/Ý\"EC½=Tu¯ˆè B°ÚÄdw•Óü=øgãÏŠºô~\Zøá{íjýñ¹-ãÊÄ§ø¤sò¢û±¿E?gø&¯„¼#ö|p¸ƒÄš²âHô›vacné¡á¦=8á}›­sãŸÙßö=ø­ûB]E¨iv?ØÞmŸ\\½B\"Àê!N\ZfàŽ>Pz°¯Õ€ÿ\0³OÂïÙïEÑÄº”ÈóXºîîO|·ð/ûõ<×¨ZYÚØ[Eeck½¼*8¡@ˆŠ:\0£€=…M@®QE\n(¢€\nü÷ÿ\0‚êV^ý§><ü3ñEÂiúþ¡¬=Ý¬Çi¹.gbS=~Yc`:•lö5ú_>þÐ¿±OÂÚZ·ñ–£>©á¯Úª¤zæ0Šv÷<ÀAW³pÃ¦q@Î7þ\nWðÄŸ>Ã®x>Ò[­[Á:’kb—/%¸’m£¹PÊøôC^™û.þÓý£>éÚÆ…ª[E¯ÛZÆšÆŽÒ=¤àaŽÓÉŒJ°ãwÈ­ß€?u‚~“Áº§ÄxÚG¼’éoµ©|ÉcFU%$“°mÎ	<±¯#ø©ÿ\0ëøñÄrøÛÂ—zß€<C3™^ïÃ·>Lm!êÞQSþá\\äæ€>—×¼A¡ø[I¹×¼I«ZišmœfK‹«©–(¢QÝ™Ž|ð¯UŸö¾ý¿OÇ	ZÌ~ü2µû%µü‘”û\\¦	R<ÎZYÀê8-]Õ—üÂºÅô|XøéñÆöví”²¼Ô\nÆG¡f.ÀºA¯¬üð÷Á|/gà¿\0øz×FÑìT¬6ÖëÆIÉfcË1$’ÌI4ÅþÕŸòmÿ\0ìY¾ÿ\0ÑM_	èÿ\0|Añ{þ	s¡Çá;9/5Ÿ\rj÷zÔ±Œ¼ñÇq*Êª;°G,}˜ï_l~Ù¾&Ðü/û0üC»×u­#»Ñn,müÆÁ–âe)j;±\' ô\'µr_ðN]PÒ?dO®¡nÐµá¼¼‰X`˜žæBôaÈö ÐÇì{ûMøã÷Ã\r\Z-ZÞé0Úk:D¶x¥B™O-mÜtÎ5îš¶­¥è:uÆ±­j6Ö6‘™\'¸¸Gj:–fà\nù·â÷üßà_ÅMãµx–y<é5\\ù\"I:ï1T6{®Ü÷Íq0Á2|3­]Cÿ\0?ãßÄið0e±»Ôq±-¼ø(Êu»\rþ\nûiXÜi:|š—ÂŸ‡ZzÛ_ß|ñÅ~DŽûU¸oÞÈê ‘3qšûÏÆ^6ø_û>ü<MsÅ–^ðžŠ°YEäÛ7•’(Ò8”Ÿ@\0ªïÃo†øCá[ü:ðÝ®‹¤Û|Ë ’îz»»ÎÇ³kKÅžð×Ž¼?{á_è¶š¶“¨Æa¹´ºŒ<r)ö=êäE\07Â^0ð·4_x7^²Ö4«ÔAwi(tpFzŽ‡Øò+‹øûûA|=ýž|yâß\ZëñÜ¬/ý¦‰Ú/çÚJG\ZuÁ#–èrkçýcþ	“ðÿ\0OÔ®5„_ü{ðý.\\³ÚéÚ“4#Ø«àvÜÌ}ëgáÏüoà§…|EŒ<­x‹â&³‹4rk÷{á§ ´cýg=œ°ö /ø&GÃ?h~ñgÆO\ZYµ¥ÿ\0ÄÍTjVð²í-l¥ØKŽÁÞi\nÿ\0²èE}£MŽ8áa†5HÑBª¨ÀP:\0AN GÁ_ðPk|(øÙð“ö°Óô™uÂ·ÃXXúÂ<ÝÉŸ÷ÖYT›•AûÂ¾Ðø{ñ#Á?¼/iã/\0xŠÓXÒ¯4s@ù*{«¯T`r\nÅjxƒÃúŠô[Ïø“IµÔ´ËøÌ7V—1‡ŽT=™Oÿ\0­__µ÷ìYà¿ÙÇág‰>9|ñ×Œ<\'q§Ëh­¥Újn q=Ìp$H\0ó	\0³P3îŽŸ|ðÀ·Þ2ñÎµ·—ý†Ïïï§ÚvEu$œqÔàWÍ¿ðK¿‡~(Ñ~ø¿â×Š,MœŸ5u¿´…†[ÄeÄ˜=<ÒcÔ(=ë\'ödýƒ~ø×ÁÞøáño\\ñ\'5oKµÕ~Ë¬_3ÛE$ˆi~@gbpkî›{{{;xím`ŽbP‘Ç\Z…TQÀ\0\0%~y|w½ºý“oM\'öñŒòøÇVcLÔ¯bŒ¿ÙÄ‘È’¦(¥Àê»±’1_¡µƒãxCâW†o<ã¯Úk:=úìžÖå2§Ð‚9V˜Gc@‹^ñG‡|e¡Úø“ÂzÕž­¥ßF$·»´”IŠFFúôë^qûH~ÑÞý<}â?êÐ^[yGÒ•Á¸¾¹Ú|µTêpœð{à\n¾ÿ\0‚dx#I¾žëá7Æˆ~·¹bÒYØjE£Áì*Äzn$ûší~ÿ\0Á?¾\nü3ñ$^:ñ\rÖµãßA –KÄw>x…Æeî–_q±@Ï¿bo\0ë??gŸÚ7Ávª?¶uõµšÝ[åÝx¦Y‘NzfDÏL×Òÿ\0ðNŸÚÃº×Ã;?Ùÿ\0Å×Qè¾:ð;Ë¦.ìùr\\ÀŽv²ûÌ¤”e ô5ì³ì·á¿ÙÂûÆ—Úˆ¯õCãSûAÖéE²‚åc]¿{cr}eüzýˆ~ü~Õ¿á*Öì/´/€öÖ7‘;ã¡‘H(äxÞôïìë\Z™$`ª£,Äà^Iuñ\'àÿ\0í¥øûà¯þ iÚ®¯•qa©Gk½…·œpûBHŒpx8¯ø&µæª¿Ù>*ý©¾&jÚãû>KÆÃ/÷[s²Ÿûæ¾øû9ü%ýô9´_†>[&»Úo/¦ÍuvW¡’Fä’BŒ(ÉÀòüŸãŸðºß\\ý’~.M‡<_áýbwÓ ¼`‹v²|Ï\Z9à°`\\ydg÷íx·ÇïÙà¿í°ÞxïCš\rfÖ?.ßXÓ¦ò.ã^ÊÍ‚²(ÇÁÇ8Åxqÿ\0‚lêö,ŸµgÄÖðñù?³¾ØØ1ÿ\0sïìÇ¶Ü{PÓZoÇ?ƒþ&ø‡}ðoEñæ›âË[WžçM·,íc²ày{†á•Ý¸g‘_šÿ\0þþÏÿ\0\nh¯üý¬<dí{v·Ö¯fš$‰™¶!tedR¸cÀte$_ \0d¿ƒ?³ŒS\\xB–M^î?*ëXÔ%óîæ^¥w`R@ùP\0p3šÛøÛû:ü%ý¡48ô_‰ÞŽøÛçì—°¹†îÔžñÊ¼þÉÊžàÐìû M\ZÍÁý5ÑÀee½¹!èAs\\¥û?Á8´‰zoÁëïøxxÃVÈ¶Òã¼¼’BÀµÙ¬l@$+N8¬Óÿ\0Í´ÓÑ´¯~Òÿ\0´	¸þÍŽÿ\0äýÐªôõZõÙûö\"ø\'û<êâÙßë^&thÎ³¬L&š0ß{ËPGžä\rÝFqÅ\0jx“ö4ýž|U7ƒ?µ¼\neà8Ì:>œ—@…÷•–,âQ¿æ;º÷Èâ»_‰¿>üÐôÝSâG‰­<;¦^ÝÇ¦Y3Âå¥IT\ZªI$€ µÜW1ñáŸ¾-øVëÁ_ü;m¬è÷xg‚l‚®3‡FRdá”‚2h·¤êú^½¦Ûë\Z&£mcw’‹y‘È§¡V^ûc~Ó~	øð¿X·ºÕ­çñf±e-¦¤FÛ¦’Y¨‘”r±®íÅ\\`dšòË¯ø&?†t{‰WáÇ¯ˆþÓçlµ®¡º0=R„þ9®ãàßüßàoÂÅãQµx–óbÔ<Ap&Iýõˆ\0¥»å÷Ûà?fïÙ_Äð~Á~$øcâs§ø“â­æ¢!›å0<Š¿eWô?»F>›ÈíPÿ\0Á9~>è:ÿ\0á™>\"\\§‡üuàÛÛ›8,o”×p™ö¦x.ŒYJõ )ÉÇÜUá_?cÿ\0´EÒëž/Ñntÿ\0Ä¡#Ö´©¼‹’A\'d”8P=Í™cS$ŒTe˜œ\0+ósöøø‘7íQãOþËÿ\0³ý¼~+Ô4›‰õmZæÎ@`ŽXâ`\"}ÓµY·6q¹•zäW¦·ü6ÚùF•¯~Ó?µqý›%ÿ\0ÈWû§q+ø\r}ðCöqøGû<è²èÿ\0¼2¶osƒw}<†k»¢:•¹Çû+……\0zmQ@‚Š( Š( Š( Š( Š( Š( Š( Š( Š( Š( Š( Š( Š( Š( Š( Š( Š( Š( Š( Š( Š( Š( Š( Š( Š( )øÕû1üøõbÑøçÃ1ÿ\0i*íƒV³ýÍä>Ÿ8ûãý—=«ó«ã·ü³â÷Âö¸Ö¼\n­ãÆKo´Œ%ì	þÜ%ñëoRoÖº(Ïçžhf¶šK{ˆ^)bb’FêU•‡yÔÊý½øÑû*üøí“øÓÂ±Ç«•Û¯bÆ´=‰eâAìá…|ñŸþ	£ñkÀâ}[á•ü>6ÒÓ/ötU¶¿zÿ\0«fÛ&?ØmÇ²Ð;ŸÑWµ­ZðÞ¥>‹â\r&ïM¿¶m“[]BÑKô*ÀThQE\0QE\0QE\0QE\0QE\0Q]WÃß…>+jßØ¿ü©k·cÅ¬YH³À2Hp‘v WÛŸÿ\0à–·’µ¶µñÃÅ‰\npï¢i?3Ÿöd¹Î¡§Ù¨ð…ü%âk0x{Â\Zö±©\\GkgK!÷ÂŽ©<\nû“à?üZÔ|{ãÖ²tÈ2®4-6U’wH–pJ§Ñ7ö…}çðãá?Ã¯„z*èü\'c¢Ú\07ù*L’‘ÞI—sîÄ×]@®s^øoàO…ú~ð…ì4M>?ùekž›ŽYÛŽ¬I®–Š(QE\0QE\0QE\0QE\0QE\0S&G’#Žf‰ÙJ¬Š(Hà€x8÷§Ñ@Áÿ\0èÔ<câk]gö…ý¤<[ñ/M±¸3Ã¤ÏZ@Üç|é8<g`CèE}‹¤éZn‡¦Zèº=Œ6V0¥½µ¼(8£PªÀ\0\0*Ý\0QE\0QE\0QE\0QE\0W™~Òbý¡~\rëß	eñhÛ_fe¿[o´y-\rÄsÇ¹wcÁ‡ZôÚ(–ø[àX~ü8ð×Ã»}Eïãðæ—o¦­ÓÆ#i„HyPNÜã8ÉÇ­u4Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@Q@gÄƒŸ~.é§Kø‹à½7ZaD’hñ4@çý\\«‡CÉû¬+ã?‹_ðJýéfÔ¾øÚ[)‰,º^³ûÈ±è³ Ü¿ð%o­}ÿ\0EsðÛâ—ìÅñÇàìÒÂmà\rB+8ÿ\0æ!hŸi´aëæÇ¿FÁö¯-¯èi•]J:†V Œ‚+Å~&þÆÿ\0³ÏÅVšï^øie©OÉÔ4¶6“gÔìÂ¹ÿ\0yM¹øŸE}ÿ\0ñ#þ	O«[,·Ÿ\n~$Cz9)c­[ùL=¼èòâ‚¾dñïìûG|9ód×¾ê×Ðä›­1ô[GñfÄ¨ôçÑZZ_†|I®jK£è¾Ô¯ïÝ¶­­­¬’ÌO E³øW¼xöý¦<vÑM\'‚‡¬äû×\ZÕÂÛ•õË™Oýó@ÏjK{{‹©–ÞÖ	&•ÎÕHÔ³1=€šý)økÿ\0­ð^–ðß|Rñõö¶ãìtØ~Ë}„³°ú¯«þüø=ðŽÃß\0iZT¸Ã\\¬~eÃýf³ŸÎ\\ü§øSû	þÐÿ\0<«Èü&|9¥ÈFouÆ6ß)ç+Füõö‡Âoø&OÁßýŸRø©^øÏPk´M­ˆaÎ<´;ÜýæÁî½«ìz(ÌÏøgÃ¾Ò¢Ðü-¡Øé:|ÛYÛ¬1¯\0}Õ\0gÍiÑE\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€\n(¢€?ÿÙ',NULL);
INSERT INTO `usuario` (`identificacion`,`tipoDocumento`,`rol`,`nombre`,`apellido`,`telefono`,`direccion`,`correo`,`contrasena`,`estado`,`foto`,`codigo_recuperacion`) VALUES ('222','cedula de ciudadania','gerente','mariana','castillo','3222231035','cra 11 n 19 - 31','castillorodriguezmariana2@gmail.com','$2y$10$9yq9.LUjO9IDFeQgapOpf.8.3qsAkeBUXT7Jmv3vGM5MKYRD4sHcS','activo','','187048');
INSERT INTO `usuario` (`identificacion`,`tipoDocumento`,`rol`,`nombre`,`apellido`,`telefono`,`direccion`,`correo`,`contrasena`,`estado`,`foto`,`codigo_recuperacion`) VALUES ('321','cedula de ciudadania','gerente','Marlen','Salcedo','413235','Calle 5','marlen.salcedo.09@gmail.com','$2y$10$YzMHD71DatwGRMBpfL6cOuqf6c4aXzOoIBxZ.ORcQY3gyh24dMk0K','activo','',NULL);
INSERT INTO `usuario` (`identificacion`,`tipoDocumento`,`rol`,`nombre`,`apellido`,`telefono`,`direccion`,`correo`,`contrasena`,`estado`,`foto`,`codigo_recuperacion`) VALUES ('1941','cedula de ciudadania','gerente','Daniel','Lopez','3004401797','CRA 16A n 19 - 30','juanperez123@gmail.com','$2y$10$Mi1TySDAzfq6CKzyLqYnXeIDkWZa9tNWRj9KigO5vucA0jir3Itu.','activo','',NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=220 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- -----------------------------
-- Datos de la tabla `verificaciones`
-- -----------------------------
INSERT INTO `verificaciones` (`id`,`correo`,`codigo`,`fecha_envio`) VALUES ('3','diuejh45','168482','2025-05-28 10:03:38');
INSERT INTO `verificaciones` (`id`,`correo`,`codigo`,`fecha_envio`) VALUES ('4','diuejh45@gmail.com','334895','2025-05-28 10:03:51');
INSERT INTO `verificaciones` (`id`,`correo`,`codigo`,`fecha_envio`) VALUES ('50','ctskiller89gmailcom','711675','2025-06-04 10:56:08');
INSERT INTO `verificaciones` (`id`,`correo`,`codigo`,`fecha_envio`) VALUES ('51','ctskiller@89gmail.com','710289','2025-06-04 10:59:11');
INSERT INTO `verificaciones` (`id`,`correo`,`codigo`,`fecha_envio`) VALUES ('52','marlen.salcedo.09@gail.com','670445','2025-06-04 11:06:42');
INSERT INTO `verificaciones` (`id`,`correo`,`codigo`,`fecha_envio`) VALUES ('120','deicy.cao.v@gmail.com','667401','2025-06-06 21:16:04');
INSERT INTO `verificaciones` (`id`,`correo`,`codigo`,`fecha_envio`) VALUES ('146','alexluqueear@gmail.com','881140','2025-06-07 23:01:05');
INSERT INTO `verificaciones` (`id`,`correo`,`codigo`,`fecha_envio`) VALUES ('204','marlen.salcedo.09@gmail.com','588178','2025-06-12 07:57:16');
INSERT INTO `verificaciones` (`id`,`correo`,`codigo`,`fecha_envio`) VALUES ('211','deicycarovargas@gmail.com','795862','2025-06-12 16:50:25');
INSERT INTO `verificaciones` (`id`,`correo`,`codigo`,`fecha_envio`) VALUES ('213','danielabron297@gmail.com','543333','2025-06-12 17:04:56');
INSERT INTO `verificaciones` (`id`,`correo`,`codigo`,`fecha_envio`) VALUES ('214','danielbaron297@gmail.com','284106','2025-06-12 17:05:31');

SET FOREIGN_KEY_CHECKS=1;
