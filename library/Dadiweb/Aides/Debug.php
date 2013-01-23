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
	protected function __construct($options=NULL,$key_type=NULL){
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
    public function debug($options=NULL, $key_type=NULL)
    {
    	$target=debug_backtrace();
    	ob_start();
    	var_dump($options);
    	$s=ob_get_clean();
    	echo '<pre>';
    	echo 'File - "'.$target[2]['file'].'"; line - '.$target[2]['line'].'<br />';
    	echo 'Class - "'.$target[3]['class'].'"; function - "'.$target[3]['function'].'"<br />';
    	echo '<br />'.$s.'</pre>';
    	ob_start();
    	if($key_type!==NULL){
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