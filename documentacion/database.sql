CREATE DATABASE biblioteca_videojuegos CHARACTER SET utf8
COLLATE utf8_unicode_ci;

USE biblioteca_videojuegos;

CREATE TABLE usuarios (
nombre_usuario varchar(35) PRIMARY KEY,
email varchar(40) UNIQUE NOT NULL, 
passwrd varchar(20) NOT NULL);

CREATE TABLE categorias (
categoria_clave varchar(30) PRIMARY KEY,
numero_juegos_per_categoria int DEFAULT 0);


CREATE TABLE videojuegos (
titulo_clave varchar(45) PRIMARY KEY, 
título varchar(40) NOT NULL, 
descripcion varchar (100) NOT NULL, 
autor varchar(35) NOT NULL,
caratula varchar(45) NULL,
categoria_clave varchar(30) UNIQUE NOT NULL,
url varchar(50) NOT NULL,
año date NOT NULL, 
nombre_usuario varchar(35) UNIQUE,
FOREIGN KEY (categoria_clave) REFERENCES categorias(categoria_clave),
FOREIGN KEY (nombre_usuario) REFERENCES usuarios(nombre_usuario));