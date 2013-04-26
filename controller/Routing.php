<?php
/*
 * Routing Controller
 * 
 * This handles how routes, controllers, and templates play
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
		$routeTemplate = "404.html";
		
	break;
	
}

// Does that controller exist?
if( is_file("{$_CONFIG['CONTROLLER']}/$_ROUTE.php") ) {
	
	// Include it
	require_once "{$_CONFIG['CONTROLLER']}/$_ROUTE.php";
	
	// Does that controller have a template?
	if( is_file("{$_CONFIG['TEMPLATES']}/$_ROUTE.html") ) {
		
		// set it
		$routeTemplate = "$_ROUTE.html";
	
	} 
	
} else {
	
	// starting looking for a defined route
	switch($_ROUTE) {
		
			
		// didn't find that, sorry bro > 404
		default:
			
			// set header
			header('HTTP/1.0 404 Not Found');
			$routeTemplate = "404.html";
			
		break;	
	
	}

}

// tell the template what route we're at
$twigVars['ROUTE'] = $_ROUTE;

// render the template and die
die(
	$Twig->render($routeTemplate, $twigVars)
);


?>