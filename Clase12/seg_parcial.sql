-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-11-2017 a las 06:28:16
-- Versión del servidor: 10.1.28-MariaDB
-- Versión de PHP: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `seg_parcial`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicamento`
--

CREATE TABLE `medicamento` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `laboratorio` varchar(50) NOT NULL,
  `precio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `medicamento`
--

INSERT INTO `medicamento` (`id`, `nombre`, `laboratorio`, `precio`) VALUES
(1, 'aspirina', 'bayer', 10),
(3, 'novalgina', 'cualquiera', 12),
(4, 'berroca', 'bayer', 200),
(6, 'tafirol', 'alguno', 200),
(7, 'benadril', 'bago', 250),
(9, 'hepatalgina MAX', 'otro', 2000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `clave` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `perfil` varchar(50) NOT NULL,
  `fechaAlta` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `mail`, `clave`, `nombre`, `apellido`, `perfil`, `fechaAlta`) VALUES
(1, 'walter@gmail.com', '123admin', 'walter', 'navarrete', 'admin', '2017-11-11 00:00:00'),
(2, 'victor@gmail.com', '123usuario', 'victor', 'nava', 'usuario', '2017-11-12 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `id` int(11) NOT NULL,
  `cliente` varchar(50) NOT NULL,
  `idmedicamento` int(11) NOT NULL,
  `foto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`id`, `cliente`, `idmedicamento`, `foto`) VALUES
(1, 'yo', 1, 'OtroNombre'),
(2, 'yo', 1, 'OtroNombre'),
(3, 'papa', 1, 'OtroNombre'),
(4, 'papa', 1, 'OtroNombre'),
(5, 'cholo', 4, '4_bayer'),
(6, 'julio', 8, '8_roer'),
(7, 'maria', 8, '8_roerArray'),
(8, 'beatriz', 8, '8_roerjpg'),
(9, 'florcita', 9, ''),
(10, 'florzota', 9, '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `medicamento`
--
ALTER TABLE `medicamento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `medicamento`
--
ALTER TABLE `medicamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
