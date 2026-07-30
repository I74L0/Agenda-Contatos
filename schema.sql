DROP DATABASE IF EXISTS agenda_contatos;
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
    telefone VARCHAR(15),
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
VALUES (1,'Arthur','(79) 97401-3749',26,26),
(2,'Bernardo','(11) 99999-9999',25,25),
(3,'Carla','(51) 99999-9999',21,21),
(4,'Dutra','(81) 99999-9999',17,17),
(5,'Eduarda','(47) 99999-9999',24,24),
(6,'Felipe','(61) 99999-9999',7,7),
(7,'Gabriela','(31) 99999-9999',13,13),
(8,'Hugo','(21) 99999-9999',19,19),
(9,'Ingrid','(92) 99999-9999',4,4),
(10,'João','(41) 99999-9999',16,16),
(11,'Karina','(65) 99999-9999',11,11),
(12,'Lucas','(83) 99999-9999',15,15),
(13,'Maria','(69) 99999-9999',22,22),
(14,'Nicolas','(24) 99999-9999',19,19),
(15,'Olivia','(98) 99999-9999',10,10),
(16,'Pedro','(91) 99999-9999',14,14),
(17,'Quiteria','(86) 99999-9999',18,18),
(18,'Rafael','(94) 99999-9999',14,14),
(19,'Samara','(96) 99999-9999',3,3),
(20,'Thiago','(27) 99999-9999',8,8),
(21,'Vanessa','(67) 99999-9999',12,12),
(22,'William','(84) 99999-9999',20,20),
(23,'Ximena','(95) 99999-9999',23,23),
(24,'Yago','(63) 99999-9999',27,27),
(25,'Zelia','(73) 99999-9999',5,5);
UNLOCK TABLES;