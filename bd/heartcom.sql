-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-01-2026 a las 06:39:21
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
-- Estructura de tabla para la tabla `codigos_mfa`
--

CREATE TABLE `codigos_mfa` (
  `id_codigo_mfa` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `tipo` enum('LOGIN') NOT NULL,
  `expira_at` datetime NOT NULL,
  `usado` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `codigos_mfa`
--

INSERT INTO `codigos_mfa` (`id_codigo_mfa`, `id_usuario`, `codigo`, `tipo`, `expira_at`, `usado`, `created_at`) VALUES
(7, 8, '297073', 'LOGIN', '2025-12-14 01:10:35', 1, '2025-12-13 21:00:35'),
(8, 8, '138761', 'LOGIN', '2025-12-20 00:01:23', 1, '2025-12-19 19:51:23'),
(9, 8, '808416', 'LOGIN', '2025-12-20 21:40:53', 1, '2025-12-20 17:30:53'),
(10, 8, '548465', 'LOGIN', '2025-12-20 22:15:37', 1, '2025-12-20 18:05:37'),
(11, 8, '896524', 'LOGIN', '2025-12-22 22:24:57', 1, '2025-12-22 18:14:57'),
(12, 8, '298478', 'LOGIN', '2025-12-22 22:40:08', 1, '2025-12-22 18:30:08'),
(13, 8, '771971', 'LOGIN', '2025-12-22 23:06:11', 1, '2025-12-22 18:56:11'),
(14, 8, '976033', 'LOGIN', '2025-12-24 00:15:17', 1, '2025-12-23 20:05:17'),
(15, 8, '890535', 'LOGIN', '2025-12-24 00:20:26', 1, '2025-12-23 20:10:26'),
(16, 8, '320537', 'LOGIN', '2026-01-10 05:42:47', 1, '2026-01-10 01:32:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `id_estado` int(11) NOT NULL,
  `estado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id_estado`, `estado`) VALUES
(1, 'pagado'),
(2, 'por pagar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_certificado`
--

CREATE TABLE `estados_certificado` (
  `id_estados_certificado` int(11) NOT NULL,
  `nombre_estado` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados_certificado`
--

INSERT INTO `estados_certificado` (`id_estados_certificado`, `nombre_estado`, `descripcion`, `activo`) VALUES
(1, 'solicitado', 'El vecino ha solicitado el certificado', 1),
(2, 'en_revision', 'El directivo está revisando la solicitud', 1),
(3, 'aprobado', 'La solicitud fue aprobada y está pendiente de pago', 1),
(4, 'rechazado', 'La solicitud fue rechazada por el directivo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos_residencia`
--

CREATE TABLE `pagos_residencia` (
  `id_pago` int(11) NOT NULL,
  `id_certificado` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `monto` int(11) DEFAULT NULL,
  `fecha_pago` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos_residencia`
--

INSERT INTO `pagos_residencia` (`id_pago`, `id_certificado`, `id_estado`, `monto`, `fecha_pago`) VALUES
(1, 5, 2, 2000, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`) VALUES
(1, 'Moderador'),
(2, 'Jefe de junta de vecinos'),
(3, 'Miembro');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `solicitud`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `solicitud` (
`id_certificado` int(11)
,`nombre_certificado` varchar(150)
,`asunto` varchar(40)
,`mensaje` varchar(2000)
,`created_at` datetime
,`nombre` varchar(101)
,`estado` varchar(50)
,`apellido` varchar(101)
,`rut` varchar(18)
,`correo` varchar(150)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_certificado`
--

CREATE TABLE `solicitud_certificado` (
  `id_certificado` int(11) NOT NULL,
  `id_certi` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL DEFAULT 1,
  `asunto` varchar(40) NOT NULL,
  `mensaje` varchar(2000) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitud_certificado`
--

INSERT INTO `solicitud_certificado` (`id_certificado`, `id_certi`, `id_usuario`, `id_estado`, `asunto`, `mensaje`, `created_at`) VALUES
(1, 2, 8, 3, 'sadasdasdasd', 'zsddasdasdsadas', '2025-12-20 17:56:42'),
(2, 1, 8, 3, 'cambio de casa ', 'por motivos de narcotrafico me cambio de casa y necesito el certificado de residencia para estos tramites con el motivo de seguir vendiendo drogra', '2025-12-23 20:51:07'),
(3, 1, 8, 3, 'Cambio de casa ', 'quiero mudarme a otra ciudad por motivos de trabajo y necesito esto para actualizar mi direccion', '2026-01-10 01:34:11'),
(4, 1, 8, 1, 'Cambio de casa ', 'dsdasdasdas', '2026-01-10 01:55:07'),
(5, 1, 8, 3, 'Cambio de casa ', 'asdasdasdasdasdasdasdasdasdsadas', '2026-01-10 02:25:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_certificados`
--

CREATE TABLE `tipos_certificados` (
  `id_certi` int(11) NOT NULL,
  `nombre_certificado` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos_certificados`
--

INSERT INTO `tipos_certificados` (`id_certi`, `nombre_certificado`) VALUES
(1, 'Certificado de residencia'),
(2, 'Certificado de inscripción vecinal'),
(3, 'Certificado de participación en proyectos comunitarios'),
(4, 'Certificado de buena conducta vecinal'),
(5, 'Certificado de voluntariado barrial');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `p_nombre` varchar(50) NOT NULL,
  `s_nombre` varchar(50) NOT NULL,
  `ap_paterno` varchar(50) NOT NULL,
  `ap_materno` varchar(50) NOT NULL,
  `fecha_nac` date NOT NULL,
  `estado_civil` varchar(10) DEFAULT NULL,
  `rut` varchar(18) DEFAULT NULL,
  `telefono` varchar(10) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `email_verificado` tinyint(1) NOT NULL DEFAULT 0,
  `email_token` varchar(64) DEFAULT NULL,
  `email_token_expira` datetime DEFAULT NULL,
  `direccion` varchar(200) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `p_nombre`, `s_nombre`, `ap_paterno`, `ap_materno`, `fecha_nac`, `estado_civil`, `rut`, `telefono`, `correo`, `email_verificado`, `email_token`, `email_token_expira`, `direccion`, `clave`, `id_rol`) VALUES
(8, 'Javier ', 'Jannet', 'Smith', 'vera', '1991-12-13', 'soltera', '18.608.676-2', '6789020', 'con.leiva@duocuc.cl', 1, NULL, NULL, 'pajaritos', '12345', 1),
(14, 'Fabian', 'mateo', 'Villablanca', 'Smit', '2015-01-22', NULL, '18.608.677-4', '922203145', 'fabianirribarra667@gmail.com', 0, 'f86a3aa3a27f21c9f3029c49b424677a2b77ca39395fb2a5f0b3892e0c9eec27', '2025-12-25 00:29:22', 'lo blanco 0824', '$2y$10$2MZY280lACZ0B4W5Ye1UxOlQvN9KmU4M0/v0CQMrOCJ.WF6j6LGe6', 3);

-- --------------------------------------------------------

--
-- Estructura para la vista `solicitud`
--
DROP TABLE IF EXISTS `solicitud`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `solicitud`  AS SELECT `sc`.`id_certificado` AS `id_certificado`, `tp`.`nombre_certificado` AS `nombre_certificado`, `sc`.`asunto` AS `asunto`, `sc`.`mensaje` AS `mensaje`, `sc`.`created_at` AS `created_at`, concat_ws(' ',`u`.`p_nombre`,`u`.`s_nombre`) AS `nombre`, `est`.`nombre_estado` AS `estado`, concat_ws(' ',`u`.`ap_paterno`,`u`.`ap_materno`) AS `apellido`, `u`.`rut` AS `rut`, `u`.`correo` AS `correo` FROM (((`solicitud_certificado` `sc` join `usuarios` `u` on(`sc`.`id_usuario` = `u`.`id_usuario`)) join `tipos_certificados` `tp` on(`tp`.`id_certi` = `sc`.`id_certi`)) join `estados_certificado` `est` on(`est`.`id_estados_certificado` = `sc`.`id_estado`)) ORDER BY `sc`.`created_at` DESC ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `codigos_mfa`
--
ALTER TABLE `codigos_mfa`
  ADD PRIMARY KEY (`id_codigo_mfa`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `estados_certificado`
--
ALTER TABLE `estados_certificado`
  ADD PRIMARY KEY (`id_estados_certificado`);

--
-- Indices de la tabla `pagos_residencia`
--
ALTER TABLE `pagos_residencia`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `fk_pago_certificado` (`id_certificado`),
  ADD KEY `fk_pago_estado` (`id_estado`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `solicitud_certificado`
--
ALTER TABLE `solicitud_certificado`
  ADD PRIMARY KEY (`id_certificado`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_estado` (`id_estado`);

--
-- Indices de la tabla `tipos_certificados`
--
ALTER TABLE `tipos_certificados`
  ADD PRIMARY KEY (`id_certi`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `rut` (`rut`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `codigos_mfa`
--
ALTER TABLE `codigos_mfa`
  MODIFY `id_codigo_mfa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estados_certificado`
--
ALTER TABLE `estados_certificado`
  MODIFY `id_estados_certificado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `pagos_residencia`
--
ALTER TABLE `pagos_residencia`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `solicitud_certificado`
--
ALTER TABLE `solicitud_certificado`
  MODIFY `id_certificado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipos_certificados`
--
ALTER TABLE `tipos_certificados`
  MODIFY `id_certi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `codigos_mfa`
--
ALTER TABLE `codigos_mfa`
  ADD CONSTRAINT `codigos_mfa_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `pagos_residencia`
--
ALTER TABLE `pagos_residencia`
  ADD CONSTRAINT `fk_pago_certificado` FOREIGN KEY (`id_certificado`) REFERENCES `solicitud_certificado` (`id_certificado`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pago_estado` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`);

--
-- Filtros para la tabla `solicitud_certificado`
--
ALTER TABLE `solicitud_certificado`
  ADD CONSTRAINT `fk_solicitud_estado` FOREIGN KEY (`id_estado`) REFERENCES `estados_certificado` (`id_estados_certificado`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
