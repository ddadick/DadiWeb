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
    
    /**
     * Dir of layout's app
     *
     * @var String()
     */
    protected $_path_app = null;
    
    
    /**
     * Name of template
     *
     * @var String()
     */
    protected $_template = null;
    
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
    	/**
    	if(
    			!isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->Layout->app_path) ||
    			!strlen($this->_path_app=trim(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->Layout->app_path))
    	){
    		throw Dadiweb_Throw_ErrorException::showThrow(
    				sprintf('Variable into "resource.Layout.app_path" in the file "%sresourse.ini" is not valid', INI_PATH)
    		);
    	}
    	//Dadiweb_Aides_Debug::show(APPS_PATH.Dadiweb_Configuration_Kernel::getInstance()->getProgram(),true);
    	$this->_path_app=Dadiweb_Aides_Filesystem::pathValidator(
    		Dadiweb_Aides_Filesystem::pathValidator(APPS_PATH).
    		Dadiweb_Configuration_Kernel::getInstance()->getProgram().DIRECTORY_SEPARATOR.
    		$this->_path_app.DIRECTORY_SEPARATOR.Dadiweb_Configuration_Kernel::getInstance()->getController()
    	);
    	Dadiweb_Aides_Debug::show($this->_path_app,true);
    	*/
    	return;
    }
/***************************************************************/
    /**
     * Get Path generic layout
     *
     * @return String()
     */
    protected function getPathGeneric()
    {
    	return $this->_path_generic;
    }
/***************************************************************/
    /**
     * Get Path layout's app
     *
     * @return String()
     */
    protected function getPathApp()
    {
    	return $this->_path_app;
    }
/***************************************************************/
    /**
     * Set name of template
     *
     * @return Nothing
     */
    protected function setTemplate($options=NULL)
    {
    	if($options===NULL && !is_string($options) && !strlen(trim($options))){
    		throw Dadiweb_Throw_ErrorException::showThrow(
    				sprintf('Template in the class "%s" is not specified', get_class($this))
    		);
    	}
    	$this->_template=$options;
    }
/***************************************************************/
    /**
     * Get name of template
     *
     * @return String()
     */
    public function getTemplate()
    {
    	if($this->_template===NULL && !is_string($this->_template) && !strlen(trim($this->_template))){
    		throw Dadiweb_Throw_ErrorException::showThrow(
    				sprintf('Template in the class "%s" is not specified', get_class($this))
    		);
    	}
    	return $this->_template;
    }
/***************************************************************/
    /**
     * Return HTML
     *
     * @return String()
     * 
     */
    public function getRendered()
    {
    	self::setTemplate('index.tpl');
    	/**
    	Dadiweb_Aides_Debug::show(APPS_PATH,true);
    	
    	if(
    			!isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->layout->class) ||
    			!strlen($this->_classname=trim(ucfirst(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->$options->class)))
    	){
    	/**
    	Dadiweb_Aides_Filesystem::pathCreate(
    		Dadiweb_Aides_Filesystem::pathValidator(APPS_PATH).
    		Dadiweb_Configuration_Kernel::getInstance()->getProgram().DIRECTORY_SEPARATOR.
    		
    	);
    	*/
    	Dadiweb_Configuration_Kernel::getInstance()->getRendered()->getRender()->setTemplateDir(self::getPathGeneric());
    	return Dadiweb_Configuration_Kernel::getInstance()->getRendered()->_echo();
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