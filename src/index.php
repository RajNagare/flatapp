<?php
/*/
 * FlatApp | Index
 * 
 * Main entry point for the development harness. 
 * 
*/

// Report Errors
error_reporting(E_ERROR | E_WARNING | E_PARSE); 


 
// are we routing via the CLI?
$CLI = ( isset($argv) && $argv[1] ? true : false );

// If we are using the CLI, use the first argument else use current working dir
define('ROOT_PATH', ( $CLI ? $argv[1] : getcwd() ) ) ; 

// If we are using the CLI, thr vendor path is local, either go up a directory
define('VENDOR_PATH', ( $CLI ? "vendor" : "../vendor" )  ) ; 

// Has setup run yet? If vendors is not there, probably not

if( !is_dir(VENDOR_PATH) ) {
	die("You need to run `setup` on your command line");
}

// Paths
define('APP_PATH', "../app" );

define('CONTROLLER_PATH', ROOT_PATH . "/controller" );

// Start Themes
require_once CONTROLLER_PATH . "/Render.php"; 

// Start Handling Routes
require_once CONTROLLER_PATH . "/Routing.php"; 
 
?>
