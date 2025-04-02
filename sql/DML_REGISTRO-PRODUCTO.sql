INSERT INTO tbl_monedas (codigo_iso, nombre_moneda, simbolo) VALUES
('CLP', 'Peso Chileno', '$'),
('USD', 'Dólar Estadounidense', 'US$'),
('ARS', 'Peso Argentino', '$'),
('PEN', 'Sol Peruano', 'S/');

INSERT INTO tbl_bodegas (nombre_bodega) VALUES
('Bodega Central'),
('Bodega Norte'),
('Bodega Sur');

INSERT INTO tbl_sucursales (id_bodega, nombre_sucursal) VALUES
(1, 'Sucursal Centro'),
(1, 'Sucursal Providencia'),
(2, 'Sucursal Antofagasta'),
(3, 'Sucursal Concepción');