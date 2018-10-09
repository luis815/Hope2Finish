<?php

//	SYSTEM
//	============================================================================================================
//	============================================================================================================
//	============================================================================================================
//	@BRIEF		File containing functions for system-related operations.
//	------------------------------------------------------------------------------------------------------------

namespace SYSTEM;

//	CONSTANTS
//	------------------------------------------------------------------------------------------------------------

//	Full path to the current directory. No trailing directory separators at the end.
define(__NAMESPACE__ . "\DIRECTORY_PATH", "X:\\services\\websvr\\cse442-project\\html");

//	Name of log file.
define(__NAMESPACE__ . "\LOG_NAME", "system.log");

//	Log master toggle. If disabled, no logging is performed and all other log settings are ignored.
define(__NAMESPACE__ . "\LOG_ENABLE", true);

//	If enabled, the visitor's IP address is included in log entries if available.
//define(__NAMESPACE__ . "\LOG_INCLUDE_IP", true);
define(__NAMESPACE__ . "\LOG_INCLUDE_IP", false);

//	Enable debug-style logging, which includes name of the calling function in log entries.
//	This setting is primarily for debugging purposes and should be disabled in production use.
define(__NAMESPACE__ . "\LOG_DEBUG_FORMAT", true);

//	Enable ECHO of log entry to screen. If disabled, log entries are only written to the log file.
define(__NAMESPACE__ . "\ENABLE_LOG_ECHO", true);


//	FUNCTIONS
//	------------------------------------------------------------------------------------------------------------



//	@BRIEF		Get the name of the calling function. This is meant to be called from
//				another function and is NOT meant to be called directly.
//	@RETURNS	String containing name of calling function.
function GET_CALLER_FUNCTION(){
	
	$max_level = 5;
	$trace = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 3);
	for ($i = $max_level; $i > 0; $i--){
		
		if (isset($trace[$i])) return $trace[$i]['function'];
	}
}


//	@BRIEF		Adds an entry to the log file. Log is created if it does not exist.
//	@RETURNS	Returns number of bytes written, or FALSE on an error.
//	------------------------------------------------------------------------------------
//	@type		Event type that will appear in the log before the message to indicate
//				the type of entry. Common values are INFO, WARNING, or ERROR.
//	@message	The detailed message entry.
function LOG($type, $message){
	
	if (!LOG_ENABLE) return;
	
	$timestamp = date("m/d/Y") . ' @ ' . date("h:i:s A T");
	$filename = DIRECTORY_PATH . '\\' . LOG_NAME;
	
	//	Begin forming the log entry with the timestamp.
	$line = "[" . $timestamp . "]";
	
	//	If visitor-ip logging is enabled, include the it if it is available.
	if (LOG_INCLUDE_IP){
		
		if (isset($_SERVER['REMOTE_ADDR']))
			$line .= " [" . $_SERVER['REMOTE_ADDR'] . "]";
		else
			$line .= " [?]";
	}
	
	//	Log entry type.
	$line .= " [" . $type . "]";
	
	//	If debug-style logging is enabled, include the name of calling function.
	if (LOG_DEBUG_FORMAT){
		$line .= " [@" . GET_CALLER_FUNCTION() . "]";
	}
	
	//	Log message.
	$line .= ": " . $message;
	
	//	If log-echo feature is enabled, echo entry to the screen.
	if (ENABLE_LOG_ECHO)
		echo "<pre>" .  $line . "</pre>";
	
	
	//	Write/append entry to log file.
	$fp = fopen($filename, 'a');
	$result = fwrite($fp, "\n" . $line);
	fclose($fp);
	
	return $result;
}


//	@BRIEF		Checks if $data contains $search.
//	@RETURNS	Returns true if $search is in $data.
function CONTAINS($data, $search){
	if( strpos($data, $search) !== false ) return true;
	return false;
}

//	@BRIEF		Removes all whitespace characters from $str.
//	@RETURNS	Returns resulting string stripped of whitespace.
function REMOVE_WHITESPACE($str){
	
	return preg_replace('/\s+/', '', $str);
}

//	@BRIEF		Truncates $data to number of characters given by $length. Returns original
//				string if truncation length is longer than the length of the original string.
//	@RETURNS	Returns truncated string.
function TRUNCATE($data, $length){
	
	//	Compute length once since we will be using the value for multiple checks.
	$len = strlen($data);
	
	if ($len == 0)
		return "";
	if ($len < $length)
		return $data;
	return substr($data , 0, $length);
}

//	@BRIEF		Checks if the given string is a valid email address format.
//	@RETURNS	Returns true if it is valid or false if it is not.
function IS_EMAIL_VALID($email){
	
	if (preg_match("/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/", $email)) return true;
	return false;
}























