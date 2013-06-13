<?php
class Dadiweb_Tags_Element_Label extends Dadiweb_Tags_Abstract
{
    
    /**
     * List of default valid parameters for tag
     *
     * @var array
     */
    protected $_valid_params = array(
        'for', 'value'
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
        $this->_name_tag='label';
        parent::validator($_name, $_options);
    }
    
/***************************************************************/
    /**
     * Opening tag
     * 
     * @param array $_options
     * @return string
     */
    public function open(array $_options=array()){
        $return='';
        foreach($_options as $key=>$item){
            if($key!='value' && $key!='name'  && $key!='required'){
                $return .= ' '.$key.'="'.$item.'"';
            }
        }
        foreach($this->{$this->getName()} as $key=>$item){
            if($key!='value' && $key!='required'){
                $return .= ' '.$key.'="'.$item.'"';
            }
        }
        return '<label'.$return.'>'.
            (
                (isset($_options['value']))
                ?$_options['value']
                :(
                    (isset($this->{$this->getName()}->value))
                    ?$this->{$this->getName()}->value
                    :''
                )
            ).$this->close();
    }
/***************************************************************/
    /**
     * Closing tag
     * 
     * @return string
     */
    public function close(){
        return '</label>';
    }
    
/***************************************************************/
    /**
     * Label for tag
     * 
     * @return string
     */
    public function label(){
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
            throw Dadiweb_Tags_Exception::getInstance()->getMessage(
                sprintf('The required method "%s" does not exist for %s', $method, get_class($this))
            ); 
        }
    }
/***************************************************************/
}