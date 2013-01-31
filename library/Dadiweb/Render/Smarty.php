<?php
class Dadiweb_Render_Smarty
{
/***************************************************************/
	/**
     * Singleton pattern implementation makes "new" unavailable
     *
     * @return void
     */
	public function __construct(){
		return $GLOBALS['SUPERVISOR_RENDER']=$this;
	}
/***************************************************************/
    /**
     * Test function for rendered
     *
     * @return string
     */
    public function test()
    {
    	return 'asdasdasd';
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
         	throw Dadiweb_Aides_Exception::getInstance()->getMessage(sprintf('The required method "%s" does not exist for %s', $method, get_class($this))); 
       	} 	
    }
/***************************************************************/
}