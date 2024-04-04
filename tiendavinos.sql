-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307:3307
-- Tiempo de generación: 04-04-2024 a las 12:15:25
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
-- Estructura de tabla para la tabla `datosenvio`
--

CREATE TABLE `datosenvio` (
  `envio_id` int(11) NOT NULL,
  `fk_usuario` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellidos` varchar(255) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correoenvio` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `datosenvio`
--

INSERT INTO `datosenvio` (`envio_id`, `fk_usuario`, `nombre`, `apellidos`, `direccion`, `telefono`, `correoenvio`) VALUES
(105, 0, 'vladi', 'Gutierrez Gomez', 'Bar Quini, Viso del Alcor', '234324', 'odellaf13@gmail.com');

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
(380, 1, 2),
(382, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `pedido_id` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total` decimal(10,2) DEFAULT NULL,
  `fk_usuario` int(11) NOT NULL,
  `estado` varchar(50) NOT NULL DEFAULT 'en trámite'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`pedido_id`, `fecha`, `total`, `fk_usuario`, `estado`) VALUES
(380, '2024-04-04 10:03:28', 14.50, 0, 'completado/para enviar'),
(382, '2024-04-04 10:10:43', 9.75, 0, 'en trámite');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `producto_id` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `pvp` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `do` varchar(60) NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `url_imagen` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`producto_id`, `nombre`, `pvp`, `stock`, `do`, `descripcion`, `url_imagen`) VALUES
(0, 'Beronia', 9.75, 93, 'Rioja', 'Intenso color cereza picota, limpio y muy brillante. Intensa nariz rica en matices donde destacan notas de frutas rojas y aromas florales perfectamente ensamblados con toques minerales y cacao. Equilibrado, goloso persistente y bien estructurado, destacan la fruta y el regaliz sobre un fondo de chocolate y café.', 'https://www.vinosycavasonline.es/images/products/vino-tinto-beronia-reserva.jpg'),
(1, 'Ébano', 7.25, 90, 'Ribera del Duero', 'Un vino joven con la expresión frutal muy presente. La crianza de 6 meses en roble francés permite que exprese su carácter ribereño junto a un paladar envolvente, untuoso y muy largo.', 'https://www.vinoseleccion.com/media/catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/e/b/ebano-2018.jpg'),
(2, 'Arbocala', 11.25, 0, 'Toro', 'Aromas de fruta roja madura (fresa y cereza), notas florales todavía presentes y aromas propios de su paso por madera (vainilla, café y coco). Tanino sedoso, que hace su paso por boca largo y agradable. La crianza en roble americano y francés le aporta esa golosidad y estructura equilibrada con la fruta.', 'https://de-scorche.com/wp-content/uploads/2022/02/Arbocala-Toro-Crianza-de-Palacio-de-Villachica-1.png'),
(3, 'OchoDosDos', 9.25, 40, 'Ribera del Duero', 'Su color rojo intenso anuncia una experiencia inigualable. En nariz, se despliegan notas de frutos rojos maduros, como la mora y la cereza, acompañados de matices especiados y toques sutiles de roble. En boca, la textura sedosa se combina con taninos elegantes y una acidez equilibrada.', 'https://marianomadrueno.es/wp-content/uploads/2023/11/ocho-dos-dos-vino-tinto.png'),
(4, 'Fuentespina', 8.00, 100, 'Ribera del Duero', 'Es un vino elaborado exclusivamente con uvas de la variedad Tempranillo que proceden de viñedos con más de 50 años de edad. Crianza de 12 meses en barricas de roble francés y americano nuevas. Fuentespina Crianza expresa todo  el potencial que se espera de un Ribera del Duero desde el primer momento lo que le hace ideal tanto para acompañar tapas o carnes y guisos en la mesa.', 'https://marianomadrueno.es/wp-content/uploads/2013/05/fuentespina-crianza-comprar-vino-tinto-ribera-del-duero.png'),
(5, 'Conde de Siruela', 8.75, 100, 'Ribera del Duero', 'Aroma Limpio y franco, intenso, con aromas primarios persistentes a fruta madura y notas de vainilla.\r\nBoca Ligero, carnoso y aterciopelado, importante aportación glicérica, muy equilibrado, el paso en boca es largo, suave y con elegantes tonos de crianza.', 'https://www.bodegasfrutosvillar.com/wp-content/uploads/2010/06/p_condesiruela_crianza1-240x480.png'),
(6, 'Condes de Albarei', 9.00, 3, 'Albariño', 'De color amarillo dorado con reflejos verdosos. En nariz presenta una intensidad media-alta, con aromas florales y matices de frutas blancas. Se trata de un aroma limpio y elegante. En boca, el vino es fresco, amplio, redondo y con una marcada persistencia aromática.', 'https://dydza6t6xitx6.cloudfront.net/ci-condes-de-albarei-albarino-e0f824649bbbe8f0.jpeg'),
(7, 'Marqués de Cáceres', 10.00, 10, 'Rioja', 'Bonita capa con destellos luminosos. Nariz de finas notas de madera tostada y especias, que engarzan con una fruta roja confitada sobre fondo de regaliz. En boca destaca una amplia sensación de volumen, con un fondo de fruta madura y unos taninos suaves y elegantes. Final de cata largo y sedoso. Temperatura de servicio 16 ºC. ', 'https://www.vinoseleccion.com/media/catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/m/a/marques_5.jpg'),
(8, 'Protos Verdejo', 6.75, 95, 'Rueda', 'Bodegas Protos es una de las bodegas más reconocidas del panorama español. Originaria de Ribera del Duero, ha extendido sus tentáculos a la cercana D.O. Rueda. Y, como no podía ser menos, con quince añadas en el mercado sus blancos ya son un referente. Protos Verdejo 2022 está elaborado con viñedos de más de 15 años plantados en secano sobre suelos cascajosos y a una elevada altitud -entre 700 y 800 m- en la que se consiguen uvas con una magnífica acidez. ', 'https://www.vinoseleccion.com/media/wysiwyg/LABUENAUVA-24/protos-verdejo-2023.png'),
(9, 'Atlántida', 27.25, 100, 'Vinos de Cádiz', 'Viñedos en suelos de albarizas de un único viñedo. La uva se vendimia manualmente por la noche para que llegue lo más fresca posible a la bodega donde se encuba en una tina de madera, el 90% de la uva con raspón y 10% despalillado. Se realizan dos bazuqueos diarios y dos remontados. Se macera durante 28 días, se prensa y pasa a barricas de 500 litros de roble francés de 1º y 2º año hace una crianza de 1 año y pasa a barricas de 225 de 3er y 4º uso durante 16 meses más.', 'https://encrypted-tbn1.gstatic.com/shopping?q=tbn:ANd9GcSJFty48be9Fl_uQIGtakXhQCPyHsCwGdhFgRTxtmGwDwf6AM_tXHfoIKGLtBZN4RecivXNaiCqDzo1KyncttJZdsQS0PPS09wS1Q0Gf_YTlP-vGHFrK3Bv-Pw1RHAL0TPuFh7YbcE&usqp=CAc'),
(10, 'Finca Moncloa', 15.15, 100, 'Vinos de Cádiz', 'El Vino Finca Moncloa es un vino tinto andaluz elaborado con las uvas Cabernet Sauvignon 44%, Syrah 36%, Tintilla de Rota 18% y Petit Verdot 2%. La finca tiene un terreno arcilloso, cuyo clima es templado, con lluvias moderadas.\r\nEsta finca está situada en la provincia de Cádiz, en una zona conocida por los ancianos del lugar como “la tierra de las viñas de Arcos”. El viñedo se encuentra en la carretera que une las poblaciones de Arcos de la Frontera con San José del Valle.', 'https://encrypted-tbn1.gstatic.com/shopping?q=tbn:ANd9GcQkhQ1vlifWk49pg_s7-KE5Pynd2DFnUONtE3RYLV3n3n0mzvpQGXgwgZD7NT8oaOT_UUI9PekF1gztI2NJPIS63-HnH3MceRgPD4fzBLiRE1T6R9yaQUmUYSyDVBNogy3OD8Bc89eQuQ&usqp=CAc'),
(11, 'Ederra Crianza', 6.00, 100, 'Rioja', 'Ederra Crianza busca la expresión frutal y la frescura de los vinos, indispensable para los vinos de crianza en roble. En Ederra Crianza está presente la variedad Garnacha, tradicional en los cupajes de la D.O.Ca. Rioja para vinos envejecidos con Tempranillo, aportando a este vino tinto frescor y longitud, y mejorando su capacidad de envejecimiento.', 'https://www.15bodegas.com/media/catalog/product/cache/eb3fb333d6d48f7945011b4bf9583efe/e/d/ederra-crianza-new_individual.jpg'),
(12, 'Cune', 6.95, 100, 'Rioja', 'Crianza de 12 meses en barrica y 6 meses en botella, periodo en el que adquiere el equilibrio aromático que le caracteriza, al igual su finura y expresión global. Color cereza brillante con matices violetas. En nariz aromas de bayas rojas, muestra elegancia en la boca, con algunas notas de especias y una acidez equilibrada.', 'https://encrypted-tbn1.gstatic.com/shopping?q=tbn:ANd9GcRKYGvjjTgSpg5dxHojnzkGTiYh6JZMI39w_0WD9L4kcMWE9m-aCdV3g8Msjdoi4bh0Sdm03ZzT51sYVrE_l-qZSm6Y7uOXSz-Ueq2Zs2iNGYMeZhTxgUUCE5C8cg3gPYEjJcmkDwPqlA&usqp=CAc'),
(13, 'Colección Vinos Blancos', 45.95, 24, 'Colección', 'Un imparable ascenso de la calidad ha situado a nuestros vinos blancos en la primera línea mundial. Vinos consolidados gracias, principalmente, a la personalidad y el potencial de nuestras variedades autóctonas. De entre todas las joyas ‘blancas’ que brillan en el panorama español, hemos seleccionado tres fantásticos monovarietales creados con las uvas más deseadas: albariño, godello y verdejo.', 'https://www.vinoseleccion.com/media/wysiwyg/LABUENAUVA-24/coleccion-blancos-micro.png'),
(14, 'Colección Ribera del Duero', 47.25, 24, 'Colección', 'Ribera del Duero es una historia de éxito brillante y meteórica. Una zona de producción que hoy rivaliza en prestigio con Rioja. Recorremos en esta colección algunas de las bodegas que merece mucho la pena disfrutar, a través, en este caso, de tres estupendos tintos con crianza. Son todos ellos vinos elaborados en exclusiva para nosotros a partir de una cosecha bendecida por la naturaleza, la 2021, calificada como Excelente en esta D.O.', 'https://www.vinoseleccion.com/media/wysiwyg/LABUENAUVA-24/coleccion-ribera-micro.png'),
(15, 'Colección Champagnes', 245.75, 20, 'Colección', 'Seguramente te estarás preguntando: ¿cuáles son las mejores marcas de champagne? ¡Hemos seleccionado para ti 6 de las mejores casas de champagne!:Champagne Mumm - Cordon Rouge Champagne Laurent Perrier - La Cuvée\r\nChampagne Moet & Chandon - Brut Impérial - Estuche\r\nChampagne Perrier Jouët - Grand Brut\r\nChampagne Taittinger - Brut Prestige\r\nChampagne Bollinger - Special Cuvés.', 'https://www.vinatis.es/85442-detail_default/pack-champagnes-de-marca.png'),
(16, 'La Gabriela', 7.25, 100, 'Manzanilla-Sanlúcar de Barrameda', 'Manzanilla Gabriela está elaborado con uvas de la variedad palomino fino 100%, suelos de albariza en Jerez Superior. Fermentación con levaduras autóctonas en el lagar de Viña Las Cañas. Crianza: Sistema de 9 criaderas y una vejez de 6 años. Sacas de 6 a 8 al años.', 'https://www.lavinia.com/media/catalog/product/cache/ad72991f53b91b689717df43818bf2ce/b/a/barrero-manzanilla-gabriela-blanco_1.jpeg'),
(17, 'Macarena', 5.25, 100, 'Manzanilla-Sanlúcar de Barrameda', 'Elegante, fresca y ligera. De color amarillo pálido. Delicada y sutil en nariz.  Muestra su carácter salino en boca.\r\n\r\n', 'https://misumiller.es/7602-medium_default/manzanilla-macarena.jpg'),
(18, 'La Solear', 8.15, 100, 'Manzanilla-Sanlúcar de Barrameda', 'En boca entrada suave y armoniosa pero seca a la vez. Final amargo. Muy persistente.\n\nColor amarillo pálido con bonitos reflejos.\n\nMuy aromático. Aromas a levadura, frutos secos, manzana asada. Notas de sal del mar.\n\nManzanilla (75 cl.). 6 años crianza biológica.', 'https://www.decantalo.com/es/58008-product_img/manzanilla-solear.jpg'),
(19, 'Lote La Solear', 54.25, 0, 'Lotes', 'Lote de Manzanilla La Solear. \r\nEn boca entrada suave y armoniosa pero seca a la vez. Final amargo. Muy persistente.\r\n', 'https://m.media-amazon.com/images/I/51Kw0xgfuOL._AC_UF894,1000_QL80_.jpg'),
(20, 'Laureatus', 12.25, 100, 'Albariño', 'Amarillo oro con reflejos de limón maduro.\r\nDe intensidad media-alta, sobresalen tostados finos mezclados con vainilla, Especies, caramelo y un fondo de frutas maduras (pera-manzana).\r\nEntrada suave, pero con frescura , recuerda notas de frutas confitadas mezcladas con elementos de Lías finas con un carácter especiado, fondo varietal importante, sedoso y persistente. Con un excelente equilibrio.', 'https://galicor.es/wp-content/uploads/2018/09/FOTO_BOTELLA_LAUREATUS.jpg'),
(21, 'Lote Laureatus', 35.00, 25, 'Lotes', 'Lote Laureatus. Amarillo oro con reflejos de limón maduro.\r\nDe intensidad media-alta, sobresalen tostados finos mezclados con vainilla, Especies, caramelo y un fondo de frutas maduras (pera-manzana).\r\nEntrada suave, pero con frescura , recuerda notas de frutas confitadas mezcladas con elementos de Lías finas con un carácter especiado, fondo varietal importante, sedoso y persistente. Con un excelente equilibrio.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ2dLyRbncXbsKfKFF6ZQorrAAH8DRhux6HLYeLvJBYrA&s');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(11) NOT NULL,
  `username` varchar(60) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `rol` varchar(60) NOT NULL DEFAULT 'user',
  `correo` varchar(50) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `username`, `password`, `rol`, `correo`, `estado`) VALUES
(0, 'migue', 'migue', 'user', 'tallerserrano@hotmail.com', 1),
(1, 'Oscar', 'afronea92', 'admin', 'odellaf13@gmail.com', 1),
(2, 'laura', '1234', 'user', 'l.diezromero@gmail.com', 1),
(3, 'lucia', 'lucia', 'user', 'asdsad@gmail.com', 1),
(4, 'sinu', 'sinu', 'user', 'asdsad@gmail.com', 1),
(5, 'vladimir', 'vladimir', 'user', 'abajoyankilandia@gmail.com', 1),
(7, 'vicentesss', 'vicentr', 'user', 'asdad@gmail.com', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `datosenvio`
--
ALTER TABLE `datosenvio`
  ADD PRIMARY KEY (`envio_id`),
  ADD KEY `fk_usuario` (`fk_usuario`);

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
-- AUTO_INCREMENT de la tabla `datosenvio`
--
ALTER TABLE `datosenvio`
  MODIFY `envio_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `pedido_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=383;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `datosenvio`
--
ALTER TABLE `datosenvio`
  ADD CONSTRAINT `datosenvio_ibfk_1` FOREIGN KEY (`fk_usuario`) REFERENCES `usuario` (`usuario_id`);

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
