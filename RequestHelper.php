<?php

/**
 * Main docblock
 *
 * PHP version 5
 *
 * @category  RequestHelpers
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
 * RequestHelper responsibility is to handle helpers for request
 *
 * @category RequestHelpers
 * @package  HttpStrategy
 * @author   Edouard Kombo <edouard.kombo@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT License
 * @link     http://www.breezeframework.com/thetrollinception.php
 */
class RequestHelper extends HandleAbstraction
{   
    /**
     * Constructor
     */
    public function __construct()
    {
    }   
    
    /**
     * Detect if current request is ajax request
     * 
     * @return boolean
     */
    public function isAjax()
    {
        $value = filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH');
        return (boolean) (isset($value) && ($value=='XMLHttpRequest')) ? true : false ;
    }
    
    /**
     * Detect if current request is post method
     * 
     * @return boolean
     */
    public function isPost()
    {
        $value = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        
        return (boolean) (isset($value) && ($value=='POST')) ? true : false ;
    }
    
    /**
     * Detect if current request is get method
     * 
     * @return boolean
     */
    public function isGet()
    {
        $value = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        
        return (boolean) (isset($value) && ($value=='GET')) ? true : false ;
    }    
    
    /**
     * Detect if current request is a cli request
     * 
     * @return boolean
     */
    public function isCli()
    {
        return (boolean) is_cli();
    }    
    
    /**
     * Detect current method
     * 
     * @return string
     */
    public function method()
    {
        return filter_input(INPUT_SERVER, 'REQUEST_METHOD');
    } 
    
    /**
     * Detect encoding
     * 
     * @return string
     */
    public function encoding()
    {
        return filter_input(INPUT_SERVER, 'HTTP_ACCEPT_ENCODING');        
    }
    
    /**
     * Get current URI
     * 
     * @return mixed
     */
    public function uri()
    {
        return filter_input(INPUT_SERVER, 'REQUEST_URI');        
    }    
    
    /**
     * Get Ip address
     * 
     * @return mixed
     */
    public function ip()
    {
        return filter_input(INPUT_SERVER, 'SERVER_ADDR');        
    }
    
     /**
     * Get Ip of the client requesting the page
     * 
     * @return mixed
     */
    public function clientIp()
    {
        return filter_input(INPUT_SERVER, 'REMOTE_ADDR');        
    }   
    
    /**
     * Get Anything more about $_SERVER superglobal
     * 
     * @param string $key Key of the $_SERVER to retrieve
     * 
     * @return mixed
     */
    public function get($key = null)
    {
        try {
            if ($key === null) {
                throw new \RuntimeException("Key can not be empty!");
            }
            
            return filter_input(INPUT_SERVER, $key);            
            
        } catch (\RuntimeException $ex) {
            echo $ex->getMessage();
            exit();
        }        
    }   
}
