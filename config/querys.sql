CREATE DATABASE ysocial;

CREATE TABLE users (
	user_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_nombre VARCHAR(256) NOT NULL,
    user_correo VARCHAR(256) NOT NULL,
    user_contraseña VARCHAR(256) NOT NULL
);

/*Aun faltan columnas*/
CREATE TABLE posts (
    post_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    post_title VARCHAR(124) NOT NULL,
    post_desc VARCHAR(264) NOT NULL,
    post_img LONGTEXT NOT NULL,
    post_by INT NOT NULL
);