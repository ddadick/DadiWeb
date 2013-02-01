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
	 * Rendered Class
	 *
	 * @var Object
	 */
	
	protected $_class = null;
	
	
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
		$GLOBALS['SUPERVISOR_RENDER']=self::$options();
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
     * The function init Smapty
     *
     * @return string
     */
    protected function Smarty()
    {
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
         	throw Dadiweb_Render_Exception::getInstance()->getMessage(sprintf('The required method "%s" does not exist for %s', $method, get_class($this))); 
       	} 	
    }
/***************************************************************/
}