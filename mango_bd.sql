-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-01-2019 a las 09:50:02
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `mango_bd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `categoria_id` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_mod` datetime NOT NULL,
  `fecha_baja` datetime NOT NULL,
  `usuario_alta` int(11) NOT NULL,
  `usuario_mod` int(11) NOT NULL,
  `usuario_baja` int(11) NOT NULL,
  `estado` text NOT NULL,
  `categoria` text NOT NULL,
  `tipo` text NOT NULL,
  `adicion` text NOT NULL,
  `imagen` text NOT NULL,
  `imagen_nombre` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`categoria_id`, `fecha_alta`, `fecha_mod`, `fecha_baja`, `usuario_alta`, `usuario_mod`, `usuario_baja`, `estado`, `categoria`, `tipo`, `adicion`, `imagen`, `imagen_nombre`) VALUES
(1, '2018-09-27 21:40:21', '2018-11-06 11:15:33', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'bebidas', 'productos', 'si', 'no', '20180927214021'),
(2, '2018-09-27 21:40:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'fuertes', 'productos', 'no', 'no', '20180927214038'),
(3, '2018-09-27 21:40:42', '0000-00-00 00:00:00', '2018-10-29 18:30:36', 1, 0, 1, 'eliminado', 'postres', 'productos', 'no', 'no', '20180927214042');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente_pago`
--

CREATE TABLE `cliente_pago` (
  `cliente_pago_id` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_mod` datetime NOT NULL,
  `fecha_baja` datetime NOT NULL,
  `usuario_alta` int(11) NOT NULL,
  `usuario_mod` int(11) NOT NULL,
  `usuario_baja` int(11) NOT NULL,
  `estado` text NOT NULL,
  `cliente_correo` text NOT NULL,
  `cliente_nombre` text NOT NULL,
  `pago_referencia` text NOT NULL,
  `pago_metodo` text NOT NULL,
  `pago_resultado` text NOT NULL,
  `pago_cantidad` text NOT NULL,
  `pago_valor_unitario` text NOT NULL,
  `pago_valor_total` text NOT NULL,
  `cuenta_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `compra_id` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_mod` datetime NOT NULL,
  `fecha_baja` datetime NOT NULL,
  `usuario_alta` int(11) NOT NULL,
  `usuario_mod` int(11) NOT NULL,
  `usuario_baja` int(11) NOT NULL,
  `estado` text NOT NULL,
  `observacion_envio` text NOT NULL,
  `observacion_recepcion` text NOT NULL,
  `destino` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`compra_id`, `fecha_alta`, `fecha_mod`, `fecha_baja`, `usuario_alta`, `usuario_mod`, `usuario_baja`, `estado`, `observacion_envio`, `observacion_recepcion`, `destino`) VALUES
