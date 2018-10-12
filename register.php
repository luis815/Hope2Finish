<?php

/*
	PLEASE NOTE: Due to reason(s) unknown, GitHub has decided to use one of my aliases used for a completely different
	account of mine, instead of my real name. The alias "Michael Belker" is actually myself, "Christopher Pei".
*/

namespace REGISTRATION;

require_once "system.php";
require_once "db.php";

//	CONSTANTS
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------


//	MISC SETTINGS
//	-------------------------------------------------------------------------------------

define(__NAMESPACE__ . "\LOG_NAME", __DIR__ . DIRECTORY_SEPARATOR . __NAMESPACE__ . ".log");
define(__NAMESPACE__ . "\LOGGING", false);
define(__NAMESPACE__ . "\MAX_EMAIL_LENGTH", 255);
define(__NAMESPACE__ . "\MIN_USERNAME_LENGTH", 3);
define(__NAMESPACE__ . "\MAX_USERNAME_LENGTH", 32);
define(__NAMESPACE__ . "\MIN_PASSWORD_LENGTH", 3);
define(__NAMESPACE__ . "\MAX_PASSWORD_LENGTH", 255);

//	API key that must be included with API Requests as the value for parameter "k" for authorization.
define(__NAMESPACE__ . "\API_KEY", "12345");


//	ERROR MESSAGE STRINGS (ENGLISH)
//	-------------------------------------------------------------------------------------

define(__NAMESPACE__ . "\EN_ERROR_MISSING_FIELDS", "");
define(__NAMESPACE__ . "\EN_ERROR_INVALID_EMAIL", "");
define(__NAMESPACE__ . "\EN_ERROR_INVALID_USERNAME", "The username you provided is not available. Usernames must have at least " . MIN_USERNAME_LENGTH . " characters, can have no more than " . MAX_USERNAME_LENGTH . " characters, and may not contain spaces.");
define(__NAMESPACE__ . "\EN_ERROR_INVALID_PASSWORD", "The password you provided does not meet the requirements. Passwords must be a minimum of " . MIN_PASSWORD_LENGTH . " characters long and no more than " . MAX_PASSWORD_LENGTH . " characters long.");
define(__NAMESPACE__ . "\EN_ERROR_PASSWORD_MISMATCH", "The passwords you provided do not match.");
define(__NAMESPACE__ . "\EN_ERROR_UNKNOWN", "An unknown error has occurred.");



//	VARS
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------

$external_css = '<link rel="stylesheet" href="https://cdn.dbmxpca.com/fonts/stylesheet.css" type="text/css" charset="utf-8" />';

$css = 
'

body {
	
	font-family: \'Helvetica Rounded LT Std\';
    font-weight: bold;
    font-style: normal;	
}

label {
	
	display: inline-block;
	float: left;
	clear: left;
	width: 150px;
	text-align: right;
	margin-right: 10px;
}

input {
	
	display: block;
	margin-bottom: 10px;
}

button {
	
	display: inline-block;
	float: right;
	font-family: \'Helvetica Rounded LT Std\';
    font-weight: bold;
    font-style: normal;
}

#error {
	margin: 0 auto;
	margin-top: 10px;
	width: 60%;
	min-width: 200px;
	color: rgb(255, 0, 0);
}


';

$html_begin = '<html><head><title>Register | FALL_2018_CSE442_CHRISTOPHER_PEI</title>' . $external_css . '<style> ' . $css . '</style></head><body>';
$html_end = '</body></html>';
$html_error_begin = '<div id="error">';
$html_error_end = '</div>';



