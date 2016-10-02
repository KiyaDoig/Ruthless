<?php
/**
 * Created by PhpStorm.
 * User: BerettaFTW
 * Date: 20/09/2016
 * Time: 6:12 PM
 */

//======================================================================
// This page manages property type create.

// Author: Stefan Prioriello
//======================================================================

ob_start();
session_start();

//get all of the values from post
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
$query='BEGIN addClient(:csurname, :cgivenname, :cnum, :cstreet, :csuburb, :cstate, :czip, :cemail, :cmobile, :cmailinglist, :pid); END;';
$stmt = oci_parse($conn, $query);

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

oci_bind_by_name($stmt,":pid", $pid, 10);

oci_execute($stmt);

// Redirect back to the client page
header("Location: BrowseManageClient.php");

// Clean up
oci_free_statement($stmt);
oci_close($conn);

ob_end_flush();

?>
