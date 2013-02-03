<?php
class Dadiweb_Render_Smarty
{
	/**
	 * Rendered Object
	 * 
	 * @var Object
	 */
	
	protected $_bootstrap = null;
	
	/**
	 * Default set variables
	 *
	 * @var Object
	 */
	
	protected $_variables = array();
	
	/**
	 * Filename of rendered class
	 *
	 * @var string
	 */
	
	protected $_filename = null;
	
	/**
	 * General Classname of rendered class
	 *
	 * @var string
	 */
	
	protected $_classname = null;
	
	/**
	 * Charset of rendered class
	 *
	 * @var string
	 */
	
	protected $_charset = null;
	
	/**
	 * Compile dir of rendered class
	 *
	 * @var string
	 */
	
	protected $_compile_dir = null;
	
	/**
	 * Cache dir of rendered class
	 *
	 * @var string
	 */
	
	protected $_cache_dir = null;
	
	/**
	 * Templater Object
	 *
	 * @var Class()
	 */
	
	protected $_rendered = null;
/***************************************************************/
	/**
     * Virtual singleton pattern implementation makes "new" unavailable
     *
     * @return void
     */
	public function __construct($options=NULL){
		if($options===NULL || !is_string($options)){
			throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Critical error. Variable "resource.Render.bootstrap" from the file "%sresourse.ini" was not transmitted in class "%s"', INI_PATH,get_class($this)));
		}
		$this->_bootstrap=$options;
		self::$options($options);
		unset($this);
		return;
	}
/***************************************************************/
	/**
	 * The function for rendered
	 *
	 * @return string
	 */
	public function _echo($options=NULL)
	{

		return $options;
		 
	}
/***************************************************************/
    /**
     * The function init Smarty
     *
     * @return string
     */
    protected function Smarty()
    {
    	$options=$this->_bootstrap;
    	if(
    		!isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->$options->filename) ||
    		!strlen($this->_filename=trim(ucfirst(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->$options->filename)))
    	){
    		throw Dadiweb_Throw_ErrorException::showThrow(
    			sprintf('Variable into "resource.'.$options.'.filename" in the file "%sresourse.ini" is not valid', INI_PATH));
    	}   	
    	if(
    		!is_file($this->_filename) &&
    		!is_file($this->_filename=dirname(__FILE__).DIRECTORY_SEPARATOR.$this->_bootstrap.DIRECTORY_SEPARATOR.$this->_filename)
    	){
    		throw Dadiweb_Throw_ErrorException::showThrow(
    			sprintf('Filename "%s" into "resource.'.$options.'.filename" in the file "%sresourse.ini" does not exist', $this->_filename,INI_PATH)
    		);
    	}
    	require_once $this->_filename;
    	if(
    		!isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->$options->class) ||
    		!strlen($this->_classname=trim(ucfirst(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->$options->class)))
    	){
    		throw Dadiweb_Throw_ErrorException::showThrow(
    			sprintf('Variable into "resource.'.$options.'.class" in the file "%sresourse.ini" is not valid', INI_PATH)
    		);
    	}
    	$this->_rendered=new $this->_classname();
    	if(
    		!isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->$options->compile_dir) ||
    		!strlen($this->_compile_dir=trim(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->$options->compile_dir))
    	){
    		throw Dadiweb_Throw_ErrorException::showThrow(
    			sprintf('Variable into "resource.'.$options.'.compile_dir" in the file "%sresourse.ini" is not valid', INI_PATH)
    		);
    	}
    	$this->_compile_dir=Dadiweb_Aides_Filesystem::pathCreate($this->_compile_dir);
    	if(
    		!isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->$options->cache_dir) ||
    		!strlen($this->_cache_dir=trim(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->$options->cache_dir))
    	){
    		throw Dadiweb_Throw_ErrorException::showThrow(
    			sprintf('Variable into "resource.'.$options.'.cache_dir" in the file "%sresourse.ini" is not valid', INI_PATH)
    		);
    	}
    	$this->_cache_dir=Dadiweb_Aides_Filesystem::pathCreate($this->_cache_dir);
    	/**
    	 * Init Smarty
    	 */
    	$this->_rendered->setCompileDir($this->_compile_dir);
    	$this->_rendered->setCacheDir($this->_cache_dir);
    	return $this;
    	
    }
/***************************************************************/
    /**
     *
     * Handler variables that do not exist (input)
     *
     * @return Nothing
     *
     */
    public function __set($name, $value)
    {
    	$this->_variables[$name] = $value;
    	$this->_rendered->assign($name,$value);
    }
/***************************************************************/
    /**
     *
     * Handler variables that do not exist (output)
     *
     * @return $this->_variables
     *
     */
    public function __get($name)
    {
    	if (array_key_exists($name, $this->_variables)) {
    		return $this->_variables[$name];
    	}
    	return NULL;
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
         	throw Dadiweb_Render_Exception::getInstance()->getMessage(
         		sprintf('The required method "%s" does not exist for %s', $method, get_class($this))
         	); 
       	} 	
    }
/***************************************************************/
}