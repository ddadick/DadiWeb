<?php
class Dadiweb_Aides_Layout
{
    /**
     * Singleton instance.
     * 
     * @var Dadiweb_Aides_Layout
     */
    protected static $_instance = null;
    
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
     * Returns an instance of Dadiweb_Aides_Layout.
     * Singleton pattern implementation.
     *
     * @return Dadiweb_Aides_Layout
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
     * Set switch Rendered.
     *
     * @return boolean
     */
    public function useRendered($rendered_switch=true)
    {
        return Dadiweb_Configuration_Kernel::getInstance()
            ->getLayout()->useRendered($rendered_switch);
    }
    
/***************************************************************/
    /**
     * Returns switch Rendered
     *
     * @return boolean
     */
    public function getSwitchRendered()
    {
        return Dadiweb_Configuration_Kernel::getInstance()
            ->getLayout()->getSwitchRendered();
    }
    
/***************************************************************/
    /**
     * Set switch Layout
     *
     * @return boolean
     */
    public function useLayout($layout_switch=true)
    {
        return Dadiweb_Configuration_Kernel::getInstance()
            ->getLayout()->useLayout($layout_switch);
    }
    
/***************************************************************/
    /**
     * Returns switch Layout
     *
     * @return boolean
     */
    public function getSwitchLayout()
    {
        return Dadiweb_Configuration_Kernel::getInstance()
            ->getLayout()->getSwitchLayout();
    }
    
/***************************************************************/
    /**
     * Set name of View
     * 
     * @param string $layout_name
     * @return string|null
     */
    public function setLayoutName($layout_name=NULL)
    {
        if(
            ($layout_name===NULL && !is_string($layout_name)) ||
            (is_string($layout_name) && !strlen(trim($layout_name)))
        ){
            Dadiweb_Configuration_Kernel::getInstance()
                ->getLayout()->setLayoutName(NULL);
        }
        return Dadiweb_Configuration_Kernel::getInstance()
            ->getLayout()->setLayoutName($layout_name);
    }
    
/***************************************************************/
    /**
     * Set switch View
     *
     * @return boolean
     */
    public function useView($view_switch=true)
    {
        return Dadiweb_Configuration_Kernel::getInstance()
            ->getLayout()->useView($view_switch);
    }
    
/***************************************************************/
    /**
     * Returns switch view
     *
     * @return boolean
     */
    public function getSwitchView()
    {
        return Dadiweb_Configuration_Kernel::getInstance()
            ->getLayout()->getSwitchView();
    }
    
/***************************************************************/
    /**
     * Set name of Layout
     * 
     * @param string $view_name
     * @return string|null
     */
    public function setViewName($view_name=NULL)
    {
        if(
            ($view_name===NULL && !is_string($view_name)) ||
            (is_string($view_name) && !strlen(trim($view_name)))
        ){
            Dadiweb_Configuration_Kernel::getInstance()
                ->getLayout()->setViewName(NULL);
        }
        return Dadiweb_Configuration_Kernel::getInstance()
                ->getLayout()->setViewName($view_name);
    }
    
/***************************************************************/
    /**
     * Get render action for special view name
     * 
     * @param string|null $view_name
     * 
     * @return string|null
     */
    public function getView($view_name=NULL)
    {
        if(
            ($view_name===NULL && !is_string($view_name)) ||
            (is_string($view_name) && !strlen(trim($view_name)))
        ){
            return NULL;
        }
        $switch_redered=self::getSwitchRendered();
        $switch_layout=self::getSwitchLayout();
        self::useRendered(true);
        self::useLayout(false);
        $save_view=Dadiweb_Configuration_Kernel::getInstance()
                    ->getLayout()->getViewName();
        self::setViewName($view_name);
        $return = Dadiweb_Configuration_Kernel::getInstance()
                    ->getLayout()->getRendered();
        self::setViewName($save_view);
        self::useRendered($switch_redered);
        self::useLayout($switch_layout);
        return $return;
    }
    
/***************************************************************/
    /**
     * Get render action of default view
     * 
     * @return string|null
     */
    public function getActionView()
    {
        $switch_redered=self::getSwitchRendered();
        $switch_layout=self::getSwitchLayout();
        self::useRendered(true);
        self::useLayout(false);
        $save_view=Dadiweb_Configuration_Kernel::getInstance()
                    ->getLayout()->getViewName();
        self::setViewName(NULL);
        $return = Dadiweb_Configuration_Kernel::getInstance()
                    ->getLayout()->getRendered();
        self::setViewName($save_view);
        self::useRendered($switch_redered);
        self::useLayout($switch_layout);
        return $return;
    }
    
/***************************************************************/
    /**
     * The handler functions that do not exist
     * 
     * @param string $method
     * @param mixed $args
     * 
     * @return void
     */
    public function __call($method, $args)
    {
        if(!method_exists($this, $method)){
            throw Dadiweb_Throw_ErrorException::showThrow(
                sprintf('The required method "%s" does not exist for %s', $method, get_class($this))
            );
        }
    }
    
/***************************************************************/
}