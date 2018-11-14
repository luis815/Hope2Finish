<?php

/*
	PLEASE NOTE: Due to reason(s) unknown, GitHub has decided to use one of my aliases used for a completely different
	account of mine, instead of my real name. The alias "Michael Belker" is actually myself, "Christopher Pei".
*/

namespace LOGIN;

require_once "system.php";
require_once "db.php";

//	CONSTANTS
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------

define(__NAMESPACE__ . "\MAX_USERNAME_LENGTH", 32);
define(__NAMESPACE__ . "\MAX_PASSWORD_LENGTH", 255);

//	MISC SETTINGS
//	-------------------------------------------------------------------------------------

//	API key that must be included with API Requests as the value for parameter "k" for authorization.
define(__NAMESPACE__ . "\API_KEY", "12345");


//	ERROR MESSAGE STRINGS (ENGLISH)
//	-------------------------------------------------------------------------------------


//	VARS
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------

//	FUNCTIONS
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------



//	@summary	Checks if a form was submitted with any data. Does not check validity of input.
//	@return		Returns true if form was submitted with any data.
function WAS_FORM_SUBMITTED(){
	
	if (
		isset($_REQUEST['username']) ||
		isset($_REQUEST['password'])
		) return true;
		return false;
}



//	@summary	Checks if submitted form data is valid.
//	@return		Returns true if form was submitted with valid data.
//	@$error		This return var indicates reason for invalid data:
//				0 = missing/blank fields;
function IS_FORM_DATA_VALID(&$error){	
	
	//	Ensure fields are set and not blank.
	if (!isset($_REQUEST['username']) || empty($_REQUEST['username']) ||
		!isset($_REQUEST['password']) || empty($_REQUEST['password'])
		){
		
		$error = 0;
		return false;
	}
	
	//	Since these are all defined, make copy of the content so as to not alter original when editing them.
	$t_u = $_REQUEST['username'];
	$t_p = $_REQUEST['password'];
	
	//	Strip appropriate fields of any tags and whitespaces.
	$t_u = strip_tags(\SYSTEM\REMOVE_WHITESPACE($t_u));
	
	return true;
}


//	@summary	Returns sanitized version of submitted registration form data. Here, "sanitized" refers
//				to the data being truncated to maximum lengths in case it is larger to avoid buffer
//				overflows, and formatted properly to be accepted for processing. The sanitized email,
//				username, and password are supplied (by the function) in the variables passed by reference.
//	@return		Returns true on successful sanitizing of all components. Returns false if one more fields
//				are missing (null), empty, or if the password doe not match the confirmation password.
function GET_FORM_DATA(&$username, &$password){
	
	//	Ensure all fields are set.
	if (!isset($_REQUEST['username']) ||
		!isset($_REQUEST['password'])
		) return false;
		
	//	Ensure they are not empty.
	if (empty($_REQUEST['username']) ||
		empty($_REQUEST['password'])
		) return false;
	
	//	Make copy of the content so as to not alter original.
	$t_u = $_REQUEST['username'];
	$t_p = $_REQUEST['password'];
	
	//	Sanitize: remove any whitespace characters and tags.
	$t_u = strip_tags(\SYSTEM\REMOVE_WHITESPACE($t_u));
	$t_p = strip_tags($t_p);
	
	//	Truncate. NOTE: Under proper operation, the form should never accept fields that are longer than they
	//	should be, however this is done for a better fail-safe solution.
	if (strlen($t_u) > MAX_USERNAME_LENGTH)
		$t_u = TRUNCATE($t_u, MAX_USERNAME_LENGTH);
	if (strlen($t_p) > MAX_PASSWORD_LENGTH)
		$t_p = TRUNCATE($t_p, MAX_PASSWORD_LENGTH);
	
	//	Properly encode characters (such as spaces) in password.
	$t_p = rawurlencode($t_p);
	
	//	"Return" the sanitized values.
	$username = $t_u;
	$password = $t_p;
	
	return true;
}



//	SCRIPT BEGINS
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------

$user_login_result = -5;
$error_count = 0;

