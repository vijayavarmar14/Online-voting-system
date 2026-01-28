CREATE DATABASE online_voting;
USE online_voting;

CREATE TABLE students (
 id INT AUTO_INCREMENT PRIMARY KEY,
 reg_no VARCHAR(20) UNIQUE,
 password VARCHAR(50),
 has_voted INT DEFAULT 0
);

CREATE TABLE candidates (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100),
 department VARCHAR(50),
 photo VARCHAR(255),
 votes INT DEFAULT 0
);

CREATE TABLE admin (
 id INT AUTO_INCREMENT PRIMARY KEY,
 username VARCHAR(50),
 password VARCHAR(50)
);

INSERT INTO admin VALUES (1,'admin','admin123');
