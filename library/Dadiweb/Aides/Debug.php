<?php
class Dadiweb_Aides_Debug
{
	/**
     * Singleton instance
     * 
     * @var Dadiweb_Aides_Array
     */
    protected static $_instance = null;
    
/***************************************************************/
	/**
     * Singleton pattern implementation makes "new" unavailable
     *
     * $options - variable for debugger
     *
     * $key_type: 
     * 0 - continue the script; 
     * 1 - stop script 
     *
     * @return information debugger
     */
	public function __construct($options=NULL,$key_type=NULL){
		self::debug($options,$key_type);
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
     * Returns information debugger
     *
     * $options - variable for debugger
     *
     * $key_type: 
     * 0 - continue the script; 
     * 1 - stop script
     *
     *
     * @return information debugger
     */
    
    public static function getInstance($options=NULL,$key_type=NULL)
    {
    	if (null === self::$_instance) {
            self::$_instance = new self($options,$key_type);
        }
        return self::$_instance;
    }
/***************************************************************/
    /**
     * Returns Debug
     * 
     * $options - variable for debugger
     *
     * $key_type: 
     * 0 - continue the script; 
     * 1 - stop script
     * 
     * 
     * @var Array()
     * @return stdClass()
     */
    public static function show($options=NULL, $key_type=NULL)
    {
    	$target=debug_backtrace();
    	echo '<pre>';
    	echo 'File - "'.$target[0]['file'].'"; line - '.$target[0]['line'].'<br />';
    	echo '<br />'.var_dump($options).'</pre>';
    	if($key_type!==NULL && $key_type){
    		exit;
    	}
    	return ;
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