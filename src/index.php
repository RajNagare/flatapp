<?php
/*/
 * Gus - the web app kickstarter
 * 
 * Welcome to the index file! Here you will find 
 * application globals configs and dependencies.
 * 
 * !! Make sure app/log/ and app/cache/ are apache writable
 * 
*/

error_reporting(E_ERROR | E_WARNING | E_PARSE); 
 
// are we routing via the CLI?
$CLI = ( isset($argv) && $argv[1] ? true : false );

if($CLI) {
	
	// allow us to 
	define('ROOT_PATH', $argv[1] );
	define('APP_PATH', "../app" );
	
} else {
	
	// Set Root and App path
	define('ROOT_PATH', getcwd() );
	define('APP_PATH', "../app" );
	
}
 
// Paths
define('CONTROLLER_PATH', ROOT_PATH . "/controller" );
define('LIBRARY_PATH', ROOT_PATH . "/library" );
define('VIEWS_PATH', ROOT_PATH . "/views" );
define('VIEWS_CACHE_PATH', APP_PATH . "/cache" );

if(!$CLI) {
	
	// Require Session
	require_once CONTROLLER_PATH . "/Session.php"; 
	
	// create our session
	$Session = new Session();

}
 
// Require Twig Dependencies
require_once LIBRARY_PATH . "/twig/lib/Twig/Autoloader.php";
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem(VIEWS_PATH);

// Build Twig object and set some environment variables
$Twig = new Twig_Environment($loader, array(
    'cache' => VIEWS_CACHE_PATH,
    'auto_reload' => true, //reload views when changes are detected
    'debug' => true,
));

/*/
 * Twig Vars are variables used in views,
 * 
 */
$twigVars = array();

// cache busting for js and css dependencies 
$twigVars["cachebust"] = "?".date("Ymd");

// Start Handling Routes
require_once CONTROLLER_PATH . "/Routing.php"; 
 
?>
