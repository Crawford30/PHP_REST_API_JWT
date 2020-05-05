<?php 

ini_set("display_errors", 1);

//INCLUDE VENDER FOLDER

require '../vendor/autoload.php'; //we go back 

use \Firebase\JWT\JWT;


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

	//GETTING DATA FROM THE BODY SECTION

	//$data = json_decode(file_get_contents("php://input"));


	//READING HEADER

	$all_headers = new StdClass;  //to remove creating new object for empty class warning

	$all_headers = getallheaders();

	$data = new StdClass;  //to remove creating new object for empty class warning


	$data -> jwt = $all_headers['Authorization']; //getting the jwt from the header with the Authorization from postman


	//CHECK THE DATA IN THE BODY SECTION, checkig the jwt token 

	if (!empty($data -> jwt)) {

		//PPUT THE TOKEN IN TRY CATCH

		try {


			//SECRETE KEY use for encoding will be use for decoding data

					$secret_key = "owt125";


					//DECODING

					$decoded_data = JWT::decode($data -> jwt,$secret_key, array('HS512')); //:: means a static method

					


					http_response_code(200);

					//GETTING USER ID

					$User_ID = $decoded_data -> data -> id;


					echo json_encode(array(
						"status" => 1,
						"message" => "We got JWT Token",
						"user_data" => $decoded_data,
						"user_id" => $User_ID 

					));


		} catch (Exception $ex) {

			http_response_code(500);  //internal server error
			echo json_encode(array(

				"status" => 0,
				"message" => $ex -> getMessage()
			));


		}



					


					

	} else {

	}


}


?>