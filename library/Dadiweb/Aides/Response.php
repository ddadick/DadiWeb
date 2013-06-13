<?php
class Dadiweb_Aides_Response
{
    /**
     * Singleton instance.
     * 
     * @var Dadiweb_Aides_Response
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
     * Returns an instance of Dadiweb_Aides_Response.
     * Singleton pattern implementation.
     *
     * @return Dadiweb_Aides_Response
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
     * Set headers of response.
     * 
     * @param string|array $search
     * @return boolean
     */
    public function setHeaders($_headers=NULL) 
    {
        Dadiweb_Http_Client::getInstance()->setHeadersResponse($_headers);
        return $this;
    }
    
/***************************************************************/
    /**
     * Get headers of response.
     * 
     * @param string|array|null $search
     * @return boolean
     */
    public function getHeaders($_headers=NULL) 
    {
        return Dadiweb_Http_Client::getInstance()->getHeadersResponse($_headers);
    }
    
/***************************************************************/
    /**
     * Set body of response.
     * 
     * @param string|null $search
     * @return Dadiweb_Aides_Response
     */
    public function setBody($_body=NULL)
    {
        Dadiweb_Http_Client::getInstance()->setBody($_body);
        return $this;
    }
    
/***************************************************************/
    /**
     * Delete headers of response.
     * 
     * @param string|array|null $search
     * @return Dadiweb_Aides_Response
     */
    public function cleanHeaders($_headers=NULL) 
    {
        Dadiweb_Http_Client::getInstance()->removeHeadersResponse($_headers);
        return $this;
    }
    
/***************************************************************/
    /**
     * Send response.
     * 
     * @param boolean $search
     * @return boolean|string|null
     */
    public function sendResponse($_response=false)
    {
        return Dadiweb_Http_Client::getInstance()->sendResponse($_response);
    }
    
/***************************************************************/
    /**
     * Get params of POST method.
     * 
     * @return array|null
     */
    public function getPost(){
        return Dadiweb_Http_Client::getInstance()->getPost();
    }
    
/***************************************************************/
    /**
     * Get params of GET method.
     * 
     * @return array|null
     */
    public function getQuery(){
        return Dadiweb_Http_Client::getInstance()->getQuery();
    }
    
/***************************************************************/
    /**
     * Get params of PUT method.
     * 
     * @return mixed
     */
    public function getPut(){
        return Dadiweb_Http_Client::getInstance()->getPut();
    }
    
/***************************************************************/
    /**
     * Get params of DELETE method.
     * 
     * @return mixed
     */
    public function getDelete(){
        return Dadiweb_Http_Client::getInstance()->getDelete();
    }
    
/***************************************************************/
    /**
     * Get params of HEAD method.
     * 
     * @return mixed
     */
    public function getHead(){
        return Dadiweb_Http_Client::getInstance()->getHead();
    }
    
/***************************************************************/
    /**
     * Get params of OPTIONS method.
     * 
     * @return mixed
     */
    public function getOptions(){
        return Dadiweb_Http_Client::getInstance()->getOptions();
    }
    
/***************************************************************/
    /**
     * Get params of PATCH method.
     * 
     * @return mixed
     */
    public function getPatch(){
        return Dadiweb_Http_Client::getInstance()->getPatch();
    }
    
/***************************************************************/
    /**
     * Get params of TRACE method.
     * 
     * @return mixed
     */
    public function getTrace(){
        return Dadiweb_Http_Client::getInstance()->getTrace();
    }
    
/***************************************************************/
    /**
     * Get params of LINK method.
     * 
     * @return mixed
     */
    public function getLink(){
        return Dadiweb_Http_Client::getInstance()->getLink();
    }
    
/***************************************************************/
    /**
     * Get params of UNLINK method.
     * 
     * @return mixed
     */
    public function getUnlink(){
        return Dadiweb_Http_Client::getInstance()->getUnlink();
    }
    
/***************************************************************/
    /**
     * Get params of CONNECT method.
     * 
     * @return mixed
     */
    public function getConnect(){
        return Dadiweb_Http_Client::getInstance()->getConnect();
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
                sprintf(
                    'The required method "%s" does not exist for %s',
                    $method,
                    get_class($this)
                )
            );
        }
    }
    
/***************************************************************/
}