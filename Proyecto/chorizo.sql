-- CREAR BASE DE DATOS Y USARLA
DROP DATABASE IF EXISTS MVCChorizo;
CREATE DATABASE MVCChorizo;
USE MVCChorizo;

-- TABLA VEHICULO
CREATE TABLE vehiculo (
    Matricula VARCHAR(10) NOT NULL PRIMARY KEY,
    Modelo VARCHAR(20) NOT NULL,
    Marca VARCHAR(20) NOT NULL,
    tipo_enchufe ENUM('Mennekes', 'J1772', 'CCS', 'CHAdeMO') NOT NULL,
    autonomia INT NOT NULL,
    fecha_fabricacion YEAR
) ENGINE=InnoDB;

-- TABLA USUARIOS
CREATE TABLE usuarios (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    matricula VARCHAR(10),
    email VARCHAR(100) NOT NULL UNIQUE,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    password BINARY(32) NOT NULL,
    tipo_usuario ENUM('admin', 'cliente') DEFAULT 'cliente',
    FOREIGN KEY (matricula) REFERENCES vehiculo(Matricula)
) ENGINE=InnoDB;

-- TABLA ESTACION
CREATE TABLE estacion (
    Id_Estacion INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(20),
    latitud DECIMAL(9,6) NOT NULL,
    longitud DECIMAL(9,6) NOT NULL,
    tipo_enchufe ENUM('Mennekes', 'J1772', 'CCS', 'CHAdeMO') NOT NULL,
    capacidad DECIMAL(9,2),
    cantidad INT
) ENGINE=InnoDB;

-- TABLA RUTA
CREATE TABLE Ruta (
    Id_Ruta INT AUTO_INCREMENT PRIMARY KEY,
    latitud DECIMAL(9,6) NOT NULL,
    longitud DECIMAL(9,6) NOT NULL,
    nombre VARCHAR(50)
) ENGINE=InnoDB;

-- TABLA RESERVA
CREATE TABLE reserva (
    id_reserva INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    Id_Estacion INT NOT NULL,
    fecha_reserva DATETIME,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(Id),
    FOREIGN KEY (Id_Estacion) REFERENCES estacion(Id_Estacion)
) ENGINE=InnoDB;

-- TABLA PLAN
CREATE TABLE plan (
    Id_Plan INT AUTO_INCREMENT PRIMARY KEY,
    Id_reserva INT NOT NULL,
    Id_Ruta INT NOT NULL,
    latitud_O DECIMAL(9,6) NOT NULL,
    longitud_O DECIMAL(9,6) NOT NULL,
    latitud_D DECIMAL(9,6) NOT NULL,
    longitud_D DECIMAL(9,6) NOT NULL,
    origen VARCHAR(50) GENERATED ALWAYS AS (CONCAT('(', latitud_O, ', ', longitud_O, ')')) STORED,
    destino VARCHAR(50) GENERATED ALWAYS AS (CONCAT('(', latitud_D, ', ', longitud_D, ')')) STORED,
    presupuesto DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (Id_reserva) REFERENCES reserva(id_reserva),
    FOREIGN KEY (Id_Ruta) REFERENCES Ruta(Id_Ruta),
    INDEX idx_origen (origen),
    INDEX idx_destino (destino)
) ENGINE=InnoDB;

-- TABLA HISTORIAL VIAJES
CREATE TABLE historial_viajes (
   Id_Historial INT AUTO_INCREMENT PRIMARY KEY,
   Id_Plan INT NOT NULL,
   Id_Usuario INT NOT NULL,
   FOREIGN KEY (Id_Usuario) REFERENCES usuarios(Id),
   FOREIGN KEY (Id_Plan) REFERENCES plan(Id_Plan)
) ENGINE=InnoDB;

-- INSERTS

-- VEHICULO
INSERT INTO vehiculo (Matricula, Modelo, Marca, tipo_enchufe, autonomia, fecha_fabricacion)
VALUES
('ABC123', 'Model S', 'Tesla', 'Mennekes', 500, 2020),
('XYZ789', 'Leaf', 'Nissan', 'CHAdeMO', 300, 2019);

SELECT * FROM vehiculo;

-- USUARIOS
INSERT INTO usuarios (email, nombre, apellido, fecha_nacimiento, password, tipo_usuario)
VALUES
('admin@gmail.com', 'Juan', 'Perez', '1990-05-20', UNHEX(SHA2('12345', 256)), 'admin'),
('cliente@gmail.com', 'Ana', 'Lopez', '1985-10-12', UNHEX(SHA2('12345', 256)), 'cliente');

SELECT * FROM usuarios;

-- ESTACION
INSERT INTO estacion (nombre, latitud, longitud, tipo_enchufe, capacidad, cantidad)
VALUES
('Estacion Centro', 40.416775, -3.703790, 'Mennekes', 100.00, 5),
('Estacion Norte', 41.403611, 2.174444, 'CHAdeMO', 80.00, 3);

SELECT * FROM estacion;

-- RUTA
INSERT INTO Ruta (latitud, longitud, nombre)
VALUES
(40.416775, -3.703790, 'Ruta Madrid'),
(41.403611, 2.174444, 'Ruta Barcelona');

SELECT * FROM Ruta;

-- RESERVA
INSERT INTO reserva (id_usuario, Id_Estacion, fecha_reserva)
VALUES
(1, 1, '2025-06-01 10:00:00'),
(2, 2, '2025-06-02 15:30:00');

SELECT * FROM reserva;

-- PLAN
INSERT INTO plan (Id_reserva, Id_Ruta, latitud_O, longitud_O, latitud_D, longitud_D, presupuesto)
VALUES
(1, 1, 40.416775, -3.703790, 41.403611, 2.174444, 150.00),
(2, 2, 41.403611, 2.174444, 40.416775, -3.703790, 160.00);

SELECT * FROM plan;

-- HISTORIAL_VIAJES
INSERT INTO historial_viajes (Id_Plan, Id_Usuario)
VALUES
(1, 1),
(2, 2);

SELECT * FROM historial_viajes;