<?php
//======================================================================
// This page manages deleting the selected images from the server and database.

// Author: Kiya
//======================================================================

include ("../Config/Connection.php");
include ("../Config/ErrorHandler.php");

// Set error and exception handlers
set_error_handler( "log_error" );
set_exception_handler( "log_exception" );

ob_start();
session_start();

// If items were checked then delete the files and the database enries
if(!empty($_POST['delete_check_list'])) {

    foreach($_POST['delete_check_list'] as $imageName) {
        // Delete the file
        unlink($_SERVER['DOCUMENT_ROOT'] . "/FIT2076/25152017/ass2/property_images/". $imageName);

        // Delete from the database
        // Get all of property addresses for properties with any images.
        $conn = oci_connect($UName,$PWord,$DB);
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $query='BEGIN deleteImageByName(:iname); END;';
        $stmt = oci_parse($conn, $query);
        if (!$stmt) {
            $m = oci_error($conn);
            throw new Exception($m);
        }

        oci_bind_by_name($stmt,":iname", $imageName);

        $r = oci_execute($stmt);
        if (!$r) {
            $m = oci_error($stmt);
            throw new Exception($m);
        }

        oci_free_statement($stmt);
        oci_close($conn);
    }
}

header("Location: ImagesPage.php?delete=success");

ob_end_flush();
?>
