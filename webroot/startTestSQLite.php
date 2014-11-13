<?php

// Error reporting
error_reporting(-1);              // Report all type of errors
ini_set('display_errors', 1);     // Display all errors
ini_set('output_buffering', 0);   // Do not buffer outputs, write directly

// Precondition
if (!is_writable(__DIR__)) {
    die("This directory must be writable to create the SQLite database file.");
}

// Read config file
$options = require "../vendor/mos/cdatabase/webroot/config_sqlite.php";

// SQLite-info is setted up, continue...
require "includeTestHTMLTable.php";
