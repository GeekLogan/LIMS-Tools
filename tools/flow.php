<?php

require_once("../config.php");
check_log();

$conn = connect_DB();
?>
<html>
<head>
</head>
<body>
<?php
$cmd = "SELECT * FROM seq_libs;";
$res = $conn->query($cmd);

while($row = $res->fetch_assoc()){
	echo $row["lib_name"];
	echo "<br/>";
}

?>
</body>
</html>
