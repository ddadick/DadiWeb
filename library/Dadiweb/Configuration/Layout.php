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
    
    /**
     * Generic switch
     *
     * @var Boolean()
     */
    protected $_rendered_switch = true;

    /**
     * Layout switch
     *
     * @var Boolean()
     */
    protected $_layout_switch = true;

    /**
     * View switch
     *
     * @var Boolean()
     */
    protected $_view_switch = true;

    /**
     * Name of view (apps)
     *
     * @var String()
     */
    protected $_view_name = null;
    
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
    		!isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Layout->path) ||
    		!strlen($this->_path_generic=trim(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Layout->path))
    	){
    		throw Dadiweb_Throw_ErrorException::showThrow(
    			sprintf('Variable into "apps.Layout.path" in the file "%sapps.ini" is not valid', INI_PATH)
    		);
    	}
    	$this->_path_generic=Dadiweb_Aides_Filesystem::pathCreate($this->_path_generic);
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
    public function getRendered($content='')
    {
    	/**
    	self::getView($content);
    	Dadiweb_Aides_Debug::show(
    	array(
    	self::getPathGeneric(),
    	Dadiweb_Configuration_Settings::getInstance()->getPath(),
    	Dadiweb_Configuration_Settings::getInstance()->getAppsPath(),
    	Dadiweb_Configuration_Settings::getInstance()->getABCAppsPath(),
    	Dadiweb_Configuration_Kernel::getInstance()->getRoutes()->getABC(),
    	Dadiweb_Configuration_Kernel::getInstance()->getApps()->getLayoutProgram(),
    	Dadiweb_Configuration_Kernel::getInstance()->getApps()->getLayoutController(),
    	Dadiweb_Configuration_Kernel::getInstance()->getApps()->getLayoutMethod(),
    	Dadiweb_Configuration_Kernel::getInstance()->getApps()->getLayoutDefaultMethod()
    	)
    	,true);
    	
    	
    	self::setTemplate('index.tpl');
    	*/
    	Dadiweb_Configuration_Kernel::getInstance()->getRendered()->getRender()->setTemplateDir(self::getPathGeneric());
    	if(self::getSwitchRendered()){
    		if(self::getSwitchView()){
    			$content=self::getView($content);
    		}
    		/**
    		if(self::getSwitchLayout()){
    			$content=Dadiweb_Configuration_Kernel::getInstance()->getRendered()->_echo($content);
    		}
    		*/
    		return $content;
    		
    	}
    	return ;
    	//Dadiweb_Aides_Debug::show(Dadiweb_Configuration_Kernel::getInstance()->getApps()->getProgram(),true);
    	//Dadiweb_Aides_Debug::show(Dadiweb_Configuration_Kernel::getInstance()->getApps()->getController(),true);
    	
    	self::setTemplate('index.tpl');
    	Dadiweb_Configuration_Kernel::getInstance()->getRendered()->getRender()->setTemplateDir(self::getPathGeneric());
    	return Dadiweb_Configuration_Kernel::getInstance()->getRendered()->_echo($content);
    }
/***************************************************************/
    /**
     * Return HTML - View of app 
     *
     * @return String()
     *
     */
    
    protected function getView($content='')
    {
    	if(self::getSwitchView()){
    		if(
    			false == is_dir(
    				$path=Dadiweb_Aides_Filesystem::pathValidator(
    					Dadiweb_Configuration_Settings::getInstance()->getPath().DIRECTORY_SEPARATOR.
    					(
    						(NULL!==Dadiweb_Configuration_Kernel::getInstance()->getRoutes()->getABC())
    						?Dadiweb_Configuration_Kernel::getInstance()->getRoutes()->getABC().DIRECTORY_SEPARATOR
    						:''
    					).Dadiweb_Configuration_Kernel::getInstance()->getApps()->getLayoutProgram().DIRECTORY_SEPARATOR.
    					($render=
    						(isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Render->app_path))
    						?Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Render->app_path
    						:'render'
    					).
    					DIRECTORY_SEPARATOR.Dadiweb_Configuration_Kernel::getInstance()->getApps()->getLayoutController()
    				)
    			)
    		){
    			throw Dadiweb_Throw_ErrorException::showThrow(
    				sprintf('Path "%s" not found', $path)
    			);
    		}
    		if(false===realpath(
    				(
    					(self::getViewName()===NULL)
    					?(
    						$path.self::setViewName(
    							Dadiweb_Configuration_Kernel::getInstance()->getApps()->getLayoutMethod().'_'.
    							(
    								(isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->view_prefix))
    								?Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->view_prefix
    								:'layout'
    								).'.'.
    							(
    								(isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Smarty->extension))
    								?Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Smarty->extension
    								:'tpl'
    							)
    						)
    					)
    					:self::getViewName()
    				)
    			)
    		){
    			throw Dadiweb_Throw_ErrorException::showThrow(
    					sprintf('Template "%s" not found', $path.self::getViewName())
    			);
    		}
    		Dadiweb_Configuration_Kernel::getInstance()->getRendered()->getRender()->setTemplateDir($path);
    		self::setTemplate(self::getViewName());
    		return Dadiweb_Configuration_Kernel::getInstance()->getRendered()->_echo($content);    		
    	}
    	return;
    }
    
/***************************************************************/
    /**
     *
     * Set rendered switch
     *
     * @var Boolean()
     *
     */
    public function useRendered($rendered_switch=true)
    {
    	return $this->_rendered_switch=$rendered_switch;
    }
/***************************************************************/
    /**
     *
     * Get rendered switch
     *
     * @return Boolean()
     *
     */
    protected function getSwitchRendered()
    {
    	return $this->_rendered_switch;
    }
/***************************************************************/
    /**
     *
     * Set layout switch
     *
     * @var Boolean()
     *
     */
    public function useLayout($layout_switch=true)
    {
    	return $this->_layout_switch=$layout_switch;
    }
/***************************************************************/
    /**
     *
     * Get layout switch
     *
     * @return Boolean()
     *
     */
    protected function getSwitchLayout()
    {
    	return $this->_layout_switch;
    }
/***************************************************************/
    /**
     *
     * Set view switch
     *
     * @var Boolean()
     *
     */
    public function useView($view_switch=true)
    {
    	return $this->_view_switch=$view_switch;
    }
/***************************************************************/
    /**
     *
     * Get view switch
     *
     * @return Boolean()
     *
     */
    protected function getSwitchView()
    {
    	return $this->_view_switch;
    }
/***************************************************************/
    /**
     *
     * Set name of view (apps)
     *
     * @var String()
     *
     */
    public function setViewName($view_name=NULL)
    {
    	return $this->_view_name=$view_name;
    }
/***************************************************************/
    /**
     *
     * Get name of view (apps)
     *
     * @return String()
     *
     */
    protected function getViewName()
    {
    	return $this->_view_name;
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