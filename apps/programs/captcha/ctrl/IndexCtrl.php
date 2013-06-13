<?php

class Captcha_IndexCtrl extends Apps_Programs_Kernel
{
    public function IndexMethod(){
        Dadiweb_Widening_Security_Captcha::getInstance()->getCaptcha();
    }
}
