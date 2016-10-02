<?php
//======================================================================
// This page manages property type update in the database.

// Author: Stefan Prioriello
//======================================================================

include ("../Config/Connection.php");
include ("../Config/ErrorHandler.php");

// Set error and exception handlers
set_error_handler( "log_error" );
set_exception_handler( "log_exception" );

//TODO Fix values
//get all of the values from post
$pid = $_POST["id"];
$ptname = $_POST["typeName"];

// Get the previously set features
session_start();
$oldFeatures= $_SESSION['currentFeatures'];

$conn = oci_connect($UName,$PWord,$DB);
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

//TODO Add stored procedure
// Update property record by id
$query='BEGIN updateProperty(:pid, :pnum, :pstreet, :psuburb, :pstate, :pzip, :ptype); END;';
$stmt = oci_parse($conn, $query);
if (!$stmt) {
    $m = oci_error($conn);
    throw new Exception($m);
}

oci_bind_by_name($stmt,":pid", $pid);
oci_bind_by_name($stmt,":ptname", $ptname);

$r = oci_execute($stmt);
if (!$r) {
    $m = oci_error($stmt);
    throw new Exception($m);
}

// Redirect back to the property type page
header("Location: BrowseManagePropertyType.php");

//Clean-up
oci_free_statement($stmt);
oci_close($conn);

?>