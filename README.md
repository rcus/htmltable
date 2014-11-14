HTMLtable
=========

Use HTMLtable to create and show tables with pagination.

Made for [Anax-MVC](https://github.com/mosbth/Anax-MVC) in the course [phpmvc](http://dbwebb.se/phpmvc) at [BTH](http://www.bth.se).


Use with Anax
-------------
###Install
Add [rcus/htmltable](https://packagist.org/packages/rcus/htmltable) to your composer.json file like with `require`.

    "require": {
        "rcus/htmltable": "dev-master"
    }

###Create a pagecontroller
Start with create a basic ANAX pagecontroller. Include the config and create a start route.

    <?php
    /**
     * This is a Anax pagecontroller.
     *
     */

    // Get environment & autoloader.
    require __DIR__.'/config_with_app.php';

    // Create content for this page
    $page = "<h1>HTMLtable</h1>";

    // Create route for this page
    $app->router->add('', function() use ($app, $di) {
      $app->theme->setTitle("HTMLtable");
      $app->views->add('me/page', [
            'content' => $page;
        ]);
    });


    // Let these two lines to be last on the page
    $app->router->handle();
    $app->theme->render();

###Include CDatabase
[rcus/htmltable](https://packagist.org/packages/rcus/htmltable) require [mos/cdatabase](https://github.com/mosbth/cdatabase) and will install it for you.

You have to include [mos/cdatabase](https://github.com/mosbth/cdatabase) in Anax, either in current pagecontroller just before `// Create content for this page`, or in `config_with_app.php`.

    // Include database support
    $di->setShared('db', function() {
        $db = new \Mos\Database\CDatabaseBasic();
        $db->setOptions(require ANAX_APP_PATH . 'config/database_sqlite.php');
        $db->connect();
        return $db;
    });

If you will use MySQL, change the filename above to `database_mysql.php`. Check your settings in the selected config file.

###Preparing the table
First we have to create a table object. You can put all this stuff below just before `// Create content for this page`.

    // Create a table object
    $table = new rcus\HTMLTable\CHTMLTable();

If you would like to add some data to the table, add this:

    // Create tabledata
    require __DIR__ . '/includeCreateTableData.php';

Set up your table with the testdata we created above.

    // Set options for table
    $table->setTableOptions('test',
        array(
            'ID'         => 'id',
            'Förnamn'    => 'firstname',
            'Efternamn'  => 'surname',
            'Födelsedag' => 'birthdate'
        ));

'test' refers to the table name in the database. Then add the columns you want to include in your table in the array, where $key will be the column's title and $value is the column's name in the database.

###Finally, create the table
And now, the fun part... Get the HTML for the table! Add this to `// Create content for this page`.

    $page .= $table->getHTML();

Well, it might not be that fun. But this line convert your table in the database to a HTML table.


About
-----
###Requirements
* PHP 5.3 or above
* [mos/cdatabase](https://github.com/mosbth/cdatabase)
* [Anax-MVC](https://github.com/mosbth/Anax-MVC) (for use with Anax)

###To-do list
* Specify which columns to order
* Make values clickable
* Make table cacheable
* Add some style (I know, it doesn't look that nice. But that's not a problem with your CSS-skills)

###Author
Marcus Törnroth (m@rcus.se)

###License
HTMLTable is licensed under the MIT License - see the `LICENSE.txt` file for details