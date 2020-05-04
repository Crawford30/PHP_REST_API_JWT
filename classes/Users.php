<?php 

class Users {

	//DEFINE PROPERTIES

	public $name; //got from the user table and project

	public $email;

	public $password;


	public $user_id;  //from the project table

	public $project_name;

	public $description;

	public $status;

	//connection variable

	private $conn;

	private $users_tbl;  // user table name

	private $projects_tbl; //projects table name



//CONSTRUCT FUNCTION

	public function  __construct($db) {

		//initialise connection varriable

		$this -> conn = $db;  //we gonna pass the db in V1 files

		//initialise the table name

		$this -> users_tbl = "tbl_users";

		$this -> projects_tbl = "tbl_projects";


	}

//CREATING USERS

	public function create_user() {

		$user_query = "INSERT INTO ".$this -> users_tbl." SET  name = ?, email = ?, password = ?";

		//PREPARE

		$user_obj = $this -> conn -> prepare($user_query);

		//BINDING PARAMETERS WITH THE PLACE HOLDERS

		$user_obj -> bind_param("sss", $this -> name, $this -> email, $this -> password );


		//EXECUTE

		if ($user_obj -> execute()) {

			return true;

		} 

		return false;


	}







}




?>