-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 09-11-2024 a las 04:57:19
-- Versión del servidor: 5.7.36
-- Versión de PHP: 8.1.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `store_sv`
--
CREATE DATABASE IF NOT EXISTS `kptura` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `kptura`;

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `ContarRegistros` (IN `consulta` TEXT, OUT `cantidad` INT)   BEGIN
    -- Preparar la consulta dinámica
    SET @sql = CONCAT('SELECT COUNT(*) INTO @count FROM (', consulta, ') AS subconsulta');
    -- Ejecutar la consulta
    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
    -- Asignar el resultado a la variable de salida
    SET cantidad = @count;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CRUD` (IN `in_tabla` TEXT, IN `in_campos` TEXT, IN `in_val_cond` TEXT, IN `in_campo` TEXT, IN `in_valor` TEXT, IN `accion` VARCHAR(3), OUT `resultado` INT)   BEGIN
    -- Crear la condición dinámica para las consultas
    SET @condicion = CONCAT(in_campo, "='", in_valor, "'");
    -- Inicializar el resultado en 0
    SET resultado = 0;
    -- Validación para la acción INSERT
    IF accion = 'I' OR accion = 'i' THEN
        -- Verificar si el dato ya existe en la tabla
        SET @proceso = CONCAT('SELECT COUNT(*) INTO @v_count FROM ', in_tabla, ' WHERE ', @condicion);
        -- Preparar la consulta para verificar si el dato ya existe
        PREPARE stmt_count FROM @proceso;
        -- Ejecutar la consulta preparada
        EXECUTE stmt_count;
        -- Liberar los recursos de la consulta preparada
        DEALLOCATE PREPARE stmt_count;
        -- Si existe un registro con ese valor
        IF @v_count > 0 THEN
            -- Establecer resultado como 3 para indicar dato duplicado
            SET resultado = 3;
        ELSE
            -- Ejecutar la consulta de inserción
            SET @queryI = CONCAT('INSERT INTO ', in_tabla, ' (', in_campos, ') VALUES(', in_val_cond, ')');
            -- Preparar la consulta de inserción
            PREPARE stmt_insert FROM @queryI;
            -- Ejecutar la consulta preparada
            EXECUTE stmt_insert;
            -- Liberar los recursos de la consulta preparada
            DEALLOCATE PREPARE stmt_insert;
            -- Establecer resultado como 1 para indicar inserción exitosa
            SET resultado = 1;
        END IF;
    -- Validación para la acción INSERT sin busqueda previa
    ELSEIF accion = 'ISB' OR accion = 'isb' THEN
        -- Ejecutar la consulta de inserción
        SET @queryI = CONCAT('INSERT INTO ', in_tabla, ' (', in_campos, ') VALUES(', in_val_cond, ')');
        -- Preparar la consulta de inserción
        PREPARE stmt_insert FROM @queryI;
        -- Ejecutar la consulta preparada
        EXECUTE stmt_insert;
        -- Liberar los recursos de la consulta preparada
        DEALLOCATE PREPARE stmt_insert;
        -- Establecer resultado como 1 para indicar inserción exitosa
        SET resultado = 1;
    -- Validación para la acción SELECT
    ELSEIF accion = 'S' || accion = 's' THEN
        -- Crear la consulta de selección
        SET @queryS = CONCAT('SELECT ', in_campos, ' FROM ', in_tabla);
        -- Preparar la consulta de selección
        PREPARE stmt_select FROM @queryS;
        -- Ejecutar la consulta preparada
        EXECUTE stmt_select;
        -- Liberar los recursos de la consulta preparada
        DEALLOCATE PREPARE stmt_select;
        -- No se establece resultado porque el resultado de la consulta se envía al cliente directamente
    
    -- Validación para la acción SELECT con Condición
    ELSEIF accion = 'SC' OR accion = 'sc' THEN
        -- Crear la consulta de selección con condición
        SET @queryS = CONCAT('SELECT ', in_campos, ' FROM ', in_tabla, ' WHERE ', in_val_cond);
        -- Preparar la consulta de selección con condición
        PREPARE stmt_select_cond FROM @queryS;
        -- Ejecutar la consulta preparada
        EXECUTE stmt_select_cond;
        -- Liberar los recursos de la consulta preparada
        DEALLOCATE PREPARE stmt_select_cond;
        -- No se establece resultado porque el resultado de la consulta se envía al cliente directamente
    -- Validación para la acción UPDATE
    ELSEIF accion = 'U' OR accion = 'u' THEN
        -- Crear la consulta de actualización
        SET @queryU = CONCAT('UPDATE ', in_tabla, ' SET ', in_campos, ' WHERE ', in_val_cond);
        -- Preparar la consulta de actualización
        PREPARE stmt_update FROM @queryU;
        -- Ejecutar la consulta preparada
        EXECUTE stmt_update;
        -- Liberar los recursos de la consulta preparada
        DEALLOCATE PREPARE stmt_update;
        -- Establecer resultado como 1 para indicar actualización exitosa
        SET resultado = 1;
    -- Validación para la acción DELETE
    ELSEIF accion = 'D' OR accion = 'd' THEN
        -- Crear la consulta de eliminación
        SET @queryD = CONCAT('DELETE FROM ', in_tabla, ' WHERE ', in_val_cond);
        -- Preparar la consulta de eliminación
        PREPARE stmt_delete FROM @queryD;
        -- Ejecutar la consulta preparada
        EXECUTE stmt_delete;
        -- Liberar los recursos de la consulta preparada
        DEALLOCATE PREPARE stmt_delete;
        -- Establecer resultado como 1 para indicar eliminación exitosa
        SET resultado = 1;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerCampo` (IN `in_tabla` VARCHAR(64), IN `in_campo` VARCHAR(64), IN `in_condicion` TEXT, OUT `out_resultado` VARCHAR(255))   BEGIN
    -- Construir la consulta dinámica para obtener el campo solicitado
    SET @sql = CONCAT('SELECT ', in_campo, ' INTO @resultado FROM ', in_tabla, ' WHERE ', in_condicion, ' LIMIT 1');
    -- Preparar y ejecutar la consulta
    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
    -- Asignar el resultado al parámetro de salida
    SET out_resultado = @resultado;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerUltimoID` (IN `nombreTabla` VARCHAR(255), IN `idvalor` VARCHAR(50), OUT `ultimoID` INT)   BEGIN
    SET @sql = CONCAT('SELECT MAX(',idvalor,') INTO @resultado FROM ', nombreTabla);
    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
    SET ultimoID = @resultado;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `id` int(11) NOT NULL,
  `tabla` varchar(50) NOT NULL,
  `accion` varchar(50) NOT NULL,
  `valores_old` text,
  `valores_new` text,
  `fecha` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`id`, `tabla`, `accion`, `valores_old`, `valores_new`, `fecha`) VALUES
(1, 'categorias', 'DELETE', 'IdCategoria: 15, Categoria: Flores, Estado: 1', '', '2024-11-03 08:45:41'),
(4, 'categorias', 'DELETE', 'IdCategoria: 16, Categoria: Flores, Estado: 1', '', '2024-11-03 09:28:55'),
(5, 'categorias', 'DELETE', 'IdCategoria: 17, Categoria: Flores, Estado: 1', '', '2024-11-03 09:28:55'),
(6, 'categorias', 'INSERT', '', 'Categoria: Flores, Estado: 1', '2024-11-03 09:29:14'),
(7, 'categorias', 'INSERT', '', 'Categoria: hgjhgiukj, Estado: 1', '2024-11-03 09:29:47'),
(8, 'categorias', 'DELETE', 'IdCategoria: 19, Categoria: hgjhgiukj, Estado: 1', '', '2024-11-03 09:30:15'),
(9, 'categorias', 'INSERT', '', 'Categoria: Consolas Video Juegos, Estado: 1', '2024-11-06 11:38:06'),
(10, 'categorias', 'INSERT', '', 'Categoria: Consolas Video Juegos, Estado: 1', '2024-11-06 11:38:06'),
(11, 'categorias', 'DELETE', 'IdCategoria: 20, Categoria: Consolas Video Juegos, Estado: 1', '', '2024-11-06 11:38:14'),
(12, 'categorias', 'INSERT', '', 'Categoria: Hardware, Estado: 1', '2024-11-06 11:43:35'),
(13, 'categorias', 'INSERT', '', 'Categoria: Laptop, Estado: 1', '2024-11-06 11:46:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `idcarrito` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idproducto` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`idcarrito`, `idusuario`, `idproducto`, `cantidad`, `total`, `estado`) VALUES
(1, 23, 2, 2, 69.90, 2),
(2, 23, 4, 2, 159.90, 2),
(3, 23, 8, 2, 119.90, 2),
(6, 23, 1, 1, 69.00, 2),
(10, 23, 6, 1, 199.00, 2),
(11, 23, 7, 1, 249.00, 2),
(12, 23, 3, 1, 699.00, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `idcategoria` int(11) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `estado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`idcategoria`, `categoria`, `estado`) VALUES
(1, 'Tecnología', 1),
(2, 'Electrónica', 1),
(3, 'Computadoras', 1),
(4, 'Smartphones', 1),
(5, 'Accesorios Tecnológicos', 1),
(6, 'Ropa', 1),
(7, 'Calzado', 1),
(8, 'Ropa Deportiva', 1),
(9, 'Accesorios de Moda', 1),
(10, 'Joyería', 1),
(11, 'Carros', 1),
(12, 'Motos', 1),
(13, 'Repuestos Automotrices', 1),
(14, 'Accesorios para Carros', 1),
(18, 'Flores', 1),
(19, 'Consolas Video Juegos', 1),
(21, 'Hardware', 1),
(22, 'Laptop', 1);

--
-- Disparadores `categorias`
--
DELIMITER $$
CREATE TRIGGER `bitacora_categorias_D` AFTER DELETE ON `categorias` FOR EACH ROW BEGIN
    INSERT INTO bitacora (tabla,accion,valores_old,valores_new) VALUES(
        'categorias','DELETE',
        CONCAT('IdCategoria: ',OLD.idcategoria,', Categoria: ', OLD.categoria, ', Estado: ', OLD.estado),''
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `bitacora_categorias_I` AFTER INSERT ON `categorias` FOR EACH ROW BEGIN
    INSERT INTO bitacora (tabla,accion,valores_old,valores_new) VALUES(
        'categorias','INSERT',
        '',
        CONCAT('Categoria: ', NEW.categoria, ', Estado: ', NEW.estado)
    );
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `bitacora_categorias_U` AFTER UPDATE ON `categorias` FOR EACH ROW BEGIN
    INSERT INTO bitacora (tabla,accion,valores_old,valores_new) VALUES(
        'categorias','UPDATE',
        CONCAT('Categoria: ', OLD.categoria, ', Estado: ', OLD.estado),
        CONCAT('Categoria: ', NEW.categoria, ', Estado: ', NEW.estado)
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `idcliente` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `telefono` varchar(9) NOT NULL,
  `direccion` text,
  `dui` varchar(10) NOT NULL,
  `idusuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`idcliente`, `nombre`, `apellido`, `telefono`, `direccion`, `dui`, `idusuario`) VALUES
