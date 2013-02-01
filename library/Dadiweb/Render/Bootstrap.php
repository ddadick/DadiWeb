<?php
class Dadiweb_Render_Bootstrap
{
	/**
     * Singleton instance
     * 
     * @var Dadiweb_Render_Bootstrap
     */
    protected static $_instance = null;
    
/***************************************************************/
	/**
     * Singleton pattern implementation makes "new" unavailable
     *
     * @return void
     */
	protected function __construct($options=NULL){
		if($options===NULL || !is_string($options)){
			throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Critical error. Variable "resource.Render.bootstrap" from the file "%sresourse.ini" was not transmitted in class "%s"', INI_PATH,get_class($this)));
		}
		$bootstrap=ucfirst($options);
		$options='Dadiweb_Render_'.$bootstrap;
		//Dadiweb_Aides_Debug::show($options,true);
		$options=new $options($bootstrap);
		return;
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
     * Returns an instance of Dadiweb_Render_Bootstrap
     * Singleton pattern implementation
     *
     * @return Dadiweb_Render_Bootstrap Provides a fluent interface
     */
    public static function getInstance($options=NULL)
    {
    	if (null === self::$_instance) {
            self::$_instance = new self($options);
        }
        return self::$_instance;
    }
/***************************************************************/
    /**
     * Reset instance of Dadiweb_Render_Bootstrap
     * Singleton pattern implementation
     *
     * @return Dadiweb_Render_Bootstrap Provides a fluent interface
     */
    public static function resetInstance()
    {
        return self::$_instance=NULL;
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