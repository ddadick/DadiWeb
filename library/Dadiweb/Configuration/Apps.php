<?php
class Dadiweb_Configuration_Apps
{
    /**
     * Singleton instance.
     * 
     * @var null|Dadiweb_Configuration_Apps
     */
    protected static $_instance = null;
    
    /**
     * Current program.
     * 
     * @var string|null
     */
    protected $_prog = NULL;
    
    /**
     * Current contoller.
     * 
     * @var string|null
     */
    protected $_ctrl = NULL;
    
    /**
     * Default contoller.
     * 
     * @var string|null
     */
    protected $_ctrl_default = NULL;
    
    /**
     * Current method.
     * 
     * @var string|null
     */
    protected $_method = NULL;
    
    /**
     * Default method.
     * 
     * @var string|null
     */
    protected $_method_default = NULL;
    
    /**
     * Path's controller (current).
     * 
     * @var string|null
     */
    protected $_path_ctrl = NULL;
    
    /**
     * File's controller (current).
     * 
     * @var string|null
     */
    protected $_file_ctrl = NULL;
    
    /**
     * External class (current).
     * 
     * @var string|null
     */
    protected $_class = NULL;
    
    /**
     * External class (default).
     * 
     * @var string|null
     */
    protected $_class_default = NULL;
    
    /**
     * Generic path for Application.
     *
     * @var string|null
     */
    protected $_path = NULL;
    
    /**
     * Name program for Layout.
     *
     * @var string|null
     */
    protected $_layout_program = NULL;
    
    /**
     * Name controller for Layout.
     *
     * @var string|null
     */
    protected $_layout_controller = NULL;
    
    /**
     * Name default controller for Layout.
     *
     * @var string|null
     */
    protected $_layout_default_controller = NULL;
    
    /**
     * Name method for Layout.
     *
     * @var string|null
     */
    protected $_layout_method = NULL;
    
