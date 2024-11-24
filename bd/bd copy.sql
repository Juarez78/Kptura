-- Active: 1727142737403@@127.0.0.1@3306@store_sv
-- DROP DATABASE store_sv;
CREATE DATABASE store_sv;

USE store_sv;

CREATE TABLE usuarios (
    idusuario INT PRIMARY KEY AUTO_INCREMENT,
    usuario VARCHAR(255) NOT NULL,
    clave TEXT NOT NULL,
    estado INT NOT NULL,
    tipo INT NOT NULL
);

INSERT INTO usuarios(usuario,clave,estado,tipo) VALUES ('admin','$2y$10$Smll0Ut0dnrpdI.qH/Xow.FPk2HFQXf.LvRRxLpoWbL6M/de27Cpm',1,1);
INSERT INTO usuarios (usuario, clave, estado, tipo)
VALUES
('Carlos', '$2y$10$Smll0Ut0dnrpdI.qH/Xow.FPk2HFQXf.LvRRxLpoWbL6M/de27Cpm', 1, 1),
('Laura', '$2y$10$Smll0Ut0dnrpdI.qH/Xow.FPk2HFQXf.LvRRxLpoWbL6M/de27Cpm', 1, 1),
('Miguel', '$2y$10$Smll0Ut0dnrpdI.qH/Xow.FPk2HFQXf.LvRRxLpoWbL6M/de27Cpm', 1, 1),
('Ana', '$2y$10$Smll0Ut0dnrpdI.qH/Xow.FPk2HFQXf.LvRRxLpoWbL6M/de27Cpm', 1, 1),
('David', '$2y$10$Smll0Ut0dnrpdI.qH/Xow.FPk2HFQXf.LvRRxLpoWbL6M/de27Cpm', 1, 1),
('Maria', '$2y$10$Smll0Ut0dnrpdI.qH/Xow.FPk2HFQXf.LvRRxLpoWbL6M/de27Cpm', 1, 1),
('Juan', '$2y$10$Smll0Ut0dnrpdI.qH/Xow.FPk2HFQXf.LvRRxLpoWbL6M/de27Cpm', 1, 1),
('Sofia', '$2y$10$Smll0Ut0dnrpdI.qH/Xow.FPk2HFQXf.LvRRxLpoWbL6M/de27Cpm', 1, 1),
('Luis', '$2y$10$Smll0Ut0dnrpdI.qH/Xow.FPk2HFQXf.LvRRxLpoWbL6M/de27Cpm', 1, 1),
('Valeria', '$2y$10$Smll0Ut0dnrpdI.qH/Xow.FPk2HFQXf.LvRRxLpoWbL6M/de27Cpm', 1, 1),
('Jose', '$2y$10$Smll0Ut0dnrpdI.qH/Xow.FPk2HFQXf.LvRRxLpoWbL6M/de27Cpm', 1, 1),
('Camila', '$2y$10$Smll0Ut0dnrpdI.qH/Xow.FPk2HFQXf.LvRRxLpoWbL6M/de27Cpm', 1, 1),
('Diego', '$2y$10$Smll0Ut0dnrpdI.qH/Xow.FPk2HFQXf.LvRRxLpoWbL6M/de27Cpm', 1, 1),
('Elena', '$2y$10$Smll0Ut0dnrpdI.qH/Xow.FPk2HFQXf.LvRRxLpoWbL6M/de27Cpm', 1, 1),
('Jorge', '$2y$10$Smll0Ut0dnrpdI.qH/Xow.FPk2HFQXf.LvRRxLpoWbL6M/de27Cpm', 1, 1),
('Patricia', '$2y$10$Smll0Ut0dnrpdI.qH/Xow.FPk2HFQXf.LvRRxLpoWbL6M/de27Cpm', 1, 1),
('Sergio', '$2y$10$Smll0Ut0dnrpdI.qH/Xow.FPk2HFQXf.LvRRxLpoWbL6M/de27Cpm', 1, 1),
('Lucia', '$2y$10$Smll0Ut0dnrpdI.qH/Xow.FPk2HFQXf.LvRRxLpoWbL6M/de27Cpm', 1, 1),
('Ricardo', '$2y$10$Smll0Ut0dnrpdI.qH/Xow.FPk2HFQXf.LvRRxLpoWbL6M/de27Cpm', 1, 1),
('Gabriela', '$2y$10$Smll0Ut0dnrpdI.qH/Xow.FPk2HFQXf.LvRRxLpoWbL6M/de27Cpm', 1, 1);
CREATE TABLE roles(
    idrol INT PRIMARY KEY AUTO_INCREMENT,
    rol VARCHAR(100) NOT NULL
);

INSERT INTO roles(rol) 
VALUES 
('Administrador'),
('Empleados'),
('Cliente');

CREATE TABLE clientes (
    idcliente INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    apellido VARCHAR(255) NOT NULL,
    telefono VARCHAR(9) NOT NULL,
    direccion TEXT,
    idusuario INT
);

CREATE TABLE proveedores (
    idproveedor INT PRIMARY KEY AUTO_INCREMENT,
    proveedor VARCHAR(255) NOT NULL,
    contacto VARCHAR(100) NOT NULL,
    direccion TEXT NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    email TEXT,
    estado INT,
    tipo TEXT
);

