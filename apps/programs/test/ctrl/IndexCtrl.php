<?php

class Test_IndexCtrl extends Apps_Programs_Kernel
{
	public function IndexMethod(){
		Dadiweb_Aides_Debug::show(
		array(
		Dadiweb_Configuration_Routes::getInstance()->getABC(),
		Dadiweb_Configuration_Settings::getInstance()->getABC(),
		Dadiweb_Configuration_Settings::getInstance()->getAppsPath(),
		$this->config,
		'中文'
		)
		,true);
	}
}
