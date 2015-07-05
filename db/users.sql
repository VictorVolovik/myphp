CREATE DATABASE `myphp` CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE users (
	user_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	first_name varchar(20) NOT NULL,
	last_name varchar(30) NOT NULL,
	email varchar(50) NOT NULL,
	bio varchar(1000),
	facebook_url varchar(100),
	twitter_handle varchar(20),
	profile_pic_id int
);

CREATE TABLE images (
	image_id int AUTO_INCREMENT PRIMARY KEY,
	filename varchar(200) NOT NULL,
	mime_type varchar(50) NOT NULL,
	file_size int NOT NULL,
	image_data mediumblob NOT NULL
);