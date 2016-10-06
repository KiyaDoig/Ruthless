<?php
//======================================================================
// This page manages property type creatoion.

// Author: Stefan Prioriello
//======================================================================

ob_start();

include ("../login-page/LoginCheck.php");
include ("../Config/Connection.php");
include ("../Config/ErrorHandler.php");

//get all of the values from post
$ptname = $_POST["typeName"];

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
$query='BEGIN addPropertyType(:ptname, :pid); END;';
$stmt = oci_parse($conn, $query);

oci_bind_by_name($stmt,":ptname", $ptname);

oci_bind_by_name($stmt,":pid", $pid, 10);

oci_execute($stmt);

// Redirect back to the property type page
header("Location: BrowseManagePropertyType.php");

// Clean up
oci_free_statement($stmt);
oci_close($conn);

ob_end_flush();

?>
