<?php
class Dadiweb_Db_Result
{
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
        $this->{$name} = $value;
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
        if (isset($this->{$name})) {
            return $this->{$name};
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