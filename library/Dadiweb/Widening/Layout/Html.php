<?php 
class Dadiweb_Widening_Layout_Html
{
    /**
     * The encoding of the HTML document.
     *
     * @var string
     */
    protected $_encode = 'UTF-8';
    
    /**
     * Default set variables.
     *
     * @var array
     */
    protected $_variables = array();
    
/***************************************************************/
    /**
     * Init method.
     *
     * @return void
     */
    public function __construct($option=array()){
        $option=Dadiweb_Aides_Array::getInstance()->array_AllKeysToLowerCase($option);
    }
    
/***************************************************************/
    /**
     * Returns CSS file.
     *
     * @param array $_option
     * @return string
     */
    public function getCSS(array $_option=array())
    {
        $url=Dadiweb_Aides_Html::getInstance()->getDesignUrl();
        $return='';
        $_option=Dadiweb_Aides_Array::getInstance()->array_AllKeysToLowerCase($_option);
        foreach($_option as $item){
            $return .=(
                is_string($item) && strlen(trim($item))
            )
            ?'<link rel="stylesheet" href="'.$url.$item.'">'.PHP_EOL
            :'';
        }
        return $return;
    }
    
/***************************************************************/
    /**
     * Returns CSS file with conditions.
     * 
     * @param string|null $_conditions
     * @param array $_option
     * @return string
     */
    public function getConditionsCSS($_conditions=NULL, array $_option=array())
    {
        if(
            $_conditions===NULL ||
            !is_string($_conditions) ||
            (is_string($_conditions) && !strlen(trim($_conditions)))
        ){
            return '';
        }
        $url=Dadiweb_Aides_Html::getInstance()->getDesignUrl();
        $return='';
        $_option=Dadiweb_Aides_Array::getInstance()->array_AllKeysToLowerCase($_option);
        foreach($_option as $item){
            $return .=(
                is_string($item) && strlen(trim($item))
            )
            ?'<!--[if '.$_conditions.']><link rel="stylesheet" href="'.$url.$item.'"><![endif]-->'.PHP_EOL
            :'';
        }
        return $return;
    }
    
/***************************************************************/
    /**
     * Returns Javascript file.
     *
     * @param array $_option
     * @return string
     */
    public function getJS(array $_option=array())
    {
        $url=Dadiweb_Aides_Html::getInstance()->getDesignUrl();
        $return='';
        $_option=Dadiweb_Aides_Array::getInstance()->array_AllKeysToLowerCase($_option);
        foreach($_option as $item){
            $return .=(
                is_string($item) && strlen(trim($item))
            )
            ?'<script type="text/javascript" src="'.$url.$item.'"></script>'.PHP_EOL
            :'';
        }
        return $return;
    }
    
/***************************************************************/
    /**
     * Returns Javascript file with conditions.
     *
     * @param string|null $_conditions
     * @param array $_option
     * @return string
     */
    public function getConditionsJS($_conditions=NULL,array $_option=array())
    {
        if(
            $_conditions===NULL ||
            !is_string($_conditions) ||
            (is_string($_conditions) && !strlen(trim($_conditions)))
        ){
            return '';
        }
        $url=Dadiweb_Aides_Html::getInstance()->getDesignUrl();
        $return='';
        $_option=Dadiweb_Aides_Array::getInstance()->array_AllKeysToLowerCase($_option);
        foreach($_option as $item){
            $return .=(
                is_string($item) && strlen(trim($item))
            )
            ?'<!--[if '.$_conditions.']><script type="text/javascript" src="'.$url.$item.'"></script><![endif]-->'.PHP_EOL
            :'';
        }
        return $return;
    }
    
/***************************************************************/
    /**
     * Get script from path of app
     * 
     * @return string
     */
    public function getActionJS(){
        $path = Dadiweb_Aides_Filesystem::pathValidator(
            Dadiweb_Configuration_Kernel::getInstance()->getApps()->getPath().DIRECTORY_SEPARATOR.
            Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Html->path.DIRECTORY_SEPARATOR.
            Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Html->js->app->path.DIRECTORY_SEPARATOR
        );
        return (
                    NULL!==($filename=Dadiweb_Aides_Html::getInstance()->getSearchFile($path,'js'))
               )
               ?(
                   '<script type="text/javascript" src="'.
                   Dadiweb_Aides_Html::getInstance()->getUrlPath($path).$filename.
                   '"></script>'.PHP_EOL
               )
               :'';
    }
    
/***************************************************************/
    /**
     * Get css from path of app
     * 
     * @return string
     */
    public function getActionCSS(){
        $path = Dadiweb_Aides_Filesystem::pathValidator(
            Dadiweb_Configuration_Kernel::getInstance()->getApps()->getPath().DIRECTORY_SEPARATOR.
            Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Html->path.DIRECTORY_SEPARATOR.
            Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Html->css->app->path.DIRECTORY_SEPARATOR
        );
        return (
                    NULL!==($filename=Dadiweb_Aides_Html::getInstance()->getSearchFile($path,'css'))
               )
               ?(
                   '<link rel="stylesheet" href="'.
                   Dadiweb_Aides_Html::getInstance()->getUrlPath($path).$filename.
                   '">'.PHP_EOL
               )
               :'';
    }
    
/***************************************************************/
    /**
     * Get locale
     * 
     * @return stdClass
     */
    public function getLocale(){
        return Dadiweb_Configuration_Kernel::getInstance()->getLocale();
    }
    
/***************************************************************/
    /**
     * Get default locale
     * 
     * @return stdClass
     */
    public function getDefaultLocale(){
        return Dadiweb_Configuration_Locale::getInstance()->getSelectLocale('en-US');
    }
    
/***************************************************************/
    /**
     * Handler variables that do not exist (input).
     * 
     * @param string $name
     * @param mixed $value
     * @return mixed
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
        if($name=='meta'){$this->{$name} = Dadiweb_Widening_Layout_Meta::getInstance();}
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
            throw Dadiweb_Throw_ErrorException::showThrow(
                sprintf('The required method "%s" does not exist for %s', $method, get_class($this))
            ); 
        }
    }
    
/***************************************************************/
}