<?php

class Dadiweb_Validator_Captcha extends Dadiweb_Validator_Abstract
{
    public function isValid($_string=NULL){
        return Dadiweb_Widening_Security_Captcha::getInstance()
                    ->getValidator($_string);
    }
}