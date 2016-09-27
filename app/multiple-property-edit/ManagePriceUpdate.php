<!--
This file manages the price updates in the database.
-->
<?php
// Fetch the arrays
$propertyIds = $_GET["propIds"];
$prices = $_GET["prices"];

// Convert to array
$pIdArr = explode(",", $propertyIds);
$plPriceArr = explode(",", $prices);

// Update in DB
include ("../Config/Connection.php");
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
    oci_execute($stmt);

    // Clean-up
    oci_free_statement($stmt);
}

header("Location: MultiplePropertyEdit.php?update=success");

// Close connection
oci_close($conn);
?>
