<?php 
class Dadiweb_Widening_Xml_Writer
{
	
	/**
	 * The version number of the document as part of the XML declaration
	 *
	 * @var String()
	 */
	protected $_version	=	'1.0';
	
	/**
	 * The encoding of the document as part of the XML declaration
	 *
	 * @var String()
	 */
	protected $_encode	=	'UTF-8';
	
	/**
	 * The content of the XML
	 *
	 * @var Array()
	 */
	protected $_content	=	NULL;
	
	/**
	 * XML Writer
	 *
	 * @var XMLWriter()
	 */
	protected $_return	=	NULL;
	
/***************************************************************/
	public function __construct($option=array()){
		$option=Dadiweb_Aides_Array::getInstance()->array_AllKeysToLowerCase($option);
		if(!is_array($option) && !isset($option['content']) && !is_array($option['content'])  && !count($option['content'])){
			throw Dadiweb_Throw_ErrorException::showThrow(sprintf('Critical error. Variable $option["content"] was not transmitted in class "%s"', get_class($this)));
		}
		$this->_content=$option['content'];
		$this->_encode=(isset($option['encode']) && is_string($option['encode']))?$option['encode']:$this->_encode;
		$this->_version=(isset($option['version']) && is_string($option['version']))?$option['version']:$this->_version;
		 
		
	}
/***************************************************************/
	
	/**
	 * Returns XML Content
	 *
	 * @var Array()
	 * @return XMLWriter()
	 */
	public function getResult()
	{
		$this->_return = new XMLWriter;
		$this->_return->openMemory();
		$this->_return->startDocument($this->_version, $this->_encode);
		self::getXML($this->_content);
		$this->_return->endDocument();
		$this->_return=$this->_return->outputMemory(TRUE);
		return $this->_return;
	}
	
/***************************************************************/
	
	/**
	 * Returns XML Content
	 *
	 * @var String() or Array()
	 * @return XMLWriter()
	 */
	protected function getXML($_content=''){
		if(is_array($_content)  && count($_content)){
			foreach($_content as $key=>$item){
				$this->_return->startElement($key);
				if(is_array($item)){					
					self::getXML($item);
				}else{
					$this->_return->startCData();
					$this->_return->text($item);
					$this->_return->endCData();
				}
				$this->_return->endElement();
			}
		}else{
			$this->_return->startCData();
			$this->_return->text($_content);
			$this->_return->endCData();
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