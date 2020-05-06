// //PASS PAREMETER INSSIDE THE BODY AND TOKEN INSIDE THE HEADER

	// //1. BODY
	// $data = json_decode(file_get_contents("php://input"));

	// //2. Header

	// $headers  = new StdClass;
	// $headers = getallheaders();

	// //CHECKING IF NOT EMPTY FOR THE FIELDS IN THE BODY

	// if (!empty($data -> name) && !empty($data -> description) && !empty($data -> status) ) {

	// 	//Data are there, hence we check about jwt validation, when it get expired hence we use try and catch

	// 	try {

	// 			//GETTING TOKEN FROM THE HEADER

	// 			$jwt = $headers["Authorization"];

	// 				//SECRETE KEY use for encoding will be use for decoding data

	// 				$secret_key = "owt125";


	// 				//DECODING

	// 				$decoded_data = JWT::decode($jwt, $secret_key, array('HS512')); //:: means a static method


	// 				//INITIALISE THE USE VARIABLE USING THE  $user_obj and that the User class

	// 				$user_obj -> user_id = $decoded_data -> data -> id;

	// 				$user_obj -> project_name = data -> name;

	// 				$user_obj -> project_description = data -> description;

	// 				$user_obj -> project_status =  data -> status;


	// 				//WE CALL THE CREATE PROJECT METHOD 

	// 				if ($user_obj -> create_projects()) {

	// 					   //if successful

	// 						http_response_code(200);  //OK
	// 						echo json_encode(array(

	// 						"status" => 1,
	// 						"message" => "Project has been successfully created"


	// 					));

	// 				} else {


	// 						http_response_code(500);  //server error
	// 						echo json_encode(array(

	// 						"status" => 0,
	// 						"message" => "Failed to create project"


	// 					));



	// 				}




	// 	} catch(Exception $ex) {

	// 		http_response_code(500);  //server error
	// 		echo json_encode(array(

	// 		"status" => 0,
	// 		"message" => $ex ->  getMessage()


	// 	));

	// 	}








	// } else {

	// 	http_response_code(404); //not found

	// 	echo json_encode(array(

	// 		"status" => 0,
	// 		"message" => "All data needed."


	// 	));

	// }