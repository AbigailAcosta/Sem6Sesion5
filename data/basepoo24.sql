--
-- Base de datos: `basepoo24`
--
CREATE DATABASE IF NOT EXISTS `basepoo24` DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci;

USE `basepoo24`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
    `idArticulo` int(11) NOT NULL,
    `descripcion` varchar(65) NOT NULL,
    `precioventa` float NOT NULL,
    `preciocompra` float NOT NULL,
    `idRubro` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
    `numero` varchar(15) NOT NULL,
    `fecha` date NOT NULL,
    `estado` int(11) NOT NULL,
    `idUsuario` int(11) NOT NULL,
    `idPersona` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallecompras`
--

CREATE TABLE `detallecompras` (
    `numero` varchar(15) NOT NULL,
    `idArticulo` int(11) NOT NULL,
    `preciocompra` float NOT NULL,
    `cantidad` float NOT NULL,
    `impuesto` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleventas`
--

CREATE TABLE `detalleventas` (
    `numero` int(11) NOT NULL,
    `idArticulo` int(11) NOT NULL,
    `precioventa` float NOT NULL,
    `cantidad` float NOT NULL,
    `impuesto` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
    `idPersona` int(11) NOT NULL,
    `razonsocial` varchar(45) NOT NULL,
    `ciruc` varchar(15) NOT NULL,
    `domicilio` varchar(65) DEFAULT NULL,
    `telefono` varchar(15) DEFAULT NULL,
    `tipo` smallint(6) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO
    `personas` (
        `idPersona`,
        `razonsocial`,
        `ciruc`,
        `domicilio`,
        `telefono`,
        `tipo`
    )
VALUES (
        1,
        'Cliente genérico',
        '999',
        'x',
        'x',
        1
    ),
    (
        2,
        'Proveedor genérico',
        '8000',
        'x',
        'x',
        2
    ),
    (
        3,
        'Cliente-Proveedor genérico',
        '8888',
        'x',
        'x',
        3
    ),
    (
        4,
        'JUAN GONZALEZ',
        '489652',
        'CAAGUAZU',
        '0981981981',
        1
    ),
    (
        5,
        'SORIANA VARGAS',
        '4789632',
        'ASUNCIÓN',
        '0991991991',
        2
    ),
    (
        6,
        'TRES FRONTERAS S.A.',
        '800489563-8',
        'CIUDAD DEL ESTE',
        '0983983983',
        3
    );

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rubros`
--

CREATE TABLE `rubros` (
    `idRubro` int(11) NOT NULL,
    `nombre` varchar(45) NOT NULL,
    `impuesto` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
    `idUsuario` int(11) NOT NULL,
    `nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    `clave` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO
    `usuarios` (
        `idUsuario`,
        `nombre`,
        `clave`
    )
VALUES (
        1,
        'admin',
        '$2y$10$wk8ZZanTdZsNxGV9h84Z.OGCCvqPX0Vo/RvYKz8bDBNgNngLPQrli'
    ),
    (
        2,
        'sales',
        '$2y$10$MXStfzYebbMXpV9nnJUfPeHtvrFqlJhf9qZCLrIxFqGzo.xD0jh.u'
    );

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vcompras`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vcompras` (
    `numero_compra` varchar(15),
    `fecha_compra` date,
    `razon_social` varchar(45),
    `estado` varchar(8),
    `nombre_usuario` varchar(45),
    `idUsuario` int(11),
    `idPersona` int(11)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
    `numero` int(11) NOT NULL,
    `fecha` date NOT NULL,
    `condicion` smallint(6) NOT NULL,
    `anulado` smallint(6) NOT NULL,
    `idUsuario` int(11) NOT NULL,
    `idPersona` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vventas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vventas` (
    `numero_venta` int(11),
    `fecha_venta` date,
    `razon_social` varchar(45),
    `condicion` varchar(7),
    `nombre_usuario` varchar(45),
    `idUsuario` int(11),
    `idPersona` int(11),
    `anulado` smallint(6)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vcompras`
--
DROP TABLE IF EXISTS `vcompras`;

CREATE ALGORITHM = UNDEFINED DEFINER = `root` @`localhost` SQL SECURITY DEFINER VIEW `vcompras` AS
SELECT
    `c`.`numero` AS `numero_compra`,
    `c`.`fecha` AS `fecha_compra`,
    `p`.`razonsocial` AS `razon_social`,
    if(
        `c`.`estado` = 1,
        'Activo',
        'Inactivo'
    ) AS `estado`,
    `u`.`nombre` AS `nombre_usuario`,
    `c`.`idUsuario` AS `idUsuario`,
    `c`.`idPersona` AS `idPersona`
FROM (
        (
            `compras` `c`
            join `personas` `p`
        )
        join `usuarios` `u`
    )
WHERE
    `c`.`idPersona` = `p`.`idPersona`
    AND `u`.`idUsuario` = `c`.`idUsuario`;

-- --------------------------------------------------------

--
-- Estructura para la vista `vventas`
--
DROP TABLE IF EXISTS `vventas`;

CREATE ALGORITHM = UNDEFINED DEFINER = `root` @`localhost` SQL SECURITY DEFINER VIEW `vventas` AS
SELECT
    `v`.`numero` AS `numero_venta`,
    `v`.`fecha` AS `fecha_venta`,
    `p`.`razonsocial` AS `razon_social`,
    if(
        `v`.`condicion` = 1,
        'Contado',
        'Crédito'
    ) AS `condicion`,
    `u`.`nombre` AS `nombre_usuario`,
    `v`.`idUsuario` AS `idUsuario`,
    `v`.`idPersona` AS `idPersona`,
    `v`.`anulado` AS `anulado`
FROM (
        (
            `ventas` `v`
            join `personas` `p`
        )
        join `usuarios` `u`
    )
WHERE
    `v`.`idPersona` = `p`.`idPersona`
    AND `u`.`idUsuario` = `v`.`idUsuario`;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
ADD PRIMARY KEY (`idArticulo`),
ADD KEY `idRubro` (`idRubro`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
ADD PRIMARY KEY (`numero`),
ADD KEY `fk_ventas_usuarios1_idx` (`idUsuario`),
ADD KEY `fk_compras_personas1_idx` (`idPersona`);

--
-- Indices de la tabla `detallecompras`
--
ALTER TABLE `detallecompras`
ADD PRIMARY KEY (`numero`, `idArticulo`),
ADD KEY `fk_detalleventas_articulos1_idx` (`idArticulo`),
ADD KEY `fk_detallecompras_compras1_idx` (`numero`);

--
-- Indices de la tabla `detalleventas`
--
ALTER TABLE `detalleventas`
ADD PRIMARY KEY (`numero`, `idArticulo`),
ADD KEY `fk_detalleventas_articulos1_idx` (`idArticulo`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
ADD PRIMARY KEY (`idPersona`),
ADD UNIQUE KEY `ciruc_UNIQUE` (`ciruc`);

--
-- Indices de la tabla `rubros`
--
ALTER TABLE `rubros`
ADD PRIMARY KEY (`idRubro`),
ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
ADD PRIMARY KEY (`idUsuario`),
ADD UNIQUE KEY `usuario` (`nombre`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
ADD PRIMARY KEY (`numero`),
ADD KEY `fk_ventas_usuarios1_idx` (`idUsuario`),
ADD KEY `fk_ventas_personas1_idx` (`idPersona`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `articulos`
--
ALTER TABLE `articulos`
MODIFY `idArticulo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
MODIFY `idPersona` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 7;

--
-- AUTO_INCREMENT de la tabla `rubros`
--
ALTER TABLE `rubros`
MODIFY `idRubro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
AUTO_INCREMENT = 3;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas` MODIFY `numero` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `articulos`
--
ALTER TABLE `articulos`
ADD CONSTRAINT `articulos_ibfk_1` FOREIGN KEY (`idRubro`) REFERENCES `rubros` (`idRubro`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
ADD CONSTRAINT `fk_compras_personas1` FOREIGN KEY (`idPersona`) REFERENCES `personas` (`idPersona`) ON UPDATE CASCADE,
ADD CONSTRAINT `fk_ventas_usuarios10` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `detallecompras`
--
ALTER TABLE `detallecompras`
ADD CONSTRAINT `fk_detallecompras_compras1` FOREIGN KEY (`numero`) REFERENCES `compras` (`numero`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_detalleventas_articulos10` FOREIGN KEY (`idArticulo`) REFERENCES `articulos` (`idArticulo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalleventas`
--
ALTER TABLE `detalleventas`
ADD CONSTRAINT `fk_detalleventas_articulos1` FOREIGN KEY (`idArticulo`) REFERENCES `articulos` (`idArticulo`) ON UPDATE CASCADE,
ADD CONSTRAINT `fk_detalleventas_ventas1` FOREIGN KEY (`numero`) REFERENCES `ventas` (`numero`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
ADD CONSTRAINT `fk_ventas_personas1` FOREIGN KEY (`idPersona`) REFERENCES `personas` (`idPersona`) ON UPDATE CASCADE,
ADD CONSTRAINT `fk_ventas_usuarios1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON UPDATE CASCADE;

COMMIT;