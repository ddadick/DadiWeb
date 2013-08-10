<?php
class Dadiweb_Widening_Layout_Meta
{
    /**
     * Singleton instance.
     * 
     * @var Dadiweb_Widening_Layout_Meta
     */
    protected static $_instance = null;
    
    /**
     * Default set variables
     *
     * @var array
     */
    protected $_variables = array();
    
    /**
     * Title of html
     *
     * @var null|string
     */
    protected $_title = NULL;
    
    /**
     * Description of html
     *
     * @var null|string
    */
    protected $_description = NULL;
    
    /**
     * Keywords of html
     *
     * @var null|string
     */
    protected $_keywords = NULL;
    
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
     * Returns an instance of Dadiweb_Widening_Layout_Meta.
     * Singleton pattern implementation.
     *
     * @return Dadiweb_Widening_Layout_Meta
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
     * Reset instance of Dadiweb_Widening_Layout_Meta.
     * Singleton pattern implementation.
     *
     * @return Dadiweb_Widening_Layout_Meta
     */
    public static function resetInstance()
    {
        return self::$_instance=NULL;
    }
    
/***************************************************************/
    /**
     * Title of html content.
     * 
     * @param string|null $_options
     * @return string
     */
    public function title($_options=NULL)
    {
        if($_options!==NULL && is_string($_options) && strlen(trim($_options))){
            $this->_title=$_options;
        }
        return '<title>'.(
                    (isset($this->_title))
                    ?$this->_title
                    :(
                        Dadiweb_Configuration_Kernel::getInstance()->getApps()->getClass().'::'.
                        Dadiweb_Configuration_Kernel::getInstance()->getApps()->getMethod()
                    )
                ).'</title>';
    }
    
/***************************************************************/
    /**
     * Keywords of html content.
     * 
     * @param string|null $_options
     * @return string
     */
    public function keywords($_options=NULL)
    {
        if($_options!==NULL && is_string($_options) && strlen(trim($_options))){
            $this->_keywords=self::content('keywords',$_options);
        }
        return (
            (
                isset($this->_keywords) &&
                is_string($this->_keywords) &&
                strlen(trim($this->_keywords))
            )
            ?$this->_keywords
            :''
        );
    }
    
/***************************************************************/
    /**
     * Description of html content.
     * 
     * @param string|null $_options
     * @return string
     */
    public function description($_options=NULL)
    {
        if($_options!==NULL && is_string($_options) && strlen(trim($_options))){
            $this->_description=self::content('description',$_options);
        }
        return (
            (
                isset($this->_description) &&
                is_string($this->_description) &&
                strlen(trim($this->_description))
            )
            ?$this->_description
            :''
        );
    }
    
/***************************************************************/
    /**
     * Http content of html.
     * 
     * @param string|null $_name
     * @param string|null $_content
     * @return string
     */
    public function content($_name=NULL, $_content=NULL)
    {
        return (
            (
                $_name!==NULL && is_string($_name) && strlen(trim($_name)) &&
                $_content!==NULL && is_string($_content) && strlen(trim($_content))
            )
            ?(
                '<meta'.
                ' name="'.$_name.'"'.
                ' content="'.$_content.'"'.
                '>'
            )
            :''
        );
    }
    
/***************************************************************/
    /**
     * Http-equiv of html content.
     * 
     * @param string|null $_equiv
     * @param string|null $_content
     * @return string
     */
    public function equiv($_equiv=NULL, $_content=NULL)
    {
        return (
            (
                $_equiv!==NULL && is_string($_equiv) && strlen(trim($_equiv)) &&
                $_content!==NULL && is_string($_content) && strlen(trim($_content))
            )
            ?(
                '<meta'.
                ' http-equiv="'.$_equiv.'"'.
                ' content="'.$_content.'"'.
                '>'
            )
            :''
        );
    }
    
/***************************************************************/
    /**
     * Charset of html content.
     * 
     * @return string
     */
    public function charset()
    {
        return '<meta charset="'.
                Dadiweb_Aides_Locale::getInstance()->getCharset().
                '">';
    }
    
/***************************************************************/
    /**
     * Generic meta tags.
     * 
     * @return string
     */
    public function generic()
    {
        $return = '';
        $array=array();
        $array[]=self::charset();
        $array[]=self::content('generator','DadiWeb');
        $array[]=self::description();
        $array[]=self::title();
        $array[]=self::keywords();
        foreach($array as $item){
            $return .=(
                (
                    NULL!==$item &&
                    is_string($item) &&
                    strlen(trim($item))
                )
                ?$item.PHP_EOL
                :''
            );
        }
        return $return;
    }
    
/***************************************************************/
    /**
     * Handler variables that do not exist (input).
     * 
     * @param string $name
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
                sprintf('The required method "%s" does not exist for %s', $method, get_class($this))
            );
        }
    }
    
/***************************************************************/
}