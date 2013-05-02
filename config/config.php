<?php
// Site settings
define('HOSTNAME_DEV',     'localhost');
define('HOSTNAME_TEST',    'test.example.com');
define('HOSTNAME_LIVE',    'example.com');

if ($_SERVER["HTTP_HOST"] === HOSTNAME_DEV) {
    // settings for development environment
    define('HOSTNAME',              HOSTNAME_DEV);
    define('APPLICATION_ENV',      'dev');
    define('DB_SERVER',            'localhost');
    define('DB_SERVER_USERNAME',   'root');
    define('DB_SERVER_PASSWORD',   '');
    define('DB_DATABASE',          'pure');
} elseif ($_SERVER["HTTP_HOST"] === HOSTNAME_TEST) {
    // settings for test environment
    define('HOSTNAME',              HOSTNAME_TEST);
    define('APPLICATION_ENV',      'test');
    define('DB_SERVER',            'localhost');
    define('DB_SERVER_USERNAME',   'samepleUser');
    define('DB_SERVER_PASSWORD',   'samplePassword');
    define('DB_DATABASE',          'sampleDatabase');
} else {
    // settings for live environment
    define('HOSTNAME',              HOSTNAME_LIVE);
    define('APPLICATION_ENV',      'live');
    define('DB_SERVER',            'localhost');
    define('DB_SERVER_USERNAME',   'samepleUser');
    define('DB_SERVER_PASSWORD',   'samplePassword');
    define('DB_DATABASE',          'sampleDatabase');
}

// path
define('DIR_BASE',       realpath(dirname(__FILE__)."/../"));
define('DIR_LIBRARY',    DIR_BASE . '/library/');
define('DIR_MODULE',     DIR_BASE . '/module/');

// name of the view file in /module/Common/View/ that serves 404 error
define('PAGE_NOT_FOUND',     '404');

// name of the view file in /module/Common/View/ that handles PHP errors and exceptions
define('PAGE_ERROR_LIVE',    'maintenance'); // on live environment
define('PAGE_ERROR_DEV',     'error'); // on dev/test environment

// PHP version (in 5 digits)
if (!defined('PHP_VERSION_ID')) {
    $version = explode('.', PHP_VERSION);
    define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
}
