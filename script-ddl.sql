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

ALTER TABLE User ADD CONSTRAINT PK_User PRIMARY KEY (user_oid);
