<?php
class Dadiweb_Apps_Programs
{
	/**
     * Singleton instance
     * 
     * @var Dadiweb_Apps_Programs
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
     * Returns an instance of Dadiweb_Apps_Programs
     * Singleton pattern implementation
     *
     * @return Dadiweb_Apps_Programs Provides a fluent interface
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
     * Reset instance of Dadiweb_Apps_Programs
     * Singleton pattern implementation
     *
     * @return unset Dadiweb_Apps_Programs
     */
    public static function resetInstance()
    {
    	return self::$_instance=NULL;
    }
/***************************************************************/
    public function loadClass($class=NULL,$path=NULL)
    {
    	if($class===NULL){
    		throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Variable $class is not specified in the file ', __FILE__));
    	}
    	if($path===NULL){
    		throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Variable $path is not specified in the file ', __FILE__));
    	}
    	$return=get_include_path();
    	set_include_path(
	    	implode(PATH_SEPARATOR,
	    		array(
    				realpath($path)
    			)
    		)
    	);
    	$d=$class;
    	$d=new $d;
    	set_include_path(
    		implode(PATH_SEPARATOR,
    			array(
    				$return
    			)
    		)
    	);
    	return $d;
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
         	throw Dadiweb_Apps_Exception::getInstance()->getMessage(sprintf('The required method "%s" does not exist for %s', $method, get_class($this))); 
       	} 	
    }
/***************************************************************/
}