CREATE DATABASE IF NOT EXISTS ReservasCitas;

USE ReservasCitas;

CREATE TABLE IF NOT EXISTS Usuarios (
    DNI INT PRIMARY KEY,
    Nombre VARCHAR(50),
    Apellidos VARCHAR(50),
    Contraseña VARCHAR(255) -- Aquí almacenaremos la contraseña
);


CREATE TABLE IF NOT EXISTS Citas (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    DNI_usuario INT,
    Fecha DATE,
    Hora TIME,
    Estado VARCHAR(20),
    FOREIGN KEY (DNI_usuario) REFERENCES Usuarios(DNI)
);
