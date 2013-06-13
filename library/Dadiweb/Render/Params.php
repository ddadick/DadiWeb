<?php
class Dadiweb_Render_Params
{
    /**
     * Singleton instance.
     * 
     * @var Dadiweb_Render_Params
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
     * Singleton pattern implementation makes "new" unavailable.
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
     * Returns an instance of Dadiweb_Render_Params.
     * Singleton pattern implementation.
     *
     * @return Dadiweb_Render_Params
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
     * Reset instance of Dadiweb_Render_Params.
     * Singleton pattern implementation.
     *
     * @return Dadiweb_Render_Params
     */
    public static function resetInstance()
    {
        return self::$_instance=NULL;
    }
    
/***************************************************************/
    /**
     * Handler variables that do not exist (input).
     * 
     * @param string|null $_options
     * @return mixed
     */
    public function forms($_options=NULL)
    {
        if(
            $_options!==NULL &&
            is_string($_options) &&
            strlen(trim($_options)) &&
            NULL!==Dadiweb_Forms_Render::getInstance()->{$_options}
        ){
            return Dadiweb_Forms_Render::getInstance()->{$_options};
        }
        return NULL;
    }
    
/***************************************************************/
    /**
     * Handler variables that do not exist (input).
     * 
     * @param string|null $_options
     * @return mixed
     */
    public function render($_options=NULL)
    {
        $content = NULL;
        if(
            $_options!==NULL &&
            is_string($_options) &&
            strlen(trim($_options))
        ){
            ob_start();
            Dadiweb_Render_Controller::getInstance(
                array(
                    'uri'=>Dadiweb_Aides_Html::getInstance()->validatorUrl($_options,false)
                )
            );
            $content = ob_get_contents();
            ob_end_clean();
            Dadiweb_Render_Controller::resetInstance();
        }
        return $content;
    }
    
/***************************************************************/
    /**
     * Handler variables that do not exist (input).
     * 
     * @param string $namen
     * @param mixed $value
     * @return mixed
     *
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
        if($name=='html'){$this->{$name} = new Dadiweb_Widening_Layout_Html();}
        if($name=='baseUrl'){$this->{$name} = Dadiweb_Aides_Html::getInstance()->getBaseUrl();}
        if($name=='designUrl'){$this->{$name} = Dadiweb_Aides_Html::getInstance()->getDesignUrl();}
        if($name=='dataUrl'){$this->{$name} = Dadiweb_Aides_Html::getInstance()->getDataPath();}
        if($name=='routes'){$this->{$name} = Dadiweb_Configuration_Routes::getInstance()->searchRoutes();}
        if (array_key_exists($name, $this->_variables)){
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
            throw Dadiweb_Render_Exception::getInstance()->getMessage(
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