<?php
/*
 * Routing Controller
 * 
 * Try  figure out what route the user is passing
 * If we have a controller/{$_ROUTE}.php, use it
 * 		If we have a views/{$_ROUTE}.html, use it
 * Else if we have inline routes if you're lazy
 * Else 404 ya boi
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
	$_ROUTE = "Public";
}

// uncomment to debug		
//var_dump($_SERVER); die(" <hr/> URI: {$_SERVER['REQUEST_URI']}   <hr/>  Determined: $_ROUTE"); die();

// do not route to these
switch($_ROUTE) {
	
	case "Session":
		
		header('HTTP/1.0 404 Not Found');
		$routeView = "404.html";
		
	break;
	
}

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