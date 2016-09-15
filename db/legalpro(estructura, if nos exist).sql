-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-11-2015 a las 19:34:41
-- Versión del servidor: 5.6.16
-- Versión de PHP: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `legalpro`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidad`
--

CREATE TABLE IF NOT EXISTS `entidad` (
  `Id` int(4) NOT NULL AUTO_INCREMENT,
  `id_profesion` int(11) DEFAULT NULL,
  `id_estudio` int(11) DEFAULT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  `id_nacionalidad` int(4) DEFAULT '0',
  `id_tipoentidad` int(11) DEFAULT NULL,
  `id_localidad` int(4) DEFAULT '0',
  `id_zona` int(4) DEFAULT '0',
  `id_provincia` int(4) DEFAULT '0',
  `id_tipo_responsabilidad_iva` int(4) DEFAULT '0',
  `nombre` varchar(255) DEFAULT NULL,
  `codigo` varchar(255) DEFAULT NULL,
  `nombre_pila` varchar(255) DEFAULT NULL,
  `nombre_apellido` varchar(255) DEFAULT NULL,
  `Observaciones` varchar(255) DEFAULT NULL,
  `nro_cuit` varchar(255) DEFAULT NULL,
  `nro_documento` varchar(255) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `EstadoCivil` smallint(6) DEFAULT '0',
  `Direccion` varchar(255) DEFAULT NULL,
  `CodPostal` varchar(255) DEFAULT NULL,
  `Celular` varchar(255) DEFAULT NULL,
  `Fax` varchar(255) DEFAULT NULL,
  `Telefono` varchar(255) DEFAULT NULL,
  `Telefono2` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `TipoPersona` int(11) DEFAULT '0' COMMENT '0-Fisica | 1 - Juridica',
  `tipo` int(4) DEFAULT '0',
  `esp` int(11) DEFAULT '0',
  `estado` int(1) DEFAULT '1' COMMENT '1-Activa | 0-Inactivo',
  `fechainactividad` int(4) DEFAULT '0',
  `status` int(11) DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidad_empresa`
--

