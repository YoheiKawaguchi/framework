<?php
// system init
spl_autoload_register('myAutoloader');
set_error_handler('myErrorHandler');
set_exception_handler('myExceptionHandler');
register_shutdown_function('myShutdownHandler');

/**
 * Class auto loader
 * 
 * You do not need to include/require class files anymore, you can simply 'new'
 *
 * @param $name
 */
function myAutoloader($name) {
    $name = str_replace('_', '/', $name);
    $list = explode('/', $name);
    $fileName = $list[ count($list) - 1 ];
    $dir = implode('/', explode('/', $name, -1));
    $file = addExtension($fileName);
    
    include $dir . '/' . $file;
}

/**
 * Conversion: Error to Exception
 * Exception is immediatly caught, so that it can not be caught anywhere else
 *
 * @param $errno
 * @param $errstr
 * @param $errfile
 * @param $errline
 */
function myErrorHandler($errno, $errstr, $errfile, $errline) {
    $msg = $errstr . " on " . $errfile . " at line " . $errline;
    
    if(APPLICATION_ENV !== 'live') {
        // set Flash Message and display error page unless it is the live site
        $flash = new Core_FlashMessage;
        $flash->setFlash('error', $msg);
    }
}

/**
 * Exceptions are caught here.
 * You can still use use try/catch if you need to handle exception in a specific way
 * 
 * @param $exception Exception object
 */
function myExceptionHandler(Exception $exception) {
    $error['message'] = $exception->getMessage();
    $error['file']    = $exception->getFile();
    $error['line']    = $exception->getLine();
    $error['type']    = $exception->getCode();
    
    myShutdownHandler($error);
}

/**
 * To be executed after script execution finishes or exit() is called.
 * All the fatal errors are caught here.
 * Set an error message in Flash Message and rollback DB if necessary
 * 
 * TODO log or report(send an email?) the error
 */
function myShutdownHandler($error = null) {
    if(empty($error)) {
        $error = error_get_last();
    }
    
    if (! empty($error)) {
        
        //TODO log or report(send an email?) the error here
        
        $msg = $error['message'] . " on " . $error['file'] . " at line " . $error['line'];
        $view = new Core_View;
        
        if(APPLICATION_ENV === 'live') {
            // Display the maintenance page on live site
            $view->render('Common', PAGE_ERROR_LIVE);
        } else {
            // set Flash Message and display error page
            $flash = new Core_FlashMessage;
            $flash->setFlash('error', $msg);
            
            $view->render('Common', PAGE_ERROR_DEV);
        }
        
        // rollback DB if necessary
        $pdo = new Core_Model;
        if($pdo->db->inTransaction()) {
            $pdo->db->rollBack();
        }
        
        exit;
    }
}

/**
 * If the $name does not have extension .php, then add it
 *
 * @param $name
 * @return string
 */
function addExtension($name)
{
    if(substr(strrchr($name, '.'), 1) === 'php') {
        return $name;
    } else {
        return $name . '.php';
    }
}

/**
 * Redirect to another URL and exit the current request
 *
 * @param string $url
 * @param int    $httpCode HTTP code to be used when redirecting
 */
function redirect($url, $httpCode = 301)
{
    switch ($httpCode) {
        case 307:
            $header = "307 Temporary Redirect";
            break;
        case 401:
            $header = "401 Unauthorized";
            break;
        case 404:
            $header = "404 Not Found";
            break;
        case 405:
            $header = "405 Method Not Allowed";
            break;
        case 503:
            $header = "503 Service Temporarily Unavailable";
            break;
        default:
            $header = "301 Moved Permanently";
    }

    header("HTTP/1.1 {$header}");
    header("Location: {$url}");
    exit;
}
