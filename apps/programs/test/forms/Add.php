<?php
class Test_Forms_Add extends Dadiweb_Forms_Abstract
{
    public function init(){
        $strings=$this->getFormParam('strings');
        $username=new Dadiweb_Tags_Element_Text('username',
                array(
                        'label'=>$strings->form_add_username,
                        'required'=>true,
                        'maxlength'=>'45'
                )
        );
        $email=new Dadiweb_Tags_Element_Text('email',
                array(
                        'label'=>$strings->form_add_email,
                        'required'=>true,
                        'maxlength'=>'255'
                )
        );
        $homepage=new Dadiweb_Tags_Element_Text('homepage',
            array(
                'label'=>$strings->form_add_homepage,
                'class'=>'test',
                'maxlength'=>'255'
            )
        );
        $captcha=new Dadiweb_Tags_Element_Text('captcha',
            array(
                'required'=>true,
                'maxlength'=>'4'
            )
        );
        $captcha->setValidator(new Dadiweb_Validator_Captcha());
        $text=new Dadiweb_Tags_Element_Textarea('text',
            array(
                'label'=>$strings->form_add_text,
                'id'=>$this->getFormName().'-text',
                'required'=>true
            )
        );
        $submit=new Dadiweb_Tags_Element_Submit('submit',
                array(
                    'value'=>$strings->form_add_submit,
                )
        );
        $this->setElements(array($username,$email,$homepage,$captcha,$text,$submit));
    }
}