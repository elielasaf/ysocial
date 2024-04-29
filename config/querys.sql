CREATE DATABASE ysocial;

CREATE TABLE users (
	user_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_nombre VARCHAR(256) NOT NULL,
    user_correo VARCHAR(256) NOT NULL,
    user_contraseña VARCHAR(256) NOT NULL
);

CREATE TABLE posts (
    post_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    post_title VARCHAR(124) NOT NULL,
    post_desc VARCHAR(264) NOT NULL,
    post_img LONGTEXT,
    post_by INT NOT NULL,
    post_date DATETIME,

    CONSTRAINT FOREIGN KEY (`post_by`)
    	REFERENCES users (`user_id`)
);

CREATE TABLE likes (
    like_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    like_for INT NOT NULL,
    like_by INT NOT NULL,

    CONSTRAINT FOREIGN KEY (`like_for`)
    	REFERENCES posts (`post_id`)
    	ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (`like_by`)
    	REFERENCES users (`user_id`)
    	ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE comments (
    comment_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    comment VARCHAR(256) NOT NULL,
    comment_for INT NOT NULL,
    comment_by INT NOT NULL,
    comment_date DATETIME,

    CONSTRAINT FOREIGN KEY (`comment_for`)
    	REFERENCES posts (`post_id`)
    	ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (`comment_by`)
    	REFERENCES users (`user_id`)
    	ON DELETE CASCADE ON UPDATE CASCADE
);