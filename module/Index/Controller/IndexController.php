<?php
class Index_Controller_IndexController extends Core_Controller
{
    function indexAction()
    {
        // set variables for the view file
        $this->view->set('pageTitle', 'Hello World!');
        $this->view->set('message',   'A simple test page with the usual Hello World');
        
        // render view file
        $this->view->render('Index', 'index');
    }
}