    /**
     * Name default method for Layout.
     *
     * @var string|null
     */
    protected $_layout_default_method = NULL;
    
/***************************************************************/
	/**
     * Singleton pattern implementation makes "new" unavailable
     * 
     * @param Dadiweb_Configuration_Pattern $pattern
     * @return void
     */
    protected function __construct(Dadiweb_Configuration_Pattern $pattern){
        self::setGeneric($pattern);
    }
    
/***************************************************************/
    /**
     * Singleton pattern implementation makes "clone" unavailable
     *
     * @return void
     */
    protected function __clone(){}
    
/***************************************************************/
    /**
     * Returns an instance of Dadiweb_Configuration_Apps
     * Singleton pattern implementation
     * 
     * @param Dadiweb_Configuration_Pattern $pattern
     * @return Dadiweb_Configuration_Apps Provides a fluent interface
     */
    public static function getInstance(Dadiweb_Configuration_Pattern $pattern)
    {
        if (null === self::$_instance) {
            self::$_instance = new self($pattern);
        }
        return self::$_instance;
    }
    
/***************************************************************/
    /**
     * Setup Configuration Apps
     * 
     * @param Dadiweb_Configuration_Pattern $pattern
     * @param boolean $render
     * @return Application
     */
    public function setGeneric(Dadiweb_Configuration_Pattern $pattern, $render=false)
    {
        if($render!==false && $render!==true){$render=true;}
        /**
         *  Set program of apps
         */
        if(NULL!==$pattern->getModel()){
            self::setProgram(strtolower($pattern->getModel()));
        }
        if(NULL===self::getProgram()){
            if(
                !isset(
                    Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                        ->apps->Master->prog
                ) || 
                !strlen(
                    trim(
                        self::setProgram(
                            strtolower(
                                Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                    ->apps->Master->prog
                            )
                        )
                    )
                )
            ){
                throw Dadiweb_Throw_ErrorException::showThrow(
                    sprintf(
                        'Value into "apps.Master.prog" in the file "%sapps.ini" is not valid or empty',
                        INI_PATH
                    )
                );
            }
        }
        self::setLayoutProgram(self::getProgram());
        /**
         * Set controller of apps.
         */
        if(NULL!==$pattern->getModel()){
            self::setDefaultController(
                strtolower(
                    (
                        isset(
                            Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                ->generic->App->ctrl_default
                        )
                    )
                    ?Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                        ->generic->App->ctrl_default
                    :'index'
                )
            );
        }else{
            if(
                isset(
                    Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                        ->apps->Master->ctrl
                )
            ){
                self::setDefaultController(
                    strtolower(
                        Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                            ->apps->Master->ctrl
                    )
                );
            }else{
                throw Dadiweb_Throw_ErrorException::showThrow(
                    sprintf(
                        'Value into "apps.Master.ctrl" in the file "%sapps.ini" is not valid or empty',
                        INI_PATH
                    )
                );
            }
        }
        if(NULL!==$pattern->getController()){
            self::setController(strtolower($pattern->getController()));
        }else{
            self::setController(self::getDefaultController());
        }
        self::setLayoutDefaultController(self::getDefaultController());
        self::setLayoutController(self::getController());
        /**
         * Set method of apps.
         */
        if(NULL!==$pattern->getView() || $render===true){
            self::setMethod(
                ucfirst(self::setLayoutMethod(strtolower($pattern->getView()))).
                (
                ($render===false)
                    ?(
                        (
                            isset(
                                Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                    ->generic->App->method
                            )
                        )
                        ?(
                            (
                                strlen(
                                    trim(
                                        self::setMethod(
                                            strtolower(
                                                Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                                    ->generic->App->method
                                            )
                                        )
                                    )
                                )
                            )
                            ?ucfirst(self::getMethod())
                            :'Method'
                        )
                        :'Method'
                    )
                    :(
                        (
                            isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                    ->generic->App->method_render
                            )
                        )
                        ?(
                            (
                                strlen(
                                    trim(
                                        self::setMethod(
                                            strtolower(
                                                Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                                    ->generic->App->method_render
                                            )
                                        )
                                    )
                               )
                            )
                            ?ucfirst(self::getMethod())
                            :'Render'
                        )
                        :'Render'
                    )
                )
            );
        }else{
            if(NULL!==$pattern->getModel() || $render===true){
                self::setMethod(
                    ucfirst(self::setLayoutMethod(strtolower('Index'))).
                    (
                        ($render===false)
                        ?(
                            (
                                isset(
                                    Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                        ->generic->App->method
                                )
                            )
                            ?(
                                (
                                    strlen(
                                        trim(
                                            self::setMethod(
                                                strtolower(
                                                    Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                                        ->generic->App->method
                                                )
                                            )
                                        )
                                    )
                                )
                                ?ucfirst(self::getMethod())
                                :'Method'
                            )
                            :'Method'
                        )
                        :(
                            (
                                isset(
                                    Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                        ->generic->App->method_render
                                )
                            )
                            ?(
                                (
                                    strlen(
                                        trim(
                                            self::setMethod(
                                                strtolower(
                                                    Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                                        ->generic->App->method_render
                                                )
                                            )
                                         )
                                    )
                                )
                                ?ucfirst(self::getMethod())
                                :'Render'
                            )
                            :'Render'
                        )
                    )
                );
            }else{
                self::setMethod(
                    ucfirst(
                        self::setLayoutMethod(
                            strtolower(
                                Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                    ->apps->Master->method
                            )
                        )
                    ).
                    (
                        ($render===false)
                        ?(
                            (
                                isset(
                                    Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                        ->generic->App->method
                                )
                            )
                            ?(
                                (
                                    strlen(
                                        trim(
                                            self::setMethod(
                                                strtolower(
                                                    Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                                        ->generic->App->method
                                                )
                                            )
                                        )
                                    )
                                )
                                ?ucfirst(self::getMethod())
                                :'Method'
                            )
                            :'Method'
                        )
                        :(
                            (
                                isset(
                                    Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                        ->generic->App->method_render
                                )
                            )
                            ?(
                                (
                                    strlen(
                                        trim(
                                            self::setMethod(
                                                strtolower(
                                                    Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                                        ->generic->App->method_render
                                                )
                                            )
                                        )
                                    )
                                )
                                ?ucfirst(self::getMethod())
                                :'Render'
                            )
                            :'Render'
                        )
                    )
                );
            }
        }
        /**
         * Set default method of apps.
         */
        if(NULL===self::setMethodDefault() || $render===true){
            self::setMethodDefault(
                ucfirst(
                    (
                        (
                            isset(
                                Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                    ->generic->App->method_default
                            )
                        )
                        ?(
                            (
                                strlen(
                                    self::setMethodDefault(
                                        trim(
                                            strtolower(
                                                Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                                    ->generic->App->method_default
                                            )
                                        )
                                    )
                                )
                            )
                            ?ucfirst(self::setLayoutDefaultMethod(self::getMethodDefault()))
                            :ucfirst(self::setLayoutDefaultMethod('index'))
                        )
                        :ucfirst(self::setLayoutDefaultMethod('index'))
                    )
                ).
                (
                    ($render===false)
                    ?(
                            (
                                isset(
                                    Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                        ->generic->App->method
                                ) &&
                                strlen(
                                    trim(
                                        self::setMethodDefault(
                                            strtolower(
                                                Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                                    ->generic->App->method
                                            )
                                        )
                                    )
                                )
                            )
                            ?ucfirst(self::getMethodDefault())
                            :'Method'
                    )
                    :(
                        (
                            isset(
                                Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                    ->generic->App->method_render
                            )
                        )
                        ?(
                            (
                                strlen(
                                    trim(
                                        self::setMethodDefault(
                                            strtolower(
                                                Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                                    ->generic->App->method_render
                                            )
                                        )
                                    )
                                )
                            )
                            ?ucfirst(self::getMethodDefault())
                            :'Render'
                        )
                        :'Render'
                    )
                )
            );
        }
        /**
         * Set path controller of apps.
         */
        if(
            false===realpath(
                self::setPathCtrl(
                    Dadiweb_Configuration_Settings::getInstance()->getPath().DIRECTORY_SEPARATOR.
                    self::getProgram().DIRECTORY_SEPARATOR.
                    (
                        (NULL!==Dadiweb_Configuration_Routes::getInstance()->getABC())
                        ?Dadiweb_Configuration_Routes::getInstance()->getABC().DIRECTORY_SEPARATOR
                        :''
                    ).
                    (
                        (
                            isset(
                                Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                    ->generic->App->ctrl_path
                            )
                        )
                        ?(
                            (
                                strlen(
                                    trim(
                                        self::setPathCtrl(
                                            strtolower(
                                                Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                                    ->generic->App->ctrl_path
                                            )
                                        )
                                    )
                                )
                            )
                            ?self::getPathCtrl()
                            :strtolower('ctrl')
                        )
                        :strtolower('ctrl')
                    )
                )
            )
        ){
            throw Dadiweb_Throw_ErrorException::showThrow(
                sprintf(
                    'Directory "%s" does not exist',
                    self::getPathCtrl()
                )
            );
        }
        /**
         * Set class controller of apps.
         */
        if(
            NULL===self::setClass(
                ($render===false)
                ?(
                    (
                        isset(
                            Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                ->generic->App->ctrl_class
                        ) &&
                        strlen(
                            trim(
                                self::setClass(
                                    strtolower(
                                        Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                            ->generic->App->ctrl_class
                                    )
                                )
                            )
                        )
                    )
                    ?ucfirst(self::getClass())
                    :ucfirst('Ctrl')
                )
                :(
                    (
                        isset(
                            Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                ->generic->App->method_render
                        )
                    )
                    ?(
                        (
                            strlen(
                                $class=trim(
                                    strtolower(
                                        Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                            ->generic->App->method_render
                                    )
                                )
                            )
                        )
                        ?ucfirst($class)
                        :'Render'
                    )
                    :'Render'
                )
            )
        ){
            throw Dadiweb_Throw_ErrorException::showThrow(
                'Critical interrupt. The name of the default class is not established.'
            );
        }
        /**
         * Set filename controller of apps.
         */
        if(
            false===is_file(
                (
                    isset(
                        Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                            ->generic->App->ctrl_class
                    )
                )
                ?(
                    (
                        strlen(
                            trim(
                                self::setFileCtrl(
                                    strtolower(
                                        Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                            ->generic->App->ctrl_class
                                    )
                                )
                            )
                        )
                    )
                    ?(
                        self::setFileCtrl(
                            self::getPathCtrl().DIRECTORY_SEPARATOR.
                            ucfirst(self::getDefaultController()).
                            ucfirst(self::getFileCtrl().'.php')
                        )
                    )
                    :(
                        self::setFileCtrl(
                            self::getPathCtrl().DIRECTORY_SEPARATOR.
                            ucfirst(self::getgetDefaultController()).
                            self::getClass().'.php'
                        )
                    )
                )
                :self::setFileCtrl(
                    self::getPathCtrl().DIRECTORY_SEPARATOR.
                    ucfirst(self::getgetDefaultController()).
                    self::getClass().'.php'
                )
            )
        ){
            throw Dadiweb_Throw_ErrorException::showThrow(
                sprintf(
                    'File "%s" does not exist',
                    self::getFileCtrl()
                )
            );
        }
        if(
            false===is_file(
                (
                    isset(
                        Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                            ->generic->App->ctrl_class
                    )
                )
                ?(
                    (
                        strlen(
                            trim(
                                self::setFileCtrl(
                                    strtolower(
                                        Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                                            ->generic->App->ctrl_class
                                    )
                                )
                            )
                        )
                    )
                    ?(
                        self::setFileCtrl(
                            self::getPathCtrl().DIRECTORY_SEPARATOR.
                            ucfirst(self::getController()).
                            ucfirst(self::getFileCtrl().'.php')
                        )
                    )
                    :(
                        self::setFileCtrl(
                            self::getPathCtrl().DIRECTORY_SEPARATOR.
                            ucfirst(self::getController()).self::getClass().'.php'
                        )
                    )
                )
                :self::setFileCtrl(
                    self::getPathCtrl().DIRECTORY_SEPARATOR.
                    ucfirst(self::getController()).self::getClass().'.php'
                )
            )
        ){
            throw Dadiweb_Throw_ErrorException::showThrow(
                sprintf(
                    'File "%s" does not exist',
                    self::getFileCtrl()
                )
            );
        }
        /**
         * Set path for spl_autoload of apps.
         */
        self::setPath(
            Dadiweb_Configuration_Settings::getInstance()->getPath().DIRECTORY_SEPARATOR.
            self::getProgram().
            (
                (NULL!==Dadiweb_Configuration_Routes::getInstance()->getABC())
                ?(DIRECTORY_SEPARATOR.Dadiweb_Configuration_Routes::getInstance()->getABC())
                :''
            )
        );
        /**
         * Setup bootsrap class of apps.
         */
        self::setDefaultClass(
            ucfirst(self::getProgram())."_".
            ucfirst(self::getDefaultController()).self::getClass()
        );
        self::setClass(
            ucfirst(self::getProgram())."_".
            ucfirst(self::getController()).self::getClass()
        );
    }
