<?php

/*
	PLEASE NOTE: Due to reason(s) unknown, GitHub has decided to use one of my aliases used for a completely different
	account of mine, instead of my real name. The alias "Michael Belker" is actually myself, "Christopher Pei".
*/

namespace UPLOAD;

require_once "system.php";
require_once "db.php";

//	CONSTANTS
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------


//	MISC SETTINGS
//	-------------------------------------------------------------------------------------

//	Master toggle switch to enable or disable video uploads. If disabled, video uploads will not
//	be permitted.
define(__NAMESPACE__ . "\VIDEO_UPLOADS_ENABLED", true);
// define(__NAMESPACE__ . "\VIDEO_UPLOADS_ENABLED", false);


//	Relative path to store raw uploaded video files. Do not include a trailing slash.
//define(__NAMESPACE__ . "\VIDEO_UPLOAD_PATH", "X:\\services\\websvr\\cse442-project\\html\\uploaded-videos");
define(__NAMESPACE__ . "\VIDEO_UPLOAD_PATH", "uploaded-videos");

//	HTML path to raw uploaded video files. Do not include a trailing slash.
define(__NAMESPACE__ . "\VIDEO_HTML_URL", "https://cse442.dbmxpca.com/uploaded-videos");

define(__NAMESPACE__ . "\LOG_NAME", __DIR__ . DIRECTORY_SEPARATOR . __NAMESPACE__ . ".log");
define(__NAMESPACE__ . "\LOGGING", false);

define(__NAMESPACE__ . "\MAX_VIDEO_TITLE_LENGTH", 255);
define(__NAMESPACE__ . "\MAX_VIDEO_DESCRIPTION_LENGTH", 4096);

//	Maximum video file size, in bytes. NOTE: CloudFlare limits all free plans to an HTTP response
//	that may not exceed 100MB. Thus, you should set this value to something less than the maximum
//	to ensure proper submission. Default value: 99000000 (equivalent of 99MB).
define(__NAMESPACE__ . "\MAX_VIDEO_SIZE", 99000000);
// define(__NAMESPACE__ . "\MAX_VIDEO_SIZE", 99000000);

//	Length of generated video ID's.
define(__NAMESPACE__ . "\VIDEO_ID_LENGTH", 16);


define(__NAMESPACE__ . "\ALLOWED_EXTENSIONS", array("mp4", "avi", "webm", "ogv"));


//	API key that must be included with API Requests as the value for parameter "k" for authorization.
define(__NAMESPACE__ . "\API_KEY", "12345");


//	ERROR MESSAGE STRINGS (ENGLISH)
//	-------------------------------------------------------------------------------------

$allowed_extension_list = "";
for ($i = 0; $i < count(ALLOWED_EXTENSIONS); $i++){
	
	if ($i == 0)
		$allowed_extension_list .= ALLOWED_EXTENSIONS[$i];
	else
		$allowed_extension_list .= ", " . ALLOWED_EXTENSIONS[$i];
}

define(__NAMESPACE__ . "\ERR_MISSING_FIELDS", "One or more required fields are missing. Please try again.");
define(__NAMESPACE__ . "\ERR_INVALID_VIDEO_FILE", "You submitted an unsupported video file. Supported file extensions include: " . $allowed_extension_list . ". Please try again.");
define(__NAMESPACE__ . "\ERR_VIDEO_TOO_LARGE", "The video file you submitted is too large. Maximum supported file size is " . \SYSTEM\GET_FRIENDLY_SIZE(MAX_VIDEO_SIZE) . ". Please try again.");
define(__NAMESPACE__ . "\ERR_MISSING_AGREEMENT", "You did not agree to our Terms and Conditions. Please try again.");
define(__NAMESPACE__ . "\ERR_UPLOAD", "The server encountered an unknown error while attempting to upload the file. Please try again later.");



define(__NAMESPACE__ . "\ERR_SERVICE_DISABLED", "Video uploads are currently disabled. Please check back later.");

