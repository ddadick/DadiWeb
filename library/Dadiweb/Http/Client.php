<?php
class Dadiweb_Http_Client
{
    /**
     * Singleton instance
     * 
     * @var Dadiweb_Http_Client
     */
    protected static $_instance = null;
/***************************************************************/
	/**
     * Singleton pattern implementation makes "new" unavailable
     *
     * @return void
     */
	protected function __construct(){}
/***************************************************************/
	/**
     * Singleton pattern implementation makes "clone" unavailable
     *
     * @return void
     */
    protected function __clone(){}
/***************************************************************/
    /**
     * Returns an instance of Dadiweb_Uri_Http
     * Singleton pattern implementation
     *
     * @return Dadiweb_Uri_Http Provides a fluent interface
     */
    public static function getInstance()
    {
    	if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
/***************************************************************/
    /**
     * Return Url
     * 
     * @return string
     */
    public function getUri(){
    	return $_SERVER["REQUEST_URI"];
    }
/***************************************************************/
    /**
     * jQuery detector
     * return True(only use jQuery), False(in other cases)
     * 
     * @return bool
     */
    public function isXHR(){
    	if (isset($_SERVER["HTTP_X_REQUESTED_WITH"])){
    		return true;
    	}
    	return false;
    }
/***************************************************************/
	/**
     * 
     * The handler functions that do not exist
     * 
     * @return Exeption, default - NULL
     * 
     */
	public function __call($method, $args) 
    {
    	if(!method_exists($this, $method)) { 
         	throw new ErrorException(sprintf('The required method "%s" does not exist for %s', $method, get_class($this))); 
       	} 	
    }
/***************************************************************/
}