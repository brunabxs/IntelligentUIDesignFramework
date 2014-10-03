DROP TABLE IF EXISTS GeneticAlgorithm;
DROP TABLE IF EXISTS User;

CREATE TABLE User (
  user_oid char(36),
  name varchar(100),
  password varchar(100),
  email varchar(100)
);

CREATE TABLE GeneticAlgorithm (
  geneticAlgorithm_oid char(36),
  populationSize int,
  genomeSize int,
  methodForSelection varchar(30),
  methodForCrossover varchar(30),
  methodForMutation varchar(30),
  properties text,
  user_oid char(36)
);

ALTER TABLE User ADD CONSTRAINT PK_User PRIMARY KEY (user_oid);
ALTER TABLE User ADD CONSTRAINT EK_User UNIQUE KEY (name);

ALTER TABLE GeneticAlgorithm ADD CONSTRAINT PK_GeneticAlgorithm PRIMARY KEY (geneticAlgorithm_oid);
ALTER TABLE GeneticAlgorithm ADD CONSTRAINT EK_GeneticAlgorithm UNIQUE KEY (user_oid);

