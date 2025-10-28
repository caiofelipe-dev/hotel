-- teste.sql
CREATE DATABASE IF NOT EXISTS hotel_teste;
USE hotel_teste;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE
);

INSERT INTO usuarios (nome, email) VALUES
('João da Silva', 'joao@teste.com'),
('Maria Oliveira', 'maria@teste.com');
