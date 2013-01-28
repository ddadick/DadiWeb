<?php

class Dadiweb_Apps_Exception
{
/**
     * Singleton instance
     * 
     * @var Dadiweb_Apps_Exception
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
     * Returns an instance of Dadiweb_Apps_Exception
     * Singleton pattern implementation
     *
     * @return Dadiweb_Apps_Exception Provides a fluent interface
     */
    public static function getInstance()
    {
    	if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    public function getMessage($message){
    	$i=1;
		$trace_log=array_reverse(debug_backtrace());
		$trace_result=array();
		foreach ($trace_log as $trace){
			if(false===array_search('Dadiweb_Apps_Exception',$trace['args']) && $trace['class']!='Dadiweb_Apps_Exception' && $trace['function']!='__call'){
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
		throw Dadiweb_Throw_Exception::getInstance()->getMessage($message,$trace_result);
    }
    
}
