-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-12-2023 a las 04:08:27
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `liga_futbol`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizarPartidosGanados` ()   BEGIN
    -- Elimina registros existentes en p_ganados
    DELETE FROM p_ganados;

    -- Inserta nuevos datos en p_ganados
    INSERT INTO p_ganados (equipo_id, cantidad)
    SELECT equipo_id, COUNT(*) AS partidos_ganados
    FROM (
        SELECT equipo_local_id AS equipo_id FROM partidos WHERE goles_local > goles_visitante
        UNION ALL
        SELECT equipo_visitante_id AS equipo_id FROM partidos WHERE goles_visitante > goles_local
    ) partidos_ganados
    GROUP BY equipo_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizarPartidosPerdidos` ()   BEGIN
    -- Elimina registros existentes en p_perdidos
    DELETE FROM p_perdidos;

    -- Inserta nuevos datos en p_perdidos
    INSERT INTO p_perdidos (equipo_id, cantidad)
    SELECT equipo_id, COUNT(*) AS partidos_perdidos
    FROM (
        SELECT equipo_local_id AS equipo_id FROM partidos WHERE goles_local < goles_visitante
        UNION ALL
        SELECT equipo_visitante_id AS equipo_id FROM partidos WHERE goles_visitante < goles_local
    ) partidos_perdidos
    GROUP BY equipo_id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enfrentamientos`
--

CREATE TABLE `enfrentamientos` (
  `id_enfrentamiento` int(11) NOT NULL,
  `id_partido` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `equipo_local` varchar(255) DEFAULT NULL,
  `equipo_visitante` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `enfrentamientos`
--

INSERT INTO `enfrentamientos` (`id_enfrentamiento`, `id_partido`, `fecha`, `equipo_local`, `equipo_visitante`) VALUES
(1409, 2397, '2023-12-12', '26', '27'),
(1410, 2398, '2023-12-13', '27', '35'),
(1411, 2399, '2023-12-14', '28', '32'),
(1412, 2400, '2023-12-15', '29', '28'),
(1413, 2401, '2023-12-16', '30', '28'),
(1414, 2402, '2023-12-17', '31', '32'),
(1415, 2403, '2023-12-18', '32', '35'),
(1416, 2404, '2023-12-19', '33', '35'),
(1417, 2405, '2023-12-20', '34', '27'),
(1418, 2406, '2023-12-21', '35', '31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id_equipo` int(11) NOT NULL,
  `nombre_equipo` varchar(50) NOT NULL,
  `entrenador_id` int(11) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id_equipo`, `nombre_equipo`, `entrenador_id`, `logo`) VALUES
(26, 'Barcelona', 32, '../uploads/logo_65755c8dd52fc7.95805232.png'),
(27, 'Real Madrid', 33, '../uploads/logo_65755eb2967750.76735670.png'),
(28, 'Athletic Club', 34, '../uploads/logo_65755ed1141e05.45595525.jpg'),
(29, 'Atletico de Madrid', 35, '../uploads/logo_65755f273d8328.67224844.png'),
(30, 'Real Sociedad', 36, '../uploads/logo_65755f79166051.71871848.png'),
(31, 'Real Betis', 37, '../uploads/logo_65755fb54de4f0.29010678.png'),
(32, 'RC Celta', 38, '../uploads/logo_657560d06f8bb5.35378176.png'),
(33, 'RCD Mallorca', 39, '../uploads/logo_6575610a42c8f5.07903135.png'),
(34, 'CA Osasuna', 40, '../uploads/logo_6575614579c962.08691411.png'),
(35, 'Cadiz CF', 41, '../uploads/logo_65756186ac4140.05303732.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugadores`
--

