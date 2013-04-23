<?php
class Test_TestCtrl extends Apps_Programs_Kernel
{
	public function IndexMethod(){
		echo 'popal Test_TestCtrl IndexMethod';
		$this->rendered->ad='TEST';
		$this->rendered->array=array('crrr','sadasd','wrwerwer');
		$this->rendered->array2=array('vvv','xxx','cccc');
		$this->rendered->array3=array('1','2','3');
	}
	public function TestMethod(){
		echo 'popal ddd';
		$this->rendered->ad=$this->strings->generic;
		$this->rendered->array=array('crrr','sadasd','wrwerwer');
		$this->rendered->array2=array('vvv','xxx','cccc');
		$this->rendered->array3=array('1','2','3');
		//Dadiweb_Aides_Debug::show($this->rendered->ad);
	}
}