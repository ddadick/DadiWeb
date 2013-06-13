<?php
class Dadiweb_Aides_Request
{
    /**
     * Singleton instance.
     * 
     * @var Dadiweb_Aides_Request
     */
    protected static $_instance = null;
    
/***************************************************************/
	/**
     * Singleton pattern implementation makes "new" unavailable.
     *
     * @return void
     */
	protected function __construct(){}
/***************************************************************/
	/**
     * Singleton pattern implementation makes "clone" unavailable.
     *
     * @return void
     */
    protected function __clone(){}
/***************************************************************/
    /**
     * Returns an instance of Dadiweb_Aides_Request.
     * Singleton pattern implementation.
     *
     * @return Dadiweb_Aides_Request
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
     * Returns the sign of use XMLHttpRequest.
     * 
     * @return boolean
     */
    public function isXHR() 
    {
        return Dadiweb_Http_Client::getInstance()->isXHR();
    }
    
/***************************************************************/
    /**
     * Return variables from Dadiweb_Configuration_Pattern (variables url).
     *
     * @param string|null $name
     * @param string|null $value
     * @return string|null
     */
    public function getParam($name=NULL, $value=NULL)
    {
        return Dadiweb_Configuration_Kernel::getInstance()->getPattern()->getParam($name, $value);
    }
    
/***************************************************************/
    /**
     * Recognizes the POST method.
     * 
     * @return boolean
     */
    public function isPost(){
        return Dadiweb_Http_Client::getInstance()->isPost();
    }
    
/***************************************************************/
    /**
     * Recognizes the GET method.
     * 
     * @return boolean
     */
    public function isGet(){
        return Dadiweb_Http_Client::getInstance()->isGet();
    }
    
/***************************************************************/
    /**
     * Recognizes the PUT method.
     * 
     * @return boolean
     */
    public function isPut(){
        return Dadiweb_Http_Client::getInstance()->isPut();
    }
    
/***************************************************************/
    /**
     * Recognizes the DELETE method.
     * 
     * @return boolean
     */
    public function isDelete(){
        return Dadiweb_Http_Client::getInstance()->isDelete();
    }
    
/***************************************************************/
    /**
     * Recognizes the HEAD method.
     * 
     * @return boolean
     */
    public function isHead(){
        return Dadiweb_Http_Client::getInstance()->isHead();
    }
    
/***************************************************************/
    /**
     * Recognizes the OPTIONS method.
     * 
     * @return boolean
     */
    public function isOptions(){
        return Dadiweb_Http_Client::getInstance()->isOptions();
    }
    
/***************************************************************/
    /**
     * Recognizes the PATCH method.
     * 
     * @return boolean
     */
    public function isPatch(){
        return Dadiweb_Http_Client::getInstance()->isPatch();
    }
    
/***************************************************************/
    /**
     * Recognizes the TRACE method.
     * 
     * @return boolean
     */
    public function isTrace(){
        return Dadiweb_Http_Client::getInstance()->isTrace();
    }
    
/***************************************************************/
    /**
     * Recognizes the LINK method.
     * 
     * @return boolean
     */
    public function isLink(){
        return Dadiweb_Http_Client::getInstance()->isLink();
    }
    
/***************************************************************/
    /**
     * Recognizes the UNLINK method.
     * 
     * @return boolean
     */
    public function isUnlink(){
        return Dadiweb_Http_Client::getInstance()->isUnlink();
    }
    
/***************************************************************/
    /**
     * Recognizes the CONNECT method.
     * 
     * @return boolean
     */
    public function isConnect(){
        return Dadiweb_Http_Client::getInstance()->isConnect();
    }
    
/***************************************************************/
    /**
     * Recognizes the REQUEST method.
     * 
     * @return string|null
     */
    public function isRequest(){
        return Dadiweb_Http_Client::getInstance()->isRequest();
    }
    
/***************************************************************/
    /**
     * The handler functions that do not exist.
     * 
     * @param string $method
     * @param mixed $args
     * @return void
     */
    public function __call($method, $args)
    {
        if(!method_exists($this, $method)){
            throw Dadiweb_Throw_ErrorException::showThrow(
                sprintf('The required method "%s" does not exist for %s', $method, get_class($this))
            );
        }
    }
    
/***************************************************************/
}