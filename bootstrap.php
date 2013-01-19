/***************************************************************/

// Define path to application directory

defined('LIB_PATH')
|| define('LIB_PATH', realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'library'));

defined('PROG_PATH')
|| define('PROG_PATH', realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'programs'));

defined('HTDOCS_PATH')
|| define('HTDOCS_PATH', realpath($_SERVER["DOCUMENT_ROOT"]));

defined('INI_PATH')
|| define('INI_PATH', realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.'settings'));

/***************************************************************/

//echo APP_PATH;

set_include_path(
	implode(PATH_SEPARATOR, 
		array(
			realpath(PROG_PATH),
			realpath(LIB_PATH),
			get_include_path()
		)
	)
);

/***************************************************************/

require_once 'Dadiweb/Bootstrap.php';

// Create application, bootstrap, and run
$dadi = new Dadiweb_Bootstrap();