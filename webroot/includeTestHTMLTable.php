<?php

// Set page to charset UTF-8
header('Content-Type: text/html; charset=utf-8');

// Get required files
require "../vendor/mos/cdatabase/src/Database/TSQLQueryBuilderBasic.php";
require "../vendor/mos/cdatabase/src/Database/CDatabaseBasic.php";
require "../src/htmltable/CHTMLTable.php";

// Create a new object
$table = new rcus\HTMLTable\CHTMLTable($options);

// For debugging
$table->setVerbose(false);
//$table->connect('debug');

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
