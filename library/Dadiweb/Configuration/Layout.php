<?php
class Dadiweb_Configuration_Layout
{
	/**
     * Singleton instance
     * 
     * @var Dadiweb_Configuration_Layout
     */
    protected static $_instance = null;
    
    /**
     * Dir of layout
     *
     * @var String()
     */
    protected $_path_generic = null;
    
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
     * Returns an instance of Dadiweb_Configuration_Layout
     * Singleton pattern implementation
     *
     * @return Dadiweb_Configuration_Layout Provides a fluent interface
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
     * Reset instance of Dadiweb_Configuration_Layout
     * Singleton pattern implementation
     *
     * @return Dadiweb_Configuration_Layout Provides a fluent interface
     */
    public static function resetInstance()
    {
    	return self::$_instance=NULL;
    }
/***************************************************************/
    /**
     * Setup Configuration Layout
     *
     * @return stdClass
     */
    protected function setGeneric()
    {
    	if(
    		!isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->Layout->path) ||
    		!strlen($this->_path_generic=trim(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->Layout->path))
    	){
    		throw Dadiweb_Throw_ErrorException::showThrow(
    			sprintf('Variable into "resource.Layout.path" in the file "%sresourse.ini" is not valid', INI_PATH)
    		);
    	}
    	$this->_path_generic=Dadiweb_Aides_Filesystem::pathCreate($this->_path_generic);
    	return;
    }
    
/***************************************************************/
    /**
     * Get Path generic layout
     *
     * @return String()
     */
    public function getPathGeneric()
    {
    	return $this->_path_generic;
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