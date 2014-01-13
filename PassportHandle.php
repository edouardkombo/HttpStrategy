<?php

/**
 * Main docblock
 *
 * PHP version 5
 *
 * @category  PassportHandle
 * @package   HttpStrategy
 * @author    Edouard Kombo <edouard.kombo@gmail.com>
 * @copyright 2013-2014 Edouard Kombo
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * @version   GIT: 1.0.0
 * @link      http://www.breezeframework.com/thetrollinception.php
 * @since     1.0.0
 */
namespace TTI\HttpStrategy;

use TTI\AbstractFactory\HandleAbstraction;

/**
 * PassportHandle responsibility is to handle session.
 *
 * @category PassportHandle
 * @package  HttpStrategy
 * @author   Edouard Kombo <edouard.kombo@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT License
 * @link     http://www.breezeframework.com/thetrollinception.php
 */
class PassportHandle extends HandleAbstraction
{
    /**
     *
     * @var string $input
     */
    protected $input;    

    /**
     *
     * @var integer $id
     */
    protected $id;

    /**
     * Constructor
     * Initialize session storage parameters, and create session
     * 
     * @param string  $handler  Handler for session storage
     * @param string  $path     Path for session storage (memory or disk)
     * @param integer $lifetime Lifetime session duration
     */
    public function __construct($handler, $path = null, $lifetime = null)
    {
        $handler = ($handler === null) ? 'files' : $handler ;
        $path = ($path === null) ? session_save_path() : $path ;
        $lifetime = ($lifetime === null) ? 1440 : $lifetime ;
        
        ini_set('session.save_handler', $handler);
        ini_set('session.save_path', $path);
        ini_set('session.gc_maxlifetime', $lifetime);
        session_start();
        $this->id = session_id();
    }
    
    /**
     * Cloner
     * 
     * @return void
     */
    public function __clone()
    {
    }      
    
    /**
     * Get the type of superglobal to fetch
     * 
     * @param string $value Value of the superglobal
     * 
     * @return \TTI\HttpStrategy\RequestHandle
     */
    protected function input($value = null)
    {
        $this->input = $_SESSION;
        
        return (object) $this;
    }     
    
    /**
     * Regenerate session id.
     *
     * @return \TTI\HttpStrategy\PassportHandle
     */
    protected function regenerate()
    {
        $this->id = session_regenerate_id();
        
        return (object) $this;
    }    
    
    /**
     * Set key/value in session.
     *
     * @param mixed $key   Key of the array
     * @param mixed $value Value to assign
     * 
     * @return \TTI\HttpStrategy\PassportHandle
     */
    public function set($key, $value)
    {
        $this->input[$key] = $value;
        
        return (object) $this;
    }   
    
    /**
     * Retrieve value stored in session by key.
     *
     * @param mixed $key Key to retrieve
     * 
     * @throws \RuntimeException
     * @return string
     */
    public function get($key = null)
    {
        try {
            if ($key === null) {
                return $this->input;
            } elseif (is_array($this->input) && isset($this->input[$key])) {
                return $this->input[$key];
            }
            
            throw new \RuntimeException("$key is not a valid attribute!");
            
        } catch(\RuntimeException $ex) {
            $ex->getMessage();   
        }
    }
    
    /**
     * Destroys the session.
     * 
     * @return \TTI\HttpStrategy\PassportHandle
     */
    public function delete()
    {
        session_destroy();
        $this->input = array();
        
        return (object) $this;
    }    
}
