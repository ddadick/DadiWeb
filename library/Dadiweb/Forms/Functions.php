<?php
class Dadiweb_Forms_Functions
{
    /**
     * Default parameter 'name' for form.
     * 
     * @var string
     */
    CONST NAME_DEFAULT = 'name_default';
    
    /**
     * Default parameter 'action' for form.
     *
     * @var string
     */
    CONST ACTION_DEFAULT = '/';
    
    /**
     * Default parameter 'enctype' for form.
     *
     * @var string
     */
    CONST ENCTYPE_DEFAULT = 'application/x-www-form-urlencoded';
    
    /**
     * Default parameter 'method' for form.
     *
     * @var array
     */
    protected $_method_default = array('post','get');
    
    /**
     * Set action for form.
     * 
     * @var string|null
     */
    protected $_action = NULL;
    
    /**
     * Set name for form.
     *
     * @var string|null
     */
    protected $_name = NULL;
    
    /**
     * Set id for form.
     *
     * @var string|null
     */
    protected $_id = NULL;
    
    /**
     * Set class for form.
     *
     * @var string|null
     */
    protected $_class = NULL;
    
    /**
     * Set method for form.
     *
     * @var string|null
     */
    protected $_method = NULL;
    
    /**
     * Set enctype for form.
     *
     * @var string|null
     */
    protected $_enctype = NULL;
    
    /**
     * Set elements of form.
     *
     * @var array
     */
    protected $_elements = array();
    
    /**
     * List of non-valid form elements.
     *
     * @var array
     */
    protected $_non_valid_elements = array();
    
