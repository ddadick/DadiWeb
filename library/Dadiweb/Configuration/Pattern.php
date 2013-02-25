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
	 * MVC - default Model
	 *
	 * @return object
	 */
	protected $model = NULL;
	
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
		$this->uri=split('\?',Dadiweb_Http_Client::getInstance()->getUri(),2);
		if(is_array($this->uri) && isset($this->uri[1]) && is_array($array=split('\&',$this->uri[1]))){
			foreach($array as $value){
				$value=split('=',$value);
				if(is_array($value) && isset($value[0]) && isset($value[1]) && $value[1]!=NULL && strlen(trim($value[1]))>0){
					$this->variables[$value[0]]=$value[1];
				}
			}
		}
		$this->uri=$this->uri[0];
   		$this->uri=split('\/',substr($this->uri, 1),4);
   		if(
   			strtolower($this->uri[0])==Dadiweb_Configuration_Routes::getInstance()->getABC() && count($this->uri)>1
   		){
   			$this->uri=split('\/',implode('/',(array_shift($this->uri)?$this->uri:array('/'))),4);
   			
   		}elseif(strtolower($this->uri[0])==Dadiweb_Configuration_Routes::getInstance()->getABC() && count($this->uri)==2 && !strlen(trim($this->uri[1]))){
   			$this->uri[0]='';
   			unset($this->uri[1]);
   		}elseif(strtolower($this->uri[0])==Dadiweb_Configuration_Routes::getInstance()->getABC() && count($this->uri)==1){
   			$this->uri[0]='';
   		}else{
   			Dadiweb_Configuration_Routes::getInstance()->setABC();
   		}
   		if(($router=Dadiweb_Configuration_Routes::getInstance()->searchRouter($this->uri))!==NULL && is_string($router)){
   			$this->uri=split('\/',substr($router, 1),4);
   		}elseif($router!==NULL && is_array($router)){
   			$this->uri=split('\/',substr($router[0], 1),4);   			
   			foreach($router[1] as $key=>$value){
   				$this->variables[$key]=$value;
   			}
   		}
		$i=0;
		if(is_array($this->uri)){
			foreach($this->uri as $value){
				if(($value==NULL or strlen(trim($value))<=0) and $i<4){
					$this->uri[$i]=NULL;
				}
				$i=$i+1;
			}
			if(isset($this->uri[0])){$this->setModel($this->uri[0]);}
			if(isset($this->uri[1])){$this->setController($this->uri[1]);}
			if(isset($this->uri[2])){$this->setView($this->uri[2]);}
			if(isset($this->uri[3])){
				foreach(array_chunk(split('\/',$this->uri[3]), 2) as $value){
					if(is_array($value) && isset($value[0]) && isset($value[1]) && $value[1]!==NULL && strlen(trim($value[1]))){
						$this->variables[$value[0]]=$value[1];
					}
				}
			}
		}
		return $this;
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