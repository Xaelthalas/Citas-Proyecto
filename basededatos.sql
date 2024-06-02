CREATE DATABASE IF NOT EXISTS ReservasCitas;

USE ReservasCitas;

-- Creamos la tabla Usuarios
CREATE TABLE IF NOT EXISTS Usuarios (
    DNI VARCHAR(9) PRIMARY KEY,
    Nombre VARCHAR(50),
    Apellidos VARCHAR(50),
    Email VARCHAR(100), -- Añadimos el campo Email
    Contraseña VARCHAR(255),
    Rol VARCHAR(20) NOT NULL DEFAULT 'usuario', -- Añadimos el campo Rol con valor por defecto 'usuario'
    UNIQUE KEY (Email) -- Añadimos una restricción UNIQUE para el campo Email
);

-- Verificamos si ya existe un usuario admin
SET @admin_count = (SELECT COUNT(*) FROM Usuarios WHERE DNI = 'admin');

-- Si no existe, insertamos el usuario admin
INSERT IGNORE INTO Usuarios (DNI, Nombre, Apellidos, Email, Contraseña, Rol) VALUES ('admin', 'Administrador', 'Principal', 'admin@example.com', 'admin', 'admin');

-- Creamos la tabla Citas
CREATE TABLE IF NOT EXISTS Citas (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    DNI_usuario VARCHAR(8),
    Fecha DATE,
    Hora TIME,
    Estado VARCHAR(20),
    Motivo VARCHAR(255),
    FOREIGN KEY (DNI_usuario) REFERENCES Usuarios(DNI)
);

-- Creamos la tabla Comentarios
CREATE TABLE IF NOT EXISTS Comentarios (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Asunto VARCHAR(255),
    Cuerpo TEXT,
    DNI_usuario VARCHAR(8),
    FOREIGN KEY (DNI_usuario) REFERENCES Usuarios(DNI)
);
