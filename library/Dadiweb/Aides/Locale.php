<?php
class Dadiweb_Aides_Locale
{
    /**
     * Singleton instance.
     * 
     * @var Dadiweb_Aides_Locale
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
     * Returns an instance of Dadiweb_Aides_Locale.
     * Singleton pattern implementation.
     *
     * @return Dadiweb_Aides_Locale
     */
    public static function getInstance()
    {
        if(null === self::$_instance){
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
/***************************************************************/
    /**
     * Get locale
     * 
     * @return stdClass
     */
    public function getLocale(){
        return Dadiweb_Configuration_Kernel::getInstance()->getLocale();
    }
    
/***************************************************************/
    /**
     * Get default locale
     * 
     * @return stdClass
     */
    public function getDefaultLocale(){
        return Dadiweb_Configuration_Locale::getInstance()->getSelectLocale('en-US');
    }
    
/***************************************************************/
    /**
     * Get charset of locale
     * 
     * @return string
     */
    public function getCharset(){
        return Dadiweb_Configuration_Locale::getInstance()->getCharsetLocale();
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
            throw Dadiweb_Aides_Exception::getInstance()->getMessage(
                sprintf('The required method "%s" does not exist for %s', $method, get_class($this))
            ); 
        }
    }
    
/***************************************************************/
}