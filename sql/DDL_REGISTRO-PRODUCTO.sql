CREATE DATABASE IF NOT EXISTS ifc_registro_productos;

USE ifc_registro_productos;

-- CREATE tbl_bodegas
CREATE TABLE tbl_bodegas (
    id_bodega INT AUTO_INCREMENT PRIMARY KEY,
    nombre_bodega VARCHAR(50) NOT NULL
);

-- CREATE tbl_sucursales
CREATE TABLE tbl_sucursales (
    id_sucursal INT AUTO_INCREMENT PRIMARY KEY,
    id_bodega INT NOT NULL,
    nombre_sucursal VARCHAR(50) NOT NULL,
    FOREIGN KEY (id_bodega) REFERENCES tbl_bodegas(id_bodega) ON DELETE CASCADE
);

-- CREATE tbl_monedas
CREATE TABLE tbl_monedas (
    codigo_iso VARCHAR(3) PRIMARY KEY,
    nombre_moneda VARCHAR(20) NOT NULL,
    simbolo VARCHAR(5)
);

-- CREATE tbl_productos
CREATE TABLE tbl_productos (
    codigo_producto VARCHAR(15) PRIMARY KEY,
    nombre_producto VARCHAR(50) NOT NULL,
    id_bodega INT NOT NULL REFERENCES tbl_bodegas(id_bodega) ON DELETE CASCADE,
    id_sucursal INT NOT NULL REFERENCES tbl_sucursales(id_sucursal) ON DELETE CASCADE,
    codigo_moneda VARCHAR(3) NOT NULL REFERENCES tbl_monedas(codigo_iso),
    precio_producto DECIMAL(10, 2) NOT NULL CHECK (precio_producto >= 0),
    descripcion_producto VARCHAR(1000) NOT NULL
) ENGINE = InnoDB;

-- CREATE tbl_productos_materiales
CREATE TABLE tbl_productos_materiales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo_producto VARCHAR(15) NOT NULL REFERENCES tbl_productos(codigo_producto) ON DELETE CASCADE,
    material VARCHAR(20) NOT NULL
);