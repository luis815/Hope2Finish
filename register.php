<?php

namespace REGISTERATION;

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


';

$html_begin = '<html><head><title>Register</title>' . $external_css . '<style> ' . $css . '</style></head><body>';
$html_end = '</body></html>';


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
//	@$error		This return var indicates reason for invalid data (0 = missing/blank fields; 1 = invalid email; ... )
function IS_FORM_DATA_VALID(&$error){
	
	$result = false;
	
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
	
	
	
	//	Does password meet minimum length requirements?
	
	
	//	Do both password fields match?
	
	
	
}



//	SCRIPT BEGINS
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------

//	Check if all fields have been submitted.






echo $html_begin;
echo $form_signup;
echo $html_end;

?>