/***************************************************************/
    /**
     * Set current program.
     * 
     * @param string|null
     * @return string
     */
    protected function setProgram($prog=NULL)
    {
        return $this->_prog=$prog;
    }
    
/***************************************************************/
    /**
     * Get current program.
     * 
     * @return string|null
     */
    public function getProgram()
    {
        return $this->_prog;
    }
    
/***************************************************************/
    /**
     * Set current controller.
     * 
     * @param string|null $ctrl
     * @return string|null
     */
    protected function setController($ctrl=NULL)
    {
        return $this->_ctrl=$ctrl;
    }
    
/***************************************************************/
    /**
     * Get current controller.
     *
     * @return string|null
     */
    public function getController()
    {
        return $this->_ctrl;
    }
    
/***************************************************************/
    /**
     * Set default controller.
     * 
     * @param string|null $ctrl_default
     * @return string|null
     */
    protected function setDefaultController($ctrl_default=NULL)
    {
        return $this->_ctrl_default=$ctrl_default;
    }
    
/***************************************************************/
    /**
     * Get default controller.
     *
     * @return string|null
     */
    public function getDefaultController()
    {
        return $this->_ctrl_default;
    }
    
/***************************************************************/
    /**
     * Set current method.
     * 
     * @param string|null $method
     * @return string|null
     */
    protected function setMethod($method=NULL)
    {
        return $this->_method=$method;
    }
    
