<?php
/*
 * Routing Controller
 * 
 * Try figure out what route the user is passing
 * If we have a view/{$_ROUTE}.hmtl, set as view
 * 		If we have a controller/{$_ROUTE}.php, execute controller logic
 * Else 404 ya boi
 * Render view with data and respond
 * 
 */

// grab path from script
$web_app_suffix = str_replace("/index.php" ,"",$_SERVER['SCRIPT_NAME']);

// determine route
$_ROUTE = str_replace("$web_app_suffix/","","{$_SERVER['REQUEST_URI']}");

// remove query string
$_ROUTE = str_replace("?{$_SERVER['QUERY_STRING']}","",$_ROUTE);

// if no route is passed, make it the public one
if(!$_ROUTE) {
	$_ROUTE = "index";
}

// If we are using the CLI, we pass the route manually
if($CLI) {
	$_ROUTE = $argv[2];
}

// uncomment to debug		
//var_dump($_SERVER); die(" <hr/> URI: {$_SERVER['REQUEST_URI']}   <hr/>  Determined: $_ROUTE"); die();

// Does that View exist?
if( is_file( VIEWS_PATH . "/$_ROUTE.html" ) ) {
	
	// set the route view
	$routeView = "$_ROUTE.html";
	
	// Does that view have a controller?
	if( is_file( CONTROLLER_PATH . "/$_ROUTE.php" ) ) {
		
		// Include it
		require_once CONTROLLER_PATH . "/$_ROUTE.php";
	
	} 
	
} else {
// didn't find that, sorry bro 

	// send 404
	header('HTTP/1.0 404 Not Found');
	$routeView = "404.html";

}

// tell the view what route we're at
$twigVars['ROUTE'] = $_ROUTE;

// render the view and die
die(
	$Twig->render($routeView, $twigVars)
);

?>
