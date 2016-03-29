<?php

require_once("config.php");

if( $_POST["pass"] != null ) {
	if( $_POST["pass"] === $pass ){
		$_SESSION["logid"] = "TRUE";
		header( 'Location: index.php' );
	}
}

?>

<html>

</html>
