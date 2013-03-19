<?php
class Test_TestCtrl extends Apps_Programs_Kernel
{
	public function IndexMethod(){

	}
	public function TestMethod(){
		//$this->useView(false);
		$this->useRendered(true);
		//$this->setViewName('index');
		echo 'abc test test test';
		$this->rendered->ad='TEST';
		$this->rendered->array=array('crrr','sadasd','wrwerwer');
		$this->rendered->array2=array('vvv','xxx','cccc');
		$this->rendered->array3=array('1','2','3');
		//Dadiweb_Aides_Debug::show($this->rendered->ad);
	}
	public function TesttestMethod(){
		echo 'abc popal/*.html '.$this->getParam('test_temp2',NULL);
		$this->rendered->ad='TEST';
		$this->rendered->array=array('crrr','sadasd','wrwerwer');
		$this->rendered->array2=array('vvv','xxx','cccc');
		$this->rendered->array3=array('1','2','3');
		//Dadiweb_Aides_Debug::show($this->rendered->ad);
	}
}