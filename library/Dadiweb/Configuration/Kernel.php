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
     * Current view
     *
     * @return String()
     */
    protected $_view = NULL;
    
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
    	$p=Dadiweb_Configuration_Pattern::getInstance();
    	$s=Dadiweb_Configuration_Settings::getInstance();
		$resourse=Dadiweb_Aides_Array::getInstance()->arr2obj($s->getGeneric())->resource;
		//self::setPath($resourse->Master->path);
		//Dadiweb_Aides_Debug::show(realpath(self::getPath()),true);
		if(!isset($resourse->Master->path) || self::setPath($resourse->Master->path)===NULL || false===realpath(self::getPath())){
			throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Path into "resource.Master.path" in the file "%sresourse.ini" is not valid', INI_PATH));
		}
		if(NULL===$p->getApplication() && NULL===$p->getController() && NULL===$p->getView()){
			if(!isset($resourse->Master->prog) || !strlen(trim(self::setProgram($resourse->Master->prog)))){
				throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Value into "resource.Master.prog" in the file "%sresourse.ini" is not valid or empty', INI_PATH));
			}elseif(!isset($resourse->Master->ctrl) || !strlen(trim(self::setController($resourse->Master->ctrl)))){
				throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Value into "resource.Master.ctrl" in the file "%sresourse.ini" is not valid or empty', INI_PATH));
			}elseif(!isset($resourse->Master->view) || !strlen(trim(self::setView($resourse->Master->view)))){
				throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Value into "resource.Master.view" in the file "%sresourse.ini" is not valid or empty', INI_PATH));
			}elseif(false===realpath(self::setPathCtrl(self::getPath().DIRECTORY_SEPARATOR.self::getProgram()))){
				throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Directory "%s" does not exist', self::getPathCtrl()));
			}elseif(false===is_file(self::setFileCtrl(self::getPathCtrl().DIRECTORY_SEPARATOR.ucfirst(self::getController()).'Ctrl.php'))){
				throw Dadiweb_Throw_ErrorException::showThrow(sprintf('File "%s" does not exist', self::getFileCtrl()));
			}
			
			$return=get_include_path();
			
			set_include_path(
				implode(PATH_SEPARATOR,
					array(
						realpath(self::getPath()),
						get_include_path()
					)
				)
			);
			Dadiweb_Aides_Debug::show(get_include_path());
			
			set_include_path(
				implode(PATH_SEPARATOR,
					array(
						realpath(self::getPath())
					)
				)
			);
			var_dump(get_include_path());die;exit;
			
			
			ob_start(array($this,'test'));
			$d=self::getProgram()."_".ucfirst(self::getController()).'Ctrl';
			//$newfunc = create_function('$a', 'new "ln($a) + ln($b) = " . log($a * $b);');
			$s=new $d;
			//$s = new "self::getProgram()_ucfirst(self::getController())Ctrl";
			$s->test();
			//ob_get_contents();
			ob_end_flush();
			//echo $s;
			
			
			
			
		}
		
		//APPS_PATH,$resourse['resource']['Master']['path'];
		//$d=ucfirst(self::getProgram())."_".ucfirst(self::getController()).'Ctrl';
		Dadiweb_Aides_Debug::show(ucfirst(self::getProgram())."_".ucfirst(self::getController()).'Ctrl');
		Dadiweb_Aides_Debug::show(self::getPath());
    }
    protected function test($content){
    	return (str_replace("as", "oranges", $content));
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
     * Set current view
     *
     * @var String()
     *
     */
    protected function setView($view=NULL)
    {
    	return $this->_view=$view;
    }
/***************************************************************/
    /**
     *
     * Get current view
     *
     * @return String()
     *
     */
    protected function getView()
    {
    	return $this->_view;
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
     * Set file's controller (current)
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