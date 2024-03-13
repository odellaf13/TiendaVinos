-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307:3307
-- Tiempo de generación: 13-03-2024 a las 09:54:15
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `producto_id` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `pvp` decimal(4,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `do` varchar(60) NOT NULL,
  `descripcion` varchar(350) NOT NULL,
  `url_imagen` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`producto_id`, `nombre`, `pvp`, `stock`, `do`, `descripcion`, `url_imagen`) VALUES
(0, 'Beronia', 10.00, 43, 'Rioja', 'Intenso color cereza picota, limpio y muy brillante. Intensa nariz rica en matices donde destacan notas de frutas rojas y aromas florales perfectamente ensamblados con toques minerales y cacao. Equilibrado, goloso persistente y bien estructurado, destacan la fruta y el regaliz sobre un fondo de chocolate y café.', 'https://www.vinosycavasonline.es/images/products/vino-tinto-beronia-reserva.jpg'),
(1, 'Ébano', 11.00, 32, 'Ribera del Duero', 'Un vino joven con la expresión frutal muy presente. La crianza de 6 meses en roble francés permite que exprese su carácter ribereño junto a un paladar envolvente, untuoso y muy largo.', 'https://www.vinoseleccion.com/media/catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/e/b/ebano-2018.jpg'),
(2, 'Arbocala', 11.25, 0, 'Toro', 'Aromas de fruta roja madura (fresa y cereza), notas florales todavía presentes y aromas propios de su paso por madera (vainilla, café y coco). Tanino sedoso, que hace su paso por boca largo y agradable. La crianza en roble americano y francés le aporta esa golosidad y estructura equilibrada con la fruta.', 'https://de-scorche.com/wp-content/uploads/2022/02/Arbocala-Toro-Crianza-de-Palacio-de-Villachica-1.png'),
(3, 'OchoDosDos', 9.25, 46, 'Ribera del Duero', 'Su color rojo intenso anuncia una experiencia inigualable. En nariz, se despliegan notas de frutos rojos maduros, como la mora y la cereza, acompañados de matices especiados y toques sutiles de roble. En boca, la textura sedosa se combina con taninos elegantes y una acidez equilibrada.', 'https://marianomadrueno.es/wp-content/uploads/2023/11/ocho-dos-dos-vino-tinto.png'),
(4, 'Fuentespina', 8.00, 1, 'Ribera del Duero', 'Crianza de 12 meses en barricas de Roble Francés y Americano nuevas. Color cereza con borde granate. Aroma de fruta confitada y chocolate, tostado, especiado. En boca presenta buena acidez, es sabroso, con taninos maduros y ah', 'https://marianomadrueno.es/wp-content/uploads/2013/05/fuentespina-crianza-comprar-vino-tinto-ribera-del-duero.png'),
(5, 'Conde de Siruela', 8.75, 8, 'Ribera del Duero', 'Aroma Limpio y franco, intenso, con aromas primarios persistentes a fruta madura y notas de vainilla.\r\nBoca Ligero, carnoso y aterciopelado, importante aportación glicérica, muy equilibrado, el paso en boca es largo, suave y con elegantes tonos de crianza.', 'https://www.bodegasfrutosvillar.com/wp-content/uploads/2010/06/p_condesiruela_crianza1-240x480.png'),
(6, 'Condes de Albarei', 9.00, 5, 'Albariño', 'De color amarillo dorado con reflejos verdosos. En nariz presenta una intensidad media-alta, con aromas florales y matices de frutas blancas. Se trata de un aroma limpio y elegante. En boca, el vino es fresco, amplio, redondo y con una marcada persistencia aromática.', 'https://dydza6t6xitx6.cloudfront.net/ci-condes-de-albarei-albarino-e0f824649bbbe8f0.jpeg'),
(7, 'Marqués de Cáceres', 10.00, 10, 'Rioja', 'Bonita capa con destellos luminosos. Nariz de finas notas de madera tostada y especias, que engarzan con una fruta roja confitada sobre fondo de regaliz. En boca destaca una amplia sensación de volumen, con un fondo de fruta madura y unos taninos suaves y elegantes. Final de cata largo y sedoso. Temperatura de servicio 16 ºC. ', 'https://www.vinoseleccion.com/media/catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/m/a/marques_5.jpg'),
(8, 'Protos Verdejo', 7.00, 100, 'Rueda', 'Bodegas Protos es una de las bodegas más reconocidas del panorama español. Originaria de Ribera del Duero, ha extendido sus tentáculos a la cercana D.O. Rueda. Y, como no podía ser menos, con quince añadas en el mercado sus blancos ya son un referente. Protos Verdejo 2022 está elaborado con viñedos de más de 15 años plantados en secano sobre suelos', 'https://www.vinoseleccion.com/media/wysiwyg/LABUENAUVA-24/protos-verdejo-2023.png');

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
(1, 'Oscar', 'afronea92', 'admin'),
(2, 'laura', '1234', 'user'),
(3, 'lucia', 'lucia', 'user'),
(4, 'sinu', 'sinu', 'user'),
(5, 'vladi', 'vladi', 'user');

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
  ADD PRIMARY KEY (`usuario_id`),
  ADD KEY `rol` (`rol`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `pedido_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=249;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `linea_pedido`
--
ALTER TABLE `linea_pedido`
  ADD CONSTRAINT `fk_pedido` FOREIGN KEY (`fk_pedido`) REFERENCES `pedido` (`pedido_id`),
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