CREATE TABLE IF NOT EXISTS `entidad_empresa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_estudio` int(11) DEFAULT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `esp` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `entidad_empresa_codigo` (`codigo`),
  KEY `entidad_empresa_idestudio` (`id_estudio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidad_localidad`
--

CREATE TABLE IF NOT EXISTS `entidad_localidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_estudio` int(11) DEFAULT NULL,
  `id_provincia` int(11) DEFAULT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `esp` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `entidad_localidad_codigo` (`codigo`),
  KEY `fk_entidad_localidad_provincia` (`id_provincia`),
  KEY `fk_estidad_localidad_estudio` (`id_estudio`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2383 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidad_nacionalidad`
--

CREATE TABLE IF NOT EXISTS `entidad_nacionalidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `entidad_nacionalidad_codigo` (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=195 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidad_profesion`
--

CREATE TABLE IF NOT EXISTS `entidad_profesion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_estudio` int(11) DEFAULT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `esp` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `entidad_profesion_codigo` (`codigo`),
  KEY `entidad_profesion_idestudio` (`id_estudio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidad_provincia`
--

CREATE TABLE IF NOT EXISTS `entidad_provincia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `entidad_provincia_codigo` (`codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidad_tipoentidad`
--

CREATE TABLE IF NOT EXISTS `entidad_tipoentidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_estudio` int(11) DEFAULT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `esp` int(11) DEFAULT '0',
  `tipo` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `entidad_tipoentidad_codigo` (`codigo`),
  KEY `entidad_tipoentidad_idestudio` (`id_estudio`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=91 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entidad_zona`
--

CREATE TABLE IF NOT EXISTS `entidad_zona` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_estudio` int(11) DEFAULT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `esp` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `entidad_zona_codigo` (`codigo`),
  KEY `entidad_zona_idestudio` (`id_estudio`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudio`
--

CREATE TABLE IF NOT EXISTS `estudio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expediente`
--

CREATE TABLE IF NOT EXISTS `expediente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_estudio` int(11) DEFAULT NULL,
  `numero` int(11) DEFAULT '0',
  `anio` int(11) DEFAULT '0',
  `nroincidente` int(11) DEFAULT '0',
  `caratula` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '0',
  `id_expediente_camara` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `expediente_numeroyanio` (`numero`,`anio`),
  KEY `fk_expediente_estudio` (`id_estudio`),
  KEY `fk_expediente_expediente_camara` (`id_expediente_camara`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expediente_camara`
--

CREATE TABLE IF NOT EXISTS `expediente_camara` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(255) DEFAULT NULL,
  `abreviatura` varchar(50) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `expediente_v`
--
CREATE TABLE IF NOT EXISTS `expediente_v` (
`identificador` varchar(86)
,`id` int(11)
,`id_estudio` int(11)
,`numero` int(11)
,`anio` int(11)
,`nroincidente` int(11)
,`caratula` varchar(255)
,`status` tinyint(4)
,`id_expediente_camara` int(11)
);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fos_group`
--

CREATE TABLE IF NOT EXISTS `fos_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_4B019DDB5E237E06` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fos_user`
--

CREATE TABLE IF NOT EXISTS `fos_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estudio_id` int(11) DEFAULT NULL,
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
  UNIQUE KEY `UNIQ_957A647992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_957A6479A0D96FBF` (`email_canonical`),
  KEY `IDX_957A647976229BB3` (`estudio_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=28 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fos_user_fos_group`
--

CREATE TABLE IF NOT EXISTS `fos_user_fos_group` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`),
  KEY `IDX_8D2E96FFA76ED395` (`user_id`),
  KEY `IDX_8D2E96FFFE54D947` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura para la vista `expediente_v`
--
DROP TABLE IF EXISTS `expediente_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `expediente_v` AS select concat(if((`e`.`id_expediente_camara` is not null),`ec`.`abreviatura`,''),' ',`e`.`numero`,'/',`e`.`anio`,convert(if((`e`.`nroincidente` = 0),'',concat('/',`e`.`nroincidente`)) using utf8)) AS `identificador`,`e`.`id` AS `id`,`e`.`id_estudio` AS `id_estudio`,`e`.`numero` AS `numero`,`e`.`anio` AS `anio`,`e`.`nroincidente` AS `nroincidente`,`e`.`caratula` AS `caratula`,`e`.`status` AS `status`,`e`.`id_expediente_camara` AS `id_expediente_camara` from (`expediente` `e` join `expediente_camara` `ec` on((`e`.`id_expediente_camara` = `ec`.`id`)));

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `entidad_empresa`
--
ALTER TABLE `entidad_empresa`
  ADD CONSTRAINT `fk_estidad_empresa_estudio` FOREIGN KEY (`id_estudio`) REFERENCES `estudio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `entidad_localidad`
--
ALTER TABLE `entidad_localidad`
  ADD CONSTRAINT `fk_entidad_localidad_provincia` FOREIGN KEY (`id_provincia`) REFERENCES `entidad_provincia` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_estidad_localidad_estudio` FOREIGN KEY (`id_estudio`) REFERENCES `estudio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `entidad_profesion`
--
ALTER TABLE `entidad_profesion`
  ADD CONSTRAINT `fk_estidad_profesion_estudio` FOREIGN KEY (`id_estudio`) REFERENCES `estudio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `entidad_tipoentidad`
--
ALTER TABLE `entidad_tipoentidad`
  ADD CONSTRAINT `fk_estidad_tipoentidad_estudio` FOREIGN KEY (`id_estudio`) REFERENCES `estudio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `entidad_zona`
--
ALTER TABLE `entidad_zona`
  ADD CONSTRAINT `fk_estidad_zona_estudio` FOREIGN KEY (`id_estudio`) REFERENCES `estudio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `fos_user`
--
ALTER TABLE `fos_user`
  ADD CONSTRAINT `FK_957A647976229BB3` FOREIGN KEY (`estudio_id`) REFERENCES `estudio` (`id`);

--
-- Filtros para la tabla `fos_user_fos_group`
--
ALTER TABLE `fos_user_fos_group`
  ADD CONSTRAINT `FK_8D2E96FFA76ED395` FOREIGN KEY (`user_id`) REFERENCES `fos_user` (`id`),
  ADD CONSTRAINT `FK_8D2E96FFFE54D947` FOREIGN KEY (`group_id`) REFERENCES `fos_group` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
