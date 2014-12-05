<?php

// Set page to charset UTF-8
header('Content-Type: text/html; charset=utf-8');

// Get the autoloader
$autodir = __DIR__ . '/../vendor/';             // dir to autoload.php in a stand-alone project
if (!file_exists($autodir.'autoload.php')) {
    $autodir = __DIR__ . '/../../../';          // dir to autoload.php as required
}
require $autodir.'autoload.php';

// Create a new object
$table = new Rcus\HTMLTable\CHTMLTable($options);

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

//$table->setPaginationOn(false);

// Get the HTML
echo $table->getHTML();
