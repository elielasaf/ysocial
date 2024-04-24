CREATE DATABASE ysocial;

CREATE TABLE users (
	user_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_nombre VARCHAR(256) NOT NULL,
    user_correo VARCHAR(256) NOT NULL,
    user_contraseña VARCHAR(256) NOT NULL
);