<?php
class Dadiweb_Configuration_Kernel
{
    /**
     * Singleton instance.
     * 
     * @var null|Dadiweb_Configuration_Kernel
     */
    protected static $_instance = null;
    
    /**
     * Output buffer (current).
     *
     * @var string|null
     */
    protected $_ob_buffer = NULL;
    
    /**
     * Rendered (current).
     *
     * @var mixed
     */
    protected $_rendered = NULL;
    
    /**
     * Pattern (current).
     *
     * @var null|Dadiweb_Configuration_Pattern
     */
    protected $_pattern = NULL;
    
    /**
     * Settings (current).
     *
     * @var null|Dadiweb_Configuration_Settings
     */
    protected $_settings = NULL;
    
    /**
     * Layout (current).
     *
     * @var null|Dadiweb_Configuration_Layout
     */
    protected $_layout = NULL;
    
    /**
     * Apps (current).
     *
     * @var null|Dadiweb_Configuration_Apps
     */
    protected $_apps = NULL;
    
    /**
     * Routes (current).
     *
     * @var null|Dadiweb_Configuration_Routes
     */
    protected $_routes = NULL;
    
    /**
     * Generic path's for Apps.
     *
     * @var string|null
     */
    protected $_path = NULL;
    
    /**
     * Locale for Apps.
     *
     * @var null|stdClass
     */
    protected $_locale = NULL;
    
