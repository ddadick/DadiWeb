<?php
class Popal2_IndexCtrl extends Apps_Programs_Kernel
{
	public function IndexMethod(){
		//echo 'popal Popal2_IndexCtrl';
		$this->rendered->ad='TEST';
		$this->rendered->ad2='TESTad2';
		$this->rendered->array=array('crrr','sadasd','wrwerwer');
		$this->rendered->array2=array('vvv','xxx','cccc');
		$this->rendered->array3=array('1','2','3');
		$this->useView(true);
		$this->useRendered(true);
		$this->setViewName('list_test');
		$this->setLayoutName('d');
	}
}