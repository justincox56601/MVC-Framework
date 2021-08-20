<?php
/**
 * Database class to handle all database connections
 * using prepared statements and bound values
 */

class Database{
	private $dbHost = DB_HOST;
	private $dbUser = DB_USER;
	private $dbPass = DB_PASS;
	private $dbName = DB_NAME;

	private $statement;
	private $dbhandler;
	private $error;
	private static $instance = null;
	private $conn;
	private $table;
	private $types;
	private $values=[];

	public static function getInstance(){
		if(self::$instance == null){
			self::$instance = new Database();
		}

		return self::$instance;
	}

	
	private function __construct(){
		$this->conn =  new mysqli($this->dbHost, $this->dbUser, $this->dbPass, $this->dbName);
	}

	/**
	 * Prepared Statement functions
	 * Query, bind, and execute
	 */

	public function query($sql){
		$this->statement = $this->conn->prepare($sql);
		if(!$this->statement){
			echo $this->conn->error;
		}

	}

	public function bind($value, $type){	
		$this->types .= $type;
		$this->values[] = $value;	
	}

	private function execute(){
		//bind parameters
		$this->statement->bind_param($this->types, ...$this->values);
		
		//resset the values and types properties
		$this->types = '';
		$this->values = [];

		//execute
		return $this->statement->execute();
	}
 
	/**
	 * Public CRUD function 
	 * Create, Read, Update, Delete
	 * all statements are handled in the prepared statements of the models 
	 */
	public function getResults(){
		//returns all entries from the database
		$this->execute();
		$result = $this->statement->get_result();

		//format data as array for return
		$data = [];
		if($result->num_rows > 0){
			while( $row = $result->fetch_object()){
				$data[] = $row;
			};
		}else{
			echo $this->conn->error;
		}

		
		return $data;
		
	}

	public function getSingle(){
		//returns a single entry from the database
		$this->execute();
		$result = $this->statement->get_result();

		return $result->fetch_object();

		
		
	}

	public function insert(){
		//if success returns the id of the inserted row, on fail an error message
		if($this->execute()){
			return $this->statement->insert_id;
		}else{
			echo $this->conn->error;
		}

	}

	public function update(){
		$this->execute();
		$result = $this->statement->get_result();

		return $result->fetch_object();
	}

	public function delete(){
		$this->execute();
		$result = $this->statement->get_result();

		return $result->fetch_object();
	}


	
	
}


