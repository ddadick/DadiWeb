<?php
class Dadiweb_Configuration_Pattern
{
	/**
	 * Return Url
	 * 
	 * @return object
	 */
	protected $uri=NULL;
	
	/**
	 * MVC - default Application
	 * 
	 * @return object
	 */
	protected $application = NULL;
	
	/**
	 * MVC - default Contoller
	 * 
	 * @return object
	 */
	protected $controller = NULL;
	
	/**
	 * MVC - default View
	 * 
	 * @return object
	 */
	protected $view = NULL;

	/**
	 * MVC - default Model
	 *
	 * @return object
	 */
	protected $model = NULL;
	

	/**
	 * MVC - variables url
	 * 
	 * @return object
	 */	
	protected $variables = NULL;
	
	/**
   	 * Singleton instance
   	 * 
   	 * @var Dadiweb_Configuration_Pattern
   	 */
   	protected static $_instance = null;
   	
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
   		$this->setMVC();
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
     * Returns an instance of Dadiweb_Configuration_Pattern
   	 * Singleton pattern implementation
     *
   	 * @return Dadiweb_Configuration_Pattern Provides a fluent interface
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
     * Reset instance of Dadiweb_Configuration_Pattern
   	 * Singleton pattern implementation
     *
   	 * @return Dadiweb_Configuration_Pattern Provides a fluent interface
     */
   	public static function resetInstance()
    {
   	    return self::$_instance=NULL;
   	}
/***************************************************************/   	
   	/**
     * Returns an instance of Dadiweb_Configuration_Pattern
   	 * Singleton pattern implementation
     *
   	 * @return Dadiweb_Configuration_Pattern Provides a fluent interface
     */
	protected function setMVC(){
   		$this->uri=split('\/',substr(Dadiweb_Http_Client::getInstance()->getUri(), 1),4);
   		/**
   		 * Checking login administrative basic control
   		 */
   		if(
   			strtolower($this->uri[0])==(
   				(
   					isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->Master->abc) 
   					&& strlen(trim(self::setABC(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->Master->abc))))
   				)
   				?self::getABC()
   				:strtolower('abc')
   			) && count($this->uri)>1
   		){
   			$this->uri=split('\/',implode('/',(array_shift($this->uri)?$this->uri:array('/'))),4);
   		}elseif(strtolower($this->uri[0])==self::getABC() && count($this->uri)==1){
   			$this->uri[0]='';
   		}else{
   			self::setABC();
   		}
		$i=0;
		if(is_array($this->uri)){
			
			foreach($this->uri as $value){
				if(($value==NULL or strlen(trim($value))<=0) and $i<4){
					$this->uri[$i]=NULL;
				}
				$i=$i+1;
			}
			if(isset($this->uri[0])){$this->setApplication($this->uri[0]);}
			if(isset($this->uri[1])){$this->setController($this->uri[1]);}
			if(isset($this->uri[2])){$this->setView($this->uri[2]);}
			if(isset($this->uri[3])){
				$this->uri=split('\?',$this->uri[3],2);
				foreach(array_chunk(split('\/',$this->uri[0]), 2) as $value){
					if(is_array($value) && isset($value[0]) && isset($value[1]) && $value[1]!=NULL && strlen(trim($value[1]))>0){
						$this->variables[$value[0]]=$value[1];
					}
				}
			}
			if(isset($this->uri[1])){
				$this->uri=split('\&',$this->uri[1]);
				if(is_array($this->uri)){
					foreach($this->uri as $value){
						$value=split('=',$value);
						if(is_array($value) && isset($value[0]) && isset($value[1]) && $value[1]!=NULL && strlen(trim($value[1]))>0){
							$this->variables[$value[0]]=$value[1];
						}
					}
				}
			}
		}
		return $this;
   	}
/***************************************************************/   	
	/**
   	 * 
   	 * Set application
   	 * 
   	 * @var Application
   	 * 
   	 */
   	protected function setApplication($application=NULL)
   	{
   		$this->application=$application;
   	}
/***************************************************************/    	
    /**
   	 * 
   	 * Get application
   	 * 
   	 * @return Application
   	 * 
   	 */
   	public function getApplication()
   	{
   		return $this->application;
   	
   	}
/***************************************************************/   	
   	/**
   	 * 
   	 * Set controller 
   	 * 
   	 * @var Controller
   	 * 
   	 */
   	protected function setController($controller=NULL)
   	{
   		$this->controller=$controller;
   	}
/***************************************************************/   	
    /**
   	 * 
   	 * Get controller 
   	 * 
   	 * @return Controller
   	 * 
   	 */
   	public function getController()
   	{
   		return $this->controller;
   	}
/***************************************************************/    	
   	/**
   	 * 
   	 * Set model 
   	 * 
   	 * @var Model
   	 * 
   	 */
   	protected function setModel($model=NULL)
   	{
   		$this->model=$model;
   	}
/***************************************************************/   	
    /**
   	 * 
   	 * Get model 
   	 * 
   	 * @return Model
   	 * 
   	 */
   	public function getModel()
   	{
   		return $this->model;
   	}
/***************************************************************/
   	/**
   	 *
   	 * Set view
   	 *
   	 * @var View
   	 *
   	 */
   	protected function setView($view=NULL)
   	{
   		$this->view=$view;
   	}
/***************************************************************/
   	/**
   	 *
   	 * Get view
   	 *
   	 * @return View
   	 *
   	 */
   	public function getView()
   	{
   		return $this->view;
   	}
/***************************************************************/    	
    /**
   	 * 
   	 * Get variables uri
   	 * 
   	 * @return Parametr, default - NULL
   	 * 
   	 */
   	public function getParam($name=NULL, $param=NULL)
   	{
   		if(isset($this->variables[$name])){
   			return $this->variables[$name];
   		}
   		return $param;
   	}
/***************************************************************/    	
    /**
   	 * 
   	 * Set administrative basic control
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
   	 * Get administrative basic control
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
         	throw Dadiweb_Configuration_Exception::getInstance()->getMessage(sprintf('The required method "%s" does not exist for %s', $method, get_class($this))); 
       	} 	
   	}
/***************************************************************/
}