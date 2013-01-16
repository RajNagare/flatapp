<?php

// grab path from script
$web_app_suffix = str_replace("/index.php" ,"",$_SERVER['SCRIPT_NAME']);

// determine route
$_ROUTE = str_replace("$web_app_suffix/","",$_SERVER['REQUEST_URI']);

// if it's an index route (/)
if(!$_ROUTE) {
	$_ROUTE = "Home";
}
	
// uncomment to debug		
//die("{$_SERVER['REDIRECT_SCRIPT_URL']} vs {$_SERVER['REQUEST_URI']} > $_ROUTE");

// Does that controller exist?
if( is_file("controller/$_ROUTE.php") ) {
	
	// Include it
	require_once "controller/$_ROUTE.php";
	
	// Does that controller have a template?
	if( is_file("{$config['app_root']}/templates/$_ROUTE.html") ) {
		
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