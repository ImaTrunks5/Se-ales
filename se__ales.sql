-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-01-2025 a las 07:28:00
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `señales`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ongs`
--

CREATE TABLE `ongs` (
  `idOng` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `Estado` varchar(100) DEFAULT NULL,
  `Municipio` varchar(100) DEFAULT NULL,
  `tipo_voluntariado` text DEFAULT NULL,
  `causa_principal` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `idProyecto` int(11) NOT NULL,
  `id_ong` int(11) DEFAULT NULL,
  `nombre_proyecto` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_fin` datetime DEFAULT NULL,
  `Estado` varchar(50) DEFAULT NULL,
  `Municipio` varchar(50) DEFAULT NULL,
  `requisitos` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `IdUsuario` int(11) NOT NULL,
  `Nombre` varchar(30) NOT NULL,
  `ApellidoPat` varchar(30) NOT NULL,
  `ApellidoMat` varchar(30) DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `Contra` varchar(20) NOT NULL,
  `Telefono` varchar(10) NOT NULL,
  `Estado` varchar(50) NOT NULL,
  `Municipio` varchar(50) NOT NULL,
  `habilidades` text NOT NULL,
  `experiencia` text NOT NULL,
  `intereses` text NOT NULL,
  `CURP` varchar(18) DEFAULT NULL,
  `FechaNacimiento` date DEFAULT NULL,
  `Genero` varchar(20) DEFAULT NULL,
  `CodigoPostal` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`IdUsuario`, `Nombre`, `ApellidoPat`, `ApellidoMat`, `Email`, `Contra`, `Telefono`, `Estado`, `Municipio`, `habilidades`, `experiencia`, `intereses`, `CURP`, `FechaNacimiento`, `Genero`, `CodigoPostal`) VALUES
(7, 'imanol', 'Gonzalez', 'Gonzalez', 'ian_imanol@outlook.com', 'Imanol22', '5580187642', 'Estado de México', 'Acambay de Ruiz Castaneda', 'faafa', 'Nada', 'Ayudar', 'GOGI030205HMCNNNA7', '2000-02-05', 'Masculino', 54080);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `voluntarios_proyectos`
--

CREATE TABLE `voluntarios_proyectos` (
  `idVol_Pro` int(11) NOT NULL,
  `id_voluntario` int(11) DEFAULT NULL,
  `id_proyecto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ongs`
--
ALTER TABLE `ongs`
  ADD PRIMARY KEY (`idOng`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`idProyecto`),
  ADD KEY `id_ong` (`id_ong`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`IdUsuario`) USING BTREE;

--
-- Indices de la tabla `voluntarios_proyectos`
--
ALTER TABLE `voluntarios_proyectos`
  ADD PRIMARY KEY (`idVol_Pro`),
  ADD KEY `id_voluntario` (`id_voluntario`),
  ADD KEY `id_proyecto` (`id_proyecto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ongs`
--
ALTER TABLE `ongs`
  MODIFY `idOng` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `idProyecto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `IdUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `voluntarios_proyectos`
--
ALTER TABLE `voluntarios_proyectos`
  MODIFY `idVol_Pro` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD CONSTRAINT `proyectos_ibfk_1` FOREIGN KEY (`id_ong`) REFERENCES `ongs` (`idOng`);

--
-- Filtros para la tabla `voluntarios_proyectos`
--
ALTER TABLE `voluntarios_proyectos`
  ADD CONSTRAINT `voluntarios_proyectos_ibfk_1` FOREIGN KEY (`id_voluntario`) REFERENCES `usuario` (`IdUsuario`),
  ADD CONSTRAINT `voluntarios_proyectos_ibfk_2` FOREIGN KEY (`id_proyecto`) REFERENCES `proyectos` (`idProyecto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
