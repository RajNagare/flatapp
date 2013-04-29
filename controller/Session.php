<?php

/* Session Controller
 * 
 * Basic class for handling sessions
 * 
*/

class Session {
	
	// expire time (1 day)
	private $expire = 86400;
	
	public function __construct() {
				
		// fire 'er up dude!
		session_set_cookie_params($this->expire,$_SERVER['HTTP_HOST']);
		session_start();
			
		// have we created a session?
		if ( !$this->get("created") ) {
				
			$this->create();	
		
		// we need to update our session	
		} else{
				
			$this->updateActivity();
					
		}
		
	}
	
	// Create the session
	private function create() {
		
		// if we don't have a created time, set it
		if ( !$this->get("created") ) {
			
		   	// set the created time
			$this->set("created",time());
		
		 // session started more than 30 minutes ago
		} else if (time() - $this->get("created") > $this->expire) {
			
		    session_regenerate_id(true);    // change session ID for the current session
		    $this->set("created",time());  // update creation time
		    
		}
		
		// set our last activity 
		$this->set("lastActivity", $this->get("created") ); 
		setcookie("TestCookie", "", $this->get("created") + $this->expire);
		
	}
	
	// Destroy the session
	function destroy() {
		
		setcookie("TestCookie", "", $this->get("created") - $this->expire);
		session_unset();     // unset $_SESSION variable for the run-time 
		session_destroy();   // destroy session data in storage
		
	}
	
	// set a variable in the seesion
	function set($var,$value) {
		
		if(!$var || !$value) {
			throw new Exception("Session->set() requires both a $var and $value");	
		}
		
		$_SESSION[$var] = $value;
		
	}
	
	// get a value
	public function get($var) {
		
		if(!$var) {
			throw new Exception("Session->get() requires $var, which was not passed");	
		}
		
		return $_SESSION[$var];
		
	}
	
	private function updateActivity() {
		
		if ( $this->get("lastActivity") 
		&& ( time() - $this->get("lastActivity") > $this->expire ) ) {
			
		   $this->destroy();
		    
		} else {
				
			// set last activity
			$this->set("lastActivity",time()); 
		
		}
	

	}
	
	function debug() {
		
		die("<pre>".var_dump($_SESSION));
		
	}
	
	
	function authenticate() {
		
		$this->updateActivity();
		
		if($this->get("created") && $this->get("lastActivity") ) {
			
			return TRUE;
			
		} else {
			
			return FALSE;
			
		}
		
		
		
	}
	
}

?>