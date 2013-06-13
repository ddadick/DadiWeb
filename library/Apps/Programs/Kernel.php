<?php
class Apps_Programs_Kernel extends Apps_Programs_Abstract
{
    /**
     * Rendered Object.
     *
     * @var mixed
     */
    protected $rendered=NULL;
    
    /**
     * Default set variables.
     *
     * @var array
     */
    protected $_variables = array();
    
    /**
     * Config of programm.
     *
     * @var array|stdClass
     */
    protected $config = array();
    
    /**
     * I18n of programm.
     *
     * @var array|stdClass
     */
    protected $strings = array();
    
/***************************************************************/
    /**
     * Init Programs.
     *
     * @return void
     */
    public function __construct(){
        $this->rendered=Dadiweb_Configuration_Kernel::getInstance()->getRendered();
        $this->config=Dadiweb_Aides_Array::getInstance()->arr2obj(
            Apps_Configuration_Config::getInstance()->getGeneric()
        );
        $this->strings=Apps_Configuration_Locale::getInstance();
        self::preInit();
        /**
         * Reset instances all singleton of programm
         */
        Apps_Configuration_Config::resetInstance();
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
        if($name=='table'){
            if(
                !isset($this->table) ||
                !($this->table instanceof Dadiweb_Db_Table_Database)
            ){
                $this->table=new Dadiweb_Db_Table_Database();
            }else{
                return $this->table;
            }
        }
        if($name=='request'){return Dadiweb_Aides_Request::getInstance();}
        if($name=='response'){return Dadiweb_Aides_Response::getInstance();}
        if($name=='layout'){return Dadiweb_Aides_Layout::getInstance();}
        if($name=='meta'){return Dadiweb_Widening_Layout_Meta::getInstance();}
        if (array_key_exists($name, $this->_variables)) {
            return $this->_variables[$name];
        }
        return NULL;
    }
    
/***************************************************************/
    /**
     * Default method.
     *
     * @return void
     */
    public function preInit()
    {
        if(Dadiweb_Configuration_Routes::getInstance()->getABC()){
            header("Location: http://".$_SERVER["SERVER_NAME"]);
            exit;
        }
        return;
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
        if(!method_exists($this, $method)){
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