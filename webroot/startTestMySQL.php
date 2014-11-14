<?php

// Error reporting
error_reporting(-1);              // Report all type of errors
ini_set('display_errors', 1);     // Display all errors
ini_set('output_buffering', 0);   // Do not buffer outputs, write directly

// Read config file
$options = require "config_mysql.php";

// MySQL-info is setted up, continue...
require "includeTestHTMLTable.php";
