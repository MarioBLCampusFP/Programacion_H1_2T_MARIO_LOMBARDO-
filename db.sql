DROP DATABASE IF EXISTS stream_web;
CREATE DATABASE stream_web;
USE stream_web;

-- Tabla para almacenar los planes base
CREATE TABLE planes (
	id_plan INT AUTO_INCREMENT PRIMARY KEY,
    nombre_plan ENUM('Básico', 'Estándar', 'Premium'),
    precio_mensual DECIMAL(6,2) NOT NULL
);

-- Tabla para almacenar los usuarios
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    edad TINYINT NOT NULL,
    id_plan INT,
    duracion_suscripcion ENUM('Mensual', 'Anual') NOT NULL,
    FOREIGN KEY (id_plan) REFERENCES planes(id_plan)
);

-- Tabla para almacenar los paquetes adicionales
CREATE TABLE paquetes (
    id_paquete INT AUTO_INCREMENT PRIMARY KEY,
	nombre_paquete ENUM('Deporte', 'Cine', 'Infantil'),
    precio_mensual DECIMAL(6,2) NOT NULL
);

-- Tabla asociativa entre usuarios y paquetes adicionales
CREATE TABLE usuario_paquete (
    id_usuario INT,
    id_paquete INT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario),
    FOREIGN KEY (id_paquete) REFERENCES paquetes(id_paquete)
);

-- Insertar datos en la tabla de planes
INSERT INTO planes (nombre_plan, precio_mensual) VALUES
('Básico', 9.99),
('Estándar', 13.99),
('Premium', 17.99);

-- Insertar datos en la tabla de paquetes adicionales
INSERT INTO paquetes (nombre_paquete, precio_mensual) VALUES
('Deporte', 6.99),
('Cine', 7.99),
('Infantil', 4.99);