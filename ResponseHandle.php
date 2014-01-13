<?php

/**
 * Main docblock
 *
 * PHP version 5
 *
 * @category  ResponseHandle
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
 * ResponseHandle responsibility is to handle http responses.
 *
 * @category ResponseHandle
 * @package  HttpStrategy
 * @author   Edouard Kombo <edouard.kombo@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT License
 * @link     http://www.breezeframework.com/thetrollinception.php
 */
class ResponseHandle extends HandleAbstraction
{
    /**
     *
     * @var string $headers
     */
    protected $headers = array();
    
    /**
     *
     * @var integer $level
     */
    protected $level = 0;
    
    /**
     *
     * @var string $output
     */
    protected $output;    

    /**
     * Constructor
     */
    public function __construct()
    {
    }           
    
    /**
     * Set key/value of headers, level and output
     *
     * @param mixed $key   Key of the array
     * @param mixed $value Value to assign
     * 
     * @return \TTI\HttpStrategy\ResponseHandle
     */
    public function set($key, $value)
    {
        if ($key == 'level') {
             return (integer) $this->level = $value;
        } elseif ($key == 'output') {
             return (string) $this->output = $value;
        } elseif ($key == 'headers') {
             return (array) $this->headers[] = $value;
        }
        
        return (object) $this;
    }    

    /**
     * Redirect to url
     * 
     * @param string  $url    Url to redirect to
     * @param integer $status of the page
     * 
     * @return void
     */
    public function redirect($url, $status = 302)
    {
        $arr1 = array('&amp;', "\n", "\r");
        $arr2 = array('&', '', '');
        
        $url = str_replace($arr1, $arr2, $url);
        header('Status: ' . $status);
        header('Location: ' . $url);
        exit();
    }    
    
    /**
     * Get Http encoding
     * 
     * @param \TTI\HttpStrategy\RequestHelper $request Request object
     * 
     * @return string
     */
    private function _encoding(\TTI\HttpStrategy\RequestHelper $request)
    {
        $encoding = $request->getEncoding();
       
        if (isset($encoding) && (strpos($encoding, 'gzip') !== false)) {
            $encoding = (string) 'gzip';
        } elseif (isset($encoding) && (strpos($encoding, 'x-gzip') !== false)) {
            $encoding = (string) 'x-gzip';
        }
       
        return (string) $encoding;
    }
    
    /**
     * Http compression
     * 
     * @param string  $data  Data to compress
     * @param integer $level Level of encoging
     * 
     * @return mixed
     */
    private function _compress($data, $level = 0)
    {
        $encoding = $this->_encoding();
        
        if (!isset($encoding) && headers_sent() && connection_status()) {
            return $data;
        }

        if (!extension_loaded('zlib') || ini_get('zlib.output_compression')) {
            return $data;
        }
        
        $this->set('headers', "Content-Encoding: $encoding");
        return gzencode($data, (int)$level);        
    }

    /**
     * Get the output response
     * 
     * @return void
     */
    public function output()
    {
        if (!$this->output) {
            echo '';
        }   
               
        if ($this->level) {
            $output = $this->_compress($this->output, $this->level);
        } else {
            $output = $this->output;
        }

        if (!headers_sent()) {
            foreach ($this->headers as $header) {
                header($header, true);
            }
        }

        echo $output;
    }       
}
