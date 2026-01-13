-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-01-2026 a las 23:40:04
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
(16, 8, '320537', 'LOGIN', '2026-01-10 05:42:47', 1, '2026-01-10 01:32:47'),
(17, 8, '845257', 'LOGIN', '2026-01-10 18:55:04', 1, '2026-01-10 14:45:04'),
(18, 17, '637449', 'LOGIN', '2026-01-11 02:39:49', 1, '2026-01-10 22:29:49'),
(19, 8, '560531', 'LOGIN', '2026-01-12 22:42:15', 1, '2026-01-12 18:32:15'),
(20, 8, '119511', 'LOGIN', '2026-01-12 22:54:41', 1, '2026-01-12 18:44:41'),
(21, 18, '445065', 'LOGIN', '2026-01-12 23:32:20', 0, '2026-01-12 19:22:20'),
(22, 18, '576142', 'LOGIN', '2026-01-12 23:33:10', 0, '2026-01-12 19:23:10'),
(23, 18, '204524', 'LOGIN', '2026-01-12 23:33:13', 0, '2026-01-12 19:23:13'),
(24, 18, '244370', 'LOGIN', '2026-01-12 23:34:23', 1, '2026-01-12 19:24:23'),
(25, 18, '740635', 'LOGIN', '2026-01-12 23:35:17', 0, '2026-01-12 19:25:17'),
(26, 8, '437325', 'LOGIN', '2026-01-13 18:42:28', 0, '2026-01-13 14:32:28'),
(27, 8, '362818', 'LOGIN', '2026-01-13 18:43:37', 0, '2026-01-13 14:33:37'),
(28, 8, '193855', 'LOGIN', '2026-01-13 18:43:55', 0, '2026-01-13 14:33:55'),
(29, 8, '263663', 'LOGIN', '2026-01-13 18:44:41', 1, '2026-01-13 14:34:41'),
(30, 18, '654063', 'LOGIN', '2026-01-13 18:47:45', 1, '2026-01-13 14:37:45'),
(31, 18, '377503', 'LOGIN', '2026-01-13 22:19:55', 1, '2026-01-13 18:09:55'),
(32, 17, '744256', 'LOGIN', '2026-01-13 22:35:37', 1, '2026-01-13 18:25:37'),
(33, 8, '139406', 'LOGIN', '2026-01-13 22:58:49', 1, '2026-01-13 18:48:49'),
(34, 21, '183551', 'LOGIN', '2026-01-13 23:47:14', 1, '2026-01-13 19:37:14');

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

--
-- Volcado de datos para la tabla `pagos_residencia`
--

INSERT INTO `pagos_residencia` (`id_pago`, `id_certificado`, `id_estado`, `monto`, `fecha_pago`) VALUES
(1, 5, 1, 2000, '2026-01-10 16:42:50'),
(2, 4, 1, 2000, '2026-01-10 16:52:40'),
(3, 6, 1, 2000, '2026-01-10 22:31:42'),
(4, 9, 1, 2000, '2026-01-13 14:40:23');

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
(1, 1, 1, '2026-01-06', '2026-01-10', 'adsdasd', 'sadasdasdasd', 8),
(2, 1, 1, '2026-01-06', '2026-01-10', 'adsdasd', 'sadasdasdasd', 8),
(3, 1, 3, '2026-01-14', '2026-01-15', 'actividad vecinal', 'actividad para----- ', 17);

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
(4, 1, 8, 3, 'Cambio de casa ', 'dsdasdasdas', '2026-01-10 01:55:07'),
(5, 1, 8, 3, 'Cambio de casa ', 'asdasdasdasdasdasdasdasdasdsadas', '2026-01-10 02:25:28'),
(6, 1, 17, 3, 'Cambio de casa ', 'por droga', '2026-01-10 22:30:33'),
(7, 1, 8, 1, 'Cambio de casa ', 'adasdasdasdasdasdasd', '2026-01-12 19:14:54'),
(8, 2, 8, 1, 'Cambio de casa ', 'adasdasdasdasdasdasdasdasdasdas', '2026-01-12 19:18:49'),
(9, 1, 18, 3, 'Cambio de casa ', 'sadasdasdas', '2026-01-12 19:30:12');

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

--
-- Volcado de datos para la tabla `transacciones_webpay`
--

