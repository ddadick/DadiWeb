<?php
abstract class Dadiweb_Tags_Abstract
{
    /**
     * Default set variables.
     *
     * @var array
     */
    protected $_variables = array();
    
    /**
     * Name tag.
     *
     * @var string|null
     */
    protected $_name_tag = NULL;
    
    /**
     * Parameter 'name' for tag.
     *
     * @var string|null
     */
    protected $_name = NULL;
    
    /**
     * List of more valid parameters for tag.
     *
     * @var array
     */
    protected $_more_valid_params = array(
        'label', 'id', 'class',
    );
    
    /**
     * List of default valid parameters for tag.
     *
     * @var array
     */
    protected $_default_valid_params = array(
        'accesskey'=>array('a', 'area', 'button', 'input', 'label', 'legend', 'textarea'),
        'contenteditable'=>array(
            'a', 'abbr', 'address', 'area', 'b', 'basefont', 'bdo', 'blockquote', 'body', 'button', 'caption', 'cite', 'code',
            'col', 'colgroup', 'dd', 'del', 'dfn', 'dir', 'div', 'dl', 'dt', 'em', 'fieldset', 'form', 'h1', 'h2', 'h3', 'h4',
            'h5', 'h6', 'i', 'iframe', 'input', 'ins', 'kbd', 'label', 'legend', 'li', 'menu', 'ol', 'option', 'p', 'pre', 'q',
            'samp', 'select', 'span', 'strong', 'sub', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot', 'th', 'thead', 'tr', 'ul', 'var',
        ),
        'contextmenu'=>array(
            'a', 'abbr', 'address', 'area', 'b', 'bdo', 'blockquote', 'body', 'button', 'caption', 'cite', 'code', 'col', 'colgroup',
            'dd', 'del', 'dfn', 'div', 'dl', 'dt', 'em', 'embed', 'fieldset', 'form', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'i', 'iframe',
            'img', 'input', 'ins', 'kbd', 'label', 'legend', 'li', 'map', 'menu', 'ol', 'option', 'p', 'pre', 'q', 's', 'samp', 'select',
            'span', 'strong', 'sub', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot', 'th', 'thead', 'tr', 'ul', 'var',
        ),
        'class'=>array(
            'a', 'abbr', 'acronym', 'address', 'applet', 'area', 'b', 'basefont', 'bdo', 'bgsound', 'big', 'blockquote', 'body', 'br',
            'button', 'caption', 'center', 'cite', 'code', 'col', 'colgroup', 'dd', 'del', 'dfn', 'dir', 'div', 'dl', 'dt', 'em', 'embed',
            'fieldset', 'font', 'form', 'frame', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'hr', 'i', 'iframe', 'img', 'input', 'ins', 'isindex',
            'kbd', 'label', 'legend', 'li', 'link', 'map', 'marquee', 'menu', 'nobr', 'object', 'ol', 'option', 'p', 'plaintext', 'pre', 'q',
            's', 'samp', 'select', 'small', 'span', 'strike', 'strong', 'sub', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot', 'th',
            'thead', 'tr', 'tt', 'u', 'ul', 'var', 'wbr', 'xmp',
        ),
        'dir'=>array(
            'a', 'abbr', 'acronym', 'address', 'applet', 'area', 'b', 'basefont', 'bdo', 'bgsound', 'big', 'blockquote', 'body', 'br', 'button',
            'caption', 'center', 'cite', 'code', 'col', 'colgroup', 'dd', 'del', 'dfn', 'dir', 'div', 'dl', 'dt', 'em', 'embed', 'fieldset',
            'font', 'form', 'frame', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'hr', 'i', 'iframe', 'img', 'input', 'ins', 'isindex', 'kbd', 'label',
            'legend', 'li', 'link', 'map', 'marquee', 'menu', 'nobr', 'object', 'ol', 'option', 'p', 'plaintext', 'pre', 'q', 's', 'samp',
            'select', 'small', 'span', 'strike', 'strong', 'sub', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot', 'th', 'thead', 'tr', 'tt',
            'u', 'ul', 'var', 'wbr', 'xmp',
        ),
        'id'=>array(
            'a', 'abbr', 'acronym', 'address', 'applet', 'area', 'b', 'basefont', 'bdo', 'bgsound', 'big', 'blockquote', 'body', 'br', 'button',
            'caption', 'center', 'cite', 'code', 'col', 'colgroup', 'dd', 'del', 'dfn', 'dir', 'div', 'dl', 'dt', 'em', 'embed', 'fieldset',
            'font', 'form', 'frame', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'hr', 'i', 'iframe', 'img', 'input', 'ins', 'isindex', 'kbd', 'label',
            'legend', 'li', 'link', 'map', 'marquee', 'menu', 'nobr', 'object', 'ol', 'option', 'p', 'plaintext', 'pre', 'q', 's', 'samp',
            'select', 'small', 'span', 'strike', 'strong', 'sub', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot', 'th', 'thead', 'tr', 'tt',
            'u', 'ul', 'var', 'wbr', 'xmp',
        ),
        'hidden'=>array(
            'a', 'abbr', 'address', 'area', 'b', 'bdo', 'big', 'blockquote', 'body', 'button', 'caption', 'cite', 'code', 'col', 'colgroup', 'dd',
            'del', 'dfn', 'div', 'dl', 'dt', 'em', 'embed', 'fieldset', 'form', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'i', 'iframe', 'img', 'input',
            'ins', 'kbd', 'label', 'legend', 'li', 'map', 'menu', 'ol', 'option', 'p', 'pre', 'q', 's', 'samp', 'select', 'span', 'strong', 'sub',
            'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot', 'th', 'thead', 'tr', 'ul', 'var',
        ),
        'lang'=>array(
            'a', 'abbr', 'acronym', 'address', 'applet', 'area', 'b', 'basefont', 'bdo', 'bgsound', 'big', 'blockquote', 'body', 'br', 'button',
            'caption', 'center', 'cite', 'code', 'col', 'colgroup', 'dd', 'del', 'dfn', 'dir', 'div', 'dl', 'dt', 'em', 'embed', 'fieldset',
            'font', 'form', 'frame', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'hr', 'i', 'iframe', 'img', 'input', 'ins', 'isindex', 'kbd', 'label',
            'legend', 'li', 'link', 'map', 'marquee', 'menu', 'nobr', 'object', 'ol', 'option', 'p', 'plaintext', 'pre', 'q', 's', 'samp',
            'select', 'small', 'span', 'strike', 'strong', 'sub', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot', 'th', 'thead', 'tr', 'tt',
            'u', 'ul', 'var', 'wbr', 'xmp',
        ),
        'spellcheck'=>array(
            'a', 'abbr', 'address', 'area', 'b', 'basefont', 'bdo', 'blockquote', 'body', 'button', 'caption', 'cite', 'code',
            'col', 'colgroup', 'dd', 'del', 'dfn', 'dir', 'div', 'dl', 'dt', 'em', 'fieldset', 'form', 'h1', 'h2', 'h3', 'h4',
            'h5', 'h6', 'i', 'iframe', 'input', 'ins', 'kbd', 'label', 'legend', 'li', 'menu', 'ol', 'option', 'p', 'pre', 'q',
            'samp', 'select', 'span', 'strong', 'sub', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot', 'th', 'thead', 'tr', 'ul', 'var',
        ),
        'style'=>array(
            'a', 'abbr', 'acronym', 'address', 'applet', 'area', 'b', 'basefont', 'bdo', 'bgsound', 'big', 'blockquote', 'body', 'br', 'button',
            'caption', 'center', 'cite', 'code', 'col', 'colgroup', 'dd', 'del', 'dfn', 'dir', 'div', 'dl', 'dt', 'em', 'embed', 'fieldset',
            'font', 'form', 'frame', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'hr', 'i', 'iframe', 'img', 'input', 'ins', 'isindex', 'kbd', 'label',
            'legend', 'li', 'link', 'map', 'marquee', 'menu', 'nobr', 'object', 'ol', 'option', 'p', 'plaintext', 'pre', 'q', 's', 'samp',
            'select', 'small', 'span', 'strike', 'strong', 'sub', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot', 'th', 'thead', 'tr', 'tt',
            'u', 'ul', 'var', 'wbr', 'xmp',
        ),
        'tabindex'=>array(
            'a', 'area', 'button', 'input', 'object', 'select', 'textarea',
        ),
        'tabindex'=>array(
                'a', 'area', 'button', 'input', 'object', 'select', 'textarea',
        ),
    );
    
