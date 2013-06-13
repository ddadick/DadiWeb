<?php
class Dadiweb_Http_Client
{
    /**
     * Singleton instance.
     * 
     * @var null|Dadiweb_Http_Client
     */
    protected static $_instance = null;
    
    /**
     * Body of response.
     *
     * @var string|null
     */
    protected $_body = NULL;
    
/***************************************************************/
	/**
     * Singleton pattern implementation makes "new" unavailable.
     *
     * @return void
     */
    protected function __construct(){}
    
/***************************************************************/
    /**
     * Singleton pattern implementation makes "clone" unavailable.
     *
     * @return void
     */
    protected function __clone(){}
    
/***************************************************************/
    /**
     * Returns an instance of Dadiweb_Uri_Http.
     * Singleton pattern implementation.
     *
     * @return Dadiweb_Uri_Http
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
     * Return Url.
     * 
     * @return string
     */
    public function getUri(){
        return $_SERVER["REQUEST_URI"];
    }
    
/***************************************************************/
    /**
     * jQuery detector, return True(only use Javascript framework), False(in other cases).
     * 
     * @return bool
     */
    public function isXHR(){
        if(isset($_SERVER["HTTP_X_REQUESTED_WITH"])){
            return true;
        }
        return false;
    }
    
/***************************************************************/
    /**
     * Get real ip.
     * 
     * @return string
     */
    function getRealIp() {
        if(
            isset($_SERVER['HTTP_X_FORWARDED_FOR']) &&
            !empty($_SERVER['HTTP_X_FORWARDED_FOR'])
        ){
            if(false!==ip2long($_SERVER['HTTP_X_FORWARDED_FOR'])){
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            foreach(explode(',',$_SERVER['HTTP_X_FORWARDED_FOR']) as $ip){
                $ip=trim($ip);
                if (false!==ip2long($ip)){
                    return $ip;
                }
            }
        }
        return $_SERVER['REMOTE_ADDR'];
    }
    
/***************************************************************/
    /**
     * Set cookies.
     * Description keys of the array $_cookies:
     * - string    'name'     => name of cookie
     * - string    'value'    => values of cookie
     * - integer   'expire'   => duration of the cookie in seconds
     * - string    'path'     => path to the directory on the server
     *                           from which the cookie will be available
     * - string    'domain'   => domain that are available cookie
     * - boolean   'secure'   => indicates that the cookie should be transferred
     *                           from the client via a secure HTTPS connection
     * - boolean   'httponly' => if set to TRUE, cookie will only be available
     *                           via the HTTP protocol(PHP 5.2.0+)
     * 
     * @param array $_cookies
     * @return boolean
     */
    public function setCookies(array $_cookies=NULL){
        if($_cookies===NULL){return false;}
        if(count($_cookies)){
            $_cookies=Dadiweb_Aides_Array::getInstance()->arr2obj($_cookies);
            if(
                !isset($_cookies->name) ||
                !is_string($_cookies->name) ||
                empty($_cookies->name) ||
                NULL===$_cookies->name
            ){
                throw Dadiweb_Throw_ErrorException::showThrow(
                    sprintf(
                        'Critical error. Parameter "name" of cookie is not '.
                        'passed or not string to the method "%s". '.
                        'Cookie has not been created.',
                        __METHOD__
                    )
                );
            }
            $name=$_cookies->name;
            $value=(
                (
                    isset($_cookies->value) &&
                    is_string($_cookies->value) &&
                    strlen(trim($_cookies->value))
                )
                ?$_cookies->value
                :''
            );
            $expire=(
                (
                    isset($_cookies->expire) &&
                    is_int($_cookies->expire)
                )
                ?$_cookies->expire
                :0
            );
            $path=(
                (
                    isset($_cookies->path) &&
                    is_string($_cookies->path) &&
                    strlen(trim($_cookies->path))
                )
                ?$_cookies->path
                :''
            );
            $domain=(
                (
                    isset($_cookies->domain) &&
                    is_string($_cookies->domain) &&
                    strlen(trim($_cookies->domain))
                )
                ?$_cookies->domain
                :''
            );
            $secure=(
                (
                    isset($_cookies->secure) &&
                    is_bool($_cookies->secure)
                )
                ?$_cookies->secure
                :false
            );
            $httponly=(
                (
                    isset($_cookies->httponly) &&
                    is_bool($_cookies->httponly)
                )
                ?$_cookies->httponly
                :false
            );
            if(false===setcookie($name,$value,$expire,$path,$domain,$secure,$httponly)){
                throw Dadiweb_Throw_ErrorException::showThrow(
                    sprintf(
                        'Critical error. Cookies are not working - see "%s".',
                        __METHOD__
                    )
                );
            }
        }
        return true;
    }
    
/***************************************************************/
    /**
     * Get cookies.
     * 
     * @param string|array $search
     * @return stdClass
     */
    public function getCookies($search=NULL){
        if(
            $search!==NULL &&
            is_string($search) &&
            strlen(trim($search))
        ){
            return (isset($_COOKIE[$search]))?$_COOKIE[$search]:NULL;
        }elseif(
            $search!==NULL &&
            is_array($search) &&
            count($search)
        ){
            $array=array();
            foreach($search as $items){
                array_push($array, ((isset($_COOKIE[$search]))?$_COOKIE[$search]:NULL));
            }
            return Dadiweb_Aides_Array::getInstance()->arr2obj($array);
        }
        return (isset($_COOKIE))?Dadiweb_Aides_Array::getInstance()->arr2obj($_COOKIE):NULL;
    }
    
/***************************************************************/
    /**
     * Get headers response.
     * 
     * @param string|array $search
     * @return string|stdClass|null
     */
    public function getHeadersResponse($search=NULL){
        if($search!==NULL && is_string($search) && strlen(trim($search))){
            foreach(headers_list() as $item){
                $item=explode(':', $item);
                if(trim($item[0])==$search){
                    return $item[1];
                }
            }
        }elseif($search!==NULL && is_array($search) && count($search)){
            $array=array();
            foreach($search as $items){
                foreach(headers_list() as $item){
                    $item=explode(':', $item);
                    if(trim($item[0])==$items){
                        $array[trim($item[0])]=trim($item[1]);
                    }
                }
            }
            return (count($array))?Dadiweb_Aides_Array::getInstance()->arr2obj($array):NULL;
        }elseif($search===NULL){
            $array=array();
            foreach(headers_list() as $item){
                $item=explode(':', $item);
                $array[trim($item[0])]=trim($item[1]);
            }
            return (count($array))?Dadiweb_Aides_Array::getInstance()->arr2obj($array):NULL;
        }
        return NULL;
    }
    
/***************************************************************/
    /**
     * Set headers of response.
     * 
     * @param string|array $search
     * @return boolean
     */
    public function setHeadersResponse($search=NULL){
        if(!headers_sent()){
            if(
                $search!==NULL &&
                is_string($search) &&
                strlen(trim($search))
            ){
                if(
                    count($test=explode(':', $search))==2 &&
                    strlen(trim($test[1]))
                ){
                    header($search);
                    return TRUE;
                }
                return false;
            }elseif(
                $search!==NULL &&
                is_array($search) &&
                count($search)
            ){
                $i=0;
                foreach($search as $key=>$items){
                    if(
                        is_string($items) &&
                        count($test=explode(':', $items))==2 &&
                        strlen(trim($test[1]))
                    ){
                        header($items);
                        $i++;
                    }elseif(
                        is_array($items) &&
                        count($items)==2 &&
                        strlen(trim($items[1]))
                    ){
                        header($items[0]." : ".$items[1]);
                        $i++;
                    }elseif(
                        is_string($items) &&
                        strlen(trim($key)) &&
                        strlen(trim($items))
                    ){
                        header($key." : ".$items);
                        $i++;
                    }
                }
                return ($i==count($search))?TRUE:FALSE;
            }
        }
        return FALSE;
    }
    
/***************************************************************/
    /**
     * Remove headers of response.
     * 
     * @param string|array|null $search
     * @return boolean
     */
    public function removeHeadersResponse($search=NULL){
        if(
            $search!==NULL &&
            is_string($search) &&
            strlen(trim($search))
        ){
            if(NULL!==self::getHeadersResponse($search)){
                header_remove($search);
                return TRUE;
            }
        }elseif(
            $search!==NULL &&
            is_array($search) &&
            count($search)
        ){
            $i=0;
            foreach($search as $item){
                if(is_string($item) && strlen(trim($item))){
                    header_remove($search);
                    $i++;
                }elseif(is_array($item) && count($item)){
                    self::removeHeadersResponse($item);
                    $i++;
                }
            }
            return ($i==count($search))?TRUE:FALSE;
        }
        header_remove();
        return TRUE;
    }
    
/***************************************************************/
    /**
     * Set body of response.
     * 
     * @param string|null $_body
     * @return boolean
     */
    public function setBody($_body=NULL){
        if(
            $_body!==NULL &&
            is_string($_body) &&
            strlen(trim($_body))
        ){
            $this->_body=$_body;
            return TRUE;
        }
        return FALSE;
    }
    
/***************************************************************/
    /**
     * Get body of response.
     * 
     * @return string|null
     */
    protected function getBody(){
        return $this->_body;
    }
    
/***************************************************************/
    /**
     * Get body of response.
     * 
     * @return string|null
     */
    public function sendResponse($_send=FALSE){
        if(is_bool($_send) && $_send===TRUE){
            self::setHeadersResponse(array('X-Generated-By'=>'DadiWeb'));
            echo $this->_body;
            return TRUE;
        }
        if($this->_body!==NULL){
            return $this->_body;
        }
        return NULL;
    }
    
/***************************************************************/
    /**
     * Recognizes the POST method.
     * 
     * @return boolean
     */
    public function isPost(){
        return ($_SERVER["REQUEST_METHOD"]=='POST')?TRUE:FALSE;
    }
    
/***************************************************************/
    /**
     * Recognizes the GET method.
     * 
     * @return boolean
     */
    public function isGet(){
        return ($_SERVER["REQUEST_METHOD"]=='GET')?TRUE:FALSE;
    }
    
/***************************************************************/
    /**
     * Recognizes the PUT method.
     * 
     * @return boolean
     */
    public function isPut(){
        return ($_SERVER["REQUEST_METHOD"]=='PUT')?TRUE:FALSE;
    }
    
/***************************************************************/
    /**
     * Recognizes the DELETE method.
     * 
     * @return boolean
     */
    public function isDelete(){
        return ($_SERVER["REQUEST_METHOD"]=='DELETE')?TRUE:FALSE;
    }
    
/***************************************************************/
    /**
     * Recognizes the HEAD method.
     * 
     * @return boolean
     */
    public function isHead(){
        return ($_SERVER["REQUEST_METHOD"]=='HEAD')?TRUE:FALSE;
    }
    
/***************************************************************/
    /**
     * Recognizes the OPTIONS method.
     * 
     * @return boolean
     */
    public function isOptions(){
        return ($_SERVER["REQUEST_METHOD"]=='OPTIONS')?TRUE:FALSE;
    }
    
/***************************************************************/
    /**
     * Recognizes the PATCH method.
     * 
     * @return boolean
     */
    public function isPatch(){
        return ($_SERVER["REQUEST_METHOD"]=='PATCH')?TRUE:FALSE;
    }
    
/***************************************************************/
    /**
     * Recognizes the TRACE method.
     * 
     * @return boolean
     */
    public function isTrace(){
        return ($_SERVER["REQUEST_METHOD"]=='TRACE')?TRUE:FALSE;
    }
    
/***************************************************************/
    /**
     * Recognizes the LINK method.
     * 
     * @return boolean
     */
    public function isLink(){
        return ($_SERVER["REQUEST_METHOD"]=='LINK')?TRUE:FALSE;
    }
    
/***************************************************************/
    /**
     * Recognizes the UNLINK method.
     * 
     * @return boolean
     */
    public function isUnlink(){
        return ($_SERVER["REQUEST_METHOD"]=='UNLINK')?TRUE:FALSE;
    }
    
/***************************************************************/
    /**
     * Recognizes the CONNECT method.
     * 
     * @return boolean
     */
    public function isConnect(){
        return ($_SERVER["REQUEST_METHOD"]=='CONNECT')?TRUE:FALSE;
    }
    
/***************************************************************/
    /**
     * Recognizes the REQUEST method.
     * 
     * @return string|null
     */
    public function isRequest(){
        return (isset($_SERVER["REQUEST_METHOD"]))?$_SERVER["REQUEST_METHOD"]:NULL;
    }
    
/***************************************************************/
    /**
     * Get params of POST method.
     * 
     * @return array|null
     */
    public function getPost(){
        return (true===self::isPost())?$_POST:NULL;
    }
    
/***************************************************************/
    /**
     * Get params of GET method.
     * 
     * @return array|null
     */
    public function getQuery(){
        return (true===self::isGet())?$_GET:NULL;
    }
    
/***************************************************************/
    /**
     * Get params of PUT method.
     * 
     * @return mixed
     */
    public function getPut(){
        return (true===self::isPut())?file_get_contents('php://input'):NULL;
    }
    
/***************************************************************/
    /**
     * Get params of DELETE method.
     * 
     * @return mixed
     */
    public function getDelete(){
        return (true===self::isDelete())?file_get_contents('php://input'):NULL;
    }
    
/***************************************************************/
    /**
     * Get params of HEAD method.
     * 
     * @return mixed
     */
    public function getHead(){
        return (true===self::isHead() && isset($_GET))?$_GET:NULL;
    }
    
/***************************************************************/
    /**
     * Get params of OPTIONS method.
     * 
     * @return mixed
     */
    public function getOptions(){
        return (
            (true===self::isOptions())
            ?(
                array(
                    "CONTENT_LENGTH"          =>$_SERVER["CONTENT_LENGTH"],
                    "HTTP_ACCEPT_ENCODING"    =>$_SERVER["HTTP_ACCEPT_ENCODING"],
                    "HTTP_ACCEPT_LANGUAGE"    =>$_SERVER["HTTP_ACCEPT_LANGUAGE"],
                    "CONTENT_TYPE"            =>$_SERVER["CONTENT_TYPE"],
                    "SERVER_PROTOCOL"         =>$_SERVER["SERVER_PROTOCOL"],
                    "REQUEST_URI"             =>$_SERVER["REQUEST_URI"],
                )
            )
            :NULL
        );
    }
    
/***************************************************************/
    /**
     * Get params of PATCH method.
     * 
     * @return mixed
     */
    public function getPatch(){
        return (true===self::isPatch())?file_get_contents('php://input'):NULL;
    }
    
/***************************************************************/
    /**
     * Get params of TRACE method.
     * 
     * @return mixed
     */
    public function getTrace(){
        return (
            (true===self::isTrace())
            ?(
                array(
                    "GET"     => self::getQuery(),
                    "POST"    => self::getPost(),
                    "FILES"   => $_FILES,
                    "COOKIE"  => self::getCookies(),
                    "REQUEST" => $_REQUEST,
                )
            )
            :NULL
        );
    }
    
/***************************************************************/
    /**
     * Get params of LINK method.
     * 
     * @return mixed
     */
    public function getLink(){
        return (
            (true===self::isLink())
            ?$_SERVER["REQUEST_URI"]
            :NULL
        );
    }
    
/***************************************************************/
    /**
     * Get params of UNLINK method.
     * 
     * @return mixed
     */
    public function getUnlink(){
        return (
            (true===self::isUnlink())
            ?$_SERVER["REQUEST_URI"]
            :NULL
        );
    }
    
/***************************************************************/
    /**
     * Get params of CONNECT method.
     * 
     * @return mixed
     */
    public function getConnect(){
        return (
            (true===self::isConnect())
            ?(
                array(
                    "GET"     => self::getQuery(),
                    "POST"    => self::getPost(),
                    "FILES"   => $_FILES,
                    "COOKIE"  => self::getCookies(),
                    "REQUEST" => $_REQUEST,
                )
            ):NULL
        );
    }
    
/***************************************************************/
    /**
     * The handler functions that do not exist.
     * 
     * @param string $method
     * @param mixed $args
     * @return void
     */
    public function __call($method, $args)
    {
        if(!method_exists($this, $method)){
            throw new ErrorException(
                sprintf(
                    'The required method "%s" does not exist for %s',
                    $method,
                    get_class($this)
                )
            ); 
        }
    }
    
/***************************************************************/
}