$form_signup = 
'
<form action="/register.php" method="post" style="margin: 0 auto;width:60%;min-width:200px;">
	<fieldset>
	
		<legend><h1>Register A New Account</h2></legend>
		
		<label>Email Address:</label>
		<input type="text" placeholder="" name="email" size="40" required />
		
		<label >Username:</label>
		<input type="text" placeholder="" name="username" size="40" required>
		
		<label for="password1">Password:</label>
		<input type="password" placeholder="" name="password1" size="40" required>
		
		<label for="password2">Confirm Password:</label>
		<input type="password" placeholder="" name="password2" size="40" required>
		
		<button type="submit">Create Account</button>
		
	</fieldset>
</form>
';

//	FUNCTIONS
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------



//	@summary	Checks if a form was submitted with any data. Does not check validity of input.
//	@return		Returns true if form was submitted with any data.
function WAS_FORM_SUBMITTED(){
	
	if (
		isset($_REQUEST['email']) ||
		isset($_REQUEST['username']) ||
		isset($_REQUEST['password1']) ||
		isset($_REQUEST['password2'])
		) return true;
		return false;
}



//	@summary	Checks if submitted form data is valid.
//	@return		Returns true if form was submitted with valid data.
//	@$error		This return var indicates reason for invalid data:
//				0 = missing/blank fields; 1 = invalid email; 2 = username too short/long;
//				3 = password's do not match; 4 = password too short/long;
function IS_FORM_DATA_VALID(&$error){	
	
	//	Ensure fields are set and not blank.
	if (!isset($_REQUEST['email']) || empty($_REQUEST['email']) ||
		!isset($_REQUEST['username']) || empty($_REQUEST['username']) ||
		!isset($_REQUEST['password1']) || empty($_REQUEST['password1']) ||
		!isset($_REQUEST['password2']) || empty($_REQUEST['password2'])){
		
		$error = 0;
		return false;
	}
	
	//	Since these are all defined, make copy of the content so as to not alter original when editing them.
	$t_e = $_REQUEST['email'];
	$t_u = $_REQUEST['username'];
	$t_p1 = $_REQUEST['password1'];
	$t_p2 = $_REQUEST['password2'];
	
	//	Strip appropriate fields of any tags and whitespaces.
	$t_e = strip_tags(\SYSTEM\REMOVE_WHITESPACE($t_e));
	$t_u = strip_tags(\SYSTEM\REMOVE_WHITESPACE($t_u));
	
	//	Does the email address have the "@" character? Is the email address at least least 3-characters long?
	if (!\SYSTEM\CONTAINS($t_e, "@") ||
		strlen($t_e) < 3){
			
		$error = 1;
		return false;
	}
	
	//	Is the email in an valid format?
	if (!\SYSTEM\IS_EMAIL_VALID($t_e)){
		
		$error = 1;
		return false;
	}
	
	//	Does username meet minimum length requirements?
	if ((strlen($t_u) < MIN_USERNAME_LENGTH) || (strlen($t_u) > MAX_USERNAME_LENGTH)){
		
		$error = 2;
		return false;
	}
	
	//	Do both password fields match?
	if (strcmp($t_p1, $t_p2) != 0){
		
		$error = 3;
		return false;
	}
	
	//	Does password meet minimum length requirements?
	if ((strlen($t_p1) < MIN_PASSWORD_LENGTH) || (strlen($t_p1) > MAX_PASSWORD_LENGTH)){
		
		$error = 4;
		return false;
	}
	
	return true;
}


