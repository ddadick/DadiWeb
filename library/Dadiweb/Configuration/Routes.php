<?php
class Dadiweb_Configuration_Routes
{
	/**
     * Singleton instance
     * 
     * @var Dadiweb_Configuration_Routes
     */
    protected static $_instance = null;
    
    /**
     * Get search router
     *
     * @var Array()
     */
    protected $_search_router = NULL;
    
    /**
     * General variable
     *
     * @var Array()
     */
    protected $_routes = NULL;

    /**
     * General variable for abc
     *
     * @var Array()
     */
    protected $_abc_routes = NULL;

   	/**
   	 * Set administrative basic control
   	 *
   	 * @var ABC
   	 */
   	protected $_abc = NULL;
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
     * Returns an instance of Dadiweb_Configuration_Routes
     * Singleton pattern implementation
     *
     * @return Dadiweb_Configuration_Routes Provides a fluent interface
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
     * Reset instance of Dadiweb_Configuration_Routes
     * Singleton pattern implementation
     *
     * @return Dadiweb_Configuration_Settings Provides a fluent interface
     */
    public static function resetInstance()
    {
        return self::$_instance=NULL;
    }
/***************************************************************/
    /**
     * Setup Configuration Object
     *
     * @return stdClass
     */
    protected function setGeneric()
    {
    	if(Dadiweb_Configuration_Settings::getInstance()->getAppsPath()!=NULL && is_array(Dadiweb_Configuration_Settings::getInstance()->getAppsPath())){
	    	foreach(Dadiweb_Configuration_Settings::getInstance()->getAppsPath() as $items){
    			if(!is_array($this->_routes)){
    				$this->_routes=array();
    			}
    			$file=$items
    				.(
    					(
    						isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->App->routes_file_name)
    						&& strlen($routes_file_name=trim(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->App->routes_file_name)))
						)
						?$routes_file_name.'.'
    						.(
    							(
    								isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->App->routes_file_exe)
    								&& strlen($routes_file_exe=trim(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->App->routes_file_exe)))
    							)
    							?strtolower($routes_file_exe)
    							:strtolower('ini')
							)
    					:strtolower(
    						'routes.'
    						.(
    							(
    								isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->App->routes_file_exe)
    								&& strlen($routes_file_exe=trim(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->App->routes_file_exe)))
    							)
    							?$routes_file_exe
    							:'ini'
							)
    					)
    				)
    			;
    			if(is_file($file)){
    				$ini=parse_ini_file($file,true);
    				if($ini){
    					foreach($ini as $key=>$item){
    						$this->_routes=array_merge_recursive(
    							$this->_routes,
    							Dadiweb_Aides_Array::getInstance()->items_2_MultiDimensionalKeys(
    									Dadiweb_Aides_Array::getInstance()->explode($key,'.'),
    									$item
    							)
    						);
    					}
    				}	
    			}
    		}
    	}
    	/**
    	 * ABC
    	 */
    	self::setABC(
    		(
    			isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->Master->abc)
    			&& strlen(trim(self::setABC(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->Master->abc))))
    		)
    		?self::getABC()
    		:strtolower('abc')
    	);
    	if(Dadiweb_Configuration_Settings::getInstance()->getABCAppsPath()!=NULL && is_array(Dadiweb_Configuration_Settings::getInstance()->getABCAppsPath())){
    		foreach(Dadiweb_Configuration_Settings::getInstance()->getABCAppsPath() as $items){
    			if(!is_array($this->_abc_routes)){
    				$this->_abc_routes=array();
    			}
    			$file=$items
    			.(
    					(
    							isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->App->routes_file_name)
    							&& strlen($routes_file_name=trim(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->App->routes_file_name)))
    					)
    					?$routes_file_name.'.'
    					.(
    							(
    									isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->App->routes_file_exe)
    									&& strlen($routes_file_exe=trim(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->App->routes_file_exe)))
    							)
    							?strtolower($routes_file_exe)
    							:strtolower('ini')
    					)
    					:strtolower(
    							'routes.'
    							.(
    									(
    											isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->App->routes_file_exe)
    											&& strlen($routes_file_exe=trim(strtolower(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->resource->App->routes_file_exe)))
    									)
    									?$routes_file_exe
    									:'ini'
    							)
    					)
    			);
    			if(is_file($file)){
    				$ini=parse_ini_file($file,true);
    				if($ini){
    					foreach($ini as $key=>$item){
    						$this->_abc_routes=array_merge_recursive(
    							$this->_abc_routes,
    							Dadiweb_Aides_Array::getInstance()->items_2_MultiDimensionalKeys(
    									Dadiweb_Aides_Array::getInstance()->explode($key,'.'),
    									$item
    							)
    						);
    					}
    				}	
    			}
    		}
    	}
    	unset($generic);
    	unset($items);
    	unset($item);
    	unset($key);
    }
