DROP DATABASE IF EXISTS db_notes;

CREATE DATABASE db_notes;

USE db_notes;

CREATE TABLE user (
  id INT AUTO_INCREMENT,
  username VARCHAR(50),
  email VARCHAR(100),
  password VARCHAR(256),
  PRIMARY KEY (id)
);

CREATE TABLE notes (
  id INT(12) AUTO_INCREMENT,
  id_user INT(12) NOT NULL,
  judul VARCHAR(100),
  konten VARCHAR(100),
  tanggal date,
  PRIMARY KEY (id),
  FOREIGN KEY (id_user) REFERENCES user (id)
);

CREATE TABLE contact (
  id INT(12) AUTO_INCREMENT,
  id_user INT(12) NOT NULL,
  foto VARCHAR(255),
  nama VARCHAR(100),
  email VARCHAR(100), 
  pekerjaan VARCHAR(50),
  nomor_telpon VARCHAR(20),
  lokasi VARCHAR(100),
  PRIMARY KEY(id),
  FOREIGN KEY (id_user) REFERENCES user (id)
);