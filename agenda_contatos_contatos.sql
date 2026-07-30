DROP TABLE IF EXISTS `contatos`;
CREATE TABLE `contatos` (
  `id_contato` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `id_cidade` int DEFAULT NULL,
  `id_estado` int DEFAULT NULL,
  PRIMARY KEY (`id_contato`),
  KEY `fk_contatos_cidades` (`id_cidade`),
  KEY `fk_contatos_estados` (`id_estado`),
  CONSTRAINT `fk_contatos_cidades` FOREIGN KEY (`id_cidade`) REFERENCES `cidades` (`id_cidade`),
  CONSTRAINT `fk_contatos_estados` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
LOCK TABLES `contatos` WRITE;
INSERT INTO `contatos` (`id_contato`, `nome`, `telefone`, `id_cidade`, `id_estado`) VALUES (3,'Carla','(11) 99999-9999',25,25),(5,'Dutra','(51) 99999-9999',21,21);
UNLOCK TABLES;