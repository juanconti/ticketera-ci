-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-08-2017 a las 23:01:36
-- Versión del servidor: 10.1.16-MariaDB
-- Versión de PHP: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ticketera`
--
CREATE DATABASE IF NOT EXISTS `ticketera` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ticketera`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `abonados`
--

CREATE TABLE `abonados` (
  `id` int(10) UNSIGNED NOT NULL,
  `descripcion` varchar(50) NOT NULL,
  `cuit` varchar(11) NOT NULL,
  `razonsocial` varchar(75) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `fcreado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fmodificado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) UNSIGNED NOT NULL,
  `descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `descripcion`) VALUES
(1, 'ADMIN'),
(2, 'USUARIOS_ABM'),
(3, 'ABONADOS_ABM');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sectores`
--

CREATE TABLE `sectores` (
  `id` int(11) UNSIGNED NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `permisos` varchar(25) NOT NULL,
  `activo` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sectores`
--

INSERT INTO `sectores` (`id`, `descripcion`, `permisos`, `activo`) VALUES
(1, 'Admin', '1', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

CREATE TABLE `tickets` (
  `id` int(10) UNSIGNED NOT NULL,
  `titulo` varchar(50) DEFAULT NULL,
  `cuerpo` text NOT NULL,
  `prioridad` tinyint(1) DEFAULT NULL,
  `abonados_id` int(10) UNSIGNED DEFAULT NULL,
  `fcreado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fmodificado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuarios_id` int(10) UNSIGNED NOT NULL,
  `estado` int(10) UNSIGNED NOT NULL,
  `relacion` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Disparadores `tickets`
--
DELIMITER $$
CREATE TRIGGER `insert_ticket_abonados_on_bitacora` AFTER INSERT ON `tickets` FOR EACH ROW INSERT INTO tickets_bitacora
(tickets_id, titulo, cuerpo, abonados_id, fecha, usuarios_id, estado, relacion)
VALUES(NEW.id,NEW.titulo,NEW.cuerpo,NEW.abonados_id,NEW.fcreado,NEW.usuarios_id,NEW.estado,NEW.relacion)
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_ticket_abonados_on_bitacora` AFTER UPDATE ON `tickets` FOR EACH ROW INSERT INTO tickets_bitacora 
(tickets_id, titulo, cuerpo, abonados_id, fecha, usuarios_id, estado, relacion)
VALUES(NEW.id,NEW.titulo,NEW.cuerpo,NEW.abonados_id,NEW.fmodificado,NEW.usuarios_id,NEW.estado,NEW.relacion)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets_bitacora`
--

CREATE TABLE `tickets_bitacora` (
  `id` int(10) UNSIGNED NOT NULL,
  `tickets_id` int(10) UNSIGNED NOT NULL,
  `titulo` varchar(50) DEFAULT NULL,
  `cuerpo` text NOT NULL,
  `abonados_id` int(10) UNSIGNED NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuarios_id` int(10) UNSIGNED NOT NULL,
  `estado` int(10) UNSIGNED NOT NULL,
  `relacion` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets_estados`
--

CREATE TABLE `tickets_estados` (
  `id` int(10) UNSIGNED NOT NULL,
  `descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `tickets_estados` (`id`, `descripcion`) VALUES
(1, 'pendiente'),
(2, 'continuado'),
(3, 'cerrado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(45) NOT NULL,
  `clave` varchar(45) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `sectores_id` int(11) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activo` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `clave`, `nombre`, `apellido`, `email`, `sectores_id`, `created_at`, `updated_at`, `activo`) VALUES
(1, 'admin', '4c882dcb24bcb1bc225391a602feca7c', 'Juan', 'Conti', 'admin@ticketera.com', 1, CURRENT_TIMESTAMP, NULL, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `abonados`
--
ALTER TABLE `abonados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `bitacora_tickets`
--
ALTER TABLE `tickets_bitacora`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `bitacora_tickets`
--
ALTER TABLE `tickets_estados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sectores`
--
ALTER TABLE `sectores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `abonado_id_idx` (`abonados_id`),
  ADD KEY `creador_id_idx` (`usuarios_id`),
  ADD KEY `estado_idx` (`estado`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sector_idx` (`sectores_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `abonados`
--
ALTER TABLE `abonados`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT de la tabla `tickets_bitacora`
--
ALTER TABLE `tickets_bitacora`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT de la tabla `tickets_estados`
--
ALTER TABLE `tickets_estados`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `sectores`
--
ALTER TABLE `sectores`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `abonado_id` FOREIGN KEY (`abonados_id`) REFERENCES `abonados` (`id`),
  ADD CONSTRAINT `usuario_id` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `estado` FOREIGN KEY (`estado`) REFERENCES `tickets_estados` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `sector` FOREIGN KEY (`sectores_id`) REFERENCES `sectores` (`id`) ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
