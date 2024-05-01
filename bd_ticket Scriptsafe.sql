-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-04-2024 a las 16:48:30
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS bd_ticket;
USE bd_ticket;
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_ticket`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `petición`
--

CREATE TABLE IF NOT EXISTS `petición` (
  `ID` int(8) NOT NULL,
  `ID_User` int(8) NOT NULL,
  `ID_Sala` int(8) NOT NULL,
  `Titulo_Peticion` text NOT NULL,
  `Descripcion` varchar(400) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `petición`
--

INSERT INTO `petición` (`ID`, `ID_User`, `ID_Sala`, `Titulo_Peticion`, `Descripcion`) VALUES
(46, 8, 33, 'No se hacer el prooyecto', 's');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sala`
--

CREATE TABLE IF NOT EXISTS `sala` (
  `ID` int(20) NOT NULL,
  `ID_USER_PROFESOR` int(20) NOT NULL,
  `Titulo_Clase` varchar(200) NOT NULL,
  `ID_Peticion` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sala`
--

INSERT INTO `sala` (`ID`, `ID_USER_PROFESOR`, `Titulo_Clase`, `ID_Peticion`) VALUES
(8, 4, 'prueba', NULL),
(27, 12, 'Clase de php', NULL),
(28, 8, 'Salas', NULL),
(29, 8, 'MATEMATICAMENTE BIEN', NULL),
(33, 8, 'asombroso', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `token`
--

CREATE TABLE IF NOT EXISTS `token` (
  `TOKEN` varchar(55) NOT NULL,
  `CREATED_DATE` varchar(15) NOT NULL,
  `EXPIRED_DATE` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `token`
--

INSERT INTO `token` (`TOKEN`, `CREATED_DATE`, `EXPIRED_DATE`) VALUES
('6fUIKkLUJv', '13/03/2024', '14/03/2024'),
('6Q5sdnElWg', '24/04/2024', '25/04/2024'),
('b6Ofb68wWX', '24/04/2024', '25/04/2024'),
('BA9BUXtjNF', '24/04/2024', '25/04/2024'),
('be6TkLJG0n', '27/04/2024', '28/04/2024'),
('bfZvdi5Y71', '24/04/2024', '25/04/2024'),
('bnQojopW7K', '28/04/2024', '29/04/2024'),
('BtZJqmAxzT', '27/04/2024', '28/04/2024'),
('eekgtcfkjH', '24/04/2024', '25/04/2024'),
('FgC591ZzqW', '13/03/2024', '14/03/2024'),
('fHpBQkaZZb', '27/04/2024', '28/04/2024'),
('FtmPqWNXgf', '27/04/2024', '28/04/2024'),
('kEK54P9NLE', '24/04/2024', '25/04/2024'),
('MNEdvKH4d2', '29/04/2024', '30/04/2024'),
('OaBAIPNCxp', '29/04/2024', '30/04/2024'),
('pLIRmN5Kc2', '27/04/2024', '28/04/2024'),
('Qd4Qz3DbgW', '24/04/2024', '25/04/2024'),
('REeZxFNmdj', '28/04/2024', '29/04/2024'),
('SAm5X3DGPx', '24/04/2024', '25/04/2024'),
('twlNNknC5V', '29/04/2024', '30/04/2024'),
('uaymJf2t3u', '24/04/2024', '25/04/2024'),
('uJZH8kGOyw', '27/04/2024', '28/04/2024'),
('us4HO2D24K', '28/04/2024', '29/04/2024'),
('vlm9zLZoWL', '24/04/2024', '25/04/2024');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(3) NOT NULL,
  `TOKEN` varchar(55) NOT NULL,
  `NOMBRE` varchar(75) NOT NULL,
  `SITIOCLASE` varchar(25) DEFAULT NULL,
  `PASSWORD` varchar(30) NOT NULL,
  `TIPO` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`ID`, `TOKEN`, `NOMBRE`, `SITIOCLASE`, `PASSWORD`, `TIPO`) VALUES
(4, 'BtZJqmAxzT', 'Anak', 'A34', '12345', 'Profe'),
(6, '6Q5sdnElWg', 'ANAK', '21', '$2y$10$.xN.JPFeQs2SuIBePlHxaOi', 'PROFESOR'),
(7, 'bfZvdi5Y71', 'ANAK', '21', '$2y$10$fX0LM7VnBUNXPy4Za9rCf.Q', 'PROFESOR'),
(8, 'twlNNknC5V', 'PAVLO', '2A', '$2y$10$X9jYQWy7TAmLBGQWz.V8D.4', 'profesor'),
(9, 'OaBAIPNCxp', 'anak', '1a', '$2y$10$Y5pWdVjs71PMcN0UOKUH4.2', 'alumno'),
(10, 'fHpBQkaZZb', 'Profe', '1a', '1234', 'profesor'),
(11, 'us4HO2D24K', 'alumno', '1a', '1234', 'alumno'),
(12, 'MNEdvKH4d2', 'ANAK', '21', '1234', 'profesor');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `petición`
--
ALTER TABLE `petición`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_Sala` (`ID_Sala`),
  ADD KEY `ID_User` (`ID_User`);

--
-- Indices de la tabla `sala`
--
ALTER TABLE `sala`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_USER_PROFESOR` (`ID_USER_PROFESOR`,`ID_Peticion`);

--
-- Indices de la tabla `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`TOKEN`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `TOKEN` (`TOKEN`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `petición`
--
ALTER TABLE `petición`
  MODIFY `ID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `sala`
--
ALTER TABLE `sala`
  MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `petición`
--
ALTER TABLE `petición`
  ADD CONSTRAINT `petición_ibfk_1` FOREIGN KEY (`ID_Sala`) REFERENCES `sala` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `petición_ibfk_2` FOREIGN KEY (`ID_User`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `sala`
--
ALTER TABLE `sala`
  ADD CONSTRAINT `sala_ibfk_2` FOREIGN KEY (`ID_USER_PROFESOR`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`TOKEN`) REFERENCES `token` (`TOKEN`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
