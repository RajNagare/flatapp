<?php
/*/
 * Gus - the web app kickstarter
 * 
 * Welcome to the index file! Here you will find 
 * application globals configs and dependencies.
 * 
 */

 // Global Configuration
$config = array();
$config['app_root'] = "/webapps/gus"; 
//$config['controller'] = "{$config['app_root']}/controller";
$config['web_root'] = "http://{$_SERVER['HTTP_HOST']}/"; 

// Global Controller
require_once  "controller/Global.php";

?>
