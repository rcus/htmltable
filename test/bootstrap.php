<?php

// Autoload for PHPUnit
include __DIR__ . "/../autoloader.php";

// Autoload for composer (CDatabase)
include __DIR__ . "/../vendor/autoload.php";

// Options for SQLite
$options = require __DIR__ . "/../webroot/database_sqlite.php";
