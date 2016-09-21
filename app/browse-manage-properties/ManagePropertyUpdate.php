<?php
//get all of the values from post
$pid = $_POST["id"];
$pnum = $_POST["streetNum"];
$pstreet = $_POST["streetName"];
$psuburb = $_POST["suburb"];
$pstate = $_POST["state"];
$pzip = $_POST["zip"];
$ptype = $_POST["type"]; //Remember it's returning the type_id not name

include ("../Config/Connection.php");
$conn = oci_connect($UName,$PWord,$DB);
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Update property record by id
$query='BEGIN updateProperty(:pid, :pnum, :pstreet, :psuburb, :pstate, :pzip, :ptype); END;';
$stmt = oci_parse($conn, $query);

oci_bind_by_name($stmt,":pid", $pid);
oci_bind_by_name($stmt,":pnum", $pnum);
oci_bind_by_name($stmt,":pstreet", $pstreet);
oci_bind_by_name($stmt,":psuburb", $psuburb);
oci_bind_by_name($stmt,":pstate", $pstate);
oci_bind_by_name($stmt,":pzip", $pzip);
oci_bind_by_name($stmt,":ptype", $ptype);

oci_execute($stmt);

header("Location: BrowseManageProperty.php");

?>
<!-- Clean-up -->
<?php
oci_free_statement($stmt);
oci_close($conn);
?>