CREATE TABLE `jugadores` (
  `id_jugador` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `contrasena_jugador` varchar(168) DEFAULT NULL,
  `posicion` varchar(50) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `rol_jugador` varchar(7) DEFAULT 'Jugador',
  `correo_jugador` varchar(168) NOT NULL,
  `equipo_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `jugadores`
--

INSERT INTO `jugadores` (`id_jugador`, `nombre`, `contrasena_jugador`, `posicion`, `edad`, `rol_jugador`, `correo_jugador`, `equipo_id`) VALUES
(43, 'Thuram', '123456', 'ED', 26, 'Jugador', 'thuram@gmail.com', 27),
(44, 'Eder', '123456', 'DEL', 26, 'Jugador', 'thuram@gmail.com', NULL),
(45, 'sasa', '123456', 'EI', 24, 'Jugador', 'sasa@gmail.com', 32),
(46, 'Son ', '123456', 'EI', 23, 'Jugador', 'son@gmail.com', 29),
(47, 'Chiesa', '123456', 'DFC', 28, 'Jugador', 'chiesa@gmail.com', 29),
(48, 'Henderson', '123456', 'DFC', 24, 'Jugador', 'henderson@gmail.com', 28),
(49, 'Antuna', '123456', 'DI', 22, 'Jugador', 'antuna@gmail.com', NULL),
(50, 'Sebastian', '123456', 'DEL', 22, 'Jugador', 'sebastian@gmail.com', NULL),
(51, 'Raul', '123456', 'DI', 22, 'Jugador', 'raul@gmail.com', NULL),
(52, 'Jorge', '123456', 'ED', 26, 'Jugador', 'jorge@gmail.com', NULL),
(53, 'Alvarado', '123456', 'ED', 26, 'Jugador', 'alvarado@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidos`
--

CREATE TABLE `partidos` (
  `id_partido` int(11) NOT NULL,
  `equipo_local_id` int(11) DEFAULT NULL,
  `equipo_visitante_id` int(11) DEFAULT NULL,
  `goles_local` int(11) DEFAULT NULL,
  `goles_visitante` int(11) DEFAULT NULL,
  `confirmado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `partidos`
--

INSERT INTO `partidos` (`id_partido`, `equipo_local_id`, `equipo_visitante_id`, `goles_local`, `goles_visitante`, `confirmado`) VALUES
(2397, 26, 27, 4, 2, 1),
(2398, 27, 35, 5, 5, 1),
(2399, 28, 32, 5, 5, 1),
(2400, 29, 28, 4, 3, 1),
(2401, 30, 28, 4, 3, 1),
(2402, 31, 32, 3, 2, 1),
(2403, 32, 35, 6, 4, 1),
(2404, 33, 35, 4, 2, 1),
(2405, 34, 27, 4, 2, 1),
(2406, 35, 31, 3, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `p_empatados`
--

CREATE TABLE `p_empatados` (
  `equipo_id` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `p_empatados`
--

INSERT INTO `p_empatados` (`equipo_id`, `cantidad`) VALUES
(26, 0),
(27, 1),
(28, 1),
(29, 0),
(30, 0),
(31, 0),
(32, 1),
(33, 0),
(34, 0),
(35, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `p_ganados`
--

CREATE TABLE `p_ganados` (
  `equipo_id` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `p_ganados`
--

INSERT INTO `p_ganados` (`equipo_id`, `cantidad`) VALUES
(26, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `p_jugados`
--

CREATE TABLE `p_jugados` (
  `equipo_id` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `p_jugados`
--

INSERT INTO `p_jugados` (`equipo_id`, `cantidad`) VALUES
(26, 1),
(27, 3),
(28, 3),
(29, 1),
(30, 1),
(31, 2),
(32, 3),
(33, 1),
(34, 1),
(35, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `p_perdidos`
--

CREATE TABLE `p_perdidos` (
  `equipo_id` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `p_perdidos`
--

INSERT INTO `p_perdidos` (`equipo_id`, `cantidad`) VALUES
(27, 2),
(28, 2),
(31, 1),
(32, 1),
(35, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_porcentual`
--

CREATE TABLE `tabla_porcentual` (
  `id` int(11) NOT NULL,
  `equipo_id` int(11) DEFAULT NULL,
  `puesto` int(11) DEFAULT NULL,
  `nombre_club` varchar(255) DEFAULT NULL,
  `p_jugados` int(11) DEFAULT NULL,
  `p_ganados` int(11) DEFAULT NULL,
  `p_empatados` int(11) DEFAULT NULL,
  `p_perdidos` int(11) DEFAULT NULL,
  `puntos_generales` int(11) DEFAULT NULL,
  `diferencia_goles` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tabla_porcentual`
--

INSERT INTO `tabla_porcentual` (`id`, `equipo_id`, `puesto`, `nombre_club`, `p_jugados`, `p_ganados`, `p_empatados`, `p_perdidos`, `puntos_generales`, `diferencia_goles`) VALUES
(1, 32, 1, 'RC Celta', 3, 1, 1, 1, 4, 0),
(2, 35, 2, 'Cadiz CF', 4, 1, 1, 2, 4, -1),
(3, 29, 3, 'Atletico de Madrid', 1, 1, 0, 0, 3, 1),
(4, 30, 4, 'Real Sociedad', 1, 1, 0, 0, 3, 1),
(5, 33, 5, 'RCD Mallorca', 1, 1, 0, 0, 3, 1),
(6, 34, 6, 'CA Osasuna', 1, 1, 0, 0, 3, 1),
(7, 26, 7, 'Barcelona', 1, 1, 0, 0, 3, 1),
(8, 31, 8, 'Real Betis', 2, 1, 0, 1, 3, 0),
(9, 27, 9, 'Real Madrid', 3, 0, 1, 2, 1, -2),
(10, 28, 10, 'Athletic Club', 3, 0, 1, 2, 1, -2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `contrasena` varchar(50) NOT NULL,
  `correo` varchar(120) NOT NULL,
  `rol` varchar(10) NOT NULL DEFAULT 'Entrenador'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `contrasena`, `correo`, `rol`) VALUES
(32, 'Joseph Askary Bautista Jimenez ', '123456', 'askarybautista@gmail.com', 'Entrenador'),
(33, 'Eleazar', '123456', 'eleazar@gmail.com', 'Entrenador'),
(34, 'Xavi', '123456', 'xavi@gmail.com', 'Entrenador'),
(35, 'Joan', '123456', 'joan@gmail.com', 'Entrenador'),
(36, 'Bryan', '123456', 'bryan@gmail.com', 'Entrenador'),
(37, 'Sebastian', '123456', 'sebastian@gmail.com', 'Entrenador'),
(38, 'Alfredo', '123456', 'alfredo@gmail.com', 'Entrenador'),
(39, 'Gustavo', '123456', 'gustavo@gmail.com', 'Entrenador'),
(40, 'Joel', '123456', 'joel@gmail.com', 'Entrenador'),
(41, 'Julion', '123456', 'julion@gmail.com', 'Entrenador'),
(42, 'Eleazar', 'eweww', 'eleazar@gmail.com', 'Entrenador'),
(43, 'Bryan', '123456', 'bryan@gmail.com', 'Entrenador'),
(44, 'Ricardo', '123456', 'ricardo@gmail.com', 'Entrenador'),
(45, 'Jorge', '123456', 'jorge@gmail.com', 'Entrenador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `enfrentamientos`
--
ALTER TABLE `enfrentamientos`
  ADD PRIMARY KEY (`id_enfrentamiento`),
  ADD KEY `id_partido` (`id_partido`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id_equipo`),
  ADD KEY `entrenador_id` (`entrenador_id`);

--
-- Indices de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  ADD PRIMARY KEY (`id_jugador`),
  ADD KEY `equipo_id` (`equipo_id`);

--
-- Indices de la tabla `partidos`
--
ALTER TABLE `partidos`
  ADD PRIMARY KEY (`id_partido`),
  ADD KEY `equipo_local_id` (`equipo_local_id`),
  ADD KEY `equipo_visitante_id` (`equipo_visitante_id`);

--
-- Indices de la tabla `p_empatados`
--
ALTER TABLE `p_empatados`
  ADD PRIMARY KEY (`equipo_id`);

--
-- Indices de la tabla `p_ganados`
--
ALTER TABLE `p_ganados`
  ADD PRIMARY KEY (`equipo_id`);

--
-- Indices de la tabla `p_jugados`
--
ALTER TABLE `p_jugados`
  ADD PRIMARY KEY (`equipo_id`);

--
-- Indices de la tabla `p_perdidos`
--
ALTER TABLE `p_perdidos`
  ADD PRIMARY KEY (`equipo_id`);

--
-- Indices de la tabla `tabla_porcentual`
--
ALTER TABLE `tabla_porcentual`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `equipo_id` (`equipo_id`),
  ADD KEY `puntos_generales` (`puntos_generales`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `enfrentamientos`
--
ALTER TABLE `enfrentamientos`
  MODIFY `id_enfrentamiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1419;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  MODIFY `id_jugador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `partidos`
--
ALTER TABLE `partidos`
  MODIFY `id_partido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2407;

--
-- AUTO_INCREMENT de la tabla `tabla_porcentual`
--
ALTER TABLE `tabla_porcentual`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `enfrentamientos`
--
ALTER TABLE `enfrentamientos`
  ADD CONSTRAINT `enfrentamientos_ibfk_1` FOREIGN KEY (`id_partido`) REFERENCES `partidos` (`id_partido`);

--
-- Filtros para la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD CONSTRAINT `equipos_ibfk_1` FOREIGN KEY (`entrenador_id`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `jugadores`
--
ALTER TABLE `jugadores`
  ADD CONSTRAINT `jugadores_ibfk_1` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id_equipo`);

--
-- Filtros para la tabla `partidos`
--
ALTER TABLE `partidos`
  ADD CONSTRAINT `partidos_ibfk_1` FOREIGN KEY (`equipo_local_id`) REFERENCES `equipos` (`id_equipo`),
  ADD CONSTRAINT `partidos_ibfk_2` FOREIGN KEY (`equipo_visitante_id`) REFERENCES `equipos` (`id_equipo`);

--
-- Filtros para la tabla `p_empatados`
--
ALTER TABLE `p_empatados`
  ADD CONSTRAINT `p_empatados_ibfk_1` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id_equipo`);

--
-- Filtros para la tabla `p_ganados`
--
ALTER TABLE `p_ganados`
  ADD CONSTRAINT `p_ganados_ibfk_1` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id_equipo`);

--
-- Filtros para la tabla `p_jugados`
--
ALTER TABLE `p_jugados`
  ADD CONSTRAINT `p_jugados_ibfk_1` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id_equipo`);

--
-- Filtros para la tabla `p_perdidos`
--
ALTER TABLE `p_perdidos`
  ADD CONSTRAINT `p_perdidos_ibfk_1` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id_equipo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
