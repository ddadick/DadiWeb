/***************************************************************/

// Define path to application directory

defined('LIB_PATH')
|| define('LIB_PATH', realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'library').DIRECTORY_SEPARATOR);

defined('APPS_PATH')
|| define('APPS_PATH', realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'apps').DIRECTORY_SEPARATOR);

defined('HTDOCS_PATH')
|| define('HTDOCS_PATH', realpath($_SERVER["DOCUMENT_ROOT"]));

defined('DATA_PATH')
|| define('DATA_PATH', realpath($_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR.'data'));


defined('INI_PATH')
|| define('INI_PATH', realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.'settings').DIRECTORY_SEPARATOR);

/***************************************************************/

//echo APP_PATH;

set_include_path(
	implode(PATH_SEPARATOR, 
		array(
			realpath(APPS_PATH),
			realpath(LIB_PATH),
			get_include_path()
		)
	)
);

/***************************************************************/

require_once 'Dadiweb/Bootstrap.php';

// Create application, bootstrap, and run
$dadi = new Dadiweb_Bootstrap();