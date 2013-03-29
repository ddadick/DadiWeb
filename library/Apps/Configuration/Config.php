<?php
class Apps_Configuration_Config
{
	/**
     * Singleton instance
     * 
     * @var Apps_Configuration_Config
     */
    protected static $_instance = null;
    
    /**
     * Config of programm
     *
     * @var Object
     */
    
    protected $_config = array();
    
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
     * Returns an instance of Apps_Configuration_Config
     * Singleton pattern implementation
     *
     * @return Apps_Configuration_Config Provides a fluent interface
     */
    public static function getInstance($options=NULL)
    {
    	if (null === self::$_instance) {
            self::$_instance = new self($options);
        }
        return self::$_instance;
    }
/***************************************************************/
    /**
     * Reset instance of Apps_Configuration_Config
     * Singleton pattern implementation
     *
     * @return Apps_Configuration_Config Provides a fluent interface
     */
    public static function resetInstance()
    {
        return self::$_instance=NULL;
    }
/***************************************************************/
    /**
     * Returns config of programm
     *
     * @return stdClass
     */
    public function getGeneric()
    {
    	if(!is_array($this->_config)){
    		self::setGeneric();
    	}
    	return $this->_config;
    }
/***************************************************************/
    /**
     * Setup config of programm
     *
     * @return stdClass
     */
    protected function setGeneric()
    {
    	$file=(
    			(
    					isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->App->config_file_name)
    					&& strlen(trim($config_file_name=strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->App->config_file_name)))
    			)
    			?$config_file_name.'.'
    			.(
    					(
    							isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->App->config_file_exe)
    							&& strlen(trim($config_file_exe=strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->App->config_file_exe)))
    					)
    					?strtolower($config_file_exe)
    					:strtolower('ini')
    			)
    			:strtolower(
    					'config.'
    					.(
    							(
    									isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->App->config_file_exe)
    									&& strlen(trim($config_file_exe=strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->App->config_file_exe)))
    							)
    							?$config_file_exe
    							:'ini'
    					)
    			)
    	);
    	if(NULL===Dadiweb_Configuration_Routes::getInstance()->getABC()){
    		if(Dadiweb_Configuration_Settings::getInstance()->getAppsPath()!=NULL && is_array(Dadiweb_Configuration_Settings::getInstance()->getAppsPath())){
    			foreach(Dadiweb_Configuration_Settings::getInstance()->getAppsPath() as $items){
    				if(!is_array($this->_config)){
    					$this->_config=array();
    				}
    				$file=$items.$file;
    				if(is_file($file)){
    					$ini=parse_ini_file($file,true);
    					if($ini){
    						foreach($ini as $key=>$item){
    							$this->_config=array_merge_recursive(
    									$this->_config,
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
    	}else{
    		if(Dadiweb_Configuration_Settings::getInstance()->getABCAppsPath()!=NULL && is_array(Dadiweb_Configuration_Settings::getInstance()->getABCAppsPath())){
    			foreach(Dadiweb_Configuration_Settings::getInstance()->getABCAppsPath() as $items){
    				if(!is_array($this->_config)){
    					$this->_config=array();
    				}
    				$file=$items.$file;
    				if(is_file($file)){
    					$ini=parse_ini_file($file,true);
    					if($ini){
    						foreach($ini as $key=>$item){
    							$this->_config=array_merge_recursive(
    									$this->_config,
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
         	throw Dadiweb_Render_Exception::getInstance()->getMessage(sprintf('The required method "%s" does not exist for %s', $method, get_class($this))); 
       	} 	
    }
/***************************************************************/
}