//	Check if all fields have been submitted.
if (WAS_FORM_SUBMITTED()){
	
	$error = 0;
	if (!IS_FORM_DATA_VALID($error)){
		
		switch($error){
			case 0:
				$_SESSION['error_message'] = "Please fill out <u>all</u> fields.";
				$_SESSION['error_message_api'] = "One or more required fields are missing.";
				break;
			default:
				$_SESSION['error_message'] = "Unknown error.";
				$_SESSION['error_message_api'] = "Unknown error: form data is invalid.";
				break;
		}
		
		$_SESSION['error_message'] .= " Please try again.";
	}
	
	else{
	
		//	Authenticate user account.
		
		//	Get form data.
		\SYSTEM\LOG("INFO", "Fetching login form data...");
		$username = $password = "";
		GET_FORM_DATA($username, $password) ? \SYSTEM\LOG("INFO", "... [OK]") : \SYSTEM\LOG("ERROR", "... [FAILED]");
		
		//	Encode the password.
		\SYSTEM\LOG("INFO", "Encoding password...");
		$password = rawurlencode($password);
		
		\SYSTEM\LOG("INFO", "Transferring login data to authentication procedure...");
		
		//	Returns 1 on success; 0 if incorrect password, 2 if user does not exist.
		$user_login_result = \DB\AUTHENTICATE_USER($username, $password);
		
		switch($user_login_result){
			
			case 1:	//	Success.
				$_SESSION['error_message'] = "<h3 style=\"color:rgb(0,180,0);\">Success!</h3><h4 style=\"color:rgb(0,180,0);\"> You have successfully logged-in.</h4>";
				$_SESSION['error_message_api'] = "User account authentication successful.";
				break;
			case 0:	//	Incorrect password.
				$error_count++;
				$_SESSION['error_message'] = "<h3 style=\"color:rgb(180,0,0);\">Sorry!</h3><h4 style=\"color:rgb(180,0,0);\"> The username and password combination you provided is incorrect.</h4>";
				$_SESSION['error_message_api'] = "Incorrect username and password combination.";
				break;
			case 2:	//	Non-existent user.
				$error_count++;
				$_SESSION['error_message'] = "<h3 style=\"color:rgb(180,0,0);\">Sorry!</h3><h4 style=\"color:rgb(180,0,0);\"> No such user account exists.</h4>";
				$_SESSION['error_message_api'] = "User account does not exist.";
				break;
			case -1:	//	Exception.
				$error_count++;
				$_SESSION['error_message'] = "<h3 style=\"color:rgb(180,0,0);\">Sorry!</h3><h4 style=\"color:rgb(180,0,0);\"> Authentication failed due to an internal error. Contact the system administrator for details.</h4>";
				$_SESSION['error_message_api'] = "Authentication failed due to an exception. See log file for details.";
				break;
			default:	//	General error.
				$error_count++;
				$_SESSION['error_message'] = "<h3 style=\"color:rgb(180,0,0);\">Sorry!</h3><h4 style=\"color:rgb(180,0,0);\"> User authentication failed.</h4>";
				$_SESSION['error_message_api'] = "Unknown error (" . $user_login_result . ").";
				break;
			
		}
	}
	
	//	API Requests
	//	------------------------------------------------------------------- BEGIN API REQUEST PROCEDURES
	
	/*
	#####################################################################################
	
	To issue an API request to LOGIN.PHP, send the following (additional) parameters:
	
		&api=1&k=XXXXX
	
	where XXXXX is the API Key defined by the API_KEY constant at the top of this file.
	For example, if the API_KEY constant is "12345", you would send the following:
	
		&api=1&k=12345
		
	Full request example:
	
	https://cse442.dbmxpca.com/login.php?username=jsmith&password=12345&api=1&k=12345
	
	#####################################################################################
	*/
	
	if (isset($_REQUEST['api'])){
		
		\SYSTEM\LOG("INFO", "Possible API request detected.");
		
		//	Set JSON page/content type and instantiate the JSON object.
		header('Content-Type: application/json');
		$j = new \stdClass();
		
		$j->success = false;
		$j->error_code = -10;
		$j->error_message = "No data provided.";
		
		\SYSTEM\LOG("INFO", "Checking data (Step 1 of 3)...");
		
		if (!strcmp($_REQUEST['api'], "1") || ($_REQUEST['api'] === 1)){
			
			\SYSTEM\LOG("INFO", "Checking data (Step 2 of 3)...");
			
			//	Verify API Key
			if (isset($_REQUEST['k'])){
				
				\SYSTEM\LOG("INFO", "Checking data (Step 3 of 3)...");
				
				if (!strcmp($_REQUEST['k'], API_KEY)){
					
					\SYSTEM\LOG("INFO", "Data successfully verified.");
					
					if ($error_count == 0 && $user_login_result === 1)
						$j->success = true;
					else
						$j->success = false;
					
					//	Error Code
					$j->error_code = $user_login_result;
					
					//	Error Message
					$j->error_message = $_SESSION['error_message_api'];
					$j->error_message_frontend = $_SESSION['error_message'];
				}
				
				//	Invalid API Key
				else{
					
					\SYSTEM\LOG("ERROR", "Data verification failed. Provided API Key is invalid.");
					
					$j->success = false;
					
					//	Error Code
					$j->error_code = -2;
					
					//	Error Message
					$j->error_message = "Invalid API Key";
					$j->error_message_frontend = null;
				}
			}
			
			//	Missing API Key
			else{
				
				\SYSTEM\LOG("ERROR", "Data verification failed. Required API Key is missing.");
				
				$j->success = false;
				
				//	Error Code
				$j->error_code = -5;
				
				//	Error Message
				$j->error_message = "Missing API Key";
			}
		}
		
		echo json_encode($j);
		
		\SYSTEM\LOG("INFO", "End of API request.");
		
		if ($error_count == 0)
			exit(0);
			
		exit(1);
	}
	
	//	------------------------------------------------------------------- END API REQUESTS PROCEDURES
	
	exit(1);	
}

else{
	
	echo $html_begin;
	echo $form_signup;
	echo $html_end;
}



?>