    /**
     * List of default valid actions for tag.
     *
     * @var array
     */
    protected $_default_valid_actions = array(
        'onblur' => array(
            'a', 'abbr', 'acronym', 'address', 'applet', 'area', 'b', 'basefont', 'bdo', 'bgsound', 'big', 'blockquote', 'body', 'br',
            'button', 'caption', 'center', 'cite', 'code', 'col', 'colgroup', 'dd', 'del', 'dfn', 'dir', 'div', 'dl', 'dt', 'em',
            'embed', 'fieldset', 'font', 'form', 'frame', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'hr', 'i', 'iframe', 'img', 'input',
            'ins', 'isindex', 'kbd', 'label', 'legend', 'li', 'link', 'map', 'marquee', 'menu', 'nobr', 'object', 'ol', 'option',
            'p', 'plaintext', 'pre', 'q', 's', 'samp', 'select', 'small', 'span', 'strike', 'strong', 'sub', 'sup', 'table',
            'tbody', 'td', 'textarea', 'tfoot', 'th', 'thead', 'tr', 'tt', 'u', 'ul', 'var', 'wbr', 'xmp',
        ),
        'onchange' => array(
            'input', 'select', 'textarea'
        ),
        'onclick' => array(
            'a', 'abbr', 'acronym', 'address', 'applet', 'area', 'b', 'basefont', 'bdo', 'bgsound', 'big', 'blockquote', 'body', 'br',
            'button', 'caption', 'center', 'cite', 'code', 'col', 'colgroup', 'dd', 'del', 'dfn', 'dir', 'div', 'dl', 'dt', 'em',
            'embed', 'fieldset', 'font', 'form', 'frame', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'hr', 'i', 'iframe', 'img', 'input',
            'ins', 'isindex', 'kbd', 'label', 'legend', 'li', 'link', 'map', 'marquee', 'menu', 'nobr', 'object', 'ol', 'option', 'p',
            'plaintext', 'pre', 'q', 's', 'samp', 'select', 'small', 'span', 'strike', 'strong', 'sub', 'sup', 'table', 'tbody', 'td',
            'textarea', 'tfoot', 'th', 'thead', 'tr', 'tt', 'u', 'ul', 'var', 'wbr', 'xmp',
        ),
        'ondblclick' => array(
            'a', 'abbr', 'acronym', 'address', 'applet', 'area', 'b', 'basefont', 'bdo', 'bgsound', 'big', 'blockquote', 'body', 'br',
            'button', 'caption', 'center', 'cite', 'code', 'col', 'colgroup', 'dd', 'del', 'dfn', 'dir', 'div', 'dl', 'dt', 'em',
            'embed', 'fieldset', 'font', 'form', 'frame', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'hr', 'i', 'iframe', 'img', 'input',
            'ins', 'isindex', 'kbd', 'label', 'legend', 'li', 'link', 'map', 'marquee', 'menu', 'nobr', 'object', 'ol', 'option',
            'p', 'plaintext', 'pre', 'q', 's', 'samp', 'select', 'small', 'span', 'strike', 'strong', 'sub', 'sup', 'table', 'tbody',
            'td', 'textarea', 'tfoot', 'th', 'thead', 'tr', 'tt', 'u', 'ul', 'var', 'wbr', 'xmp',
        ),
        'onfocus' => array(
            'button', 'input', 'label', 'select', 'textarea',
        ),
        'onkeydown' => array(
            'a', 'abbr', 'acronym', 'address', 'applet', 'area', 'b', 'basefont', 'bdo', 'bgsound', 'big', 'blockquote', 'body', 'br',
            'button', 'caption', 'center', 'cite', 'code', 'col', 'colgroup', 'dd', 'del', 'dfn', 'dir', 'div', 'dl', 'dt', 'em', 'embed',
            'fieldset', 'font', 'form', 'frame', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'hr', 'i', 'iframe', 'img', 'input', 'ins', 'isindex',
            'kbd', 'label', 'legend', 'li', 'link', 'map', 'marquee', 'menu', 'nobr', 'object', 'ol', 'option', 'p', 'plaintext', 'pre',
            'q', 's', 'samp', 'select', 'small', 'span', 'strike', 'strong', 'sub', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot',
            'th', 'thead', 'tr', 'tt', 'u', 'ul', 'var', 'wbr', 'xmp',
        ),
        'onkeypress' => array(
            'a', 'abbr', 'acronym', 'address', 'applet', 'area', 'b', 'basefont', 'bdo', 'bgsound', 'big', 'blockquote', 'body', 'br',
            'button', 'caption', 'center', 'cite', 'code', 'col', 'colgroup', 'dd', 'del', 'dfn', 'dir', 'div', 'dl', 'dt', 'em', 'embed',
            'fieldset', 'font', 'form', 'frame', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'hr', 'i', 'iframe', 'img', 'input', 'ins', 'isindex',
            'kbd', 'label', 'legend', 'li', 'link', 'map', 'marquee', 'menu', 'nobr', 'object', 'ol', 'option', 'p', 'plaintext', 'pre',
            'q', 's', 'samp', 'select', 'small', 'span', 'strike', 'strong', 'sub', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot',
            'th', 'thead', 'tr', 'tt', 'u', 'ul', 'var', 'wbr', 'xmp'
        ),
        'onkeyup' => array(
            'a', 'abbr', 'acronym', 'address', 'applet', 'area', 'b', 'basefont', 'bdo', 'bgsound', 'big', 'blockquote', 'body', 'br',
            'button', 'caption', 'center', 'cite', 'code', 'col', 'colgroup', 'dd', 'del', 'dfn', 'dir', 'div', 'dl', 'dt', 'em', 'embed',
            'fieldset', 'font', 'form', 'frame', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'hr', 'i', 'iframe', 'img', 'input', 'ins', 'isindex',
            'kbd', 'label', 'legend', 'li', 'link', 'map', 'marquee', 'menu', 'nobr', 'object', 'ol', 'option', 'p', 'plaintext', 'pre',
            'q', 's', 'samp', 'select', 'small', 'span', 'strike', 'strong', 'sub', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot',
            'th', 'thead', 'tr', 'tt', 'u', 'ul', 'var', 'wbr', 'xmp',
        ),
        'onload' => array(
            'body', 'frameset',
        ),
        'onmousedown' => array(
            'a', 'abbr', 'acronym', 'address', 'applet', 'area', 'b', 'basefont', 'bdo', 'bgsound', 'big', 'blockquote', 'body', 'br',
            'button', 'caption', 'center', 'cite', 'code', 'col', 'colgroup', 'dd', 'del', 'dfn', 'dir', 'div', 'dl', 'dt', 'em', 'embed',
            'fieldset', 'font', 'form', 'frame', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'hr', 'i', 'iframe', 'img', 'input', 'ins', 'isindex',
            'kbd', 'label', 'legend', 'li', 'link', 'map', 'marquee', 'menu', 'nobr', 'object', 'ol', 'option', 'p', 'plaintext', 'pre',
            'q', 's', 'samp', 'select', 'small', 'span', 'strike', 'strong', 'sub', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot',
            'th', 'thead', 'tr', 'tt', 'u', 'ul', 'var', 'wbr', 'xmp',
        ),
        'onmousemove' => array(
            'a', 'abbr', 'acronym', 'address', 'applet', 'area', 'b', 'basefont', 'bdo', 'bgsound', 'big', 'blockquote', 'body', 'br', 'button',
            'caption', 'center', 'cite', 'code', 'col', 'colgroup', 'dd', 'del', 'dfn', 'dir', 'div', 'dl', 'dt', 'em', 'embed', 'fieldset',
            'font', 'form', 'frame', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'hr', 'i', 'iframe', 'img', 'input', 'ins', 'isindex', 'kbd',
            'label', 'legend', 'li', 'link', 'map', 'marquee', 'menu', 'nobr', 'object', 'ol', 'option', 'p', 'plaintext', 'pre', 'q', 's',
            'samp', 'select', 'small', 'span', 'strike', 'strong', 'sub', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot', 'th', 'thead',
            'tr', 'tt', 'u', 'ul', 'var', 'wbr', 'xmp',
        ),
        'onmouseout' => array(
            'a', 'abbr', 'acronym', 'address', 'applet', 'area', 'b', 'basefont', 'bdo', 'bgsound', 'big', 'blockquote', 'body', 'br',
            'button', 'caption', 'center', 'cite', 'code', 'col', 'colgroup', 'dd', 'del', 'dfn', 'dir', 'div', 'dl', 'dt', 'em', 'embed',
            'fieldset', 'font', 'form', 'frame', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'hr', 'i', 'iframe', 'img', 'input', 'ins', 'isindex',
            'kbd', 'label', 'legend', 'li', 'link', 'map', 'marquee', 'menu', 'nobr', 'object', 'ol', 'option', 'p', 'plaintext', 'pre',
            'q', 's', 'samp', 'select', 'small', 'span', 'strike', 'strong', 'sub', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot',
            'th', 'thead', 'tr', 'tt', 'u', 'ul', 'var', 'wbr', 'xmp',
        ),
        'onmouseover' => array(
            'a', 'abbr', 'acronym', 'address', 'applet', 'area', 'b', 'basefont', 'bdo', 'bgsound', 'big', 'blockquote', 'body', 'br',
            'button', 'caption', 'center', 'cite', 'code', 'col', 'colgroup', 'dd', 'del', 'dfn', 'dir', 'div', 'dl', 'dt', 'em', 'embed',
            'fieldset', 'font', 'form', 'frame', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'hr', 'i', 'iframe', 'img', 'input', 'ins', 'isindex',
            'kbd', 'label', 'legend', 'li', 'link', 'map', 'marquee', 'menu', 'nobr', 'object', 'ol', 'option', 'p', 'plaintext', 'pre',
            'q', 's', 'samp', 'select', 'small', 'span', 'strike', 'strong', 'sub', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot',
            'th', 'thead', 'tr', 'tt', 'u', 'ul', 'var', 'wbr', 'xmp',
        ),
        'onmouseup' => array(
            'a', 'abbr', 'acronym', 'address', 'applet', 'area', 'b', 'basefont', 'bdo', 'bgsound', 'big', 'blockquote', 'body', 'br',
            'button', 'caption', 'center', 'cite', 'code', 'col', 'colgroup', 'dd', 'del', 'dfn', 'dir', 'div', 'dl', 'dt', 'em', 'embed',
            'fieldset', 'font', 'form', 'frame', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'hr', 'i', 'iframe', 'img', 'input', 'ins', 'isindex',
            'kbd', 'label', 'legend', 'li', 'link', 'map', 'marquee', 'menu', 'nobr', 'object', 'ol', 'option', 'p', 'plaintext', 'pre',
            'q', 's', 'samp', 'select', 'small', 'span', 'strike', 'strong', 'sub', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot',
            'th', 'thead', 'tr', 'tt', 'u', 'ul', 'var', 'wbr', 'xmp',
        ),
        'onreset' => array(
            'form',
        ),
        'onselect' => array(
            'input', 'textarea',
        ),
        'onsubmit' => array(
            'form',
        ),
        'onunload' => array(
            'body', 'frameset',
        )
    );
    
