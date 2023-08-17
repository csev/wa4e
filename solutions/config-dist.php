<?php

// Remember this is being called from one folder down.
if ( file_exists('../config-local.php') ) {
    include_once('../config-local.php');
}

if ( ! isset($pdo) ) {
    $pdo = new PDO('mysql:host=localhost;port=8889;dbname=misc', 'fred', 'zap');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

// Cleanup old data
try{
    $stmt = $pdo->prepare('DELETE FROM Profile
        WHERE updated_at < (NOW() - INTERVAL 60 MINUTE)');
    $stmt->execute();
} catch(Exception $e) {
    // Nothing
}

/*
CREATE DATABASE misc DEFAULT CHARACTER SET utf8 ;

GRANT ALL ON misc.* TO 'fred'@'localhost' IDENTIFIED BY 'zap';
GRANT ALL ON misc.* TO 'fred'@'127.0.0.1' IDENTIFIED BY 'zap';

USE misc;

CREATE TABLE users (
   user_id INTEGER NOT NULL AUTO_INCREMENT,
   name VARCHAR(128),
   email VARCHAR(128),
   password VARCHAR(128),

   created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

   INDEX(email),
   PRIMARY KEY(user_id)
) ENGINE=InnoDB CHARSET=utf8;

ALTER TABLE users ADD INDEX(email);
ALTER TABLE users ADD INDEX(password);

INSERT INTO users (name,email,password)
    VALUES ('Chuck','csev@umich.edu','1a52e17fa899cf40fb04cfc42e6352f1');

INSERT INTO users (name,email,password)
    VALUES ('UMSI','umsi@umich.edu','1a52e17fa899cf40fb04cfc42e6352f1');

CREATE TABLE Profile (
  profile_id INTEGER NOT NULL AUTO_INCREMENT,
  user_id INTEGER NOT NULL,
  first_name TEXT,
  last_name TEXT,
  email TEXT,
  headline TEXT,
  summary TEXT,

  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY(profile_id),

  CONSTRAINT profile_ibfk_2
        FOREIGN KEY (user_id)
        REFERENCES users (user_id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE  Profile ADD updated_at
    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP 
    ON UPDATE CURRENT_TIMESTAMP;

CREATE TABLE Position (
  position_id INTEGER NOT NULL AUTO_INCREMENT,
  profile_id INTEGER,
  rank INTEGER,
  year INTEGER,
  description TEXT,

  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

  PRIMARY KEY(position_id),

  CONSTRAINT position_ibfk_1
        FOREIGN KEY (profile_id)
        REFERENCES Profile (profile_id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Institution (
  institution_id INTEGER NOT NULL AUTO_INCREMENT,
  name VARCHAR(255),
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(institution_id),
  UNIQUE(name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO Institution (name) VALUES ('University of Michigan');
INSERT INTO Institution (name) VALUES ('University of Virginia');
INSERT INTO Institution (name) VALUES ('University of Oxford');
INSERT INTO Institution (name) VALUES ('University of Cambridge');
INSERT INTO Institution (name) VALUES ('Stanford University');
INSERT INTO Institution (name) VALUES ('Duke University');
INSERT INTO Institution (name) VALUES ('Michigan State University');
INSERT INTO Institution (name) VALUES ('Mississippi State University');
INSERT INTO Institution (name) VALUES ('Montana State University');

CREATE TABLE Education (
  profile_id INTEGER,
  institution_id INTEGER,
  rank INTEGER,
  year INTEGER,

  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

  CONSTRAINT education_ibfk_1
        FOREIGN KEY (profile_id)
        REFERENCES Profile (profile_id)
        ON DELETE CASCADE ON UPDATE CASCADE,

  CONSTRAINT education_ibfk_2
        FOREIGN KEY (institution_id)
        REFERENCES Institution (institution_id)
        ON DELETE CASCADE ON UPDATE CASCADE,

  PRIMARY KEY(profile_id, institution_id)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

*/
