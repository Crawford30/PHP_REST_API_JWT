<?php 

//debugger

ini_set("display_errors", 1);

//HEADERS
header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Methods: POST");

header("Content-type: application/json; Charset = UTF-8");



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



	$data = json_decode(file_get_contents("php://input"));


	//CHECK 

	if (!empty($data -> email) && !empty($data -> password)) {

		//we have some data

		//WE INITIALISE SOME PROPERTY
		$user_obj -> email = $data -> email;

		//$user_obj -> password = $data -> password; //we use php function to verify password


		//WE CALL THE METHOD CHECK LOGIN
		$user_data = $user_obj -> check_login();

		//CHECK

		if (!empty($user_data)) {

			//we have some data

			$name = $user_data['name']; //the name is a key read from the users table

			$email = $user_data['email'];

			$password = $user_data['password'];


			//WE USE PASSWORD VERIFY FUNTION OF PHP

			if (password_verify($data -> password, $password))  { //normal password from api, hashed password

				http_response_code(200);

				echo json_encode(array(

				"status" => 1,
				"message" => "User logged in successfully"

				));



			}  else {
				http_response_code(404);

				echo json_encode(array(

				"status" => 0,
				"message" => "Invalid Credentials"

			  ));

			}



		} else {

			http_response_code(404);

			echo json_encode(array(

			"status" => 0,
			"message" => "Invalid Credentials"

		));

		}




	} else {

		http_response_code(404);

		echo json_encode(array(

			"status" => 0,
			"message" => "All data needed"

		));
	}

 }





?>