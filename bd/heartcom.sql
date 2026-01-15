-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-01-2026 a las 20:20:04
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
(4, 'Cancelado', 'Proyecto cancelado');

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
  MODIFY `id_codigo_mfa` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT de la tabla `estados_proyecto`
--
ALTER TABLE `estados_proyecto`
  MODIFY `id_estado_proyecto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- AUTO_INCREMENT de la tabla `proyectos_barrio`
--
ALTER TABLE `proyectos_barrio`
  MODIFY `id_proyecto` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id_certificado` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;

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
