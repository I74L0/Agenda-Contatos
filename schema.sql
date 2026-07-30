CREATE DATABASE agenda_contatos;
USE agenda_contatos;

CREATE TABLE estados(
    id_estado INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255),
    uf VARCHAR(2)
);

CREATE TABLE cidades(
    id_cidade INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255),
    id_estado int,
    CONSTRAINT fk_cidades_estados
    FOREIGN KEY (id_estado)
    REFERENCES estados(id_estado)
);

CREATE TABLE contatos (
	id_contato int PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255),
    telefone VARCHAR(255),
    id_cidade int,
    id_estado int,
    CONSTRAINT fk_contatos_cidades
    FOREIGN KEY (id_cidade)
    REFERENCES cidades(id_cidade),
    CONSTRAINT fk_contatos_estados
    FOREIGN KEY (id_estado)
    REFERENCES estados(id_estado)
);