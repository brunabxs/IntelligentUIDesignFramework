DROP TABLE IF EXISTS User;

CREATE TABLE User (
  user_oid char(36),
  name varchar(100),
  password varchar(100),
  email varchar(100)
);

ALTER TABLE User ADD CONSTRAINT PK_User PRIMARY KEY (user_oid);
ALTER TABLE User ADD CONSTRAINT EK_User UNIQUE KEY (name);
