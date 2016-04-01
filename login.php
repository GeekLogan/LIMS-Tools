<?php

require_once("config.php");
check_log_inverse();

if( $_POST["pass"] != null ) {
	if( $_POST["pass"] == $password ){
		$_SESSION["logid"] = "TRUE";
		header( 'Location: index.php' );
	}
}

?>
<html>
<head>
<title>Login to LIMTools</title>
</head>
<body>

<form method="post" action="login.php">

Enter Password:
<input type="password" name="pass" />
<br />
<input type="submit" value="Submit">

</form>

</body>
</html>
