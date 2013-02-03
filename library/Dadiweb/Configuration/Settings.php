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
     * @var Array()
     */
    protected $_settings = NULL;
 
    /**
     * Application path
     *
     * @var String()
     */
    protected $_path = NULL;
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
     * Reset instance of Dadiweb_Configuration_Settings
     * Singleton pattern implementation
     *
     * @return Dadiweb_Configuration_Settings Provides a fluent interface
     */
    public static function resetInstance()
    {
        return self::$_instance=NULL;
    }
/***************************************************************/
    /**
     * Returns Configuration Settings
     *
     * @return stdClass
     */
    public function getGeneric()
    {
    	if(!is_array($this->_settings)){
    		self::setGeneric();
    	}
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
    	$generic=Dadiweb_Aides_Filesystem::getInstance()->getScanDir(INI_PATH);
    	if($generic!=NULL && is_array($generic)){
	    	foreach($generic as $items){
    			if(!$items['type']){
    				if(!is_array($this->_settings)){
    					$this->_settings=array();
    				}
    				$file=INI_PATH.DIRECTORY_SEPARATOR.$items['item'];
    				if(!is_file($file)){
    					throw Dadiweb_Throw_ErrorException::showThrow(sprintf('The general configuration ini-file "%s" does not exist', $file));
    				}
    				$ini=parse_ini_file($file,true);
    				if(!$ini){
    					throw Dadiweb_Throw_ErrorException::showThrow(
    						sprintf('The general configuration ini-file "%s" does not exist or empty', $file)
    					);
    				}
    				foreach($ini as $key=>$item){
    					$this->_settings=array_merge_recursive(
    						$this->_settings,
    						Dadiweb_Aides_Array::getInstance()->items_2_MultiDimensionalKeys(
    							Dadiweb_Aides_Array::getInstance()->explode($key,'.'),
    							$item
    						)
    					);
    				}
    			}
    		}
    	}
    	unset($generic);
    	unset($items);
    	unset($item);
    	unset($key);
    }
/***************************************************************/
    /**
     *
     * Set application path
     *
     * @var String()
     *
     */
    public function setPath($path=NULL)
    {
    	return $this->_path=$path;
    }
/***************************************************************/
    /**
     *
     * Get application path
     *
     * @return String()
     *
     */
    public function getPath()
    {
    	return $this->_path;
    
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