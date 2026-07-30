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

LOCK TABLES `estados` WRITE;
INSERT INTO `estados` (`id_estado`, `nome`, `uf`)
VALUES (1,'Acre','AC'),
(2,'Alagoas','AL'),
(3,'Amapá','AP'),
(4,'Amazonas','AM'),
(5,'Bahia','BA'),
(6,'Ceará','CE'),
(7,'Distrito Federal','DF'),
(8,'Espírito Santo','ES'),
(9,'Goiás','GO'),
(10,'Maranhão','MA'),
(11,'Mato Grosso','MT'),
(12,'Mato Grosso do Sul','MS'),
(13,'Minas Gerais','MG'),
(14,'Pará','PA'),
(15,'Paraíba','PB'),
(16,'Paraná','PR'),
(17,'Pernambuco','PE'),
(18,'Piauí','PI'),
(19,'Rio de Janeiro','RJ'),
(20,'Rio Grande do Norte','RN'),
(21,'Rio Grande do Sul','RS'),
(22,'Rondônia','RO'),
(23,'Roraima','RR'),
(24,'Santa Catarina','SC'),
(25,'São Paulo','SP'),
(26,'Sergipe','SE'),
(27,'Tocantins','TO');
UNLOCK TABLES;


LOCK TABLES `cidades` WRITE;
INSERT INTO `cidades` (`id_cidade`, `nome`, `id_estado`)
VALUES (1,'Rio Branco',1),
(2,'Maceió',2),
(3,'Macapá',3),
(4,'Manaus',4),
(5,'Salvador',5),
(6,'Fortaleza',6),
(7,'Brasília',7),
(8,'Vitória',8),
(9,'Goiânia',9),
(10,'São Luís',10),
(11,'Cuiabá',11),
(12,'Campo Grande',12),
(13,'Belo Horizonte',13),
(14,'Belém',14),
(15,'João Pessoa',15),
(16,'Curitiba',16),
(17,'Recife',17),
(18,'Teresina',18),
(19,'Rio de Janeiro',19),
(20,'Natal',20),
(21,'Porto Alegre',21),
(22,'Porto Velho',22),
(23,'Boa Vista',23),
(24,'Florianópolis',24),
(25,'São Paulo',25),
(26,'Aracaju',26),
(27,'Palmas',27),
(28,'Aquidabã',26);
UNLOCK TABLES;

LOCK TABLES `contatos` WRITE;
INSERT INTO `contatos` (`id_contato`, `nome`, `telefone`, `id_cidade`, `id_estado`)
VALUES (3,'Carla','(11) 99999-9999',25,25),
(5,'Dutra','(51) 99999-9999',21,21);
UNLOCK TABLES;