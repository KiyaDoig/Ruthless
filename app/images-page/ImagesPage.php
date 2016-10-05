<?php
//======================================================================
// This page displays all of the images in the server folder property-images.
// If the image is assigned to a property in the database the address is displayed.
// The user may use check-boxes to delete one or multiple images from the server and database.

// Author: Kiya
//======================================================================

ob_start();
include ("../login-page/LoginCheck.php");
include ("../Config/Connection.php");
include ("../Config/ErrorHandler.php");

// Set error and exception handlers
set_error_handler( "log_error" );
set_exception_handler( "log_exception" );

// This page, used for code display
$_SESSION["page"] = "Images";
?>
<!DOCTYPE html>
<html lang="en">
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
    <body>
        <div class="row" id="main-header">
            <?php include '../Elements/MainHeader.php' ?>
        </div>

        <div class="row" id="main-area">
            <?php include '../Elements/SideBar.php' ?>
            <div class="col-md-9 main-content">
                <div class="col-md-12">
                    <h1>Images</h1>
                    <div class="row">
                        <div class="col-md-12">
                            <p> All images on the file server are displayed and if applicable the property they are assigned to.</p>
                            <p> Note that deleting an image on this page will also un-assign it from the property in the database.</p>

                            <!-- Display a success alert when update is successful-->
                            <div class="row" id="delete-success-div">
                                <?php
                                if (isset($_GET["delete"]) ) {
                                    ?>
                                    <div class="col-md-7 offset-md-2">
                                        <div class="alert alert-success" role="alert" id="update-success">
                                            <strong>Success!</strong> Image(s) deleted.
                                        </div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>

                            <form method="post" Action="ManageImagesDelete.php" enctype="multipart/form-data">
                                <!-- Display all images in the property-images folder -->
                                <div id="all-images">
                                    <?php
                                    // Get all of property addresses for properties with any images.
                                    $conn = oci_connect($UName,$PWord,$DB);
                                    if (!$conn) {
                                        $e = oci_error();
                                        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                                    }

                                    $query= "SELECT i.image_name, p.property_number, p.property_street, p.property_suburb, p.property_state, p.property_postcode
                                     FROM property_image i LEFT JOIN property p on i.property_id = p.property_id";
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

                                    // Create array of the return
                                    $propImages = array();
                                    while ($row = oci_fetch_array($stmt, OCI_ASSOC+OCI_RETURN_NULLS)) {
                                        $propImages[] = $row;
                                    }

                                    // Set the property_images directory and open the stream.
                                    $currdir = dirname("../../../ass2/property_images/*");
                                    $dir = opendir($currdir);

                                    // Iterate over the files and check for matches with the array from the database
                                    while ($file = readdir($dir)) {
                                        if ($file == "." || $file =="..") {
                                            continue;
                                        }
                                        // Display the image name, image, property if applicable, and checkbox
                                        else {
                                            ?>
                                            <div class='col-md-6'>
                                                <div class="col-md-7">
                                                    <img class="property-image" src="../../property_images/<?php echo $file; ?>">
                                                </div>
                                                <div class="col-md-5" id="prop-info">
                                                            <?php
                                                            foreach ($propImages as $p) {
                                                                if ($file == $p["IMAGE_NAME"]){
                                                                    ?>
                                                                    <p id="address-line-1"><?php echo $p["PROPERTY_NUMBER"] . '&nbsp;' . $p["PROPERTY_STREET"]; ?> </p>
                                                                    <p id="address-line-2"><?php echo $p["PROPERTY_SUBURB"] . '&nbsp;' . $p["PROPERTY_STATE"] . '&nbsp;' . $p["PROPERTY_POSTCODE"]; ?> </p>
                                                                <?php
                                                                }
                                                            }
                                                            ?>
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="delete_check_list[]" value="<?php echo $file; ?>" multiple="multiple">
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">Delete <?php echo $file; ?></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    closedir($dir);
                                    ?>
                                </div>

                                <!-- Submit form -->
                                <div class="col-md-1 offset-md-10">
                                    <button type="submit" role="button" class="btn btn-primary submit-button">DELETE SELECTED</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add a footer to each displayed page -->
                <div class="col-md-12">
                    <nav class="navbar navbar-fixed-bottom navbar-light bg-faded" id="footer">
                        <div class="col-md-2 offset-md-8">
                            <p>Click to display code:</p>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-primary display-code" href="../DisplayCode.php" role="button" target="_blank">Images</a>
                        </div>
                    </nav>
                </div>
        </div>

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