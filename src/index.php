<?php
/*/
 * FlatApp | Index
 * 
 * Main entry point for the development harness. 
 * 
*/

error_reporting(E_ERROR | E_WARNING | E_PARSE); 
 
// are we routing via the CLI?
$CLI = ( isset($argv) && $argv[1] ? true : false );

// If we are using the CLI, use the first argument else use current working dir
define('ROOT_PATH', ( $CLI ? $argv[1] : getcwd() ) ) ; 

define('VENDOR_PATH', ( $CLI ? "vendor" : "../vendor" )  ) ; 

// Paths
define('APP_PATH', "../app" );
define('CONTROLLER_PATH', ROOT_PATH . "/controller" );
define('VIEWS_PATH', ROOT_PATH . "/views" );
define('VIEWS_CACHE_PATH', APP_PATH . "/cache" );
 
// Require Twig Dependencies
require_once VENDOR_PATH . "/twig/twig/lib/Twig/Autoloader.php";
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

// Theme
$twigVars["theme"] = ( $_GET['theme'] ? $_GET['theme'] : "default" );

// cache busting for js and css dependencies 
$twigVars["cachebust"] = "?".date("Ymd");

// Start Handling Routes
require_once CONTROLLER_PATH . "/Routing.php"; 
 
?>