    /**
     * List of valid form elements.
     *
     * @var array
     */
    protected $_valid_elements = array();
    
/***************************************************************/
    /**
     * Return parameter of form.
     * 
     * @param string|null $_search
     * @param mixed $return
     * @return mixed
     */
    public function getFormParam($_search=NULL,$return=NULL){
        if(
            $_search!==NULL &&
            is_string($_search) &&
            strlen(trim($_search)) &&
            NULL!==$this->{$_search}
        ){
            return $this->{$_search};
        }
        return ($return!==NULL)?$return:NULL;
    }
    
/***************************************************************/
    /**
     * Set action for form.
     * 
     * @param string|null $_action
     * @return string
     */
    public function setFormAction($_action=NULL){
        return $this->_action = (
            (
                $_action!==NULL &&
                is_string($_action) &&
                strlen(trim($_action))
            )
            ?$_action
            :(self::ACTION_DEFAULT)
        );
    }
    
/***************************************************************/
    /**
     * Get action for form.
     * 
     * @return string
     */
    protected function getFormAction(){
        return (
            (
                $this->_action!==NULL &&
                is_string($this->_action) &&
                strlen(trim($this->_action))
            )
            ?$this->_action
            :$this->setFormAction()
        );
    }
    
/***************************************************************/
    /**
     * Set name for form.
     * 
     * @param string|null $_name
     * @return string
     */
    public function setFormName($_name=NULL){
        return $this->_name = (
            (
                $_name!==NULL &&
                is_string($_name) &&
                strlen(trim($_name))
            )
            ?$_name
            :(self::NAME_DEFAULT)
        );
    }
    
/***************************************************************/
    /**
     * Get name for form.
     *
     * @return string
     */
    protected function getFormName(){
        return (
            (
                $this->_name!==NULL &&
                is_string($this->_name) &&
                strlen(trim($this->_name))
            )
            ?$this->_name
            :$this->setFormName()
        );
    }
/***************************************************************/
    /**
     * Set id for form.
     * 
     * @param string|null $_id
     * @return string
     */
    public function setFormId($_id=NULL){
        return $this->_id = (
            (
                $_id!==NULL &&
                is_string($_id) &&
                strlen(trim($_id))
            )
            ?$_id
            :($this->getFormName().'_'.self::NAME_DEFAULT)
        );
    }
    
/***************************************************************/
    /**
     * Get id for form.
     *
     * @return string
     */
    protected function getFormId(){
        return (
            (
                $this->_id!==NULL &&
                is_string($this->_id) &&
                strlen(trim($this->_id))
            )
            ?$this->_id
            :$this->setFormId()
        );
    }
    
/***************************************************************/
    /**
     * Set class for form.
     * 
     * @param string|null $_class
     * @return string
     */
    public function setFormClass($_class=NULL){
        return $this->_class = (
            (
                $_class!==NULL &&
                is_string($_class) &&
                strlen(trim($_class))
            )
            ?$_class
            :($this->getFormName().'_'.self::NAME_DEFAULT)
        );
    }
    
/***************************************************************/
    /**
     * Get class for form.
     *
     * @return string
     */
    protected function getFormClass(){
        return (
            (
                $this->_class!==NULL &&
                is_string($this->_class) &&
                strlen(trim($this->_class))
            )
            ?$this->_class
            :$this->setFormClass()
        );
    }
    
/***************************************************************/
    /**
     * Set method for form.
     * 
     * @param boolean $_method
     * @return string
     */
    public function setFormMethod($_method=false){
        return $this->_method = (
            (is_bool($_method))
            ?$this->_method_default[(int)$_method]
            :($this->_method_default[0])
        );
    }
    
/***************************************************************/
    /**
     * Get method for form.
     *
     * @return string
     */ 
    protected function getFormMethod(){
        return $this->_method;
    }
    
/***************************************************************/
    /**
     * Set enctype for form.
     * 
     * @param string|null $_enctype
     * @return string
     */
    public function setFormEnctype($_enctype=NULL){
        return $this->_enctype = (
            (
                $_enctype!==NULL &&
                is_string($_enctype) &&
                strlen(trim($_enctype))
            )
            ?$_enctype
            :(self::ENCTYPE_DEFAULT)
        );
    }
    
/***************************************************************/
    /**
     * Get enctype for form.
     *
     * @return string
     */
    protected function getFormEnctype(){
        return (
            (
                $this->_enctype!==NULL &&
                is_string($this->_enctype) &&
                strlen(trim($this->_enctype))
            )
            ?$this->_enctype
            :$this->setFormEnctype()
        );
    }
    
/***************************************************************/
    /**
     * Open form.
     * 
     * @return string
     */
    public function open(){
        $form=new Dadiweb_Tags_Render_Form();
        return $form->open(
            array(
                'action'=>$this->getFormAction(),
                'name'=>$this->getFormName(),
                'id'=>$this->getFormId(),
                'class'=>$this->getFormClass(),
                'method'=>$this->getFormMethod(),
                'enctype'=>$this->getFormEnctype(),
            )
        );
    }
    
/***************************************************************/
    /**
     * Close form.
     * 
     * @return string
     */
    public function close(){
        $form=new Dadiweb_Tags_Render_Form();
        return $form->close();
    }
    
/***************************************************************/
    /**
     * Label for element of form.
     * 
     * @return string
     */
    public function label($_element=NULL){
        if(
            isset($this->_elements[$_element]) &&
            $this->_elements[$_element] instanceof Dadiweb_Tags_Abstract
        ){
            return $this->_elements[$_element]->label(
                array('name'=>$this->getFormName())
            );
        }else{
            throw Dadiweb_Throw_ErrorException::showThrow(
                sprintf(
                    'Element "%s" is not defined into class "%s"',
                    $_element,
                    get_class($this)
                )
            );
        }
    }
    
/***************************************************************/
    /**
     * Set elemets of form.
     * 
     * @param array $_elements
     * @return void
     */
    public function setElements(array $_elements=array()){
        foreach($_elements as $item){
            if($item instanceof Dadiweb_Tags_Abstract){
                $this->_elements[$item->getName()]=$item;
            }
        }
    }
    
/***************************************************************/
    /**
     * Get elemets of form.
     * 
     * @return array
     */
    protected function getElements(){
        return $this->_elements;
    }
    
/***************************************************************/
    /**
     * Set value for the one element of form.
     * 
     * @param string|null $_name
     * @param string|null $_value
     * @return void
     */
    public function setValue($_name=NULL, $_value=NULL){
        $getElements=self::getElements();
        if(
            $_name !== NULL &&
            isset($getElements[$_name]) &&
            $getElements[$_name] instanceof Dadiweb_Tags_Abstract
        ){
            $this->{$_name}=(
                (isset($_value))
                ?$_value
                :NULL
            );
            $getElements[$_name]->setValue($this->{$_name});
        }
    }
    
/***************************************************************/
    /**
     * Set values of form.
     * 
     * @param array $_values
     * @return void
     */
    public function setValues(array $_values=array()){
        foreach(($getElements=self::getElements()) as $key=>$items){
            $this->{$key}=(
                (isset($_values[self::getFormName()][$key]))
                ?$_values[self::getFormName()][$key]
                :NULL
            );
            $getElementsv[$key]->setValue($this->{$key});
        }
    }
    
/***************************************************************/
    /**
     * Set list of non-valid form elements.
     * 
     * @param Dadiweb_Tags_Abstract|null $_element
     * @return void
     */
    protected function setNonValidElements($_element=NULL){
        if(
            $_element===NULL ||
            $_element instanceof Dadiweb_Tags_Abstract
        ){
            $this->_non_valid_elements[$_element->getName()]=$_element;
        }
    }
    
/***************************************************************/
    /**
     * Get list of non-valid form elements.
     * 
     * @return array|null
     */
    public function getNonValidElements(){
        if(
            isset($this->_non_valid_elements) &&
            is_array($this->_non_valid_elements) &&
            count($this->_non_valid_elements)
        ){
            return $this->_non_valid_elements;
        }
        return NULL;
    }
    
/***************************************************************/
    /**
     * Set list of valid form elements.
     * 
     * @param null|Dadiweb_Tags_Abstract $_element
     * @return void
     */
    protected function setValidElements($_element=NULL){
        if(
            $_element===NULL ||
            $_element instanceof Dadiweb_Tags_Abstract
        ){
            $this->_valid_elements[$_element->getName()]=$_element;
        }
    }
    
/***************************************************************/
    /**
     * Get list of valid form elements.
     * 
     * @return array|null
     */
    public function getValidElements(){
        if(
            isset($this->_valid_elements) &&
            is_array($this->_valid_elements) &&
            count($this->_valid_elements)
        ){
            return $this->_valid_elements;
        }
        return NULL;
    }
    
/***************************************************************/
    /**
     * Get list of validation of forms.
     * 
     * @param boolean|null $_list_validation
     * @return array|null
     */
    public function listValidation($_list_validation=NULL){
        if(NULL===$_list_validation){
            $array=NULL;
            if(NULL!==($result=self::getValidElements())){
                $array['valid']=$result;
            }else{
                $array['valid']=NULL;
            }
            if(NULL!==($result=self::getNonValidElements())){
                $array['non_valid']=$result;
            }else{
                $array['non_valid']=NULL;
            }
            return $array;
        }elseif(
            (
                is_string($_list_validation) &&
                strlen(trim($_list_validation))
            ) ||
            (
                is_bool($_list_validation) &&
                TRUE === $_list_validation
            )
        ){
            return self::getValidElements();
        }elseif(
            (
                is_string($_list_validation) &&
                !strlen(trim($_list_validation))
            ) ||
            (
                is_bool($_list_validation) &&
                FALSE === $_list_validation
            )
        ){
            return self::getNonValidElements();
        }
        return NULL;
    }
    
/***************************************************************/
    /**
     * Validation of the form element.
     * 
     * @param Dadiweb_Tags_Abstract $_element
     * @return boolean
     */
    protected function validationElement($_element=NULL){
        $return=TRUE;
        if(
            $_element===NULL ||
            !($_element instanceof Dadiweb_Tags_Abstract)
        ){
            $return = FALSE;
        }
        if(
            $return ===TRUE &&
            NULL!==$_element->getValidators() &&
            is_array($_element->getValidators()) &&
            count($_element->getValidators())
        ){
            
            foreach($_element->getValidators() as $item){
                
                if(FALSE===($result=$item->isValid($this->{$_element->getName()}))){
                    self::setNonValidElements($_element);
                }else{
                    self::setValidElements($_element);
                }
                
                $return=(TRUE===$result && TRUE!==$return)?$return:$result;
            }
        }
        return $return;
    }
    
/***************************************************************/
    /**
     * Validation of the form elements.
     *
     * @return boolean
     */
    public function validationElements(){
        $return=TRUE;
        foreach(self::getElements() as $key=>$items){
            if(
                NULL!==$items->getValidators() &&
                is_array($items->getValidators()) &&
                count($items->getValidators())
            ){
                $result=self::validationElement($items);
                $return=(TRUE===$result && TRUE!==$return)?$return:$result;
            }
        
        }
        return $return;
    }
    
/***************************************************************/
    /**
     * Filtration of the form element.
     * 
     * @param Dadiweb_Tags_Abstract $_element
     * @return boolean
     */
    protected function filtrationElement($_element=NULL){
        $return=TRUE;
        if(
            $_element===NULL ||
            !($_element instanceof Dadiweb_Tags_Abstract)
        ){
            $return = FALSE;
        }
        if(
            $return === TRUE &&
            NULL!==$_element->getFilters() &&
            is_array($_element->getFilters()) &&
            count($_element->getFilters())
        ){
            foreach($_element->getFilters() as $item){
                $this->{$_element->getName()}=$item->getFilter($this->{$_element->getName()});
            }
            $_element->setValue($this->{$_element->getName()});
        }
        return ($return===TRUE)?$this->{$_element->getName()}:FALSE;
    }
    
/***************************************************************/
    /**
     * Filter of the form elements.
     *
     * @return boolean
     */
    public function filtrationElements(){
        foreach(self::getElements() as $key=>$items){
            if(
                NULL!==$items->getFilters() &&
                is_array($items->getFilters()) &&
                count($items->getFilters())
            ){
                self::filtrationElement($items);
            }
        
        }
    }
    
/***************************************************************/
    /**
     * Validator of form.
     * 
     * @param array $_values
     * @return boolean
     */
    public function isValid(array $_values=array()){
        $return=TRUE;
        if(
            count($_values) &&
            isset($_values[self::getFormName()])
        ){
            self::setValues($_values);
            $return=self::validationElements();
            if(TRUE===($return=self::validationElements())){
                self::filtrationElements();
            }
        }else{
            $return = FALSE;
        }
        return $return;
    }
    
/***************************************************************/
    /**
     * Get rendered elemet of form.
     * 
     * @param string|null $_element
     * @return string
     */
    public function element($_element=NULL){
        if(
            isset($this->_elements[$_element]) &&
            $this->_elements[$_element] instanceof Dadiweb_Tags_Abstract
        ){
            return $this->_elements[$_element]->open(
                array('name'=>$this->getFormName())
            );
        }else{
            throw Dadiweb_Throw_ErrorException::showThrow(
                sprintf(
                    'Element "%s" is not defined into class "%s"',
                    $_element,
                    get_class($this)
                )
            );
        }
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
        var_dump('sss');
        if(!method_exists($this, $method)) { 
            throw Dadiweb_Forms_Exception::getInstance()->getMessage(
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