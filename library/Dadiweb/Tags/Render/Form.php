<?php
class Dadiweb_Tags_Render_Form extends Dadiweb_Tags_Abstract
{
    /**
     * Default parameter 'name' for form
     *
     * @var string
     */
    CONST NAME_DEFAULT = 'name_default';
    
    /**
     * Default parameter 'action' for form
     *
     * @var string
     */
    CONST ACTION_DEFAULT = '/';
    
    /**
     * Default parameter 'enctype' for form
     *
     * @var string
     */
    CONST ENCTYPE_DEFAULT = 'application/x-www-form-urlencoded';
    
    /**
     * Default parameter 'method' for form
     *
     * @var string
     */
    CONST METHOD_DEFAULT = 'post';
/***************************************************************/
    /**
     * Opening tag for form
     * 
     * @param array $_options
     * @return string
     */
    public function open(array $_options=array()){
        $_options=(isset($_options) && $_options!==NULL)?Dadiweb_Aides_Array::getInstance()->arr2obj($_options,0):(new stdClass());
        $name=(isset($_options->name))?$_options->name:(self::NAME_DEFAULT);
        $id=(isset($_options->id))?$_options->id:$name.'_form';
        $class=(isset($_options->class))?$_options->class:$name.'_form';
        $action=(isset($_options->action))?$_options->action:(self::ACTION_DEFAULT);
        $method=(isset($_options->method))?$_options->method:(self::METHOD_DEFAULT);
        $enctype=(isset($_options->enctype))?$_options->enctype:(self::ENCTYPE_DEFAULT);
        return '<form '.
                ((isset($id))?' id="'.$id.'"':'').
                ((isset($class))?' class="'.$class.'"':'').
                ((isset($name))?' name="'.$name.'"':'').
                ((isset($action))?' action="'.$action.'"':'').
                ((isset($method))?' method="'.$method.'"':'').
                ((isset($enctype))?' enctype="'.$enctype.'"':'').
                '/>';
    }
/***************************************************************/
    /**
     * Closing tag for form
     * 
     * @return string
     */
    public function close(){
        return '</form>';
    }
    
/***************************************************************/
    /**
     * Label of tag
     * 
     * @return void
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