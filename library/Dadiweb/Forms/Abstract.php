<?php
abstract class Dadiweb_Forms_Abstract extends Dadiweb_Forms_Functions
{
    /**
     * Default set variables.
     *
     * @var array
     */
    
    protected $_variables = array();
    
/***************************************************************/
    /**
     * Declare the required method.
     */
    abstract public function init();
    
/***************************************************************/
    /**
     * Init Forms.
     *
     * @return void
     */
    public function __construct(array $options=array()){
        foreach($options as $key=>$items){
            $this->{$key}=$items;
        }
        $class=get_class($this);
        $form= explode('_',strtolower($class));
        $this->setFormName($form[count($form)-1]);
        $class::init();
        Dadiweb_Forms_Render::getInstance()->{$form[count($form)-1]}=$this;
    }
    
/***************************************************************/
    /**
     * Handler variables that do not exist (input).
     * 
     * @param string $name
     * @param mixed $value
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
     * @return mixed
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
            throw Dadiweb_Throw_ErrorException::showThrow(
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