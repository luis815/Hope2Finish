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