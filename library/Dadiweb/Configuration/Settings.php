<?php
class Dadiweb_Configuration_Settings
{
	/**
     * Singleton instance
     * 
     * @var Dadiweb_Configuration_Settings
     */
    protected static $_instance = null;
    
    /**
     * General variable
     *
     * @var stdClass()
     */
    protected $_settings = null;
/***************************************************************/
	/**
     * Singleton pattern implementation makes "new" unavailable
     *
     * @return void
     */
	protected function __construct(){
		$this->_settings = new stdClass();
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
     * Returns an instance of Dadiweb_Configuration_Settings
     * Singleton pattern implementation
     *
     * @return Dadiweb_Configuration_Settings Provides a fluent interface
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
     * Returns Configuration Settings
     *
     * @return stdClass
     */
    public function getGeneric()
    {
    	$this->setGeneric();
    	return $this->_settings;
    }
/***************************************************************/
    /**
     * Setup Configuration Object
     *
     * @return stdClass
     */
    protected function setGeneric()
    {
    	//var_dump(Dadiweb_Aides_Filesystem::getInstance()->getScanDir(INI_PATH));die;exit;
    	//$ini_array = parse_ini_file(HTDOCS_PATH.DIRECTORY_SEPARATOR."resources.ini", true);
    	$generic=Dadiweb_Aides_Filesystem::getInstance()->getScanDir(INI_PATH);
    	if($generic!=NULL && is_array($generic)){
	    	foreach(Dadiweb_Aides_Filesystem::getInstance()->getScanDir(INI_PATH) as $items){
    			if(!$items['type']){
    				//var_dump(parse_ini_file(INI_PATH.DIRECTORY_SEPARATOR.$items['item']));die;exit;
    			}
    		}
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
         	throw Dadiweb_Configuration_Exception::getInstance()->getMessage(sprintf('The required method "%s" does not exist for %s', $method, get_class($this))); 
       	} 	
    }
/***************************************************************/
}