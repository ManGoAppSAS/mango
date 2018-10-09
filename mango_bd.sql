-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-10-2018 a las 16:58:18
-- Versión del servidor: 10.1.36-MariaDB
-- Versión de PHP: 7.2.10

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
(1, '2018-09-27 21:40:21', '2018-09-28 00:40:19', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'bebidas', 'productos', 'no', 'no', '20180927214021'),
(2, '2018-09-27 21:40:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'fuertes', 'productos', 'no', 'no', '20180927214038'),
(3, '2018-09-27 21:40:42', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'postres', 'productos', 'no', 'no', '20180927214042');

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
-- Estructura de tabla para la tabla `componente`
--

CREATE TABLE `componente` (
  `componente_id` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_mod` datetime NOT NULL,
  `fecha_baja` datetime NOT NULL,
  `usuario_alta` int(11) NOT NULL,
  `usuario_mod` int(11) NOT NULL,
  `usuario_baja` int(11) NOT NULL,
  `estado` text NOT NULL,
  `componente` text NOT NULL,
  `tipo` text NOT NULL,
  `unidad_minima` text NOT NULL,
  `unidad_compra` text NOT NULL,
  `costo_unidad_minima` text NOT NULL,
  `costo_unidad_compra` text NOT NULL,
  `preparacion` text NOT NULL,
  `cantidad_unidad_compra` text NOT NULL,
  `proveedor_id` int(11) NOT NULL,
  `productor_id` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `componente`
--

INSERT INTO `componente` (`componente_id`, `fecha_alta`, `fecha_mod`, `fecha_baja`, `usuario_alta`, `usuario_mod`, `usuario_baja`, `estado`, `componente`, `tipo`, `unidad_minima`, `unidad_compra`, `costo_unidad_minima`, `costo_unidad_compra`, `preparacion`, `cantidad_unidad_compra`, `proveedor_id`, `productor_id`) VALUES
(1, '2018-10-08 17:27:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'coca cola 350ml', 'comprado', 'unid', 'unid', '1000', '1000', '', '0', 1, '0'),
(2, '2018-10-08 17:31:10', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'seven up 350ml', 'comprado', 'unid', 'unid', '1000', '1000', '', '0', 1, '0');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `componente_producido_composicion`
--

CREATE TABLE `componente_producido_composicion` (
  `componente_producido_composicion_id` int(11) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_mod` datetime NOT NULL,
  `fecha_baja` datetime NOT NULL,
  `usuario_alta` int(11) NOT NULL,
  `usuario_mod` int(11) NOT NULL,
  `usuario_baja` int(11) NOT NULL,
  `estado` text NOT NULL,
  `cantidad` text NOT NULL,
  `componente_producido_id` int(11) NOT NULL,
  `componente_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
(1, '2018-09-06 13:29:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'cortesia', '100', 'ventas'),
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
(1, '2018-09-27 20:41:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'IVA', '19');

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

INSERT INTO `local` (`local_id`, `fecha_alta`, `fecha_mod`, `fecha_baja`, `usuario_alta`, `usuario_mod`, `usuario_baja`, `estado`, `local`, `tipo`, `direccion`, `telefono`, `apertura`, `cierre`, `propina`, `imagen`, `imagen_nombre`) VALUES
(1, '2018-09-27 21:11:27', '2018-09-30 00:31:04', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'rionegro', 'punto de venta', 'calle 10', '3123434', '09:00:00', '17:00:00', 0, 'si', '20180930003104'),
(2, '2018-09-27 21:17:48', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'laureles', 'punto de venta', 'calle 45', '6788778', '09:00:00', '17:00:00', 0, 'no', '20180927211748'),
(3, '2018-09-30 00:26:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'Bello', 'punto de venta', 'Calle 23 no 67-99', '2585452', '09:00:00', '17:00:00', 0, 'no', '20180930002619'),
(4, '2018-10-01 14:49:17', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'hola lola', 'punto de venta', 'CALLE DEL PARAISO 9', '1243134E1', '09:00:00', '17:00:00', 10, 'no', '20181001144917');

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
(1, '2018-09-06 13:26:33', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'VISA', 'tarjeta', '7'),
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
  `mostrar_local` text NOT NULL,
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

INSERT INTO `plantilla_factura` (`plantilla_factura_id`, `fecha_alta`, `fecha_mod`, `fecha_baja`, `usuario_alta`, `usuario_mod`, `usuario_baja`, `estado`, `titulo`, `prefijo`, `numero_inicio`, `numero_fin`, `sufijo`, `encabezado`, `mostrar_local`, `mostrar_atendido`, `mostrar_impuesto`, `pie`, `imagen`, `imagen_nombre`, `local_id`) VALUES
(1, '2018-09-06 18:26:16', '2018-09-06 18:42:37', '2018-09-17 23:13:30', 1, 1, 1, 'eliminado', 'factura de venta', 'POB', '1', '1000', 'REST', 'Somos rÃ©gimen... \r\nNIT... \r\nResoluciÃ³n de facturaciÃ³n No...', 'no', 'no', 'no', 'gracias por su compra', 'si', '20180906182616', 2),
(2, '2018-09-14 16:30:37', '2018-09-18 21:42:15', '2018-09-18 22:03:03', 1, 1, 1, 'eliminado', 'recibo de venta', 'ARG ', '1', '10000', ' XC', 'Somos rÃ©gimen... NIT... ResoluciÃ³n de facturaciÃ³n No...', 'si', 'si', 'si', 'gracias x su compra', 'si', '20180914163037', 1),
(3, '2018-09-18 22:04:29', '2018-09-26 13:34:20', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'factura de venta', '', '1', '10000', '', 'Somos rÃ©gimen... \r\nNIT... \r\nResoluciÃ³n de facturaciÃ³n No...', 'si', 'si', 'si', 'Gracias por su compra\r\nVuelva pronto', 'si', '20180918220657', 1);

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
(1, '2018-10-08 17:27:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'coca cola 350ml', 'simple', '', '', 'no', '20181008172741', 1, 1),
(2, '2018-10-08 17:31:10', '2018-10-08 17:32:42', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'seven up 350ml', 'simple', '', '', 'no', '20181008173110', 1, 1);

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
  `componente_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto_composicion`
--

INSERT INTO `producto_composicion` (`producto_composicion_id`, `fecha_alta`, `fecha_mod`, `fecha_baja`, `usuario_alta`, `usuario_mod`, `usuario_baja`, `estado`, `cantidad`, `producto_id`, `componente_id`) VALUES
(1, '2018-10-08 17:27:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', '1', 1, 1),
(2, '2018-10-08 17:31:10', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', '1', 2, 2);

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
(1, '2018-10-08 17:27:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 1, 3),
(2, '2018-10-08 17:27:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 1, 2),
(3, '2018-10-08 17:27:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 1, 1);

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
(1, '2018-10-08 17:27:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'precio normal', 'principal', '3000', 'si', 1, 1),
(2, '2018-10-08 17:31:10', '2018-10-08 17:32:42', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'precio normal', 'principal', '1000', 'no', 2, 1);

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
  `correo` text NOT NULL,
  `contacto` text NOT NULL,
  `telefono` text NOT NULL,
  `direccion` text NOT NULL,
  `cuenta_bancaria` text NOT NULL,
  `imagen` text NOT NULL,
  `imagen_nombre` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`proveedor_id`, `fecha_alta`, `fecha_mod`, `fecha_baja`, `usuario_alta`, `usuario_mod`, `usuario_baja`, `estado`, `proveedor`, `documento_tipo`, `documento_numero`, `tipo`, `correo`, `contacto`, `telefono`, `direccion`, `cuenta_bancaria`, `imagen`, `imagen_nombre`) VALUES
(1, '2018-09-27 22:35:03', '2018-09-27 22:40:34', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'juan de hoyos', 'NIT', '900976432', 'abarrotes', 'ventas@juandehoyos.com', 'camilo perez', '5667788', 'calle 45 No 55-90', '98967544532 ahorros bancolombia', 'no', '20180927223503'),
(2, '2018-10-02 18:23:25', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'prospier', 'NIT', '986968968', 'lupulos', 'ventas@prospiera.com', 'marco a;sfdkja;sdklfja;dskjl', '3124458989', 'calle 56 78 89', '9009898787', 'no', '20181002182325');

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
  `impuestos` text NOT NULL,
  `porcentaje_comision` text NOT NULL,
  `local_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ubicacion`
--

INSERT INTO `ubicacion` (`ubicacion_id`, `fecha_alta`, `fecha_mod`, `fecha_baja`, `usuario_alta`, `usuario_mod`, `usuario_baja`, `estado`, `ubicacion`, `ubicada`, `tipo`, `impuestos`, `porcentaje_comision`, `local_id`) VALUES
(1, '2018-09-06 12:55:28', '2018-09-18 17:32:24', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'mesa 1', 'terraza', 'mesa', 'si', '20', 1),
(2, '2018-09-06 13:10:57', '2018-09-26 12:36:10', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'mesa 2', 'terraza', 'mesa', 'si', '20', 1);

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
  `direccion` text NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `imagen` text NOT NULL,
  `imagen_nombre` text NOT NULL,
  `local_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuario_id`, `fecha_alta`, `fecha_mod`, `fecha_baja`, `usuario_alta`, `usuario_mod`, `usuario_baja`, `estado`, `nombres`, `apellidos`, `documento_tipo`, `documento_numero`, `tipo`, `correo`, `contrasena`, `telefono`, `direccion`, `fecha_nacimiento`, `imagen`, `imagen_nombre`, `local_id`) VALUES
(1, '2018-09-03 10:34:07', '2018-09-17 17:45:32', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'danny', 'estrada', 'CC', '8359856', 'soporte tÃ©cnico', 'demo@demo.com', 'demo', '3124450363', 'calle 23 #55 - 77', '1985-02-15', 'si', '20180906125313', 1),
(2, '2018-09-17 16:51:43', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'jhon', 'doe', 'CC', '889988', 'vendedor', 'pepito@gmail.com', '12233', '3454545', 'calle 10 # 67 - 90', '2002-01-01', 'no', '20180917165143', 1),
(3, '2018-09-17 16:53:05', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'jay', 'melanie', 'CC', '8899887', 'vendedor', 'jay@gmail.com', '12233', '3454545', 'calle 10 # 67 - 90', '2002-01-01', 'no', '20180917165305', 1),
(4, '2018-09-17 16:54:19', '2018-09-26 12:32:55', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'andrea', 'guzman', 'CC', '098098', 'administradora', 'andrea@gmail.com', '123123', '3124450363', 'calle 23 No 55 - 77', '1985-02-15', 'si', '20180918004306', 1),
(5, '2018-09-17 16:55:26', '2018-09-17 17:36:42', '0000-00-00 00:00:00', 1, 1, 0, 'activo', 'manuela', 'perez', 'CC', '988788', 'cajera', 'manuela@gmail.com', '878787', '', '', '0000-00-00', 'no', '20180917165526', 1);

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
(3, '2018-09-17 15:54:20', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 0, 'activo', 'grill');

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
-- Indices de la tabla `componente`
--
ALTER TABLE `componente`
  ADD PRIMARY KEY (`componente_id`),
  ADD KEY `proveedor_id` (`proveedor_id`);

--
-- Indices de la tabla `componente_producido_composicion`
--
ALTER TABLE `componente_producido_composicion`
  ADD PRIMARY KEY (`componente_producido_composicion_id`),
  ADD KEY `componente_producido_id` (`componente_producido_id`),
  ADD KEY `componente_id` (`componente_id`);

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
  ADD KEY `componente_id` (`componente_id`);

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
-- AUTO_INCREMENT de la tabla `componente`
--
ALTER TABLE `componente`
  MODIFY `componente_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `componente_producido_composicion`
--
ALTER TABLE `componente_producido_composicion`
  MODIFY `componente_producido_composicion_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `descuento`
--
ALTER TABLE `descuento`
  MODIFY `descuento_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `impuesto`
--
ALTER TABLE `impuesto`
  MODIFY `impuesto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `local`
--
ALTER TABLE `local`
  MODIFY `local_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `plantilla_factura_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `producto_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productor`
--
ALTER TABLE `productor`
  MODIFY `productor_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto_composicion`
--
ALTER TABLE `producto_composicion`
  MODIFY `producto_composicion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `producto_local`
--
ALTER TABLE `producto_local`
  MODIFY `producto_local_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `producto_precio`
--
ALTER TABLE `producto_precio`
  MODIFY `producto_precio_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `proveedor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  MODIFY `ubicacion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `zona_entrega`
--
ALTER TABLE `zona_entrega`
  MODIFY `zona_entrega_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
