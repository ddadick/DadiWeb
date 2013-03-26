<?php
class Dadiweb_Configuration_Kernel
{
	/**
     * Singleton instance
     * 
     * @var Dadiweb_Configuration_Kernel
     */
    protected static $_instance = null;
    
    /**
     * Output buffer (current)
     *
     * @return Object
     */
    protected $_ob_buffer = NULL;
    
    /**
     * Rendered (current)
     *
     * @return Object
     */
    protected $_rendered = NULL;
    
    
    /**
     * Pattern (current)
     *
     * @return Object
     */
    protected $_pattern = NULL;
    
    /**
     * Settings (current)
     *
     * @return Object
     */
    protected $_settings = NULL;
    
    /**
     * Layout (current)
     *
     * @return Object
     */
    protected $_layout = NULL;
    
    /**
     * Apps (current)
     *
     * @return Object
     */
    protected $_apps = NULL;
    
    /**
     * Routes (current)
     *
     * @return Object
     */
    protected $_routes = NULL;
    
    /**
     *
     * Generic path's for Apps
     *
     * @var String()
     *
     */
    protected $_path = NULL;
    
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
     * Returns an instance of Dadiweb_Configuration_Kernel
     * Singleton pattern implementation
     *
     * @return Dadiweb_Configuration_Kernel Provides a fluent interface
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
     * Build Kernel Object
     *
     * @return stdClass
     */
    public function buildKernel()
    {
    	self::setSettings(Dadiweb_Aides_Array::getInstance()->arr2obj(Dadiweb_Configuration_Settings::getInstance()->getGeneric()));
    	Dadiweb_Configuration_Session::getInstance()->getGeneric();
    	self::setRoutes(Dadiweb_Configuration_Routes::getInstance());
    	self::setPattern(Dadiweb_Configuration_Pattern::getInstance());
    	self::setLayout(Dadiweb_Configuration_Layout::getInstance());
    	Dadiweb_Configuration_Render::getInstance()->getGeneric();
    	self::setApps(Dadiweb_Configuration_Apps::getInstance());
		/**
		 * Rendered
		 */
		echo self::getLayout()->getRendered(
				self::ob_class(
					self::getApps()->getPathCtrl(),
					self::getApps()->getClass(), 
					self::getApps()->getMethod()
				)
		);
		/**
		 * End of Kernel
		 */
		Dadiweb_Configuration_Render::resetInstance();
		Dadiweb_Configuration_Pattern::resetInstance();
		Dadiweb_Configuration_Settings::resetInstance();
		Dadiweb_Configuration_Layout::resetInstance();
    }
/***************************************************************/
    /**
     *
     * Init external Class
     *
     * @return Object
     *
     */
    
