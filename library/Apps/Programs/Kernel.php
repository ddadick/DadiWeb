<?php
class Apps_Programs_Kernel
{
	/**
	 * Rendered Object
	 *
	 * @var Object
	 */
	protected $rendered=NULL;

	/**
	 * Default set variables
	 *
	 * @var Object
	 */
	
	protected $_variables = array();
	
/***************************************************************/
	/**
     * Init Programs
     *
     * @return void
     */
	public function __construct(){
		$this->rendered=Dadiweb_Configuration_Kernel::getInstance()->getRendered();
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
         	throw Apps_Programs_Exception::getInstance()->getMessage(sprintf('The required method "%s" does not exist for %s', $method, get_class($this))); 
       	} 	
    }
/***************************************************************/
}