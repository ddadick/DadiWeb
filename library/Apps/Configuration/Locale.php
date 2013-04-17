<?php
class Apps_Configuration_Locale
{
	/**
     * Singleton instance
     * 
     * @var Apps_Configuration_Locale
     */
    protected static $_instance = null;
    
    /**
     * Locales of programm
     *
     * @var Object
     */
    
    protected $_locale = NULL;
    
/***************************************************************/
	/**
     * Singleton pattern implementation makes "new" unavailable
     *
     * @return void
     */
	protected function __construct(){
		self::setGeneric();
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
     * Returns an instance of Apps_Configuration_Config
     * Singleton pattern implementation
     *
     * @return Apps_Configuration_Config Provides a fluent interface
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
     * Reset instance of Apps_Configuration_Config
     * Singleton pattern implementation
     *
     * @return Apps_Configuration_Config Provides a fluent interface
     */
    public static function resetInstance()
    {
        return self::$_instance=NULL;
    }
/***************************************************************/
    /**
     * Returns config of programm
     *
     * @return stdClass
     */
    public function getGeneric()
    {
    	if(!is_array($this->_locale)){
    		self::setGeneric();
    	}
    	return $this->_locale;
    }
/***************************************************************/
    /**
     * Setup config of programm
     *
     * @return stdClass
     */
    protected function setGeneric()
    {
    	$file=(
    		(
    			isset(Dadiweb_Configuration_Kernel::getInstance()->getLocale()->locale)
    			&& strlen($locale_file_name=trim(Dadiweb_Configuration_Kernel::getInstance()->getLocale()->locale))
    		)
    		?$locale_file_name.'.'
    		.(
    			(
    				isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Locales->extension)
    				&& strlen($locale_file_exe=trim(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Locales->extension)))
    			)
    			?strtolower($locale_file_exe)
    			:(
    				(
    					isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->locales_type)
    					&& strlen($locale_file_exe=trim(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->locales_type)))
    				)
    				?$locale_file_exe
    				:strtolower('xml')
    			)
    		)
    		:(
    			'en_US.'
    			.(
    				(
    					isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Locales->extension)
    					&& strlen($locale_file_exe=trim(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Locales->extension)))
    				)
    				?$locale_file_exe
    				:(
    					(
    						isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->locales_type)
    						&& strlen($locale_file_exe=trim(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->locales_type)))
    					)
    					?$locale_file_exe
    					:strtolower('xml')
    				)
    			)
    		)
    	);
    	$type=(
    		(
    			isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Locales->type)
    			&& strlen($type=trim(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Locales->type)))
    		)
    		?$type
    		:(
    			(
    				isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->locales_type)
    				&& strlen($type=trim(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->locales_type)))
    			)
    			?$type
    			:strtolower('xml')
    		)
    	);
    	$path=(
    		(
    			isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Locales->path)
    			&& strlen($path=trim(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Locales->path)))
    		)
    		?$path
    		:(
    			(
    				isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->locales_path)
    				&& strlen($path=trim(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->generic->App->locales_path)))
    			)
    			?$path
    			:strtolower('/.. /resources/i18n')
    		)
    	);
    	if(Dadiweb_Configuration_Apps::getInstance()->getPathCtrl()!==NULL){
   			if(!is_array($this->_locale)){
   				$this->_locale=array();
   			}
   			$path=Dadiweb_Aides_Filesystem::pathCreate(
   				Dadiweb_Aides_Filesystem::pathValidator(
   					Dadiweb_Configuration_Apps::getInstance()->getPathCtrl().
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
   			if(!is_file($file)){
   				
   			}
   			$t=new Dadiweb_Widening_Xml_Reader(array('content'=>$file));
			Dadiweb_Aides_Debug::show($t->getResult(),true);
   			
    	}
    }
    
/***************************************************************/
	/**
     * 
     * The handler functions that do not exist
     * 
     * @return Exeption, default - NULL
     * 
     */
	public function __call($method, $args) 
    {
    	if(!method_exists($this, $method)) { 
         	throw Dadiweb_Render_Exception::getInstance()->getMessage(sprintf('The required method "%s" does not exist for %s', $method, get_class($this))); 
       	} 	
    }
/***************************************************************/
}