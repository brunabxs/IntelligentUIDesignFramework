DROP TABLE IF EXISTS AnalyticsData;
DROP TABLE IF EXISTS Analytics;
DROP TABLE IF EXISTS Individual;
DROP TABLE IF EXISTS Generation;
DROP TABLE IF EXISTS GeneticAlgorithm;
DROP TABLE IF EXISTS Process;
DROP TABLE IF EXISTS User;

CREATE TABLE User (
  user_oid char(36),
  name varchar(100),
  password varchar(100),
  email varchar(100)  
);

CREATE TABLE Process (
  process_oid char(36),
  serverConfiguration tinyint(1),
  clientConfiguration tinyint(1),
  scheduleNextGeneration tinyint(1),
  user_oid char(36)
);

CREATE TABLE GeneticAlgorithm (
  geneticAlgorithm_oid char(36),
  code varchar(36),
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

CREATE TABLE Analytics (
  analytics_oid char(36),
  token char(36),
  siteId int,
  type char(10),
  geneticAlgorithm_oid char(36)
);

CREATE TABLE AnalyticsData (
  analyticsData_oid char(36),
  method char(100),
  extraParameters char(255),
  weight int,
  analytics_oid char(36)
);

ALTER TABLE User ADD CONSTRAINT PK_User PRIMARY KEY (user_oid);
ALTER TABLE User ADD CONSTRAINT EK_User UNIQUE KEY (name);

ALTER TABLE Process ADD CONSTRAINT PK_Process PRIMARY KEY (process_oid);
ALTER TABLE Process ADD CONSTRAINT EK_Process UNIQUE KEY (user_oid);

ALTER TABLE GeneticAlgorithm ADD CONSTRAINT PK_GeneticAlgorithm PRIMARY KEY (geneticAlgorithm_oid);
ALTER TABLE GeneticAlgorithm ADD CONSTRAINT EK1_GeneticAlgorithm UNIQUE KEY (code);
ALTER TABLE GeneticAlgorithm ADD CONSTRAINT EK2_GeneticAlgorithm UNIQUE KEY (user_oid);

ALTER TABLE Generation ADD CONSTRAINT PK_Generation PRIMARY KEY (generation_oid);
ALTER TABLE Generation ADD CONSTRAINT EK_Generation UNIQUE KEY (number, geneticAlgorithm_oid);

ALTER TABLE Individual ADD CONSTRAINT PK_Individual PRIMARY KEY (individual_oid);
ALTER TABLE Individual ADD CONSTRAINT EK_Individual UNIQUE KEY (genome, generation_oid);

ALTER TABLE Analytics ADD CONSTRAINT PK_Analytics PRIMARY KEY (analytics_oid);
ALTER TABLE Analytics ADD CONSTRAINT EK_Analytics UNIQUE KEY (geneticAlgorithm_oid);

ALTER TABLE AnalyticsData ADD CONSTRAINT PK_AnalyticsData PRIMARY KEY (analyticsData_oid);
ALTER TABLE AnalyticsData ADD CONSTRAINT EK_AnalyticsData UNIQUE KEY (method, extraParameters, analytics_oid);
