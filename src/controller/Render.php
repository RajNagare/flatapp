<?php
/*
 * Render Controller
 * 
 * Handles the theming and twig setup
 */

$theme = "default";

define('VIEWS_PATH', ROOT_PATH . "/themes/{$theme}" );

define('VIEWS_CACHE_PATH', APP_PATH . "/cache" );

// Twig Include
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

$twigVars['theme'] = "default";

// cache busting for js and css dependencies 
$twigVars["cachebust"] = "?".date("Ymd");
 
?>