<?php
class Dadiweb_Forms_Render
{
    /**
     * Singleton instance.
     * 
     * @var Dadiweb_Forms_Render
     */
    protected static $_instance = null;
    
    /**
     * Default set variables.
     *
     * @var array
     */
    protected $_variables = array();
    
/***************************************************************/
    /**
     * Singleton pattern implementation makes "new" unavailable
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
     * Returns an instance of Dadiweb_Forms_Render.
     * Singleton pattern implementation.
     *
     * @return Dadiweb_Forms_Render
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
     * Reset instance of Dadiweb_Forms_Render.
     * Singleton pattern implementation.
     *
     * @return Dadiweb_Forms_Render
     */
    public static function resetInstance()
    {
        return self::$_instance=NULL;
    }
    
/***************************************************************/
    /**
     * Handler variables that do not exist (input).
     * 
     * @param string|null $name
     * @param mixed|null $value
     * @return void
     */
    public function __set($name, $value)
    {
        $this->_variables[$name] = $value;
    }
    
/***************************************************************/
    /**
     * Handler variables that do not exist (output).
     * 
     * @param string $name
     * @return mixed|null
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->_variables)) {
            return $this->_variables[$name];
        }
        return NULL;
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
        if(!method_exists($this, $method)) { 
            throw Dadiweb_Forms_Exception::getInstance()->getMessage(
                sprintf('The required method "%s" does not exist for %s', $method, get_class($this))
            );
        }
    }
    
/***************************************************************/
}