INSERT INTO proveedores (proveedor, contacto, direccion, telefono, email, estado, tipo) VALUES
('Tecnología Innovadora SA', 'Luis González', 'Av. Reforma #123, San Salvador, El Salvador', '50321234567', 'contacto@tecnologiainnovadora.com', 1, 'Nacional'),
('DataWare Solutions', 'Marta Castillo', 'Calle Principal #45, Santa Ana, El Salvador', '50322223344', 'marta@dataware.com', 1, 'Nacional'),
('GlobalTech Inc.', 'Michael Cooper', '789 King St, New York, USA', '18004567890', 'michael@globaltech.com', 1, 'Internacional'),
('Servicios Digitales', 'Roberto Martínez', 'Blvd. del Ejército, Soyapango, El Salvador', '50322123456', 'info@serviciosdigitales.com', 1, 'Nacional'),
('NetWorld Ltd.', 'Sofia Turner', '20 Bay Street, Toronto, Canada', '14165551234', 'contact@networld.ca', 1, 'Internacional'),
('Soluciones IT SA', 'Carlos Ramos', 'Colonia Escalón, San Salvador, El Salvador', '50323456789', 'carlos@solucionesit.com', 1, 'Nacional'),
('SoftWare Global', 'Alice Brown', '123 Silicon Ave, San Jose, USA', '18005551234', 'alice@swglobal.com', 1, 'Internacional'),
('Electronicos del Sur', 'Juan Pérez', 'Centro de San Miguel, San Miguel, El Salvador', '50322227788', 'jp@electronicosdelsur.com', 1, 'Nacional'),
('TechWorld Pte Ltd', 'Chen Wei', '15 Orchard Rd, Singapore', '6581234567', 'chen@techworld.sg', 1, 'Internacional'),
('Innovación y Soluciones', 'Sergio Sánchez', 'Calle La Mascota, San Salvador, El Salvador', '50323344556', 'sergio@innovacion.com', 1, 'Nacional'),
('DigitalEdge Ltd.', 'Amina Yusuf', '12 Ahmed St, Lagos, Nigeria', '234123456789', 'amina@digitaledge.ng', 1, 'Internacional'),
('NetSolutions', 'María Castro', 'Barrio La Vega, Santa Tecla, El Salvador', '50324567890', 'mcastro@netsolutions.com', 1, 'Nacional'),
('IT Hub Europe', 'Hans Meier', 'Hauptstrasse 5, Berlin, Germany', '49301234567', 'hans@ithub.de', 1, 'Internacional'),
('Smart Tech SA', 'Raúl Romero', 'Zona Rosa, San Salvador, El Salvador', '50321211234', 'raul@smarttech.com', 1, 'Nacional'),
('AsiaLink Tech', 'Yuki Tanaka', '2-4-5 Shibuya, Tokyo, Japan', '81312345678', 'yuki@asialink.jp', 1, 'Internacional');

INSERT INTO proveedores (proveedor, contacto, direccion, telefono, email, estado, tipo) VALUES
('Zona Digital', 'Erick López', 'Colonia Escalón, San Salvador, El Salvador', '50322123456', 'erick@zonadigital.com', 1, 'Nacional'),
('Aeon Solutions', 'María Hernández', 'Blvd. Los Próceres, San Salvador, El Salvador', '50322334455', 'maria@aeonsolutions.com', 1, 'Nacional'),
('STB Tecnología', 'Oscar Torres', 'Centro Comercial Metrocentro, San Salvador, El Salvador', '50322445566', 'oscar@stbtecnologia.com', 1, 'Nacional');

CREATE TABLE categorias(
    idcategoria INT PRIMARY KEY AUTO_INCREMENT,
    categoria VARCHAR(255) NOT NULL,
    estado INT
);

INSERT INTO categorias (categoria, estado) VALUES
('Tecnología', 1),
('Electrónica', 1),
('Computadoras', 1),
('Smartphones', 1),
('Accesorios Tecnológicos', 1),
('Ropa', 1),
('Calzado', 1),
('Ropa Deportiva', 1),
('Accesorios de Moda', 1),
('Joyería', 1),
('Carros', 1),
('Motos', 1),
('Repuestos Automotrices', 1),
('Accesorios para Carros', 1),
('Flores', 1);

CREATE TABLE productos (
    idproducto INT PRIMARY KEY AUTO_INCREMENT,
    imagen VARCHAR(100) NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    detalle TEXT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    idproveedor INT,
    idcategoria INT,
    FOREIGN KEY (idproveedor) REFERENCES proveedores(idproveedor),
    FOREIGN KEY (idcategoria) REFERENCES categorias(idcategoria)
);
DROP TABLE bitacora;
CREATE TABLE bitacora(
    id INT PRIMARY KEY AUTO_INCREMENT,
    tabla VARCHAR(50) NOT NULL,
    accion VARCHAR(50) NOT NULL,
    valores_old TEXT,
    valores_new TEXT,
    fecha DATETIME DEFAULT NOW()
);


CREATE TABLE carrito(
    idcarrito INT PRIMARY KEY AUTO_INCREMENT,
    idusuario INT NOT NULL,
    idproducto INT,
    cantidad INT NOT NULL,
    total FLOAT,
    estado INT
);

CREATE TABLE ticket(
    idticket INT PRIMARY KEY AUTO_INCREMENT,
    idusuario INT NOT NULL,
    idcarrito VARCHAR(255),
    estado INT,
    fecha DATETIME
);