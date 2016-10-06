<?php
//======================================================================
// This page allows the user to upload multiple images for a property
// This page is displayed in the add new property work-flow.
// Images are uploaded and then displayed within the page.
// Uploaded images can be deleted from this page.

// Author: Kiya
//======================================================================

ob_start();
include ("../login-page/LoginCheck.php");
include ("../Config/Connection.php");
include ("../Config/ErrorHandler.php");

// Set error and exception handlers
set_error_handler( "log_error" );
set_exception_handler( "log_exception" );

// The id for the property to add images for
$pid = intval($_SESSION['pid']);

// This page, used for code display
$_SESSION["page"] = "AddImages";
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
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<body>
<div class="row" id="main-header">
    <?php include '../Elements/MainHeader.php' ?>
</div>

<div class="row" id="main-area">
    <!-- Sidebar -->
    <?php include '../Elements/SideBar.php' ?>
    <!-- Main content -->
    <div class="col-md-9 main-content">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <div class="col-md-8 offset-md-2">
                    <div class="alert alert-success" role="alert" id="create-success">
                        <strong>Property Record Created</strong> Upload images or finish and return to property list.
                    </div>
                </div>

                <div class="row" id="image-upload-row">
                    <div class="col-md-8">
                        <h5 id="images-heading">Upload Images</h5>
                    </div>

                    <!-- Upload and display images -->
                    <div class="col-md-11" id="image-upload">
                        <div class="col-md-12" id="images">
                            <?php
                            $conn = oci_connect($UName,$PWord,$DB);
                            if (!$conn) {
                                $e = oci_error();
                                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                            }

                            $query = "SELECT image_name FROM Property_Image where PROPERTY_ID =".$pid;
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

                            // Display the images
                            while ($row = oci_fetch_array($stmt, OCI_ASSOC+OCI_RETURN_NULLS)) {
                                foreach ($row as $item) {
                                    echo "<div class='col-md-4' id='image-div'>";
                                    echo '<img class="property-image" src="../../property_images/'.$item.'">';
                                    echo "<form method='post' Action=''>";
                                    echo "<input type='hidden' value='$item' name='activeImage'> </input>";
                                    echo "<button class='delete-img-button' id='$item' type='submit' ><img id='delete-img' src='../Images/Delete-48.png'></button>";
                                    echo "</form>";
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>

                        <div>
                            <?php
                            // Delete the image
                            if (isset($_POST['activeImage']) && !empty($_POST["activeImage"]))  {
                                $imageName = $_POST['activeImage'];

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

                                // Delete the file
                                unlink("../../property_images/" . $imageName);
                                ?>
                                <!-- refresh the view -->
                                <script>
                                    $( "#images" ).load( "AddImages.php #images" );
                                </script>
                            <?php
                            }
                            ?>

                         </div>
                        <div class="col-md-6 offset-md-6">
                            <form method="post" enctype="multipart/form-data"
                                  action="AddImages.php">
                                <input type="file" size="50" name="userfile">
                                <button type="submit" role="button" class="btn btn-secondary">Upload File</button>

                            </form>
                        </div>

                        <?php

                        if (isset($_FILES["userfile"]["tmp_name"]))
                        {
                            // Make a unique ID for the image name
                            $conn = oci_connect($UName,$PWord,$DB);
                            if (!$conn) {
                                $e = oci_error();
                                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                            }

                            // Stored procedure to get the next image id in sequence
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

                            // Append the unique id to the name and try to move the file to server folder
                            $upfile = "../../property_images/" . $iid . "_" . $_FILES["userfile"]["name"];
                            // Error handling
                            if(!move_uploaded_file($_FILES["userfile"]
                            ["tmp_name"],$upfile))
                            {
                                echo "ERROR: Could Not Move File into Directory";
                            }
                            if ($_FILES["userfile"]["error"] === UPLOAD_ERR_OK) {
                                echo 'Upload was successful';
                            }
                            if($_FILES["userfile"]["size"] == 0)
                            {
                                echo "ERROR: Uploaded file is zero length";
                            }
                            if($_FILES["userfile"]["type"] != "image/gif" &&
                                $_FILES["userfile"]["type"] != "image/pjpeg" &&
                                $_FILES["userfile"]["type"] != "image/png" &&
                                $_FILES["userfile"]["type"] != "image/jpeg")

                            {
                                echo "ERROR: You may only upload .jpg, .png or .gif files";
                            }
                            else
                            {
                                $name = $iid . "_" . $_FILES["userfile"]["name"];

                                // Save image info to DB
                                $conn = oci_connect($UName,$PWord,$DB);
                                if (!$conn) {
                                    $e = oci_error();
                                    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                                }

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

                                ?>
                                <!-- refresh the view -->
                                <script>
                                    $( "#images" ).load( "AddImages.php #images" );
                                </script>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 offset-md-10">
                        <form method="post" Action="../browse-manage-properties/BrowseManageProperty.php">
                            <button id="done-button" role="button" type="submit" class="btn btn-primary">DONE</button>
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

<!-- jQuery first, then Tether, then Bootstrap JS. -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js" integrity="sha384-VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU" crossorigin="anonymous"></script>

<!-- Clean-up -->
<?php
oci_free_statement($stmt);
oci_close($conn);
?>
</body>
</html>
<?php
ob_end_flush();
?>