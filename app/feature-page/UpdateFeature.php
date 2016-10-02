<?php
//======================================================================
// This page allows the user to update a property, including all property details, features and images.

// Author: Stefan Prioriello
//======================================================================

include ("../Config/Connection.php");
include ("../Config/ErrorHandler.php");

// Set error and exception handlers
set_error_handler( "log_error" );
set_exception_handler( "log_exception" );

ob_start();
session_start();
// This page, used for code display
$_SESSION["page"] = "UpdatePropertyType";

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
                    <h1>Update Feature</h1>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $conn = oci_connect($UName,$PWord,$DB);
                            if (!$conn) {
                                $e = oci_error();
                                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                            }

                            // Get property record by id
                            //TODO STORED PROCEDURE
                            //$query='SELECT type_id, type_name FROM property_type WHERE type_id = arg_pid';
                            $query='BEGIN getFeatureById(:arg_fid, :fid, :fname); END;';
                            $stmt = oci_parse($conn, $query);
                            if (!$stmt) {
                                $m = oci_error($conn);
                                throw new Exception($m);
                            }

                            oci_bind_by_name($stmt, ":arg_fid", $_POST["activePropertyId"]);
                            oci_bind_by_name($stmt,":fid", $fid, 10);
                            oci_bind_by_name($stmt,":fname", $fname, 20);
                            oci_bind_by_name($stmt,":fdescription", $fdescription, 40);

                            $r = oci_execute($stmt);
                            if (!$r) {
                                $m = oci_error($stmt);
                                throw new Exception($m);
                            }

                            ?>

                            <!-- Form to display current property types which may be updated-->
                            <form method="post" Action="ManageFeatureUpdate.php" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label for="feature-id-input" class="col-xs-2 col-form-label">Feature ID</label>
                                    <div class="col-xs-10">
                                        <input name="id" class="form-control" type="number" value="<?php echo $fid;?>" id="feature-id-input" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="feature-name-input" class="col-xs-2 col-form-label">Feature Name</label>
                                    <div class="col-xs-10">
                                        <input name="featureName" class="form-control" type="text" value="<?php echo $fname;?>" id="feature-name-input">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="feature-description-input" class="col-xs-2 col-form-label">Feature Description</label>
                                    <div class="col-xs-10">
                                        <input name="featureDescription" class="form-control" type="text" value="<?php echo $fname;?>" id="feature-description-input">
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
                        <a class="btn btn-primary display-code" href="../DisplayCode.php" role="button" target="_blank">Update Feature</a>
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