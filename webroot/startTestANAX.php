<?php
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader.
require __DIR__.'/config_with_app.php';

// Include database support
$di->setShared('db', function() {
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require  __DIR__.'/database_sqlite.php');
    $db->connect();
    return $db;
});

// Create a table object
$table = new rcus\HTMLTable\CHTMLTable();

// Create tabledata
require __DIR__ . '/includeCreateTableData.php';

// Set options for table
$table->setTableOptions('test',
    array(
        'ID'         => 'id',
        'Förnamn'    => 'firstname',
        'Efternamn'  => 'surname',
        'Födelsedag' => 'birthdate'
    ));

// Create content for this page
$page = "<h1>HTMLtable</h1>";
$page .= $table->getHTML();

// Create route for this page
$app->router->add('', function() use ($app, $di) {
  $app->theme->setTitle("HTMLtable");
  $app->views->add('me/page', [
        'content' => $page
    ]);
});


// Let these two lines to be last on the page
$app->router->handle();
$app->theme->render();
