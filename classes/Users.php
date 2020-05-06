<?php 

ini_set("display_errors", 1);

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


		//METHOD TO CHECK THAT ONLY ONE EMAIL ADDRESSED IS USED

		public function  check_email() {

			$email_query = "SELECT * FROM ".$this -> users_tbl." WHERE  email = ?";

			//PREPARE THE QUERY

			$usr_obj = $this -> conn -> prepare($email_query);


			//BINDING PARAMETERS

			$usr_obj -> bind_param("s", $this -> email);


			//EXECUTE

			if ($usr_obj -> execute()) {

				//if sucessful

				$data = $usr_obj -> get_result();

				return $data -> fetch_assoc();


			
			} 

			return array(); //if not succesful we return empty array


		}


		//CHECK LOGIN METHOD
		public function check_login() {


			$email_query = "SELECT * FROM ".$this -> users_tbl." WHERE  email = ? ";

			//PREPARE THE QUERY

			$usr_obj = $this -> conn -> prepare($email_query);


			//BINDING PARAMETERS

			$usr_obj -> bind_param("s", $this -> email);


			//EXECUTE

			if ($usr_obj -> execute()) {

				//if sucessful

				$data = $usr_obj -> get_result();

				return $data -> fetch_assoc();


			
			} 

			return array(); //if not succesful we return empty array

		}



		//METHOD TO CREATE PROJECTS

		public function create_project() {

			$project_query = "INSERT INTO ".$this -> projects_tbl."  SET user_id = ?, name = ?, description = ?, status = ?";

			//PREPARE

			$project_obj = $this -> conn -> prepare($project_query);

			//SANITIZE INPUT VARIABLES
			$project_name = htmlspecialchars(strip_tags($this -> project_name));

			$description = htmlspecialchars(strip_tags($this -> description));

			$status = htmlspecialchars(strip_tags($this -> status));


			//BINDING THE PARAMETERS
			$project_obj -> bind_param("isss", $this -> user_id, $this -> project_name, $this -> description, $this -> status); //from the project table, we have user_id, project_name, description,status

			//CHECK AND EXECUTE THE QUERY

			if ($project_obj -> execute()) {

				return true;
			}

			return false;


		}



		



	// used to list all projects
  public function get_all_projects(){

    $project_query = "SELECT * FROM ".$this->projects_tbl." ORDER BY id DESC";

    $project_obj = $this -> conn -> prepare($project_query);

    $project_obj -> execute();

    return $project_obj -> get_result();

  }









}




?>