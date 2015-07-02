CREATE DATABASE `myphp` CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE users (
user_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
first_name varchar(20) NOT NULL,
last_name varchar(30) NOT NULL,
email varchar(50) NOT NULL,
bio varchar(1000) NOT NULL,
facebook_url varchar(100) NOT NULL,
twitter_handle varchar(20) NOT NULL
);