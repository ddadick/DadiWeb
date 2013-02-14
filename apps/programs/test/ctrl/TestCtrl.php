<?php
class Test_TestCtrl extends Apps_Programs_Kernel
{
	public function IndexMethod(){

	}
	public function TestMethod(){
		echo '1';
		//echo 'asdasd';
		$this->rendered->ad='TEST';
		$this->rendered->array=array('crrr','sadasd','wrwerwer');
		$this->rendered->array2=array('vvv','xxx','cccc');
		$this->rendered->array3=array('1','2','3');
		echo 'adadad';
		//Dadiweb_Aides_Debug::show($this->rendered->ad);
	}
}