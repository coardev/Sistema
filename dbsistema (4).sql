-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-06-2020 a las 04:11:51
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbsistema`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `id` int(10) UNSIGNED NOT NULL,
  `idcategoria` int(10) UNSIGNED DEFAULT NULL,
  `codigo` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inventariable` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `precio_proveedor` decimal(11,2) DEFAULT NULL,
  `precio_proveedor1` decimal(11,2) DEFAULT NULL,
  `precio_venta` decimal(11,2) DEFAULT NULL,
  `iva` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ieps` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock` decimal(11,2) DEFAULT 0.00,
  `minimo` decimal(11,2) DEFAULT 0.00,
  `existencia` decimal(11,2) DEFAULT NULL,
  `promedio` decimal(11,2) DEFAULT NULL,
  `stock1` int(11) DEFAULT NULL,
  `total` decimal(11,2) DEFAULT NULL,
  `salida1` decimal(11,2) DEFAULT NULL,
  `descripcion` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condicion` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`id`, `idcategoria`, `codigo`, `nombre`, `inventariable`, `precio_proveedor`, `precio_proveedor1`, `precio_venta`, `iva`, `ieps`, `stock`, `minimo`, `existencia`, `promedio`, `stock1`, `total`, `salida1`, `descripcion`, `condicion`, `created_at`, `updated_at`) VALUES
(54, 10, '5145', 'Cubrebocas', '1', '5.00', '5.00', '8.50', 'Si', 'Si', '157.00', '10.00', '200.00', '5.00', NULL, '1000.00', NULL, 'Azul', 1, '2020-06-22 01:56:16', '2020-06-22 01:56:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `condicion`, `created_at`, `updated_at`) VALUES
(10, 'Farmacia', NULL, 1, '2020-06-22 01:53:33', '2020-06-22 01:53:33'),
(11, 'Servicio', NULL, 1, '2020-06-22 01:53:58', '2020-06-22 01:53:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ingresos`
--

