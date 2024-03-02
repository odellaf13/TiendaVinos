-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307:3307
-- Tiempo de generación: 26-02-2024 a las 11:07:23
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
-- Base de datos: `tiendavinos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `linea_pedido`
--

CREATE TABLE `linea_pedido` (
  `fk_pedido` int(11) NOT NULL,
  `fk_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `linea_pedido`
--

INSERT INTO `linea_pedido` (`fk_pedido`, `fk_producto`, `cantidad`) VALUES
(1, 0, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `pedido_id` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total` decimal(4,2) NOT NULL,
  `fk_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`pedido_id`, `fecha`, `total`, `fk_usuario`) VALUES
(1, '2024-02-24 12:28:05', 0.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `producto_id` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `pvp` decimal(4,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `do` varchar(60) NOT NULL,
  `descripcion` varchar(350) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`producto_id`, `nombre`, `pvp`, `cantidad`, `do`, `descripcion`) VALUES
(0, 'Beronia', 10.00, 9, 'Rioja', 'Intenso color cereza picota, limpio y muy brillante. Intensa nariz rica en matices donde destacan notas de frutas rojas y aromas florales perfectamente ensamblados con toques minerales y cacao. Equilibrado, goloso persistente y bien estructurado, destacan la fruta y el regaliz sobre un fondo de chocolate y café.'),
(1, 'Ébano', 11.00, 2, 'Ribera del Duero', 'Un vino joven con la expresión frutal muy presente. La crianza de 6 meses en roble francés permite que exprese su carácter ribereño junto a un paladar envolvente, untuoso y muy largo.'),
(2, 'Arbocala', 11.25, 1, 'Toro', 'Aromas de fruta roja madura (fresa y cereza), notas florales todavía presentes y aromas propios de su paso por madera (vainilla, café y coco). Tanino sedoso, que hace su paso por boca largo y agradable. La crianza en roble americano y francés le aporta esa golosidad y estructura equilibrada con la fruta.'),
(3, 'OchoDosDos', 9.25, 1, 'Ribera del Duero', 'Su color rojo intenso anuncia una experiencia inigualable. En nariz, se despliegan notas de frutos rojos maduros, como la mora y la cereza, acompañados de matices especiados y toques sutiles de roble. En boca, la textura sedosa se combina con taninos elegantes y una acidez equilibrada.'),
(4, 'Fuentespina', 8.00, 1, 'Ribera del Duero', 'Crianza de 12 meses en barricas de Roble Francés y Americano nuevas. Color cereza con borde granate. Aroma de fruta confitada y chocolate, tostado, especiado. En boca presenta buena acidez, es sabroso, con taninos maduros y ah'),
(5, 'Conde de Siruela', 8.75, 1, 'Ribera del Duero', 'Aroma Limpio y franco, intenso, con aromas primarios persistentes a fruta madura y notas de vainilla.\r\nBoca Ligero, carnoso y aterciopelado, importante aportación glicérica, muy equilibrado, el paso en boca es largo, suave y con elegantes tonos de crianza.'),
(6, 'Condes de Albarei', 9.00, 1, 'Albariño', 'De color amarillo dorado con reflejos verdosos. En nariz presenta una intensidad media-alta, con aromas florales y matices de frutas blancas. Se trata de un aroma limpio y elegante. En boca, el vino es fresco, amplio, redondo y con una marcada persistencia aromática.'),
(7, 'Marqués de Cáceres', 9.00, 12, 'Rioja', 'Color rubí con capa y ribete de intensidad media. Nariz profunda de fruta negra que alterna con un entramado balsámico, de madera fina y delicada, perfectamente integrada.Maticesque jueganunapartiduradehábil armonía. Buquédesuavesnotasdecuerofinoydealgunanotamentoladaquebrinda frescuraalacata.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `rol` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `username`, `password`, `rol`) VALUES
(1, 'oscar', 'oscar', 'user'),
(2, 'vladi', 'vladi', 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `linea_pedido`
--
ALTER TABLE `linea_pedido`
  ADD PRIMARY KEY (`fk_pedido`,`fk_producto`),
  ADD KEY `fk_producto` (`fk_producto`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`pedido_id`),
  ADD KEY `fk_usuario` (`fk_usuario`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`producto_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `linea_pedido`
--
ALTER TABLE `linea_pedido`
  ADD CONSTRAINT `linea_pedido_ibfk_1` FOREIGN KEY (`fk_pedido`) REFERENCES `pedido` (`pedido_id`),
  ADD CONSTRAINT `linea_pedido_ibfk_2` FOREIGN KEY (`fk_producto`) REFERENCES `producto` (`producto_id`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`fk_usuario`) REFERENCES `usuario` (`usuario_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
