<?php
//THIS IS THE CONFIGURATION FILE

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$password = "1234";

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

function connect_DB() {
	return new mysqli("localhost", "root", "", "mendeLIMS_dev");
}

function log_HTML($txt){
	echo "<!-- ";
	echo $txt;
	echo " --!>";
}

function qdb($query) {
	log_HTML("DB Query: ".$query);
	return connect_DB()->query($query);
}

function qdb_f($query) {
	return qdb($query)->fetch_assoc();
}

?>
