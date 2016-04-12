<?php

require_once("../config.php");
check_log();

?>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
<style>
th, td {
	align: left;
}
</style>
<script type="text/javascript">

$(document).ready(function(){
	$("input[type='checkbox']").each(function() {
		this.checked=false;
	});
});

</script>
</head>
<body>
<h3>Flowcell Tools</h3>
<table border="1">
<?php

function get_samples() {
	return qdb("SELECT * FROM lib_samples;");
}

function get_by_id($id) {
	return qdb_f("SELECT * FROM seq_libs WHERE id=".$id.";");
}

function get_multiplex($id, $pool) {
	$query = "SELECT * FROM `index_tags` WHERE `runtype_adapter` LIKE '".$pool."'";
	$query .= "AND `tag_nr` =" . $id ." LIMIT 0,2;";
	return qdb_f($query)["tag_sequence"];
}

$res = get_samples();
$keys = array();

echo "<tr><th>Select</th><th>Sequence Barcode</th>";
foreach($keys as $key) {
	echo "<th>" . $key . "</th>";
}
echo "</tr>";

while($row = $res->fetch_assoc()){
	$samp = get_by_id($row["seq_lib_id"]);
	var_dump($samp);
	echo "<tr>";
	echo "<td><input type='checkbox' checked='false' /></td>";
	echo "<td>" . get_multiplex($row["index_tag"], $row["runtype_adapter"]) . "</td>";
	foreach( $keys as $key ) {
		echo "<td>" . $row[$key] . "</td>";
	}
	echo "<tr/>";
}

?>
</table>
</body>
</html>
