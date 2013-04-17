<?php 
class Dadiweb_Widening_Xml_Reader
{
		
	/**
	 * Set content of the XML from XML-file
	 *
	 * @var Object()
	 */
	protected $_content	=	NULL;
	
	/**
	 * Get content from XML
	 *
	 * @var Array()
	 */
	protected $_return	=	NULL;
	
/***************************************************************/
	public function __construct($option=array()){
		$option=Dadiweb_Aides_Array::getInstance()->array_AllKeysToLowerCase($option);
		if(!is_array($option) && !isset($option['content'])){
			throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Critical error. Variable $option["content"] was not transmitted in class "%s"', get_class($this)));
		}
		if(!is_file($option['content'])){
			throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Critical error. Filename "%s" from variable $option["content"] in class "%s" is not valid', $option['content'], get_class($this)));
		}
		$this->_content=@simplexml_load_file($option['content']);	 
	}
/***************************************************************/
	
	/**
	 * Returns XML Content
	 *
	 * @var Content from XML
	 * @return Array()
	 */
	public function getResult()
	{
		self::getXML($this->_content);
		return $this->_return;
	}
	
/***************************************************************/
	
	/**
	 * Returns XML Content
	 *
	 * @var SimpleXMLElement()
	 * @return Array()
	 */
	protected function getXML($_content=''){
		if($_content instanceof SimpleXMLElement){
   			if(count($_content->children())){
   				foreach($_content->children() as $key=>$item){
   					if(!is_array($this->_return)){
   						$this->_return=array();
   					}
   					if($item instanceof SimpleXMLElement){
   						$this->_return[$key]=self::getXML($item);
   					}else{
   						$this->_return[$key]=$item;
   					}
   				}
   			}
   		}
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