/***************************************************************/
    /**
     * Get current method.
     *
     * @return string|null
     */
    public function getMethod()
    {
        return $this->_method;
    }
    
/***************************************************************/
    /**
     * Set default method.
     * 
     * @param string|null $method_default
     * @return string|null
     */
    protected function setMethodDefault($method_default=NULL)
    {
        return $this->_method_default=$method_default;
    }
    
/***************************************************************/
    /**
     * Get default method.
     *
     * @return string|null
     */
    public function getMethodDefault()
    {
        return $this->_method_default;
    }
    
/***************************************************************/
    /**
     * Set path's applications.
     * 
     * @param string|null $path
     * @return string|null
     */
    protected function setPath($path=NULL)
    {
        return $this->_path=$path;
    }
    
/***************************************************************/
    /**
     * Get path's applications.
     *
     * @return string|null
     */
    public function getPath()
    {
        return $this->_path;
    }
    
/***************************************************************/
    /**
     * Set path's controller (current).
     * 
     * @param string|null $path_ctrl
     * @return string|null
     */
    protected function setPathCtrl($path_ctrl=NULL)
    {
        return $this->_path_ctrl=$path_ctrl;
    }
    
/***************************************************************/
    /**
     * Get path's controller (current).
     *
     * @return string|null
     */
    public function getPathCtrl()
    {
        return $this->_path_ctrl;
    }
    
