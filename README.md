# CRUD-in-PHP
To get started run the following SQL commands:

CREATE DATABASE misc;
GRANT ALL ON misc.* TO 'fred'@'localhost' IDENTIFIED BY 'zap';
GRANT ALL ON misc.* TO 'fred'@'127.0.0.1' IDENTIFIED BY 'zap';

USE misc; (Or select misc in phpMyAdmin)

CREATE TABLE autos (
        autos_id INTEGER NOT NULL KEY AUTO_INCREMENT,
        make VARCHAR(255),
        model VARCHAR(255),
        year INTEGER,
        mileage INTEGER
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


The above defined table "autos" inside the database named "misc" is used in the CRUD Application. You can either use the same code to understand the working of the application or modify it however you see fit.
