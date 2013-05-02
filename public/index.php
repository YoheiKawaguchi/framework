<?php
// errors are handeled by custom error handler
// @see /library/global_functions.php
error_reporting(0);
ini_set('display_errors','0');
ini_set('mbstring.internal_encoding', "UTF-8");

require_once '../config/config.php';
require_once '../library/global_functions.php';

// Ensure library/ and module/ are in include_path
set_include_path(implode(PATH_SEPARATOR, array (
    DIR_LIBRARY,
    DIR_MODULE
)));

Zend_Session::start();

// route and handle the request
$dispatcher = new Core_Dispatcher;
$dispatcher->dispatch();
