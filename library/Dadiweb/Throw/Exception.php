<?php

class Dadiweb_Throw_Exception
{
/**
     * Singleton instance
     * 
     * @var Dadiweb_Throw_Exception
     */
    protected static $_instance = null;
	/**
     * Singleton pattern implementation makes "new" unavailable
     *
     * @return void
     */
	protected function __construct(){}
	/**
     * Singleton pattern implementation makes "clone" unavailable
     *
     * @return void
     */
    protected function __clone(){}
    /**
     * Returns an instance of Dadiweb_Uri_Http
     * Singleton pattern implementation
     *
     * @return Dadiweb_Throw_Exception Provides a fluent interface
     */
    public static function getInstance()
    {
    	if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    public function getMessage($message=null,$error_stack=array()){
    	http_response_code(404);
    	if($message==null or count($error_stack)==0){
	    	echo "Warning!!! Failed to initialize the error handler".'<br />';
    		$i=1;
			$trace_log=array_reverse(debug_backtrace());
			$trace_result=array();
			foreach ($trace_log as $trace){
				if(false===array_search('Dadiweb_Throw_Exception',$trace['args']) && $trace['class']!='Dadiweb_Throw_Exception' && $trace['function']!='__call'){
					array_push($trace_result,
					(isset($trace['file'])?' file "'.$trace['file'].'","':'')
					.(isset($trace['line'])?' line "'.$trace['line'].'" :"':'')
					.(isset($trace['class'])?' class - "'.$trace['class'].'";"':'')
					.(isset($trace['function'])?' method - "'.$trace['function'].'";"':'')
					.((count($trace['args'])>0)?' argumnets - \''.implode("','", $trace['args']).'\';':'')
					);
				}
				$i=$i+1;
			}
			foreach ($trace_result as $key=>$trace){
				echo '#'.($key+1).' '.$trace.'<br />';
			}
			exit;
    	}
    	echo "Warning!!! ".$message.'<br />';
    	foreach ($error_stack as $key=>$trace){
			echo '#'.($key+1).' '.$trace.'<br />';
		}
    }
    
}
