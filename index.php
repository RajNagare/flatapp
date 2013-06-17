<?php
/*/
 * Gus - the web app kickstarter
 * 
 * Welcome to the index file! Here you will find 
 * application globals configs and dependencies.
 * 
 */

 
// For your health, dummy
error_reporting(E_ERROR | E_WARNING | E_PARSE); 
 
 // Global Configuration
$_CONFIG = parse_ini_file("config.ini", true);

// are we routing via the CLI?
$CLI = ( isset($argv) && $argv[1] ? true : false );
 
// If we aren't using the CLI
if(!$CLI) {

	// start your session fool
	require_once "{$_CONFIG['CONTROLLER']}/Session.php"; 
	
	// create our session
	$Session = new Session();
	 
	// Require Twig Dependencies
	require_once "{$_CONFIG['LIB']}/twig/lib/Twig/Autoloader.php";
	Twig_Autoloader::register();
	$loader = new Twig_Loader_Filesystem($_CONFIG['VIEWS']);
	
	// Build Twig object and set some environment vari	ables
	$Twig = new Twig_Environment($loader, array(
	    'cache' => $_CONFIG['VIEWS_CACHE'],
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

}

// Start Handling Routes
require_once "{$_CONFIG['CONTROLLER']}/Routing.php"; 
 
?>