CREATE TABLE `detalle_ingresos` (
  `id` int(10) UNSIGNED NOT NULL,
  `idingreso` int(10) UNSIGNED NOT NULL,
  `idarticulo` int(10) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Disparadores `detalle_ingresos`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockIngreso` AFTER INSERT ON `detalle_ingresos` FOR EACH ROW BEGIN
 UPDATE articulos SET stock = stock + NEW.cantidad 
 WHERE articulos.id = NEW.idarticulo;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id` int(10) UNSIGNED NOT NULL,
  `idventa` int(10) UNSIGNED DEFAULT NULL,
  `stock` decimal(11,2) DEFAULT NULL,
  `stock2` decimal(11,2) DEFAULT NULL,
  `articulo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `idarticulo` int(10) UNSIGNED DEFAULT NULL,
  `cantidad` decimal(11,2) DEFAULT NULL,
  `precio` decimal(11,2) DEFAULT NULL,
  `precio_proveedor` decimal(11,2) DEFAULT NULL,
  `promedio` decimal(11,2) DEFAULT 0.00,
  `precio1` decimal(11,2) DEFAULT NULL,
  `importe` decimal(11,2) DEFAULT NULL,
  `total` decimal(11,2) DEFAULT NULL,
  `estado` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condicion` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id`, `idventa`, `stock`, `stock2`, `articulo`, `idarticulo`, `cantidad`, `precio`, `precio_proveedor`, `promedio`, `precio1`, `importe`, `total`, `estado`, `condicion`, `created_at`, `updated_at`) VALUES
(161, 151, '200.00', '170.00', 'Cubrebocas', 54, '30.00', '8.50', '5.00', '0.00', '5.00', '255.00', '850.00', 'Venta Cancelada', NULL, '2020-06-22 01:57:01', '2020-06-22 01:57:48'),
(162, 152, '170.00', '128.00', 'Cubrebocas', 54, '42.00', '8.50', '5.00', '0.00', '5.00', '357.00', '640.00', 'Venta Cancelada', NULL, '2020-06-22 01:57:28', '2020-06-22 01:59:04'),
(163, 153, '200.00', '168.00', 'Cubrebocas', 54, '32.00', '8.50', '5.00', '0.00', '5.00', '272.00', '840.00', 'Venta Cancelada', NULL, '2020-06-22 02:08:16', '2020-06-22 02:10:07'),
(164, 154, '168.00', '145.00', 'Cubrebocas', 54, '23.00', '8.50', '5.00', '0.00', '5.00', '195.50', '725.00', 'Venta Concretada', NULL, '2020-06-22 02:08:41', NULL),
(165, 155, '209.00', '157.00', 'Cubrebocas', 54, '52.00', '8.50', '5.00', '0.00', '5.00', '442.00', '785.00', 'Venta Concretada', NULL, '2020-06-22 02:11:25', NULL);

--
-- Disparadores `detalle_ventas`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockVenta` AFTER INSERT ON `detalle_ventas` FOR EACH ROW BEGIN
 UPDATE articulos SET stock = stock - NEW.cantidad 
 WHERE articulos.id = NEW.idarticulo
 AND articulos.inventariable = 1;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_updStockVenta1` AFTER UPDATE ON `detalle_ventas` FOR EACH ROW BEGIN
 UPDATE articulos SET stock = stock + NEW.cantidad 
 WHERE articulos.id = NEW.idarticulo
 AND articulos.inventariable = 1;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `stock` decimal(11,2) DEFAULT 0.00,
  `stock1` decimal(11,2) DEFAULT 0.00,
  `precio_proveedor` decimal(11,2) DEFAULT NULL,
  `importe` decimal(11,2) DEFAULT 0.00,
  `reingreso` decimal(11,2) DEFAULT 0.00,
  `estado` varchar(200) DEFAULT NULL,
  `tipo` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`id`, `nombre`, `stock`, `stock1`, `precio_proveedor`, `importe`, `reingreso`, `estado`, `tipo`, `created_at`, `updated_at`) VALUES
(279, 'Cubrebocas', '200.00', '0.00', '5.00', '1000.00', '0.00', 'Ingreso', 1, '2020-06-22 01:56:16', '2020-06-22 01:56:16'),
(280, 'Cubrebocas', '0.00', '30.00', '5.00', '0.00', '150.00', 'Reingreso', NULL, '2020-06-22 01:57:48', '2020-06-22 01:57:48'),
(281, 'Cubrebocas', '0.00', '42.00', '5.00', '0.00', '210.00', 'Reingreso', NULL, '2020-06-22 01:59:04', '2020-06-22 01:59:04'),
(282, 'Cubrebocas', '0.00', '32.00', '5.00', '0.00', '160.00', 'Reingreso', NULL, '2020-06-22 02:10:07', '2020-06-22 02:10:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial2`
--

CREATE TABLE `historial2` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `articulo` varchar(100) DEFAULT NULL,
  `stock` decimal(11,2) DEFAULT 0.00,
  `stock1` decimal(11,2) DEFAULT NULL,
  `existencia` decimal(11,2) DEFAULT NULL,
  `entrada1` decimal(11,2) DEFAULT NULL,
  `precio_proveedor` decimal(11,2) DEFAULT NULL,
  `saldo` decimal(11,2) DEFAULT NULL,
  `saldo1` decimal(11,2) DEFAULT 0.00,
  `salida1` decimal(11,2) DEFAULT 0.00,
  `cantidad` decimal(11,2) DEFAULT 0.00,
  `precio` decimal(11,2) DEFAULT NULL,
  `precio1` decimal(11,2) DEFAULT 0.00,
  `reingreso` decimal(11,2) DEFAULT 0.00,
  `total` decimal(11,2) DEFAULT NULL,
  `promedio` decimal(11,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `historial2`
--

INSERT INTO `historial2` (`id`, `nombre`, `articulo`, `stock`, `stock1`, `existencia`, `entrada1`, `precio_proveedor`, `saldo`, `saldo1`, `salida1`, `cantidad`, `precio`, `precio1`, `reingreso`, `total`, `promedio`, `created_at`, `updated_at`) VALUES
(419, 'Cubrebocas', NULL, '200.00', NULL, '200.00', NULL, '5.00', NULL, '1000.00', '0.00', '0.00', NULL, '5.00', '0.00', '1000.00', '5.00', '2020-06-22 01:56:16', '2020-06-22 01:56:16'),
(420, 'Cubrebocas', NULL, '0.00', NULL, '170.00', NULL, NULL, NULL, '0.00', '150.00', '30.00', NULL, '0.00', '0.00', '850.00', '5.00', '2020-06-22 01:57:01', '2020-06-22 01:57:01'),
(421, 'Cubrebocas', NULL, '0.00', NULL, '128.00', NULL, NULL, NULL, '0.00', '210.00', '42.00', NULL, '0.00', '0.00', '640.00', '5.00', '2020-06-22 01:57:28', '2020-06-22 01:57:28'),
(422, 'Cubrebocas', NULL, '30.00', NULL, '200.00', NULL, NULL, NULL, '0.00', '0.00', '0.00', NULL, '5.00', '150.00', '1000.00', '5.00', '2020-06-22 01:57:48', '2020-06-22 01:57:48'),
(423, 'Cubrebocas', NULL, '42.00', NULL, '170.00', NULL, NULL, NULL, '0.00', '0.00', '0.00', NULL, '5.00', '210.00', '850.00', '5.00', '2020-06-22 01:59:04', '2020-06-22 01:59:04'),
(424, 'Cubrebocas', NULL, '0.00', NULL, '168.00', NULL, NULL, NULL, '0.00', '160.00', '32.00', NULL, '0.00', '0.00', '840.00', '5.00', '2020-06-22 02:08:16', '2020-06-22 02:08:16'),
(425, 'Cubrebocas', NULL, '0.00', NULL, '145.00', NULL, NULL, NULL, '0.00', '115.00', '23.00', NULL, '0.00', '0.00', '725.00', '5.00', '2020-06-22 02:08:41', '2020-06-22 02:08:41'),
(426, 'Cubrebocas', NULL, '32.00', NULL, '200.00', NULL, NULL, NULL, '0.00', '0.00', '0.00', NULL, '5.00', '160.00', '1000.00', '5.00', '2020-06-22 02:10:07', '2020-06-22 02:10:07'),
(427, 'Cubrebocas', NULL, '0.00', NULL, '157.00', NULL, NULL, NULL, '0.00', '260.00', '52.00', NULL, '0.00', '0.00', '785.00', '5.00', '2020-06-22 02:11:25', '2020-06-22 02:11:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos`
--

CREATE TABLE `ingresos` (
  `id` int(10) UNSIGNED NOT NULL,
  `idproveedor` int(10) UNSIGNED NOT NULL,
  `idusuario` int(10) UNSIGNED NOT NULL,
  `tipo_comprobante` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serie_comprobante` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_hora` date NOT NULL,
  `total` decimal(11,2) NOT NULL,
  `estado` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Disparadores `ingresos`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockIngresoAnular` AFTER UPDATE ON `ingresos` FOR EACH ROW BEGIN
  UPDATE articulos a
    JOIN detalle_ingresos di
      ON di.idarticulo = a.id
     AND di.idingreso = new.id
     set a.stock = a.stock - di.cantidad;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id`, `nombre`, `direccion`, `telefono`, `email`, `created_at`, `updated_at`) VALUES
(19, 'Semillas S.A de C.V', 'Zumpango', '55589632152', NULL, '2020-06-10 22:33:17', '2020-06-10 22:33:17'),
(20, 'Portal Compaq', 'Tecamac', NULL, NULL, '2020-06-10 22:38:55', '2020-06-10 22:38:55'),
(21, 'chris', NULL, NULL, NULL, '2020-06-11 00:31:25', '2020-06-11 00:31:25'),
(22, 'mau', NULL, NULL, NULL, '2020-06-12 02:19:58', '2020-06-12 02:19:58'),
(23, 'ceci', NULL, NULL, NULL, '2020-06-12 02:52:03', '2020-06-12 02:52:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(10) UNSIGNED NOT NULL,
  `contacto` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `contacto`) VALUES
(19, 'Semillas S.A de C.V'),
(20, 'Portal Compaq');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `descripcion`, `condicion`) VALUES
(1, 'Administrador', 'Administrador del Sistema', 1),
(2, 'Vendedor', 'Vendedor Productos', 1),
(3, 'Almacenero', 'Almacenista', 1),
(4, 'Cajero', 'Cobro de Ventas', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `condicion` tinyint(1) NOT NULL DEFAULT 1,
  `idrol` int(10) UNSIGNED NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `usuario`, `password`, `condicion`, `idrol`, `remember_token`) VALUES
(1, 'admin', '$2y$10$npigKfWYb/K.O0dZSatQOeObd4nx7ZbTprISUnqHiaI/QX27NLBFm', 1, 1, 'zUgX1zw0q9DW7dKHCPz9EWha5TZCME71RshdF9hz8LkesTxgUB8FXKDiqY8Y'),
(8, 'Angel', '$2y$10$eTX2RnxhpEp.O86LnXD4ee9ZEYhb.KdznCNwCd.gmmTr/zW9CjSXe', 1, 3, 'u8TqP6qo2nrSyTakAyxPyNAqFk14hk74Y9qaA0QIvTYaAEV6IrBcZ4MjWsx3'),
(12, 'blue', '$2y$10$ZsDXiQNGtDXVTHmDIh2aEeVRWUekFl7SL.87stMXw5LFZEKy2Rn1O', 1, 2, '92FtDc1F81ufciEwUuccavIKmaUHHUe07bRDRPK3PUf2fOQ3Vx1nP3sEtXOj'),
(23, 'ceci', '$2y$10$yxrkt/b1/xg.zb1IoeyLzuF/TyE3nxBzpZp5IXPkHevFO3mTQHdfu', 1, 3, 'Zh0HoNYpteBo02G1pmm9P8tv94m843QgMuI68f2JJlEIfHMgMURGNl6Yp7SM'),
(21, 'chris', '$2y$10$xvLQw1.5XHvTJ9VH/DAXvuL4raJZGNddDKHvPVCq8WeQ74ZEXOqNK', 1, 4, 'g5znJAYAItOaQnaGEQX1LKJx7UCiW8XpszSG2tUMeOjQUYxDqwQqak4GZCuo'),
(13, 'jor', '$2y$10$w4NE5ZWBernrfT8xn4FE/OEqoZIcRnWjuE/smWzjHYEZJ/6sI6Wge', 1, 4, NULL),
(10, 'Jorge', '$2y$10$lNw/dqJ5KlEYKytSz3BFOudd9Cv0CNUFqF62DlSN0ywM94YbbFTh2', 1, 4, 'zKj4Ao7F6Wm6kP3g5EL8EtY9ZLejPYSD4L7gNCfAFqUGsv6G4dJNZpDnEw7D'),
(9, 'Martha', '$2y$10$UW./QP5m0MTCPjRXFx0sm.O/D/C42H7XbPZC/6xXXS3mYMTTFe4hW', 1, 2, 'Uspw80pVjhmWZrU2PDWlYzRTKzBbyNkLAoCxRzfwpusYDuW9W2uqbqzKLMPk'),
(22, 'mau', '$2y$10$uIAbu3/ITUB32qZkd5P35uhhFiTiTNnl1ETOxzQkD2mI/qKITFBWy', 1, 4, '7mjFxhyIYKlcENhKHGa47HQAze5nXIvHIvMP6CJge7kugCVhWGolIX1O4wCR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(10) UNSIGNED NOT NULL,
  `idcliente` int(10) UNSIGNED DEFAULT NULL,
  `idusuario` int(10) UNSIGNED NOT NULL,
  `tipo_comprobante` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_hora` date NOT NULL,
  `total` decimal(11,2) NOT NULL,
  `estado` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `efectivo` decimal(11,2) DEFAULT 0.00,
  `tarjeta` decimal(11,2) DEFAULT 0.00,
  `vales` decimal(11,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `idcliente`, `idusuario`, `tipo_comprobante`, `fecha_hora`, `total`, `estado`, `created_at`, `updated_at`, `efectivo`, `tarjeta`, `vales`) VALUES
(151, 21, 12, 'TICKET', '2020-06-21', '255.00', 'Venta Registrada', '2020-06-22 01:57:01', '2020-06-22 01:57:01', '0.00', '0.00', '0.00'),
(152, 23, 12, 'TICKET', '2020-06-21', '357.00', 'Venta Cancelada', '2020-06-22 01:57:28', '2020-06-22 01:59:04', '0.00', '0.00', '0.00'),
(153, 21, 12, 'TICKET', '2020-06-21', '272.00', 'Venta Cancelada', '2020-06-22 02:08:16', '2020-06-22 02:10:07', '0.00', '0.00', '0.00'),
(154, 20, 12, 'TICKET', '2020-06-21', '195.50', 'Venta Registrada', '2020-06-22 02:08:41', '2020-06-22 02:08:41', '0.00', '0.00', '0.00'),
(155, 20, 12, 'TICKET', '2020-06-21', '442.00', 'Venta Registrada', '2020-06-22 02:11:25', '2020-06-22 02:11:25', '0.00', '0.00', '0.00');

--
-- Disparadores `ventas`
--
DELIMITER $$
CREATE TRIGGER `tr_updStockVentaAnular` AFTER UPDATE ON `ventas` FOR EACH ROW BEGIN
  UPDATE articulos a
    JOIN detalle_ventas dv
      ON dv.idarticulo = a.id
     AND dv.idventa= new.id
     set a.stock = a.stock + dv.cantidad;
end
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `articulos_idcategoria_foreign` (`idcategoria`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_ingresos`
--
ALTER TABLE `detalle_ingresos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_ingresos_idingreso_foreign` (`idingreso`),
  ADD KEY `detalle_ingresos_idarticulo_foreign` (`idarticulo`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_ventas_idventa_foreign` (`idventa`),
  ADD KEY `detalle_ventas_idarticulo_foreign` (`idarticulo`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historial2`
--
ALTER TABLE `historial2`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ingresos_idproveedor_foreign` (`idproveedor`),
  ADD KEY `ingresos_idusuario_foreign` (`idusuario`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personas_nombre_unique` (`nombre`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD KEY `proveedores_id_foreign` (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_nombre_unique` (`nombre`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `users_usuario_unique` (`usuario`),
  ADD KEY `users_id_foreign` (`id`),
  ADD KEY `users_idrol_foreign` (`idrol`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ventas_idcliente_foreign` (`idcliente`),
  ADD KEY `ventas_idusuario_foreign` (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `detalle_ingresos`
--
ALTER TABLE `detalle_ingresos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=283;

--
-- AUTO_INCREMENT de la tabla `historial2`
--
ALTER TABLE `historial2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=428;

--
-- AUTO_INCREMENT de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD CONSTRAINT `articulos_idcategoria_foreign` FOREIGN KEY (`idcategoria`) REFERENCES `categorias` (`id`);

--
-- Filtros para la tabla `detalle_ingresos`
--
ALTER TABLE `detalle_ingresos`
  ADD CONSTRAINT `detalle_ingresos_idarticulo_foreign` FOREIGN KEY (`idarticulo`) REFERENCES `articulos` (`id`),
  ADD CONSTRAINT `detalle_ingresos_idingreso_foreign` FOREIGN KEY (`idingreso`) REFERENCES `ingresos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `detalle_ventas_idarticulo_foreign` FOREIGN KEY (`idarticulo`) REFERENCES `articulos` (`id`),
  ADD CONSTRAINT `detalle_ventas_idventa_foreign` FOREIGN KEY (`idventa`) REFERENCES `ventas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ingresos`
--
ALTER TABLE `ingresos`
  ADD CONSTRAINT `ingresos_idproveedor_foreign` FOREIGN KEY (`idproveedor`) REFERENCES `proveedores` (`id`),
  ADD CONSTRAINT `ingresos_idusuario_foreign` FOREIGN KEY (`idusuario`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD CONSTRAINT `proveedores_id_foreign` FOREIGN KEY (`id`) REFERENCES `personas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_idrol_foreign` FOREIGN KEY (`idrol`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_idcliente_foreign` FOREIGN KEY (`idcliente`) REFERENCES `personas` (`id`),
  ADD CONSTRAINT `ventas_idusuario_foreign` FOREIGN KEY (`idusuario`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
