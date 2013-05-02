<?php
/**
 * Core_Controller
 *
 * Core_Controller must always be extended when creating a controller class
 * This gives all the child controller classes the access to request 
 * parameters (such as POST) and view files
 */
class Core_Controller
{
    /** @var $request Core_Request */
    protected $request;

    /** @var $view Core_View */
    protected $view;
    
    final function __construct()
    {
        if (method_exists($this, '__beforeParentConstruct')) {
            $this->__beforeParentConstruct();
        }

        $this->request = new Core_Request;
        $this->view    = new Core_View;

        if (method_exists($this, '__afterParentConstruct')) {
            $this->__afterParentConstruct();
        }
    }
}