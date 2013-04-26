<?php

/* Session Controller
 * 
 *
*/

session_start();

#var_dump($_SESSION); die();

function AuthenticateSession() {
	
	if(!$_SESSION['Account']['id']) {
		header("Location: /");
	}
	
}


?>