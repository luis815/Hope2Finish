<?php

//	DATABASE
//	============================================================================================================
//	============================================================================================================
//	============================================================================================================
//	@BRIEF		File containing functions for DB-related operations.
//	------------------------------------------------------------------------------------------------------------

namespace DB;

require_once "system.php";

//	CONSTANTS
//	------------------------------------------------------------------------------------------------------------

//	Full path to the current directory. No trailing directory separators at the end.
define(__NAMESPACE__ . "\DIRECTORY_PATH", "X:\\services\\websvr\\cse442-project\\html");

//	Name of log file.
define(__NAMESPACE__ . "\LOG_NAME", "db.log");

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

//	Name of database, including the extension (i.e.: "name.db").
define(__NAMESPACE__ . "\DB_NAME", "hope2finish-prj.db");


//	FUNCTIONS
//	------------------------------------------------------------------------------------------------------------

/*

//	Get calling function name. This is meant to be called from another function, and is not meant to be called
//	directly.
function GET_CALLER_FUNCTION(){
	
	$max_level = 5;
	$trace = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 3);
	for ($i = $max_level; $i > 0; $i--){
		
		if (isset($trace[$i])) return $trace[$i]['function'];
	}
}

//	Custom log function.
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
	//$linef = "\n" . $line;
	$fp = fopen($filename, 'a');
	$result = fwrite($fp, "\n" . $line);
	fclose($fp);
	
	return $result;
}

*/


//	@BRIEF		Create a user account by inserting the new user into the database.
//				NOTE: This function expects data ALREADY be sanitized.
//	@RETURNS	Returns 0 on success; 1 on general failure, 2 if user already exists.
//	------------------------------------------------------------------------------------
//	@username	The username of the user account.
//	@password	The hashed password of the user account.
//	@salt		The salt used to hash the user account's password.
//	@email		The email for the user account.
function CREATE_USER($username, $password, $salt, $email){
	
	//	Friendly operation name for logging.
	$operation_name = "User Account Creation";
	
	//	Keep track of success, error and warning count.
	$success_count = 0;
	$error_count = 0;
	$warning_count = 0;
	
	//	NOTE: "execute()" used for PREAPARED statements; otherwise only use "exec()".
	
	\SYSTEM\LOG("INFO", "Starting " . $operation_name . "...");
	
	//	Sanity checks.
	if (
		(!isset($username) || empty($username)) ||
		(!isset($password) || empty($password)) ||
		(!isset($salt) || empty($salt)) ||
		(!isset($email) || empty($email))
		){
		
		\SYSTEM\LOG("ERROR", "One or more null or empty values provided. Operation terminated.");
		return 1;
	}
	
	try{
		
		\SYSTEM\LOG("INFO", "----------------------------------------------------------------------");
		\SYSTEM\LOG("INFO", "This operation will attempt to create the following user account:");
		\SYSTEM\LOG("INFO", " -- Username[\"" . $username . "\"]");
		\SYSTEM\LOG("INFO", " -- Email[\"" . $email . "\"]");
		\SYSTEM\LOG("INFO", "----------------------------------------------------------------------");
		
		//	Open or create database if it doesn't exist.
		\SYSTEM\LOG("INFO", "Opening/creating database \"" .  DB_NAME  .  "\"...");
		$db = new \PDO('sqlite:' . DB_NAME);
		
		//	Prepare an INSERT statement.
		$tableName = "users";
		$insert = "INSERT INTO " . $tableName . " (username, password, salt, email) VALUES (:username, :password, :salt, :email)";
		$statement = $db->prepare($insert);
		
		//	Bind appropriate parameters to statement vars.
		$statement->bindParam(':username', $username);
		$statement->bindParam(':password', $password);
		$statement->bindParam(':salt', $salt);
		$statement->bindParam(':email', $email);
		
		//	Execute.
		switch($statement->execute()){
			
			case TRUE:
				$success_count++;
				\SYSTEM\LOG("INFO", "User account successfully created.");
				break;
			default:
				$error_count++;
				\SYSTEM\LOG("ERROR", "Failed to create user account.");
				break;
		}
		
		
		
		//	Close DB.
		\SYSTEM\LOG("INFO", "Closing database connection...");
		$db = null;
		
		if (isset($db)){
			$error_count++;
			\SYSTEM\LOG("ERROR", "Failed to close database connection.");
		}
		else \SYSTEM\LOG("INFO", "Successfully closed database connection.");
		
		\SYSTEM\LOG("INFO", "Finished " . $operation_name . ".");		
		
	}catch(PDOException $e){
		
		\SYSTEM\LOG("EXCEPTION", $e->getMessage());
		$error_count++;
		\SYSTEM\LOG("INFO", "============ " . $operation_name . ": " . $success_count . " succeeded, " . $error_count . " failed, " . $warning_count . " warning(s) ============");
		return 1;
	}
	
	\SYSTEM\LOG("INFO", "============ " . $operation_name . ": " . $success_count . " succeeded, " . $error_count . " failed, " . $warning_count . " warning(s) ============");
	return 0;
	
}

