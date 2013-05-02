<?php
/**
 * Core_Request
 *
 * This class controls superglobal variables such as POST GET,
 * and assign them as objects.
 * This class is always instantiated by the Core_Controller class, giving all
 * the child controller class the access to the request objects
 * 
 * POST/GET are supposed to be readonly properties, thus, there are no setters.
 */
class Core_Request
{    
    private static $request;
    
    private $post;
    private $query;

    final function __construct()
    {
        if (method_exists($this, '__beforeParentConstruct')) {
            $this->__beforeParentConstruct();
        }
        
        if(null !== self::$request) {
            return;
        }

        if(isset($GLOBALS['request']) && !empty($GLOBALS['request'])) {
            self::$request = $GLOBALS['request'];
        }

        if (isset($GLOBALS['request']['query']) && ! empty($GLOBALS['request']['query'])) {
            foreach ($GLOBALS['request']['query'] as $key => $value) {
                $this->query[$key] = $value;
            }
        }
        
        if (isset($_POST) && ! empty($_POST)) {
            foreach ($_POST as $key => $value) {
                $this->post[$key] = $value;
            }
        }
        
        if (method_exists($this, '__afterParentConstruct')) {
            $this->__afterParentConstruct();
        }
    }

    public function getActionName()
    {
        if(isset(self::$request['action']) && ! empty(self::$request['action'])) {
            return self::$request['action'];
        } else {
            return null;
        }
    }

    public function getControllerName()
    {
        if(isset(self::$request['controller']) && ! empty(self::$request['controller'])) {
            return self::$request['controller'];
        } else {
            return null;
        }
    }

    public function getModuleName()
    {
        if(isset(self::$request['module']) && ! empty(self::$request['module'])) {
            return self::$request['module'];
        } else {
            return null;
        }
    }

    public function getPost($key = null)
    {
        $result = null;
        if (null === $key || empty($this->post)) {
            $result = $this->post;
        } else {
            if (true == array_key_exists($key, $this->post)) {
                $result = $this->post[$key];
            }
        }
        return $result;
    }

    public function getQuery($key = null)
    {
        $result = null;
        if (null === $key || empty($this->query)) {
            $result = $this->query;
        } else {
            if (true == array_key_exists($key, $this->query)) {
                $result = $this->query[$key];
            }
        }
        return $result;
    }

    public function getRequest($key = null)
    {
        $result = null;
        if (null === $key || empty($this->query)) {
            $result = $this->query;
        } else {
            if (true == array_key_exists($key, $this->query)) {
                $result = $this->query[$key];
            }
        }
        return $result;
    }
    
    public function isPost()
    {
        $post = $this->getPost();
        if(!empty($post)) {
            return true;
        }
        return false;
    }
}
