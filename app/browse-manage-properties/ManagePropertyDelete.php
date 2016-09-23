<?php
//get all of the values from post
$pid = $_POST["activePropertyId"];

include ("../Config/Connection.php");
$conn = oci_connect($UName,$PWord,$DB);
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Update property record by id
$query='BEGIN deleteProperty(:pid); END;';
$stmt = oci_parse($conn, $query);

oci_bind_by_name($stmt,":pid", $pid);

oci_execute($stmt);

header("Location: BrowseManageProperty.php");

?>
    <!-- Clean-up -->
<?php
oci_free_statement($stmt);
oci_close($conn);
?>