(1, 'Rigoberto Israel', 'Orellana Orellana', '1234-5678', 'San Salvador', '0', 23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idproducto` int(11) NOT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `detalle` text NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `idproveedor` int(11) DEFAULT NULL,
  `idcategoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idproducto`, `imagen`, `nombre`, `detalle`, `precio`, `stock`, `idproveedor`, `idcategoria`) VALUES
(1, '1.gif', 'Teclado usb logitech prodigy', 'Teclado usb logitech prodigy g213 rgb 920-008084', 69.00, 17, 16, 21),
(2, '2.jpg', 'Disco solido ssd msi', 'Disco solido ssd msi spatium s270 240gb sata 2.5p', 34.95, 86, 16, 21),
(3, '3.jpg', 'Playstation 5 Slim', 'Consola sony playstation 5 slim con lector de disco 1tb hdr 4k 8k', 699.00, 23, 16, 19),
(4, '4.jpg', 'Memoria ram laptop ddr5 kingston fury impact', 'Memoria ram ddr5 kingston fury impact 16gb 5600mt/s kf556s40ib-16 laptop', 79.95, 91, 16, 21),
(5, '5.jpg', 'Laptop acer nitro 5 an515-58-57wz', 'Laptop acer nitro 5 an515-58-57wz intel core i5-12450h ram 8gb almacenamiento ssd 512gb rtx3050 4gb pantalla 15.6p fhd ips 144hz w11hsl wifi ax+bt negro', 999.00, 148, 16, 22),
(6, '6.jpg', 'Tarjeta de video msi ventus xs gtx1650 4gb', 'Tarjeta de video msi ventus xs gtx1650 4gb gddr6 oc v3 edition', 199.00, 23, 16, 21),
(7, '7.jpg', 'Procesador amd ryzen 5 8400f', 'Procesador amd ryzen 5 8400f 6c/12t 4.2-4.7ghz 22m am5 requiere gpu', 249.00, 149, 1, 21),
(8, '8.jpg', 'Smartwatch xiaomi redmi watch 5 lite negro', 'Smartwatch xiaomi redmi watch 5 lite negro pantalla amoled 1.96p 57765 5atm', 59.95, 96, 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `idproveedor` int(11) NOT NULL,
  `proveedor` varchar(255) NOT NULL,
  `contacto` varchar(100) NOT NULL,
  `direccion` text NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `email` text,
  `estado` int(11) DEFAULT NULL,
  `tipo` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`idproveedor`, `proveedor`, `contacto`, `direccion`, `telefono`, `email`, `estado`, `tipo`) VALUES
(1, 'Tecnología Innovadora SA', 'Luis González', 'Av. Reforma #123, San Salvador, El Salvador', '50321234567', 'contacto@tecnologiainnovadora.com', 1, 'Nacional'),
(2, 'DataWare Solutions', 'Marta Castillo', 'Calle Principal #45, Santa Ana, El Salvador', '50322223344', 'marta@dataware.com', 1, 'Nacional'),
(3, 'GlobalTech Inc.', 'Michael Cooper', '789 King St, New York, USA', '18004567890', 'michael@globaltech.com', 1, 'Internacional'),
(4, 'Servicios Digitales', 'Roberto Martínez', 'Blvd. del Ejército, Soyapango, El Salvador', '50322123456', 'info@serviciosdigitales.com', 1, 'Nacional'),
(5, 'NetWorld Ltd.', 'Sofia Turner', '20 Bay Street, Toronto, Canada', '14165551234', 'contact@networld.ca', 1, 'Internacional'),
(6, 'Soluciones IT SA', 'Carlos Ramos', 'Colonia Escalón, San Salvador, El Salvador', '50323456789', 'carlos@solucionesit.com', 1, 'Nacional'),
(7, 'SoftWare Global', 'Alice Brown', '123 Silicon Ave, San Jose, USA', '18005551234', 'alice@swglobal.com', 1, 'Internacional'),
(8, 'Electronicos del Sur', 'Juan Pérez', 'Centro de San Miguel, San Miguel, El Salvador', '50322227788', 'jp@electronicosdelsur.com', 1, 'Nacional'),
(9, 'TechWorld Pte Ltd', 'Chen Wei', '15 Orchard Rd, Singapore', '6581234567', 'chen@techworld.sg', 1, 'Internacional'),
(10, 'Innovación y Soluciones', 'Sergio Sánchez', 'Calle La Mascota, San Salvador, El Salvador', '50323344556', 'sergio@innovacion.com', 1, 'Nacional'),
(11, 'DigitalEdge Ltd.', 'Amina Yusuf', '12 Ahmed St, Lagos, Nigeria', '234123456789', 'amina@digitaledge.ng', 1, 'Internacional'),
(12, 'NetSolutions', 'María Castro', 'Barrio La Vega, Santa Tecla, El Salvador', '50324567890', 'mcastro@netsolutions.com', 1, 'Nacional'),
(13, 'IT Hub Europe', 'Hans Meier', 'Hauptstrasse 5, Berlin, Germany', '49301234567', 'hans@ithub.de', 1, 'Internacional'),
(14, 'Smart Tech SA', 'Raúl Romero', 'Zona Rosa, San Salvador, El Salvador', '50321211234', 'raul@smarttech.com', 1, 'Nacional'),
(15, 'AsiaLink Tech', 'Yuki Tanaka', '2-4-5 Shibuya, Tokyo, Japan', '81312345678', 'yuki@asialink.jp', 1, 'Internacional'),
(16, 'Zona Digital', 'Erick López', 'Colonia Escalón, San Salvador, El Salvador', '50322123456', 'erick@zonadigital.com', 1, 'Nacional'),
(17, 'Aeon Solutions', 'María Hernández', 'Blvd. Los Próceres, San Salvador, El Salvador', '50322334455', 'maria@aeonsolutions.com', 1, 'Nacional'),
(18, 'STB Tecnología', 'Oscar Torres', 'Centro Comercial Metrocentro, San Salvador, El Salvador', '50322445566', 'oscar@stbtecnologia.com', 1, 'Nacional');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idrol` int(11) NOT NULL,
  `rol` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idrol`, `rol`) VALUES
(1, 'Administrador'),
(2, 'Empleados'),
(3, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticket`
--

CREATE TABLE `ticket` (
  `idticket` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idcarrito` varchar(255) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ticket`
--

INSERT INTO `ticket` (`idticket`, `idusuario`, `idcarrito`, `estado`, `fecha`) VALUES
(1, 23, '1, 2, 3', 2, '2024-11-06 21:27:24'),
(2, 23, '6', 2, '2024-11-06 22:00:55'),
(3, 23, '10, 11', 2, '2024-11-07 07:20:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `clave` text NOT NULL,
  `estado` int(11) NOT NULL,
  `tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `usuario`, `clave`, `estado`, `tipo`) VALUES
(1, 'admin', '$2y$10$Smll0Ut0dnrpdI.qH/Xow.FPk2HFQXf.LvRRxLpoWbL6M/de27Cpm', 1, 1),
(23, 'rigorellana', '$2y$10$9K57/8bvPwsKlkxF9iG7puuSysMYTKxskddWWnLz6P6l0kqqH3VqK', 1, 3),
(24, 'cliente', '$2y$10$B9af7TS060oEoMDOuYF7EeoBOiI7xmICgqrftY5SAiB/8h1co2DzW', 1, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`idcarrito`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idcategoria`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idcliente`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idproducto`),
  ADD KEY `idproveedor` (`idproveedor`),
  ADD KEY `idcategoria` (`idcategoria`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`idproveedor`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`idticket`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `idcarrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `idproveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ticket`
--
ALTER TABLE `ticket`
  MODIFY `idticket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`idproveedor`) REFERENCES `proveedores` (`idproveedor`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`idcategoria`) REFERENCES `categorias` (`idcategoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
