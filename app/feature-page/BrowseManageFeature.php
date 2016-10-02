<?php
/**
 * Created by PhpStorm.
 * User: BerettaFTW
 * Date: 20/09/2016
 * Time: 6:01 PM
 */
//======================================================================
// This page displays all property types.
// The user can view/add/edit/delete the property type list

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
$_SESSION["page"] = "BrowseManagePropertyType";
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
        <div class="row">
            <div class="col-md-12 content">
                <h1>Browse Features</h1>
                <!-- Search bar -->
                <div class="row search-add-row">
                    <div class="col-md-2 offset-md-4">
                        <a class="btn btn-primary" href="AddFeature.php" role="button">New Feature</a>
                    </div>
                </div>
                <!-- Features table -->
                <div class="row" id="properties-table">
                    <div class="col-md-12">
                        <!-- Display all features -->
                        <div>
                            <?php
                            $conn = oci_connect($UName,$PWord,$DB);
                            if (!$conn) {
                                $e = oci_error();
                                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                            }
                            $query = "SELECT * FROM feature";
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
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Feature ID</th>
                                    <th>Feature Name</th>
                                    <th>Feature Description</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                echo "<tr>";
                                while ($row = oci_fetch_array($stmt, OCI_ASSOC+OCI_RETURN_NULLS)) {
                                    echo "<tr class='property-row' onclick='applyActiveClass(this)'>\n";
                                    foreach ($row as $item) {
                                        echo "    <td >" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
                                    }
                                    echo "</tr>\n";
                                }

                                ?>
                                </tbody>
                            </table>
                            <!-- Clean-up -->
                            <?php
                            oci_free_statement($stmt);
                            oci_close($conn);
                            ?>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <!-- Update feature button -->
                    <div class="col-md-2 offset-md-8">
                        <form method="post" Action="UpdateFeature.php">
                            <div id="hidden">
                                <input id="propId1" type="text" name="activePropertyId"> </input>
                            </div>
                            <button id="update-button" role="button" type="submit" class="btn btn-secondary disabled">Update</button>
                        </form>
                    </div>
                    <!-- Delete feature button -->
                    <div class="col-md-2">
                        <!-- Confirmation modal -->
                        <button id="delete-button" type="button" class="btn btn-primary disabled" data-toggle="modal" data-target=".bd-delete-prop-modal-sm">Delete</button>

                        <div class="modal fade bd-delete-prop-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="gridModalLabel">Delete Feature</h4>
                                    </div>
                                    <form method="post" Action="ManageFeatureDelete.php">
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete the feature?</p>
                                        </div>
                                        <div id="hidden">
                                            <input id="propId2" type="text" name="activePropertyId"> </input>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                            <button id="confirm-delete-button" role="button" type="submit" class="btn btn-primary">Confirm Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Display footer -->
    <div class="col-md-12">
        <nav class="navbar navbar-fixed-bottom navbar-light bg-faded" id="footer">
            <div class="col-md-2 offset-md-8">
                <p>Click to display code:</p>
            </div>
            <div class="col-md-2">
                <a class="btn btn-primary display-code" href="../DisplayCode.php" role="button" target="_blank">Feature</a>
            </div>
        </nav>
    </div>
</div>


<!-- JS Scripts -->
<script>
    function applyActiveClass(tr) {
        var rows = document.getElementsByClassName('property-row');
        for (i = 0; i < rows.length; i++) {
            rows[i].classList.remove('active');
        }
        tr.classList.add('active');
        // Set variable
        activePropertyId = ($('.property-row.active td:first').text());
        // find the 'propId' input element and set its value to the above variable
        document.getElementById("propId1").value = activePropertyId;
        document.getElementById("propId2").value = activePropertyId;

        // Enable update button
        var updateButton = document.getElementById('update-button');
        var deleteButton = document.getElementById('delete-button');
        if (updateButton.classList.contains('disabled')){
            updateButton.classList.remove('disabled')
        }
        if (deleteButton.classList.contains('disabled')){
            deleteButton.classList.remove('disabled')
        }
    }
</script>


<!-- jQuery first, then Tether, then Bootstrap JS. -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js" integrity="sha384-VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU" crossorigin="anonymous"></script>
</body>
</html>