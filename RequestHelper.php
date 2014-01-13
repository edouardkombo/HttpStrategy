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

/**
 * RequestHelper responsibility is to handle helpers for request
 *
 * @category RequestHelpers
 * @package  HttpStrategy
 * @author   Edouard Kombo <edouard.kombo@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT License
 * @link     http://www.breezeframework.com/thetrollinception.php
 */
class RequestHelper
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
        $value = filter_input('INPUT_SERVER', 'HTTP_X_REQUESTED_WITH');
        
        return (boolean) (isset($value) && ($value=='XMLHttpRequest')) ? true : false ;
    }
    
    /**
     * Detect if current request is post method
     * 
     * @return boolean
     */
    public function isPost()
    {
        $value = filter_input('INPUT_SERVER', 'REQUEST_METHOD');
        
        return (boolean) (isset($value) && ($value=='POST')) ? true : false ;
    }
    
    /**
     * Detect if current request is get method
     * 
     * @return boolean
     */
    public function isGet()
    {
        $value = filter_input('INPUT_SERVER', 'REQUEST_METHOD');
        
        return (boolean) (isset($value) && ($value=='GET')) ? true : false ;
    }    
    
    /**
     * Detect current method
     * 
     * @return string
     */
    public function getMethod()
    {
        $value = filter_input('INPUT_SERVER', 'REQUEST_METHOD');
        
        return (string) $value ;
    } 
    
    /**
     * Detect encoding
     * 
     * @return string
     */
    public function getEncoding()
    {
        $value = filter_input('INPUT_SERVER', 'HTTP_ACCEPT_ENCODING');        
        
        return (string) $value;
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
}
