-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-01-2026 a las 20:27:02
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
(1, 2, '565192', 'LOGIN', '2026-01-15 23:13:58', 1, '2026-01-15 19:03:58'),
(2, 2, '634108', 'LOGIN', '2026-01-15 23:15:15', 1, '2026-01-15 19:05:15'),
(3, 1, '236927', 'LOGIN', '2026-01-15 23:23:43', 1, '2026-01-15 19:13:43'),
(4, 2, '288027', 'LOGIN', '2026-01-15 23:29:20', 0, '2026-01-15 19:19:20'),
(5, 1, '190713', 'LOGIN', '2026-01-15 23:29:51', 1, '2026-01-15 19:19:51'),
(6, 2, '613864', 'LOGIN', '2026-01-15 23:39:54', 1, '2026-01-15 19:29:54'),
(7, 1, '345319', 'LOGIN', '2026-01-15 23:43:22', 1, '2026-01-15 19:33:22'),
(8, 1, '180283', 'LOGIN', '2026-01-15 23:56:22', 1, '2026-01-15 19:46:22'),
(9, 1, '138053', 'LOGIN', '2026-01-16 15:59:02', 1, '2026-01-16 11:49:02'),
(10, 2, '164191', 'LOGIN', '2026-01-16 19:54:31', 0, '2026-01-16 15:44:31'),
(11, 2, '836098', 'LOGIN', '2026-01-16 20:02:15', 1, '2026-01-16 15:52:15'),
(12, 1, '794925', 'LOGIN', '2026-01-16 20:50:54', 1, '2026-01-16 16:40:54'),
(13, 3, '334265', 'LOGIN', '2026-01-16 21:20:50', 1, '2026-01-16 17:10:50'),
(14, 3, '906384', 'LOGIN', '2026-01-16 22:31:07', 1, '2026-01-16 18:21:07'),
(15, 2, '884293', 'LOGIN', '2026-01-16 22:33:43', 1, '2026-01-16 18:23:43'),
(16, 3, '183669', 'LOGIN', '2026-01-16 22:37:47', 1, '2026-01-16 18:27:47'),
(17, 1, '864168', 'LOGIN', '2026-01-16 23:18:41', 1, '2026-01-16 19:08:41'),
(18, 1, '413047', 'LOGIN', '2026-01-16 23:19:10', 1, '2026-01-16 19:09:10'),
(19, 3, '547973', 'LOGIN', '2026-01-16 23:51:13', 1, '2026-01-16 19:41:13'),
(20, 3, '913648', 'LOGIN', '2026-01-16 23:56:04', 1, '2026-01-16 19:46:04'),
(21, 3, '324167', 'LOGIN', '2026-01-17 00:43:07', 1, '2026-01-16 20:33:07'),
(22, 2, '192722', 'LOGIN', '2026-01-17 04:14:22', 1, '2026-01-17 00:04:22'),
(23, 3, '684186', 'LOGIN', '2026-01-17 04:30:02', 1, '2026-01-17 00:20:02'),
(24, 2, '745431', 'LOGIN', '2026-01-17 18:10:12', 1, '2026-01-17 14:00:12'),
(25, 1, '611644', 'LOGIN', '2026-01-17 18:29:54', 1, '2026-01-17 14:19:54'),
(26, 3, '601694', 'LOGIN', '2026-01-17 18:43:33', 1, '2026-01-17 14:33:33'),
(27, 4, '267071', 'LOGIN', '2026-01-17 19:07:34', 1, '2026-01-17 14:57:34'),
(28, 3, '209208', 'LOGIN', '2026-01-17 19:09:43', 1, '2026-01-17 14:59:43'),
(29, 4, '669657', 'LOGIN', '2026-01-17 20:35:31', 1, '2026-01-17 16:25:31');

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
-- Estructura de tabla para la tabla `estados_postulacion`
--