define(__NAMESPACE__ . "\DESC_VIDEO_TITLE", "Provide a friendly title for your video, if you wish to do so. If you do not provide a title, your video will be automatically named \"Untitled\". No tags or HTML please, and no more than " . MAX_VIDEO_TITLE_LENGTH . " characters.");
define(__NAMESPACE__ . "\DESC_VIDEO_DESCRIPTION", "Optionally, provide a description for your video. No tags or HTML please, and no more than " . MAX_VIDEO_DESCRIPTION_LENGTH . " characters.");
define(__NAMESPACE__ . "\DESC_VIDEO_FILE", "Select the video file you wish to upload. Supported file extensions are: " . $allowed_extension_list . ". Maximum file size is " . \SYSTEM\GET_FRIENDLY_SIZE(MAX_VIDEO_SIZE) . ".");
define(__NAMESPACE__ . "\DESC_VIDEO_TERMS", "I hereby affirm that by uploading this video, it becomes the sole and exclusive property of Hope2Finish Inc., which shall have full right, title and interest thereto, including under copyright, in all videos now existing or hereafter created, and without any obligation to account or make any payment to the uploader for any use thereof. No purported reservation of rights incorporated in or accompanying any video shall have any force or effect. By checking this box and submitting this video for upload, you hereby agree to all of the foregoing.");



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
	margin-bottom: 5px;
}

