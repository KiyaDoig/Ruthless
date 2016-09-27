<?php ob_start();
session_start();

//get all of the values from post
$pnum = $_POST["streetNum"];
$pstreet = $_POST["streetName"];
$psuburb = $_POST["suburb"];
$pstate = $_POST["state"];
$pzip = $_POST["zip"];
$ptype = $_POST["type"]; //Remember it's returning the type_id not name
$pldate = (string)$_POST["listingDate"]; //TODO pass it to the DB as a date and put the form back to a date input.
$plprice =$_POST["price"];

include ("../Config/Connection.php");
$conn = oci_connect($UName,$PWord,$DB);
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Insert them into the property table
$query='BEGIN addProperty(:pnum, :pstreet, :psuburb, :pstate, :pzip, :ptype, :pldate, :plprice, :pid); END;';
$stmt = oci_parse($conn, $query);

oci_bind_by_name($stmt,":pnum", $pnum);
oci_bind_by_name($stmt,":pstreet", $pstreet);
oci_bind_by_name($stmt,":psuburb", $psuburb);
oci_bind_by_name($stmt,":pstate", $pstate);
oci_bind_by_name($stmt,":pzip", $pzip);
oci_bind_by_name($stmt,":ptype", $ptype);
oci_bind_by_name($stmt,":pldate", $pldate);
oci_bind_by_name($stmt,":plprice", $plprice);

oci_bind_by_name($stmt,":pid", $pid, 10);

oci_execute($stmt);

$_SESSION['pid']= $pid;

header("Location: AddImages.php");

// TODO error page

?>
<!-- Clean-up -->
<?php
oci_free_statement($stmt);
oci_close($conn);

ob_end_flush();

?>