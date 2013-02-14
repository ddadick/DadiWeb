<?php

class Dadiweb_Loader_Loader
{
/***************************************************************/
	public static function loadClass($class)
    {
    	if (class_exists($class, false) || interface_exists($class, false)) {
            return;
        }
        $load=false;
        $file=str_replace('_', DIRECTORY_SEPARATOR, $class).'.php';
        foreach(explode(PATH_SEPARATOR, get_include_path()) as $path){
        	if(false !== realpath($path.DIRECTORY_SEPARATOR.$file)){
        		require_once $file;
        		$load=true;
        	}
        }
        if(!$load){
        	$file=explode('_', $class);        	
        	foreach(explode(PATH_SEPARATOR, get_include_path()) as $path){
        		if(is_array($file) && false !== realpath($filename=$path.DIRECTORY_SEPARATOR.$file[(count($file)-1)].'.php')){
        			require_once $filename;
        			$load=true;
        		}elseif(is_string($file) && false !== realpath($filename=$path.DIRECTORY_SEPARATOR.$file.'.php')){
        			require_once $filename;
        			$load=true;
        		}
        	}
        }
    	if (!$load) {
			throw Dadiweb_Loader_Exception::getInstance()->getMessage("File \"$file\" does not exist or class \"$class\" was not found in the file \"$file\"");
        }else{return;}
    }
/***************************************************************/	
	/**
     * Warning !!! This function can not be changed
     * 
     * spl_autoload() suitable implementation for supporting class autoloading.
     *
     * Attach to spl_autoload() using the following:
     * <code>
     * spl_autoload_register(array('Dadiweb_Loader_Loader', 'autoload'));
     * </code> 
     * 
     * @param  string $class
     * @return string|false Class name on success; false on failure
     */
    public static function autoload($class)
    {
    	try {
            @self::loadClass($class);
            return $class;
        }catch (ErrorException $e) {
			var_dump($e);
        	return false;
        }
    }
/***************************************************************/    
}