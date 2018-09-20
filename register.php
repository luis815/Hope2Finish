<?php

$external_css = '<link rel="stylesheet" href="https://cdn.dbmxpca.com/fonts/stylesheet.css" type="text/css" charset="utf-8" />';

$css = 
'

body {
	
	font-family: \'Helvetica Rounded LT Std\';
    font-weight: bold;
    font-style: normal;
	
	/*
	font-family: \'Helvetica LT Std\';
	font-weight: bold;
    font-style: normal;
	*/
	
	/*
	font-family: \'ChaletComprime-CologneSixty\';
    font-weight: normal;
    font-style: normal;
	*/
	
}

label {
	
	display: inline-block;
	float: left;
	clear: left;
	width: 150px;
	text-align: right;
	margin-right: 10px;
	/* margin-top: 5px; */
	/* margin-bottom: 5px; */
}

input {
	
	display: block;
	margin-bottom: 10px;
	/* float: left; */
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


echo $html_begin;
echo $form_signup;
echo $html_end;

?>
