<?php
//======================================================================
// This page manages property create.

// Author: Kiya
//======================================================================

ob_start();
include ("../login-page/LoginCheck.php");
include ("../Config/Connection.php");
include ("../Config/ErrorHandler.php");

// Set error and exception handlers
set_error_handler( "log_error" );
set_exception_handler( "log_exception" );

//get all of the values from post
$pnum = $_POST["streetNum"];
$pstreet = $_POST["streetName"];
$psuburb = $_POST["suburb"];
$pstate = $_POST["state"];
$pzip = $_POST["zip"];
$ptype = $_POST["type"]; //Remember it's returning the type_id not name
$pldate = (string)$_POST["listingDate"];
$plprice = $_POST["price"];

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

// Active property id, used by add images page
$_SESSION['pid']= $pid;

// Insert the features in to the property features table if any were checked.
if(!empty($_POST['features_check_list'])) {
    foreach($_POST['features_check_list'] as $featureId) {
        $query = 'BEGIN addPropertyFeatures(:pid, :fid); END;';
        $stmt = oci_parse($conn,$query);
        if (!$stmt) {
            $m = oci_error($conn);
            throw new Exception($m);
        }

        oci_bind_by_name($stmt,":pid", $pid);
        oci_bind_by_name($stmt,":fid", $featureId);

        $r = oci_execute($stmt);
        if (!$r) {
            $m = oci_error($stmt);
            throw new Exception($m);
        }
    }
}

// Display add images page
header("Location: AddImages.php");

// Clean up
oci_free_statement($stmt);
oci_close($conn);

ob_end_flush();

?>
