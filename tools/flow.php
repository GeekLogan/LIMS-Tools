<?php

require_once("../config.php");
check_log();

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
		this.checked = false;
	});
});

function gen() {
	toAdd = [];
	$("tr.datarow").each(function() {
		if($(this).find("input[type='checkbox']")[0].checked) {
			toAdd.push(this);
		}
	});

	if(toAdd.length < 1) {
		alert("Please Select Samples!");
		return;
	}

	//alert("Found " + toAdd.length + " Samples...");
}
</script>
</head>
<body>
<h3>Flowcell Tools</h3>
<table border="1" id="fromserver">
<?php

$keys = array("lib_name", "notebook_ref", "id");

echo "<tr>\n<th>Select</th>\n";
foreach($keys as $key) echo "<th>" . $key . "</th>\n";
echo "<th>Sequence Barcode</th>\n</tr>\n";

$res = get_samples();
while($row = $res->fetch_assoc()){
	$samp = get_by_id($row["seq_lib_id"]);
	echo "<!--"; var_dump($samp); echo "--!>\n";
	echo "<tr class='datarow' id='row_" . $row["seq_lib_id"];
	echo "'>\n<td><input type='checkbox' checked='false'/></td>\n";
	$i = 0;
	foreach( $keys as $key ) {
		echo "<td data_key='".$keys[$i]."'>" . $samp[$key] . "</td>\n";
		$i = $i + 1;
	}
	echo "<td data_key='multitag'>" . get_multiplex($row["index_tag"], $row["runtype_adapter"]) . "</td>\n";
	echo "</tr>\n";
}

?>
</table>
<br />
<button onclick="gen()">Generate</button>
<table id="gentable"></table>
</body>
</html>
