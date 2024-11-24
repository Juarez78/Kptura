-- Active: 1708630569922@@127.0.0.1@3306@store_sv
DROP DATABASE store_sv;
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
    idrol INSERT INTO usuarios (usuario, clave, estado, tipo)
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


INSERT INTO roles(rol) VALUES ('Administrador'),('Empleados'),('Cliente');
);


INSERT INTO roles(rol) VALUES ('Administrador'),('Empleados'),('Cliente');

CREATE TABLE categorias(
    idcategoria INT PRIMARY KEY AUTO_INCREMENT,
    categoria VARCHAR(100) NOT NULL,
    estado INT
);

CREATE TABLE clientes (
    idcliente INT PRIMARY KEY AUTO_INCREMENT,
    cliente VARCHAR(100) NOT NULL,
    telefono VARCHAR(9),
    direccion TEXT,
    email TEXT,
    idusuario INT
);