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
jQuery.fn.visible = function() {
    return this.css('display', 'block');
};
jQuery.fn.invisible = function() {
    return this.css('display', 'none');
};
jQuery.fn.outerHTML = function(s) {
  return (s)
  ? this.before(s).remove()
  : jQuery("<p>").append(this.eq(0).clone()).html();
}

$(document).ready(function(){
	$("table").visible();
	$("input[type='checkbox']").each(function() {
		this.checked = false;
	});
	$("table#gentable").invisible();
});

function gen() {
	toAdd = [];
	$("tr.datarow").each(function() {
		if($(this).find("input[type='checkbox']")[0].checked) {
			toAdd.push(this);
			console.log("ID Added: " + $(this).attr('id').replace("row_",""));
		}
	});

	if(toAdd.length < 1) {
		alert("Please Select Samples!");
		return;
	}

	$("table#fromserver").invisible();
	$("button#gen").invisible();
	$("table#gentable").visible();

	toAdd.forEach(function(e, i, arr){
		$("table#gentable").append( $(e).outerHTML() );
	});
	$("table#gentable").find("input[type='checkbox']").parent().invisible();
	$("table#gentable").prepend( $("#h_row").outerHTML() );
	$("table#gentable").find("tr").find("#h_sel").invisible();

	//alert("Found " + toAdd.length + " Samples...");
}
</script>
</head>
<body>
<h3>Flowcell Tools</h3>
<table border="1" id="fromserver">
<?php

$keys = array("lib_name", "notebook_ref", "id");

echo "<tr id='h_row'>\n<th id='h_sel'>Select</th>\n";
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
<button id="gen" onclick="gen()">Generate</button>
<table id="gentable" border="1">

</table>
</body>
</html>
