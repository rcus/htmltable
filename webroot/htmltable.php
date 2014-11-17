<?php
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader.
require 'config_with_app.php';

// Database configuration
$dsnfile = 'database_mysql.php';
$options = (file_exists(ANAX_APP_PATH.'config/'.$dsnfile))
    ? require ANAX_APP_PATH.'config/'.$dsnfile
    : require ANAX_INSTALL_PATH.'vendor/rcus/htmltable/webroot/'.$dsnfile;

// Create a table object
$table = new rcus\HTMLTable\CHTMLTable();
$table->setOptions($options);
$table->connect();

// Create tabledata
require ANAX_INSTALL_PATH . 'vendor/rcus/htmltable/webroot/includeCreateTableData.php';

// Set options for table
$table->setTableOptions('test',
    array(
        'ID'         => 'id',
        'Förnamn'    => 'firstname',
        'Efternamn'  => 'surname',
        'Födelsedag' => 'birthdate'
    ));
//$table->setPaginationOn(false);

// Create content for this page
$app->theme->setTitle("HTMLtable");
$app->views->addString("<h1>HTMLtable</h1>\n".
    $table->getHTML()
);

// Let this line to be last on the page
$app->theme->render();