    protected function ob_class($path=NULL,$class=NULL,$method=NULL){
    	if($class===NULL || (is_string($class) && !strlen(trim($class)))){
    		throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Variable $class is empty', $class));
    	}
    	if($method===NULL || (is_string($method) && !strlen(trim($method)))){
    		throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Variable $function is empty', $method));
    	}
    	$return=get_include_path();
    	if(is_array($path)){
    		foreach ($path as $key=>$item){
    			if(!is_string($item) || (is_string($item) && !realpath($item))){
    				throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Path "%s" does not exist', $item));
    			}else{
    				$path[$key]=realpath($item);
    			}
    		}
    		set_include_path(
    			implode(PATH_SEPARATOR,
    				array_merge(
    					$path,
	    				explode(PATH_SEPARATOR,
    						$return
    					)
    				)
    			)
    		);
    	}else{
    		if(!is_string($path) || !strlen(trim($path)) || (is_string($path) && !realpath($path))){
    			throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Path "%s" does not exist', $path));
    		}
	    	set_include_path(
    			implode(PATH_SEPARATOR,
			    	array(
    					realpath($path),
    					$return
			    	)
    			)
    		);
    	}
    	ob_start();    	
    	$test=Dadiweb_Configuration_Apps::getInstance()->getDefaultClass();
    	$test=new $test;
    	$test_method=Dadiweb_Configuration_Apps::getInstance()->getMethodDefault();
    	if (!method_exists($test, $test_method)) {
    		$test->$test_method();
    	}
    	unset($test);
    	unset($test_method);
    	$class=new $class;
    	if (method_exists($class, Dadiweb_Configuration_Apps::getInstance()->getMethodDefault())) {
    		$class->$method();
    	}else{
    		$method=Dadiweb_Configuration_Apps::getInstance()->getMethodDefault();
    		$class->$method();
    	}
    	set_include_path(
	    	implode(PATH_SEPARATOR,
    			array(
			    	$return
		    	)
    		)
    	);
    	return ob_get_clean();
    }

/***************************************************************/
    /**
     *
     * Set Rendered
     *
     * @return Nothing
     *
     */
    public function setRendered($options=NULL)
    {
    	if($options===NULL){
			throw Dadiweb_Throw_ErrorException::showThrow('Critical error. Rendered undefined.');
		}
		$this->_rendered=$options;
    }
/***************************************************************/
    /**
     *
     * Get Rendered
     *
     * @return Object rendered
     *
     */
    public function getRendered()
    {
    	if($this->_rendered===NULL){
    		throw Dadiweb_Throw_ErrorException::showThrow('Critical error. Rendered undefined.');
    	}
    	return $this->_rendered;
    }
/***************************************************************/
    /**
     *
     * Set Settings
     *
     * @return Nothing
     *
     */
    protected function setSettings($options=NULL)
    {
    	if($options===NULL){
			throw Dadiweb_Throw_ErrorException::showThrow('Critical error. Settings undefined.');
		}
		$this->_settings=$options;
    }
/***************************************************************/
    /**
     *
     * Get Settings
     *
     * @return Object settings
     *
     */
    public function getSettings()
    {
    	if($this->_settings===NULL){
    		throw Dadiweb_Throw_ErrorException::showThrow('Critical error. Settings undefined.');
    	}
    	return $this->_settings;
    }
/***************************************************************/
    /**
     *
     * Set Pattern
     *
     * @return Nothing
     *
     */
    protected function setPattern($options=NULL)
    {
    	if($options===NULL){
			throw Dadiweb_Throw_ErrorException::showThrow('Critical error. Pattern undefined.');
		}
		$this->_pattern=$options;
    }
/***************************************************************/
    /**
     *
     * Get Pattern
     *
     * @return Object pattern
     *
     */
    public function getPattern()
    {
    	if($this->_pattern===NULL){
    		throw Dadiweb_Throw_ErrorException::showThrow('Critical error. Pattern undefined.');
    	}
    	return $this->_pattern;
    }
/***************************************************************/
    /**
     *
     * Set Layout
     *
     * @return Nothing
     *
     */
    protected function setLayout($options=NULL)
    {
    	if($options===NULL){
			throw Dadiweb_Throw_ErrorException::showThrow('Critical error. Layout undefined.');
		}
		$this->_layout=$options;
    }
/***************************************************************/
    /**
     *
     * Get Layout
     *
     * @return Object layout
     *
     */
    public function getLayout()
    {
    	if($this->_layout===NULL){
    		throw Dadiweb_Throw_ErrorException::showThrow('Critical error. Layout undefined.');
    	}
    	return $this->_layout;
    }
/***************************************************************/
    /**
     *
     * Set Apps
     *
     * @return Nothing
     *
     */
    protected function setApps($options=NULL)
    {
    	if($options===NULL){
			throw Dadiweb_Throw_ErrorException::showThrow('Critical error. Apps undefined.');
		}
		$this->_apps=$options;
    }
/***************************************************************/
    /**
     *
     * Get Apps
     *
     * @return Object apps
     *
     */
    public function getApps()
    {
    	if($this->_apps===NULL){
    		throw Dadiweb_Throw_ErrorException::showThrow('Critical error. Apps undefined.');
    	}
    	return $this->_apps;
    }
/***************************************************************/
    /**
     *
     * Set Routes
     *
     * @return Nothing
     *
     */
    protected function setRoutes($options=NULL)
    {
    	if($options===NULL){
			throw Dadiweb_Throw_ErrorException::showThrow('Critical error. Routes undefined.');
		}
		$this->_routes=$options;
    }
/***************************************************************/
    /**
     *
     * Get Routes
     *
     * @return Object routes
     *
     */
    public function getRoutes()
    {
    	if($this->_routes===NULL){
    		throw Dadiweb_Throw_ErrorException::showThrow('Critical error. Routes undefined.');
    	}
    	return $this->_routes;
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