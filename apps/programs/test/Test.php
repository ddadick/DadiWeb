<?php
 
class Test_Test
{
	
	public function testtest(){
		
		$d='test_TestRender';
		//$newfunc = create_function('$a', 'new "ln($a) + ln($b) = " . log($a * $b);');
		$s=new $d;
		//$s = new "self::getProgram()_ucfirst(self::getController())Ctrl";
			
		$s->test();
		
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
			Dadiweb_Throw_ErrorException::showThrow(sprintf('The required method "%s" does not exist for %s', $method, get_class($this)));
		}
	}
}