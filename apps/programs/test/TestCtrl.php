<?php
class Test_TestCtrl extends Apps_Programs_Kernel
{
	public function TestMethod(){
		echo '1';
		echo 'asdasd';
		$this->rendered->ad=array('ad');
		Dadiweb_Aides_Debug::show($this->rendered->ad);
	}
}