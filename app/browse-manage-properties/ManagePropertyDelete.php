<?php
//======================================================================
// This page manages property delete from the database.

// Author: Kiya
//======================================================================

//get all of the values from post
$pid = $_POST["activePropertyId"];

include ("../Config/Connection.php");
include ("../Config/ErrorHandler.php");

// Set error and exception handlers
set_error_handler( "log_error" );
set_exception_handler( "log_exception" );

$conn = oci_connect($UName,$PWord,$DB);
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    throw new Exception('Connection failed');
}

// Update property record by id
$query='BEGIN deleteProperty(:pid); END;';

$stmt = oci_parse($conn, $query);
if (!$stmt) {
    $m = oci_error($conn);
    throw new Exception($m);
}
oci_bind_by_name($stmt,":pid", $pid);

$r = oci_execute($stmt);
if (!$r) {
    $m = oci_error($stmt);
    throw new Exception($m);
}

// Display Property browse page
header("Location: BrowseManageProperty.php");

// Clean-up
oci_free_statement($stmt);
oci_close($conn);