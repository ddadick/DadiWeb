<?php
class Dadiweb_Configuration_Apps
{
	/**
     * Singleton instance
     * 
     * @var Dadiweb_Configuration_Apps
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
     *
     * Generic path for Application
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
     * Returns an instance of Dadiweb_Configuration_Apps
     * Singleton pattern implementation
     *
     * @return Dadiweb_Configuration_Apps Provides a fluent interface
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
     * Setup Configuration Apps
     *
     * @return Application
     */
    protected function setGeneric()
    {
		if(NULL!==Dadiweb_Configuration_Kernel::getInstance()->getPattern()->getModel()){
    		self::setProgram(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getPattern()->getModel()));
    	}
    	if(NULL===self::getProgram()){
    		if(
				!isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Master->prog) || 
				!strlen(trim(self::setProgram(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Master->prog))))
    		
			){
				throw Dadiweb_Throw_ErrorException::showThrow(
					sprintf('Value into "apps.Master.prog" in the file "%sapps.ini" is not valid or empty', INI_PATH)
				);
			}
    	}    	 
		if(NULL!==Dadiweb_Configuration_Kernel::getInstance()->getPattern()->getController()){
			self::setController(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getPattern()->getController()));
		}elseif(
			NULL===self::getController() && (
				!isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Master->ctrl) || 
				!strlen(trim(self::setController(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Master->ctrl))))
			)
		){
			throw Dadiweb_Throw_ErrorException::showThrow(
					sprintf('Value into "apps.Master.ctrl" in the file "%sapps.ini" is not valid or empty', INI_PATH)
			);
		}
		if(NULL!==Dadiweb_Configuration_Kernel::getInstance()->getPattern()->getView()){
			self::setMethod(
				ucfirst(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getPattern()->getView())).
				(
					(isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->method))
					?(
						(strlen(trim(self::setMethod(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->method)))))
						?ucfirst(self::getMethod())
						:'Method'
					)
					:'Method'
				)
			);
			
		}
		if(NULL===self::setMethodDefault()){
			self::setMethodDefault(
				ucfirst(
						(
								(isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->method_default))
								?(
										(strlen(trim(self::setMethodDefault(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->method_default)))))
										?ucfirst(self::getMethodDefault())
										:ucfirst('Index')
								)
								:ucfirst('Index')
						)
				)
				.(
						(isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->method))
						?(
								(strlen(trim(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->method)))
								?ucfirst(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->method))
								:ucfirst('Method')
						)
						:ucfirst('Method')
				)
			);
			
		}
		if(
			NULL===self::getMethod() && (
				!isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Master->method) 
				|| !strlen(
					trim(
						self::setMethod(
							ucfirst(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Master->method)).
							(
								(isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->method))
								?(
									(strlen(trim(self::setMethod(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->method)))))
									?ucfirst(self::getMethod())
									:'Method'
								)
								:'Method'
							)
						)
					)	
				)	
			)
		){
			self::setMethod('IndexMethod');
		}
		//Dadiweb_Aides_Debug::show(Dadiweb_Configuration_Routes::getInstance()->getABC(),true);
		if(false===realpath(
					self::setPathCtrl(
						Dadiweb_Configuration_Settings::getInstance()->getPath().DIRECTORY_SEPARATOR.self::getProgram().DIRECTORY_SEPARATOR.
						(
							(NULL!==Dadiweb_Configuration_Routes::getInstance()->getABC())
							?Dadiweb_Configuration_Routes::getInstance()->getABC().DIRECTORY_SEPARATOR
							:''
						).
						(
							(isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->ctrl_path))
							?(
								(strlen(trim(self::setPathCtrl(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->ctrl_path)))))
								?self::getPathCtrl()
								:strtolower('ctrl')
							)
							:strtolower('ctrl')
						)
					)
				)
		){
			throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Directory "%s" does not exist', self::getPathCtrl()));
		}
		if(NULL===self::setClass(
					(isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->ctrl_class) && strlen(trim(self::setClass(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->ctrl_class)))))
					?ucfirst(self::getClass())
					:ucfirst('Ctrl')
				)
		){
			throw Dadiweb_Throw_ErrorException::showThrow('Critical interrupt. The name of the default class is not established.');
		}
		
		self::setFileCtrl(self::getPathCtrl().DIRECTORY_SEPARATOR.ucfirst(self::getController()).self::getClass().'.php',true);
		//Dadiweb_Aides_Debug::show(self::getFileCtrl(),true);
		if(NULL===self::setFileCtrl()){
			if(false===is_file(
				(isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->ctrl_class))
					?(
						(strlen(trim(self::setFileCtrl(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->ctrl_class)))))
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
		self::setPath(
			Dadiweb_Configuration_Settings::getInstance()->getPath().DIRECTORY_SEPARATOR.self::getProgram()
			.(
				(NULL!==Dadiweb_Configuration_Routes::getInstance()->getABC())
				?(DIRECTORY_SEPARATOR.Dadiweb_Configuration_Routes::getInstance()->getABC())
				:''
			)
		);
		//Dadiweb_Aides_Debug::show($this,true);
		/**
		 * Setup bootsrap class of app
		 */
		self::setClass(ucfirst(self::getProgram())."_".ucfirst(self::getController()).self::getClass());
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
    public function getProgram()
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
    public function getController()
    {
    	return $this->_ctrl;
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
    public function getMethod()
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
    public function getMethodDefault()
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
    public function getPathCtrl()
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
    public function getClass()
    {
    	return $this->_class;
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