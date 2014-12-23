[![Build Status](https://travis-ci.org/rcus/htmltable.svg?branch=master)](https://travis-ci.org/rcus/htmltable) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/rcus/htmltable/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/rcus/htmltable/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/rcus/htmltable/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/rcus/htmltable/?branch=master)

HTMLtable
=========

Use HTMLtable to create and show tables with pagination.

Made for [Anax-MVC](https://github.com/mosbth/Anax-MVC) in the course [phpmvc](http://dbwebb.se/phpmvc) at [BTH](http://www.bth.se).


Use with Anax
-------------
###Install
Add [rcus/htmltable](https://packagist.org/packages/rcus/htmltable) to your composer.json file with `require`.

    "minimum-stability": "dev",
    "require": {
        ...
        "rcus/htmltable": "dev-master"
    }

Run `composer install --no-dev` or `composer update --no-dev` to get rcus/htmltable. [rcus/htmltable](https://packagist.org/packages/rcus/htmltable) require [mos/cdatabase](https://github.com/mosbth/cdatabase) and will install it for you. While mos/cdatabase is a dev version you need to set `"minimum-stability": "dev"`.

Tip: If you would like to test HTMLtable, copy `htmltable.php` from `/vendor/rcus/htmltable/webroot` to `/webroot` and point your browser to that file.

###Usage
First we have to create a table object in your pagecontroller.

    // Create a table object
    $table = new rcus\HTMLTable\CHTMLTable(require ANAX_APP_PATH . 'config/database_sqlite.php');

You maybe have to edit the path and filename for your configuration of the database. If you do not have any config-file, copy from `vendor/rcus/htmltable/webroot` and edit (if needed). Read more about this at [dbwebb](http://dbwebb.se/opensource/cdatabase#connect).

If you would like to add some testdata to the table, add this:

    // Create tabledata
    require ANAX_INSTALL_PATH . 'vendor/rcus/htmltable/webroot/includeCreateTableData.php';

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

Finally, create the table. The fun part...

    // Get the HTMLtable
    $table->getHTML();

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