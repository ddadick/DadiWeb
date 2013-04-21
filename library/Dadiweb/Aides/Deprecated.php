<?php
class Dadiweb_Aides_Deprecated
{
	/**
     * Singleton instance
     * 
     * @var Dadiweb_Aides_Deprecated
     */
    protected static $_instance = null;
    
/***************************************************************/
	/**
     * Singleton pattern implementation makes "new" unavailable
     *
     * @return void
     */
	protected function __construct(){}
/***************************************************************/
	/**
     * Singleton pattern implementation makes "clone" unavailable
     *
     * @return void
     */
    protected function __clone(){}
/***************************************************************/
    /**
     * Returns an instance of Dadiweb_Aides_Deprecated
     * Singleton pattern implementation
     *
     * @return Dadiweb_Aides_Deprecated Provides a fluent interface
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
     * Chooses which functions (split() or preg_split()) use depending on the version of PHP
     * 
     * @see http://php.net/manual/en/function.split.php
     * @see http://php.net/manual/en/function.preg-split.php
     * 
     * @param parametrs for functions PHP or split(), or preg_split()
     * @return result functions PHP split() or preg_split()
     */
    public static function split($options=NULL)
    {
    	if($options==NULL){return NULL;}
    	if(phpversion()>='5.3.0'){
    		$var='';
    		foreach($options as $item){
    			$i=(isset($i))?($i+1):0;
    			if($i==0){
    				$var.="'/".$item."/'";
    			}else{
    				if(is_int($item)){
    					$var.=$item;
    				}else{
    					$var.="'".$item."'";
    				}
    			}
    			if(count($options)>($i+1)){
    				$var.=", ";
    			}
    		}
    		$func = create_function('$var', 'return preg_split('.$var.');');
    		return $func($var);
    	}else{
    		$var='';
    		foreach($options as $item){
    			$i=(isset($i))?($i+1):0;
    			if($i==0){
    				$var.="'".$item."'";
    			}else{
    				if(is_int($item)){
    					$var.=$item;
    				}else{
    					$var.="'".$item."'";
    				}
    			}
    			if(count($options)>($i+1)){
    				$var.=", ";
    			}
    		}
    		$func = create_function('$var', 'return split('.$var.');');
    		return $func($var);
    	}
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