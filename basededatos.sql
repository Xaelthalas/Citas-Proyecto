CREATE DATABASE IF NOT EXISTS ReservasCitas;

USE ReservasCitas;

-- Creamos la tabla Usuarios
CREATE TABLE IF NOT EXISTS Usuarios (
    DNI VARCHAR(8) PRIMARY KEY,
    Nombre VARCHAR(50),
    Apellidos VARCHAR(50),
    Contraseña VARCHAR(255) -- Aquí almacenaremos la contraseña
);

-- Verificamos si ya existe un usuario admin
SET @admin_count = (SELECT COUNT(*) FROM Usuarios WHERE DNI = 'admin');

-- Si no existe, insertamos el usuario admin
INSERT IGNORE INTO Usuarios (DNI, Nombre, Apellidos, Contraseña) VALUES ('admin', 'Administrador', 'Principal', 'admin');

-- Creamos la tabla Citas
CREATE TABLE IF NOT EXISTS Citas (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    DNI_usuario VARCHAR(8),
    Fecha DATE,
    Hora TIME,
    Estado VARCHAR(20),
    Motivo VARCHAR(255), -- Añadimos el campo Motivo
    FOREIGN KEY (DNI_usuario) REFERENCES Usuarios(DNI)
);