INSERT INTO `transacciones_webpay` (`id_transaccion`, `id_certificado`, `id_usuario`, `monto`, `token_ws`, `orden_compra`, `session_id`, `codigo_autorizacion`, `medio_pago`, `numero_cuotas`, `tipo_cuotas`, `estado_transaccion`, `fecha_transaccion`, `fecha_actualizacion`, `last4_tarjeta`, `respuesta_json`) VALUES
(1, 5, 8, 2000, '01abb2527fa51bb5e5acdf43f239b1dd4cea197bcbc572e50a36b6dfae8678e4', 'CERT-5-1768070890', 'USR-8-88von07126cctkvh9gg8c9i3aq', NULL, NULL, NULL, NULL, 'INICIADA', '2026-01-10 15:48:10', NULL, NULL, NULL),
(2, 5, 8, 2000, '01ab8d001b23742c1ddc7efd55e65e4e11eb02c88dbaa31a731bc6f503828597', 'CERT-5-1768074071', 'USR-8-88von07126cctkvh9gg8c9i3aq', '1213', 'VN', 0, NULL, 'AUTORIZADA', '2026-01-10 16:41:12', '2026-01-10 16:42:05', '6623', '{\"vci\":\"TSY\",\"amount\":2000,\"status\":\"AUTHORIZED\",\"buy_order\":\"CERT-5-1768074071\",\"session_id\":\"USR-8-88von07126cctkvh9gg8c9i3aq\",\"card_detail\":{\"card_number\":\"6623\"},\"accounting_date\":\"0110\",\"transaction_date\":\"2026-01-10T19:41:12.033Z\",\"authorization_code\":\"1213\",\"payment_type_code\":\"VN\",\"response_code\":0,\"installments_number\":0}'),
(3, 4, 8, 2000, '01abd6013cd2c6d40312fa71249595193b16ee5412a4d405b78d6454d445b481', 'CERT-4-1768074709', 'USR-8-88von07126cctkvh9gg8c9i3aq', '1213', 'VN', 0, NULL, 'AUTORIZADA', '2026-01-10 16:51:50', '2026-01-10 16:52:40', '6623', '{\"vci\":\"TSY\",\"amount\":2000,\"status\":\"AUTHORIZED\",\"buy_order\":\"CERT-4-1768074709\",\"session_id\":\"USR-8-88von07126cctkvh9gg8c9i3aq\",\"card_detail\":{\"card_number\":\"6623\"},\"accounting_date\":\"0110\",\"transaction_date\":\"2026-01-10T19:51:49.759Z\",\"authorization_code\":\"1213\",\"payment_type_code\":\"VN\",\"response_code\":0,\"installments_number\":0}'),
(4, 6, 17, 2000, '01abab0cb7e1a116d996dfbd2a1a23a134a17f8f1d223a72e8cc9474a0dd862a', 'CERT-6-1768095058', 'USR-17-tipgf2jgrcm1gnqjtfdt3rfnad', '1617', 'VN', 0, NULL, 'AUTORIZADA', '2026-01-10 22:30:58', '2026-01-10 22:31:41', '2032', '{\"vci\":\"TSY\",\"amount\":2000,\"status\":\"AUTHORIZED\",\"buy_order\":\"CERT-6-1768095058\",\"session_id\":\"USR-17-tipgf2jgrcm1gnqjtfdt3rfnad\",\"card_detail\":{\"card_number\":\"2032\"},\"accounting_date\":\"0110\",\"transaction_date\":\"2026-01-11T01:30:58.603Z\",\"authorization_code\":\"1617\",\"payment_type_code\":\"VN\",\"response_code\":0,\"installments_number\":0}'),
(5, 9, 18, 2000, '01ab2a64432501e3d560af8740b45bce0001d274b82242b351f48032519ee4b8', 'CERT-9-1768325947', 'USR-18-p03ngka6amajvn4nrkb7od3026', NULL, NULL, NULL, NULL, 'INICIADA', '2026-01-13 14:39:07', NULL, NULL, NULL),
(6, 9, 18, 2000, '01ab26529fcd8992e86c33c10724ee6a51ad27efbfeb760f81fe2ad1f9b3abee', 'CERT-9-1768325954', 'USR-18-p03ngka6amajvn4nrkb7od3026', '1213', 'VN', 0, NULL, 'AUTORIZADA', '2026-01-13 14:39:14', '2026-01-13 14:40:23', '6623', '{\"vci\":\"TSY\",\"amount\":2000,\"status\":\"AUTHORIZED\",\"buy_order\":\"CERT-9-1768325954\",\"session_id\":\"USR-18-p03ngka6amajvn4nrkb7od3026\",\"card_detail\":{\"card_number\":\"6623\"},\"accounting_date\":\"0113\",\"transaction_date\":\"2026-01-13T17:39:14.641Z\",\"authorization_code\":\"1213\",\"payment_type_code\":\"VN\",\"response_code\":0,\"installments_number\":0}');

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
(8, 'Javier ', 'Jannet', 'Smith', 'vera', '1991-12-13', '18.608.676-2', '6789020', 'con.leiva@duocuc.cl', 1, NULL, NULL, 'pajaritos', '$2y$10$fgTF.SEFfhNzR.NVEbyvp.GPO622GKVORUqCR4M0NN6VgmBgHl4y.', 1),
(14, 'Fabian', 'mateo', 'Villablanca', 'Smit', '2015-01-22', '18.608.677-4', '922203145', 'fabianirribarra667@gmail.com', 0, 'f86a3aa3a27f21c9f3029c49b424677a2b77ca39395fb2a5f0b3892e0c9eec27', '2025-12-25 00:29:22', 'lo blanco 0824', '1234', 3),
(17, 'Juancho', 'Peres', 'Villacasa', 'Torres3', '1999-01-08', '22.302.080-5', '5678954', 'gerina.leiva@gmail.com', 1, NULL, NULL, 'los sapos casiques', '12345', 3),
(18, 'Pedro', 'Peres', 'Villacasa', 'Torres', '1999-01-08', '20.608.676-7', '5678954', 'cleivavera94@gmail.com', 1, NULL, NULL, 'los sapos casiques', '1234', 3),
(21, 'Pedro', 'Se vendio en la calle', 'no tengo papa', 'se fue por cigarro', '2002-01-08', '11.111.111-1', '9873628', 'starlix234.leiva@gmail.com', 1, NULL, NULL, 'los sapos casiques 2', '$2y$10$k1yKAevP7ubKNlWltUo3a.NtYiM6cCgOXV6TlHQJvLWfJeudZz0Cu', 3);

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
  MODIFY `id_codigo_mfa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

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
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `solicitud_certificado`
--
ALTER TABLE `solicitud_certificado`
  MODIFY `id_certificado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tipos_certificados`
--
ALTER TABLE `tipos_certificados`
  MODIFY `id_certi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipo_reserva`
--
ALTER TABLE `tipo_reserva`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `transacciones_webpay`
--
ALTER TABLE `transacciones_webpay`
  MODIFY `id_transaccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

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
