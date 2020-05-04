<?php 
/**
 * 
 */
class Database {

	//varrabl declation

	private $hostname;
	private $dbname;
	private $username;
	private $password;

	private $conn;

	//Connection methd


	public function connect() {

		//use mysql funntion to connection

		//variable initialisation

		$this -> hostname = "localhost";
		$this -> dbname = "rest_php_api";
		$this -> username = "root";
		$this -> password = "";


		//we connect our database

		$this -> conn = new mysqli($this -> hostname, $this -> username, $this -> password,  $this -> dbname);

		//checking for conection

		if ($this -> conn -> connect_errno) {

			//if error print connection error, if true it means it has some error

			print_r($this -> conn ->  connect_error);

			exxit;  //exit from the class

		} else {

			//if connection is succesfull, if false means no error and hence connection succesfull

			return  $this -> conn;

				//PRINTING IN BROWSER

			// print_r($this -> conn);



		}



	}
	
	
}


// //testing if the class works

// $db = new Database();

// //calling the method

// $db -> connect();



?>