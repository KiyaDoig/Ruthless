<?php
//======================================================================
// This page allows the user to update a client, including all client details.

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
$_SESSION["page"] = "UpdateClient";

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
                    <h1>Update Client</h1>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $conn = oci_connect($UName,$PWord,$DB);
                            if (!$conn) {
                                $e = oci_error();
                                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                            }

                            // Get property record by id
                            $query='BEGIN getClientById(:arg_pid, :pid, :csurname, :cgivenname, :cnum, :cstreet, :csuburb, :cstate, :czip, :cemail, :cmobile, :cmailinglist); END;';
                            $stmt = oci_parse($conn, $query);
                            if (!$stmt) {
                                $m = oci_error($conn);
                                throw new Exception($m);
                            }

                            oci_bind_by_name($stmt,":arg_pid", $_POST["activePropertyId"]);
                            oci_bind_by_name($stmt,":pid", $pid, 10);
                            oci_bind_by_name($stmt,":csurname", $csurname, 40);
                            oci_bind_by_name($stmt,":cgivenname", $cgivenname, 40);
                            oci_bind_by_name($stmt,":cnum", $cnum, 20);
                            oci_bind_by_name($stmt,":cstreet", $cstreet, 20);
                            oci_bind_by_name($stmt,":csuburb", $csuburb, 40);
                            oci_bind_by_name($stmt,":cstate", $cstate, 20);
                            oci_bind_by_name($stmt,":czip", $czip, 10);
                            oci_bind_by_name($stmt,":cemail", $cemail, 40);
                            oci_bind_by_name($stmt,":cmobile", $cmobile, 10);
                            oci_bind_by_name($stmt,":cmailinglist", $cmailinglist, 1);

                            $r = oci_execute($stmt);
                            if (!$r) {
                                $m = oci_error($stmt);
                                throw new Exception($m);
                            }
                            ?>

                            <!-- Form to display current property details which may be updates-->
                            <form method="post" Action="ManageClientUpdate.php" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label for="prop-id-input" class="col-xs-2 col-form-label">Property ID</label>
                                    <div class="col-xs-10">
                                        <input name="id" class="form-control" type="number" value="<?php echo $pid;?>" id="prop-id-input" readonly>
                                    </div>
                                </div>

                                <div class="form-group surname row">
                                    <label for="surname-input" class="col-xs-2 col-form-label">Surname</label>
                                    <div class="col-xs-10">
                                        <input name="surname" class="form-control" type="text" value="<?php echo $csurname;?>" id="surname-input" >
                                    </div>
                                </div>
                                <div class="form-group givenName row">
                                    <label for="given-name-input" class="col-xs-2 col-form-label">Given Name</label>
                                    <div class="col-xs-10">
                                        <input name="givenName" class="form-control" type="text" value="<?php echo $cgivenname;?>" id="given-name-input">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="street-num-input" class="col-xs-2 col-form-label">Street Number</label>
                                    <div class="col-xs-10">
                                        <input name="streetNum" class="form-control" maxlength="10" type="text" value="<?php echo $cnum;?>" id="street-num-input">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="street-name-input" class="col-xs-2 col-form-label">Street Name</label>
                                    <div class="col-xs-10">
                                        <input name="streetName" class="form-control" type="text" value="<?php echo $cstreet;?>" id="street-name-input">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="suburb-input" class="col-xs-2 col-form-label">Suburb</label>
                                    <div class="col-xs-10">
                                        <input name="suburb" class="form-control" type="text" value="<?php echo $csuburb;?>" id="suburb-input">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="state-input" class="col-xs-2 col-form-label">State</label>
                                    <div class="col-xs-10">
                                        <input name="state" class="form-control" maxlength="6" type="text" value="<?php echo $cstate;?>" id="state-input">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="zip-input" class="col-xs-2 col-form-label">ZIP</label>
                                    <div class="col-xs-10">
                                        <input name="zip" class="form-control" maxlength="4" type="text" value="<?php echo $czip;?>" id="zip-input">
                                    </div>
                                </div>

                                <!-- TODO Email validation -->
                                <div class="form-group email row">
                                    <label for="email-input" class="col-xs-2 col-form-label">Email</label>
                                    <div class="col-xs-10">
                                        <input name="email" class="form-control" type="text" value="<?php echo $cemail;?>" id="email-input">
                                    </div>
                                </div>
                                <!-- TODO Validation and see if there is specific field available -->
                                <div class="form-group mobile row">
                                    <label for="mobile-input" class="col-xs-2 col-form-label">Mobile</label>
                                    <div class="col-xs-10">
                                        <input name="mobile" class="form-control" maxlength="10" type="text" value="<?php echo $cmobile;?>" id="mobile-input">
                                    </div>
                                </div>
                                <!-- TODO Make it a yes or no drop down -->
                                <div class="form-group mailingList row">
                                    <label for="mailing-list-input" class="col-xs-2 col-form-label">Mailing List</label>
                                    <div class="col-xs-10">
                                        <input name="mailingList" class="form-control" maxlength="1" type="text" value="<?php echo $cmailinglist;?>" id="mailing-list-input">
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
                        <a class="btn btn-primary display-code" href="../DisplayCode.php" role="button" target="_blank">Update Client</a>
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