<?php
class Dadiweb_Configuration_Session
{
	/**
     * Singleton instance
     * 
     * @var Dadiweb_Configuration_Session
     */
    protected static $_instance = null;
    
    /**
     * Render object
     *
     * @var Dadiweb_Configuration_Session
     */
    protected $_session = null;
    
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
     * Returns an instance of Dadiweb_Configuration_Session
     * Singleton pattern implementation
     *
     * @return Dadiweb_Configuration_Session Provides a fluent interface
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
     * Reset instance of Dadiweb_Configuration_Session
     * Singleton pattern implementation
     *
     * @return Dadiweb_Configuration_Session Provides a fluent interface
     */
    public static function resetInstance()
    {
    	return self::$_instance=NULL;
    }
/***************************************************************/
    /**
     * Returns Configuration Session
     *
     * @return stdClass
     */
    public function getGeneric()
    {
    	
    	if($this->_session===NULL){
    		self::setGeneric();
    	}
    	
    	return $this->_session;
    }
/***************************************************************/
    /**
     * Setup Configuration Session
     *
     * @return stdClass
     */
    protected function setGeneric()
    {
    	$this->_session=Dadiweb_Aides_Array::getInstance()->implode_Keys(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->session,'.',true);
    	foreach($this->_session as $key=>$item){
    		$this->_session->{$key}=(
    			(false===strpos($key, 'type.'))
    			?(
    				(trim($item)!="")
    				?(
    					('path'==$this->_session->{'type.'.$key})
	    				?(
    						(DIRECTORY_SEPARATOR!==$item)
    						?Dadiweb_Aides_Filesystem::pathCreate(Dadiweb_Aides_Filesystem::pathValidator($item))
    						:Dadiweb_Aides_Filesystem::pathCreate(
    							Dadiweb_Aides_Filesystem::pathValidator(
    								APPS_PATH.'/../'.
    								(
    									(
    										isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->Session->save_path)
    										&& strlen(trim(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->Session->save_path))
    									)
    									?Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->Session->save_path
    									:'session'
    								)
    							)
    						)
    					)
    					:(
    						('integer'==$this->_session->{'type.'.$key})
    						?(int)$item
    						:(
    							('boolean'==$this->_session->{'type.'.$key})
    							?(boolean)$item
    							:trim($item)
    						)
    					)
    				)
    				:NULL
    			)
    			:trim($item)
    		);
    		if(NULL===$this->_session->{$key}){
    			unset($this->_session->{$key});
    		}
    	}
    	foreach($this->_session as $key=>$item){
    		if(false!==strpos($key, 'type.')){
    			unset($this->_session->{$key});
    		}else{
    			ini_set($key, $item);
    		}
    	}
    	session_start();
    	return;
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
         	throw Dadiweb_Configuration_Exception::getInstance()->getMessage(sprintf('The required method "%s" does not exist for %s', $method, get_class($this))); 
       	} 	
    }
/***************************************************************/
}