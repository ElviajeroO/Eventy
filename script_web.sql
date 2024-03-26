create schema web;

use web;

CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(100) NOT NULL,
    confirmado BIT(1) DEFAULT 0,
    codconfirmacao smallint unsigned,
    otp VARCHAR(100)
);

ALTER USER 'root'@'localhost' IDENTIFIED BY 'root';

exit;
