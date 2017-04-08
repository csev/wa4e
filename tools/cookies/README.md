
Cookie Application
------------------

I have written this application two ways in the same folder:

* As a single PHP file using the "Dr. Chuck" MVC pattern
* As a Silex Applicatjn with nice URL routing and Twi templating

As a default, we run the silex version of the code.

If you want to run the "old school" version rename the `.htaccess`
file

    mv .htaccess .htaccess-save

You can check which version is running by looking for a comment
like: 

    <!-- Rendered from Cookie.twig -->
    <!-- Rendered using old school MVC index.php -->

Both versions do the same thing.

Old School
----------

All the model, view, and controller are stored in `index.php`

Silex Version
-------------

The `.htaccess` file moves all requests into `silex.php`.  This
file routes GET and POST requests into a controller stored in
`src/AppBundle/Cookies.php`.  The template is stored in 
`templates/Cookies.twig`.


