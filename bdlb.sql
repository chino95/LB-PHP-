-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-10-2017 a las 05:31:52
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdlb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aservicio`
--

CREATE TABLE `aservicio` (
  `ID_AServicio` int(11) NOT NULL,
  `ID_Servicio` int(11) NOT NULL,
  `ID_Empleado` int(11) NOT NULL,
  `ID_Vehiculo` int(11) NOT NULL,
  `Precio` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `aservicio`
--

INSERT INTO `aservicio` (`ID_AServicio`, `ID_Servicio`, `ID_Empleado`, `ID_Vehiculo`, `Precio`) VALUES
(1, 1, 1, 1, 450);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `ID_Cliente` int(11) NOT NULL,
  `ID_Cuenta` int(11) NOT NULL,
  `Nombre_contacto` text NOT NULL,
  `Nombre_empresa` text NOT NULL,
  `Direccion` text NOT NULL,
  `Telefono` text NOT NULL,
  `Num_Ctpat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`ID_Cliente`, `ID_Cuenta`, `Nombre_contacto`, `Nombre_empresa`, `Direccion`, `Telefono`, `Num_Ctpat`) VALUES
(1, 3, 'Karla Fierro', 'Avent', 'Periferico', '6313140277', 0),
(2, 4, 'Juan Lopez', 'Chamberlain', 'Periferico #409', '3158533', 594622);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas`
--

CREATE TABLE `cuentas` (
  `ID_Cuenta` int(11) NOT NULL,
  `Correo` text NOT NULL,
  `Psw` text NOT NULL,
  `Nivel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cuentas`
--

INSERT INTO `cuentas` (`ID_Cuenta`, `Correo`, `Psw`, `Nivel`) VALUES
(1, '1@1', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 1),
(2, '2@2', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 1),
(3, 'c@c', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 0),
(4, 'cliente@cliente.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `ID_Empleados` int(11) NOT NULL,
  `Nombre` text NOT NULL,
  `Appat` text NOT NULL,
  `Direccion` text NOT NULL,
  `Telefono` text NOT NULL,
  `Licencia` text NOT NULL,
  `Num_Licencia` text NOT NULL,
  `Tipo_Licencia` text NOT NULL,
  `Num_Visa` text NOT NULL,
  `IFE` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`ID_Empleados`, `Nombre`, `Appat`, `Direccion`, `Telefono`, `Licencia`, `Num_Licencia`, `Tipo_Licencia`, `Num_Visa`, `IFE`) VALUES
(1, 'Mario', 'Lopez', 'Nuevo nogales', '6312547852', 'Si', '123456', 'Mexicana', '000000', '000000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sservicio`
--

CREATE TABLE `sservicio` (
  `ID_Servicio` int(11) NOT NULL,
  `ID_TipoServicio` int(11) NOT NULL,
  `ID_Cliente` int(11) NOT NULL,
  `Fecha` text NOT NULL,
  `Hora` text NOT NULL,
  `Foraneo` int(11) NOT NULL,
  `Tipo_Carga` text NOT NULL,
  `Origen` text NOT NULL,
  `Destino` text NOT NULL,
  `Peso` int(11) NOT NULL,
  `PesoM` text NOT NULL,
  `Bultos` int(11) NOT NULL,
  `BultosM` text NOT NULL,
  `Comentarios` text NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sservicio`
--

INSERT INTO `sservicio` (`ID_Servicio`, `ID_TipoServicio`, `ID_Cliente`, `Fecha`, `Hora`, `Foraneo`, `Tipo_Carga`, `Origen`, `Destino`, `Peso`, `PesoM`, `Bultos`, `BultosM`, `Comentarios`, `status`) VALUES
(1, 1, 1, '2017-10-23', '17:45', 1, 'Quimico', 'a', 'b', 10, 'Kg', 5, 'Cubeta', 'c', 'Aceptado'),
(2, 2, 1, '2017-10-31', '12:34', 0, 'Inbond', 's', 'd', 5, 'Lbs', 4, 'Tambo', 'c', 'solicitado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tservicio`
--

CREATE TABLE `tservicio` (
  `ID_TipoServicio` int(11) NOT NULL,
  `Tipo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tservicio`
--

INSERT INTO `tservicio` (`ID_TipoServicio`, `Tipo`) VALUES
(1, 'Importacion'),
(2, 'Exportacion'),
(3, 'Almacen - Almacen'),
(4, 'Rampa - Patio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `updateservicio`
--

CREATE TABLE `updateservicio` (
  `ID_UpdateS` int(11) NOT NULL,
  `ID_Servicio` int(11) NOT NULL,
  `Status` text NOT NULL,
  `Fecha` text NOT NULL,
  `Ubicacion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `updateservicio`
--

INSERT INTO `updateservicio` (`ID_UpdateS`, `ID_Servicio`, `Status`, `Fecha`, `Ubicacion`) VALUES
(1, 1, 'En recinto fiscal', '2017/10/23', 'asdasd.com'),
(2, 1, '21', '2017/10/23', 'asd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID_Usuario` int(11) NOT NULL,
  `ID_Cuenta` int(11) NOT NULL,
  `Nombre` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID_Usuario`, `ID_Cuenta`, `Nombre`) VALUES
(1, 1, 'Ivan ZuÃ±iga'),
(2, 2, 'Juan ZuÃ±iga');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `ID_Vehiculo` int(11) NOT NULL,
  `Marca` text NOT NULL,
  `Modelo` text NOT NULL,
  `Serie` text NOT NULL,
  `Tipo` text NOT NULL,
  `Placa_Mex` text NOT NULL,
  `Placa_Usa` text NOT NULL,
  `Clave_Vehiculo` text NOT NULL,
  `Numero_Economico` text NOT NULL,
  `Capacidad_Carga` text NOT NULL,
  `Capacidad_Volumen` text NOT NULL,
  `Medidas` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`ID_Vehiculo`, `Marca`, `Modelo`, `Serie`, `Tipo`, `Placa_Mex`, `Placa_Usa`, `Clave_Vehiculo`, `Numero_Economico`, `Capacidad_Carga`, `Capacidad_Volumen`, `Medidas`) VALUES
(1, 'Ford', 'F150', '00000', 'Pick-Up', '0000000000', '00000000000', '000000000', '00000000', '0000', '0000', '0000');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aservicio`
--
ALTER TABLE `aservicio`
  ADD PRIMARY KEY (`ID_AServicio`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`ID_Cliente`);

--
-- Indices de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  ADD PRIMARY KEY (`ID_Cuenta`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`ID_Empleados`);

--
-- Indices de la tabla `sservicio`
--
ALTER TABLE `sservicio`
  ADD PRIMARY KEY (`ID_Servicio`);

--
-- Indices de la tabla `tservicio`
--
ALTER TABLE `tservicio`
  ADD PRIMARY KEY (`ID_TipoServicio`);

--
-- Indices de la tabla `updateservicio`
--
ALTER TABLE `updateservicio`
  ADD PRIMARY KEY (`ID_UpdateS`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID_Usuario`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`ID_Vehiculo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aservicio`
--
ALTER TABLE `aservicio`
  MODIFY `ID_AServicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `ID_Cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  MODIFY `ID_Cuenta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `ID_Empleados` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `sservicio`
--
ALTER TABLE `sservicio`
  MODIFY `ID_Servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `tservicio`
--
ALTER TABLE `tservicio`
  MODIFY `ID_TipoServicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `updateservicio`
--
ALTER TABLE `updateservicio`
  MODIFY `ID_UpdateS` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID_Usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `ID_Vehiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
