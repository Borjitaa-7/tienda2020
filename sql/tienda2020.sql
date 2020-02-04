-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-02-2020 a las 17:42:46
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
(11, 'Carnívoro Especial', 'alucinante, kaotico', 'Local', '99.98', '50%', '15', 'a55a92491d43a5667fd819123d902cb2.jpeg'),
(12, 'Jengibre rojo', 'kaotico', 'Local', '27.99', '5%', '19', '0302a8e3fdf7fd6398c0af835d5cb213.jpeg'),
(15, 'Tibu', 'decoracion', 'Internacional', '1.9', '5%', '12', '4bf38ed990601b6b8dc842b9aebdc9fd.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineasventas`
--

CREATE TABLE `lineasventas` (
  `idVenta` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `idProducto` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `precio` float NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `lineasventas`
--

INSERT INTO `lineasventas` (`idVenta`, `idProducto`, `nombre`, `tipo`, `precio`, `cantidad`) VALUES
('200204-052950', 11, 'Carnívoro Especial', 'alucinante, kaotico', 99.98, 2);

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
(10, '05937585C', 'jose', 'funez', 'prueba@prueba.com', 'c893bad68927b457dbed39460e6afd62', 'si', '626909589', '28/01/2020', '0f0035d49f6a29483d95ed6d9a4e0308.jpeg'),
(13, '12345679A', 'yoda', 'yoda', 'yoda@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'no', '656322124', '04/02/2020', '8cae442688e9bf3dec63e12bfce861a6.jpeg');

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
  `direccion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `nombreTarjeta` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `numTarjeta` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`idVenta`, `fecha`, `total`, `subtotal`, `iva`, `nombre`, `email`, `direccion`, `nombreTarjeta`, `numTarjeta`) VALUES
('200204-052950', '2020-02-04 17:29:50', 126.571, 104.6, 21.97, 'jose', 'prueba@prueba.com', 'aa', 'yoda', '5555555555555555');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
