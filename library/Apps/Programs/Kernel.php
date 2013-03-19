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
	 * Return variables from Dadiweb_Configuration_Pattern (variables url)
	 *
	 * @return Void
	 *
	 */
	public function getParam($name=NULL, $value=NULL)
	{
		return Dadiweb_Configuration_Kernel::getInstance()->getPattern()->getParam($name, $value);
	}
	
/***************************************************************/
	/**
	 *
	 * Set rendered switch
	 *
	 * @return Boolean()
	 *
	 */
	public function useRendered($rendered_switch=true)
	{
		return Dadiweb_Configuration_Kernel::getInstance()->getLayout()->useRendered($rendered_switch);
	}
	
/***************************************************************/
	/**
	 *
	 * Set view switch
	 *
	 * @return Boolean()
	 *
	 */
	public function useView($view_switch=true)
	{
		return Dadiweb_Configuration_Kernel::getInstance()->getLayout()->useView($view_switch);
	}
	
/***************************************************************/
	/**
	 *
	 * Set view name
	 *
	 * @return Boolean()
	 *
	 */
	public function setViewName($view_name=NULL)
	{
		return Dadiweb_Configuration_Kernel::getInstance()->getLayout()->setViewName($view_name);
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
    		throw Dadiweb_Throw_ErrorException::showThrow(sprintf('The required method "%s" does not exist for %s', $method, get_class($this))); 
       	} 	
    }
/***************************************************************/
}