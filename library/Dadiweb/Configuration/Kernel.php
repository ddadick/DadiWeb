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
     * Current program
     *
     * @return String()
     */
    protected $_prog = NULL;
    
    /**
     * Current contoller
     *
     * @return String()
     */
    protected $_ctrl = NULL;
    
    /**
     * Current method
     *
     * @return String()
     */
    protected $_method = NULL;
    
    /**
     * Current model
     *
     * @return String()
     */
    protected $_model = NULL;
 
    /**
     * Path's controller (current)
     *
     * @return String()
     */
    protected $_path_ctrl = NULL;

    /**
     * File's controller (current)
     *
     * @return String()
     */
    protected $_file_ctrl = NULL;

    /**
     * External class (current)
     *
     * @return String()
     */
    protected $_class = NULL;
    
    /**
     * Output buffer (current)
     *
     * @return Object
     */
    protected $_ob_buffer = NULL;
    
    
/***************************************************************/
	/**
     * Singleton pattern implementation makes "new" unavailable
     *
     * @return void
     */
	protected function __construct(){
		self::buildKernel();
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
    protected function buildKernel()
    {
    	$GLOBALS['SUPERVISOR_PATTERN']=Dadiweb_Configuration_Pattern::getInstance();
    	Dadiweb_Configuration_Pattern::resetInstance();
    	$GLOBALS['SUPERVISOR_INI']=Dadiweb_Aides_Array::getInstance()->arr2obj(Dadiweb_Configuration_Settings::getInstance()->getGeneric());
    	Dadiweb_Configuration_Settings::resetInstance();
    	Dadiweb_Configuration_Render::getInstance()->getGeneric();
    	Dadiweb_Configuration_Render::resetInstance();
		if(!isset($GLOBALS['SUPERVISOR_INI']->resource->Master->path) || !strlen(trim($GLOBALS['SUPERVISOR_INI']->resource->Master->path)) || 
				self::setPath($GLOBALS['SUPERVISOR_INI']->resource->Master->path)===NULL || false===realpath(self::getPath())){
			throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Path into "resource.Master.path" in the file "%sresourse.ini" is not valid', INI_PATH));
		}
		if(NULL===$GLOBALS['SUPERVISOR_PATTERN']->getApplication() && NULL===$GLOBALS['SUPERVISOR_PATTERN']->getController() && 
				NULL===$GLOBALS['SUPERVISOR_PATTERN']->getView()){
			if(!isset($GLOBALS['SUPERVISOR_INI']->resource->Master->prog) || 
					!strlen(trim(self::setProgram($GLOBALS['SUPERVISOR_INI']->resource->Master->prog)))){
				throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Value into "resource.Master.prog" in the file "%sresourse.ini" is not valid or empty', INI_PATH));
			}elseif(!isset($GLOBALS['SUPERVISOR_INI']->resource->Master->ctrl) || 
					!strlen(trim(self::setController($GLOBALS['SUPERVISOR_INI']->resource->Master->ctrl)))){
				throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Value into "resource.Master.ctrl" in the file "%sresourse.ini" is not valid or empty', INI_PATH));
			}elseif(!isset($GLOBALS['SUPERVISOR_INI']->resource->Master->method) || 
					!strlen(trim(self::setMethod(ucfirst($GLOBALS['SUPERVISOR_INI']->resource->Master->method).'Method')))){
				self::setMethod('IndexMethod');
			}elseif(false===realpath(self::setPathCtrl(self::getPath().DIRECTORY_SEPARATOR.self::getProgram()))){
				throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Directory "%s" does not exist', self::getPathCtrl()));
			}elseif(false===is_file(self::setFileCtrl(self::getPathCtrl().DIRECTORY_SEPARATOR.ucfirst(self::getController()).'Ctrl.php'))){
				throw Dadiweb_Throw_ErrorException::showThrow(sprintf('File "%s" does not exist', self::getFileCtrl()));
			}
			self::setClass(self::getProgram()."_".ucfirst(self::getController()).'Ctrl');
			
		}
		self::ob_class(self::getPath(),self::getClass(), self::getMethod());
		
    }
/***************************************************************/
    /**
     *
     * Set current program
     *
     * @var String()
     *
     */
    protected function setProgram($prog=NULL)
    {
    	return $this->_prog=$prog;
    }
/***************************************************************/
    /**
     *
     * Get current program
     *
     * @return String()
     *
     */
    protected function getProgram()
    {
    	return $this->_prog;
    
    }
/***************************************************************/
    /**
     *
     * Set current controller
     *
     * @var String()
     *
     */
    protected function setController($ctrl=NULL)
    {
    	return $this->_ctrl=$ctrl;
    }
/***************************************************************/
    /**
     *
     * Get current controller
     *
     * @return String()
     *
     */
    protected function getController()
    {
    	return $this->_ctrl;
    }
/***************************************************************/
    /**
     *
     * Set current model
     *
     * @var String()
     *
     */
    protected function setModel($model=NULL)
    {
    	return $this->_model=$model;
    }
/***************************************************************/
    /**
     *
     * Get current model
     *
     * @return String()
     *
     */
    protected function getModel()
    {
    	return $this->_model;
    }
/***************************************************************/
    /**
     *
     * Set current method
     *
     * @var String()
     *
     */
    protected function setMethod($method=NULL)
    {
    	return $this->_method=$method;
    }
/***************************************************************/
    /**
     *
     * Get current method
     *
     * @return String()
     *
     */
    protected function getMethod()
    {
    	return $this->_method;
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
    protected function getPath()
    {
    	return $this->_path;
    }
/***************************************************************/
    /**
     *
     * Set path's controller (current)
     *
     * @var String()
     *
     */
    protected function setPathCtrl($path_ctrl=NULL)
    {
    	return $this->_path_ctrl=$path_ctrl;
    }
/***************************************************************/
    /**
     *
     * Get path's controller (current)
     *
     * @return String()
     *
     */
    protected function getPathCtrl()
    {
    	return $this->_path_ctrl;
    }
/***************************************************************/
    /**
     *
     * Set external class (current)
     *
     * @var String()
     *
     */
    protected function setFileCtrl($file_ctrl=NULL)
    {
    	return $this->_file_ctrl=$file_ctrl;
    }
/***************************************************************/
    /**
     *
     * Get file's controller (current)
     *
     * @return String()
     *
     */
    protected function getFileCtrl()
    {
    	return $this->_file_ctrl;
    }
/***************************************************************/
    /**
     *
     * Set external class (current)
     *
     * @var String()
     *
     */
    protected function setClass($class=NULL)
    {
    	return $this->_class=$class;
    }
/***************************************************************/
    /**
     *
     * Get external class (current)
     *
     * @return String()
     *
     */
    protected function getClass()
    {
    	return $this->_class;
    }
/***************************************************************/
    /**
     *
     * Output buffer (current)
     *
     * @return Object
     *
     */
    
    protected function ob_buffer($content){
    	
    	return $GLOBALS['SUPERVISOR_RENDER']->_echo($content);
    }
/***************************************************************/
    /**
     *
     * Init external Class
     *
     * @return Object
     *
     */
    
    public function ob_class($path=NULL,$class=NULL,$method=NULL){
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
    				$path
    			)
    		);
    	}else{
    		if(!is_string($path) || !strlen(trim($path)) || (is_string($path) && !realpath($path))){
    			throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Path "%s" does not exist', $path));
    		}
	    	set_include_path(
    			implode(PATH_SEPARATOR,
			    	array(
    					realpath($path)
			    	)
    			)
    		);
    	}
    	$GLOBALS['SUPERVISOR_STOP']=NULL;
    	$class=new $class;
    	ob_start(array($this,'ob_buffer'));
    	$class->$method();
    	ob_end_flush();
    	if($GLOBALS['SUPERVISOR_STOP']!==NULL){
    		exit;
    	}
    	set_include_path(
	    	implode(PATH_SEPARATOR,
    			array(
			    	$return
		    	)
    		)
    	);
    	return;
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