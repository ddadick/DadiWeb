<?php
class Dadiweb_Configuration_Render
{
    /**
     * Singleton instance.
     * 
     * @var Dadiweb_Configuration_Render
     */
    protected static $_instance = null;
    
    /**
     * Render object.
     *
     * @var Dadiweb_Configuration_Render
     */
    protected $_render = null;
    
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
     * Returns an instance of Dadiweb_Configuration_Render.
     * Singleton pattern implementation.
     *
     * @return Dadiweb_Configuration_Render
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
     * Reset instance of Dadiweb_Configuration_Render.
     * Singleton pattern implementation.
     *
     * @return Dadiweb_Configuration_Render
     */
    public static function resetInstance()
    {
        Dadiweb_Render_Bootstrap::resetInstance();
        return self::$_instance=NULL;
    }
    
/***************************************************************/
    /**
     * Returns Configuration Render.
     *
     * @return stdClass
     */
    public function getGeneric()
    {
        if($this->_render===NULL){
            self::setGeneric();
        }
        return $this->_render;
    }
    
/***************************************************************/
    /**
     * Setup Configuration Render.
     *
     * @return stdClass
     */
    protected function setGeneric()
    {
        if(
            !isset(
                Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                    ->apps->Render->bootstrap
            ) ||
            !strlen(
                trim(
                    Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                        ->apps->Render->bootstrap
                )
            )
        ){
            throw Dadiweb_Throw_ErrorException::showThrow(
                sprintf(
                    'Variable into "apps.Render.bootstrap" in the file "%sapps.ini" is not valid',
                    INI_PATH
                )
            );
        }
        Dadiweb_Render_Bootstrap::getInstance(
            Dadiweb_Configuration_Kernel::getInstance()->getSettings()
                ->apps->Render->bootstrap
        );
        Dadiweb_Render_Bootstrap::resetInstance();
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
        if(!method_exists($this, $method)) { 
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