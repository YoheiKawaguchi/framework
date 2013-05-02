<?php
/**
 * FlashMessage Class
 *
 * Manage flash messages by using Zend_Session
 * 
 * By default, flash messages are automatically deleted when;
 *   - once fetched, or
 *   - after 2 hops (request)
 */
class Core_FlashMessage
{
    /** @var Zend_Session_Namespace $flashMessageNamespace */
    protected $flashMessageNamespace;
    private $namespace = 'flashMessageNamespace';
    
    /**
     * @param int $hops Flash Messages are automatically deleted after $hops request(s)
     */
    final function __construct($hops = 2)
    {
        if (method_exists($this, '__beforeParentConstruct')) {
            $this->__beforeParentConstruct();
        }
            
        $this->flashMessageNamespace = new Zend_Session_Namespace($this->namespace);
        
        // if nothing is set yet, then initialize it
        if (! isset($_SESSION[$this->namespace]['flash']) || empty($_SESSION[$this->namespace]['flash'])) {
            if($hops > 0) {
                $this->flashMessageNamespace->setExpirationHops($hops);
            }
            $this->flashMessageNamespace->flash = array();
        }
        
        if (method_exists($this, '__afterParentConstruct')) {
            $this->__afterParentConstruct();
        }
    }
    
    /**
     * Stores a flash message.  By default a flash message is automatically deleted once fetched
     *
     * @param  string  $type  key identifying the flash message (eg. 'error', 'success', 'info')
     * @param  string  $msg   flash message
     */
    public function setFlash($type, $msg = null)
    {
        $this->flashMessageNamespace->flash[$type][] = $msg;
    }
    
    /**
     * Checks if a type of flash message exists
     *
     * @param  string  $type  key identifying the flash message (eg. 'error', 'success', 'info')
     * @return boolean        whether the specified flash message exists
     */
    public function hasFlash($type)
    {
        if(isset($this->flashMessageNamespace->flash[$type]) && !empty($this->flashMessageNamespace->flash[$type])) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Fetch one type of flash messages.
     * By default, flash messages are automatically deleted once fetched
     *
     * @param  string  $type    key identifying the flash message (eg. 'error', 'success', 'info')
     * @param  boolean $delete  whether the messages get deleted after fetching them
     * @return mixed            the message(s) or null if empty
     */
    public function getFlash($type, $delete = true)
    {
        if(isset($this->flashMessageNamespace->flash[$type]) && !empty($this->flashMessageNamespace->flash[$type])) {
            $return = $this->flashMessageNamespace->flash[$type];
            if($delete) {
                $this->flashMessageNamespace->flash[$type] = array();
            }
            return $return;
        } else {
            return null;
        }
    }
    
    /**
     * Fetch all the types of flash messages. 
     * By default, flash messages are automatically deleted once fetched
     * 
     * @param  boolean $delete  whether the messages get deleted after fetching them
     * @return mixed            the message(s) or null if empty
     */
    public function getFlashes($delete = true)
    {
        if(isset($this->flashMessageNamespace->flash) && !empty($this->flashMessageNamespace->flash)) {
            $return = $this->flashMessageNamespace->flash;
            if($delete) {
                $this->flashMessageNamespace->flash = array();
            }
            return $return;
        } else {
            return null;
        }
    }
}
