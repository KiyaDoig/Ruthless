<?php
//======================================================================
// This page allows the user to create a client in the database
// The user can input details.

// Author: Stefan Prioriello
//======================================================================

ob_start();

include ("../login-page/LoginCheck.php");
include ("../Config/Connection.php");
include ("../Config/ErrorHandler.php");

// Set error and exception handlers
set_error_handler( "log_error" );
set_exception_handler( "log_exception" );

// This page, used for code display
$_SESSION["page"] = "AddClient";
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
    <body>
    <div class="row" id="main-header">
        <?php include '../Elements/MainHeader.php' ?>
    </div>

    <div class="row" id="main-area">
        <!-- Sidebar -->
        <?php include '../Elements/SideBar.php' ?>
        <!-- Main content -->
        <div class="col-md-9 main-content">
            <div class="row content-row">
                <div class="col-md-12 content">
                    <h1>Add Client</h1>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $conn = oci_connect($UName,$PWord,$DB);
                            if (!$conn) {
                                $e = oci_error();
                                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                            }

                            // Get all property types
                            $query= "SELECT type_id, type_name FROM property_type ORDER BY type_name";
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
                            ?>

                            <!-- TODO input validation on date -->
                            <!-- Display form for new property information -->
                            <form id="prop-form" data-toggle="validator" method="post" Action="ManageClientCreate.php">

                                <div class="form-group surname row">
                                    <label for="surname-input" class="col-xs-2 col-form-label">Surname</label>
                                    <div class="col-xs-10">
                                        <input name="surname" class="form-control" type="text" id="surname-input" required>
                                    </div>
                                </div>
                                <div class="form-group givenName row">
                                    <label for="given-name-input" class="col-xs-2 col-form-label">Given Name</label>
                                    <div class="col-xs-10">
                                        <input name="givenName" class="form-control" type="text" id="given-name-input" required>
                                    </div>
                                </div>

                                <div class="form-group street-num row">
                                    <label for="street-num-input" class="col-xs-2 col-form-label">Street Number</label>
                                    <div class="col-xs-10">
                                        <input name="streetNum" class="form-control" maxlength="10" type="text" id="street-num-input" required>
                                    </div>
                                </div>
                                <div class="form-group street row">
                                    <label for="street-name-input" class="col-xs-2 col-form-label">Street Name</label>
                                    <div class="col-xs-10">
                                        <input name="streetName" class="form-control" type="text" id="street-name-input" required>
                                    </div>
                                </div>
                                <div class="form-group suburb row">
                                    <label for="suburb-input" class="col-xs-2 col-form-label">Suburb</label>
                                    <div class="col-xs-10">
                                        <input name="suburb" class="form-control" type="text" id="suburb-input" required>
                                    </div>
                                </div>
                                <div class="form-group state row">
                                    <label for="state-input" class="col-xs-2 col-form-label">State</label>
                                    <div class="col-xs-10">
                                        <input name="state" class="form-control" maxlength="6" type="text" id="state-input" required>
                                    </div>
                                </div>
                                <div class="form-group zip row">
                                    <label for="zip-input" class="col-xs-2 col-form-label">ZIP</label>
                                    <div class="col-xs-10">
                                        <input name="zip" class="form-control" maxlength="4" type="text" id="zip-input" required>
                                    </div>
                                </div>

                                <!-- TODO Email validation -->
                                <div class="form-group email row">
                                    <label for="email-input" class="col-xs-2 col-form-label">Email</label>
                                    <div class="col-xs-10">
                                        <input name="email" class="form-control" type="text" id="email-input" required>
                                    </div>
                                </div>
                                <!-- TODO Validation and see if there is specific field available -->
                                <div class="form-group mobile row">
                                    <label for="mobile-input" class="col-xs-2 col-form-label">Mobile</label>
                                    <div class="col-xs-10">
                                        <input name="mobile" class="form-control" maxlength="10" type="text" id="mobile-input" required>
                                    </div>
                                </div>
                                <!-- TODO Make it a yes or no drop down -->
                                <div class="form-group mailingList row">
                                    <label for="mailing-list-input" class="col-xs-2 col-form-label">Mailing List</label>
                                    <div class="col-xs-10">
                                        <input name="mailingList" class="form-control" maxlength="1" type="text" id="mailing-list-input" required>
                                    </div>
                                </div>

                                <div class="form-group col-md-1 offset-md-11">
                                    <button type="submit" role="button" onclick="go()" class="btn btn-primary submit-button">CREATE</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Display a footer -->
            <div class="col-md-12" >
                <nav class="navbar navbar-fixed-bottom navbar-light bg-faded" id="footer">
                    <div class="col-md-2 offset-md-8">
                        <p>Click to display code:</p>
                    </div>
                    <div class="col-md-2">
                        <a class="btn btn-primary display-code" href="../DisplayCode.php" role="button" target="_blank">Client</a>
                    </div>
                </nav>
            </div>
        </div>

    </div>

    <!-- JS Scripts -->
    <script>
        // By default pre-select today's date
        document.addEventListener('DOMContentLoaded', function() {
            var today = new Date();
            var dd = ("0" + (today.getDate())).slice(-2);
            var mm = ("0" + (today.getMonth() +　1)).slice(-2);
            var yyyy = today.getFullYear();
            today = dd + '/' + mm + '/' + yyyy ;
            $("#listing-date-input").attr("value", today);
        }, false);

        //-----------------------------------------------------
        // Handle form validation
        //-----------------------------------------------------
        var inputElements = [
            "street-num-input",
            "street-name-input",
            "suburb-input",
            "state-input",
            "zip-input"
        ];

        var streetNumInput = document.getElementById(inputElements[0]);
        var streetNameInput = document.getElementById(inputElements[1]);
        var suburbInput = document.getElementById(inputElements[2]);
        var stateNumInput = document.getElementById(inputElements[3]);
        var zipNumInput = document.getElementById(inputElements[4]);

        // Add or remove bootstrap styling on key-up
        streetNumInput.addEventListener("keyup", function (event) {
            handleValidation(streetNumInput)
        }, false);
        streetNameInput.addEventListener("keyup", function (event) {
            handleValidation(streetNameInput)
        }, false);
        suburbInput.addEventListener("keyup", function (event) {
            handleValidation(suburbInput)
        }, false);
        stateNumInput.addEventListener("keyup", function (event) {
            handleValidation(stateNumInput)
        }, false);
        zipNumInput.addEventListener("keyup", function (event) {
            handleValidation(zipNumInput)
        }, false);

        function handleValidation(arg) {
            if (!arg.validity.valid) {
                arg.classList.add("form-control-warning");
                // Get the form-group parent and add the warning style too
                var f = arg.parentElement.parentElement.className;
                ff = document.getElementsByClassName(f);
                ff[0].classList.add("has-warning");
            } else {
                // Remove style to input element
                arg.classList.remove("form-control-warning");
                // Get the form-group parent and add the warning style too
                var form = arg.parentElement.parentElement.className;
                form = document.getElementsByClassName(form);
                form[0].classList.remove("has-warning");
            }
        }

        // Add Bootstrap styling to form validation
        function go() {
            for (i = 0; i < inputElements.length; i++) {
                var element = document.getElementById(inputElements[i]);
                if (!element.validity.valid) {
                    // Suppress browser error message
                    event.preventDefault();
                    // Add style to input element
                    element.classList.add("form-control-warning");
                    // Get the form-group parent and add the warning style too
                    var form = element.parentElement.parentElement.className;
                    form = document.getElementsByClassName(form);
                    form[0].classList.add("has-warning");
                }
            }
        }
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