<?php
class Dadiweb_Tags_Element_Textarea extends Dadiweb_Tags_Abstract
{
    
    /**
     * List of default valid parameters for tag
     *
     * @var array
     */
    protected $_valid_params = array(
        'autofocus', 'cols', 'disabled', 'form', 'maxlength',
        'placeholder', 'readonly', 'required', 'rows', 'wrap', 'value',
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
        $this->_name_tag='textarea';
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
        if(isset($_options['name'])){
            $return .= ' name="'.$_options['name'].'['.$this->getName().']"';
        }
        $value=FALSE;
        foreach($this->{$this->getName()} as $key=>$item){
            if($key!='required' && $key!='label'){
                $return .= ' '.$key.'="'.$item.'"';
            }elseif($key=='required' && $item===true){
                $return .= ' '.$key;
            }elseif($key=='value'){
                $value = (
                    ($this->getValue()!==NULL)
                    ?$this->getValue()
                    :(
                        ($item!==NULL)
                        ?$item
                        :''
                     )
                );
            }
        }
        $value =(
            (FALSE===$value)
            ?(
                ($this->getValue()!==NULL)
                ?$this->getValue()
                :''
            )
            :''
        );
        return (
            '<textarea'.$return.'>'.
            $value.
            self::close()
        );
    }
/***************************************************************/
    /**
     * Closing tag
     * 
     * @return string
     */
    public function close(){
        return '</textarea>';
    }
    
/***************************************************************/
    /**
     * Label for tag
     * 
     * @return string
     */
    public function label(){
        $label = new Dadiweb_Tags_Element_Label($this->getName(),array('for'=>$this->{$this->getName()}->id));
        return $label->open(array('value'=>$this->{$this->getName()}->label,'required'=>$this->{$this->getName()}->required));
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