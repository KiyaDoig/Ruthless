<?php
//======================================================================
// This page manages feature create.

// Author: Stefan Prioriello
//======================================================================

ob_start();

include ("../login-page/LoginCheck.php");
include ("../Config/Connection.php");
include ("../Config/ErrorHandler.php");

// Set error and exception handlers
set_error_handler( "log_error" );
set_exception_handler( "log_exception" );

//get all of the values from post
$fname = $_POST["featureName"];
$fdescription = $_POST["featureDescription"];

include ("../Config/Connection.php");
include ("../Config/ErrorHandler.php");

// Set error and exception handlers
set_error_handler( "log_error" );
set_exception_handler( "log_exception" );

$conn = oci_connect($UName,$PWord,$DB);
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Insert them into the property table
//TODO Add procedure and fix query
$query='BEGIN addFeature(:fname, :fdescription, :fid); END;';
$stmt = oci_parse($conn, $query);

oci_bind_by_name($stmt,":fname", $fname);
oci_bind_by_name($stmt,":fdescription", $fdescription);

oci_bind_by_name($stmt,":fid", $fid, 10);

oci_execute($stmt);

// Redirect back to the property type page
header("Location: BrowseManageFeature.php");

// Clean up
oci_free_statement($stmt);
oci_close($conn);

ob_end_flush();

?>
