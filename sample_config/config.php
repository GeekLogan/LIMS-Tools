<?php
//THIS IS THE CONFIGURATION FILE

$password = "1234";
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "";

session_start();

function check_log() {
	if( $_SESSION["logid"] == null ) {
		header( 'Location: login.php' );
	}
}

function check_log_inverse() {
	if( $_SESSION["logid"] != null ) {
		header( 'Location: index.php' );
	}
}

?>
