<?php
//======================================================================
// This page allows the user to update a property, including all property details, features and images.

// Author: Kiya
//======================================================================

include ("../Config/Connection.php");

ob_start();
session_start();
// This page, used for code display
$_SESSION["page"] = "UpdateProperty";

// Select the current property type
function selectType($value1, $value2)
{
    $strSelect = "";
    if($value1 == $value2)
    {
        $strSelect = " Selected";
    }
    return $strSelect;
}
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>
        Ruthless Real Estate
    </title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="sha384-2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../app.css" />
</head>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<body>
<div class="row" id="main-header">
    <?php include '../Elements/MainHeader.php' ?>
</div>

<div class="row" id="main-area">
    <!-- Sidebar -->
    <?php include '../Elements/SideBar.php' ?>
    <!-- Main contents -->
    <div class="col-md-9 main-content">
        <div class="row">
            <div class="col-md-12 content">
                <h1>Update Property</h1>
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        $conn = oci_connect($UName,$PWord,$DB);
                        if (!$conn) {
                            $e = oci_error();
                            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                        }

                        // Get property record by id
                        $query='BEGIN getPropertyById(:arg_pid, :pid, :pnum, :pstreet, :psuburb, :pstate, :pzip, :ptype); END;';
                        $stmt = oci_parse($conn, $query);

                        oci_bind_by_name($stmt, ":arg_pid", $_POST["activePropertyId"]);
                        oci_bind_by_name($stmt,":pid", $pid, 10);
                        oci_bind_by_name($stmt,":pnum", $pnum, 20);
                        oci_bind_by_name($stmt,":pstreet", $pstreet, 20);
                        oci_bind_by_name($stmt,":psuburb", $psuburb, 40);
                        oci_bind_by_name($stmt,":pstate", $pstate, 20);
                        oci_bind_by_name($stmt,":pzip", $pzip, 10);
                        oci_bind_by_name($stmt,":ptype", $ptype, 10);

                        oci_execute($stmt);

                        // Get all property types
                        $query= "SELECT type_id, type_name FROM property_type ORDER BY type_name";
                        $stmt = oci_parse($conn, $query);

                        oci_execute($stmt);
                        ?>

                        <!-- Form to display current property details which may be updates-->
                        <form method="post" Action="ManagePropertyUpdate.php" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label for="prop-id-input" class="col-xs-2 col-form-label">Property ID</label>
                                <div class="col-xs-10">
                                    <input name="id" class="form-control" type="number" value="<?php echo $pid;?>" id="prop-id-input" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="street-num-input" class="col-xs-2 col-form-label">Street Number</label>
                                <div class="col-xs-10">
                                    <input name="streetNum" class="form-control" maxlength="10" type="text" value="<?php echo $pnum;?>" id="street-num-input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="street-name-input" class="col-xs-2 col-form-label">Street Name</label>
                                <div class="col-xs-10">
                                    <input name="streetName" class="form-control" type="text" value="<?php echo $pstreet;?>" id="street-name-input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="suburb-input" class="col-xs-2 col-form-label">Suburb</label>
                                <div class="col-xs-10">
                                    <input name="suburb" class="form-control" type="text" value="<?php echo $psuburb;?>" id="suburb-input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="state-input" class="col-xs-2 col-form-label">State</label>
                                <div class="col-xs-10">
                                    <input name="state" class="form-control" maxlength="6" type="text" value="<?php echo $pstate;?>" id="state-input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="zip-input" class="col-xs-2 col-form-label">ZIP</label>
                                <div class="col-xs-10">
                                    <input name="zip" class="form-control" maxlength="4" type="text" value="<?php echo $pzip;?>" id="zip-input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="type-input" class="col-xs-2 col-form-label">Property Type</label>
                                <div class="col-xs-10">
                                    <select name="type" class="form-control">
                                        <?php
                                        // Get all of the types with the current type selected
                                        while ($types = oci_fetch_array ($stmt))
                                        {
                                            ?>
                                            <option value="<?php echo $types["TYPE_ID"];?>"
                                                <?php echo selectType($ptype, $types["TYPE_NAME"]);?>>
                                                <?php echo $types["TYPE_NAME"]; ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-xs-2"><strong>Property Features:</strong></div>
                                <div class="col-xs-10">
                                    <?php
                                    $conn = oci_connect($UName,$PWord,$DB);
                                    if (!$conn) {
                                        $e = oci_error();
                                        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                                    }

                                    // Get features for the property
                                    $query= "SELECT pf.feature_id, f.feature_name 
                                        FROM property_feature pf LEFT JOIN feature f on pf.feature_id = f.feature_id 
                                        WHERE pf.property_id = '$pid'";

                                    // Create an array of the feature id's for the features which the property has
                                    $idsOfPropFeatures = [];
                                    $stmt = oci_parse($conn, $query);
                                    oci_execute($stmt);
                                    while ($features = oci_fetch_array ($stmt)) {
                                        $idsOfPropFeatures[] = $features["FEATURE_ID"];
                                    }

                                    // ManagePropertyUpdate will use this to identify removed features
                                    $_SESSION['currentFeatures']= $idsOfPropFeatures;

                                    // Get all features
                                    $query= "SELECT feature_id, feature_name FROM feature ORDER BY feature_name";
                                    $stmt = oci_parse($conn, $query);
                                    oci_execute($stmt);
                                    while ($features = oci_fetch_array ($stmt)) {
                                        // If the property has the feature then set checked
                                        ?>
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="features_check_list[]" value="<?php echo $features["FEATURE_ID"] ?>" multiple="multiple"
                                            <?php if (in_array($features["FEATURE_ID"], $idsOfPropFeatures)){
                                                echo 'checked="checked"';
                                            }?>>
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-description"><?php echo $features["FEATURE_NAME"] ?></span>
                                        </label>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <!-- Images -->
                            <div class="row" id="image-upload-row">
                                <div class="col-md-8">
                                    <h5 id="images-heading">Images</h5>
                                </div>

                                <div class="col-md-11" id="image-upload">
                                    <div class="col-md-12" id="existing-images">
                                        <?php
                                        $conn = oci_connect($UName,$PWord,$DB);
                                        if (!$conn) {
                                            $e = oci_error();
                                            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                                        }

                                        $query = "SELECT image_name FROM Property_Image where PROPERTY_ID =".$_POST["activePropertyId"];
                                        $stmt = oci_parse($conn, $query);
                                        oci_execute($stmt);

                                        $count =0;
                                        // Display the images and checkboxes to mark to delete
                                        while ($row = oci_fetch_array($stmt, OCI_ASSOC+OCI_RETURN_NULLS)) {
                                            $count++;
                                            foreach ($row as $item) {
                                                ?>
                                                <div class='col-md-6'>
                                                <img id="property-image" src="../../property_images/<?php echo $item ?>">
                                                <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="delete_check_list[]" value="<?php echo $item ?>" multiple="multiple">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Delete Image</span>
                                                </label>
                                                </div>
                                             <?php
                                            }
                                        }
                                        // If no rows returned display message
                                        if ($count == 0) {
                                            ?>
                                            <p>This property currently has no images.</p>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div>
                                        <p>Select one or more images for upload</p>
                                        <ul id="result"></ul>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-xs-10">
                                            <input type="file" size="50" name="userfile[]" id="image-input" multiple="multiple">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Submit form -->
                            <div class="col-md-1 offset-md-11">
                                <button type="submit" role="button" class="btn btn-primary submit-button">Done</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Display footer -->
        <div class="col-md-12" >
            <nav class="navbar navbar-fixed-bottom navbar-light bg-faded" id="footer">
                <div class="col-md-2 offset-md-8">
                    <p>Click to display code:</p>
                </div>
                <div class="col-md-2">
                    <a class="btn btn-primary display-code" href="../DisplayCode.php" role="button" target="_blank">Property</a>
                </div>
            </nav>
        </div>
    </div>

</div>

<!-- JS Scripts -->
<script>
    // Updates the display of file names
    function listFiles() {
        var input = $("input[type='file']")[0];
        var ul = $("#result");
        ul.empty();
        for (var i = 0; i < input.files.length; i++) {
            $('<li>').text(input.files[i].name).appendTo(ul);
        }
    }

    // When the file input changes, call listFiles to update the display
    $('input:file').change(function() {
        listFiles();
    });
</script>

<!-- Clean-up -->
<?php
oci_free_statement($stmt);
oci_close($conn);
?>

<!-- jQuery first, then Tether, then Bootstrap JS. -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js" integrity="sha384-VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU" crossorigin="anonymous"></script>
</body>
</html>
<?php
ob_end_flush();
?>