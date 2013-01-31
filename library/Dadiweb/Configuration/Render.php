<?php
class Dadiweb_Configuration_Render
{
	/**
     * Singleton instance
     * 
     * @var Dadiweb_Configuration_Render
     */
    protected static $_instance = null;
    
    /**
     * Render object
     *
     * @var Dadiweb_Configuration_Render
     */
    protected $_render = null;
    
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
     * Returns an instance of Dadiweb_Configuration_Render
     * Singleton pattern implementation
     *
     * @return Dadiweb_Configuration_Render Provides a fluent interface
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
     * Reset instance of Dadiweb_Configuration_Render
     * Singleton pattern implementation
     *
     * @return Dadiweb_Configuration_Render Provides a fluent interface
     */
    public static function resetInstance()
    {
    	Dadiweb_Render_Bootstrap::resetInstance();
    	return self::$_instance=NULL;
    }
    /***************************************************************/
    /**
     * Returns Configuration Render
     *
     * @return stdClass
     */
    public function getGeneric()
    {
    	
    	if($this->_render===NULL){
    		self::setGeneric();
    	}
    	
    	return $this->_render;
    }
/***************************************************************/
    /**
     * Setup Configuration Render
     *
     * @return stdClass
     */
    protected function setGeneric()
    {
    	/**
    	 * resource.Render.filename = "smarty.class.php"
resource.Render.class = "smarty"
resource.Render.charset = "UTF-8"
resource.Render.compile_dir = APPS_PATH "/../cache/render_compile"
resource.Render.cache_dir = APPS_PATH "/../cache/render_cache"
    	 */
    	
    	if(!isset($GLOBALS['SUPERVISOR_INI']->resource->Render->bootstrap) || !strlen(trim($GLOBALS['SUPERVISOR_INI']->resource->Render->bootstrap))){
    		throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Variable into "resource.Render.bootstrap" in the file "%sresourse.ini" is not valid', INI_PATH));
    	}
    	$bootstrap=Dadiweb_Render_Bootstrap::getInstance($GLOBALS['SUPERVISOR_INI']->resource->Render->bootstrap);
    	//Dadiweb_Aides_Debug::show($bootstrap,true);
    	return $bootstrap;
    	/**
    	if(!isset($GLOBALS['SUPERVISOR_INI']->resource->Render->filename) || !strlen(trim($GLOBALS['SUPERVISOR_INI']->resource->Render->filename))){
    		throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Variable into "resource.Render.filename" in the file "%sresourse.ini" is not valid', INI_PATH));
    	}
    	if(!isset($GLOBALS['SUPERVISOR_INI']->resource->Render->class) || !strlen(trim($GLOBALS['SUPERVISOR_INI']->resource->Render->class))){
    		throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Variable into "resource.Render.class" in the file "%sresourse.ini" is not valid', INI_PATH));
    	}
    	if(!isset($GLOBALS['SUPERVISOR_INI']->resource->Render->charset) || !strlen(trim($GLOBALS['SUPERVISOR_INI']->resource->Render->charset))){
    		throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Variable into "resource.Render.charset" in the file "%sresourse.ini" is not valid', INI_PATH));
    	}
    	if(!isset($GLOBALS['SUPERVISOR_INI']->resource->Render->compile_dir) || !strlen(trim($GLOBALS['SUPERVISOR_INI']->resource->Render->compile_dir))){
    		throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Variable into "resource.Render.compile_dir" in the file "%sresourse.ini" is not valid', INI_PATH));
    	}
    	if(!isset($GLOBALS['SUPERVISOR_INI']->resource->Render->cache_dir) || !strlen(trim($GLOBALS['SUPERVISOR_INI']->resource->Render->cache_dir))){
    		throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Variable into "resource.Render.cache_dir" in the file "%sresourse.ini" is not valid', INI_PATH));
    	}
    	*/
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