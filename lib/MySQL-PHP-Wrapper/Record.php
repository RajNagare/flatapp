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
	
	public function setProperties($properties) {
		
		// assign values to this object
		foreach($properties as $property => $value) {
			
			$this->{$property} = $value;
		}
		 
	}
	
	public function getProperties() {
		
		return get_object_vars($this);
			
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
	
	
	// Call to database and assign values to this object
	public function instantiate($id) {
		
		// make sure we have a table
		if(!$id)  {
			throw new Exception("Record->instantiate() requires (int) \$id but not supplied!");	
		} else {
		// set the id
			$this->id = (int)$id;
		}
		
		// find this record by id
		$result = $this->find("*"," id = {$this->id} LIMIT 1");

		// take the values from get
		$values = $result->fetch_object();
		
		// did we get values
		if($values) {
				
			// set our properties
			$this->setProperties($values);
			
		// we didn't get any values	
		} else {
				
			// sorry bro
			throw new Exception("Record->instantiate() failed to fetch row with id = {$this->id}");	
			
		}
		
	}
	
	// update database with the object's properties
	function update() {
		
		// global db
		global $DB;
		
		// is this object instantiated?
		if(empty($this->id)) {
			throw new Exception("Record->update() requires that the record is instantiated and has an \$id property set");	
		}
		
		// build the query
		$query = "UPDATE {$this->table} SET ";
		
		// get properties and a count
		$properties = $this->getProperties();
		$propertiesCount = count($properties);
		
		// counter for building the query string
		$queryCounter = 0;
		
		// loop through properties
		foreach($properties as $property => $value) {
			
			// check what properties we are accessing
			switch($property) {
						
				// skip these properties and decrement property count
				case "id":
				case "table": 
					$propertiesCount--;
				break; 	
				
				// otherwise start building query string
				default:
					
					// column and value assignment
					$query .= "{$property} = '{$value}' ";	
			
					// increment query counter
					$queryCounter++;
					
					// check to see if we should append a comma to the query string
					if( $propertiesCount > 1
					&&  $propertiesCount > $queryCounter) {
						$query .= ",";	
					}
				
				break;
				
			}				
			
		}
			
		// where this object id is the key
		$query .= " WHERE id = {$this->id};";
		
		//die($query);
		
		// dat query
		return $DB->Q("$query");
		
	}
	
	
	/*public function insert($values) {
		
		// did we not get an array?
		if(!$values || !is_array($values)) {
			throw new Exception("Record->insert() requires $values to be passed as an array but was not.");	
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

// this gets animal with id 1 and returns the record object
$Animal = new Animal(1);

echo "#{$Animal->id} {$Animal->name}<br/>";
$Animal->name = "Max";
echo "#{$Animal->id} {$Animal->name}<br/>";

$Animal->update();
echo "#{$Animal->id} {$Animal->name}<br/>";

// get a mysqli result object using find
/*$allAnimals = $Animal->find("*","id");

// loop through the mysqli object like a boss 
while($animal = $allAnimals->fetch_object() ){
	
	$test = new Animal($animal->id);
	echo "#{$test->id} {$test->name} / {$animal->name}<br/>";
	//$test->name = "test".rand(1,100);
	echo "#{$test->id} {$test->name} / {$animal->name}<br/>";
	$test->update();
	 
    echo "#{$test->id} {$test->name} / {$animal->name}<br/>";
	echo "<hr/>";
	
} */

die();

?>