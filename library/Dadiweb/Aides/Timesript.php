<?php
class Dadiweb_Aides_Timesript
{
	/**
     * Singleton instance
     * 
     * @var Dadiweb_Aides_Timesript
     */
    protected static $_instance = null;
    
    /**
     * Current time
     *
     * @var float()
     */
    protected $_time = null;
    
/***************************************************************/
	/**
     * Singleton pattern implementation makes "new" unavailable
     *
     * @return void
     */
	protected function __construct($_time=NULL){
		$this->start($_time);
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
     * Returns an instance of Dadiweb_Aides_Timesript
     * Singleton pattern implementation
     *
     * @return Dadiweb_Aides_Timesript Provides a fluent interface
     */
    public static function getInstance($_time=NULL)
    {
    	if (null === self::$_instance) {
            self::$_instance = new self($_time);
        }
        return self::$_instance;
    }
/***************************************************************/
    /**
     * Reset instance of Dadiweb_Aides_Timesript
     * Singleton pattern implementation
     *
     * @return Dadiweb_Aides_Timesript Provides a fluent interface
     */
    public static function resetInstance()
    {
    	return self::$_instance=NULL;
    }
    
/***************************************************************/
    /**
     * Returns execution time
     *
     * @return float()
     */
    public function time()
    {    	
    	return microtime(true) - $this->_time;
    }
/***************************************************************/
    /**
     * Bootstrap execution time
     * 
     * @return Void
     */
    protected function start($_time=NULL)
    {
    	$this->_time = ($_time==NULL)?microtime(true):$_time;
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
         	throw Dadiweb_Aides_Exception::getInstance()->getMessage(sprintf('The required method "%s" does not exist for %s', $method, get_class($this))); 
       	} 	
    }
/***************************************************************/
}