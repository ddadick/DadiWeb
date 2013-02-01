<?php

//Setup default timezone
date_default_timezone_set('Europe/Helsinki');

//Error List for interrupt handling
error_reporting(E_ALL | E_STRICT);

//Set output options for PHP errors
ini_set('display_errors','On');

/***************************************************************/

/**
 *
 * The error handler
 * @category	NULL
 * @package		Supervisor
 * @return		The output buffer function 'ob_start()' of php
 */
class Supervisor
{
	public function __construct()
	{
		$GLOBALS['SUPERVISOR_DEBUG']=array();
		
		//registration handler critical error
		register_shutdown_function(array($this, 'FatalErrorCatcher'));

		//the creation of the output buffer
		ob_start();
		
		//the primary scenario
		@eval(file_get_contents(dirname(__FILE__).DIRECTORY_SEPARATOR.'bootstrap.php'));
	}

	public function FatalErrorCatcher()
	{
		//the secondary scenario
		$error = error_get_last();
		if (isset($error)){
			if(
				$error['type'] == E_STRICT ||
				$error['type'] == E_COMPILE_ERROR ||
				$error['type'] == E_CORE_ERROR
			){
				echo 'Warning!!! Error: '.$error['message'].'<br />';
				echo '# file - "'.$error['file'].'", line - '.$error['line'].'<br />';
				//reset the buffer, shut down the buffer
				ob_end_clean();
				
				// контроль критических ошибок:
				// - записать в лог
				// - вернуть заголовок 500
				// - вернуть после заголовка данные для пользователя
			}else{
				if($error['message']!='Can only throw objects'){
					echo 'Warning!!! Error: '.$error['message'].'<br />';
					echo '# file - "'.$error['file'].'", line - '.$error['line'].'<br />';
				}
				//the conclusion buffer, shut down the buffer
				ob_end_flush();
			}
		}else{
			
			//the conclusion buffer, shut down the buffer
			
			ob_end_flush();
			if(isset($GLOBALS['SUPERVISOR_THROW']) && isset($GLOBALS['SUPERVISOR_STOP']) && $GLOBALS['SUPERVISOR_STOP']){
				echo $GLOBALS['SUPERVISOR_THROW'];
			}elseif(count($GLOBALS['SUPERVISOR_DEBUG'])){
				foreach($GLOBALS['SUPERVISOR_DEBUG'] as $item){
					echo $item;
				}
			}
		}
	}
}

$SUPERVISOR_STOP=NULL;

// bootstrap
new Supervisor();

