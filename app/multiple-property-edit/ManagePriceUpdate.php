<?php
//======================================================================
// This page manages the price updates in the database.

// Author: Kiya
//======================================================================

include ("../Config/Connection.php");
include ("../Config/ErrorHandler.php");

// Set error and exception handlers
set_error_handler( "log_error" );
set_exception_handler( "log_exception" );

// Fetch the arrays
$propertyIds = $_GET["propIds"];
$prices = $_GET["prices"];

// Convert to array
$pIdArr = explode(",", $propertyIds);
$plPriceArr = explode(",", $prices);

// Update in DB
$conn = oci_connect($UName,$PWord,$DB);
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Update property listing record by property id
for ($i = 0; $i < count($pIdArr); $i++) {
    $query= "UPDATE PROPERTY_LISTING SET PROPERTY_LISTING_PRICE = $plPriceArr[$i] 
            WHERE PROPERTY_ID = $pIdArr[$i]";
    $stmt = oci_parse($conn, $query);
    if (!$stmt) {
        $m = oci_error($conn);
        throw new Exception($m);
    }
    $r = oci_execute($stmt);
    if (!$r) {
        $m = oci_error($stmt);
        throw new Exception($m);
    }

    // Clean-up
    oci_free_statement($stmt);
}

// Display the Multiple property page and pass that update was a success
header("Location: MultiplePropertyEdit.php?update=success");

// Close connection
oci_close($conn);
?>
