<?php 

//Debugger mode

ini_set("display_errors", 1);

//INCLUDE THE HEADERS

header("Aceces-Control-Allow-Origin: *");

header("Aceces-Control-Allow-Methods: POST");

header("Content-type: application/json; charset = UTF-8");

//INCLUDING FILES

include_once("../config/database.php"); //go one folder back  

include_once("../classes/Users.php"); //go one folder back  

//OBJECTS

$db = new Database(); //inside database.php ie its class name


//CALLING CONNECT METHOD

$connection = $db -> connect();

$user_obj = new Users($connection); //pass our connection variable


//CHECKING FILE TO ONLY BE ACCESSED FOR POST REQUEST TYPE

if ($_SERVER['REQUEST_METHOD'] === "POST") {

	//if successful, we connect the data to the body

	$data = json_decode(file_get_contents("php://input"));

	//CHECK THE DATA TO MAKE SURE IT  HAS THE PARAMETERS

	if (!empty($data -> name) && !empty($data -> email)  && !empty($data -> password)) {

		//if not empty, we initailise 
		$user_obj -> name  = $data -> name;

		$user_obj -> email  = $data -> email;

		$user_obj -> password  = password_hash($data -> password, PASSWORD_DEFAULT);




		//WE CHECK THE EMAIL TO MAKE SURE ITS NOT REGISTRED WITH
		
		$email_data = $user_obj -> check_email();

		if (!empty($email_data)) {

			//means we have some data, insertion should not go

			//means we have email already
		http_response_code(500); //server

		echo json_encode(array(

		"status" => 0,
		"message" => "User already exists, please try another email address"


	));



		} else {


//WE CALL OUT METHOD create_user

		if ($user_obj -> create_user()) {

		//means no data
		http_response_code(200); //ok

		echo json_encode(array(

		"status" => 1,
		"message" => "User has been ceated successfully"


		));



		} else {


			//means failed  to create user
		http_response_code(500); //server

		echo json_encode(array(

		"status" => 0,
		"message" => "Failed to save user"


		));



		}


		}




		

	} else {

		//means no data
		http_response_code(500); //server

		echo json_encode(array(

		"status" => 0,
		"message" => "All data needed"


	));
	}







} else {

	http_response_code(503);

	echo json_encode(array(

		"status" => 0,
		"message" => "Access Denied"


	));
}




?>