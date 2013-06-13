<?php
class Dadiweb_Configuration_Db
{
	/**
     * Singleton instance
     * 
     * @var Dadiweb_Configuration_Db
     */
    protected static $_instance = null;
    
    /**
     * General variable
     * 
     * @var array
     */
    protected $_db = NULL;
    
/***************************************************************/
	/**
     * Singleton pattern implementation makes "new" unavailable
     *
     * @return void
     */
	protected function __construct(){
		self::setGeneric();
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
     * Returns an instance of Dadiweb_Configuration_Db
     * Singleton pattern implementation
     *
     * @return Dadiweb_Configuration_Db Provides a fluent interface
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
     * Reset instance of Dadiweb_Configuration_Db
     * Singleton pattern implementation
     *
     * @return Dadiweb_Configuration_Db Provides a fluent interface
     */
    public static function resetInstance()
    {
        return self::$_instance=NULL;
    }
/***************************************************************/
    /**
     * Returns Configuration DB
     *
     * @return stdClass
     */
    public function getGeneric()
    {
    	if(!is_array($this->_db)){
    		self::setGeneric();
    	}
    	return $this->_db;
    }
/***************************************************************/
    /**
     * Setup Configuration Object
     *
     * @return stdClass
     */
    protected function setGeneric()
    {
        if(
            isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->db) &&
            ($_database=Dadiweb_Configuration_Kernel::getInstance()->getSettings()->db) instanceof stdClass
        ){
            foreach($_database as $driver=>$items){
                if($items instanceof stdClass){
                    if(!is_array($this->_db)){$this->_db=array();}
                    foreach($items as $key=>$item){
                        if(!isset($this->_db[$key])){
                            $class='Dadiweb_Db_Config_'.ucfirst($driver);
                            $config=new $class(Dadiweb_Aides_Array::getInstance()->obj2arr($items->$key,0),$key);
                            $class='Dadiweb_Db_Functions_'.ucfirst($driver);
                            $functions=new $class($config,$key);
                            $this->_db[$key]=$functions;
                        }
                    }
                }
                
            }
            return $this->_db;
        }else{
            return NULL;
        }
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
         	throw Dadiweb_Configuration_Exception::getInstance()->getMessage(
         		sprintf('The required method "%s" does not exist for %s', $method, get_class($this))
         	); 
       	} 	
    }
/***************************************************************/
}