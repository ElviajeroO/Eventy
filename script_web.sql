create schema web;

use web;

CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(100) NOT NULL,
    confirmado TINYINT DEFAULT 0,
    codconfirmacao smallint unsigned,
    codsenha smallint unsigned,
    cookie varchar(100),
    otp VARCHAR(100)
);

ALTER USER 'root'@'localhost' IDENTIFIED BY 'root';

exit;
