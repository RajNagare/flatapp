<?php
/*
 * Global Controller
 * 
 * 
 */
 

// start your session fool
session_start();
 
// Require Twig Dependencies
require_once "{$config['app_root']}/lib/Twig/Autoloader.php";
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem("{$config['app_root']}/templates/");

// Build Twig object and set some environment variables
$Twig = new Twig_Environment($loader, array(
    'cache' => "{$config['app_root']}/templates/cache/",
    'debug' => true
));

/*/
 * Twig Vars are variables used in templates,
 * feel free to add to the $twig_vars array
 * 
 */
$twigVars = array(
	'global' => "{$config['web_root']}",
	'lib' => "{$config['web_root']}lib",
	'js' => "{$config['web_root']}js",
	'css' => "{$config['web_root']}css",
	'img' => "{$config['web_root']}img",
);
 
/*// connect to mongo
$Mongo = new MongoClient();

// Use the Pipeline DB
$DB = $Mongo->Lytemap; 

// Posts Collection
$Posts = $DB->Posts;

// Accounts Collection
$Accounts = $DB->Accounts;
*/

// Start Handling Routes
require_once "controller/Routing.php"; 
 
?>