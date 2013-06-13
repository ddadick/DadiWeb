<?php
class Apps_Configuration_Locale
{
    /**
     * Singleton instance.
     * 
     * @var Apps_Configuration_Locale
     */
    protected static $_instance = null;
    
    /**
     * Default set variables.
     *
     * @var array
     */
    protected $_variables = array();
    
    /**
     * Locales of programm.
     *
     * @var null|array|stdClass
     */
    protected $_locale = NULL;
    
/***************************************************************/
    /**
     * Singleton pattern implementation makes "new" unavailable.
     *
     * @return void
     */
    protected function __construct(){
        self::setGeneric();
    }
    
/***************************************************************/
    /**
     * Singleton pattern implementation makes "clone" unavailable.
     *
     * @return void
     */
    protected function __clone(){}
    
/***************************************************************/
    /**
     * Returns an instance of Apps_Configuration_Config.
     * Singleton pattern implementation.
     * 
     * @param null|mixed $options
     * 
     * @return Apps_Configuration_Config
     */
    public static function getInstance($options=NULL)
    {
        if (null === self::$_instance) {
            self::$_instance = new self($options);
        }
        return self::$_instance;
    }
    
/***************************************************************/
    /**
     * Reset instance of Apps_Configuration_Config.
     * Singleton pattern implementation.
     *
     * @return Apps_Configuration_Config
     */
    public static function resetInstance()
    {
        return self::$_instance=NULL;
    }
    
/***************************************************************/
    /**
     * Returns i18n of programm.
     *
     * @return null|class|stdClass
     */
    public function getGeneric()
    {
        if(!is_array($this->_locale) || $this->_locale instanceof stdClass){
            self::setGeneric();
        }
        return $this->_locale;
    }
    
/***************************************************************/
    /**
     * Setup i18n of programm.
     * 
     * @param boolean $_options
     * @return void
     */
    protected function setGeneric($_options=false)
    {
        $file = (
            (
                false === $_options &&
                isset(Dadiweb_Configuration_Kernel::getInstance()->getLocale()->locale) &&
                strlen($locale_file_name=trim(Dadiweb_Configuration_Kernel::getInstance()->getLocale()->locale))
            )
            ?$locale_file_name.'.'
            .(
                (
                    isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Locales->extension) &&
                    strlen(
                        $locale_file_exe=trim(
                            strtolower(
                                Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Locales->extension
                            )
                        )
                    )
                )
                ?strtolower($locale_file_exe)
                :(
                    (
                        isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->locales_type) &&
                        strlen(
                            $locale_file_exe=trim(
                                strtolower(
                                    Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->locales_type
                                )
                            )
                        )
                    )
                    ?$locale_file_exe
                    :strtolower('xml')
                )
            )
            :(
                'en_US.'
                .(
                    (
                        isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Locales->extension) &&
                        strlen(
                            $locale_file_exe=trim(
                                strtolower(
                                    Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Locales->extension
                                )
                            )
                        )
                    )
                    ?$locale_file_exe
                    :(
                        (
                            isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->locales_type) &&
                            strlen(
                                $locale_file_exe=trim(
                                    strtolower(
                                        Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->locales_type
                                    )
                                )
                            )
                        )
                        ?$locale_file_exe
                        :strtolower('xml')
                    )
                )
            )
        );
        $type=(
            (
                isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Locales->type) &&
                strlen(
                    $type=trim(
                        strtolower(
                            Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Locales->type
                        )
                    )
                )
            )
            ?$type
            :(
                (
                    isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->locales_type) &&
                    strlen(
                        $type=trim(
                            strtolower(
                                Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->locales_type
                            )
                        )
                    )
                )
                ?$type
                :strtolower('xml')
            )
        );
        $path=(
            (
                isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Locales->path) &&
                strlen(
                    $path=trim(
                        strtolower(
                            Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Locales->path
                        )
                    )
                )
            )
            ?$path
            :(
                (
                    isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->locales_path) &&
                    strlen(
                        $path=trim(
                            strtolower(
                                Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->locales_path
                            )
                        )
                    )
                )
                ?$path
                :strtolower('/.. /resources/i18n')
            )
        );
        if(Dadiweb_Configuration_Kernel::getInstance()->getApps()->getPathCtrl()!==NULL){
            if(!is_array($this->_locale)){
                $this->_locale=array();
            }
            $path=Dadiweb_Aides_Filesystem::pathCreate(
                Dadiweb_Aides_Filesystem::pathValidator(
                    Dadiweb_Configuration_Kernel::getInstance()->getApps()->getPathCtrl().
                    $path
                )
            );
            $file=$path.$file;
            if(!is_file($file)){
                $t=new Dadiweb_Widening_Xml_Writer(
                    array(
                        'version'	=>	'1.0',
                        'encode'	=>	'UTF-8',
                        'content'	=>	array(
                            'string'=>array(
                                'generic'	=>	'Hello, DadiWeb!'
                            )
                        )
                    )
                );
                $fp=fopen($file, "w");
                fwrite($fp,$t->getResult());
                fclose($fp);
            }
            $t=new Dadiweb_Widening_Xml_Reader(array('content'=>$file));
            foreach($t->getResult() as $key=>$item){
                $this->{$key}=$item;
            }
            $this->_locale = $t->getResult();
        }
    }
    
/***************************************************************/
    /**
     * Handler variables that do not exist (input)
     * $t->getResult()
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
     * Handler variables that do not exist (output)
     * 
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        
        if (array_key_exists($name, $this->_variables)) {
            return $this->_variables[$name];
        }
        self::setGeneric(true);
        if (array_key_exists($name, $this->_variables)) {
            return $this->_variables[$name];
        }
        self::setGeneric();
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
        if(!method_exists($this, $method)){
            throw Dadiweb_Render_Exception::getInstance()
                ->getMessage(sprintf('The required method "%s" does not exist for %s', $method, get_class($this))); 
        }
    }
    
/***************************************************************/
}