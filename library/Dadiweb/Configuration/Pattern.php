<?php
class Dadiweb_Configuration_Pattern
{
    /**
     * Singleton instance.
     *
     * @var Dadiweb_Configuration_Pattern
     */
    protected static $_instance = null;
    
    /**
     * MVC - variables url.
     *
     * @var array|null
     */
    protected $variables = NULL;
    
    /**
     * Return Url.
     * 
     * @var null|string|array
     */
    protected $uri=NULL;
    
    /**
     * MVC - default Model.
     *
     * @var string|null
     */
    protected $model = NULL;
    
    /**
     * MVC - default Contoller.
     * 
     * @var string|null
     */
    protected $controller = NULL;
    
    /**
     * MVC - default View.
     * 
     * @var string|null
     */
    protected $view = NULL;
    
/***************************************************************/
    /**
     * Singleton pattern implementation makes "new" unavailable.
     * 
     * @param array $_options
     * @return void
     */
    protected function __construct(array $_options=array()){
        
        $_options=Dadiweb_Aides_Array::getInstance()->arr2obj($_options,0);
        $this->uri=(
            (
                isset($_options->uri) &&
                is_string($_options->uri) &&
                strlen(trim($_options->uri))
            )
            ?$_options->uri
            :Dadiweb_Http_Client::getInstance()->getUri()
        );
        $this->setMVC();
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
     * Returns an instance of Dadiweb_Configuration_Pattern.
     * Singleton pattern implementation.
     * 
     * @param array $_options
     * @return Dadiweb_Configuration_Pattern
     */
    public static function getInstance(array $_options=array())
    {
        if (null === self::$_instance) {
            self::$_instance = new self($_options);
        }
        if(
            count($_options) &&
            isset($_options['uri'])
            && is_string($_options['uri']) &&
            strlen(trim($_options['uri'])
        )){
            self::$_instance=new self($_options);
        }
        return self::$_instance;
    }
    
/***************************************************************/
    /**
     * Reset instance of Dadiweb_Configuration_Pattern.
     * Singleton pattern implementation.
     *
     * @return Dadiweb_Configuration_Pattern
     */
    public static function resetInstance()
    {
        return self::$_instance=NULL;
    }
    
/***************************************************************/
    /**
     * Sets general variables for the MVC.
     * 
     * @return Dadiweb_Configuration_Pattern
     */
    protected function setMVC(){
        $this->uri=Dadiweb_Aides_Deprecated::split(array('\?',$this->uri,2));
        if(
            is_array($this->uri) &&
            isset($this->uri[1]) &&
            is_array(
                $array=Dadiweb_Aides_Deprecated::split(array('\&',$this->uri[1]))
            )
        ){
            foreach($array as $value){
                $value=Dadiweb_Aides_Deprecated::split(array('=',$value));
                if(
                    is_array($value) &&
                    isset($value[0]) &&
                    isset($value[1]) &&
                    $value[1]!=NULL &&
                    strlen(trim($value[1]))>0
                ){
                    $this->variables[$value[0]]=$value[1];
                }
            }
        }
        $this->uri=$this->uri[0];
        $this->uri=Dadiweb_Aides_Deprecated::split(array('\/',substr($this->uri, 1),4));
        if(
            strtolower($this->uri[0])==Dadiweb_Configuration_Kernel::getInstance()
                                                            ->getRoutes()->getABC() &&
            count($this->uri)>1
        ){
            $this->uri=Dadiweb_Aides_Deprecated::split(
                array('\/',implode('/',(array_shift($this->uri)?$this->uri:array('/'))),4)
            );
        }elseif(
            strtolower($this->uri[0])==Dadiweb_Configuration_Kernel::getInstance()
                                                            ->getRoutes()->getABC() &&
            count($this->uri)==2 &&
            !strlen(trim($this->uri[1]))
        ){
            $this->uri[0]='';
            unset($this->uri[1]);
        }elseif(
            strtolower($this->uri[0])==Dadiweb_Configuration_Kernel::getInstance()
                                                            ->getRoutes()->getABC() &&
            count($this->uri)==1
        ){
            $this->uri[0]='';
        }else{
            Dadiweb_Configuration_Kernel::getInstance()->getRoutes()->setABC();
        }
        if(
            NULL !== Dadiweb_Configuration_Locale::getInstance()
                ->searchLocale($this->uri[0])
        ){
            $this->uri=Dadiweb_Aides_Deprecated::split(
                array('\/',implode('/',(array_shift($this->uri)?$this->uri:array('/'))),4)
            );
        }
        if(
            (
                $router=Dadiweb_Configuration_Kernel::getInstance()
                    ->getRoutes()->searchRouter($this->uri)
            )!==NULL &&
            is_string($router)
        ){
            $this->uri=Dadiweb_Aides_Deprecated::split(
                array('\/',substr($router, 1),4)
            );
        }elseif($router!==NULL && is_array($router)){
            $this->uri=Dadiweb_Aides_Deprecated::split(
                array('\/',substr($router[0], 1),4)
            );
            foreach($router[1] as $key=>$value){
                $this->variables[$key]=$value;
            }
        }
        $i=0;
        if(is_array($this->uri)){
            foreach($this->uri as $value){
                if(($value==NULL or strlen(trim($value))<=0) and $i<4){
                    $this->uri[$i]=NULL;
                }
                $i=$i+1;
            }
            if(isset($this->uri[0])){$this->setModel($this->uri[0]);}
            if(isset($this->uri[1])){$this->setController($this->uri[1]);}
            if(isset($this->uri[2])){$this->setView($this->uri[2]);}
            if(isset($this->uri[3])){
                foreach(
                    array_chunk(
                        Dadiweb_Aides_Deprecated::split(
                            array('\/',$this->uri[3])
                        )
                    , 2) as $value
                ){
                    if(
                        is_array($value) &&
                        isset($value[0]) &&
                        isset($value[1]) &&
                        $value[1]!==NULL &&
                        strlen(trim($value[1]))
                    ){
                        $this->variables[$value[0]]=$value[1];
                    }
                }
            }
        }
        return $this;
    }
    
/***************************************************************/
    /**
     * Set controller.
     * 
     * @param string|null
     * @return void
     */
    protected function setController($controller=NULL)
    {
        $this->controller=$controller;
    }
    
/***************************************************************/
    /**
     * Get controller 
     * 
     * @return string|null
     */
    public function getController()
    {
        return $this->controller;
    }
    
/***************************************************************/
    /**
     * Set model.
     * 
     * @param string|null
     * @return void
     */
    protected function setModel($model=NULL)
    {
        $this->model=$model;
    }
    
/***************************************************************/
    /**
      * Get model.
     * 
     * @return string|null
     */
    public function getModel()
    {
        return $this->model;
    }
    
/***************************************************************/
    /**
     * Set view
     * 
     * @param string|null $view
     * @return void
     *
     */
    protected function setView($view=NULL)
    {
        $this->view=$view;
    }
    
/***************************************************************/
    /**
     * Get view.
     * 
     * @return string|null
     */
    public function getView()
    {
        return $this->view;
    }
    
/***************************************************************/
    /**
     * Get param of uri.
     * 
     * @param string|null $name
     * @param mixed|null $param
     * @return mixed|null
     */
    public function getParam($name=NULL, $param=NULL)
    {
        if(isset($this->variables[$name])){
            return $this->variables[$name];
        }
        return $param;
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
                 sprintf('The required method "%s" does not exist for %s', $method, get_class($this))
             ); 
        }
    }
    
/***************************************************************/
}