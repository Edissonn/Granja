-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-02-2018 a las 04:16:29
-- Versión del servidor: 10.1.9-MariaDB
-- Versión de PHP: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `punto_venta`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `pk_categoria` smallint(6) NOT NULL,
  `nom_categoria` varchar(30) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`pk_categoria`, `nom_categoria`) VALUES
(1, 'Lacteos'),
(2, 'Jardin'),
(3, 'Bar'),
(4, 'Quesos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `pk_cliente` smallint(6) NOT NULL,
  `nombre_cliente` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `edad` int(11) NOT NULL,
  `telefono_cel` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono_casa` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre_local` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `fk_localidad` smallint(6) NOT NULL,
  `calle_ave` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `descripccion` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`pk_cliente`, `nombre_cliente`, `edad`, `telefono_cel`, `telefono_casa`, `nombre_local`, `fk_localidad`, `calle_ave`, `descripccion`, `estado`) VALUES
(1, 'Alfredo', 32, '3232345432', '3232343456', 'Chocobabana', 2, 'Av. Revolucion', 'Entre Mercurio y Tamarindo', 1),
(4, 'Maria Santos Lopez Valle', 59, '3237292729', '3237292729', 'Santos Bar', 4, 'Avenida Acme', 'Marca Acme', 1),
(5, 'Elizabeth Beng Jimenez', 30, '1232635235', '1232635235', 'Santochos Bar', 3, 'xsxasxsajbxa', 'xsjsdckjsdkjbcsd', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `corte_caja`
--

CREATE TABLE `corte_caja` (
  `pk_corcaja` smallint(11) NOT NULL,
  `fecha_corte` date NOT NULL,
  `fecha_venta` date NOT NULL,
  `hora` time NOT NULL,
  `ganancias` float NOT NULL,
  `cant_caja` float DEFAULT NULL,
  `fk_usuario` smallint(11) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `localidad`
--

CREATE TABLE `localidad` (
  `pk_localidad` smallint(6) NOT NULL,
  `nombre` varchar(80) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `localidad`
--

INSERT INTO `localidad` (`pk_localidad`, `nombre`) VALUES
(1, 'San Pancho'),
(2, 'Sayulita'),
(3, 'Lo de Marcos'),
(4, 'Monteon');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `pk_producto` smallint(6) NOT NULL,
  `nombre` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `ruta_img` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `codigo_barras` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `precio` float NOT NULL,
  `fk_categoria` smallint(6) NOT NULL,
  `stok` float NOT NULL,
  `importe` float NOT NULL,
  `precioProveedor` float NOT NULL,
  `fk_unidad` smallint(6) NOT NULL,
  `cant_producto` float NOT NULL,
  `fk_provedor` smallint(6) DEFAULT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`pk_producto`, `nombre`, `ruta_img`, `codigo_barras`, `precio`, `fk_categoria`, `stok`, `importe`, `precioProveedor`, `fk_unidad`, `cant_producto`, `fk_provedor`, `estado`) VALUES
(21, 'KEFIR YOGURT DE BULGAROS', '20171121181128eme.jpg', '7501293191684', 80, 2, 76, 10, 10, 2, 300, 4, 1),
(22, 'SPICY MIX (MIZUNA)', '20171121181122esme (2).jpg', '7501839191684', 50, 2, 83, 20, 40, 2, 300, 5, 1),
(23, 'SPICY MIX (MOSTAZA)', '20171121181131esmeral.jpg', '4005900036643', 50, 2, 96, 0, 40, 2, 300, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_provedor`
--

CREATE TABLE `producto_provedor` (
  `pk_pp` smallint(6) NOT NULL,
  `fk_producto` smallint(6) NOT NULL,
  `fk_provedor` smallint(6) NOT NULL,
  `fecha` date NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `producto_provedor`
--

INSERT INTO `producto_provedor` (`pk_pp`, `fk_producto`, `fk_provedor`, `fecha`, `cantidad`) VALUES
(15, 21, 5, '2017-11-21', 20),
(16, 22, 5, '2017-11-21', 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provedor`
--

CREATE TABLE `provedor` (
  `pk_provedor` smallint(6) NOT NULL,
  `nombre_provedor` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `provedor`
--

INSERT INTO `provedor` (`pk_provedor`, `nombre_provedor`, `estado`) VALUES
(1, 'Guillermo', 1),
(2, 'Tamara', 1),
(3, 'Taller de Bebidas', 1),
(4, 'Taller de Lacteos', 1),
(5, 'Hortalizas', 1),
(6, 'liza', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_medida`
--

CREATE TABLE `unidad_medida` (
  `pk_unidad` smallint(6) NOT NULL,
  `unidad` varchar(10) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `unidad_medida`
--

INSERT INTO `unidad_medida` (`pk_unidad`, `unidad`) VALUES
(1, 'Litros'),
(2, 'Gramos'),
(3, '1/2 Litro'),
(4, 'Kilogramos'),
(5, 'Mililitros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `pk_usuario` smallint(6) NOT NULL,
  `nombre` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `apellidos` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `contrasenia` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `tipo_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`pk_usuario`, `nombre`, `apellidos`, `correo`, `contrasenia`, `tipo_usuario`) VALUES
(5, 'Edson Daniel', 'Luquin Lopez', 'edll_23@hotmail.com', '123', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `pk_venta` smallint(6) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `total` float NOT NULL,
  `estado` int(11) NOT NULL,
  `fk_usuario` smallint(6) NOT NULL,
  `fk_cliente` smallint(6) DEFAULT NULL,
  `cant_pago` float NOT NULL DEFAULT '0',
  `cambio` float NOT NULL DEFAULT '0',
  `factura` int(11) NOT NULL,
  `tipo_pago` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`pk_venta`, `fecha`, `hora`, `total`, `estado`, `fk_usuario`, `fk_cliente`, `cant_pago`, `cambio`, `factura`, `tipo_pago`) VALUES
(27, '2018-02-11', '11:51:29', 70, 1, 5, 1, 80, 10, 0, 1),
(28, '2018-02-11', '11:51:51', 70, 1, 5, 4, 100, 30, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_producto`
--

CREATE TABLE `venta_producto` (
  `pk_vp` smallint(6) NOT NULL,
  `cant_producto` float NOT NULL,
  `cant_importe` float NOT NULL,
  `fk_producto` smallint(6) NOT NULL,
  `fk_venta` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `venta_producto`
--

INSERT INTO `venta_producto` (`pk_vp`, `cant_producto`, `cant_importe`, `fk_producto`, `fk_venta`) VALUES
(98, 1, 20, 22, 27),
(99, 1, 20, 22, 28);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`pk_categoria`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`pk_cliente`),
  ADD KEY `fk_localidad` (`fk_localidad`);

--
-- Indices de la tabla `corte_caja`
--
ALTER TABLE `corte_caja`
  ADD PRIMARY KEY (`pk_corcaja`),
  ADD KEY `fk_usuario` (`fk_usuario`);

--
-- Indices de la tabla `localidad`
--
ALTER TABLE `localidad`
  ADD PRIMARY KEY (`pk_localidad`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`pk_producto`),
  ADD KEY `fk_categoria` (`fk_categoria`),
  ADD KEY `fk_unidad` (`fk_unidad`),
  ADD KEY `fk_provedor` (`fk_provedor`);

--
-- Indices de la tabla `producto_provedor`
--
ALTER TABLE `producto_provedor`
  ADD PRIMARY KEY (`pk_pp`),
  ADD KEY `fk_provedor` (`fk_provedor`),
  ADD KEY `fk_producto` (`fk_producto`);

--
-- Indices de la tabla `provedor`
--
ALTER TABLE `provedor`
  ADD PRIMARY KEY (`pk_provedor`);

--
-- Indices de la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  ADD PRIMARY KEY (`pk_unidad`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`pk_usuario`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`pk_venta`),
  ADD KEY `fk_usuario` (`fk_usuario`),
  ADD KEY `fk_cliente` (`fk_cliente`);

--
-- Indices de la tabla `venta_producto`
--
ALTER TABLE `venta_producto`
  ADD PRIMARY KEY (`pk_vp`),
  ADD KEY `fk_producto` (`fk_producto`),
  ADD KEY `fk_venta` (`fk_venta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `pk_categoria` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `pk_cliente` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `corte_caja`
--
ALTER TABLE `corte_caja`
  MODIFY `pk_corcaja` smallint(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `localidad`
--
ALTER TABLE `localidad`
  MODIFY `pk_localidad` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `pk_producto` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT de la tabla `producto_provedor`
--
ALTER TABLE `producto_provedor`
  MODIFY `pk_pp` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de la tabla `provedor`
--
ALTER TABLE `provedor`
  MODIFY `pk_provedor` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  MODIFY `pk_unidad` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `pk_usuario` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `pk_venta` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT de la tabla `venta_producto`
--
ALTER TABLE `venta_producto`
  MODIFY `pk_vp` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `cliente_ibfk_1` FOREIGN KEY (`fk_localidad`) REFERENCES `localidad` (`pk_localidad`);

--
-- Filtros para la tabla `corte_caja`
--
ALTER TABLE `corte_caja`
  ADD CONSTRAINT `corte_caja_ibfk_1` FOREIGN KEY (`fk_usuario`) REFERENCES `usuario` (`pk_usuario`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`fk_categoria`) REFERENCES `categoria` (`pk_categoria`),
  ADD CONSTRAINT `producto_ibfk_2` FOREIGN KEY (`fk_unidad`) REFERENCES `unidad_medida` (`pk_unidad`),
  ADD CONSTRAINT `producto_ibfk_3` FOREIGN KEY (`fk_provedor`) REFERENCES `provedor` (`pk_provedor`);

--
-- Filtros para la tabla `producto_provedor`
--
ALTER TABLE `producto_provedor`
  ADD CONSTRAINT `producto_provedor_ibfk_2` FOREIGN KEY (`fk_provedor`) REFERENCES `provedor` (`pk_provedor`),
  ADD CONSTRAINT `producto_provedor_ibfk_3` FOREIGN KEY (`fk_producto`) REFERENCES `producto` (`pk_producto`);

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `venta_ibfk_1` FOREIGN KEY (`fk_usuario`) REFERENCES `usuario` (`pk_usuario`),
  ADD CONSTRAINT `venta_ibfk_2` FOREIGN KEY (`fk_cliente`) REFERENCES `cliente` (`pk_cliente`);

--
-- Filtros para la tabla `venta_producto`
--
ALTER TABLE `venta_producto`
  ADD CONSTRAINT `venta_producto_ibfk_1` FOREIGN KEY (`fk_producto`) REFERENCES `producto` (`pk_producto`),
  ADD CONSTRAINT `venta_producto_ibfk_2` FOREIGN KEY (`fk_venta`) REFERENCES `venta` (`pk_venta`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
