<?php
class Dadiweb_Aides_Array
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
     * Returns an instance of Dadiweb_Aides_Array
     * Singleton pattern implementation
     *
     * @return Dadiweb_Aides_Array Provides a fluent interface
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
     * Returns stdClass() from Array()
     * 
     * $options=array()
     * $key_type:
     *  - NULL : key's array as is;
     *  - 0    : key's array as lower case;
     *  - 1    : key's array as upper case;
     * @var Array()
     * @return stdClass()
     */
    public function arr4obj($options=array(), $key_type=NULL)
    {
    	if(is_array($options)){
    		if($key_type!==NULL && !$key_type){
    			$options=array_change_key_case ($options, CASE_LOWER);
    		}elseif($key_type!==NULL && $key_type){
    			$options=array_change_key_case ($options, CASE_UPPER);
    		}
    		foreach($options as $key=>$item){
    			if(is_array($item)){
    				$options[$key]=self::arr4obj($item, $key_type);
    			}
    		}
    	}else{
    		$options=array();
    	}    	
    	return (object)$options;
    }
/***************************************************************/
    /**
     * Returns Array() from stdClass()
     * 
     * $options=stdClass()
     * $key_type:
     *  - NULL : key's stdClass as is;
     *  - 0    : key's stdClass as lower case;
     *  - 1    : key's stdClass as upper case;
     * @var stdClass()
     * @return Array()
     */
    public function obj4arr($options=NULL,$key_type=NULL)
    {
    	if($options instanceof stdClass){
    		$options=(array)$options;
    		if($key_type!==NULL && !$key_type){
    			$options=array_change_key_case ($options, CASE_LOWER);
    		}elseif($key_type!==NULL && $key_type){
    			$options=array_change_key_case ($options, CASE_UPPER);
    		}
    		foreach($options as $key=>$item){
    			if($item instanceof stdClass){
    				$options[$key]=self::obj4arr($item, $key_type);
    			}
    		}
    	}else{
    		$options = stdClass();
    	}
    	return $options;
    }
/***************************************************************/
    /**
     * Returns an array with the keys of the lower case
     * 
     * @var Array()
     * @return Array()
     */
    public function array_AllKeysToLowerCase($options=NULL)
    {
    	if(is_array($options)){
    		$options=array_change_key_case ($options, CASE_LOWER);
    		foreach($options as $key=>$item){
    			if(is_array($item)){
					$options[$key]=self::array_AllKeysToLowerCase($item);    				
    			}
    		}
    	}else{
    		$options=array();
    	}
    	return $options;
    }
/***************************************************************/
    /**
     * Returns an array with the keys of the upper case
     * 
     * @var Array()
     * @return Array()
     */
    public function array_AllKeysToUpperCase($options=NULL)
    {
    	if(is_array($options)){
    		$options=array_change_key_case ($options, CASE_UPPER);
    		foreach($options as $key=>$item){
    			if(is_array($item)){
    				$options[$key]=self::array_AllKeysToUpperCase($item);
    			}
    		}
    	}else{
    		$options=array();
    	}
    	return $options;
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