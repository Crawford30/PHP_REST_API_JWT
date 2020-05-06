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

	//1. BODY
	
	$data = json_decode(file_get_contents("php://input"));


	//2. headers

	$headers = getallheaders();

	//CHECK

	if (!empty($data -> name) && !empty($data -> description)  && !empty($data -> status)) {

		//means we have all the data in the body, we check about jwt token

		 try {

		 	$jwt = $headers["Authorization"];

		 	//READ JWT DATA
		 	//SECRETE KEY use for encoding will be use for decoding data

					$secret_key = "owt125";

					//DECODING

					$decoded_data = JWT::decode($jwt, $secret_key, array('HS512')); //:: means a static method



					//INITIALIZE CLASS LABEL  VARIABLES FROM THE USER CLASS

					$user_obj -> user_id =  $decoded_data -> data -> id; //has key data and id as parameter from the login api

					$user_obj -> project_name =  $data -> name;

					$user_obj -> description =  $data -> description;

					$user_obj -> status =  $data -> status;


					//CHECK TO CALL THE CREATE PRPJECT METHOD

					if ($user_obj -> create_project()){

						//if successful

						http_response_code(200); //ok

						echo json_encode(array(

							"status" => 1,
							"message" => "project has been created"



						));

					} else {

						//if not sucess

						http_response_code(500); //server error

						echo json_encode(array(

							"status" => 0,
							"message" => "Failed to create project"
						));



					}








		 } catch(Exception $ex) {


		 	http_response_code(500); //server error

		 	echo  json_encode(array(

		 		"status" => 0,
		 		"message" => $ex -> getMessage()

		 	));

		 }





	} else {

		http_response_code(404); //not found

		echo json_encode(array(

			"status" => 0,
			"message" => "All data needed"
		));

	}






} 




?> 







 