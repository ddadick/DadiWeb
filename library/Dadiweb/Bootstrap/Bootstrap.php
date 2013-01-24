<?php
require_once 'Dadiweb/Loader/Autoload.php';
require_once 'Dadiweb/Bootstrap/Exception.php';
class Dadiweb_Bootstrap_Bootstrap extends Dadiweb_Throw_ErrorException
{
	/**
	 * 
	 * MVC - default Contoller
	 * @return object
	 */
	public $controller = NULL;
	/**
	 * 
	 * MVC - default Model
	 * @return object
	 */
	public $model = NULL;
	/**
	 * 
	 * MVC - default View
	 * @return object
	 */
	public $view = NULL;
	public $request_uri = NULL;
	public $management = NULL;
	public $variables = NULL;
/***************************************************************/
	/**
	 * 
	 * Bootstraper Dadiweb
	 * @category	Dadiweb
	 * @package		Dadiweb_Bootstrap_Bootstrap
	 * @return		MVC object
	 */	
	public function __construct($mode=NULL, $option=array()){
		parent::__construct();
		$this->autoload();
		Dadiweb_Pattern_Pattern::getInstance();
		Dadiweb_Configuration_Settings::getInstance()->setGeneric();
	}
/***************************************************************/
	/**
	 * 
	 * Autoloader classes
	 * @category	Dadiweb
	 * @package		Dadiweb_Bootstrap_Bootstrap
	 * @return		Object of Dadiweb
	 */	
	protected function autoload(){
		Dadiweb_Loader_Autoload::getInstance();
		return $this;
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
         	throw Dadiweb_Bootstrap_Exception::getInstance()->getMessage(sprintf('The required method "%s" does not exist for %s', $method, get_class($this))); 
       	} 	
   	}
/***************************************************************/
}