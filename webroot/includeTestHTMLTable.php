<?php

// Set page to charset UTF-8
header('Content-Type: text/html; charset=utf-8');

// Get required files
require "../vendor/mos/cdatabase/src/Database/TSQLQueryBuilderBasic.php";
require "../vendor/mos/cdatabase/src/Database/CDatabaseBasic.php";
require "../src/htmltable/CHTMLTable.php";

// Create a new object
$table = new rcus\HTMLTable\CHTMLTable();

// Carry out som tests, $table must exist
$table->setOptions($options);
$table->setVerbose(false);
$table->connect();
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

// Get the HTML
echo $table->getHTML();
