<?php
/*/
 * Gus - the web app kickstarter
 * 
 * Welcome to the index file! Here you will find 
 * application globals configs and dependencies.
 * 
 *  1) Go upate config.ini for correct application paths
 *  2) Make sure log/ and cache/ are apache writable
 * 
 */

 
// For your health, dummy
error_reporting(E_ERROR | E_WARNING | E_PARSE); 
 
// Paths
define('ROOT_PATH', getcwd() );
define('CONTROLLER_PATH', ROOT_PATH . "/controller" );
define('LIBRARY_PATH', ROOT_PATH . "/library" );
define('VIEWS_PATH', ROOT_PATH . "/views" );
define('VIEWS_CACHE_PATH', VIEWS_PATH . "/cache" );

// start your session fool
require_once CONTROLLER_PATH . "/Session.php"; 

// create our session
$Session = new Session();
 
// Require Twig Dependencies
require_once LIBRARY_PATH . "/twig/lib/Twig/Autoloader.php";
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem(VIEWS_PATH);

// Build Twig object and set some environment vari	ables
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