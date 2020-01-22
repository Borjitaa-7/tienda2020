-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-01-2020 a las 10:16:47
-- Versión del servidor: 10.4.6-MariaDB
-- Versión de PHP: 7.3.9

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
(6, 'Manzanilla', 'decoracion', 'Internacional', '10.99', '5%', '1', 'cd5bf0f92e3e4f52a0412048a8c28807.jpeg'),
(7, 'Pasiflora', 'decoracion', 'Internacional', '12.99', '10%', '4', 'c035b51efd8b264a1becfd642df0455c.jpeg'),
(8, 'Marihuana', 'alucinante', 'Internacional', '5.99', '5%', '5', '3895b28a504a69c00fa1d907bf944498.jpeg'),
(9, 'Clavel', 'decoracion', 'Local', '8.99', '20%', '50', '417d446e5807e6ede17fbe25a1e60437.jpeg'),
(10, 'Peyote', 'kaotico', 'Internacional', '25.99', '5%', '37', '7048fb04697ebf021e8f6c3a1a71fcbb.jpeg'),
(11, 'CarnÃ­vora Especial', 'kaotico', 'Internacional', '99.99', '5%', '15', 'a55a92491d43a5667fd819123d902cb2.jpeg'),
(12, 'Jengibre rojo', 'kaotico', 'Local', '27.99', '5%', '19', '49bebacdbe1b87391b99e0d39dedf03a.jpeg'),
(13, 'Margarita', 'decoracion, formal', 'Internacional', '12.99', '10%', '55', '8843446bc41cb9b38024c0c757085e2a.jpeg');

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
(7, '05984136Z', 'Darth Vader', 'Sith', 'vader@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'si', '656323255', '22/01/2020', '517ed6e29e31c6f42384ef7efb970ca6.jpeg'),
(8, '05984136S', 'Spiderman', 'TelaraÃ±a', 'aracnido@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'si', '656323289', '22/01/2020', '52bd57efaa221820b308940e9c24e9a4.jpeg');

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
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
