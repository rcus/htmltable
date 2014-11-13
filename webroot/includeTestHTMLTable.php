<?php

// Get required files
require "../vendor/mos/cdatabase/src/Database/TSQLQueryBuilderBasic.php";
require "../vendor/mos/cdatabase/src/Database/CDatabaseBasic.php";
require "../src/htmltable/CHTMLTable.php";

// Create a new object
$table = new rcus\HTMLTable\CHTMLTable();

// Carry out som tests, $table must exist
$table->setOptions($options);
$table->connect();
//$table->connect('debug');

// Create tabledata
require __DIR__ . '/includeCreateTableData.php';

