<?php

class Dadiweb_Throw_ErrorException extends ErrorException
{
/***************************************************************/
	public function __construct(){
		@set_exception_handler(array($this, 'exception_handler'));
	}
/***************************************************************/
	public function exception_handler($exception) {
		http_response_code(404);
		echo "Warning!!! ". $exception->getMessage() ."<br />";
		$i=0;
		$trace_log=array_reverse($exception->getTrace());
		$trace_result=array();
		foreach ($trace_log as $trace){
			if(isset($trace['args']) && false===array_search('Dadiweb_Throw_ErrorException',$trace['args']) && $trace['class']!='Dadiweb_Throw_ErrorException' && $trace['function']!='__call'){
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
   }
/***************************************************************/
   /**
    * Returns User Throw
    *
    * @return Throw
    */
   public static function showThrow($message)
   {
    ob_start();
    header("HTTP/1.0 404 Not Found");
    $target=array_reverse(debug_backtrace());
    echo '<br />';
    echo 'Warning!!! '. $message.'<br />';
	$i=0;
	$trace_result=array();
	foreach ($target as $trace){
		if(isset($trace['args']) && false===array_search('Dadiweb_Throw_ErrorException',$trace['args']) && $trace['function']!='__call'){
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
	ob_end_flush();
	exit;
   }
/***************************************************************/
}
