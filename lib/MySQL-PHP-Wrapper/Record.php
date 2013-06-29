<?php
/* 
 * Record Class
 * 
 * Abstracted data record class for interacting with MySQL Records
 * 
 */
class Record {
	
	// table
	public $table = NULL;
	public $id = NULL;
	
	// Constructor
	public function __construct($id) {
		
		// DB Object
		global $DB;
			
		// if we don't have the DB object	
		if(!$DB) {
			
			// sorry newb, can't used record
			throw new Exception("$DB Global object not found, cannot connect to DB!");	
		}
		
		// make sure we have a table
		if(!$this->table) {
			
			throw new Exception("Record does not have table defined!");	
			
		}
		
		// are we trying to get a specific object?
		if($id) {
			
			// instantiate it
			$this->instantiate($id);
 	
		}
		
	} 
	
	// set our table
	public function setTable($table) {
		
		$this->table = $table;
		
	}
	
	// Finds documents in a table
	public function find($expression,$where) {
		
		global $DB;
		
		if(!$expression) {
			throw new Exception("Record->find() requires (string) \$expression but not supplied!");	
		}
		
		// build the query
		$query = "SELECT {$expression} FROM {$this->table}";
		
		// do we have where clause?
		if($where) {
			$query .= " WHERE {$where}";
		}
		
		// end the query
		$query .= ";";
		
		//die($query);
		
		// return results
		return $DB->Q($query);
		
	}
	
	// Returns a specific row by ID 
	public function get($id) {
		
		// make sure we have a table
		if( !$id || !is_int($id) )  {
			throw new Exception("Record->get() requires (int) \$id but not supplied!");	
		}
		
		// did we pass an id? 
		if($id) {
			$this->id = $id;
		}
		
		$result = $this->find("*"," id = {$this->id} LIMIT 1");

		if($result->nuw_rows===0) {
			
			return $result;
			
		} else {

			return $result->fetch_object();
			
		}
	
	}
	
	// Call to database and assign values to this object
	public function instantiate($id) {
		
		// take the values from get
		$values = $this->get($id);
		
		// did we get values
		if($values) {
				
			// assign values to this object
			foreach($values as $k => $value) {
				
				$this->{$k} = $value;
			}
			
		// we didn't get any values	
		} else {
				
			// sorry bro
			throw new Exception("Record->get() failed to find row with id = {$this->id}");	
			
		}
		
	}
	
	function update() {
		
		var_dump($this->values);
		
	}
	
	
	// create a record
	/*public function create($values) {
		
		// did we not get an array?
		if(!$values || !is_array($values)) {
			throw new Exception("Record->create() requires $values to be passed as an array but was not.");	
		}
		
		// make the insert
		$insert =  $this->table->insert($values);
		
		// did that work?
		if($insert['ok']) {
			
			// return document values with ID
			return $values;
		
		// there was an error	
		} else {
			
			// return the insert 
			return $insert;
			
		}
		
	}
	
	// update a record
	public function update($query = NULL, $values = NULL,$options = array()) {
		
		// did we not get an array?
		if(!$query || !is_array($query)) {
			throw new Exception("Record->update() requires $query to be passed as an array but was not.");	
		}
		
		// did we not get an array?
		if(!$values || !is_array($values)) {
			throw new Exception("Record->update() requires $values to be passed as an array but was not.");	
		}
		
		// set update statement
		$values = array(
			'$set' => $values	
		);	
		
		// make the update
		$update =  $this->table->update($query,$values,$options);
		
		// did that work?
		if($update['ok']) {
			
			// return document values with ID
			return $values;
		
		// there was an error	
		} else {
			
			// return the update 
			return $update;
			
		}
		
	}
	
	// delete a record
	public function delete($query = NULL, $options = array()) {
		
		// did we not get an array?
		if(!$query || !is_array($query)) {
			throw new Exception("Record->delete() requires $query to be passed as an array but was not.");	
		}
		
		// make the update
		$delete =  $this->table->remove($query,$options);
		
		// we succesfully deleted
		if($delete['ok']) {
			return TRUE;
		} else {
			return $delete;
		}
		
	}

	*/
	
}

/*
 * Project Record 
 * 
 * Manages pivotal project
 * 
*/

class Animal extends Record {

	// constructor
	public function __construct($id) {
		
		// set it to the stories collection
		$this->setTable("animals");
		
		// construct
		parent::__construct($id);
		
	}
	
}

?>