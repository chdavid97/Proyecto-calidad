-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-11-2019 a las 14:07:02
-- Versión del servidor: 10.4.8-MariaDB
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `login`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `claves`
--

CREATE TABLE `claves` (
  `rand_uno` int(1) NOT NULL,
  `rand_dos` int(1) NOT NULL,
  `rand_tres` int(1) NOT NULL,
  `user` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `claves`
--

INSERT INTO `claves` (`rand_uno`, `rand_dos`, `rand_tres`, `user`) VALUES
(6, 4, 5, 'chdavid1997@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `id` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id`, `tipo`) VALUES
(1, 'Administrador'),
(2, 'Usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `password` varchar(130) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `FechaNac` date NOT NULL,
  `correo` varchar(80) NOT NULL,
  `last_session` datetime DEFAULT NULL,
  `activacion` int(11) NOT NULL DEFAULT 0,
  `token` varchar(40) NOT NULL,
  `token_password` varchar(100) DEFAULT NULL,
  `password_request` int(11) DEFAULT 0,
  `id_tipo` int(11) NOT NULL,
  `celular` int(10) NOT NULL,
  `ciudad` varchar(40) NOT NULL,
  `genero` varchar(30) NOT NULL,
  `estado` varchar(30) NOT NULL,
  `cedula` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `password`, `nombre`, `apellido`, `FechaNac`, `correo`, `last_session`, `activacion`, `token`, `token_password`, `password_request`, `id_tipo`, `celular`, `ciudad`, `genero`, `estado`, `cedula`) VALUES
(4, 'jessy', '$2y$10$7IOPTOuzBOEepGP0/BIjWuSjrFfN/nw4lLA56eNfLrGKmkYr/WFaW', 'Jessica', 'Mera', '1987-06-13', 'yssej@yahoo.com', NULL, 0, '7e0312979a45f6c0e5945388c15c72e7', NULL, 0, 2, 0, '', '', '', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
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
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