CREATE TABLE `estados_postulacion` (
  `id_estado_postulacion` tinyint(4) NOT NULL,
  `nombre_estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados_postulacion`
--

INSERT INTO `estados_postulacion` (`id_estado_postulacion`, `nombre_estado`) VALUES
(2, 'aceptado'),
(1, 'pendiente'),
(3, 'rechazado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_proyecto`
--

CREATE TABLE `estados_proyecto` (
  `id_estado_proyecto` int(11) NOT NULL,
  `nombre_estado` varchar(50) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados_proyecto`
--

INSERT INTO `estados_proyecto` (`id_estado_proyecto`, `nombre_estado`, `descripcion`) VALUES
(1, 'Planificado', 'Proyecto creado, aún no iniciado'),
(2, 'En ejecución', 'Proyecto actualmente en desarrollo'),
(3, 'Completado', 'Proyecto finalizado'),
(4, 'Cancelado', 'Proyecto cancelado'),
(5, 'Aprobado', 'Proyecto aprobado'),
(6, 'Rechazado', 'Proyecto rechazado\r\n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_reserva`
--

CREATE TABLE `estado_reserva` (
  `id_estado_reserva` int(11) NOT NULL,
  `estado` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado_reserva`
--

INSERT INTO `estado_reserva` (`id_estado_reserva`, `estado`) VALUES
(1, 'en proceso'),
(2, 'aprobado'),
(3, 'rechazado');

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulaciones_proyecto`
--

CREATE TABLE `postulaciones_proyecto` (
  `id_postulacion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_proyecto` int(11) NOT NULL,
  `fecha_postulacion` datetime NOT NULL DEFAULT current_timestamp(),
  `id_estado_postulacion` tinyint(4) NOT NULL DEFAULT 1,
  `observacion_admin` varchar(500) DEFAULT NULL,
  `fecha_respuesta` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `postulaciones_proyecto`
--

INSERT INTO `postulaciones_proyecto` (`id_postulacion`, `id_usuario`, `id_proyecto`, `fecha_postulacion`, `id_estado_postulacion`, `observacion_admin`, `fecha_respuesta`) VALUES
(15, 3, 1, '2026-01-17 15:11:03', 1, NULL, NULL),
(19, 4, 1, '2026-01-17 15:25:41', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos_barrio`
--

CREATE TABLE `proyectos_barrio` (
  `id_proyecto` int(11) NOT NULL,
  `nombre_proyecto` varchar(120) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date DEFAULT NULL,
  `id_estado_proyecto` int(11) NOT NULL,
  `id_tipo_proyecto` int(11) NOT NULL,
  `responsable` varchar(150) NOT NULL,
  `presupuesto_estimado` decimal(12,2) NOT NULL DEFAULT 0.00,
  `presupuesto_utilizado` decimal(12,2) NOT NULL DEFAULT 0.00,
  `direccion_proyecto` varchar(255) DEFAULT NULL,
  `cupo_maximo` int(11) NOT NULL DEFAULT 0,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proyectos_barrio`
--

INSERT INTO `proyectos_barrio` (`id_proyecto`, `nombre_proyecto`, `descripcion`, `fecha_inicio`, `fecha_fin`, `id_estado_proyecto`, `id_tipo_proyecto`, `responsable`, `presupuesto_estimado`, `presupuesto_utilizado`, `direccion_proyecto`, `cupo_maximo`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 'Limpieza de áreas verdes  ', 'Ne necesitan voluntarios para la limpiesa de plazas ', '2026-01-23', '2026-01-31', 5, 4, 'Alejandra Mariela Cortes Soza', 200000.00, 0.00, 'avenida García 2058', 19, '2026-01-16 21:41:33', '2026-01-17 18:25:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` int(11) NOT NULL,
  `id_estado_reserva` int(11) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `Fecha_ini` date DEFAULT NULL,
  `Fecha_fin` date DEFAULT NULL,
  `asunto` varchar(50) DEFAULT NULL,
  `motivo` varchar(200) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id_reserva`, `id_estado_reserva`, `id_tipo`, `Fecha_ini`, `Fecha_fin`, `asunto`, `motivo`, `id_usuario`) VALUES
(4, 1, 2, '2026-01-18', '2026-01-25', 'necesito poder cambiar mi direccion por favor ', 'hbvbbjbhjgjhbhjghh', 3);

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
(1, 1, 3, 1, 'Reunion', '<zx<xa<xczcszc dwae aw', '2026-01-16 18:28:17'),
(2, 1, 3, 1, 'Reunion', 'adadawdaw', '2026-01-16 18:29:02'),
(3, 1, 3, 1, 'Cambio de casa ', '1234567asdasdasdsadasdasd', '2026-01-16 18:29:28'),
(4, 1, 3, 1, 'deja de ponerte triste', 'sadasdasdasdasdasdasdas', '2026-01-16 18:32:03'),
(5, 3, 3, 1, 'Reunion', 'dwadawdawdaw', '2026-01-16 18:32:15');

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_reserva`
--

CREATE TABLE `tipo_reserva` (
  `id_tipo` int(11) NOT NULL,
  `tipo` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_reserva`
--

INSERT INTO `tipo_reserva` (`id_tipo`, `tipo`) VALUES
(1, 'cancha'),
(2, 'Salas de Reuniones '),
(3, 'piscinas '),
(4, 'Areas Verdes'),
(5, 'Plazas de la comunidad'),
(6, 'sedes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transacciones_webpay`
--

CREATE TABLE `transacciones_webpay` (
  `id_transaccion` int(11) NOT NULL,
  `id_certificado` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `monto` int(11) NOT NULL,
  `token_ws` varchar(255) DEFAULT NULL,
  `orden_compra` varchar(50) DEFAULT NULL,
  `session_id` varchar(100) DEFAULT NULL,
  `codigo_autorizacion` varchar(20) DEFAULT NULL,
  `medio_pago` varchar(50) DEFAULT NULL,
  `numero_cuotas` tinyint(3) DEFAULT NULL,
  `tipo_cuotas` varchar(50) DEFAULT NULL,
  `estado_transaccion` enum('INICIADA','AUTORIZADA','RECHAZADA','ANULADA','ERROR') NOT NULL DEFAULT 'INICIADA',
  `fecha_transaccion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `last4_tarjeta` char(4) DEFAULT NULL,
  `respuesta_json` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

INSERT INTO `usuarios` (`id_usuario`, `p_nombre`, `s_nombre`, `ap_paterno`, `ap_materno`, `fecha_nac`, `rut`, `telefono`, `correo`, `email_verificado`, `email_token`, `email_token_expira`, `direccion`, `clave`, `id_rol`) VALUES
(1, 'constanza', 'valeria', 'leiva', 'vera', '1994-01-14', '18.608.676-7', '942971785', 'gerina.leiva@gmail.com', 1, NULL, NULL, 'pajaritos', '$2y$10$eOq.Aj4DL11QM0hATtgpyOLLJnPPwXbyqdSJwCpHkNyQHg/b6/uYu', 1),
(2, 'Pedro', 'Carlos', 'Peres', 'Cortes', '1994-01-14', '11.635.036-K', '942971785', 'cleivavera94@gmail.com', 1, NULL, NULL, 'pajaritos 1123', '$2y$10$Y5UYwwGHNpQrY4n//8lJVeCDHxjEX/3HkO4aplbu8Kn3WjHGPjnbm', 2),
(3, 'Alejandra', 'Mariela', 'Cortes', 'Soza', '2000-09-15', '5.342.034-6', '943456245', 'starlix234.leiva@gmail.com', 1, NULL, NULL, 'pajaritos 1124', '$2y$10$9K9xs132yCoskJCiwZIEr.50jZavZn/Qj5.Rd4U4FrGUD90t3Zd.2', 3),
(4, 'Fabian', 'mateo', 'Villablanca', 'Smit', '2000-11-11', '20.447.987-9', '933203191', 'fabianirribarra667@gmail.com', 1, NULL, NULL, 'lo blanco 0824', '$2y$10$gMOMoWyQOsCm42GF49hhU.yoll2ON50252RKrq1c5TA2J2MNnwFoW', 3);

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
-- Indices de la tabla `estados_postulacion`
--
ALTER TABLE `estados_postulacion`
  ADD PRIMARY KEY (`id_estado_postulacion`),
  ADD UNIQUE KEY `nombre_estado` (`nombre_estado`);

--
-- Indices de la tabla `estados_proyecto`
--
ALTER TABLE `estados_proyecto`
  ADD PRIMARY KEY (`id_estado_proyecto`),
  ADD UNIQUE KEY `nombre_estado` (`nombre_estado`);

--
-- Indices de la tabla `estado_reserva`
--
ALTER TABLE `estado_reserva`
  ADD PRIMARY KEY (`id_estado_reserva`);

--
-- Indices de la tabla `pagos_residencia`
--
ALTER TABLE `pagos_residencia`
  ADD PRIMARY KEY (`id_pago`),
  ADD KEY `fk_pago_certificado` (`id_certificado`),
  ADD KEY `fk_pago_estado` (`id_estado`);

--
-- Indices de la tabla `postulaciones_proyecto`
--
ALTER TABLE `postulaciones_proyecto`
  ADD PRIMARY KEY (`id_postulacion`),
  ADD UNIQUE KEY `uk_usuario_proyecto` (`id_usuario`,`id_proyecto`),
  ADD KEY `idx_post_proyecto` (`id_proyecto`),
  ADD KEY `idx_post_estado` (`id_estado_postulacion`),
  ADD KEY `idx_post_usuario` (`id_usuario`);

--
-- Indices de la tabla `proyectos_barrio`
--
ALTER TABLE `proyectos_barrio`
  ADD PRIMARY KEY (`id_proyecto`),
  ADD KEY `fk_proyecto_estado` (`id_estado_proyecto`),
  ADD KEY `fk_proyecto_tipo` (`id_tipo_proyecto`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `fk_reserva_estado` (`id_estado_reserva`),
  ADD KEY `fk_reserva_tipo` (`id_tipo`),
  ADD KEY `fk_reserva_usuario` (`id_usuario`);

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
-- Indices de la tabla `tipos_proyecto`
--
ALTER TABLE `tipos_proyecto`
  ADD PRIMARY KEY (`id_tipo_proyecto`),
  ADD UNIQUE KEY `nombre_tipo` (`nombre_tipo`);

--
-- Indices de la tabla `tipo_reserva`
--
ALTER TABLE `tipo_reserva`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `transacciones_webpay`
--
ALTER TABLE `transacciones_webpay`
  ADD PRIMARY KEY (`id_transaccion`),
  ADD KEY `idx_trans_certificado` (`id_certificado`),
  ADD KEY `idx_trans_usuario` (`id_usuario`);

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
  MODIFY `id_codigo_mfa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

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
-- AUTO_INCREMENT de la tabla `estados_postulacion`
--
ALTER TABLE `estados_postulacion`
  MODIFY `id_estado_postulacion` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estados_proyecto`
--
ALTER TABLE `estados_proyecto`
  MODIFY `id_estado_proyecto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `estado_reserva`
--
ALTER TABLE `estado_reserva`
  MODIFY `id_estado_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pagos_residencia`
--
ALTER TABLE `pagos_residencia`
  MODIFY `id_pago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `postulaciones_proyecto`
--
ALTER TABLE `postulaciones_proyecto`
  MODIFY `id_postulacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `proyectos_barrio`
--
ALTER TABLE `proyectos_barrio`
  MODIFY `id_proyecto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- AUTO_INCREMENT de la tabla `tipos_proyecto`
--
ALTER TABLE `tipos_proyecto`
  MODIFY `id_tipo_proyecto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipo_reserva`
--
ALTER TABLE `tipo_reserva`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `transacciones_webpay`
--
ALTER TABLE `transacciones_webpay`
  MODIFY `id_transaccion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- Filtros para la tabla `postulaciones_proyecto`
--
ALTER TABLE `postulaciones_proyecto`
  ADD CONSTRAINT `fk_post_estado` FOREIGN KEY (`id_estado_postulacion`) REFERENCES `estados_postulacion` (`id_estado_postulacion`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_post_proyecto` FOREIGN KEY (`id_proyecto`) REFERENCES `proyectos_barrio` (`id_proyecto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_post_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `proyectos_barrio`
--
ALTER TABLE `proyectos_barrio`
  ADD CONSTRAINT `fk_proyecto_estado` FOREIGN KEY (`id_estado_proyecto`) REFERENCES `estados_proyecto` (`id_estado_proyecto`),
  ADD CONSTRAINT `fk_proyecto_tipo` FOREIGN KEY (`id_tipo_proyecto`) REFERENCES `tipos_proyecto` (`id_tipo_proyecto`);

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `fk_reserva_estado` FOREIGN KEY (`id_estado_reserva`) REFERENCES `estado_reserva` (`id_estado_reserva`),
  ADD CONSTRAINT `fk_reserva_tipo` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_reserva` (`id_tipo`),
  ADD CONSTRAINT `fk_reserva_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `solicitud_certificado`
--
ALTER TABLE `solicitud_certificado`
  ADD CONSTRAINT `fk_solicitud_estado` FOREIGN KEY (`id_estado`) REFERENCES `estados_certificado` (`id_estados_certificado`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `transacciones_webpay`
--
ALTER TABLE `transacciones_webpay`
  ADD CONSTRAINT `fk_trans_certificado` FOREIGN KEY (`id_certificado`) REFERENCES `solicitud_certificado` (`id_certificado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_trans_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
