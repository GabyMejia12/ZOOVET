-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-10-2024 a las 02:03:23
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
-- Base de datos: `zoovet`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

CREATE TABLE `cita` (
  `id_cita` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `id_veterinario` int(11) NOT NULL,
  `id_mascota` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas`
--

CREATE TABLE `consultas` (
  `id_consulta` int(11) NOT NULL,
  `RX` varchar(255) NOT NULL,
  `fecha_consulta` datetime NOT NULL,
  `id_tipoconsulta` int(11) NOT NULL,
  `id_veterinario` int(11) NOT NULL,
  `id_mascota` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_entrada`
--

CREATE TABLE `detalle_entrada` (
  `id_detentrada` int(11) NOT NULL,
  `cantidad_detentrada` int(11) NOT NULL,
  `cantidad_medida` float NOT NULL,
  `total` float NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_entrada` int(11) NOT NULL,
  `precio_compra` float NOT NULL,
  `vencimiento` date NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_entrada`
--

INSERT INTO `detalle_entrada` (`id_detentrada`, `cantidad_detentrada`, `cantidad_medida`, `total`, `id_producto`, `id_entrada`, `precio_compra`, `vencimiento`, `estado`) VALUES
(9, 1, 20, 20, 3, 1, 12.95, '2024-12-31', 1),
(10, 2, 10, 20, 3, 1, 15.99, '2025-12-31', 1),
(11, 1, 15, 15, 1, 1, 12.99, '2024-10-31', 1),
(14, 1, 10, 10, 1, 4, 2.59, '2024-10-17', 1),
(16, 2, 10, 20, 1, 5, 5.99, '2024-10-31', 1),
(17, 1, 30, 30, 2, 5, 7.95, '2026-12-20', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_salida`
--

CREATE TABLE `detalle_salida` (
  `id_detsalida` int(11) NOT NULL,
  `cantidad_detsalida` int(11) NOT NULL,
  `precio_salida` float NOT NULL,
  `id_salida` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_salida`
--

INSERT INTO `detalle_salida` (`id_detsalida`, `cantidad_detsalida`, `precio_salida`, `id_salida`, `id_producto`, `estado`) VALUES
(4, 5, 7.99, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada`
--

CREATE TABLE `entrada` (
  `id_entrada` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `hora` time NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `entrada`
--

INSERT INTO `entrada` (`id_entrada`, `fecha`, `hora`, `id_usuario`, `estado`) VALUES
(1, '2024-10-15 00:00:00', '23:26:00', 1, 1),
(2, '2024-10-16 00:00:00', '21:09:00', 8, 0),
(3, '2024-10-17 00:00:00', '23:21:00', 1, 1),
(4, '2024-10-17 00:00:00', '23:24:00', 1, 1),
(5, '2024-10-19 00:00:00', '00:41:00', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mascota`
--

CREATE TABLE `mascota` (
  `id_mascota` int(11) NOT NULL,
  `codigo_mascota` varchar(20) NOT NULL,
  `nombre_mascota` varchar(20) NOT NULL,
  `peso` float NOT NULL,
  `edad` varchar(20) NOT NULL,
  `especie` varchar(20) NOT NULL,
  `raza` varchar(50) NOT NULL,
  `sexo` varchar(20) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `id_propietario` int(11) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mascota`
--

INSERT INTO `mascota` (`id_mascota`, `codigo_mascota`, `nombre_mascota`, `peso`, `edad`, `especie`, `raza`, `sexo`, `descripcion`, `id_propietario`, `estado`) VALUES
(1, 'P299423', 'Zeus', 7, '2 años', 'canino', 'Bulldog', 'macho', 'El bulldog, ​ también conocido como bulldog inglés, es una raza de perro originaria de Inglaterra\"', 1, 1),
(5, '', '', 2.1, '1 año', 'Felino', 'Angora', 'Hembra', 'GATO OJOS VERDES COLOR NEGRO', 2, 1),
(6, 'R0001', 'Gomita', 2.1, '6 meses', 'Canino', 'Husky', 'Hembra', 'JSHDCFEID', 2, 0),
(7, 'IF3983', 'iguano', 13, '10 años', 'felino', 'gato arrabalero', 'macho', 'gato de callle', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `codigo_producto` varchar(20) NOT NULL,
  `nombre_producto` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `medida` varchar(50) NOT NULL,
  `stock` float NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `codigo_producto`, `nombre_producto`, `descripcion`, `medida`, `stock`, `estado`) VALUES
(1, 'AL0012', 'Antibiotico tos', 'Antibiotico para la tos, gatos 100 ml', 'ML', 40, 1),
(2, 'PL002', 'Prueba', 'blablabla', 'pastillas', 30, 1),
(3, 'PL003', 'ANKOFEN', 'Analgesico', 'ml', 40, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propietario`
--

CREATE TABLE `propietario` (
  `id_propietario` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `telefono` varchar(12) NOT NULL,
  `direccion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `propietario`
--

INSERT INTO `propietario` (`id_propietario`, `nombre`, `apellido`, `telefono`, `direccion`) VALUES
(1, 'Fernando José', 'Barahona', '', 'SAN SALVADOR, SAN SALVADOR'),
(2, 'Diana María', 'Mendoza', '34343434', 'SAN SALVADOR, SOYAPANGO'),
(3, 'Pedro', 'Angeles', '66666666', 'SAN SALVADOR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salida`
--

CREATE TABLE `salida` (
  `id_salida` int(11) NOT NULL,
  `fecha_salida` datetime NOT NULL,
  `id_tiposalida` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `id_consulta` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `salida`
--

INSERT INTO `salida` (`id_salida`, `fecha_salida`, `id_tiposalida`, `id_usuario`, `estado`, `id_consulta`) VALUES
(1, '2024-10-20 10:36:10', 2, 1, 1, NULL),
(2, '2024-10-20 12:43:28', 2, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_consulta`
--

CREATE TABLE `tipo_consulta` (
  `id_tipoconsulta` int(11) NOT NULL,
  `nombre_consulta` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_consulta`
--

INSERT INTO `tipo_consulta` (`id_tipoconsulta`, `nombre_consulta`) VALUES
(1, 'General'),
(2, 'Profilactico'),
(3, 'Cirugia'),
(4, 'Ayuda social');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_salida`
--

CREATE TABLE `tipo_salida` (
  `id_tiposalida` int(11) NOT NULL,
  `nombre_salida` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_salida`
--

INSERT INTO `tipo_salida` (`id_tiposalida`, `nombre_salida`) VALUES
(1, 'consulta'),
(2, 'venta'),
(3, 'campaña'),
(4, 'ayuda social');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `usuario` varchar(15) NOT NULL,
  `password` varchar(100) NOT NULL,
  `estado` int(11) NOT NULL,
  `tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `usuario`, `password`, `estado`, `tipo`) VALUES
(1, 'Juan', 'Lein', 'j12lein', '$2y$10$wNtNpJ4rPgVK1DOg/D7pu./FJom1iucdM.ZKlT4m19TRAL7Fs.kx6', 1, 1),
(2, 'Reina', 'Mejia', 'RMEJI', '$2y$10$.N/4weMEJ5bW6PyKTqz/zewRlHxTseLRBQ7j.BD8df1aSIxoGIrc6', 1, 1),
(4, 'Lili', '', 'LM05', '', 1, 1),
(5, 'Lourdes', 'LEIVA', 'LOULEIVA', '$2y$10$4xLD1qaT4a2.sC2b4ebKjOoD1RZvQ9C8QQ0HADzfrXVw6yP.YxcgC', 1, 1),
(6, 'Maria', 'VALLE', 'MVALLE', '$2y$10$YuavgiYehqeifQlhP80T6OI7S9fXU47TRlnMQFQlZmr3TT7/pTzna', 1, 2),
(8, 'Esther', 'Alegría', 'esther.a5237', '$2y$10$wNtNpJ4rPgVK1DOg/D7pu./FJom1iucdM.ZKlT4m19TRAL7Fs.kx6', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `veterinario`
--

CREATE TABLE `veterinario` (
  `id_veterinario` int(11) NOT NULL,
  `codigo_veterinario` varchar(20) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellido` varchar(30) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `veterinario`
--

INSERT INTO `veterinario` (`id_veterinario`, `codigo_veterinario`, `nombre`, `apellido`, `id_usuario`) VALUES
(6, 'COD01258', 'Esther', 'Alegría', 8),
(7, 'COD12453', 'Reina', 'Mejia', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`id_cita`);

--
-- Indices de la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id_consulta`);

--
-- Indices de la tabla `detalle_entrada`
--
ALTER TABLE `detalle_entrada`
  ADD PRIMARY KEY (`id_detentrada`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_entrada` (`id_entrada`);

--
-- Indices de la tabla `detalle_salida`
--
ALTER TABLE `detalle_salida`
  ADD PRIMARY KEY (`id_detsalida`);

--
-- Indices de la tabla `entrada`
--
ALTER TABLE `entrada`
  ADD PRIMARY KEY (`id_entrada`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `mascota`
--
ALTER TABLE `mascota`
  ADD PRIMARY KEY (`id_mascota`),
  ADD KEY `id_propietario` (`id_propietario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `propietario`
--
ALTER TABLE `propietario`
  ADD PRIMARY KEY (`id_propietario`);

--
-- Indices de la tabla `salida`
--
ALTER TABLE `salida`
  ADD PRIMARY KEY (`id_salida`),
  ADD KEY `id_tiposalida` (`id_tiposalida`),
  ADD KEY `id_consulta` (`id_consulta`);

--
-- Indices de la tabla `tipo_consulta`
--
ALTER TABLE `tipo_consulta`
  ADD PRIMARY KEY (`id_tipoconsulta`);

--
-- Indices de la tabla `tipo_salida`
--
ALTER TABLE `tipo_salida`
  ADD PRIMARY KEY (`id_tiposalida`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `veterinario`
--
ALTER TABLE `veterinario`
  ADD PRIMARY KEY (`id_veterinario`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id_consulta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_entrada`
--
ALTER TABLE `detalle_entrada`
  MODIFY `id_detentrada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `detalle_salida`
--
ALTER TABLE `detalle_salida`
  MODIFY `id_detsalida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `entrada`
--
ALTER TABLE `entrada`
  MODIFY `id_entrada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `mascota`
--
ALTER TABLE `mascota`
  MODIFY `id_mascota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `propietario`
--
ALTER TABLE `propietario`
  MODIFY `id_propietario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `salida`
--
ALTER TABLE `salida`
  MODIFY `id_salida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_consulta`
--
ALTER TABLE `tipo_consulta`
  MODIFY `id_tipoconsulta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_salida`
--
ALTER TABLE `tipo_salida`
  MODIFY `id_tiposalida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `veterinario`
--
ALTER TABLE `veterinario`
  MODIFY `id_veterinario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_entrada`
--
ALTER TABLE `detalle_entrada`
  ADD CONSTRAINT `detalle_entrada_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `detalle_entrada_ibfk_2` FOREIGN KEY (`id_entrada`) REFERENCES `entrada` (`id_entrada`);

--
-- Filtros para la tabla `entrada`
--
ALTER TABLE `entrada`
  ADD CONSTRAINT `entrada_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `mascota`
--
ALTER TABLE `mascota`
  ADD CONSTRAINT `mascota_ibfk_1` FOREIGN KEY (`id_propietario`) REFERENCES `propietario` (`id_propietario`);

--
-- Filtros para la tabla `salida`
--
ALTER TABLE `salida`
  ADD CONSTRAINT `salida_ibfk_1` FOREIGN KEY (`id_tiposalida`) REFERENCES `tipo_salida` (`id_tiposalida`),
  ADD CONSTRAINT `salida_ibfk_2` FOREIGN KEY (`id_consulta`) REFERENCES `consultas` (`id_consulta`);

--
-- Filtros para la tabla `veterinario`
--
ALTER TABLE `veterinario`
  ADD CONSTRAINT `veterinario_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
