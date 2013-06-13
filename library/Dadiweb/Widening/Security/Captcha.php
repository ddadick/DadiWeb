<?php 
class Dadiweb_Widening_Security_Captcha
{
    /**
     * Singleton instance
     *
     * @var Dadiweb_Widening_Security_Captcha
     */
    protected static $_instance = null;
    
    /**
     * Set of uppercase to captcha
     * 
     * @var string
     */
    protected $_uppercase = 'ABCDEFGHJKLMNOPQRSTUVWXYZ';
    
    /**
     * Set of lowercase to captcha
     *
     * @var string
     */
    protected $_lowercase = 'abcdefghijkmnpqrstuvwxyz';
    
    /**
     * Set of figures to captcha
     *
     * @var string
     */
    protected $_figures = '123456789';
    
    /**
     * Lenth of captcha
     * 
     * @var integer
     */
    protected $_length = 4;

    /**
     * Name CAPTCHA cookie
     * 
     * @var string
     */
    protected $_name_cookie	= 'DADIWEB_CAPTCHA';
    
    /**
     * Random text for captcha
     * 
     * @var NULL|string
     */
    protected $_txt_captcha=NULL;
    
/***************************************************************/
    /**
     * Init Captcha
     * 
     * @param array $options
     */
    protected function __construct($options=array()){
        if (isset($options['uppercase'])) {
            $this->setUppercase($options['uppercase']);
        }else{$this->setUppercase();}
        if (isset($options['lowercase'])) {
            $this->setLowercase($options['lowercase']);
        }else{$this->setLowercase();}
        if (isset($options['figures'])) {
            $this->setFigures($options['figures']);
        }else{$this->setFigures();}
        if (isset($options['length'])) {
            $this->setLength($options['length']);
        }else{$this->setLength();}
        if (isset($options['name_cookie'])) {
            $this->setNameCookie($options['name_cookie']);
        }else{$this->setNameCookie();}
    }
    
/***************************************************************/
	/**
     * Singleton pattern implementation makes "clone" unavailable
     *
     * @return void
     */
    protected function __clone(){}
/***************************************************************/
    /**
     * Returns an instance of Dadiweb_Widening_Security_Captcha
     * Singleton pattern implementation
     *
     * @return Dadiweb_Widening_Security_Captcha Provides a fluent interface
     */
    public static function getInstance()
    {
    	if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
/***************************************************************/
    /**
     * Set of uppercase for captchas
     * 
     * @param string $_uppercase
     * @return string
     */
    protected function setUppercase($_uppercase='ABCDEFGHJKLMNOPQRSTUVWXYZ')
    {
        return $this->_uppercase=(is_string($_uppercase) && strlen(trim($_uppercase)))?$_uppercase:'ABCDEFGHJKLMNOPQRSTUVWXYZ';
    }
    
/***************************************************************/
    /**
     * Get of uppercase for captchas
     *
     * @return string
     */
    protected function getUppercase()
    {
        if(
            $this->_uppercase===NULL ||
            !is_string($this->_uppercase) ||
            (is_string($this->_uppercase) && !strlen(trim($this->_uppercase)))
        ){
            $this->setUppercase();
        }
        return $this->_uppercase;
    }
    
/***************************************************************/
    /**
     * Set of lowercase for captchas
     *
     * @param string $_lowercase
     * @return string
     */
    protected function setLowercase($_lowercase='abcdefghijkmnpqrstuvwxyz')
    {
        return $this->_lowercase=(is_string($_lowercase) && strlen(trim($_lowercase)))?$_lowercase:'abcdefghijkmnpqrstuvwxyz';
    }
    
/***************************************************************/
    /**
     * Get of lowercase for captchas
     *
     * @return string
     */
    protected function getLowercase()
    {
        if(
            $this->_lowercase===NULL ||
            !is_string($this->_lowercase) ||
            (is_string($this->_lowercase) && !strlen(trim($this->_lowercase)))
        ){
            $this->setLowercase();
        }
        return $this->_lowercase;
    }
    
/***************************************************************/
    /**
     * Set of figures for captchas
     *
     * @param string $_figures
     * @return string
     */
    protected function setFigures($_figures='123456789')
    {
        return $this->_figures=(is_string($_figures) && strlen(trim($_figures)))?$_figures:'123456789';
    }
    
/***************************************************************/
    /**
     * Get of figures for captchas
     *
     * @return string
     */
    protected function getFigures()
    {
        if(
            $this->_figures===NULL ||
            !is_string($this->_figures) ||
            (is_string($this->_figures) && !strlen(trim($this->_figures)))
        ){
            $this->setFigures();
        }
        return $this->_figures;
    }
    
/***************************************************************/
    /**
     * Set of length for captchas
     *
     * @param integer $_length
     * @return integer
     */
    protected function setLength($_length=4)
    {
        return $this->_length=(is_int($_length) && $_length>0)?$_length:4;
    }
    
/***************************************************************/
    /**
     * Get of length for captchas
     *
     * @return integer
     */
    protected function getLength()
    {
        if(
            $this->_length===NULL ||
            !is_int($this->_length) ||
            (is_int($this->_length) && $this->_length<=0)
        ){
            $this->setLength();
        }
        return $this->_length;
    }
    
/***************************************************************/
    /**
     * Set name of security cookie for captchas
     *
     * @param string $_name_cookie
     * @return string
     */
    protected function setNameCookie($_name_cookie='DADIWEB_CAPTCHA')
    {
        return $this->_name_cookie=(is_string($_name_cookie) && strlen(trim($_name_cookie)))?$_name_cookie:'DADIWEB_CAPTCHA';
    }
    
/***************************************************************/
    /**
     * Get name of security cookie for captchas
     *
     * @return string
     */
    public function getNameCookie()
    {
        if(
            $this->_name_cookie===NULL ||
            !is_string($this->_name_cookie) ||
            (is_string($this->_name_cookie) && !strlen(trim($this->_name_cookie)))
        ){
            $this->setNameCookie();
        }
        return $this->_name_cookie;
    }
    
/***************************************************************/
    /**
     * Set of random string for captcha
     * 
     * @return string
     */
    protected function setTxtCaptcha(){
        $text = $this->getUppercase();
        $text .= $this->getLowercase();
        $text .= $this->getFigures();
        $random_id='';
        $array_t=array();
        for( $i = 1; $i <= 4; $i++ ){
            $random_id = $random_id.$text{mt_rand(0,strlen($text) - 1)};
        }
        $text = rtrim($random_id);
        $this->_txt_captcha=$text;
    }
    
/***************************************************************/
    /**
     * Get of random string for captcha
     *
     * @return string
     */
    protected function getTxtCaptcha(){
        if(
            $this->_txt_captcha===NULL ||
            !is_string($this->_txt_captcha) ||
            (is_string($this->_txt_captcha) && !strlen(trim($this->_txt_captcha)))
        ){
            $this->setTxtCaptcha();
        }
        return $this->_txt_captcha;
    }
    
/***************************************************************/
    /**
     * Generator of security cookies for captcha
     * 
     * @return void
     */
    protected function setCookie(){
        Dadiweb_Http_Client::getInstance()->setCookies(
            array(
                'name'=>$this->getNameCookie(),
                'value'=>md5(
                    ip2long(Dadiweb_Http_Client::getInstance()->getRealIp())*
                    crc32(strtolower($this->getTxtCaptcha()))
                )
            )
        );
    }

/***************************************************************/
    /**
     * Validator for captcha
     * 
     * @param string|null $_testcase
     * @return boolean
     */
    public function getValidator($_testcase=NULL){
        if(
            $_testcase===NULL ||
            !is_string($_testcase) ||
            (is_string($_testcase) && !strlen($_testcase))
        ){
            return false;
        }
        return (
            md5(
                ip2long(Dadiweb_Http_Client::getInstance()->getRealIp())*crc32(strtolower($_testcase))
            )===Dadiweb_Http_Client::getInstance()->getCookies($this->getNameCookie())
        );
    }
    
/***************************************************************/
    /**
     * Generator of captcha
     *
     * @return void
     */
    public function getCaptcha(){
        $this->setTxtCaptcha();
        $this->setCookie();
        $image = new Imagick();
        $draw = new ImagickDraw();
        $background = new ImagickPixel('transparent');
        $image->newImage(80, 48, $background);
        $draw->setFont('Arial');
        $draw->setFontSize(30);
        for ($i = 1; $i <= strlen($this->getTxtCaptcha()); $i++) {
            $r_st = substr($this->getTxtCaptcha(),($i-1),1);
            $angle_mod = rand(5,8);
            $angle_polar = rand(0,1);
            if ($angle_polar == 1) {
                $angle = $angle_mod;
            }
            else {
                $angle = '-'.$angle_mod;
            }
            $textColor = '#'.sprintf("%02X", round(rand(30,200))).sprintf("%02X", round(rand(10,255))).sprintf("%02X", round(rand(10,255)));
            $textColor = new ImagickPixel($textColor);
            $draw->setFillColor($textColor);
            $image->annotateImage($draw, (((int)(68/4)*$i)-(100/2)), (int)(48/4), $angle, $r_st);
        }
        $image->setImageFormat('png');
        $image->drawImage($draw);
        $image->implodeImage (round(rand(5,6))/18);
        Dadiweb_Http_Client::getInstance()->setHeadersResponse('Content-Type: image/png');
        echo $image;
    }
    
/***************************************************************/
    /**
     * 
     * The handler functions that do not exist
     * 
     * @return Exeption, default - NULL
     * 
     */
	public function __call($method, $args) 
    {
    	if(!method_exists($this, $method)) { 
    		throw Dadiweb_Throw_ErrorException::showThrow(sprintf('The required method "%s" does not exist for %s', $method, get_class($this))); 
       	} 	
    }	
/***************************************************************/
}