/***************************************************************/    	
    /**
   	 * 
   	 * Search routes for Apps
   	 * 
   	 * @return Array()
   	 * 
   	 */
   	public function searchRouter($uri=NULL)
   	{
   		if($uri==NULL){return NULL;}
   		$uri='/'.implode('/',$uri);
   		if(NULL===self::getABC()){
   			if(is_array(self::getRoutes()) && count(is_array(self::getRoutes()))){
   				foreach(self::getRoutes() as $item){
   					if($item['type']=='generic'){
   						if(false!==strpos($uri, '/'.$item['alias']) && false!==strpos($uri.'/', '/'.$item['alias'].'/')){
   							$this->_search_router = str_replace (
   									'/'.$item['alias'],
   									'/'.implode('/',array($item['prog'],$item['ctrl'],$item['method'])),
	   								$uri
   							);
   						}
   					}elseif($item['type']=='regexp'){
   						preg_match('/'.str_replace('/','\/',$item['alias']).'/i', $uri, $matches);
   						if(count($matches)){
   							$this->_search_router=array();
	   						array_push(
   								$this->_search_router,str_replace (
   									'/'.$matches[0],
   									'/'.implode('/',array($item['prog'],$item['ctrl'],$item['method'])),
   									$uri
   								)
   							);
   							$variable=array();
	   						$regexp='';
   							if(isset($item['var'])){
   								foreach($item['var'] as $key=>$var){
   									if(isset($matches[(int)$key])){
   										$variable[$var]=$matches[(int)$key];
   										$regexp.=$variable[$var];
   									}
   								}
	   						}
   							array_push($this->_search_router,$variable);
   							array_push($this->_search_router,sprintf($item['regexp'], $regexp));
   						}
   					}
   				}
   			}
   		}else{
   			if(is_array(self::getABCRoutes()) && count(is_array(self::getABCRoutes()))){  
   				foreach(self::getABCRoutes() as $item){
   					if($item['type']=='generic'){
   						if(false!==strpos($uri, '/'.$item['alias']) && false!==strpos($uri.'/', '/'.$item['alias'].'/')){
   							$this->_search_router = str_replace (
   								'/'.$item['alias'],
	   							'/'.implode('/',array($item['prog'],$item['ctrl'],$item['method'])),
   								$uri
   							);
   						}
   					}elseif($item['type']=='regexp'){
   						preg_match('/'.str_replace('/','\/',$item['alias']).'/i', $uri, $matches);
	   					if(count($matches)){
   							$this->_search_router=array();
   							array_push(
   								$this->_search_router,str_replace (
   									'/'.$matches[0],
   									'/'.implode('/',array($item['prog'],$item['ctrl'],$item['method'])),
   									$uri
   								)
	   						);
   							$variable=array();
   							$regexp='';
   							if(isset($item['var'])){
   								foreach($item['var'] as $key=>$var){
   									if(isset($matches[(int)$key])){
   										$variable[$var]=$matches[(int)$key];
   										$regexp.=$variable[$var];
   									}
	   							}
   							}
   							array_push($this->_search_router,$variable);
   							array_push($this->_search_router,sprintf($item['regexp'], $regexp));
   						}
   					}
   				}
   			}
   		}
   		return $this->_search_router;
   	}
/***************************************************************/    	
    /**
   	 * 
   	 * Set login administrative basic control
   	 * 
   	 * @return ABC
   	 * 
   	 */
   	public function setABC($_abc=NULL)
   	{
   		return $this->_abc=$_abc;
   	}
/***************************************************************/    	
    /**
     * 
     * Get login administrative basic control
     * 
     * @return ABC
     * 
     */
    public function getABC()
    {
        return $this->_abc;
    }
/***************************************************************/
    /**
     * 
     * Get routes for Apps
     * 
     * @return Array()
     * 
     */
    public function getRoutes()
    {
        return (isset($this->_routes['routes']))?$this->_routes['routes']:NULL;
    }
/***************************************************************/
    /**
     * 
     * Search routes for Apps
     * 
     * @return Array()
     * 
     */
    public function searchRoutes($_search=NULL)
    {
        if(self::getABC()!==NULL && NULL!==($routes=self::getABCRoutes())){
            if($_search!==NULL && is_string($_search) && strlen(trim($_search)) && array_key_exists($_search , $routes)){
                return $routes[$_search]['alias'];
            }
        }elseif(NULL!==($routes=self::getRoutes())){
            if($_search!==NULL && is_string($_search) && strlen(trim($_search)) && array_key_exists($_search , $routes)){
                return $routes[$_search]['alias'];
            }
        }
        $array=array();
        foreach($routes as $key=>$items){
            $array[$key]=$items['alias'];
        }
        return Dadiweb_Aides_Array::getInstance()->arr2obj($array);
    }
/***************************************************************/
    /**
   	 * 
   	 * Get routes for Apps
   	 * (administrative basic control)
   	 * 
   	 * @return Array()
   	 * 
   	 */
   	public function getABCRoutes()
   	{
   		return (isset($this->_abc_routes['routes']))?$this->_abc_routes['routes']:NULL;
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
         	throw Dadiweb_Configuration_Exception::getInstance()->getMessage(
         		sprintf('The required method "%s" does not exist for %s', $method, get_class($this))
         	); 
       	} 	
    }
/***************************************************************/
}