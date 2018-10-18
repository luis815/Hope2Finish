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



//	@BRIEF		Authenticate a user account.
//				NOTE: This function expects data ALREADY be sanitized.
//	@RETURNS	Returns 1 on success; 0 if incorrect password, 2 if user does not exist.
//	------------------------------------------------------------------------------------
//	@username	The username of the user account.
//	@password	The plain-text password of the user account.
function AUTHENTICATE_USER($username, $password){
	
	//	Friendly operation name for logging.
	$operation_name = "User Account Authentication";
	
	//	Keep track of success, error and warning count.
	$success_count = 0;
	$error_count = 0;
	$warning_count = 0;
	
	//	Set custom return value.
	$return = 0;
	
	//	NOTE: "execute()" used for PREAPARED statements; otherwise only use "exec()".
	
	\SYSTEM\LOG("INFO", "Starting " . $operation_name . "...");
	
	//	Sanity checks.
	if (
		(!isset($username) || empty($username)) ||
		(!isset($password) || empty($password))
		){
		
		\SYSTEM\LOG("ERROR", "One or more null or empty values provided. Operation terminated.");
		return 1;
	}
	
	try{
		
		$tableName = "users";
		
		\SYSTEM\LOG("INFO", "----------------------------------------------------------------------");
		\SYSTEM\LOG("INFO", "This operation will attempt to authenticate the following user account:");
		\SYSTEM\LOG("INFO", " -- Username[\"" . $username . "\"]");
		\SYSTEM\LOG("INFO", "----------------------------------------------------------------------");
		
		//	Open or create database if it doesn't exist.
		\SYSTEM\LOG("INFO", "Opening/creating database \"" .  DB_NAME  .  "\"...");
		$db = new \PDO('sqlite:' . DB_NAME);
		
		//	Perform a SELECT query to see if a user account with the same username already exists.
		$select = "SELECT id, username, email, password from " . $tableName . " WHERE username=:username";
		$statement = $db->prepare($select);
		
		//	Bind appropriate parameters to statement vars.
		$statement->bindValue(':username', $username, \PDO::PARAM_STR);
		
		//	Execute
		$statement->execute();
		
		//	Fetch the data.
		$r = $statement->fetchAll();
		
		//	DEBUG PRINT
		//\SYSTEM\LOG("DEBUG", print_r($r));
		
		//	DEBUG
		//exit(0);
		
		//	We can login in via username OR email in the future BUT to do this safely, we must guarantee
		//	that all emails are unique, which we do not do at this time. Thus, we will only allow login
		//	via username for now.
		if (isset($r[0]["id"]) &&
			isset($r[0]["username"]) &&
			isset($r[0]["email"]) &&
			isset($r[0]["password"])
			){
			
			//$error_count++;
			//$return = 2;
			\SYSTEM\LOG("INFO", "User account found (id: " . $r[0]["id"] . "; email: " . $r[0]["email"] . "). Checking password...");
			
			//	Fetch the password information as stored in the DB.
			$hash = $r[0]["password"];
			
			//	Do an EXPLICIT check to make sure TRUE.
			if (\SYSTEM\VERIFY_PASSWORD($password, $hash) === TRUE){
			
				$success_count++;
				$return = 1;
				\SYSTEM\LOG("INFO", "Password verification successful - password is correct.");
				\SYSTEM\LOG("INFO", "Authentication successful.");
			}
			
			else{
				//	Incorrect password.
				$error_count++;
				$return = 0;
				\SYSTEM\LOG("ERROR", "Password verification failed - incorrect password provided.");
				\SYSTEM\LOG("ERROR", "Authentication failed.");
			}
			
		}
		
		//	User account does not exist.
		else{
			
			$error_count++;
			$return = 2;
			\SYSTEM\LOG("ERROR", "User account \"" . $username . "\" does not exist.");
		}
		
		//	TODO: Proceed to create cookie/session/whatever to save user's login state for login persistence.
		if ($error_count === 0 && $warning_count === 0){
			
			//	TODO
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
		
		$return = 1;
		\SYSTEM\LOG("EXCEPTION", $e->getMessage());
		$error_count++;
		\SYSTEM\LOG("INFO", "============ " . $operation_name . ": " . $success_count . " succeeded, " . $error_count . " failed, " . $warning_count . " warning(s) ============");
		return $return;
	}
	
	\SYSTEM\LOG("INFO", "============ " . $operation_name . ": " . $success_count . " succeeded, " . $error_count . " failed, " . $warning_count . " warning(s) ============");
	return $return;
	
}



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
	
	//	Set custom return value.
	$return = 0;
	
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
		
		$tableName = "users";
		
		\SYSTEM\LOG("INFO", "----------------------------------------------------------------------");
		\SYSTEM\LOG("INFO", "This operation will attempt to create the following user account:");
		\SYSTEM\LOG("INFO", " -- Username[\"" . $username . "\"]");
		\SYSTEM\LOG("INFO", " -- Email[\"" . $email . "\"]");
		\SYSTEM\LOG("INFO", "----------------------------------------------------------------------");
		
		//	Open or create database if it doesn't exist.
		\SYSTEM\LOG("INFO", "Opening/creating database \"" .  DB_NAME  .  "\"...");
		$db = new \PDO('sqlite:' . DB_NAME);
		
		//	Perform a SELECT query to see if a user account with the same username already exists.
		$select = "SELECT id from " . $tableName . " WHERE username=:username";
		$statement = $db->prepare($select);
		
		//	Bind appropriate parameters to statement vars.
		$statement->bindValue(':username', $username, \PDO::PARAM_STR);
		
		//	Execute
		$statement->execute();
		
		//	Fetch the data.
		$r = $statement->fetchAll();	
		if (isset($r[0]["id"])){
			
			$error_count++;
			$return = 2;
			\SYSTEM\LOG("ERROR", "A user account with the same username (id: " . $r[0]["id"] . ") already exists.");
		}
		
		//	Proceed to account creation ONLY if there are NO errors or warnings.
		if ($error_count === 0 && $warning_count === 0){
			
			//	Reset.
			$statement->closeCursor();
			
			//	Prepare an INSERT statement.
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
		
		$return = 1;
		\SYSTEM\LOG("EXCEPTION", $e->getMessage());
		$error_count++;
		\SYSTEM\LOG("INFO", "============ " . $operation_name . ": " . $success_count . " succeeded, " . $error_count . " failed, " . $warning_count . " warning(s) ============");
		return $return;
	}
	
	\SYSTEM\LOG("INFO", "============ " . $operation_name . ": " . $success_count . " succeeded, " . $error_count . " failed, " . $warning_count . " warning(s) ============");
	return $return;
	
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
																			`username` TEXT COLLATE NOCASE,
																			`password` TEXT,
																			`salt` TEXT,
																			`email` TEXT COLLATE NOCASE
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

//	Initialize the database.
// DB_INIT();

//	Create sample user account.
// CREATE_USER("user12345", "hashedpasswd", "passwordsalt", "test_email@something.com");

//	Attempt to create another user with the same username (this should fail).
// CREATE_USER("user12345", "hashedpasswd2", "passwordsalt2", "test_email2@something.com");

//	Create another sample user account.
// CREATE_USER("user67890", "hashedpasswd2", "passwordsalt2", "test_email2@something.com");







//	...it is the new trend to not close the PHP tags ;D