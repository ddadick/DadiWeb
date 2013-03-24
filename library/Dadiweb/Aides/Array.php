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
    public function arr2obj($options=array(), $key_type=NULL)
    {
    	if(is_array($options)){
    		if($key_type!==NULL && !$key_type){
    			$options=array_change_key_case ($options, CASE_LOWER);
    		}elseif($key_type!==NULL && $key_type){
    			$options=array_change_key_case ($options, CASE_UPPER);
    		}
    		foreach($options as $key=>$item){
    			if(is_array($item)){
    				$options[$key]=self::arr2obj($item, $key_type);
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
    public function obj2arr($options=NULL,$key_type=NULL)
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
    				$options[$key]=self::obj2arr($item, $key_type);
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
     * Split a string by string as stdClass() or Array()
     *
     * $string - the input string
     * $delimiter - the boundary string
     * $return:
     * - NULL : return Array();
     * - 0    : return Array();
     * - 1    : return stdClass();
     * @var string
     * @return Array() or stdClass()
     */
    public function explode($string=NULL, $delimiter=NULL, $return=NULL)
    {
    	$result=array();
    	if($delimiter!==NULL && $string!==NULL){
    		$result=explode($delimiter, $string);
	    	if(is_array($result)){
    			if($return!==NULL && $return){
    				$result=self::arr2obj($result);
    			}
	    	}
    	}
    	return $result;
    }
/***************************************************************/
    /**
     * Merge Array() or stdClass() keys into a string 
     *
     * $array - the input array
     * $delimiter - separator
     * $return:
     * - NULL : return Array();
     * - 0    : return Array();
     * - 1    : return stdClass();
     * @var Array() or stdClass()
     * @return String()
     */
    public function implode_Keys($array=NULL, $delimiter=NULL, $return=NULL)
    {
    	$result=array();
    	if($array instanceof stdClass){
    		$array=self::obj2arr($array);
    	}
    	if(is_array($array)){
    		foreach($array as $key=>$item){
    			if($item instanceof stdClass){
    				$item=self::obj2arr($item);
	    		}
	    		if(is_array($item)){    			
	    			foreach(self::implode_Keys($item) as $key2=>$item2){
	    				$result[$key.$delimiter.$key2]=$item2;
	    			}
	    		}else{
	    			$result[$key]=$item;
	    		}
    		}
    	}
    	if($return!==NULL && $return){
    		$result=self::arr2obj($result);
    	}
    	return $result;
    }
    
/***************************************************************/
    /**
     * Elements of the Array(stdClass) in turn key multi-dimensional Array(stdClass)
     *
     * $options - the input array()
     * $item - assigned value to key multi-dimensional Array(stdClass)
     * $reverse:
     *  - NULL : Array(stdClass) as is;
     *  - 0    : Array(stdClass) as is;
     *  - 1    : Array(stdClass) as reverse;
     * $key_type:
     *  - NULL : key's Array(stdClass) as is;
     *  - 0    : key's Array(stdClass) as lower case;
     *  - 1    : key's Array(stdClass) as upper case;
     * $return:
     * - NULL : return Array();
     * - 0    : return Array();
     * - 1    : return stdClass();
     * @var string
     * @return Array() or stdClass()
     */
    public function items_2_MultiDimensionalKeys($options=NULL, $item=NULL,$reverse=NULL,$key_type=NULL, $return=NULL)
    {
    	if($reverse!==NULL && $reverse){
    		$options=array_reverse($options);
    	}
    	for($i=(count($options)-1);$i>=0;$i--){
    		if($i==(count($options)-1)){
    			$result=array($options[$i]=>$item);
    		}else{
    			$result=array($options[$i]=>$result);
    		}
    	}
    	$options=$result;
    	unset($result);
    	if($key_type!==NULL && !$key_type){
    		$options=self::array_AllKeysToLowerCase($options);
    	}elseif($key_type!==NULL && $key_type){
    		$options=self::array_AllKeysToUpperCase($options);
    	}
    	if($return!==NULL && $return){
    		$options=self::arr2obj($options);
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