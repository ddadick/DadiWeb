<?php
class Dadiweb_Tags_Element_Submit extends Dadiweb_Tags_Element_Default_Input
{
    /**
     * List of default valid parameters for tag
     *
     * @var array
     */
    protected $_valid_params = array(
        'disabled', 'name', 'type', 'value',
    );
    
/***************************************************************/
    /**
     * Init class of tag
     * 
     * @param string $_name
     * @param array $_options
     * @return void
     */
    public function __construct($_name=NULL, array $_options=array()){
        if($_name===NULL || !is_string($_name) || (is_string($_name) && !strlen(trim($_name)))){
            throw Dadiweb_Throw_ErrorException::showThrow(
                sprintf('Parameter "Name" was not transmitted into class "%s"', get_class($this))
            );
        }
        $_options['type']='submit';
        parent::__construct($_name, $_options);
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
            throw Dadiweb_Tags_Exception::getInstance()->getMessage(
                sprintf('The required method "%s" does not exist for %s', $method, get_class($this))
            ); 
        }
    }
/***************************************************************/
}