//	@summary	Returns sanitized version of submitted registration form data. Here, "sanitized" refers
//				to the data being truncated to maximum lengths in case it is larger to avoid buffer
//				overflows, and formatted properly to be accepted for processing. The sanitized email,
//				username, and password are supplied (by the function) in the variables passed by reference.
//	@return		Returns true on successful sanitizing of all components. Returns false if one more fields
//				are missing (null), empty, or if the password doe not match the confirmation password.
function GET_FORM_DATA(&$email, &$username, &$password){
	
	//	Ensure all fields are set.
	if (!isset($_REQUEST['email']) ||
		!isset($_REQUEST['username']) ||
		!isset($_REQUEST['password1']) ||
		!isset($_REQUEST['password2'])
		) return false;
		
	//	Ensure they are not empty.
	if (empty($_REQUEST['email']) ||
		empty($_REQUEST['username']) ||
		empty($_REQUEST['password1']) ||
		empty($_REQUEST['password2'])
		) return false;
		
	//	Ensure passwords match. Note that " == 0" means they match so anything other than this = mismatch.
	if (strcmp($_REQUEST['password1'], $_REQUEST['password2']))
		return false;
	
	//	Make copy of the content so as to not alter original.
	$t_e = $_REQUEST['email'];
	$t_u = $_REQUEST['username'];
	$t_p = $_REQUEST['password1'];
	
	//	Sanitize: remove any whitespace characters and tags.
	$t_e = strip_tags(\SYSTEM\REMOVE_WHITESPACE($t_e));
	$t_u = strip_tags(\SYSTEM\REMOVE_WHITESPACE($t_u));
	
	//	Truncate. NOTE: Under proper operation, the form should never accept fields that are longer than they
	//	should be, however this is done for a better fail-safe solution.
	if (strlen($t_e) > MAX_EMAIL_LENGTH)
		$email = TRUNCATE($t_e, MAX_EMAIL_LENGTH);
	if (strlen($t_u) > MAX_USERNAME_LENGTH)
		$username = TRUNCATE($t_u, MAX_USERNAME_LENGTH);
	if (strlen($t_p) > MAX_PASSWORD_LENGTH)
		$password = TRUNCATE($t_p, MAX_PASSWORD_LENGTH);
	
	
	//	"Return" the sanitized values.
	$email = $t_e;
	$username = $t_u;
	$password = $t_p;
	
	return true;
}



//	SCRIPT BEGINS
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------

$user_registration_result = 0;

