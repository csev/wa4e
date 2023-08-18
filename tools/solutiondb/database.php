<?php

// The SQL to uninstall this tool
$DATABASE_UNINSTALL = array(
"drop table if exists {$CFG->dbprefix}solutions_users",
"drop table if exists {$CFG->dbprefix}solutions_Profile",
"drop table if exists {$CFG->dbprefix}solutions_Position",
"drop table if exists {$CFG->dbprefix}solutions_Institution",
"drop table if exists {$CFG->dbprefix}solutions_Education",
"drop table if exists {$CFG->dbprefix}solutions_autos",
);

// The SQL to create the tables if they don't exist
$DATABASE_INSTALL = array(

array( "{$CFG->dbprefix}solutions_users",
"CREATE TABLE solutions_users (
   user_id INTEGER NOT NULL AUTO_INCREMENT,
   name VARCHAR(128),
   email VARCHAR(128),
   password VARCHAR(128),

   created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
   updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

   UNIQUE(email),
   PRIMARY KEY(user_id)
) ENGINE=InnoDB CHARSET=utf8;"
),

array( "{$CFG->dbprefix}solutions_Profile",
"CREATE TABLE solutions_Profile (
  profile_id INTEGER NOT NULL AUTO_INCREMENT,
  user_id INTEGER NOT NULL,
  first_name TEXT,
  last_name TEXT,
  email TEXT,
  headline TEXT,
  summary TEXT,

  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  PRIMARY KEY(profile_id),

  CONSTRAINT profile_ibfk_2
        FOREIGN KEY (user_id)
        REFERENCES solutions_users (user_id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
),

array( "{$CFG->dbprefix}solutions_Position",
"CREATE TABLE solutions_Position (
  position_id INTEGER NOT NULL AUTO_INCREMENT,
  profile_id INTEGER,
  rank INTEGER,
  year INTEGER,
  description TEXT,

  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  PRIMARY KEY(position_id),

  CONSTRAINT position_ibfk_1
        FOREIGN KEY (profile_id)
        REFERENCES solutions_Profile (profile_id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
),

array( "{$CFG->dbprefix}solutions_Institution",
"CREATE TABLE solutions_Institution (
  institution_id INTEGER NOT NULL AUTO_INCREMENT,
  name VARCHAR(255),

  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  PRIMARY KEY(institution_id),
  UNIQUE(name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
),

array( "{$CFG->dbprefix}solutions_Education",
"CREATE TABLE solutions_Education (
  profile_id INTEGER,
  institution_id INTEGER,
  rank INTEGER,
  year INTEGER,

  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  CONSTRAINT education_ibfk_1
        FOREIGN KEY (profile_id)
        REFERENCES solutions_Profile (profile_id)
        ON DELETE CASCADE ON UPDATE CASCADE,

  CONSTRAINT education_ibfk_2
        FOREIGN KEY (institution_id)
        REFERENCES solutions_Institution (institution_id)
        ON DELETE CASCADE ON UPDATE CASCADE,

  PRIMARY KEY(profile_id, institution_id)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
),

array( "{$CFG->dbprefix}solutions_autos",
"CREATE TABLE solutions_autos (
   auto_id INT UNSIGNED NOT NULL AUTO_INCREMENT KEY,
   user_id INTEGER,
   make VARCHAR(128),
   year INTEGER,
   mileage INTEGER,

   created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
   updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
)

);

// Database upgrade
$DATABASE_UPGRADE = function($oldversion) {
    global $CFG, $PDOX;

    $PDOX->queryDie("INSERT IGNORE INTO solutions_users (name,email,password)
        VALUES ('Chuck','csev@umich.edu','1a52e17fa899cf40fb04cfc42e6352f1');");
    $PDOX->queryDie("INSERT IGNORE INTO solutions_users (name,email,password)
        VALUES ('UMSI','umsi@umich.edu','1a52e17fa899cf40fb04cfc42e6352f1');");
    $PDOX->queryDie("INSERT IGNORE INTO solutions_Institution (name) VALUES ('University of Michigan');");
    $PDOX->queryDie("INSERT IGNORE INTO solutions_Institution (name) VALUES ('University of Virginia');");
    $PDOX->queryDie("INSERT IGNORE INTO solutions_Institution (name) VALUES ('University of Oxford');");
    $PDOX->queryDie("INSERT IGNORE INTO solutions_Institution (name) VALUES ('University of Cambridge');");
    $PDOX->queryDie("INSERT IGNORE INTO solutions_Institution (name) VALUES ('Stanford University');");
    $PDOX->queryDie("INSERT IGNORE INTO solutions_Institution (name) VALUES ('Duke University');");
    $PDOX->queryDie("INSERT IGNORE INTO solutions_Institution (name) VALUES ('Michigan State University');");
    $PDOX->queryDie("INSERT IGNORE INTO solutions_Institution (name) VALUES ('Mississippi State University');");
    $PDOX->queryDie("INSERT IGNORE INTO solutions_Institution (name) VALUES ('Montana State University');");

    return 202001010000;

}; // Don't forget the semicolon on anonymous functions :)

// Do the actual migration if we are not in admin/upgrade.php
if ( isset($CURRENT_FILE) ) {
    include $CFG->dirroot."/admin/migrate-run.php";
}

