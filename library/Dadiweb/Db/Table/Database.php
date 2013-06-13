<?php
class Dadiweb_Db_Table_Database extends Dadiweb_Db_Table_Abstract
{
    /**
     * Default set variables
     *
     * @var Object
     */
    
    protected $_variables = array();
    
    /**
     * DB class of Dadiweb_Configuration_Db_Functions
     *
     * @var array
     */
    protected $_db = NULL;
    
/***************************************************************/
    /**
     * Init method
     * 
     * @see Dadiweb_Db_Table_Abstract::initDb()
     */
    public function initDb(){

    }
    
/***************************************************************/
    /**
     *
     * Handler variables that do not exist (input)
     *
     * @return Nothing
     *
     */
    public function __set($name, $value)
    {
        $this->_variables[$name] = $value;
    }
/***************************************************************/
    /**
     *
     * Handler variables that do not exist (output)
     *
     * @return $this->_variables
     *
     */
    public function __get($name)
    {
        if (array_key_exists($name, Dadiweb_Configuration_Kernel::getInstance()->getDb())) {
            return $this->_db=Dadiweb_Aides_Array::getInstance()->arr2obj(Dadiweb_Configuration_Kernel::getInstance()->getDb())->{$name};
        }
        if (array_key_exists($name, $this->_variables)) {
            return $this->_variables[$name];
        }
        return NULL;
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
            throw Dadiweb_Db_ErrorException::showThrow(sprintf('The required method "%s" does not exist for %s', $method, get_class($this)));
        }
    }
/***************************************************************/
}