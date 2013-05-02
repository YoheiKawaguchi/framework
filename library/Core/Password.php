<?php
/**
 * Core_Password
 *
 * Create a random password in plain text or encrypted, and verify password.
 * By default, it uses 'sha512' algorithm
 * @see http://php.net/manual/en/function.hash.php
 */
class Core_Password
{
    private $passwordLength = 8;
    private $algorithm      = 'sha512';// available since PHP 5.3.2
    private $passwordChars  = "abcdefghijkmnprstwxyzABCDEFGHJKMNPQRSTUWXYZ123456789";
    
    final function __construct($algorithm = null)
    {
        if (method_exists($this, '__beforeParentConstruct')) {
            $this->__beforeParentConstruct();
        }
        
        if(empty($algorithm)) {
            // PHP version check for 'sha512'
            if(PHP_VERSION_ID < 50302) {
                echo 'To use Core_Password (sha512), PHP version must be 5.3.2 or above';
                exit;
            }
        } else {
            $this->algorithm = $algorithm;
        }
        
        if (method_exists($this, '__afterParentConstruct')) {
            $this->__afterParentConstruct();
        }
        
    }
    
    /*
     * Create and return encrypted string
     * If $str is given, then encrypt it. If null, then randomly generate
     * 
     * @param  string  $str  plain string
     * @param  string  encrypted string
     */
    public function create($str = null)
    {
        if(empty($str)) {
            $str = $this->createRandomString();
        }
        
        return hash($this->algorithm, $str);
    }
    
    /*
     * Compare plain text password and encrypted password
     * 
     * @param  string  $password    plain text password (e.g. user input)
     * @param  string  $securePass  encrypted password (e.g. the password stored on DB)
     * @return boolean
     */
    public function verify($password, $encryptedPass)
    {
        if ($this->create($password) === $encryptedPass) {
            return true;
        } else {
            return false;
        }
    }
    
    /*
     * Generate a random string in plain text (not encrypted)
     * 
     * @param  int     $passwordLength  length
     * @param  string  $passwordChars   list of characters to be used
     * @return string  randomly generated string
     */
    public function createRandomString($passwordLength = 0, $passwordChars = null)
    {
        if($passwordLength < 1) {
            $passwordLength = $this->passwordLength;
        }
        if(empty($passwordChars)) {
            $passwordChars = $this->passwordChars;
        }
    
        //remember to declare $pass as an array
        $pass = array();
    
        //put the length -1 in cache
        $alphaLength = strlen($passwordChars) - 1;
    
        for ($i = 0; $i < $passwordLength; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $passwordChars[$n];
        }
        return implode($pass);
    }
}
