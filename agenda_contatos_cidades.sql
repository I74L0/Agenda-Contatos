DROP TABLE IF EXISTS `cidades`;
CREATE TABLE `cidades` (
  `id_cidade` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `id_estado` int DEFAULT NULL,
  PRIMARY KEY (`id_cidade`),
  KEY `fk_cidades_estados` (`id_estado`),
  CONSTRAINT `fk_cidades_estados` FOREIGN KEY (`id_estado`) REFERENCES `estados` (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
LOCK TABLES `cidades` WRITE;
INSERT INTO `cidades` (`id_cidade`, `nome`, `id_estado`) VALUES (1,'Rio Branco',1),(2,'Maceió',2),(3,'Macapá',3),(4,'Manaus',4),(5,'Salvador',5),(6,'Fortaleza',6),(7,'Brasília',7),(8,'Vitória',8),(9,'Goiânia',9),(10,'São Luís',10),(11,'Cuiabá',11),(12,'Campo Grande',12),(13,'Belo Horizonte',13),(14,'Belém',14),(15,'João Pessoa',15),(16,'Curitiba',16),(17,'Recife',17),(18,'Teresina',18),(19,'Rio de Janeiro',19),(20,'Natal',20),(21,'Porto Alegre',21),(22,'Porto Velho',22),(23,'Boa Vista',23),(24,'Florianópolis',24),(25,'São Paulo',25),(26,'Aracaju',26),(27,'Palmas',27),(28,'Aquidabã',26);
UNLOCK TABLES;