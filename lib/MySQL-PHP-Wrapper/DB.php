<?php
/*
 * DB Class for MySQL
 * 
 * A simple wrapper class of the mysqli extension
 * 
 * 
*/
class DB extends mysqli {
	
    public function __construct() {
    	
		global $_CONFIG;
		
		// did we not get an array?
		if(!$_CONFIG["DB"] || !is_array($_CONFIG["DB"])) {
			throw new Exception("DB Class - No configuration set for DB connection ya turkey");	
		}
        
		// Set up the connection	
        parent::__construct(
			$_CONFIG["DB"]["HOST"], 
			$_CONFIG["DB"]["USER"],
			$_CONFIG["DB"]["PASS"], 
			$_CONFIG["DB"]["DATABASE"],
			$_CONFIG["DB"]["PORT"]
		); 

		// do we have an error?
        if ( mysqli_connect_error() ) {
        	
			// sheeeet
			throw new Exception("DB Connection Error #"
				. mysqli_connect_errno()
				. " - "
           		. mysqli_connect_error()
			);
			
        }
		
    }
	
	// The big Q executes a query with some error checking built it,
	// reutrns the result oject
	public function Q($query) {
		
		// no query string fool?
		if(!$query) {
			throw new Exception("DB Find Error - Requires \$query to be passed as an string but was not.");	
		}
		
		// did we get a result?
		if( $result = $this->query($query) ) {
						
			// return result object
			return $result; 
		
		} else {
			
			throw new Exception("DB Error - ".$this->error);
			
		}
		
	}
	
}

// connect
$DB = new DB();

?>