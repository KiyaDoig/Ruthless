<?php
//======================================================================
// This page manages property update in the database.

// Author: Kiya
//======================================================================

ob_start();
include ("../login-page/LoginCheck.php");
include ("../Config/Connection.php");
include ("../Config/ErrorHandler.php");

// Set error and exception handlers
set_error_handler( "log_error" );
set_exception_handler( "log_exception" );

//get all of the values from post
$pid = $_POST["id"];
$pnum = $_POST["streetNum"];
$pstreet = $_POST["streetName"];
$psuburb = $_POST["suburb"];
$pstate = $_POST["state"];
$pzip = $_POST["zip"];
$ptype = $_POST["type"]; //Remember it's returning the type_id not name

// Get the previously set features
$oldFeatures= $_SESSION['currentFeatures'];

$conn = oci_connect($UName,$PWord,$DB);
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Update the property features
if(!empty($_POST['features_check_list'])) {
    // First check if you need to remove any by seeing if they are in the old array but not in the new one
    // Array diff returns all elements which are in array A but not in array B
    $diff = array_diff($oldFeatures, $_POST['features_check_list']);
    if (!empty($diff)) {
        foreach ($diff as $oldFeature) {
            // Remove from property feature
            $query = 'BEGIN deletePropertyFeatures(:pid, :fid); END;';
            $stmt = oci_parse($conn,$query);
            if (!$stmt) {
                $m = oci_error($conn);
                throw new Exception($m);
            }
            oci_bind_by_name($stmt,":pid", $pid);
            oci_bind_by_name($stmt,":fid", $oldFeature);

            $r = oci_execute($stmt);
            if (!$r) {
                $m = oci_error($stmt);
                throw new Exception($m);
            }
        }
    }
    foreach($_POST['features_check_list'] as $featureId) {
        // Then check if the featureId is in the old array
        // Do nothing if it was already a property feature
        if (!in_array($featureId, $oldFeatures)) {
            // If the feature id is not in the old array but is in the new one, then add the new prop feature
            $query = 'BEGIN addPropertyFeatures(:pid, :fid); END;';
            $stmt = oci_parse($conn,$query);
            if (!$stmt) {
                $m = oci_error($conn);
                throw new Exception($m);
            }
            oci_bind_by_name($stmt,":pid", $pid);
            oci_bind_by_name($stmt,":fid", $featureId);

            $r = oci_execute($stmt);
            if (!$r) {
                $m = oci_error($stmt);
                throw new Exception($m);
            }
        }
    }
}
// If it's empty then all features were removed
else {
    foreach($oldFeatures as $removed) {
        // Remove from property feature
        $query = 'BEGIN deletePropertyFeatures(:pid, :fid); END;';
        $stmt = oci_parse($conn,$query);
        if (!$stmt) {
            $m = oci_error($conn);
            throw new Exception($m);
        }
        oci_bind_by_name($stmt,":pid", $pid);
        oci_bind_by_name($stmt,":fid", $removed);

        $r = oci_execute($stmt);
        if (!$r) {
            $m = oci_error($stmt);
            throw new Exception($m);
        }
    }
}

// Delete the images from the db and server if any were checked.
if(!empty($_POST['delete_check_list'])) {
    foreach($_POST['delete_check_list'] as $imageName) {
        // Delete from the DB
        $query = 'BEGIN deleteImageByName(:iname); END;';
        $stmt = oci_parse($conn,$query);
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

        // Delete the file
        unlink("../../property_images/". $imageName);
    }
}

// Check for new files to upload and iterate over them and upload and save to database
if (isset($_FILES["userfile"]["tmp_name"])) {
    foreach($_FILES["userfile"]["tmp_name"] as $key => $tmpName) {
        if (strlen($_FILES["userfile"]["name"][$key]) > 1) {
            // Make a unique ID for the image name
            $query='BEGIN getNextImageId(:iid); END;';
            $stmt = oci_parse($conn, $query);
            if (!$stmt) {
                $m = oci_error($conn);
                throw new Exception($m);
            }
            oci_bind_by_name($stmt,":iid", $iid, 20);
            $r = oci_execute($stmt);
            if (!$r) {
                $m = oci_error($stmt);
                throw new Exception($m);
            }

            // Move the file
            $upfile = "../../property_images/" . $iid . "_" . $_FILES["userfile"]["name"][$key];
            if(!move_uploaded_file($_FILES["userfile"]["tmp_name"][$key], $upfile))
            {
                echo "ERROR: Could Not Move File into Directory";
            }
            if($_FILES["userfile"]["size"][$key] == 0)
            {
                echo "ERROR: Uploaded file is zero length";
            }
            if($_FILES["userfile"]["type"][$key] != "image/gif" &&
                $_FILES["userfile"]["type"][$key] != "image/pjpeg" &&
                $_FILES["userfile"]["type"][$key] != "image/png" &&
                $_FILES["userfile"]["type"][$key] != "image/jpeg")

            {
                echo "ERROR: You may only upload .jpg, .png or .gif files";
            }
            else
            {
                $name = $iid . "_" . $_FILES["userfile"]["name"][$key];

                // Save image info to DB
                $query='BEGIN addImage(:iid, :pid, :iname); END;';
                $stmt = oci_parse($conn, $query);
                if (!$stmt) {
                    $m = oci_error($conn);
                    throw new Exception($m);
                }

                oci_bind_by_name($stmt,":iid", $iid);
                oci_bind_by_name($stmt,":pid", $pid);
                oci_bind_by_name($stmt,":iname", $name);

                $r = oci_execute($stmt);
                if (!$r) {
                    $m = oci_error($stmt);
                    throw new Exception($m);
                }
            }
        }
    }
}

// Update property record by id
$query='BEGIN updateProperty(:pid, :pnum, :pstreet, :psuburb, :pstate, :pzip, :ptype); END;';
$stmt = oci_parse($conn, $query);
if (!$stmt) {
    $m = oci_error($conn);
    throw new Exception($m);
}

oci_bind_by_name($stmt,":pid", $pid);
oci_bind_by_name($stmt,":pnum", $pnum);
oci_bind_by_name($stmt,":pstreet", $pstreet);
oci_bind_by_name($stmt,":psuburb", $psuburb);
oci_bind_by_name($stmt,":pstate", $pstate);
oci_bind_by_name($stmt,":pzip", $pzip);
oci_bind_by_name($stmt,":ptype", $ptype);

$r = oci_execute($stmt);
if (!$r) {
    $m = oci_error($stmt);
    throw new Exception($m);
}

header("Location: BrowseManageProperty.php");

//Clean-up
oci_free_statement($stmt);
oci_close($conn);

ob_end_flush();
?>