//	Create initial database and tables.
function DB_INIT(){
	
	//	Friendly operation name for logging.
	$operation_name = "Database Initialization";
	
	//	Keep track of success, error and warning count.
	$success_count = 0;
	$error_count = 0;
	$warning_count = 0;
	
	//	NOTE: "execute()" used for PREAPARED statements; otherwise only use "exec()".
	
	\SYSTEM\LOG("INFO", "Starting " . $operation_name . "...");
	
	try{
		
		// Open or create database if it doesn't exist.
		\SYSTEM\LOG("INFO", "Opening/creating database \"" .  DB_NAME  .  "\"...");
		$db = new \PDO('sqlite:' . DB_NAME);
		
		//	Create 'users' table.
		$tableName = "users";
		\SYSTEM\LOG("INFO", "Creating \"" . $tableName . "\" table...");
		//	According to PHP MANUAL [ https://secure.php.net/manual/en/pdo.exec.php ], exec() returns the number
		//	of rows affected by the statement, with the exception of results from a SELECT statement. Originally,
		//	the return value was used to test if table creation succeeded or failed, with the expectation that
		//	each table creation would return the number of tables returned, for example 1 or 0. During my testing
		//	however, I discovered it to consistently return a value of 0 on success.
		$result = $db->exec("CREATE TABLE IF NOT EXISTS `" . $tableName . "` (
																			`id` INTEGER PRIMARY KEY,
																			`username` TEXT,
																			`password` TEXT,
																			`salt` TEXT,
																			`email` TEXT
																			)");
		
		//	##########################################################
		//	TODO	Perhaps refactor the following error-checking to
		//			its own function since doing this multiple times
		//			otherwise will unnecessarily make the function
		//			long and difficult to read.
		//	##########################################################
		
		//	According to PHP MANUAL [ https://secure.php.net/manual/en/pdo.errorinfo.php ] and thanks to comment
		//	by "calin" at [ https://secure.php.net/manual/en/pdo.exec.php ], we can check for errors as follows.
		if ($result === false || $result === 0){
			
			$error = $db->errorInfo();
			
			//	Success.
			if ($error[0] === '00000'){
				$success_count++;
				\SYSTEM\LOG("INFO", "Success.");
			}
			
			//	Success with warning.
			else if ($error[0] === '01000'){
				
				$warning_count++;
				if (isset($error[1]) && isset($error[2]))
					\SYSTEM\LOG("WARNING", "Success (DB WARNING: [Code: " . $error[1] . "] [Message: " . $error[2] . "]." );
				else
					\SYSTEM\LOG("WARNING", "Success (DB WARNING: [Database reported success with warning, but failed to return further information].");
			}
			
			//	All other errors.
			else{
				
				$error_count++;
				if (isset($error[1]) && isset($error[2]))
					\SYSTEM\LOG("ERROR", "Failed (DB ERROR: [Code: " . $error[1] . "] [Message: " . $error[2] . "]." );
				else
					\SYSTEM\LOG("ERROR", "Failed (DB ERROR: [Database reported error, but failed to return further information]." );
			}
		}
		
		//	##########################################################
		//	TODO	Additional tables can be created beginning here.
		//	##########################################################
		
		//	Close DB.
		\SYSTEM\LOG("INFO", "Closing database connection...");
		$db = null;
		// isset($db) ? \SYSTEM\LOG("ERROR", "Failed to close database connection.") : \SYSTEM\LOG("INFO", "Successfully closed database connection.");
		if (isset($db)){
			$error_count++;
			\SYSTEM\LOG("ERROR", "Failed to close database connection.");
		}
		else \SYSTEM\LOG("INFO", "Successfully closed database connection.");
		
		\SYSTEM\LOG("INFO", "Finished " . $operation_name . ".");
		// \SYSTEM\LOG("INFO", " --- " . $warning_count . " Warning(s)");
		// \SYSTEM\LOG("INFO", " --- " . $error_count . " Error(s)");
		
		
	}catch(PDOException $e){
		
		\SYSTEM\LOG("EXCEPTION", $e->getMessage());
		$error_count++;
		\SYSTEM\LOG("INFO", "============ " . $operation_name . ": " . $success_count . " succeeded, " . $error_count . " failed, " . $warning_count . " warning(s) ============");
		return 1;
	}
	
	\SYSTEM\LOG("INFO", "============ " . $operation_name . ": " . $success_count . " succeeded, " . $error_count . " failed, " . $warning_count . " warning(s) ============");
	return 0;
}




//	SCRIPT BEGIN
//	------------------------------------------------------------------------------------------------------------
//	------------------------------------------------------------------------------------------------------------
//	------------------------------------------------------------------------------------------------------------
//	------------------------------------------------------------------------------------------------------------

// DB_INIT();

CREATE_USER("user12345", "hashedpasswd", "passwordsalt", "test_email@something.com");







//	...it is the new trend to not close the PHP tags ;D