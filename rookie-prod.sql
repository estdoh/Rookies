-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 03-08-2022 a las 19:36:34
-- Versión del servidor: 5.7.31
-- Versión de PHP: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `rookie-prod`
--

--
-- Estructura de tabla para la tabla `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(400) NOT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `category`
--

INSERT INTO `category` (`id_category`, `name`, `description`) VALUES
(1, 'PROMOCIÓN', 'merchandasing y productos de promocion'),
(2, 'PACKAGING', 'desarollo de productos y packaging para envases'),
(3, 'EDITORIAL', 'Libros, revistas y diseño editorial'),
(4, 'BRANDING', 'diseño e imagen de marca, identidad coorporativa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id_client` int(11) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(100) NOT NULL,
  `client_mail` varchar(100) NOT NULL,
  `client_phone` varchar(100) NOT NULL,
  PRIMARY KEY (`id_client`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clients`
--

INSERT INTO `clients` (`id_client`, `client_name`, `client_mail`, `client_phone`) VALUES
(1, 'Star', 'star@star.com.ar', '223 23456234'),
(2, 'yoyo123', 'info@star.com.ar', '963'),
(3, 'User 3', 'hola@star.com.ar', '852');


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` int(150) NOT NULL,
  `name` varchar(400) CHARACTER SET utf8mb4 NOT NULL,
  `description` varchar(450) CHARACTER SET utf8mb4 NOT NULL,  
  `price` int(11) NOT NULL,  
  PRIMARY KEY (`id`)
  
) ENGINE=InnoDB AUTO_INCREMENT=1181 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `products`
--

-- INSERT INTO `products` (`id`, `category`, `name`, `description`, `img`, `price_a`, `price_b`) VALUES
-- (1098, 3, 'ENVASE', 'desarrollo morfologica de estuche troquelado, envase pet, brick, etc. no incluye grafica (ver item anterior)', 'images/61a003b6e914e.png', 45110, 54132),
-- (1099, 4, 'MODELADO 3D DE ENVASE', 'Costo por envase. Forma simple (caja, frasco, etc).', 'images/tv-led.png', 7410, 8892),
-- (1100, 3, 'RENDERIZADO DE MODELO 3D', 'imagen de producto. Precio unitario de cada imágen/vista.', 'images/623a8af72a128.png', 1, 1),
-- (1161, 8, 'ETIQUETA SIMPLE', 'etiqueta simple de poducto', '', 1233, 1233),
-- (1162, 2, 'PRUEBA', 'PRUEBA', 'images/61a003c809e88.png', 123, 123),
-- (1166, 2, 'test123', '123', 'images/61a003d611e78.jpg', 123, 123),
-- (1179, 2, 'Compuesto', 'Prueba', 'images/61a003e143a85.jpg', 3456, 7788),
-- (1180, 8, 'NUEVA', 'Nueva', 'images/61a003ec87dcd.png', 23324, 2444);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` varchar(12) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPRESSED;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `email`, `password`, `rol`) VALUES
(21, 'gaston@dohestudio.com.ar', '$2y$10$VWc8P8xorsOl.dAQ9ImFC.nYX7vERAPd2sRSFq4WXmxgjlJ8rX7jW', 'SUPER-ADMIN'),
(28, 'admin@prueba', '$2y$10$OKRMwNHhN4nJsj/.N6p9guEcsF91AWt0bsUwfQRU6.cNx1FIfDw9O', 'SUPER-ADMIN');

--
-- Restricciones para tablas volcadas
--


--
-- Filtros para la tabla `products`
--
-- ALTER TABLE `products`
--   ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category`) REFERENCES `category` (`id_category`);
-- COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
