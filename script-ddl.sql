DROP TABLE IF EXISTS Individual;
DROP TABLE IF EXISTS Generation;
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

CREATE TABLE Generation (
  generation_oid char(36),
  number int,
  geneticAlgorithm_oid char(36)
);

CREATE TABLE Individual (
  individual_oid char(36),
  genome varchar(30),
  properties text,
  quantity int,
  score real,
  generation_oid char(36)
);

ALTER TABLE User ADD CONSTRAINT PK_User PRIMARY KEY (user_oid);
ALTER TABLE User ADD CONSTRAINT EK_User UNIQUE KEY (name);

ALTER TABLE GeneticAlgorithm ADD CONSTRAINT PK_GeneticAlgorithm PRIMARY KEY (geneticAlgorithm_oid);
ALTER TABLE GeneticAlgorithm ADD CONSTRAINT EK_GeneticAlgorithm UNIQUE KEY (user_oid);

ALTER TABLE Generation ADD CONSTRAINT PK_Generation PRIMARY KEY (generation_oid);
ALTER TABLE Generation ADD CONSTRAINT EK_Generation UNIQUE KEY (number, geneticAlgorithm_oid);

ALTER TABLE Individual ADD CONSTRAINT PK_Individual PRIMARY KEY (individual_oid);
ALTER TABLE Individual ADD CONSTRAINT EK_Individual UNIQUE KEY (genome, generation_oid);