desc {
	
	font-size: 14px;
	color: rgb(150, 150, 150);
	float: left;
	margin-left: 175px;
	margin-top: 0px;
	/*width: 150px;*/
	/* display: block; */
	display: block;
	/* margin-bottom: 10px; */
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

$html_begin = '<html><head><title>Upload A Video | FALL_2018_CSE442_CHRISTOPHER_PEI</title>' . $external_css . '<style> ' . $css . '</style></head><body>';
$html_end = '</body></html>';
$html_error_begin = '<div id="error">';
$html_error_end = '</div>';

$form_upload = '';

if (VIDEO_UPLOADS_ENABLED){

	$form_upload = 
	'
	<form action="/upload.php" method="post" enctype="multipart/form-data" style="margin: 0 auto;width:60%;min-width:200px;">
		<fieldset>
		
			<legend><h1>Upload A Video</h1></legend>
			
			<label>Title:</label>
			<input type="text" placeholder="" name="t" size="40" />
			<desc>' . DESC_VIDEO_TITLE . '</desc>
			<br><br><br><br>
			
			<label>Description:</label>
			<textarea name="d" rows="4" cols="40"></textarea>
			
			<desc>' . DESC_VIDEO_DESCRIPTION . '</desc>
			<br><br><br><br>
			
			<label>Video:</label>
			<input type="file" name="v" id="v" accept="video/*">
			<desc>' . DESC_VIDEO_FILE . '</desc>
			<br><br>
			
			<label>Terms and Conditions:</label>
			<input type="checkbox" value="1" required name="agree">
			<desc>' . DESC_VIDEO_TERMS . '</desc>
			
			<br><br><br><br>
			<p>&nbsp;</p>
			
			<button type="submit">Upload Video</button>
			
		</fieldset>
	</form>
	';
}

else{
	
	$form_upload = 
	'
	<form action="/upload.php" method="post" enctype="multipart/form-data" style="margin: 0 auto;width:60%;min-width:200px;">
		<fieldset>
		
			<legend><h1>Upload A Video</h1></legend>
			
			<h2>SORRY</h2>
			<h3>' . ERR_SERVICE_DISABLED . '</h3>
			
		</fieldset>
	</form>
	';
}

//	FUNCTIONS
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------



//	@summary	Checks if a form was submitted with any data. Does not check validity of input.
//	@return		Returns true if form was submitted with any data.
function WAS_FORM_SUBMITTED(){
	
	if (
		isset($_FILES['v']) ||
		isset($_REQUEST['agree'])
		) return true;
		return false;
}



//	@summary	Checks if submitted form data is valid.
//	@return		Returns true if form was submitted with valid data.
//	@$error		This return var indicates reason for invalid data:
//				0 = missing/blank fields; 1 = invalid video file; 2 = video too large;
//				3 = did not agree to terms and conditions; 4 = upload error.
function IS_FORM_DATA_VALID(&$error){	
	
	//	Ensure fields are set and not blank.
	if (!isset($_FILES['v']) || empty($_FILES['v']) ||
		!isset($_REQUEST['agree']) || empty($_REQUEST['agree'])){
		
		$error = 0;
		return false;
	}
	
	//	Check if user agrees to TAC.
	if ($_REQUEST['agree'] != 1 || $_REQUEST['agree'] != "1"){
		
		$error = 3;
		return false;
	}
	
	//	Get the original filename.
	$original_filename = $_FILES["v"]["name"];
	$original_file_extension = '';
	
	\SYSTEM\LOG("DEBUG", '$_FILES["v"]["name"] = ' . $_FILES["v"]["name"] . '.');
	\SYSTEM\LOG("DEBUG", '$_FILES["v"]["tmp_name"] = ' . $_FILES["v"]["tmp_name"] . '.');
	\SYSTEM\LOG("DEBUG", '$_FILES["v"]["error"] = ' . $_FILES["v"]["error"] . '.');
	
	//	Scratch that, fuck it-- doesn't work. Might as well use the native shit anyway.
	//	Get the file extension using the power of REGEX.
	//preg_match("|\.([a-z0-9]{2,4})$|i", $original_filename, $original_file_extension);
	
	//	Make the extension lowercase for consistency.
	//$original_file_extension = strtolower($original_file_extension);
	
	$original_file_extension = strtolower(pathinfo($original_filename, PATHINFO_EXTENSION));
	
	
	
	\SYSTEM\LOG("INFO", "Extension of attempted upload is \"." . $original_file_extension . "\".");
	
	//	Make a copy of ALLOWED_EXTENSIONS and make them all lowercase for consistency.
	$allowed_extensions = array_map('strtolower', ALLOWED_EXTENSIONS);
	
	//	Check if the extension is allowed.
	if (!in_array($original_file_extension, $allowed_extensions)){
		
		$error = 1;
		return false;
	}
	
	//	Check file size.
	$original_file_size = $_FILES["v"]["size"];
	
	if ($original_file_size > MAX_VIDEO_SIZE){
		
		$error = 2;
		return false;
	}
	
	//	Check file error code.
	$file_error = $_FILES["v"]["error"];	
	if ($file_error == UPLOAD_ERR_OK)
		return true;
	
	$error = 4;
	return false;
}


//	@summary	Returns sanitized version of submitted video upload form data. Here, "sanitized" refers
//				to the data being truncated to maximum lengths in case it is larger to avoid buffer
//				overflows, and formatted properly to be accepted for processing. The sanitized values
//				are supplied (by the function) in the variables passed by reference.
//	@return		Returns true on successful sanitizing of all components. Returns false if one more fields
//				are missing (null), empty, or if the password doe not match the confirmation password.
function GET_FORM_DATA(&$title, &$description){
	
	//	Ensure all fields are set.
	if (!isset($_FILES['v']) ||
		!isset($_REQUEST['agree'])
		) return false;
		
	//	Ensure they are not empty.
	if (empty($_FILES['v']) ||
		empty($_REQUEST['agree'])
		) return false;
		
	
	$t_t = '';					//	Title
	$t_d = '';					//	Description
	$t_v = $_FILES['v'];		//	Video file
	$t_a = $_REQUEST['agree'];	//	Agree
	
	//	Check if title is supplied and if so, strip and truncate.
	if (isset($_REQUEST['t']) && !empty($_REQUEST['t'])){
		
		//	Make a copy of the value.
		$t_t = $_REQUEST['t'];
		//	Fuck off tags.
		$t_t = strip_tags($t_t);
		//	Truncate if required.
		if (strlen($t_t) > MAX_VIDEO_TITLE_LENGTH)
			$t_t = \SYSTEM\TRUNCATE($t_t, MAX_VIDEO_TITLE_LENGTH);
	}
	else{ $t_t = "Untitled"; }	//	Default title.
	
	//	Check if description is supplied and if so, strip and truncate.
	if (isset($_REQUEST['d']) && !empty($_REQUEST['d'])){
		
		//	Make a copy of the value.
		$t_d = $_REQUEST['d'];
		//	Fuck off tags.
		$t_d = strip_tags($t_t);
		//	Truncate if required.
		if (strlen($t_d) > MAX_VIDEO_DESCRIPTION_LENGTH)
			$t_d = \SYSTEM\TRUNCATE($t_d, MAX_VIDEO_DESCRIPTION_LENGTH);
	}
	else{ $t_d = ""; }	//	Default description.
	
	//	Return the memes.
	$title = $t_t;
	$description = $t_d;
	
	return true;

}


//	@summary	Generates a random string to be used as the video identifier and file name.
//	@return		Returns video ID string.
function GENERATE_UNIQUE_VIDEO_ID(){
	
	//	Pick some "unique" string.
	return \SYSTEM\RANDOM_STR(VIDEO_ID_LENGTH);
	
}



//	SCRIPT BEGINS
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------
//	-------------------------------------------------------------------------------------

$video_upload_result = -1;

//				0 = missing/blank fields; 1 = invalid video file; 2 = video too large;
//				3 = did not agree to terms and conditions;







