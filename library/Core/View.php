<?php
/**
 * Core_View
 *
 * This class gives all the controller classes the view related
 * methods such as; passing variables to view file, rendering view file etc...
 * This class is always instantiated in Core_Controller class
 */
class Core_View
{
    private $vars = array();
    private $layoutName;
    private $moduleName;
    private $viewName;

    final function __construct()
    {
        if (method_exists($this, '__beforeParentConstruct')) {
            $this->__beforeParentConstruct();
        }
        
        // set reserved vars
        $this->vars['pageTitle']    = '';
        $this->vars['flashMessage'] = '';
        
        if (method_exists($this, '__afterParentConstruct')) {
            $this->__afterParentConstruct();
        }
    }
    
    /**
     * Pass a variable to view/layout files
     * 
     * @param string $name
     * @param mixed  $value
     */
    public function set($name, $value)
    {
        $this->vars[$name] = $value;
    }

    /**
     * Render a view file. This also sets flash messages if there are any
     * 
     * @param  string  $moduleName name of the module
     * @param  string  $viewName   name of the view file (without extension)
     */
    public function render($moduleName, $viewName)
    {
        $flash = new Core_FlashMessage;
        $this->vars['flashMessage'] = $flash->getFlashes();
        
        $request = new Core_Request;
        $this->moduleName = ucfirst(strtolower($moduleName));
        $this->viewName = $viewName;
        unset($flash, $request, $moduleName, $viewName);

        // extract variables so the view file can use those variables
        extract( $this->vars );
        require_once(DIR_MODULE . $this->moduleName . '/View/' . addExtension(strtolower($this->viewName)));
    }

    /**
     * Render a layout file. You should call this method in a view file.
     *
     * @param  string  $moduleName name of the module
     * @param  string  $viewName   name of the view file (without extension)
     */
    public function includeLayout($moduleName, $layoutName)
    {
        $this->moduleName = $moduleName;
        $this->layoutName = $layoutName;
        unset($moduleName, $layoutName);

        // extract variables so the view file can use those variables
        extract( $this->vars );
        require_once(DIR_MODULE . $this->moduleName . '/View/Layout/' . addExtension(strtolower($this->layoutName)));
    }
}
