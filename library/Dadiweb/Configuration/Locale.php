<?php
class Dadiweb_Configuration_Locale
{
	/**
     * Singleton instance
     * 
     * @var Dadiweb_Configuration_Locale
     */
    protected static $_instance = null;
    
    /**
     * General variable
     *
     * @var Array()
     */
    protected $_locale = NULL;
    
    /**
     * Language variable (list)
     *
     * @var Array()
     */
    protected $_languages = NULL;
    
    /**
     * Region variable (list)
     *
     * @var Array()
     */
    protected $_regions = NULL;
    
/***************************************************************/
	/**
     * Singleton pattern implementation makes "new" unavailable
     *
     * @return void
     */
	protected function __construct(){
		self::setGeneric();
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
     * Returns an instance of Dadiweb_Configuration_Locale
     * Singleton pattern implementation
     *
     * @return Dadiweb_Configuration_Locale Provides a fluent interface
     */
    public static function getInstance($options=NULL)
    {
    	if (null === self::$_instance) {
            self::$_instance = new self($options);
        }
        return self::$_instance;
    }
/***************************************************************/
    /**
     * Reset instance of Dadiweb_Configuration_Locale
     * Singleton pattern implementation
     *
     * @return Dadiweb_Configuration_Locale Provides a fluent interface
     */
    public static function resetInstance()
    {
        return self::$_instance=NULL;
    }
/***************************************************************/
    /**
     * Returns Configuration Settings
     *
     * @return stdClass
     */
    public function getGeneric()
    {
    	if(!is_array($this->_locale)){
    		self::setGeneric();
    	}
    	return $this->_locale;
    }
/***************************************************************/
    /**
     * Setup Configuration Object
     *
     * @return stdClass
     */
    protected function setGeneric()
    {
    	self::setLanguages();
    	self::setRegions();
    	/**
    	 * Set default locale
    	 */
    	if(
    		isset(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Locales->default)
    		&& strlen($locale=trim(Dadiweb_Configuration_Kernel::getInstance()->getSettings()->apps->Locales->default))
    	){
    		self::searchLocale($locale);
    	}
    	if(self::getLocale() instanceof stdClass){
    		return self::getLocale();
    	}
    	self::searchLocale('en-US');
    }
/***************************************************************/
    /**
     * Search locale
     *
     * @return stdClass
     */
    public function searchLocale($_search=NULL)
    {
    	if($_search==NULL || !is_string($_search) || !strlen(trim($_search))){return NULL;}
    	if(
    		count($_search=explode('-',$_search))==2
    		&& is_array($_search)
    		&& isset($_search[0])
    		&& isset($_search[1])
    		&& false!==array_search($_search[0],self::getLanguages())
    		&& false!==array_search($_search[1],self::getRegions())
    	){
    		$array=array();
    		$array['language']=$_search[0];
    		$array['region']=$_search[1];
    		$array['locale']=$array['language'].'_'.$array['region'];
    		$array['original']=$array['language'].'-'.$array['region'];
    		$this->_locale=Dadiweb_Aides_Array::getInstance()->arr2obj($array);
    		return $this->_locale->original;
    	}
    	return NULL;
    }
/***************************************************************/
    /**
     * Get locale
     *
     * @return stdClass
     */
    public function getLocale()
    {
    	if($this->_locale instanceof stdClass){
    		return $this->_locale; 
    	}    	
    	return self::getGeneric();
    }
/***************************************************************/
    /**
     * Setup laguages
     *
     * @return Array()
     */
    protected function setLanguages()
    {
    	
    	$this->_languages[]='aa'; //Afar
    	$this->_languages[]='ab'; //Abkhazian
    	$this->_languages[]='ae'; //Avestan
    	$this->_languages[]='af'; //Afrikaans
    	$this->_languages[]='ak'; //Akan
    	$this->_languages[]='am'; //Amharic
    	$this->_languages[]='an'; //Aragonese
    	$this->_languages[]='ar'; //Arabic
    	$this->_languages[]='as'; //Assamese
    	$this->_languages[]='av'; //Avaric
    	$this->_languages[]='ay'; //Aymara
    	$this->_languages[]='az'; //Azerbaijani
    	$this->_languages[]='ba'; //Bashkir
    	$this->_languages[]='be'; //Belarusian
    	$this->_languages[]='bg'; //Bulgarian
    	$this->_languages[]='bh'; //Bihari languages
    	$this->_languages[]='bi'; //Bislama
    	$this->_languages[]='bm'; //Bambara
    	$this->_languages[]='bn'; //Bengali
    	$this->_languages[]='bo'; //Tibetan
    	$this->_languages[]='br'; //Breton
    	$this->_languages[]='bs'; //Bosnian
    	$this->_languages[]='ca'; //Catalan
    	$this->_languages[]='ce'; //Chechen
    	$this->_languages[]='ch'; //Chamorro
    	$this->_languages[]='co'; //Corsican
    	$this->_languages[]='cr'; //Cree
    	$this->_languages[]='cs'; //Czech
    	$this->_languages[]='cu'; //Church Slavic, Church Slavonic, Old Bulgarian, Old Church Slavonic, Old Slavonic
    	$this->_languages[]='cv'; //Chuvash
    	$this->_languages[]='cy'; //Welsh
    	$this->_languages[]='da'; //Danish
    	$this->_languages[]='de'; //German
    	$this->_languages[]='dv'; //Dhivehi, Divehi, Maldivian
    	$this->_languages[]='dz'; //Dzongkha
    	$this->_languages[]='ee'; //Ewe
    	$this->_languages[]='el'; //Modern Greek (1453-)
    	$this->_languages[]='en'; //English
    	$this->_languages[]='eo'; //Esperanto
    	$this->_languages[]='es'; //Spanish, Castilian
    	$this->_languages[]='et'; //Estonian
    	$this->_languages[]='eu'; //Basque
    	$this->_languages[]='fa'; //Persian
    	$this->_languages[]='ff'; //Fulah
    	$this->_languages[]='fi'; //Finnish
    	$this->_languages[]='fj'; //Fijian
    	$this->_languages[]='fo'; //Faroese
    	$this->_languages[]='fr'; //French
    	$this->_languages[]='fy'; //Western Frisian
    	$this->_languages[]='ga'; //Irish
    	$this->_languages[]='gd'; //Scottish Gaelic, Gaelic
    	$this->_languages[]='gl'; //Galician
    	$this->_languages[]='gn'; //Guarani
    	$this->_languages[]='gu'; //Gujarati
    	$this->_languages[]='gv'; //Manx
    	$this->_languages[]='ha'; //Hausa
    	$this->_languages[]='he'; //Hebrew
    	$this->_languages[]='hi'; //Hindi
    	$this->_languages[]='ho'; //Hiri Motu
    	$this->_languages[]='hr'; //Croatian
    	$this->_languages[]='ht'; //Haitian, Haitian Creole
    	$this->_languages[]='hu'; //Hungarian
    	$this->_languages[]='hy'; //Armenian
    	$this->_languages[]='hz'; //Herero
    	$this->_languages[]='ia'; //Interlingua (International Auxiliary Language Association)
    	$this->_languages[]='id'; //Indonesian
    	$this->_languages[]='ie'; //Interlingue, Occidental
    	$this->_languages[]='ig'; //Igbo
    	$this->_languages[]='ii'; //Sichuan Yi, Nuosu
    	$this->_languages[]='ik'; //Inupiaq
    	$this->_languages[]='in'; //Indonesian
    	$this->_languages[]='io'; //Ido
    	$this->_languages[]='is'; //Icelandic
    	$this->_languages[]='it'; //Italian
    	$this->_languages[]='iu'; //Inuktitut
    	$this->_languages[]='iw'; //Hebrew
    	$this->_languages[]='ja'; //Japanese
    	$this->_languages[]='ji'; //Yiddish
    	$this->_languages[]='jv'; //Javanese
    	$this->_languages[]='jw'; //Javanese
    	$this->_languages[]='ka'; //Georgian
    	$this->_languages[]='kg'; //Kongo
    	$this->_languages[]='ki'; //Kikuyu, Gikuyu
    	$this->_languages[]='kj'; //Kuanyama, Kwanyama
    	$this->_languages[]='kk'; //Kazakh
    	$this->_languages[]='kl'; //Kalaallisut, Greenlandic
    	$this->_languages[]='km'; //Central Khmer
    	$this->_languages[]='kn'; //Kannada
    	$this->_languages[]='ko'; //Korean
    	$this->_languages[]='kr'; //Kanuri
    	$this->_languages[]='ks'; //Kashmiri
    	$this->_languages[]='ku'; //Kurdish
    	$this->_languages[]='kv'; //Komi
    	$this->_languages[]='kw'; //Cornish
    	$this->_languages[]='ky'; //Kirghiz, Kyrgyz
    	$this->_languages[]='la'; //Latin
    	$this->_languages[]='lb'; //Luxembourgish, Letzeburgesch
    	$this->_languages[]='lg'; //Ganda
    	$this->_languages[]='li'; //Limburgan, Limburger, Limburgish
    	$this->_languages[]='ln'; //Lingala
    	$this->_languages[]='lo'; //Lao
    	$this->_languages[]='lt'; //Lithuanian
    	$this->_languages[]='lu'; //Luba-Katanga
    	$this->_languages[]='lv'; //Latvian
    	$this->_languages[]='mg'; //Malagasy
    	$this->_languages[]='mh'; //Marshallese
    	$this->_languages[]='mi'; //Maori
    	$this->_languages[]='mk'; //Macedonian
    	$this->_languages[]='ml'; //Malayalam
    	$this->_languages[]='mn'; //Mongolian
    	$this->_languages[]='mo'; //Moldavian, Moldovan
    	$this->_languages[]='mr'; //Marathi
    	$this->_languages[]='ms'; //Malay (macrolanguage)
    	$this->_languages[]='mt'; //Maltese
    	$this->_languages[]='my'; //Burmese
    	$this->_languages[]='na'; //Nauru
    	$this->_languages[]='nb'; //Norwegian Bokmål
    	$this->_languages[]='nd'; //North Ndebele
    	$this->_languages[]='ne'; //Nepali (macrolanguage)
    	$this->_languages[]='ng'; //Ndonga
    	$this->_languages[]='nl'; //Dutch, Flemish
    	$this->_languages[]='nn'; //Norwegian Nynorsk
    	$this->_languages[]='no'; //Norwegian
    	$this->_languages[]='nr'; //South Ndebele
    	$this->_languages[]='nv'; //Navajo, Navaho
    	$this->_languages[]='ny'; //Nyanja, Chewa, Chichewa
    	$this->_languages[]='oc'; //Occitan (post 1500)
    	$this->_languages[]='oj'; //Ojibwa
    	$this->_languages[]='om'; //Oromo
    	$this->_languages[]='or'; //Oriya (macrolanguage)
    	$this->_languages[]='os'; //Ossetian, Ossetic
    	$this->_languages[]='pa'; //Panjabi, Punjabi
    	$this->_languages[]='pi'; //Pali
    	$this->_languages[]='pl'; //Polish
    	$this->_languages[]='ps'; //Pushto, Pashto
    	$this->_languages[]='pt'; //Portuguese
    	$this->_languages[]='qu'; //Quechua
    	$this->_languages[]='rm'; //Romansh
    	$this->_languages[]='rn'; //Rundi
    	$this->_languages[]='ro'; //Romanian, Moldavian, Moldovan
    	$this->_languages[]='ru'; //Russian
    	$this->_languages[]='rw'; //Kinyarwanda
    	$this->_languages[]='sa'; //Sanskrit
    	$this->_languages[]='sc'; //Sardinian
    	$this->_languages[]='sd'; //Sindhi
    	$this->_languages[]='se'; //Northern Sami
    	$this->_languages[]='sg'; //Sango
    	$this->_languages[]='sh'; //Serbo-Croatian
    	$this->_languages[]='si'; //Sinhala, Sinhalese
    	$this->_languages[]='sk'; //Slovak
    	$this->_languages[]='sl'; //Slovenian
    	$this->_languages[]='sm'; //Samoan
    	$this->_languages[]='sn'; //Shona
    	$this->_languages[]='so'; //Somali
    	$this->_languages[]='sq'; //Albanian
    	$this->_languages[]='sr'; //Serbian
    	$this->_languages[]='ss'; //Swati
    	$this->_languages[]='st'; //Southern Sotho
    	$this->_languages[]='su'; //Sundanese
    	$this->_languages[]='sv'; //Swedish
    	$this->_languages[]='sw'; //Swahili (macrolanguage)
    	$this->_languages[]='ta'; //Tamil
    	$this->_languages[]='te'; //Telugu
    	$this->_languages[]='tg'; //Tajik
    	$this->_languages[]='th'; //Thai
    	$this->_languages[]='ti'; //Tigrinya
    	$this->_languages[]='tk'; //Turkmen
    	$this->_languages[]='tl'; //Tagalog
    	$this->_languages[]='tn'; //Tswana
    	$this->_languages[]='to'; //Tonga (Tonga Islands)
    	$this->_languages[]='tr'; //Turkish
    	$this->_languages[]='ts'; //Tsonga
    	$this->_languages[]='tt'; //Tatar
    	$this->_languages[]='tw'; //Twi
    	$this->_languages[]='ty'; //Tahitian
    	$this->_languages[]='ug'; //Uighur, Uyghur
    	$this->_languages[]='uk'; //Ukrainian
    	$this->_languages[]='ur'; //Urdu
    	$this->_languages[]='uz'; //Uzbek
    	$this->_languages[]='ve'; //Venda
    	$this->_languages[]='vi'; //Vietnamese
    	$this->_languages[]='vo'; //Volapük
    	$this->_languages[]='wa'; //Walloon
    	$this->_languages[]='wo'; //Wolof
    	$this->_languages[]='xh'; //Xhosa
    	$this->_languages[]='yi'; //Yiddish
    	$this->_languages[]='yo'; //Yoruba
    	$this->_languages[]='za'; //Zhuang, Chuang
    	$this->_languages[]='zh'; //Chinese
    	$this->_languages[]='zu'; //Zulu;
    	return $this->_languages;
    }
/***************************************************************/
    /**
     * Get laguages
     *
     * @return Array()
     */
    public function getLanguages()
    {
    	if(!is_array($this->_languages)){
    		self::setLanguages();
    	}
    	return $this->_languages;
    }
/***************************************************************/
    /**
     * Setup regions
     *
     * @return Array()
     */
    protected function setRegions()
    {
    	$this->_regions[]='AC'; //Ascension Island
    	$this->_regions[]='AD'; //Andorra
    	$this->_regions[]='AE'; //United Arab Emirates
    	$this->_regions[]='AF'; //Afghanistan
    	$this->_regions[]='AG'; //Antigua and Barbuda
    	$this->_regions[]='AI'; //Anguilla
    	$this->_regions[]='AL'; //Albania
    	$this->_regions[]='AM'; //Armenia
    	$this->_regions[]='AN'; //Netherlands Antilles
    	$this->_regions[]='AO'; //Angola
    	$this->_regions[]='AQ'; //Antarctica
    	$this->_regions[]='AR'; //Argentina
    	$this->_regions[]='AS'; //American Samoa
    	$this->_regions[]='AT'; //Austria
    	$this->_regions[]='AU'; //Australia
    	$this->_regions[]='AW'; //Aruba
    	$this->_regions[]='AX'; //Åland Islands
    	$this->_regions[]='AZ'; //Azerbaijan
    	$this->_regions[]='BA'; //Bosnia and Herzegovina
    	$this->_regions[]='BB'; //Barbados
    	$this->_regions[]='BD'; //Bangladesh
    	$this->_regions[]='BE'; //Belgium
    	$this->_regions[]='BF'; //Burkina Faso
    	$this->_regions[]='BG'; //Bulgaria
    	$this->_regions[]='BH'; //Bahrain
    	$this->_regions[]='BI'; //Burundi
    	$this->_regions[]='BJ'; //Benin
    	$this->_regions[]='BL'; //Saint Barthélemy
    	$this->_regions[]='BM'; //Bermuda
    	$this->_regions[]='BN'; //Brunei Darussalam
    	$this->_regions[]='BO'; //Bolivia
    	$this->_regions[]='BQ'; //Bonaire, Sint Eustatius and Saba
    	$this->_regions[]='BR'; //Brazil
    	$this->_regions[]='BS'; //Bahamas
    	$this->_regions[]='BT'; //Bhutan
    	$this->_regions[]='BU'; //Burma
    	$this->_regions[]='BV'; //Bouvet Island
    	$this->_regions[]='BW'; //Botswana
    	$this->_regions[]='BY'; //Belarus
    	$this->_regions[]='BZ'; //Belize
    	$this->_regions[]='CA'; //Canada
    	$this->_regions[]='CC'; //Cocos (Keeling) Islands
    	$this->_regions[]='CD'; //The Democratic Republic of the Congo
    	$this->_regions[]='CF'; //Central African Republic
    	$this->_regions[]='CG'; //Congo
    	$this->_regions[]='CH'; //Switzerland
    	$this->_regions[]='CI'; //Côte d'Ivoire
    	$this->_regions[]='CK'; //Cook Islands
    	$this->_regions[]='CL'; //Chile
    	$this->_regions[]='CM'; //Cameroon
    	$this->_regions[]='CN'; //China
    	$this->_regions[]='CO'; //Colombia
    	$this->_regions[]='CP'; //Clipperton Island
    	$this->_regions[]='CR'; //Costa Rica
    	$this->_regions[]='CS'; //Serbia and Montenegro
    	$this->_regions[]='CU'; //Cuba
    	$this->_regions[]='CV'; //Cape Verde
    	$this->_regions[]='CW'; //Curaçao
    	$this->_regions[]='CX'; //Christmas Island
    	$this->_regions[]='CY'; //Cyprus
    	$this->_regions[]='CZ'; //Czech Republic
    	$this->_regions[]='DD'; //German Democratic Republic
    	$this->_regions[]='DE'; //Germany
    	$this->_regions[]='DG'; //Diego Garcia
    	$this->_regions[]='DJ'; //Djibouti
    	$this->_regions[]='DK'; //Denmark
    	$this->_regions[]='DM'; //Dominica
    	$this->_regions[]='DO'; //Dominican Republic
    	$this->_regions[]='DZ'; //Algeria
    	$this->_regions[]='EA'; //Ceuta, Melilla
    	$this->_regions[]='EC'; //Ecuador
    	$this->_regions[]='EE'; //Estonia
    	$this->_regions[]='EG'; //Egypt
    	$this->_regions[]='EH'; //Western Sahara
    	$this->_regions[]='ER'; //Eritrea
    	$this->_regions[]='ES'; //Spain
    	$this->_regions[]='ET'; //Ethiopia
    	$this->_regions[]='EU'; //European Union
    	$this->_regions[]='FI'; //Finland
    	$this->_regions[]='FJ'; //Fiji
    	$this->_regions[]='FK'; //Falkland Islands (Malvinas)
    	$this->_regions[]='FM'; //Federated States of Micronesia
    	$this->_regions[]='FO'; //Faroe Islands
    	$this->_regions[]='FR'; //France
    	$this->_regions[]='FX'; //Metropolitan France
    	$this->_regions[]='GA'; //Gabon
    	$this->_regions[]='GB'; //United Kingdom
    	$this->_regions[]='GD'; //Grenada
    	$this->_regions[]='GE'; //Georgia
    	$this->_regions[]='GF'; //French Guiana
    	$this->_regions[]='GG'; //Guernsey
    	$this->_regions[]='GH'; //Ghana
    	$this->_regions[]='GI'; //Gibraltar
    	$this->_regions[]='GL'; //Greenland
    	$this->_regions[]='GM'; //Gambia
    	$this->_regions[]='GN'; //Guinea
    	$this->_regions[]='GP'; //Guadeloupe
    	$this->_regions[]='GQ'; //Equatorial Guinea
    	$this->_regions[]='GR'; //Greece
    	$this->_regions[]='GS'; //South Georgia and the South Sandwich Islands
    	$this->_regions[]='GT'; //Guatemala
    	$this->_regions[]='GU'; //Guam
    	$this->_regions[]='GW'; //Guinea-Bissau
    	$this->_regions[]='GY'; //Guyana
    	$this->_regions[]='HK'; //Hong Kong
    	$this->_regions[]='HM'; //Heard Island and McDonald Islands
    	$this->_regions[]='HN'; //Honduras
    	$this->_regions[]='HR'; //Croatia
    	$this->_regions[]='HT'; //Haiti
    	$this->_regions[]='HU'; //Hungary
    	$this->_regions[]='IC'; //Canary Islands
    	$this->_regions[]='ID'; //Indonesia
    	$this->_regions[]='IE'; //Ireland
    	$this->_regions[]='IL'; //Israel
    	$this->_regions[]='IM'; //Isle of Man
    	$this->_regions[]='IN'; //India
    	$this->_regions[]='IO'; //British Indian Ocean Territory
    	$this->_regions[]='IQ'; //Iraq
    	$this->_regions[]='IR'; //Islamic Republic of Iran
    	$this->_regions[]='IS'; //Iceland
    	$this->_regions[]='IT'; //Italy
    	$this->_regions[]='JE'; //Jersey
    	$this->_regions[]='JM'; //Jamaica
    	$this->_regions[]='JO'; //Jordan
    	$this->_regions[]='JP'; //Japan
    	$this->_regions[]='KE'; //Kenya
    	$this->_regions[]='KG'; //Kyrgyzstan
    	$this->_regions[]='KH'; //Cambodia
    	$this->_regions[]='KI'; //Kiribati
    	$this->_regions[]='KM'; //Comoros
    	$this->_regions[]='KN'; //Saint Kitts and Nevis
    	$this->_regions[]='KP'; //Democratic People's Republic of Korea
    	$this->_regions[]='KR'; //Republic of Korea
    	$this->_regions[]='KW'; //Kuwait
    	$this->_regions[]='KY'; //Cayman Islands
    	$this->_regions[]='KZ'; //Kazakhstan
    	$this->_regions[]='LA'; //Lao People's Democratic Republic
    	$this->_regions[]='LB'; //Lebanon
    	$this->_regions[]='LC'; //Saint Lucia
    	$this->_regions[]='LI'; //Liechtenstein
    	$this->_regions[]='LK'; //Sri Lanka
    	$this->_regions[]='LR'; //Liberia
    	$this->_regions[]='LS'; //Lesotho
    	$this->_regions[]='LT'; //Lithuania
    	$this->_regions[]='LU'; //Luxembourg
    	$this->_regions[]='LV'; //Latvia
    	$this->_regions[]='LY'; //Libya
    	$this->_regions[]='MA'; //Morocco
    	$this->_regions[]='MC'; //Monaco
    	$this->_regions[]='MD'; //Moldova
    	$this->_regions[]='ME'; //Montenegro
    	$this->_regions[]='MF'; //Saint Martin (French part)
    	$this->_regions[]='MG'; //Madagascar
    	$this->_regions[]='MH'; //Marshall Islands
    	$this->_regions[]='MK'; //The Former Yugoslav Republic of Macedonia
    	$this->_regions[]='ML'; //Mali
    	$this->_regions[]='MM'; //Myanmar
    	$this->_regions[]='MN'; //Mongolia
    	$this->_regions[]='MO'; //Macao
    	$this->_regions[]='MP'; //Northern Mariana Islands
    	$this->_regions[]='MQ'; //Martinique
    	$this->_regions[]='MR'; //Mauritania
    	$this->_regions[]='MS'; //Montserrat
    	$this->_regions[]='MT'; //Malta
    	$this->_regions[]='MU'; //Mauritius
    	$this->_regions[]='MV'; //Maldives
    	$this->_regions[]='MW'; //Malawi
    	$this->_regions[]='MX'; //Mexico
    	$this->_regions[]='MY'; //Malaysia
    	$this->_regions[]='MZ'; //Mozambique
    	$this->_regions[]='NA'; //Namibia
    	$this->_regions[]='NC'; //New Caledonia
    	$this->_regions[]='NE'; //Niger
    	$this->_regions[]='NF'; //Norfolk Island
    	$this->_regions[]='NG'; //Nigeria
    	$this->_regions[]='NI'; //Nicaragua
    	$this->_regions[]='NL'; //Netherlands
    	$this->_regions[]='NO'; //Norway
    	$this->_regions[]='NP'; //Nepal
    	$this->_regions[]='NR'; //Nauru
    	$this->_regions[]='NT'; //Neutral Zone
    	$this->_regions[]='NU'; //Niue
    	$this->_regions[]='NZ'; //New Zealand
    	$this->_regions[]='OM'; //Oman
    	$this->_regions[]='PA'; //Panama
    	$this->_regions[]='PE'; //Peru
    	$this->_regions[]='PF'; //French Polynesia
    	$this->_regions[]='PG'; //Papua New Guinea
    	$this->_regions[]='PH'; //Philippines
    	$this->_regions[]='PK'; //Pakistan
    	$this->_regions[]='PL'; //Poland
    	$this->_regions[]='PM'; //Saint Pierre and Miquelon
    	$this->_regions[]='PN'; //Pitcairn
    	$this->_regions[]='PR'; //Puerto Rico
    	$this->_regions[]='PS'; //State of Palestine
    	$this->_regions[]='PT'; //Portugal
    	$this->_regions[]='PW'; //Palau
    	$this->_regions[]='PY'; //Paraguay
    	$this->_regions[]='QA'; //Qatar
    	$this->_regions[]='RE'; //Réunion
    	$this->_regions[]='RO'; //Romania
    	$this->_regions[]='RS'; //Serbia
    	$this->_regions[]='RU'; //Russian Federation
    	$this->_regions[]='RW'; //Rwanda
    	$this->_regions[]='SA'; //Saudi Arabia
    	$this->_regions[]='SB'; //Solomon Islands
    	$this->_regions[]='SC'; //Seychelles
    	$this->_regions[]='SD'; //Sudan
    	$this->_regions[]='SE'; //Sweden
    	$this->_regions[]='SG'; //Singapore
    	$this->_regions[]='SH'; //Saint Helena, Ascension and Tristan da Cunha
    	$this->_regions[]='SI'; //Slovenia
    	$this->_regions[]='SJ'; //Svalbard and Jan Mayen
    	$this->_regions[]='SK'; //Slovakia
    	$this->_regions[]='SL'; //Sierra Leone
    	$this->_regions[]='SM'; //San Marino
    	$this->_regions[]='SN'; //Senegal
    	$this->_regions[]='SO'; //Somalia
    	$this->_regions[]='SR'; //Suriname
    	$this->_regions[]='SS'; //South Sudan
    	$this->_regions[]='ST'; //Sao Tome and Principe
    	$this->_regions[]='SU'; //Union of Soviet Socialist Republics
    	$this->_regions[]='SV'; //El Salvador
    	$this->_regions[]='SX'; //Sint Maarten (Dutch part)
    	$this->_regions[]='SY'; //Syrian Arab Republic
    	$this->_regions[]='SZ'; //Swaziland
    	$this->_regions[]='TA'; //Tristan da Cunha
    	$this->_regions[]='TC'; //Turks and Caicos Islands
    	$this->_regions[]='TD'; //Chad
    	$this->_regions[]='TF'; //French Southern Territories
    	$this->_regions[]='TG'; //Togo
    	$this->_regions[]='TH'; //Thailand
    	$this->_regions[]='TJ'; //Tajikistan
    	$this->_regions[]='TK'; //Tokelau
    	$this->_regions[]='TL'; //Timor-Leste
    	$this->_regions[]='TM'; //Turkmenistan
    	$this->_regions[]='TN'; //Tunisia
    	$this->_regions[]='TO'; //Tonga
    	$this->_regions[]='TP'; //East Timor
    	$this->_regions[]='TR'; //Turkey
    	$this->_regions[]='TT'; //Trinidad and Tobago
    	$this->_regions[]='TV'; //Tuvalu
    	$this->_regions[]='TW'; //Taiwan, Province of China
    	$this->_regions[]='TZ'; //United Republic of Tanzania
    	$this->_regions[]='UA'; //Ukraine
    	$this->_regions[]='UG'; //Uganda
    	$this->_regions[]='UM'; //United States Minor Outlying Islands
    	$this->_regions[]='US'; //United States
    	$this->_regions[]='UY'; //Uruguay
    	$this->_regions[]='UZ'; //Uzbekistan
    	$this->_regions[]='VA'; //Holy See (Vatican City State)
    	$this->_regions[]='VC'; //Saint Vincent and the Grenadines
    	$this->_regions[]='VE'; //Venezuela
    	$this->_regions[]='VG'; //British Virgin Islands
    	$this->_regions[]='VI'; //U.S. Virgin Islands
    	$this->_regions[]='VN'; //Viet Nam
    	$this->_regions[]='VU'; //Vanuatu
    	$this->_regions[]='WF'; //Wallis and Futuna
    	$this->_regions[]='WS'; //Samoa
    	$this->_regions[]='YD'; //Democratic Yemen
    	$this->_regions[]='YE'; //Yemen
    	$this->_regions[]='YT'; //Mayotte
    	$this->_regions[]='YU'; //Yugoslavia
    	$this->_regions[]='ZA'; //South Africa
    	$this->_regions[]='ZM'; //Zambia
    	$this->_regions[]='ZR'; //Zaire
    	$this->_regions[]='ZW'; //Zimbabwe
    	return $this->_regions; 
    }
/***************************************************************/
    /**
     * Get regions
     *
     * @return Array()
     */
    public function getRegions()
    {
    	if(!is_array($this->_regions)){
    		self::setRegions();
    	}
    	return $this->_regions;
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
         	throw Dadiweb_Render_Exception::getInstance()->getMessage(sprintf('The required method "%s" does not exist for %s', $method, get_class($this))); 
       	} 	
    }
/***************************************************************/
}