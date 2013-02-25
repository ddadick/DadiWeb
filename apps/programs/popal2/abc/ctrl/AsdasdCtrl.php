<?php
class Popal2_AsdasdCtrl extends Apps_Programs_Kernel
{
	public function IndexMethod(){

	}
	public function AsdasdMethod(){
		echo 'popal Popal2_AsdasdCtrl';
		$this->rendered->ad='TEST';
		$this->rendered->array=array('crrr','sadasd','wrwerwer');
		$this->rendered->array2=array('vvv','xxx','cccc');
		$this->rendered->array3=array('1','2','3');
		//Dadiweb_Aides_Debug::show($this->rendered->ad);
	}
	public function EreerMethod(){
		echo 'popal Popal2_EreerMethod';
		$this->rendered->ad='TEST';
		$this->rendered->array=array('crrr','sadasd','wrwerwer');
		$this->rendered->array2=array('vvv','xxx','cccc');
		$this->rendered->array3=array('1','2','3');
		//Dadiweb_Aides_Debug::show($this->rendered->ad);
	}
}