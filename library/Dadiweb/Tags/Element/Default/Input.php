<?php
class Dadiweb_Tags_Element_Default_Input extends Dadiweb_Tags_Abstract
{
/***************************************************************/
    /**
     * Init class of tag.
     * 
     * @param string $_name
     * @param array $_options
     * @return void
     */
    public function __construct($_name=NULL, array $_options=NULL){
        $this->_name_tag='input';
        parent::validator($_name, $_options);
    }
    
/***************************************************************/
    /**
     * Opening tag.
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
                $value=TRUE;
                $return .= ' '.$key.'='.
                (
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
        $return .=(
            (FALSE===$value)
            ?(
                ($this->getValue()!==NULL)
                ?' value="'.$this->getValue().'"'
                :''
            )
            :''
        );
        return '<input'.$return.'>';
    }
/***************************************************************/
    /**
     * Closing tag.
     * 
     * @return string
     */
    public function close(){
        return;
    }
    
/***************************************************************/
    /**
     * Label for tag.
     * 
     * @return string
     */
    public function label(array $_options=array()){
        $label = new Dadiweb_Tags_Element_Label(
            $this->getName(),
            array('for'=>$this->{$this->getName()}->id)
        );
        return $label->open(
            array(
                'value'=>$this->{$this->getName()}->label,
                'required'=>$this->{$this->getName()}->required
            )
        );
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
            throw Dadiweb_Tags_Exception::getInstance()->getMessage(
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