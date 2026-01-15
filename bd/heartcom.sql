-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-01-2026 a las 20:14:59
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `heartcom`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_proyecto`
--

CREATE TABLE `tipos_proyecto` (
  `id_tipo_proyecto` int(11) NOT NULL,
  `nombre_tipo` varchar(80) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos_proyecto`
--

INSERT INTO `tipos_proyecto` (`id_tipo_proyecto`, `nombre_tipo`, `descripcion`) VALUES
(1, 'Infraestructura', 'Obras físicas del barrio'),
(2, 'Social', 'Actividades sociales y comunitarias'),
(3, 'Cultural', 'Eventos y actividades culturales'),
(4, 'Medioambiental', 'Proyectos ecológicos y sustentables'),
(5, 'Seguridad', 'Proyectos relacionados con seguridad vecinal');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tipos_proyecto`
--
ALTER TABLE `tipos_proyecto`
  ADD PRIMARY KEY (`id_tipo_proyecto`),
  ADD UNIQUE KEY `nombre_tipo` (`nombre_tipo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tipos_proyecto`
--
ALTER TABLE `tipos_proyecto`
  MODIFY `id_tipo_proyecto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