    /**
     * List of validators.
     * 
     * @var array|null
     */
    protected $_list_validators = NULL;
    
    /**
     * List of filters.
     *
     * @var array|null
     */
    protected $_list_filters = NULL;
    
    /**
     * Value of tag.
     *
     * @var mixed
     */
    protected $value = NULL;
    
/***************************************************************/
    /**
     * Init class of tag.
     * 
     * @param string $_name
     * @param array $_options
     * @return void
     */
    protected function validator($_name=NULL, array $_options=NULL){
        if(
            $_name===NULL ||
            !is_string($_name) ||
            (
                is_string($_name) &&
                !strlen(trim($_name))
            )
        ){
            throw Dadiweb_Throw_ErrorException::showThrow(
                sprintf(
                    'Parameter "Name" was not transmitted into class "%s"',
                    get_class($this)
                )
            );
        }
        $this->{$_name}=new stdClass;
        $this->setName($_name);
        $this->{$this->getName()}->id=$this->_name_tag.'_'.$this->getName();
        $this->{$this->getName()}->class=$this->_name_tag.'_'.$this->getName();
        $this->{$this->getName()}->required=false;
        foreach(Dadiweb_Aides_Array::getInstance()->arr2obj($_options,0) as $key=>$item){
            if(true===$this->validatorParameters($key)){
                $this->{$_name}->{$key}=$item;
            }
        }
    }
    
/***************************************************************/
    /**
     * Default method.
     * 
     * @param string $name
     * @param string $subname
     */
    abstract public function open(array $_options);
    
/***************************************************************/
    /**
     * Default method.
     */
    abstract public function close();
    
/***************************************************************/
    /**
     * Default method.
     */
    abstract public function label();
    
/***************************************************************/
    /**
     * Set name for tag.
     * 
     * @param string $_name
     * @return string
     */
    protected function setName($_name=NULL){
        return $this->_name = (
            (
                $_name!==NULL &&
                is_string($_name) &&
                strlen(trim($_name))
            )
            ?$_name
            :NULL
        );
    }
    
/***************************************************************/
    /**
     * Get name for tag.
     *
     * @return string
     */
    public function getName(){
        return (
            (
                $this->_name!==NULL &&
                is_string($this->_name) &&
                strlen(trim($this->_name))
            )
            ?$this->_name
            :$this->setName()
        );
    }
    
/***************************************************************/
    /**
     * Validates the tag parameters.
     * 
     * @param string|null $_search
     * @return boolean
     */
    public function validatorParameters($_search=NULL){
        $result=false;
        if(
            isset($this->_default_valid_actions) &&
            count($this->_default_valid_actions) &&
            $result===false
        ){
            $result=(
                (false!==array_key_exists($_search,$this->_default_valid_actions))
                ?true
                :false
            );
            if($result){
                $result=(
                    (false!==array_search($this->_name_tag, $this->_default_valid_actions[$_search]))
                    ?true
                    :false
                );
            }
        }
        if(
            isset($this->_default_valid_params) &&
            count($this->_default_valid_params) &&
            $result===false
        ){
            $result=(
                (false!==array_key_exists($_search,$this->_default_valid_params))
                ?true
                :false
            );
            if($result){
                $result=(
                    (false!==array_search($this->_name_tag, $this->_default_valid_params[$_search]))
                    ?true
                    :false
                );
            }
        }
        if(
            isset($this->_valid_params) &&
            count($this->_valid_params) &&
            $result===false
        ){
            $result=(
                (false!==array_search($_search, $this->_valid_params))
                ?true
                :false
            );
        }
        if(
            isset($this->_more_valid_params) &&
            count($this->_more_valid_params) &&
            $result===false
        ){
            $result=(
                (false!==array_search($_search, $this->_more_valid_params))
                ?true
                :false
            );
        }
        return $result;
    }
    
/***************************************************************/
    /**
     * Set validator for tag.
     *
     * @param null|Dadiweb_Validator_Abstract $_validator
     * @return Dadiweb_Validator_Abstract
     */
    public function setValidator($_validator=NULL)
    {
        if(
            isset($_validator) &&
            $_validator instanceof Dadiweb_Validator_Abstract
        ){
            $this->_list_validators[]=$_validator;
            return $this;
        }else{
            throw Dadiweb_Throw_ErrorException::showThrow(
                sprintf(
                    'The parameter that is passed to the method "%s" '.
                    'does not match with "Dadiweb_Validator_Abstract"', 
                    __METHOD__
                )
            );
        }
    }
    
/***************************************************************/
    /**
     * Get validator for tag.
     *
     * @return array
     */
    public function getValidators()
    {
        $_validator=TRUE;
        if(
            isset($this->_list_validators) &&
            count($this->_list_validators)
        ){
            foreach($this->_list_validators as $key=>$item){
                if($_validator===true){
                    $_validator=(
                        ($item instanceof Dadiweb_Validator_Abstract)
                        ?TRUE
                        :FALSE
                    );
                }
            }
        }
        if($_validator===TRUE){
            return $this->_list_validators;
        }
        throw Dadiweb_Throw_ErrorException::showThrow(
            sprintf(
                'The element "%s" into the method "%s" '.
                'does not match with "Dadiweb_Validator_Abstract"',
                self::getName(), 
                __METHOD__
            )
        );
    }
    
/***************************************************************/
    /**
     * Set filter for tag.
     *
     * @param null|Dadiweb_Filter_Abstract $_filter
     * @return Dadiweb_Filter_Abstract
     */
    public function setFilter($_filter=NULL)
    {
        if(
            isset($_filter) &&
            $_filter instanceof Dadiweb_Filter_Abstract
        ){
            $this->_list_filters[]=$_filter;
            return $this;
        }else{
            throw Dadiweb_Throw_ErrorException::showThrow(
                sprintf(
                    'The parameter that is passed to the method "%s" '.
                    'does not match with "Dadiweb_Filter_Abstract"', 
                    __METHOD__
                )
            );
        }
    }
    
/***************************************************************/
    /**
     * Get filter for tag.
     *
     * @return array
     */
    public function getFilters()
    {
        $_filter=TRUE;
        if(
            isset($this->_list_filters) &&
            count($this->_list_filters)
        ){
            foreach($this->_list_filters as $key=>$item){
                if($_filter===true){
                    $_filter=(
                        ($item instanceof Dadiweb_Filter_Abstract)
                        ?TRUE
                        :FALSE
                    );
                }
            }
        }
        if($_filter===TRUE){
            return $this->_list_filters;
        }
        throw Dadiweb_Throw_ErrorException::showThrow(
            sprintf(
                'The element "%s" into the method "%s" '.
                'does not match with "Dadiweb_Filter_Abstract"',
                self::getName(), 
                __METHOD__
            )
        );
    }
    
/***************************************************************/
    /**
     * Set value of tag.
     * 
     * @param mixed $value
     * @return void
     */
    public function setValue($value=NULL)
    {
        $this->value = $value;
    }
    
/***************************************************************/
    /**
     * Get value of tag.
     * 
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
    
/***************************************************************/
    /**
     * Handler variables that do not exist (input).
     * 
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set($name, $value)
    {
        $this->_variables[$name] = $value;
    }
    
/***************************************************************/
    /**
     * Handler variables that do not exist (output).
     * 
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->_variables)) {
            return $this->_variables[$name];
        }
        return NULL;
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
        if(!method_exists($this, $method)) { 
            throw Dadiweb_Throw_ErrorException::showThrow(
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