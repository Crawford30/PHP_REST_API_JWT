<?php 

ini_set("display_errors", 1);

//INCLUDE VENDER FOLDER

require '../vendor/autoload.php'; //we go back 

use \Firebase\JWT\JWT;


//include headers

header("Access-control-Allow: *");

header("Access-control-Allow-Methods: GET");


//INCLUDING FILES

include_once("../config/database.php"); //go one folder back  

include_once("../classes/Users.php"); //go one folder back 


//OBJECTS

$db = new Database(); //inside database.php ie its class name


//CALLING CONNECT METHOD

$connection = $db -> connect();

$user_obj = new Users($connection); //pass our connection variable


//CHECKING REQUEST TYPE


if ($_SERVER['REQUEST_METHOD'] === "GET") { 



	$headers = getallheaders(); //get all the headers of which jwt token is in the header


	$jwt = $headers['Authorization']; //has authorization as the key

	 


	//WE DECODE THE JWT IN  A TRY CATCH BLOCK

	try {

		 $secret_key = "owt125";


		//WE DECODE THE JWT TOKEN

		$decoded_data = JWT::decode($jwt, $secret_key,array('HS512'));

		//WE GET THE USER ID FROM $decoded_data

		$user_obj -> user_id = $decoded_data -> data -> id; //from login, we see data having id as a key



	//CALL METHOD TO GET PROJECTS FROM THE USER CLASS

	$projects = $user_obj -> get_user_all_projects();

	//print_r($projects);

	//IT PRINTS OUT THE num_row which is the number of rows so we check it out ie checking for any record

	if ($projects -> num_rows > 0) {

		//DECKARE EMPTY ARRAY TO STORE

		$projects_arr = array();

		//here means we  have projects

		//use whie to loop, row by row

		while ($row = $projects -> fetch_assoc() ) {

			$projects_arr[] = array(

				"id" => $row['id'],

				"name" => $row['name'],

				"description" => $row['description'],

				"user_id" => $row['user_id'],

				"status" => $row['status'],

				"created_at" => $row['created_at']
			);
		}


		//PREPARE OUR OUTPUT FORMAT

		http_response_code(200);

		echo json_encode(array(

			"status" => 1,
			"projecs" => $projects_arr
		));

		




	} else {
		http_response_code(404); //error

		echo json_encode(array(
			"status" => 0,
			"message" => "No Project found"

		));
	}





	} catch(Exception $ex) {

		http_response_code(500); //error

		echo json_encode(array(
			"status" => 0,
			"message" => $ex -> getMessage()

		));





	}





	// //CALL METHOD TO GET PROJECTS FROM THE USER CLASS

	// $projects = $user_obj -> get_user_all_projects();

	// //print_r($projects);

	// //IT PRINTS OUT THE num_row which is the number of rows so we check it out ie checking for any record

	// if ($projects -> num_rows > 0) {

	// 	//DECKARE EMPTY ARRAY TO STORE

	// 	$projects_arr = array();

	// 	//here means we  have projects

	// 	//use whie to loop, row by row

	// 	while ($row = $projects -> fetch_assoc() ) {

	// 		$projects_arr[] = array(

	// 			"id" => $row['id'],

	// 			"name" => $row['name'],

	// 			"description" => $row['description'],

	// 			"user_id" => $row['user_id'],

	// 			"status" => $row['status'],

	// 			"created_at" => $row['created_at']
	// 		);
	// 	}




	// 	//PREPARE OUR OUTPUT FORMAT

	// 	http_response_code(200);

	// 	echo json_encode(array(

	// 		"status" => 1,
	// 		"projecs" => $projects_arr
	// 	));

		




	// } else {
	// 	http_response_code(404); //error

	// 	echo json_encode(array(
	// 		"status" => 0,
	// 		"message" => "No Project found"

	// 	));
	// }

}





?>