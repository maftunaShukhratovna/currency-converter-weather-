CREATE DATABASE currencyconverter;

USE currencyconverter;

CREATE TABLE tgusers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNIQUE NOT NULL,     
    username VARCHAR(255),           
    start_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);