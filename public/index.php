<?php

use Core\App;

session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__.'/../vendor/autoload.php';

App::run();

session_destroy();