(1, '2018-11-19 14:05:26', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'enviado', '', '', 1),
(2, '2018-11-27 20:32:19', '0000-00-00 00:00:00', '2018-11-27 20:33:53', 1, 0, 1, 'eliminado', '', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_ingrediente`
--

CREATE TABLE `compra_ingrediente` (
  `compra_ingrediente_id` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_mod` datetime NOT NULL,
  `fecha_baja` datetime NOT NULL,
  `usuario_alta` int(11) NOT NULL,
  `usuario_mod` int(11) NOT NULL,
  `usuario_baja` int(11) NOT NULL,
  `estado` text NOT NULL,
  `cantidad_enviada` text NOT NULL,
  `cantidad_recibida` text NOT NULL,
  `cantidad_devuelta` text NOT NULL,
  `compra_id` int(11) NOT NULL,
  `ingrediente_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `compra_ingrediente`
--

INSERT INTO `compra_ingrediente` (`compra_ingrediente_id`, `fecha_alta`, `fecha_mod`, `fecha_baja`, `usuario_alta`, `usuario_mod`, `usuario_baja`, `estado`, `cantidad_enviada`, `cantidad_recibida`, `cantidad_devuelta`, `compra_id`, `ingrediente_id`) VALUES
(7, '2018-11-19 15:41:46', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'enviado', '40', '0', '0', 1, 26),
(8, '2018-11-19 15:42:31', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'enviado', '50', '0', '0', 1, 28),
(6, '2018-11-19 15:41:24', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'enviado', '20', '0', '0', 1, 27),
(9, '2018-11-27 20:32:33', '0000-00-00 00:00:00', '2018-11-27 20:33:53', 1, 0, 1, 'eliminado', '20', '0', '0', 2, 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descuento`
--

CREATE TABLE `descuento` (
  `descuento_id` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_mod` datetime NOT NULL,
  `fecha_baja` datetime NOT NULL,
  `usuario_alta` int(11) NOT NULL,
  `usuario_mod` int(11) NOT NULL,
  `usuario_baja` int(11) NOT NULL,
  `estado` text NOT NULL,
  `descuento` text NOT NULL,
  `porcentaje` text NOT NULL,
  `aplica` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `descuento`
--

INSERT INTO `descuento` (`descuento_id`, `fecha_alta`, `fecha_mod`, `fecha_baja`, `usuario_alta`, `usuario_mod`, `usuario_baja`, `estado`, `descuento`, `porcentaje`, `aplica`) VALUES
(1, '2018-09-06 13:29:14', '0000-00-00 00:00:00', '2018-10-29 18:22:54', 1, 0, 1, 'eliminado', 'cortesia', '100', 'ventas'),
(2, '2018-09-06 13:29:27', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'socios y amigos', '10', 'ventas'),
(3, '2018-09-17 23:03:44', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'amigos', '70', 'ventas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impuesto`
--

CREATE TABLE `impuesto` (
  `impuesto_id` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_mod` datetime NOT NULL,
  `fecha_baja` datetime NOT NULL,
  `usuario_alta` int(11) NOT NULL,
  `usuario_mod` int(11) NOT NULL,
  `usuario_baja` int(11) NOT NULL,
  `estado` text NOT NULL,
  `impuesto` text NOT NULL,
  `porcentaje` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `impuesto`
--

INSERT INTO `impuesto` (`impuesto_id`, `fecha_alta`, `fecha_mod`, `fecha_baja`, `usuario_alta`, `usuario_mod`, `usuario_baja`, `estado`, `impuesto`, `porcentaje`) VALUES
(1, '2018-09-27 20:41:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'IVA', '19'),
(2, '2018-10-29 18:21:08', '0000-00-00 00:00:00', '2018-10-29 18:21:17', 1, 0, 1, 'eliminado', 'ICA', '5'),
(3, '2018-10-30 19:29:32', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'ipo', '8'),
(4, '2018-10-30 19:29:47', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'sin impuesto', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingrediente`
--

CREATE TABLE `ingrediente` (
  `ingrediente_id` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_mod` datetime NOT NULL,
  `fecha_baja` datetime NOT NULL,
  `usuario_alta` int(11) NOT NULL,
  `usuario_mod` int(11) NOT NULL,
  `usuario_baja` int(11) NOT NULL,
  `estado` text NOT NULL,
  `ingrediente` text NOT NULL,
  `tipo` text NOT NULL,
  `unidad_minima` text NOT NULL,
  `unidad_compra` text NOT NULL,
  `costo_unidad_minima` text NOT NULL,
  `costo_unidad_compra` text NOT NULL,
  `cantidad_unidad_compra` text NOT NULL,
  `proveedor_id` int(11) NOT NULL,
  `productor_id` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ingrediente`
--

INSERT INTO `ingrediente` (`ingrediente_id`, `fecha_alta`, `fecha_mod`, `fecha_baja`, `usuario_alta`, `usuario_mod`, `usuario_baja`, `estado`, `ingrediente`, `tipo`, `unidad_minima`, `unidad_compra`, `costo_unidad_minima`, `costo_unidad_compra`, `cantidad_unidad_compra`, `proveedor_id`, `productor_id`) VALUES
(1, '2018-10-08 17:27:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'coca cola 350ml', 'comprado', 'unid', 'unid', '1000', '1000', '0', 1, '0'),
(2, '2018-10-08 17:31:10', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'seven up 350ml', 'comprado', 'unid', 'unid', '1000', '1000', '0', 1, '0'),
(3, '2018-10-29 18:25:24', '2018-11-13 15:22:24', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'salsa de la casa', 'producido', 'g', 'kg', '0', '0', '2', 0, '2'),
(4, '2018-10-29 18:25:40', '0000-00-00 00:00:00', '2018-10-29 18:27:53', 1, 0, 1, 'eliminado', 'cobertura especial', 'producido', 'g', 'g', '0', '0', '500', 0, '1'),
(5, '2018-10-29 18:29:22', '0000-00-00 00:00:00', '2018-10-29 18:29:30', 1, 0, 1, 'eliminado', 'tomate', 'comprado', 'g', 'kg', '1', '1000', '0', 1, '0'),
(6, '2018-10-29 19:29:41', '2018-10-29 21:22:43', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'tomate chonto', 'comprado', 'g', 'kg', '0.5', '500', '0', 1, '0'),
(7, '2018-10-29 19:29:49', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'lechuga', 'comprado', 'g', 'kg', '0.5', '500', '0', 1, '0'),
(8, '2018-10-29 19:29:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'queso', 'comprado', 'g', 'kg', '2', '2000', '0', 1, '0'),
(9, '2018-10-29 20:05:17', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'aceite de oliva', 'comprado', 'ml', 'l', '5', '5000', '0', 1, '0'),
(10, '2018-10-29 23:48:48', '2018-12-03 18:28:34', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'cobertura blanca', 'producido', 'g', 'kg', '0', '0', '2', 0, '0'),
(11, '2018-10-30 19:41:10', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'harina de trigo', 'comprado', 'g', 'kg', '3', '3000', '0', 1, '0'),
(12, '2018-10-30 19:41:31', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'sal', 'comprado', 'g', 'kg', '1', '1000', '0', 1, '0'),
(13, '2018-10-30 19:41:57', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'levadura', 'comprado', 'g', 'kg', '5', '5000', '0', 1, '0'),
(14, '2018-10-30 19:42:25', '2018-10-31 18:16:07', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'agua de la canilla', 'comprado', 'ml', 'l', '0', '0', '0', 1, '0'),
(15, '2018-10-30 19:42:48', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'ajonjoli', 'comprado', 'g', 'kg', '8', '8000', '0', 1, '0'),
(16, '2018-10-30 19:43:10', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'mijo', 'comprado', 'g', 'kg', '8', '8000', '0', 1, '0'),
(17, '2018-10-30 19:43:26', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'nueces', 'comprado', 'g', 'kg', '20', '20000', '0', 1, '0'),
(18, '2018-10-30 19:43:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'chia', 'comprado', 'g', 'kg', '20', '20000', '0', 1, '0'),
(19, '2018-10-30 19:55:28', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'cocacola', 'comprado', 'unid', 'unid', '1300', '1300', '0', 1, '0'),
(20, '2018-10-31 16:50:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'cerveza', 'comprado', 'unid', 'unid', '1500', '1500', '0', 1, '0'),
(21, '2018-10-31 17:22:05', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'pan integral', 'comprado', 'unid', 'unid', '0', '0', '0', 1, '0'),
(22, '2018-10-31 19:02:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'agua manantial ', 'comprado', 'ml', 'botella 375 ml', '3.2', '1200', '0', 1, '0'),
(23, '2018-10-31 19:02:33', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'agua manantial gas', 'comprado', 'ml', 'botella 375 ml', '3.2', '1200', '0', 1, '0'),
(24, '2018-10-31 20:18:15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'cobertura de vainilla', 'producido', 'ml', 'l', '0', '0', '1', 0, '2'),
(25, '2018-10-31 20:29:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'club colombia', 'comprado', 'unid', 'unid', '1500', '1500', '0', 1, '0'),
(26, '2018-11-05 20:56:41', '2018-11-05 21:05:51', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'ron', 'comprado', 'ml', 'botella 750 ml', '26.666666666667', '20000', '0', 3, '0'),
(27, '2018-11-05 20:56:59', '2018-11-05 21:05:38', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'Ginebra', 'comprado', 'ml', 'botella 1500 ml', '20', '30000', '0', 3, '0'),
(28, '2018-11-05 20:57:33', '2018-11-05 21:06:02', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'whiskey', 'comprado', 'ml', 'botella 750 ml', '80', '60000', '0', 3, '0'),
(29, '2018-11-14 14:31:02', '2018-11-14 14:34:14', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'salsa secreta', 'producido', 'ml', 'l', '0', '0', '1', 0, '2'),
(30, '2018-11-14 14:40:06', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'pimienta', 'comprado', 'g', 'kg', '2', '2000', '0', 1, '0'),
(31, '2018-12-27 13:58:12', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'azucar', 'comprado', 'g', 'bulto 50 kg', '1.8', '90000', '0', 1, '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingrediente_producido_composicion`
--

CREATE TABLE `ingrediente_producido_composicion` (
  `ingrediente_producido_composicion_id` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_mod` datetime NOT NULL,
  `fecha_baja` datetime NOT NULL,
  `usuario_alta` int(11) NOT NULL,
  `usuario_mod` int(11) NOT NULL,
  `usuario_baja` int(11) NOT NULL,
  `estado` text NOT NULL,
  `cantidad` text NOT NULL,
  `ingrediente_producido_id` int(11) NOT NULL,
  `ingrediente_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ingrediente_producido_composicion`
--

INSERT INTO `ingrediente_producido_composicion` (`ingrediente_producido_composicion_id`, `fecha_alta`, `fecha_mod`, `fecha_baja`, `usuario_alta`, `usuario_mod`, `usuario_baja`, `estado`, `cantidad`, `ingrediente_producido_id`, `ingrediente_id`) VALUES
(18, '2018-11-16 18:02:13', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', '900', 10, 23),
(19, '2018-11-16 18:02:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', '2', 10, 25),
(23, '2018-11-19 15:24:57', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', '60', 10, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingrediente_producido_preparacion`
--

CREATE TABLE `ingrediente_producido_preparacion` (
  `ingrediente_producido_preparacion_id` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_mod` datetime NOT NULL,
  `fecha_baja` datetime NOT NULL,
  `usuario_alta` int(11) NOT NULL,
  `usuario_mod` int(11) NOT NULL,
  `usuario_baja` int(11) NOT NULL,
  `estado` text NOT NULL,
  `paso` int(2) NOT NULL,
  `preparacion` text NOT NULL,
  `imagen` text NOT NULL,
  `imagen_nombre` text NOT NULL,
  `ingrediente_producido_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ingrediente_producido_preparacion`
--

INSERT INTO `ingrediente_producido_preparacion` (`ingrediente_producido_preparacion_id`, `fecha_alta`, `fecha_mod`, `fecha_baja`, `usuario_alta`, `usuario_mod`, `usuario_baja`, `estado`, `paso`, `preparacion`, `imagen`, `imagen_nombre`, `ingrediente_producido_id`) VALUES
(1, '2018-11-19 12:35:12', '2018-11-19 12:48:34', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 1, 'Se abre el paquete bien abierto', 'Si', '20181119123709', 10),
(2, '2018-11-19 12:36:33', '2018-11-19 12:48:43', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 2, 'se pela todo bien pelado', 'Si', '20181119123633', 10),
(3, '2018-11-19 12:37:24', '2018-11-19 12:56:58', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 3, 'se hierve todo bien hervido, mucho hasta que el agua se vuelva polvo se hierve todo bien hervido, mucho hasta qu', 'Si', '20181119124818', 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `inventario_id` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_mod` datetime NOT NULL,
  `fecha_baja` datetime NOT NULL,
  `usuario_alta` int(11) NOT NULL,
  `usuario_mod` int(11) NOT NULL,
  `usuario_baja` int(11) NOT NULL,
  `estado` text NOT NULL,
  `cantidad_actual` text NOT NULL,
  `cantidad_minima` text NOT NULL,
  `cantidad_maxima` text NOT NULL,
  `ingrediente_id` int(11) NOT NULL,
  `local_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`inventario_id`, `fecha_alta`, `fecha_mod`, `fecha_baja`, `usuario_alta`, `usuario_mod`, `usuario_baja`, `estado`, `cantidad_actual`, `cantidad_minima`, `cantidad_maxima`, `ingrediente_id`, `local_id`) VALUES
(1, '2018-11-07 20:00:04', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', '46', '9', '46', 11, 1),
(2, '2018-11-07 20:00:05', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', '10', '2', '10', 17, 1),
(3, '2018-11-07 20:00:06', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', '3', '0', '3', 27, 1),
(4, '2018-11-07 20:00:19', '2018-11-19 15:49:47', '0000-00-00 00:00:00', 1, 1, 0, 'activo', '83', '16', '83', 26, 1),
(5, '2018-11-19 15:49:37', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', '50', '10', '50', 28, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `local`
--

CREATE TABLE `local` (
  `local_id` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_mod` datetime NOT NULL,
  `fecha_baja` datetime NOT NULL,
  `usuario_alta` int(11) NOT NULL,
  `usuario_mod` int(11) NOT NULL,
  `usuario_baja` int(11) NOT NULL,
  `estado` text NOT NULL,
  `local` text NOT NULL,
  `nit` text NOT NULL,
  `regimen` text NOT NULL,
  `tipo` text NOT NULL,
  `direccion` text NOT NULL,
  `telefono` text NOT NULL,
  `apertura` time NOT NULL,
  `cierre` time NOT NULL,
  `propina` int(11) NOT NULL,
  `imagen` text NOT NULL,
  `imagen_nombre` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `local`
--

INSERT INTO `local` (`local_id`, `fecha_alta`, `fecha_mod`, `fecha_baja`, `usuario_alta`, `usuario_mod`, `usuario_baja`, `estado`, `local`, `nit`, `regimen`, `tipo`, `direccion`, `telefono`, `apertura`, `cierre`, `propina`, `imagen`, `imagen_nombre`) VALUES
(1, '2018-09-27 21:11:27', '2018-11-30 18:17:59', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'rionegro', '9008877', 'regimen simplificado', 'punto de venta', 'calle 10', '3123434', '09:00:00', '17:00:00', 0, 'si', '20180930003104'),
(2, '2018-09-27 21:17:48', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'laureles', '', '', 'punto de venta', 'calle 45', '6788778', '09:00:00', '17:00:00', 0, 'no', '20180927211748'),
(3, '2018-09-30 00:26:19', '0000-00-00 00:00:00', '2018-10-29 17:43:12', 1, 0, 1, 'eliminado', 'Bello', '', '', 'punto de venta', 'Calle 23 no 67-99', '2585452', '09:00:00', '17:00:00', 0, 'no', '20180930002619'),
(4, '2018-10-01 14:49:17', '2018-10-30 18:33:32', '2018-11-06 10:43:20', 1, 1, 1, 'activo', 'envigado', '', '', 'punto de venta', 'calle 45 # 18  - 23', '5676767', '09:00:00', '17:00:00', 10, 'si', '20181030183332'),
(5, '2018-10-30 18:28:50', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'mercado del rio', '', '', 'punto de venta', 'centro comercial mercados del rio local 1223', '7898989', '09:00:00', '17:00:00', 0, 'no', '20181030182850'),
(6, '2018-11-30 18:05:36', '2018-12-03 12:16:15', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'canalla express', '902119789-4x', 'somos rÃ©gimen comÃºnx', 'punto de venta', 'calle 10 No 55 99', '31244589', '09:00:00', '17:00:00', 10, 'no', '20181130180536');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metodo_pago`
--

CREATE TABLE `metodo_pago` (
  `metodo_pago_id` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_mod` datetime NOT NULL,
  `fecha_baja` datetime NOT NULL,
  `usuario_alta` int(11) NOT NULL,
  `usuario_mod` int(11) NOT NULL,
  `usuario_baja` int(11) NOT NULL,
  `estado` text NOT NULL,
  `metodo` text NOT NULL,
  `tipo` text NOT NULL,
  `porcentaje_comision` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `metodo_pago`
--

INSERT INTO `metodo_pago` (`metodo_pago_id`, `fecha_alta`, `fecha_mod`, `fecha_baja`, `usuario_alta`, `usuario_mod`, `usuario_baja`, `estado`, `metodo`, `tipo`, `porcentaje_comision`) VALUES
(1, '2018-09-06 13:26:33', '0000-00-00 00:00:00', '2018-10-29 18:19:44', 1, 0, 1, 'eliminado', 'VISA', 'tarjeta', '7'),
(2, '2018-09-06 13:27:03', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'efectivo', 'efectivo', '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(14) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `payment_ref` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `payment_result` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `user_id`, `user_email`, `payment_ref`, `user_name`, `payment_method`, `payment_result`) VALUES
(1, '999', 'dannyws@gmail.com', '1513518', 'Danny Wayne', 'TDC', 'Aceptada'),
(2, '999', 'dannyws@gmail.com', '1513582', 'Danny Wayne', 'cash', 'Aceptada'),
(3, '999', 'dannyws@gmail.com', '1583536', 'Danny Wayne', 'TDC', 'Aceptada'),
(4, '999', 'dannyws@gmail.com', '1638750', 'Danny Wayne', 'TDC', 'Aceptada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantilla_factura`
--

CREATE TABLE `plantilla_factura` (
  `plantilla_factura_id` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_mod` datetime NOT NULL,
  `fecha_baja` datetime NOT NULL,
  `usuario_alta` int(11) NOT NULL,
  `usuario_mod` int(11) NOT NULL,
  `usuario_baja` int(11) NOT NULL,
  `estado` text NOT NULL,
  `titulo` text NOT NULL,
  `prefijo` text NOT NULL,
  `numero_inicio` text NOT NULL,
  `numero_fin` text NOT NULL,
  `sufijo` text NOT NULL,
  `encabezado` text NOT NULL,
  `mostrar_atendido` text NOT NULL,
  `mostrar_impuesto` text NOT NULL,
  `pie` text NOT NULL,
  `imagen` text NOT NULL,
  `imagen_nombre` text NOT NULL,
  `local_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `plantilla_factura`
--

INSERT INTO `plantilla_factura` (`plantilla_factura_id`, `fecha_alta`, `fecha_mod`, `fecha_baja`, `usuario_alta`, `usuario_mod`, `usuario_baja`, `estado`, `titulo`, `prefijo`, `numero_inicio`, `numero_fin`, `sufijo`, `encabezado`, `mostrar_atendido`, `mostrar_impuesto`, `pie`, `imagen`, `imagen_nombre`, `local_id`) VALUES
(1, '2018-12-03 13:19:53', '2018-12-03 13:40:25', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'factura de venta', 'RIO', '1', '2000', 'POS', 'Inversiones Rionegro SAS\r\nResoluciÃ³n No 898787 de 2 de diciembre', 'si', 'si', 'Propina voluntaria\r\nGracias por su compra, vuelva pronto!', 'si', '20181203134025', 1),
(2, '2018-12-03 17:32:56', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'recibo de venta', 'can', '1', '3000', 'bar', 'texto de encabezado', 'si', 'si', 'bal labaslfadj;fldsf', 'si', '20181203173256', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `producto_id` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_mod` datetime NOT NULL,
  `fecha_baja` datetime NOT NULL,
  `usuario_alta` int(11) NOT NULL,
  `usuario_mod` int(11) NOT NULL,
  `usuario_baja` int(11) NOT NULL,
  `estado` text NOT NULL,
  `producto` text NOT NULL,
  `tipo` text NOT NULL,
  `descripcion` text NOT NULL,
  `codigo_barras` text NOT NULL,
  `imagen` text NOT NULL,
  `imagen_nombre` text NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `zona_entrega_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`producto_id`, `fecha_alta`, `fecha_mod`, `fecha_baja`, `usuario_alta`, `usuario_mod`, `usuario_baja`, `estado`, `producto`, `tipo`, `descripcion`, `codigo_barras`, `imagen`, `imagen_nombre`, `categoria_id`, `zona_entrega_id`) VALUES
(1, '2018-10-08 17:27:41', '0000-00-00 00:00:00', '2018-10-29 17:52:30', 1, 0, 1, 'eliminado', 'coca cola 350ml', 'simple', '', '', 'no', '20181008172741', 1, 1),
(2, '2018-10-08 17:31:10', '2018-10-08 17:32:42', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'seven up 350ml', 'simple', '', '', 'no', '20181008173110', 1, 1),
(3, '2018-10-29 19:30:25', '2018-10-30 19:28:42', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'hamburguesa', 'compuesto', '', '', 'no', '20181029193025', 2, 1),
(4, '2018-10-30 19:30:44', '2018-11-06 11:19:26', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'paella negra', 'compuesto', 'la paella es un rico plato para maricones', '', 'si', '20181031202808', 2, 1),
(5, '2018-10-30 19:46:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'pan', 'compuesto', 'es un deliciosso pan de trigo hecho en nuestro horno de leÃ±a acompaÃ±ado de tomate y aceite de oliva', '', 'no', '20181030194652', 2, 1),
(6, '2018-10-30 19:47:58', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'pan de frutos secos', 'compuesto', 'es un delicioso pan de trigo y frutos secos silvestres como la chia y el ajonjoli  hecho en nuestro horno de leÃ±a acompaÃ±ado de tomate y aceite de oliva', '', 'no', '20181030194758', 2, 1),
(7, '2018-10-30 19:55:28', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'cocacola', 'simple', 'jugo de coca negra', '', 'no', '20181030195528', 1, 2),
(8, '2018-10-31 16:50:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'cerveza', 'simple', '', '', 'no', '20181031165051', 1, 2),
(9, '2018-10-31 17:20:40', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'arroz blanco', 'compuesto', '', '', 'no', '20181031172040', 2, 1),
(10, '2018-10-31 17:22:05', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'pan integral', 'compuesto', '', '', 'no', '20181031172205', 2, 1),
(11, '2018-10-31 18:45:17', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'wisky old park doble', 'compuesto', 'trago servido on  the rocks', '', 'no', '20181031184517', 1, 2),
(12, '2018-10-31 20:29:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'club colombia', 'simple', 'Cerveza colombiana de tipo lagger', '', 'no', '20181031202938', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productor`
--

CREATE TABLE `productor` (
  `productor_id` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_mod` datetime NOT NULL,
  `fecha_baja` datetime NOT NULL,
  `usuario_alta` int(11) NOT NULL,
  `usuario_mod` int(11) NOT NULL,
  `usuario_baja` int(11) NOT NULL,
  `estado` text NOT NULL,
  `productor` text NOT NULL,
  `documento_tipo` text NOT NULL,
  `documento_numero` text NOT NULL,
  `tipo` text NOT NULL,
  `correo` text NOT NULL,
  `contacto` text NOT NULL,
  `telefono` text NOT NULL,
  `direccion` text NOT NULL,
  `cuenta_bancaria` text NOT NULL,
  `imagen` text NOT NULL,
  `imagen_nombre` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `productor`
--

INSERT INTO `productor` (`productor_id`, `fecha_alta`, `fecha_mod`, `fecha_baja`, `usuario_alta`, `usuario_mod`, `usuario_baja`, `estado`, `productor`, `documento_tipo`, `documento_numero`, `tipo`, `correo`, `contacto`, `telefono`, `direccion`, `cuenta_bancaria`, `imagen`, `imagen_nombre`) VALUES
(1, '2018-12-03 17:19:35', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'cocina canalla', 'NIT', '90099009', '', '', '', '', '', '', 'no', '20181203171935'),
(2, '2018-12-03 17:56:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'casa matriz', 'NIT', '9009809809', '', '', '', '', '', '', 'no', '20181203175641');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_composicion`
--

CREATE TABLE `producto_composicion` (
  `producto_composicion_id` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_mod` datetime NOT NULL,
  `fecha_baja` datetime NOT NULL,
  `usuario_alta` int(11) NOT NULL,
  `usuario_mod` int(11) NOT NULL,
  `usuario_baja` int(11) NOT NULL,
  `estado` text NOT NULL,
  `cantidad` text NOT NULL,
  `producto_id` int(11) NOT NULL,
  `ingrediente_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto_composicion`
--

INSERT INTO `producto_composicion` (`producto_composicion_id`, `fecha_alta`, `fecha_mod`, `fecha_baja`, `usuario_alta`, `usuario_mod`, `usuario_baja`, `estado`, `cantidad`, `producto_id`, `ingrediente_id`) VALUES
(1, '2018-10-08 17:27:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', '1', 1, 1),
(28, '2018-10-30 19:55:28', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', '1', 7, 19),
(41, '2018-11-13 14:44:40', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', '90', 4, 14),
(25, '2018-10-30 00:38:46', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', '1', 2, 2),
(29, '2018-10-31 16:50:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', '1', 8, 20),
(30, '2018-10-31 17:22:05', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', '1', 10, 21),
(39, '2018-11-08 16:04:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', '8', 4, 22),
(33, '2018-10-31 20:29:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', '1', 12, 25),
(52, '2018-11-19 15:31:10', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', '6900', 4, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_local`
--

CREATE TABLE `producto_local` (
  `producto_local_id` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_mod` datetime NOT NULL,
  `fecha_baja` datetime NOT NULL,
  `usuario_alta` int(11) NOT NULL,
  `usuario_mod` int(11) NOT NULL,
  `usuario_baja` int(11) NOT NULL,
  `estado` text NOT NULL,
  `producto_id` int(11) NOT NULL,
  `local_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto_local`
--

INSERT INTO `producto_local` (`producto_local_id`, `fecha_alta`, `fecha_mod`, `fecha_baja`, `usuario_alta`, `usuario_mod`, `usuario_baja`, `estado`, `producto_id`, `local_id`) VALUES
(1, '2018-10-08 17:27:41', '0000-00-00 00:00:00', '2018-10-29 17:52:30', 1, 0, 1, 'eliminado', 1, 3),
(2, '2018-10-08 17:27:41', '0000-00-00 00:00:00', '2018-10-29 17:52:30', 1, 0, 1, 'eliminado', 1, 2),
(3, '2018-10-08 17:27:41', '0000-00-00 00:00:00', '2018-10-29 17:52:30', 1, 0, 1, 'eliminado', 1, 1),
(7, '2018-10-30 19:28:42', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 3, 2),
(36, '2018-11-06 11:19:26', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 4, 4),
(11, '2018-10-30 19:46:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 5, 4),
(12, '2018-10-30 19:46:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 5, 2),
(13, '2018-10-30 19:46:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 5, 5),
(14, '2018-10-30 19:46:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 5, 1),
(15, '2018-10-30 19:47:58', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 6, 4),
(16, '2018-10-30 19:47:58', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 6, 2),
(17, '2018-10-30 19:47:58', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 6, 5),
(18, '2018-10-30 19:47:58', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 6, 1),
(21, '2018-10-30 19:55:28', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 7, 4),
(22, '2018-10-30 19:55:28', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 7, 2),
(23, '2018-10-30 19:55:28', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 7, 5),
(24, '2018-10-30 19:55:28', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 7, 1),
(25, '2018-10-31 16:50:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 8, 4),
(26, '2018-10-31 16:50:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 8, 2),
(27, '2018-10-31 16:50:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 8, 1),
(28, '2018-10-31 17:20:40', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 9, 2),
(29, '2018-10-31 18:45:17', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 11, 4),
(30, '2018-10-31 18:45:17', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 11, 2),
(31, '2018-10-31 18:45:17', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 11, 5),
(32, '2018-10-31 18:45:17', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 11, 1),
(34, '2018-10-31 20:29:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 12, 2),
(35, '2018-10-31 20:29:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 12, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_precio`
--

CREATE TABLE `producto_precio` (
  `producto_precio_id` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_mod` datetime NOT NULL,
  `fecha_baja` datetime NOT NULL,
  `usuario_alta` int(11) NOT NULL,
  `usuario_mod` int(11) NOT NULL,
  `usuario_baja` int(11) NOT NULL,
  `estado` text NOT NULL,
  `nombre` text NOT NULL,
  `tipo` text NOT NULL,
  `precio` text NOT NULL,
  `impuesto_incluido` text NOT NULL,
  `producto_id` int(11) NOT NULL,
  `impuesto_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto_precio`
--

INSERT INTO `producto_precio` (`producto_precio_id`, `fecha_alta`, `fecha_mod`, `fecha_baja`, `usuario_alta`, `usuario_mod`, `usuario_baja`, `estado`, `nombre`, `tipo`, `precio`, `impuesto_incluido`, `producto_id`, `impuesto_id`) VALUES
(1, '2018-10-08 17:27:41', '0000-00-00 00:00:00', '2018-10-29 17:52:30', 1, 0, 1, 'eliminado', 'precio normal', 'principal', '3000', 'si', 1, 1),
(2, '2018-10-08 17:31:10', '2018-10-08 17:32:42', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'precio normal', 'principal', '1000', 'no', 2, 1),
(3, '2018-10-29 18:12:06', '0000-00-00 00:00:00', '2018-10-29 18:12:31', 1, 0, 1, 'eliminado', 'distribuidor', 'secundario', '2000', 'si', 2, 1),
(4, '2018-10-29 19:30:25', '2018-10-30 19:28:42', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'precio normal', 'principal', '10000', 'si', 3, 1),
(5, '2018-10-30 19:30:44', '2018-11-06 11:19:26', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'precio normal', 'principal', '30000', 'si', 4, 3),
(6, '2018-10-30 19:33:16', '2018-10-30 19:35:18', '2018-11-06 11:19:10', 1, 1, 1, 'eliminado', 'eventos', 'secundario', '25000', 'si', 4, 3),
(7, '2018-10-30 19:46:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'precio normal', 'principal', '8000', 'no', 5, 3),
(8, '2018-10-30 19:47:58', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'precio normal', 'principal', '8000', 'no', 6, 3),
(9, '2018-10-30 19:55:28', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'precio normal', 'principal', '5000', 'no', 7, 3),
(10, '2018-10-31 16:50:51', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'precio normal', 'secundario', '3000', 'si', 8, 1),
(11, '2018-10-31 17:20:40', '2018-11-16 14:29:13', '2018-11-16 15:00:33', 1, 1, 1, 'eliminado', 'precio normal', 'secundario', '5000', 'si', 9, 1),
(12, '2018-10-31 17:22:05', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'precio normal', 'principal', '5000', 'si', 10, 1),
(13, '2018-10-31 18:45:17', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'precio normal', 'principal', '20000', 'si', 11, 3),
(14, '2018-10-31 20:29:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'precio normal', 'principal', '5000', 'si', 12, 1),
(15, '2018-11-14 16:13:53', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'distribuidor', 'secundario', '3500', 'si', 4, 1),
(16, '2018-11-16 15:01:02', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'principal', 'principal', '2000', 'si', 9, 1),
(17, '2018-11-16 16:40:55', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'a por mayor', 'secundario', '7000', 'no', 4, 4),
(18, '2018-11-17 16:15:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'distribuidor', 'secundario', '2000', 'si', 8, 1),
(19, '2018-11-17 16:16:12', '2018-11-17 16:16:31', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'al por mayor', 'principal', '1500', 'no', 8, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `proveedor_id` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_mod` datetime NOT NULL,
  `fecha_baja` datetime NOT NULL,
  `usuario_alta` int(11) NOT NULL,
  `usuario_mod` int(11) NOT NULL,
  `usuario_baja` int(11) NOT NULL,
  `estado` text NOT NULL,
  `proveedor` text NOT NULL,
  `documento_tipo` text NOT NULL,
  `documento_numero` text NOT NULL,
  `tipo` text NOT NULL,
  `contacto` text NOT NULL,
  `telefono_pedidos` text NOT NULL,
  `correo_pedidos` text NOT NULL,
  `telefono` text NOT NULL,
  `correo` text NOT NULL,
  `direccion` text NOT NULL,
  `cuenta_bancaria` text NOT NULL,
  `imagen` text NOT NULL,
  `imagen_nombre` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`proveedor_id`, `fecha_alta`, `fecha_mod`, `fecha_baja`, `usuario_alta`, `usuario_mod`, `usuario_baja`, `estado`, `proveedor`, `documento_tipo`, `documento_numero`, `tipo`, `contacto`, `telefono_pedidos`, `correo_pedidos`, `telefono`, `correo`, `direccion`, `cuenta_bancaria`, `imagen`, `imagen_nombre`) VALUES
(1, '2018-12-03 16:25:31', '2018-12-03 16:43:45', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'La Careta', 'NIT', '90989898', 'licores', 'pepito careta', '30031448860', 'compras@lacareta.com0', '2454545', 'info@lacareta.com', 'calle falsa 123', '34998761233', 'no', '20181203162531');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicacion`
--

CREATE TABLE `ubicacion` (
  `ubicacion_id` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_mod` datetime NOT NULL,
  `fecha_baja` datetime NOT NULL,
  `usuario_alta` int(11) NOT NULL,
  `usuario_mod` int(11) NOT NULL,
  `usuario_baja` int(11) NOT NULL,
  `estado` text NOT NULL,
  `ubicacion` text NOT NULL,
  `ubicada` text NOT NULL,
  `tipo` text NOT NULL,
  `local_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ubicacion`
--

INSERT INTO `ubicacion` (`ubicacion_id`, `fecha_alta`, `fecha_mod`, `fecha_baja`, `usuario_alta`, `usuario_mod`, `usuario_baja`, `estado`, `ubicacion`, `ubicada`, `tipo`, `local_id`) VALUES
(1, '2018-09-06 12:55:28', '2018-09-18 17:32:24', '2018-11-06 10:54:13', 1, 1, 1, 'eliminado', 'mesa 1', 'terraza', 'mesa', 1),
(2, '2018-09-06 13:10:57', '2018-09-26 12:36:10', '2018-10-29 17:58:48', 1, 1, 1, 'eliminado', 'mesa 2', 'terraza', 'mesa', 1),
(3, '2018-11-30 15:46:10', '2018-12-03 13:51:33', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'mesa 1', 'piso 1', 'mesa', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuario_id` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_mod` datetime NOT NULL,
  `fecha_baja` datetime NOT NULL,
  `usuario_alta` int(11) NOT NULL,
  `usuario_mod` int(11) NOT NULL,
  `usuario_baja` int(11) NOT NULL,
  `estado` text NOT NULL,
  `nombres` text NOT NULL,
  `apellidos` text NOT NULL,
  `documento_tipo` text NOT NULL,
  `documento_numero` text NOT NULL,
  `tipo` text NOT NULL,
  `correo` text NOT NULL,
  `contrasena` text NOT NULL,
  `telefono` text NOT NULL,
  `telefono_emergencia` text NOT NULL,
  `direccion` text NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `porcentaje_comision` text NOT NULL,
  `imagen` text NOT NULL,
  `imagen_nombre` text NOT NULL,
  `local_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `fecha_alta`, `fecha_mod`, `fecha_baja`, `usuario_alta`, `usuario_mod`, `usuario_baja`, `estado`, `nombres`, `apellidos`, `documento_tipo`, `documento_numero`, `tipo`, `correo`, `contrasena`, `telefono`, `telefono_emergencia`, `direccion`, `fecha_nacimiento`, `porcentaje_comision`, `imagen`, `imagen_nombre`, `local_id`) VALUES
(1, '2018-09-03 10:34:07', '2018-12-03 17:25:28', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'danny', 'estrada', 'CC', '8359856', 'soporte tÃ©cnico', 'demo@demo.com', 'demo', '3124450363', '8909090', 'calle 23 #55 - 77', '1985-02-15', '8', 'si', '20180906125313', 1),
(2, '2018-09-17 16:51:43', '0000-00-00 00:00:00', '2018-11-06 10:53:10', 1, 0, 1, 'eliminado', 'jhon', 'doe', 'CC', '889988', 'vendedor', 'pepito@gmail.com', '12233', '3454545', '', 'calle 10 # 67 - 90', '2002-01-01', '', 'no', '20180917165143', 1),
(3, '2018-09-17 16:53:05', '2018-11-30 15:40:44', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'jay', 'melanie', 'CC', '8899887', 'vendedor', 'jay@gmail.com', '12233', '3454545', '', 'calle 10 # 67 - 90', '2002-01-01', '5', 'no', '20180917165305', 1),
(4, '2018-09-17 16:54:19', '2018-11-30 16:12:28', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'andrea', 'guzman', 'CC', '098098', 'administradora', 'andrea@gmail.com', '123123', '3124450363', '3454545', 'calle 23 No 55 - 77', '1985-02-15', '10', 'si', '20180918004306', 1),
(5, '2018-09-17 16:55:26', '2018-09-17 17:36:42', '2018-10-29 17:56:50', 1, 1, 1, 'eliminado', 'manuela', 'perez', 'CC', '988788', 'cajera', 'manuela@gmail.com', '878787', '', '', '', '0000-00-00', '', 'no', '20180917165526', 1),
(6, '2018-11-30 16:05:57', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'Carlos', 'Merlano', 'CC', '909890', 'mesero', 'carlos@demo.com', 'carlos', '3124433221', '6788776', 'Call3 66 90 88', '0000-00-00', '10', 'no', '20181130160557', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zona_entrega`
--

CREATE TABLE `zona_entrega` (
  `zona_entrega_id` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_mod` datetime NOT NULL,
  `fecha_baja` datetime NOT NULL,
  `usuario_alta` int(11) NOT NULL,
  `usuario_mod` int(11) NOT NULL,
  `usuario_baja` int(11) NOT NULL,
  `estado` text NOT NULL,
  `zona_entrega` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `zona_entrega`
--

INSERT INTO `zona_entrega` (`zona_entrega_id`, `fecha_alta`, `fecha_mod`, `fecha_baja`, `usuario_alta`, `usuario_mod`, `usuario_baja`, `estado`, `zona_entrega`) VALUES
(1, '2018-09-05 17:22:15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'cocina'),
(2, '2018-09-05 17:22:18', '2018-09-18 18:01:24', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'bar'),
(3, '2018-09-17 15:54:20', '0000-00-00 00:00:00', '2018-10-29 17:54:24', 1, 0, 1, 'eliminado', 'grill');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`categoria_id`);

--
-- Indices de la tabla `cliente_pago`
--
ALTER TABLE `cliente_pago`
  ADD PRIMARY KEY (`cliente_pago_id`),
  ADD KEY `cuenta_id` (`cuenta_id`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`compra_id`),
  ADD KEY `destino` (`destino`);

--
-- Indices de la tabla `compra_ingrediente`
--
ALTER TABLE `compra_ingrediente`
  ADD PRIMARY KEY (`compra_ingrediente_id`),
  ADD KEY `compra_id` (`compra_id`),
  ADD KEY `ingrediente_id` (`ingrediente_id`);

--
-- Indices de la tabla `descuento`
--
ALTER TABLE `descuento`
  ADD PRIMARY KEY (`descuento_id`);

--
-- Indices de la tabla `impuesto`
--
ALTER TABLE `impuesto`
  ADD PRIMARY KEY (`impuesto_id`);

--
-- Indices de la tabla `ingrediente`
--
ALTER TABLE `ingrediente`
  ADD PRIMARY KEY (`ingrediente_id`),
  ADD KEY `proveedor_id` (`proveedor_id`);

--
-- Indices de la tabla `ingrediente_producido_composicion`
--
ALTER TABLE `ingrediente_producido_composicion`
  ADD PRIMARY KEY (`ingrediente_producido_composicion_id`),
  ADD KEY `ingrediente_producido_id` (`ingrediente_producido_id`),
  ADD KEY `ingrediente_id` (`ingrediente_id`);

--
-- Indices de la tabla `ingrediente_producido_preparacion`
--
ALTER TABLE `ingrediente_producido_preparacion`
  ADD PRIMARY KEY (`ingrediente_producido_preparacion_id`),
  ADD KEY `ingrediente_producido_id` (`ingrediente_producido_id`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`inventario_id`),
  ADD KEY `ingrediente_id` (`ingrediente_id`),
  ADD KEY `local_id` (`local_id`);

--
-- Indices de la tabla `local`
--
ALTER TABLE `local`
  ADD PRIMARY KEY (`local_id`);

--
-- Indices de la tabla `metodo_pago`
--
ALTER TABLE `metodo_pago`
  ADD PRIMARY KEY (`metodo_pago_id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `plantilla_factura`
--
ALTER TABLE `plantilla_factura`
  ADD PRIMARY KEY (`plantilla_factura_id`),
  ADD KEY `local_id` (`local_id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`producto_id`),
  ADD KEY `categoria_id` (`categoria_id`),
  ADD KEY `zona_entrega_id` (`zona_entrega_id`);

--
-- Indices de la tabla `productor`
--
ALTER TABLE `productor`
  ADD PRIMARY KEY (`productor_id`);

--
-- Indices de la tabla `producto_composicion`
--
ALTER TABLE `producto_composicion`
  ADD PRIMARY KEY (`producto_composicion_id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `componente_id` (`ingrediente_id`);

--
-- Indices de la tabla `producto_local`
--
ALTER TABLE `producto_local`
  ADD PRIMARY KEY (`producto_local_id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `local_id` (`local_id`);

--
-- Indices de la tabla `producto_precio`
--
ALTER TABLE `producto_precio`
  ADD PRIMARY KEY (`producto_precio_id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `impuesto_id` (`impuesto_id`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`proveedor_id`);

--
-- Indices de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  ADD PRIMARY KEY (`ubicacion_id`),
  ADD KEY `local_id` (`local_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuario_id`),
  ADD KEY `id_local` (`local_id`);

--
-- Indices de la tabla `zona_entrega`
--
ALTER TABLE `zona_entrega`
  ADD PRIMARY KEY (`zona_entrega_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `categoria_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cliente_pago`
--
ALTER TABLE `cliente_pago`
  MODIFY `cliente_pago_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `compra_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `compra_ingrediente`
--
ALTER TABLE `compra_ingrediente`
  MODIFY `compra_ingrediente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `descuento`
--
ALTER TABLE `descuento`
  MODIFY `descuento_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `impuesto`
--
ALTER TABLE `impuesto`
  MODIFY `impuesto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ingrediente`
--
ALTER TABLE `ingrediente`
  MODIFY `ingrediente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `ingrediente_producido_composicion`
--
ALTER TABLE `ingrediente_producido_composicion`
  MODIFY `ingrediente_producido_composicion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `ingrediente_producido_preparacion`
--
ALTER TABLE `ingrediente_producido_preparacion`
  MODIFY `ingrediente_producido_preparacion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `inventario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `local`
--
ALTER TABLE `local`
  MODIFY `local_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `metodo_pago`
--
ALTER TABLE `metodo_pago`
  MODIFY `metodo_pago_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(14) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `plantilla_factura`
--
ALTER TABLE `plantilla_factura`
  MODIFY `plantilla_factura_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `producto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `productor`
--
ALTER TABLE `productor`
  MODIFY `productor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `producto_composicion`
--
ALTER TABLE `producto_composicion`
  MODIFY `producto_composicion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `producto_local`
--
ALTER TABLE `producto_local`
  MODIFY `producto_local_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `producto_precio`
--
ALTER TABLE `producto_precio`
  MODIFY `producto_precio_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `proveedor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  MODIFY `ubicacion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `zona_entrega`
--
ALTER TABLE `zona_entrega`
  MODIFY `zona_entrega_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
