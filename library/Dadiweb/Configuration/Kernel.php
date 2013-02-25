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
     * Default method
     *
     * @return String()
     */
    protected $_method_default = NULL;
    
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
    	//Dadiweb_Aides_Debug::show(Dadiweb_Configuration_Settings::getInstance()->getABCAppsPath(),true);
    	Dadiweb_Configuration_Routes::getInstance();
    	//Dadiweb_Aides_Debug::show(Dadiweb_Configuration_Routes::getInstance()->getABCRoutes(),true);
    	self::setPattern(Dadiweb_Configuration_Pattern::getInstance());
    	self::setLayout(Dadiweb_Configuration_Layout::getInstance());
    	Dadiweb_Configuration_Render::getInstance()->getGeneric();
    	//Dadiweb_Aides_Debug::show(self::getPattern(),true);
    	
		
		if(
			NULL===self::getPattern()->setModel() &&
			NULL===self::getPattern()->getController() && 
			NULL===self::getPattern()->getView()
		){
			if(
				!isset(self::getSettings()->apps->Master->prog) || 
				!strlen(trim(self::setProgram(strtolower(self::getSettings()->apps->Master->prog))))
			){
				throw Dadiweb_Throw_ErrorException::showThrow(
						sprintf('Value into "apps.Master.prog" in the file "%sapps.ini" is not valid or empty', INI_PATH)
				);
			}elseif(
				!isset(self::getSettings()->apps->Master->ctrl) || 
				!strlen(trim(self::setController(strtolower(self::getSettings()->apps->Master->ctrl))))
			){
				throw Dadiweb_Throw_ErrorException::showThrow(
						sprintf('Value into "apps.Master.ctrl" in the file "%sapps.ini" is not valid or empty', INI_PATH)
				);
			}elseif(
				!isset(self::getSettings()->apps->Master->method) 
				|| !strlen(
					trim(
						self::setMethod(
							ucfirst(strtolower(self::getSettings()->apps->Master->method)).
							(
								(isset(self::getSettings()->generic->App->method))
								?(
									(strlen(trim(self::setMethod(strtolower(self::getSettings()->generic->App->method)))))
									?ucfirst(self::getMethod())
									:'Method'
								)
								:'Method'
							)
						)
					)	
				)
				|| !strlen(
					trim(
						self::setMethodDefault(
							ucfirst(
								(
									(isset(self::getSettings()->generic->App->method_default))
									?(
										(strlen(trim(self::setMethodDefault(strtolower(self::getSettings()->generic->App->method_default)))))
										?ucfirst(self::getMethodDefault())
										:ucfirst('Index')
									)
									:ucfirst('Index')
								)
							)
							.(
								(isset(self::getSettings()->generic->App->method))
								?(
									(strlen(trim(self::getSettings()->generic->App->method)))
									?ucfirst(strtolower(self::getSettings()->generic->App->method))
									:ucfirst('Method')
								)
								:ucfirst('Method')
							)
						)
					)	
				)
			){
				self::setMethodDefault('IndexMethod');
				self::setMethod('IndexMethod');
			}elseif(false===realpath(
						self::setPathCtrl(
							Dadiweb_Configuration_Settings::getInstance()->getPath().DIRECTORY_SEPARATOR.self::getProgram().DIRECTORY_SEPARATOR.
							(
								(isset(self::getSettings()->generic->App->ctrl_path))
								?(
									(strlen(trim(self::setPathCtrl(strtolower(self::getSettings()->generic->App->ctrl_path)))))
									?self::getPathCtrl()
									:strtolower('ctrl')
								)
								:strtolower('ctrl')
							)
						)
					)
			){
				throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Directory "%s" does not exist', self::getPathCtrl()));
			}elseif(NULL===self::setClass(
						(isset(self::getSettings()->generic->App->ctrl_class) && strlen(trim(self::setClass(strtolower(self::getSettings()->generic->App->ctrl_class)))))
						?ucfirst(self::getClass())
						:ucfirst('Ctrl')
					)
			){
				throw Dadiweb_Throw_ErrorException::showThrow('Critical interrupt. The name of the default class is not established.');
			}elseif(false===is_file(
						(isset(self::getSettings()->generic->App->ctrl_class))
						?(
							(strlen(trim(self::setFileCtrl(strtolower(self::getSettings()->generic->App->ctrl_class)))))
							?(
								self::setFileCtrl(self::getPathCtrl().DIRECTORY_SEPARATOR.ucfirst(self::getController()).ucfirst(self::getFileCtrl().'.php'))
							)
							:(self::setFileCtrl(self::getPathCtrl().DIRECTORY_SEPARATOR.ucfirst(self::getController()).self::getClass().'.php'))
						)
						:self::setFileCtrl(self::getPathCtrl().DIRECTORY_SEPARATOR.ucfirst(self::getController()).self::getClass().'.php')
					)
			){
				throw Dadiweb_Throw_ErrorException::showThrow(sprintf('File "%s" does not exist', self::getFileCtrl()));
			}		
		}
		//Dadiweb_Aides_Debug::show(array(self::getPattern()->getApplication(),self::getPattern()->getController(),self::getPattern()->getView()),true);
		/**
		 * Setup bootsrap class of app
		 */
		self::setClass(self::getProgram()."_".ucfirst(self::getController()).self::getClass());
		/**
		 * Rendered
		 */
		echo self::getLayout()->getRendered(
				self::ob_class(self::getPathCtrl(),self::getClass(), self::getMethod())
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
     * Set default method
     *
     * @var String()
     *
     */
    protected function setMethodDefault($method_default=NULL)
    {
    	return $this->_method_default=$method_default;
    }
/***************************************************************/
    /**
     *
     * Get default method
     *
     * @return String()
     *
     */
    protected function getMethodDefault()
    {
    	return $this->_method_default;
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
    	$class=new $class;
    	if (method_exists($class, self::getMethodDefault())) {
    		$class->$method();
    	}else{
    		$method=self::getMethodDefault();
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