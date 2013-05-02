<?php
/**
 * Core_Dispatcher
 *
 * This class maps request URI and module/controller/action
 * such as http://hostname/module/controller/action/parametes
 */
class Core_Dispatcher
{
    private $sysRoot;
    
    final function __construct($path = null)
    {
        if (method_exists($this, '__beforeParentConstruct')) {
            $this->__beforeParentConstruct();
        }
    
        if(null !== $path) {
            $this->sysRoot = rtrim($path, '/');
        }
        
        if (method_exists($this, '__afterParentConstruct')) {
            $this->__afterParentConstruct();
        }
    }
    
    /**
     * Defines what url patterns get mapped into what module/controller/action.
     * if no route is provided 'index' is used
     */
    public function dispatch()
    {
        $param = str_replace($this->sysRoot, '', $_SERVER['REQUEST_URI']);
        $param = trim($param, "/");

        // Format instances
        $instance = $this->getInstance($param);
        
        // For later use in Core_Request
        $GLOBALS['request']['module']     = $instance['module'];
        $GLOBALS['request']['controller'] = $instance['controller'];
        $GLOBALS['request']['action']     = $instance['action'];
        $GLOBALS['request']['query']      = $instance['query'];

        $filename  = ucfirst(strtolower($instance['controller'])) . 'Controller';
        $className = ucfirst(strtolower($instance['module'])) . '_Controller_' . $filename;
        $fullPath  = DIR_MODULE . ucfirst(strtolower($instance['module'])) . '/Controller/' . $filename . '.php';
        
        // include, instantiate and call the appropriate action method
        if (! file_exists($fullPath)) {
            $view = new Core_View;
            $view->render('Common', PAGE_NOT_FOUND);
        } else {
            require_once $fullPath;
            $controllerInstance = new $className();
            $actionMethod = strtolower($instance['action']) . 'Action';

            if (method_exists($controllerInstance, $actionMethod)) {
                $controllerInstance->$actionMethod();
            } elseif (method_exists($controllerInstance, 'indexAction')) {
                $controllerInstance->indexAction();
            } else {
                $view = new Core_View;
                $view->render('Common', PAGE_NOT_FOUND);
            }
        }
    }

    private function getInstance($param)
    {
        $instance['module']     = "Index";
        $instance['controller'] = "Index";
        $instance['action']     = "index";
        $instance['query']      = '';

        $params = array();
        if ('' != $param) {
            $params = explode('/', $param);
        }

        // Module Name
        if (0 < count($params)) {
            $instance['module'] = ucfirst(strtolower($params[0]));
            array_shift($params);
        }
        // Controller Name
        if (0 < count($params)) {
            $instance['controller'] = ucfirst(strtolower($params[0]));
            array_shift($params);
        }
        // Action Name
        if (0 < count($params)) {
            $instance['action'] = strtolower($params[0]);
            array_shift($params);
        }

        // Get Query
        $instance['query'] = $this->setQuery($params);

        return $instance;
    }

    private function setQuery($params)
    {
        $query = array();
        $key = '';

        if (0 < count($params)) {
            for($i = 0, $size = count($params); $i < $size; ++$i) {

                // key of the variable
                if (0 === $i || $i % 2 === 0) {
                    $key = $params[$i];

                // value of the variable
                } else {
                    $query[$key] = $params[$i];
                }
            }
        }
        return $query;
    }
}
