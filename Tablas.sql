-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-04-2024 a las 14:20:54
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cuentas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_p` int(11) NOT NULL,
  `nombre_p` varchar(30) NOT NULL,
  `precio` float NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_p`, `nombre_p`, `precio`, `stock`) VALUES
(1, 'portail hp', 500.2, 102),
(2, 'disco duro ssd', 89.32, 230),
(3, 'a', 10, 12),
(4, 'b', 13, 13),
(9, 'tv', 12, 1),
(11, 'sd', 122, 13),
(12, 'torre', 34, 13),
(13, 'acer', 344, 23),
(14, 'gato', 2121, 1212),
(16, 'prueba', 2, 2),
(23, 'qwerty', 1.1, 1),
(24, 'rew', 1.45, 122),
(26, 'portatil acer', 500.2, 102);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cargo` enum('administrador','usuario') NOT NULL DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `email`, `cargo`) VALUES
(1, 'test', '$2y$10$SfhYIDtn.iOuCW7zfoFLuuZHX6lja4lF4XA4JqNmpiH/.P3zB8JCa', 'test@test.com', 'usuario'),
(2, 'mimun', '$2y$10$LgJKpbJJGe04idP3rZD9eeyanCNCHkPeY9C98zDc5DQIFFvjGBInS', 'mimun@mimun', 'administrador'),
(3, 'user', '$2y$10$cusyTnivJt18v068vtQapebcz/QmLG8Au6CsleEUroGMkUny1dKUS', 'diwel47667@acname.com', 'usuario'),
(4, 'prueba', '$2y$10$/59u.6ULt.KC/6J9iCeLIuwBzFrV3TT5HSXgY4mP5Tf1aX25LON.m', 'prueba@prueba.es', 'usuario'),
(5, 'prueba2', '$2y$10$AF8z7iEkTTa9MBy3mEueSOrwoA0WzsGUHeAT9mAv6206/Tt2amIjC', 'prueba@prueba2.org', 'usuario');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_p`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_p` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
