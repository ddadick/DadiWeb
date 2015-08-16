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
		return $this->_return=Dadiweb_Aides_Array::getInstance()->arr2obj(self::getXML($this->_content));
	}
	
/***************************************************************/
	
	/**
	 * Returns XML Content
	 *
	 * @var SimpleXMLElement()
	 * @return Array()
	 */
	protected function getXML($_content=NULL){
		$test=array();
		if($_content instanceof SimpleXMLElement && count($_content->children())){
			foreach($_content->children() as $key=>$item){
				if($item instanceof SimpleXMLElement){
					$test[$key]=self::getXML($item);
				}
			}
   		}else{
   			return preg_replace("/\[CDATA\](.*?)\[\/CDATA\]/is", "base64_decode('$1')", $_content);
   		}
   		return $test;
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