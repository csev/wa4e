Web Applications for Everybody (WA4E)
=====================================

Course materials for www.wa4e.com

Setup On Localhost
------------------

Here are the steps to set this up on localhost on a Macintosh using MAMP.

Install MAMP (or similar) using https://www.wa4e.com/install

Check out this repo into a top level folder in htdocs

    cd /Applications/MAMP/htdocs
    git clone https://github.com/csev/wa4e.git

Go into the newly checked out folder and get a copy of Tsugi:

    cd wa4e
    git clone https://github.com/csev/tsugi.git

Create a database in your SQL server:

    CREATE DATABASE tsugi DEFAULT CHARACTER SET utf8;
    CREATE USER 'ltiuser'@'localhost' IDENTIFIED BY 'ltipassword';
    GRANT ALL ON tsugi.* TO 'ltiuser'@'localhost';
    CREATE USER 'ltiuser'@'127.0.0.1' IDENTIFIED BY 'ltipassword';
    GRANT ALL ON tsugi.* TO 'ltiuser'@'127.0.0.1';

Still in the tsugi folder set up config.php:

    cp config-dist.php config.php

Edit the config.php file, scroll through and set up all the variables.  As you scroll through the file
some of the following values are the values I use on my MAMP:

    $wwwroot = 'http://localhost:8888/wa4e/tsugi';   // Embedded Tsugi localhost
    
    ...
    
    $CFG->pdo = 'mysql:host=127.0.0.1;port=8889;dbname=tsugi'; // MAMP
    $CFG->dbuser    = 'ltiuser';
    $CFG->dbpass    = 'ltipassword';
    
    ...
    
    $CFG->adminpw = 'short';
    
    ...
    
    $CFG->apphome = 'http://localhost:8888/wa4e';
    $CFG->context_title = "Web Applications for Everybody";
    $CFG->lessons = $CFG->dirroot.'/../lessons.json';
    
    ... 
    
    $CFG->tool_folders = array("admin", "../tools", "../mod");
    $CFG->install_folder = $CFG->dirroot.'./../mod'; // Tsugi as a store
    
    ...
    
    $CFG->servicename = 'WA4E';

Then go to https://console.developers.google.com/apis/credentials and
create an "OAuth Client ID".  Make it a "Web Application", give it a name,
put the following into "Authorized JavaScript Origins":

        http://localhost

And these into Authorized redirect URIs:

    http://localhost/wa4e/tsugi/login.php
    http://localhost/wa4e/tsugi/login

Note: You do not need port numbers for either of these values in your Google
configuration.

Google will give you a 'client ID' and 'client secret', add them to `config.php`
as follows:

    $CFG->google_client_id = '96..snip..oogleusercontent.com';
    $CFG->google_client_secret = 'R6..snip..29a';

While you are there, you could "Create credentials", select "API
key", and name the key "My Google MAP API Key" and put the API
key into `config.php` like the following:

    $CFG->google_map_api_key = 'AIza..snip..9e8';

Starting the Application
------------------------

After the above configuration is done, navigate to your application:

    http://localhost:8888/wa4e/

It should complain that you have not created tables and suggest you 
use the Admin console to do that:

    http://localhost:8888/wa4e/tsugi/admin

It will demand the `$CFG->adminpw` from `config.php` (above) before 
unlocking the admin console.  Run the "Upgrade Database" option and
it should create lots of tables in the database and the red warning
message about bad database, should go away.

Got into the database and the `lti_key` table, find the row with the `key_key`
of google.com and put a value in the `secret` column - anything will do - 
just don't leave it empty or the internal LTI tools will not launch.

Next use the administrator interface to install the peer-grading tool
from the github repository:

    http://localhost:8888/wa4e/tsugi/admin/install

Click on "Available Modules" and install https://github.com/tsugitools/peer-grade

The other two LTI tools are already part of the wa4e repo and in `wa4e/tools`
folder.

Using the Application
---------------------

Navigate to:

    http://localhost:8888/wa4e/

You should click around without logging in and see if things work.

Then log in with your Google account and the UI should change.  In particular you should
see 'Assignments' and in Lessons you should start seeing LTI autograders.


Private Repos
-------------

You also need the `wa4e-private` checked out and the top level folder
`solutions` soft linked to `wa4e-private/assn`.

    ln -s wa4e-private/assn solutions

Also you need to set up the misc database so the solutions work using the
instructions in that folder.

