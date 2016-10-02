<?php
//======================================================================
// This page manages client update in the database.

// Author: Stefan Prioriello
//======================================================================

include ("../Config/Connection.php");
include ("../Config/ErrorHandler.php");

// Set error and exception handlers
set_error_handler( "log_error" );
set_exception_handler( "log_exception" );

//get all of the values from post
$cid = $_POST["id"];
$csurname = $_POST["surname"];
$cgivenname = $_POST["givenName"];
$cnum = $_POST["streetNum"];
$cstreet = $_POST["streetName"];
$csuburb = $_POST["suburb"];
$cstate = $_POST["state"];
$czip = $_POST["zip"];
$cemail = $_POST["email"];
$cmobile = $_POST["mobile"];
$cmailinglist = $_POST["mailingList"];


// Get the previously set features
session_start();

$conn = oci_connect($UName,$PWord,$DB);
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Update client record by id
$query='BEGIN updateClient(:cid, :csurname, :cgivenname, :cnum, :cstreet, :csuburb, :cstate, :czip, :cemail, :cmobile, :cmailinglist); END;';

$stmt = oci_parse($conn, $query);
if (!$stmt) {
    $m = oci_error($conn);
    throw new Exception($m);
}

oci_bind_by_name($stmt,":cid", $cid);
oci_bind_by_name($stmt,":csurname", $csurname);
oci_bind_by_name($stmt,":cgivenname", $cgivenname);
oci_bind_by_name($stmt,":cnum", $cnum);
oci_bind_by_name($stmt,":cstreet", $cstreet);
oci_bind_by_name($stmt,":csuburb", $csuburb);
oci_bind_by_name($stmt,":cstate", $cstate);
oci_bind_by_name($stmt,":czip", $czip);
oci_bind_by_name($stmt,":cemail", $cemail);
oci_bind_by_name($stmt,":cmobile", $cmobile);
oci_bind_by_name($stmt,":cmailinglist", $cmailinglist);


$r = oci_execute($stmt);
if (!$r) {
    $m = oci_error($stmt);
    throw new Exception($m);
}

// Redirect back to the client page
header("Location: BrowseManageClient.php");

//Clean-up
oci_free_statement($stmt);
oci_close($conn);

?>