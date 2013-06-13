<?php
class Dadiweb_Aides_Timescript
{
    /**
     * Singleton instance.
     * 
     * @var Dadiweb_Aides_Timescript
     */
    protected static $_instance = null;
    
    /**
     * Current time
     *
     * @var float
     */
    protected $_time = null;
    
/***************************************************************/
    /**
     * Singleton pattern implementation makes "new" unavailable.
     * 
     * @param float|null $_time
     * @return void
     */
    protected function __construct($_time=NULL){
        $this->start($_time);
    }
    
/***************************************************************/
    /**
     * Singleton pattern implementation makes "clone" unavailable.
     *
     * @return void
     */
    protected function __clone(){}
    
/***************************************************************/
    /**
     * Returns an instance of Dadiweb_Aides_Timescript.
     * Singleton pattern implementation.
     * 
     * @param float|null $_time
     * @return Dadiweb_Aides_Timescript
     */
    public static function getInstance($_time=NULL)
    {
        if (null === self::$_instance) {
            self::$_instance = new self($_time);
        }
        return self::$_instance;
    }
    
/***************************************************************/
    /**
     * Reset instance of Dadiweb_Aides_Timescript.
     * Singleton pattern implementation.
     * 
     * @return null
     */
    public static function resetInstance()
    {
        return self::$_instance=NULL;
    }
    
/***************************************************************/
    /**
     * Returns execution time.
     * 
     * @return float
     */
    public function time()
    {
        return microtime(true) - $this->_time;
    }
    
/***************************************************************/
    /**
     * Bootstrap execution time
     * 
     * @param float|null $_time
     * @return void
     */
    protected function start($_time=NULL)
    {
        $this->_time = ($_time==NULL)?microtime(true):$_time;
    }
    
/***************************************************************/
    /**
     * The handler functions that do not exist
     * 
     * @param string $method
     * @param mixed $args
     * @return void
     */
    public function __call($method, $args) 
    {
        if(!method_exists($this, $method)) { 
            throw Dadiweb_Aides_Exception::getInstance()
                ->getMessage(sprintf('The required method "%s" does not exist for %s', $method, get_class($this))); 
        }
    }
    
/***************************************************************/
}