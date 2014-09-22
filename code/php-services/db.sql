CREATE DATABASE misc;
GRANT ALL ON misc.* TO 'fred' IDENTIFIED BY 'zap';
USE misc;

CREATE TABLE cache (
  id INT UNSIGNED NOT NULL
     AUTO_INCREMENT KEY,
  url VARCHAR(4096), 
  retrieved INTEGER,
  body LONGTEXT
);

CREATE TABLE rps_game (
  id INT UNSIGNED NOT NULL
     AUTO_INCREMENT KEY,
  created INT,
  login VARCHAR(100),
  pw VARCHAR(100),
  play INT,
  opponent VARCHAR(100),
  play2 INT
);
