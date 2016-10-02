<?php
/**
 * Created by PhpStorm.
 * User: BerettaFTW
 * Date: 30/09/2016
 * Time: 6:12 PM
 */

//======================================================================
// This page manages property type delete from the database.

// Author: Stefan Prioriello
//======================================================================

//get all of the values from post
$fid = $_POST["activePropertyId"];

ob_start();
//session_start(); //This is not required due to the login check file now

include ("../login-page/LoginCheck.php");
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

// Update property type record by id
//TODO Add procedure and fix query
$query='BEGIN deleteFeature(:fid); END;';

$stmt = oci_parse($conn, $query);
if (!$stmt) {
    $m = oci_error($conn);
    throw new Exception($m);
}

oci_bind_by_name($stmt,":fid", $fid);

$r = oci_execute($stmt);
if (!$r) {
    $m = oci_error($stmt);
    throw new Exception($m);
}

// Redirect back to the property type page
header("Location: BrowseManageFeature.php");

// Clean-up
oci_free_statement($stmt);
oci_close($conn);

?>