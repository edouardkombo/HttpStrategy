<?php

/**
 * Main docblock
 *
 * PHP version 5
 *
 * @category  RequestHandle
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
 * RequestHandle responsibility is to handle superglobals between these:
 * INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER and INPUT_ENV
 *
 * @category RequestHandle
 * @package  HttpStrategy
 * @author   Edouard Kombo <edouard.kombo@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT License
 * @link     http://www.breezeframework.com/thetrollinception.php
 */
class RequestHandle extends HandleAbstraction
{
    /**
     *
     * @var string $input
     */
    protected $input;
    
    /**
     *
     * @var string $value
     */
    protected $value;    

    /**
     * Constructor
     */
    public function __construct()
    {
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
    public function input($value)
    {
        $this->input = constant('INPUT_' . strtoupper($value));
        
        return (object) $this;
    }  
    
    /**
     * Set the key to retrieve
     *
     * @param mixed $key Key to retrieve
     * 
     * @throws \RuntimeException
     * @return \TTI\HttpStrategy\RequestHandle
     */
    public function get($key = null)
    {
        try {
            if ($key === null) {
                throw new \RuntimeException("You must specify a value to get!");            
            }
            $this->value = $key;
            
            return $this;

        } catch(\RuntimeException $ex) {
            echo $ex->getMessage();
            exit();
   
        }
    }
    
    /**
     * Fetch the last value by filtering it
     *
     * @param string $filter filter to apply
     * @param string $opt    additional option
     *
     * @return mixed
     */
    public function filter($filter = null, $opt = null)
    {
        if (null === $filter) {
            $res = filter_input($this->input, $this->value);
        } elseif (null === $opt) {
            $filter = 'FILTER_' . strtoupper($filter);
            $res = filter_input($this->input, $this->value, $filter);
        } else {
            $opt = 'FILTER_' . strtoupper($opt);
            $res = filter_input($this->input, $this->value, $filter, $opt);
        }

        return $res;
    }    
}
