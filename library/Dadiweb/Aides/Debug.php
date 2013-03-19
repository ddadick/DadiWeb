<?php
class Dadiweb_Aides_Debug
{
/***************************************************************/
    /**
     * Returns Debug
     * 
     * $options - variable for debugger
     *
     * $key_type: 
     * 0 - continue the script; 
     * 1 - stop script
     * 
     * 
     * @var Array()
     * @return stdClass()
     */
    public static function show($options=NULL, $key_type=NULL)
    {
    	
    	$target=debug_backtrace();
    	ob_start();
    	echo '<pre>';
    	echo 'File - "'.$target[0]['file'].'"; line - '.$target[0]['line'].'<br />';
    	echo '<br />'.var_dump($options).'</pre>';
    	if($key_type!==NULL && $key_type){
    		ob_end_flush();
    		exit;
    	}
    	ob_end_flush();
    	return ;
    }
/***************************************************************/
}