/***************************************************************/
    /**
     * Set external class (current).
     * 
     * @param string|null $file_ctrl
     * @return string|null
     */
    protected function setFileCtrl($file_ctrl=NULL)
    {
        return $this->_file_ctrl=$file_ctrl;
    }
    
/***************************************************************/
    /**
     * Get file's controller (current).
     *
     * @return string|null
     */
    protected function getFileCtrl()
    {
        return $this->_file_ctrl;
    }
    
/***************************************************************/
    /**
     * Set external class (current).
     * 
     * @param string|null $class
     * @return string|null
     */
    protected function setClass($class=NULL)
    {
        return $this->_class=$class;
    }
    
/***************************************************************/
    /**
     * Get external class (current).
     *
     * @return string|null
     */
    public function getClass()
    {
        return $this->_class;
    }
    
/***************************************************************/
    /**
     * Set external class (default).
     * 
     * @param string|null $class_default
     * @return string|null
     */
    protected function setDefaultClass($class_default=NULL)
    {
        return $this->_class_default=$class_default;
    }
    
/***************************************************************/
    /**
     * Get external class (default).
     *
     * @return string|null
     */
    public function getDefaultClass()
    {
        return $this->_class_default;
    }
    
/***************************************************************/
    /**
     * Set program (layout).
     * 
     * @param string|null $layout_program
     * @return string|null
     */
    protected function setLayoutProgram($layout_program=NULL)
    {
        return $this->_layout_program=$layout_program;
    }
    
/***************************************************************/
    /**
     * Get program (layout).
     *
     * @return string|null
     */
    public function getLayoutProgram()
    {
        return $this->_layout_program;
    }
    
/***************************************************************/
    /**
     * Set controller (layout).
     * 
     * @param string|null $layout_controller
     * @return string|null
     */
    protected function setLayoutController($layout_controller=NULL)
    {
        return $this->_layout_controller=$layout_controller;
    }
    
/***************************************************************/
    /**
     * Get controller (layout).
     *
     * @return string|null
     */
    public function getLayoutController()
    {
        return $this->_layout_controller;
    }
    
/***************************************************************/
    /**
     * Set default controller (layout).
     * 
     * @param string|null $layout_default_controller
     * @return string|null 
     */
    protected function setLayoutDefaultController($layout_default_controller=NULL)
    {
        return $this->_layout_default_controller=$layout_default_controller;
    }
    
/***************************************************************/
    /**
     * Get default controller (layout).
     *
     * @return string|null
     */
    public function getLayoutDefaultController()
    {
        return $this->_layout_default_controller;
    }
    
/***************************************************************/
    /**
     * Set method (layout).
     * 
     * @param string|null $layout_method
     * @return string|null
     */
    protected function setLayoutMethod($layout_method=NULL)
    {
        return $this->_layout_method=$layout_method;
    }
    
/***************************************************************/
    /**
     * Get method (layout).
     *
     * @return string
     */
    public function getLayoutMethod()
    {
        return $this->_layout_method;
    }
    
/***************************************************************/
    /**
     * Set default method (layout).
     * 
     * @param string|null $layout_default_method
     * @return string|null
     */
    protected function setLayoutDefaultMethod($layout_default_method=NULL)
    {
        return $this->_layout_default_method=$layout_default_method;
    }
    
/***************************************************************/
    /**
     * Get default method (layout).
     *
     * @return string|null
     */
    public function getLayoutDefaultMethod()
    {
        return $this->_layout_default_method;
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
            throw Dadiweb_Configuration_Exception::getInstance()->getMessage(
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