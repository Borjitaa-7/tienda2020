-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-02-2020 a las 00:09:43
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda2020`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `id` int(11) NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `tipo` text COLLATE utf8_spanish_ci NOT NULL,
  `distribuidor` text COLLATE utf8_spanish_ci NOT NULL,
  `precio` text COLLATE utf8_spanish_ci NOT NULL,
  `descuento` text COLLATE utf8_spanish_ci NOT NULL,
  `unidades` text COLLATE utf8_spanish_ci NOT NULL,
  `imagen` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`id`, `nombre`, `tipo`, `distribuidor`, `precio`, `descuento`, `unidades`, `imagen`) VALUES
(11, 'Margarita', 'decoracion', 'Local', '2.99', '50', '82', 'edb553ebb9d106085487e806d5283a63.jpeg'),
(12, 'Jazmin', 'decoracion', 'Local', '2.5', '10', '79', 'ed9a3962597b0010c9977708e4d28a89.png'),
(15, 'Rosa', 'formal', 'Local', '1.99', '20', '12', '3983121dfb9104f54a0c68d881cabb7e.jpeg'),
(16, 'Amapola', 'decoracion', 'Internacional', '9.99', '0', '33', 'bf324c0c9a45074b78a4e33f7acf1128.jpeg'),
(18, 'Aloe Vera', 'alucinante', 'Internacional', '0.99', '5', '442', 'c311beeacddc5f4278923f5bee8ae89d.jpeg'),
(19, 'Pitaya', 'alucinante', 'Internacional', '14.99', '0', '75', 'c3a2ced4239da50612f6b1122afe9ad8.jpeg'),
(20, 'Pasiflora', 'decoracion, alucinante', 'Internacional', '49.99', '50', '100', '8fa40a0613966ffb563813e519c75aca.jpeg'),
(21, 'Orquidea Azul', 'kaotico', 'Internacional', '99.99', '0', '2', 'ea7c29bd22a41a731f3b119f11b4c02e.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineasventas`
--

CREATE TABLE `lineasventas` (
  `idVenta` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `idProducto` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `descuento` int(11) NOT NULL,
  `precio` float NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `dni` text COLLATE utf8_spanish_ci NOT NULL,
  `nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` text COLLATE utf8_spanish_ci NOT NULL,
  `email` text COLLATE utf8_spanish_ci NOT NULL,
  `password` text COLLATE utf8_spanish_ci NOT NULL,
  `admin` text COLLATE utf8_spanish_ci NOT NULL,
  `telefono` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` text COLLATE utf8_spanish_ci NOT NULL,
  `imagen` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `dni`, `nombre`, `apellidos`, `email`, `password`, `admin`, `telefono`, `fecha`, `imagen`) VALUES
(1, '05937585C', 'Jose', 'Funez', 'prueba@prueba.com', 'c893bad68927b457dbed39460e6afd62', 'si', '626909589', '28/01/2020', '1e132dcb5b051cf06d7846ba146864dd.jpeg'),
(2, '05923847Y', 'Borja', 'Cebrian', 'prueba@admin.com', 'e10adc3949ba59abbe56e057f20f883e', 'si', '626395860', '05/02/2020', 'fe1704a487b416a1c5c34e6d2a86fc89.jpeg'),
(3, '05938475C', 'Juan', 'Ortiz', 'juan@juan.com', 'c893bad68927b457dbed39460e6afd62', 'no', '626800495', '05/02/2020', '53d5e02bf7d040ff9f71708ba55c8541.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `idVenta` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `total` float NOT NULL,
  `subtotal` float NOT NULL,
  `iva` float NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` text COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tarjeta` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `titular` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`idVenta`, `fecha`, `total`, `subtotal`, `iva`, `nombre`, `email`, `telefono`, `direccion`, `tarjeta`, `titular`) VALUES
('200223-110218', '2020-02-23 23:02:18', 3.09, 2.55, 0.54, 'Jose Funez', 'prueba@prueba.com', 'Pio 1', '626909589', '1212121212121', 'Jose Funez'),
('200223-110540', '2020-02-23 23:05:40', 3.09, 2.55, 0.54, 'Jose Funez', 'prueba@prueba.com', 'Pio 1', '626909589', '1212121212121', 'Jose Funez'),
('200223-110601', '2020-02-23 23:06:01', 3.09, 2.55, 0.54, 'Jose Funez', 'prueba@prueba.com', 'Pio 1', '626909589', '1212121212121', 'Jose Funez'),
('200223-111923', '2020-02-23 23:19:23', 3.09, 2.55, 0.54, 'Jose Funez', 'prueba@prueba.com', 'Pio 1', '626909589', '1212121212121', 'Jose Funez'),
('200223-113402', '2020-02-23 23:34:02', 3.09, 2.55, 0.54, 'Jose Funez', 'prueba@prueba.com', 'Falsa 4', '626909589', '1212121212121', 'Jose Funez'),
('200223-115812', '2020-02-23 23:58:12', 3.09, 2.55, 0.54, 'Jose Funez', 'prueba@prueba.com', 'Pio 1', '626909589', '1212121212121', 'Jose Funez'),
('200224-120709', '2020-02-24 00:07:09', 3.09, 2.55, 0.54, 'Jose Funez', 'prueba@prueba.com', 'Pio 1', '626909589', '1212121212121', 'Jose Funez');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`idVenta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
