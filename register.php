<?php

/*
	PLEASE NOTE: Due to reason(s) unknown, GitHub has decided to use one of my aliases used for a completely different
	account of mine, instead of my real name. The alias "Michael Belker" is actually myself, "Christopher Pei". :)
*/

namespace REGISTRATION;

define(__NAMESPACE__ . "\LOG_NAME", __DIR__ . DIRECTORY_SEPARATOR . __NAMESPACE__ . ".log");
define(__NAMESPACE__ . "\LOGGING", false);

define(__NAMESPACE__ . "\MIN_USERNAME_LENGTH", 3);
define(__NAMESPACE__ . "\MAX_USERNAME_LENGTH", 32);
define(__NAMESPACE__ . "\MIN_PASSWORD_LENGTH", 3);
define(__NAMESPACE__ . "\MAX_PASSWORD_LENGTH", 255);


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

//	@summary	Checks if $data contains $search.
//	@return		Returns true if $search is in $data.
function CONTAINS($data, $search){
	if( strpos($data, $search) !== false ) return true;
	return false;
}

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
	
	//	Does the email address have the "@" character? Is the email address at least least 3-characters long?
	if (!CONTAINS($_REQUEST['email'], "@") ||
		strlen($_REQUEST['email']) < 3){
			
		$error = 1;
		return false;
	}
	
	//	Does username meet minimum length requirements?
	if ((strlen($_REQUEST['username']) < MIN_USERNAME_LENGTH) || (strlen($_REQUEST['username']) > MAX_USERNAME_LENGTH)){
		
		$error = 2;
		return false;
	}
	
	//	Do both password fields match?
	if (strcmp($_REQUEST['password1'], $_REQUEST['password2']) != 0){
		
		$error = 3;
		return false;
	}
	
	//	Does password meet minimum length requirements?
	if ((strlen($_REQUEST['password1']) < MIN_PASSWORD_LENGTH) || (strlen($_REQUEST['password1']) > MAX_PASSWORD_LENGTH)){
		
		$error = 4;
		return false;
	}
	
	return true;
}


//	@summary	Sanitizes submitted form data. The sanitized email, username, and password
//				are returned in the variables passed by reference.
//	@return		void
function GET_FORM_DATA(&$email, &$username, &$password){
	
	//TODO
}



//	SCRIPT BEGINS
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------

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
	
	else $_SESSION['error_message'] = "<h3 style=\"color:rgb(0,180,0);\">Success!</h3><h4 style=\"color:rgb(0,180,0);\"> Your account has been (hypothetically) created.<br>Hypothetically, you will be able to click <a href=\"#\">here</a> to login.</h4>";
		
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
