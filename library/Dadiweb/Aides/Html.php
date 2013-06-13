<?php
class Dadiweb_Aides_Html
{
    /**
     * Singleton instance.
     * 
     * @var Dadiweb_Aides_Html
     */
    protected static $_instance = null;
    
/***************************************************************/
    /**
     * Singleton pattern implementation makes "new" unavailable
     *
     * @return void
     */
    protected function __construct(){}
    
/***************************************************************/
    /**
     * Singleton pattern implementation makes "clone" unavailable
     *
     * @return void
     */
    protected function __clone(){}
    
/***************************************************************/
    /**
     * Returns an instance of Dadiweb_Aides_Html.
     * Singleton pattern implementation.
     *
     * @return Dadiweb_Aides_Html
     */
    public static function getInstance()
    {
        if(null === self::$_instance){
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
/***************************************************************/
    /**
     * Get real host
     * 
     * @return string
     */
    public function getRealHost(){
        return (isset($_SERVER["X_REAL_HOST"]))?$_SERVER["X_REAL_HOST"]:(
                (isset($_SERVER["HTTP_HOST"]))?$_SERVER["HTTP_HOST"]:$_SERVER["SERVER_NAME"]
        );
    }
    
/***************************************************************/
    /**
     * Get base url
     * 
     * @return string
     */
    public function getBaseUrl(){
        return "http://".self::getRealHost().'/';
    }
    
/***************************************************************/
    /**
     * Get design path
     * 
     * @return string
     */
    public function getDesignPath(){
        return Dadiweb_Configuration_Layout::getInstance()->getLayoutPath();
    }
    
/***************************************************************/
    /**
     * Get data path
     * 
     * @return string
     */
    public function getDataPath(){
        $path=DATA_PATH;
        if(false===DATA_PATH){
            $path=Dadiweb_Aides_Filesystem::pathCreate($_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR.'data');
        }
        return self::getUrlPath($path);
    }
    
/***************************************************************/
    /**
     * Url validator (ftp etc.)
     * 
     * @param string|null $_path
     * @return string|null
     */
    public function validatorUrl($_url=NULL){
        if(
            NULL!==$_url &&
            is_string($_url) &&
            strlen(trim($_url))
        ){
            $pos=strpos($_url, '://');
            return substr($_url,0,$pos+2).preg_replace('/[\/\\\\]+/', "/", substr($_url,$pos+2));
        }
        return NULL;
    }
    
/***************************************************************/
    /**
     * Get url from path
     * 
     * @param string|null $_path
     * @return string
     */
    public function getUrlPath($_path=NULL){
        
        if(
            NULL!==$_path &&
            is_string($_path) &&
            strlen(trim($_path)) &&
            false!==(
                $pos=strpos($_path, Dadiweb_Aides_Filesystem::getInstance()->getScanDir())
            ) &&
            $pos==0
        ){
            return self::validatorUrl(substr_replace($_path, self::getBaseUrl(), 0, strlen(Dadiweb_Aides_Filesystem::getInstance()->getScanDir())));
        }
        return self::getBaseUrl();
    }
    
/***************************************************************/
    /**
     * Get design path
     * 
     * @return string
     */
    public function getDesignUrl(){
        $designPath=Dadiweb_Configuration_Layout::getInstance()->getLayoutPath();
        return substr(self::getBaseUrl(),0,(strlen(self::getBaseUrl())-1)).
                substr($designPath, (strpos($designPath, $_SERVER["DOCUMENT_ROOT"])+strlen($_SERVER["DOCUMENT_ROOT"])));
    }
    
/***************************************************************/
    /**
     * Search design file for app
     * 
     * @param string|null $_path
     * @param string|null $_extension
     * @return string
     */
    public function getSearchFile($_path=NULL, $_extension=NULL){
        if(
            $_path!==NULL &&
            is_string($_path) &&
            strlen(trim($_path)) &&
            $_extension!==NULL &&
            is_string($_extension) &&
            strlen(trim($_extension))
        ){
            return (
                false!==realpath(
                    $_path.($filename=
                        Dadiweb_Configuration_Kernel::getInstance()->getApps()->getLayoutProgram().'_'.
                        Dadiweb_Configuration_Kernel::getInstance()->getApps()->getLayoutController().'_'.
                        Dadiweb_Configuration_Kernel::getInstance()->getApps()->getLayoutMethod().'.'.
                        $_extension
                    )
                )
            )
            ?$filename
            :(
                (
                    false!==realpath(
                        $_path.($filename=
                            Dadiweb_Configuration_Kernel::getInstance()->getApps()->getLayoutProgram().'_'.
                            Dadiweb_Configuration_Kernel::getInstance()->getApps()->getLayoutController().'.'.
                            $_extension
                        )
                    )
                )
                ?$filename
                :(
                    (
                        false!==realpath(
                            $_path.($filename=
                                Dadiweb_Configuration_Kernel::getInstance()->getApps()->getLayoutProgram().'.'.
                                $_extension
                            )
                        )
                    )
                    ?$filename
                    :NULL
                )
            );
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
            throw Dadiweb_Aides_Exception::getInstance()->getMessage(
                sprintf(
                    'The required method "%s" does not exist for %s',
                    $method, get_class($this)
                )
            ); 
        }
    }
    
/***************************************************************/
}