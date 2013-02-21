<?php
class Dadiweb_Configuration_Routes
{
	/**
     * Singleton instance
     * 
     * @var Dadiweb_Configuration_Routes
     */
    protected static $_instance = null;
    
    /**
     * General variable
     *
     * @var Array()
     */
    protected $_routes = NULL;

    /**
     * Paths of routes
     *
     * @var Array()
     */
    protected $_routes_path = NULL;
    
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
     * Returns an instance of Dadiweb_Configuration_Routes
     * Singleton pattern implementation
     *
     * @return Dadiweb_Configuration_Routes Provides a fluent interface
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
     * Reset instance of Dadiweb_Configuration_Routes
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
     * Returns Configuration Routes
     *
     * @return stdClass
     */
    public function getGeneric()
    {
    	if(!is_array($this->_routes)){
    		self::setGeneric();
    	}
    	return $this->_routes;
    }
/***************************************************************/
    /**
     * Setup Configuration Object
     *
     * @return stdClass
     */
    protected function setGeneric()
    {
    	$generic=Dadiweb_Aides_Filesystem::getInstance()->getScanDir(Dadiweb_Configuration_Kernel::getInstance()->getPath());
    	if($generic!=NULL && is_array($generic)){
	    	foreach($generic as $items){
    			if(!$items['type']){
    				if(!is_array($this->_routes)){
    					$this->_routes=array();
    				}
    				$file=Dadiweb_Aides_Filesystem::getInstance()->pathValidator(
    					Dadiweb_Configuration_Kernel::getInstance()->getPath().DIRECTORY_SEPARATOR.$items['item'].DIRECTORY_SEPARATOR
    						.(
    							(
    								isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->App->settings_path)
    								&& strlen(trim($routes_path=strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->App->settings_path)))
								)
								?$routes_path
    							:strtolower('settings')
    						)
    					)
    					.(
    						(
    							isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->App->routes_file_name)
    							&& strlen(trim($routes_file_name=strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->App->routes_file_name)))
							)
							?$routes_file_name.'.'
    							.(
    								(
    									isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->App->routes_file_exe)
    									&& strlen(trim($routes_file_exe=strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->App->routes_file_exe)))
    								)
    								?strtolower($routes_file_exe)
    								:strtolower('ini')
								)
    						:strtolower(
    							'routes.'
    							.(
    								(
    									isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->App->routes_file_exe)
    									&& strlen(trim($routes_file_exe=strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->App->routes_file_exe)))
    								)
    								?$routes_file_exe
    								:'ini'
								)
    						)
    					)
    				;
    				if(is_file($file)){
    					if(!is_array($this->_routes_path)){
    						$this->_routes_path=array();
    					}
    					self::setRoutesPath($routes_path);
    					$ini=parse_ini_file($file,true);
    					if(!$ini){
    						throw Dadiweb_Throw_ErrorException::showThrow(
    								sprintf('The configuration ini-file "%s" does not exist or empty', $file)
    						);
    					}
    					foreach($ini as $key=>$item){
    						$this->_routes=array_merge_recursive(
    								$this->_routes,
    								Dadiweb_Aides_Array::getInstance()->items_2_MultiDimensionalKeys(
    										Dadiweb_Aides_Array::getInstance()->explode($key,'.'),
    										$item
    								)
    						);
    					}
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
     * Set paths of routes
     *
     * @var String()
     *
     */
    protected function setRoutesPath($routes_path=NULL)
    {
    	return (
    				NULL!==$routes_path
    				&& strlen(trim($routes_path=strtolower($routes_path)))
    				&& array_push($this->_routes_path,$routes_path)
    			)
    			?$routes_path
    			:NULL;
    }
/***************************************************************/
    /**
     *
     * Get paths of routes
     *
     * @return Array()
     *
     */
    protected function getRoutesPath()
    {
    	return $this->_routes_path;
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