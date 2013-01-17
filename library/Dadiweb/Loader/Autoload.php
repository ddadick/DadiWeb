<?php
require_once 'Dadiweb/Loader/Loader.php';
class Dadiweb_Loader_Autoload
{
	/**
     * Singleton instance
     * 
     * @var Dadiweb_Uri_Http
     */
    protected static $_instance = null;
/***************************************************************/
	/**
     * Singleton pattern implementation makes "new" unavailable
     *
     * @return void
     */
	protected function __construct(){
		spl_autoload_register(array('Dadiweb_Loader_Loader','autoload'));
	}
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
   	 * 
   	 * The handler functions that do not exist
   	 * 
   	 * @return Exeption, default - NULL
   	 * 
   	 */
	public function __call($method, $args) 
   	{
   		if(!method_exists($this, $method)) {
   			require_once 'Dadiweb/Loader/Exception.php';
         	throw Dadiweb_Loader_Exception::getInstance()->getMessage(sprintf('The required method "%s" does not exist for %s', $method, get_class($this))); 
       	} 	
   	}
/***************************************************************/
}