    /**
     * DB for Apps.
     *
     * @var null|stdClass
     */
    protected $_db = NULL;
    
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
     * Returns an instance of Dadiweb_Configuration_Kernel.
     * Singleton pattern implementation.
     *
     * @return Dadiweb_Configuration_Kernel
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
     * Build Kernel Object.
     *
     * @return void
     */
    public function buildKernel()
    {
        Dadiweb_Aides_Timescript::getInstance(TIMESCRIPT);
        self::setSettings(Dadiweb_Aides_Array::getInstance()
                ->arr2obj(Dadiweb_Configuration_Settings::getInstance()->getGeneric()));
        Dadiweb_Configuration_Session::getInstance()->getGeneric();
        self::setRoutes(Dadiweb_Configuration_Routes::getInstance());
        self::setPattern(Dadiweb_Configuration_Pattern::getInstance());
        self::setLocale(Dadiweb_Configuration_Locale::getInstance()->getLocale());
        self::setLayout(Dadiweb_Configuration_Layout::getInstance());
        Dadiweb_Configuration_Render::getInstance()->getGeneric();
        self::setApps(Dadiweb_Configuration_Apps::getInstance(self::getPattern()));
        self::setDb(Dadiweb_Configuration_Db::getInstance()->getGeneric());
        /**
         * Rendered.
         */
        Dadiweb_Aides_Response::getInstance()->setBody(
            self::getLayout()->getRendered(
                self::ob_class(
                    array(
                        self::getApps()->getPathCtrl(),
                        self::getApps()->getPathCtrl().DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR,
                    ),
                    self::getApps()->getClass(), 
                    self::getApps()->getMethod()
                )
            )
        )->sendResponse(true);
        /**
        * End of Kernel.
        */
        Dadiweb_Aides_Timescript::getInstance()->time();
    }
    
/***************************************************************/
    /**
     * Init external Class.
     * 
     * @param string|null $path
     * @param string|null $class
     * @param string|null $method
     * @return string
     */
    protected function ob_class($path=NULL,$class=NULL,$method=NULL){
        if(
            $class===NULL ||
            (
                is_string($class) &&
                !strlen(trim($class))
            )
        ){
            throw Dadiweb_Throw_ErrorException::showThrow(
                sprintf('Variable $class is empty', $class)
            );
        }
        if(
            $method===NULL ||
            (
                is_string($method) &&
                !strlen(trim($method))
            )
        ){
            throw Dadiweb_Throw_ErrorException::showThrow(
                sprintf(
                    'Variable $function is empty',
                    $method
                )
            );
        }
        $return=get_include_path();
        if(is_array($path)){
            foreach ($path as $key=>$item){
                if(
                    !is_string($item) ||
                    (
                        is_string($item) &&
                        !realpath($item)
                    )
                ){
                    throw Dadiweb_Throw_ErrorException::showThrow(
                        sprintf(
                            'Path "%s" does not exist',
                            $item
                        )
                    );
                }else{
                    $path[$key]=realpath($item);
                }
            }
            set_include_path(
                implode(PATH_SEPARATOR,
                    array_merge(
                        $path,
                        explode(PATH_SEPARATOR,
                            $return
                        )
                    )
                )
            );
        }else{
            if(
                !is_string($path) ||
                !strlen(trim($path)) ||
                (
                    is_string($path) &&
                    !realpath($path)
                )
            ){
                throw Dadiweb_Throw_ErrorException::showThrow(
                    sprintf(
                        'Path "%s" does not exist',
                        $path
                    )
                );
            }
            set_include_path(
                implode(PATH_SEPARATOR,
                    array(
                        realpath($path),
                        $return
                    )
                )
            );
        }
        $test=self::getApps()->getDefaultClass();
        $test=new $test;
        $test_method=self::getApps()->getMethodDefault();
        if(!method_exists($test, $test_method)){
            $test->$test_method();
        }
        unset($test);
        unset($test_method);
        $class=new $class;
        if(method_exists($class, self::getApps()->getMethodDefault())){
            $class->preInit();
            $class->$method();
        }else{
            $method=self::getApps()->getMethodDefault();
            $class->$method();
        }
        set_include_path(
            implode(PATH_SEPARATOR,
                array(
                    $return
                )
            )
        );
        return;
    }
    
/***************************************************************/
    /**
     * Set Rendered.
     * 
     * @param mixed $options
     * @return void
     */
    public function setRendered($options=NULL)
    {
        if($options===NULL){
            throw Dadiweb_Throw_ErrorException::showThrow(
                'Critical error. Rendered undefined.'
            );
        }
        $this->_rendered=$options;
    }
    
/***************************************************************/
    /**
     * Get Rendered.
     *
     * @return void
     */
    public function getRendered()
    {
        if($this->_rendered===NULL){
            throw Dadiweb_Throw_ErrorException::showThrow(
                'Critical error. Rendered undefined.'
            );
        }
        return $this->_rendered;
    }
/***************************************************************/
    /**
     * Set Settings.
     * 
     * @param stdClass|null $options
     * @return void
     */
    protected function setSettings($options=NULL)
    {
        if($options===NULL){
            throw Dadiweb_Throw_ErrorException::showThrow(
                'Critical error. Settings undefined.'
            );
        }
        $this->_settings=$options;
    }
    
/***************************************************************/
    /**
     * Get Settings.
     *
     * @return stdClass|mixed
     */
    public function getSettings()
    {
        if($this->_settings===NULL){
            throw Dadiweb_Throw_ErrorException::showThrow(
                'Critical error. Settings undefined.
            ');
        }
        return $this->_settings;
    }
    
/***************************************************************/
    /**
     * Set Pattern.
     * 
     * @param null|Dadiweb_Configuration_Pattern $options
     * @return void
     */
    protected function setPattern($options=NULL)
    {
        if($options===NULL){
            throw Dadiweb_Throw_ErrorException::showThrow(
                'Critical error. Pattern undefined.'
            );
        }
        $this->_pattern=$options;
    }
    
/***************************************************************/
    /**
     * Get Pattern.
     *
     * @return null|Dadiweb_Configuration_Pattern
     */
    public function getPattern()
    {
        if($this->_pattern===NULL){
            throw Dadiweb_Throw_ErrorException::showThrow(
                'Critical error. Pattern undefined.
            ');
        }
        return $this->_pattern;
    }
    
/***************************************************************/
    /**
     * Set Layout.
     * 
     * @param null|Dadiweb_Configuration_Layout $options
     * @return void
     */
    protected function setLayout($options=NULL)
    {
        if($options===NULL){
            throw Dadiweb_Throw_ErrorException::showThrow(
                'Critical error. Layout undefined.
            ');
        }
        $this->_layout=$options;
    }
    
/***************************************************************/
    /**
     * Get Layout.
     *
     * @return null|Dadiweb_Configuration_Layout
     */
    public function getLayout()
    {
        if($this->_layout===NULL){
            throw Dadiweb_Throw_ErrorException::showThrow(
                'Critical error. Layout undefined.'
            );
        }
        return $this->_layout;
    }
    
/***************************************************************/
    /**
     * Set Apps.
     * 
     * @param null|Dadiweb_Configuration_Apps $options
     * @return void
     */
    protected function setApps($options=NULL)
    {
        if($options===NULL){
            throw Dadiweb_Throw_ErrorException::showThrow(
                'Critical error. Apps undefined.'
            );
        }
        $this->_apps=$options;
    }
    
/***************************************************************/
    /**
     * Get Apps.
     *
     * @return null|Dadiweb_Configuration_Apps
     */
    public function getApps()
    {
        if($this->_apps===NULL){
            throw Dadiweb_Throw_ErrorException::showThrow(
                'Critical error. Apps undefined.'
            );
        }
        return $this->_apps;
    }
    
/***************************************************************/
    /**
     * Set Routes.
     * 
     * @param null|Dadiweb_Configuration_Routes $options
     * @return void
     */
    protected function setRoutes($options=NULL)
    {
        if($options===NULL){
            throw Dadiweb_Throw_ErrorException::showThrow(
                'Critical error. Routes undefined.'
            );
        }
        $this->_routes=$options;
    }
    
/***************************************************************/
    /**
     * Get Routes.
     *
     * @return null|Dadiweb_Configuration_Routes $options
     */
    public function getRoutes()
    {
        if($this->_routes===NULL){
            throw Dadiweb_Throw_ErrorException::showThrow(
                'Critical error. Routes undefined.'
            );
        }
        return $this->_routes;
    }
    
/***************************************************************/
    /**
     * Set path's applications.
     *
     * @param string $path
     * @return string
     */
    protected function setPath($path=NULL)
    {
        return $this->_path=$path;
    }
    
/***************************************************************/
    /**
     * Get path's applications.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->_path;
    }
    
/***************************************************************/
    /**
     * Set locale for apps.
     * 
     * @param null|stdClass $_locale
     * @return null|stdClass
     */
    protected function setLocale($_locale=NULL)
    {
        return $this->_locale=$_locale;
    }
    
/***************************************************************/
    /**
     * Get locale for apps.
     *
     * @return stdClass
     */
    public function getLocale()
    {
        return $this->_locale;
    }
    
/***************************************************************/
    /**
     * Set DB for apps.
     *
     * @param null|stdClass
     * @return null|stdClass
     */
    protected function setDb($_db=NULL)
    {
        return $this->_db=$_db;
    }
    
/***************************************************************/
    /**
     * Get DB for apps.
     *
     * @return null|stdClass
     */
    public function getDb()
    {
        return $this->_db;
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
             throw Dadiweb_Configuration_Exception::getInstance()->getMessage(
                 sprintf(
                     'The required method "%s" does not exist for %s',
                     $method, get_class($this)
                 )
             );
        }
    }
    
/***************************************************************/
}