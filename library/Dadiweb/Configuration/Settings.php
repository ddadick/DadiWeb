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
     *
     * Generic path's for Apps
     *
     * @var String()
     *
     */
    protected $_path = NULL;
    
    /**
     * Paths of settings for Apps
     *
     * @var Array()
     */
    protected $_apps_path = NULL;
    
    /**
     * Paths of settings for Apps
     * (administrative basic control)
     *
     * @var Array()
     */
    protected $_abc_apps_path = NULL;
    
    /**
     * Set administrative basic control
     *
     * @var ABC
     */
    protected $_abc = NULL;
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
    	/**
    	 * Setup variable for administrative basic control
    	 */
    	self::setABC(
    			(
    					isset($this->_settings['apps']['Master']['abc'])
    					&& strlen(trim(self::setABC(strtolower($this->_settings['apps']['Master']['abc']))))
    			)
    			?self::getABC()
    			:strtolower('abc')
    	);
    	/**
    	 * Setup default path for Apps
    	 */
    	if(
    			!isset($this->_settings['apps']['Master']['path']) ||
    			!strlen(trim($this->_settings['apps']['Master']['path'])) ||
    			self::setPath($this->_settings['apps']['Master']['path'])===NULL ||
    			false===realpath(self::getPath())
    	){
    		throw Dadiweb_Throw_ErrorException::showThrow(
    				sprintf('Path into "apps.Master.path" in the file "%sapps.ini" is not valid', INI_PATH)
    		);
    	}
    	/**
    	 * Setup default path of settings for Apps
    	 */
    	$generic=Dadiweb_Aides_Filesystem::getInstance()->getScanDir(self::getPath());
    	if($generic!=NULL && is_array($generic)){
    		foreach($generic as $items){
    			if(!$items['type']){
    				if(is_dir(
    						$path=Dadiweb_Aides_Filesystem::getInstance()->pathValidator(
    							self::getPath().DIRECTORY_SEPARATOR.$items['item'].DIRECTORY_SEPARATOR
    							.(
    								(
    									isset($this->_settings['resource']['App']['settings_path'])
    									&& strlen(trim($path=strtolower($this->_settings['resource']['App']['settings_path'])))
    								)
    								?$path
    								:strtolower('settings')
    							)
    						)
    					)
    				){
    					if(!is_array($this->_apps_path)){
    						$this->_apps_path=array();
    					}
    					self::setAppsPath($path);
    				}
    				if(is_dir(
    						$path=Dadiweb_Aides_Filesystem::getInstance()->pathValidator(
    								self::getPath().DIRECTORY_SEPARATOR.$items['item'].DIRECTORY_SEPARATOR
    								.self::getABC().DIRECTORY_SEPARATOR
    								.(
    										(
    												isset($this->_settings['resource']['App']['settings_path'])
    												&& strlen(trim($path=strtolower($this->_settings['resource']['App']['settings_path'])))
    										)
    										?$path
    										:strtolower('settings')
    								)
    						)
    				)
    				){
    					if(!is_array($this->_abc_apps_path)){
    						$this->_abc_apps_path=array();
    					}
    					self::setABCAppsPath($path);
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
     * Set path's applications
     *
     * @var String()
     *
     */
    protected function setPath($path=NULL)
    {
    	return $this->_path=$path;
    }
/***************************************************************/
    /**
     *
     * Get path's applications
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
     * Set paths of settings for Apps
     *
     * @var String()
     *
     */
    protected function setAppsPath($apps_path=NULL)
    {
    	return (
    				NULL!==$apps_path
    				&& strlen(trim($apps_path=strtolower($apps_path)))
    				&& array_push($this->_apps_path,$apps_path)
    			)
    			?$apps_path
    			:NULL;
    }
/***************************************************************/
    /**
     *
     * Get paths of settings for Apps
     *
     * @return Array()
     *
     */
    public function getAppsPath()
    {
    	return $this->_apps_path;
    }
    
/***************************************************************/
    /**
     *
     * Set paths of settings for Apps
     * (administrative basic control)
     *
     * @var String()
     *
     */
    protected function setABCAppsPath($abc_apps_path=NULL)
    {
    	return (
    				NULL!==$abc_apps_path
    				&& strlen(trim($abc_apps_path=strtolower($abc_apps_path)))
    				&& array_push($this->_abc_apps_path,$abc_apps_path)
    			)
    			?$abc_apps_path
    			:NULL;
    }
/***************************************************************/
    /**
     *
     * Get paths of settings for Apps
     * (administrative basic control)
     *
     * @return Array()
     *
     */
    public function getABCAppsPath()
    {
    	return $this->_abc_apps_path;
    }
    
/***************************************************************/    	
    /**
   	 * 
   	 * Set login administrative basic control
   	 * 
   	 * @return ABC
   	 * 
   	 */
   	protected function setABC($_abc=NULL)
   	{
   		return $this->_abc=$_abc;
   	}
/***************************************************************/    	
    /**
   	 * 
   	 * Get login administrative basic control
   	 * 
   	 * @return ABC
   	 * 
   	 */
   	public function getABC()
   	{
   		return $this->_abc;
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