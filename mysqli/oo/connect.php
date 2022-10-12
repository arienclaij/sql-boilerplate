<?php
/*
  * MySQLi CONNECTION FILE
  * In this file we make the connection with a MySQL
  * server through MySQLi functions. In this
  * function is immediately selecting a db, so
  * we do that right away.
 */

/* Error-Handling
 * ==============
  * First, let's create a function to manage the
  * errors. With this we can easily find the problem
  * if something is wrong.
  * Once a script is online you don't want the user
  * get the error messages, that's why we put error_log here
  * use if DEBUG_MODE is false.
 */

// DEBUG_MODE, this will be false if the script is placed online
define('DEBUG_MODE', true);

/*
  * We store all errors in $errors. We read this in the
  * script out via a foreach loop
 */
$errors = array();

if (DEBUG_MODE) { 
    // DEBUG_MODE is on
	// Make sure we see all errors
	ini_set('display_errors', 'On');
	error_reporting(E_ALL | E_NOTICE);
} else {
	// DEBUG_MODE is off, don't show arrors
	ini_set('display_errors', 'Off');
	error_reporting(0);
}

/*
 * A function so that we can easily and beautifully show errors
 */
function SQLerror($error, $message, $file)
{
	// $error is the result of MySQLi::error()
        // $message is the text accompanying the error,
        // we will use this text if DEBUG_MODE is off
        // $file is the result of __FILE__ in the file of the error
	
	global $errors; // Put the error variable we just created in this function

    if (DEBUG_MODE) { 
        // DEBUG_MODE on => store the errors so we can show them later
		$errors[] = $message.': '.$error;
    } else { 
        // DEBUG_MODE off => log the errors en store only $message
		// We store not only the error, but also the file and the date for the convenience
		$log = $file.' ['.date('H:i:s').'] '.$error;
		error_log($log);

		$errors[] = $message;
	}
}

/* Connection with MySQLi
 * ==========================
 */
$sqlLink = new MySQLi('localhost', 'username', 'password', 'sql-boilerplate');
//Change the host, username, password and sql-boilerplate (database) to the correct data.

if ($sqlLink === false) {
	// If MySQLi returned false something went wrong, use the error function you just created
        // Because it is a connection we use MySQLi::connect_error
	SQLerror( $sqlLink->connect_error(), 'We kunnen geen verbinding aanmaken', __FILE__ );
}