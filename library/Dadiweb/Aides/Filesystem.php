<?php
class Dadiweb_Aides_Filesystem
{
	/**
     * Singleton instance
     * 
     * @var Dadiweb_Aides_Filesystem
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
     * Returns an instance of Dadiweb_Aides_Filesystem
     * Singleton pattern implementation
     *
     * @return Dadiweb_Aides_Filesystem Provides a fluent interface
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
     * Returns contents of the directory
     *
     * $options:
     * - NULL       : return contens of the path $_SERVER["DOCUMENT_ROOT"];
     * - array()    : returns content's paths from array();
     * - stdClass() : returns content's paths from stdClass();
     * - string     : returns content's paths from string;
     * 
     * $sorting:
     *  - NULL : the sorted order is alphabetical in ascending order;
     *  - 0    : the result is unsorted;
     *  - 1    : the sort order is alphabetical in descending order;
     * 
     * $key_type:
     *  - NULL : key's array() or stdClass() as is;
     *  - 0    : key's array() or stdClass() as lower case;
     *  - 1    : key's array() or stdClass() as upper case;
     * 
     * @return NULL or Array(type: 0 - is not dir / 1 - is dir; item: path or filename)
     */
    public function getScanDir($options=NULL, $sorting=NULL ,$key_type=NULL)
    {
    	if(is_array($options)) {
    		if($key_type!==NULL && !$key_type){
    			$options=array_change_key_case ($options, CASE_LOWER);
    		}elseif($key_type!==NULL && $key_type){
    			$options=array_change_key_case ($options, CASE_UPPER);
    		}
    		foreach($options as $key=>$item){
    			if(is_array($item)){
    				$options[$key]=self::getScanDir($item,$sorting,$key_type);
    			}
    		}
    	}elseif($options instanceof stdClass) {
    		$options=self::getScanDir(Dadiweb_Aides_Array::getInstance()->obj4arr($options,$key_type),$sorting,$key_type);
    	}elseif(is_string($options)) {
    		if($sorting!==NULL && !$sorting && is_dir($options)){
    			$options=scandir($options, SCANDIR_SORT_NONE);
    		}elseif($sorting!==NULL && $sorting && is_dir($options)){
    			$options=scandir($options, SCANDIR_SORT_DESCENDING);
    		}elseif(is_dir($options)){
    			$options=scandir($options);
    		}else{
    			$options=NULL;
    		}
    		if($options!=NULL && is_array($options)){
    			$result=array();
    			foreach($options as $item){
    				if($item!='.' && $item!='..' && is_dir($item)){
    					array_push($result,array('type'=>1,'item'=>$item));
    				}elseif($item!='.' && $item!='..'){
    					array_push($result,array('type'=>0,'item'=>$item));
    				}
    			}
    			if(count($result)){
    				$options=$result;
    			}else{
    				$options=NULL;
    			}
    			unset($result);
    		}else{
    			$options=NULL;
    		}
    		
    	}else{
    		$options=NULL;
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