//	Check if all fields have been submitted.
if (WAS_FORM_SUBMITTED()){
	
	$error = 0;
	if (!IS_FORM_DATA_VALID($error)){
		
		switch($error){
			case 0:
				$_SESSION['error_message'] = "Please fill out <u>all</u> fields.";
				break;
			case 1:
				$_SESSION['error_message'] = "The <u>email address</u> you provided appears to be invalid.";
				break;
			case 2:
				$_SESSION['error_message'] = "Your <u>username</u> must contain between " . MIN_USERNAME_LENGTH . "-" . MAX_USERNAME_LENGTH . " character(s).";
				break;
			case 3:
				$_SESSION['error_message'] = "The two <u>passwords</u> you provided do not match.";
				break;
			case 4:
				$_SESSION['error_message'] = "Your <u>password</u> must contain between " . MIN_PASSWORD_LENGTH . "-" . MAX_PASSWORD_LENGTH . " character(s).";
				break;
			default:
				$_SESSION['error_message'] = "This error is reserved for future mist- errrrrrr um, dank-memes.";
				break;
		}
		
		$_SESSION['error_message'] .= " Please try again.";
	}
	
	else{
	
		//	Create user account.
		
		$error_count = 0;
		
		//	Get form data.
		\SYSTEM\LOG("INFO", "Fetching registration form data...");
		$email = $username = $password = "";
		GET_FORM_DATA($email, $username, $password) ? \SYSTEM\LOG("INFO", "... [OK]") : \SYSTEM\LOG("ERROR", "... [FAILED]");
		
		//	Hash the password.
		\SYSTEM\LOG("INFO", "Generating password hash...");
		$password_hash = \SYSTEM\GENERATE_PASSWORD_HASH($password);
		
		if ($password_hash === FALSE){
			
			$error_count++;
			\SYSTEM\LOG("INFO", "... [FAILED]");
		}
		else
			\SYSTEM\LOG("INFO", "... [OK]");
		
		
		if ($error_count == 0){
			
			$salt = "-";	//	Temporary.
			$user_registration_result = \DB\CREATE_USER($username, $password_hash, $salt, $email);
			
			switch($user_registration_result){
				
				case 0:	//	Success.
					$_SESSION['error_message'] = "<h3 style=\"color:rgb(0,180,0);\">Success!</h3><h4 style=\"color:rgb(0,180,0);\"> Your account has been created.<br>Click <a href=\"#\">here</a> to login.</h4>";
					$_SESSION['error_message_api'] = "User account created successfully.";
					break;
				case 2:	//	Account already exists.
					$error_count++;
					$_SESSION['error_message'] = "<h3 style=\"color:rgb(180,0,0);\">Sorry!</h3><h4 style=\"color:rgb(180,0,0);\"> An account with that username already exists.<br>Existing users can click <a href=\"#\">here</a> to login.</h4>";
					$_SESSION['error_message_api'] = "User account already exists.";
					break;
				default:	//	General error.
					$error_count++;
					$_SESSION['error_message'] = "<h3 style=\"color:rgb(180,0,0);\">Sorry!</h3><h4 style=\"color:rgb(180,0,0);\"> Account creation failed.</h4>";
					$_SESSION['error_message_api'] = "Unknown error.";
					break;
				
			}
		}
		
		//$salt = "SAMPLE_SALT";
		
		//$result = CREATE
		
		
		
		
		
		// $_SESSION['error_message'] = "<h3 style=\"color:rgb(0,180,0);\">Success!</h3><h4 style=\"color:rgb(0,180,0);\"> Your account has been (hypothetically) created.<br>Hypothetically, you will be able to click <a href=\"#\">here</a> to login.</h4>";
 
 
	}
	
	//	API Requests
	//	------------------------------------------------------------------- BEGIN API REQUEST PROCEDURES
	
	/*
	#####################################################################################
	
	To issue an API request to REGISTER.PHP, send the following (additional) parameters:
	
		&api=1&k=XXXXX
	
	where XXXXX is the API Key defined by the API_KEY constant at the top of this file.
	For example, if the API_KEY constant is "12345", you would send the following:
	
		&api=1&k=12345
		
	Full request example:
	
	https://cse442.dbmxpca.com/register.php?email=test@domain.com&username=testuser579&password1=123456&password2=123456&api=1&k=12345
	
	#####################################################################################
	*/
	
	if (isset($_REQUEST['api'])){
		
		\SYSTEM\LOG("INFO", "Possible API request detected.");
		
		//	Set JSON page/content type and instantiate the JSON object.
		header('Content-Type: application/json');
		$j = new \stdClass();
		
		$j->success = false;
		$j->error_code = -5;
		$j->error_message = "No data provided.";
		
		\SYSTEM\LOG("INFO", "Checking data (Step 1 of 3)...");
		
		if (!strcmp($_REQUEST['api'], "1") || ($_REQUEST['api'] === 1)){
			
			\SYSTEM\LOG("INFO", "Checking data (Step 2 of 3)...");
			
			//	Verify API Key
			if (isset($_REQUEST['k'])){
				
				\SYSTEM\LOG("INFO", "Checking data (Step 3 of 3)...");
				
				if (!strcmp($_REQUEST['k'], API_KEY)){
					
					\SYSTEM\LOG("INFO", "Data successfully verified.");
					
					if ($error_count == 0 && $user_registration_result == 0)
						$j->success = true;
					else
						$j->success = false;
					
					//	Error Code
					$j->error_code = $user_registration_result;
					
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
				$j->error_code = -1;
				
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
	
	//	Normal (Front-End) Request
	echo $html_begin;
	echo $form_signup;
	
	if (isset($_SESSION['error_message'])){
		
		echo $html_error_begin;
		echo $_SESSION['error_message'];
		echo $html_error_end;
	}
	
	echo $html_end;
	
	exit(1);	
}

else{
	
	echo $html_begin;
	echo $form_signup;
	echo $html_end;
}



?>
