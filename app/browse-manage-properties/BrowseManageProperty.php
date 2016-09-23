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
<?php
include ("../Config/Connection.php");
?>
<body>
<div class="row" id="main-header">
    <?php include '../Elements/MainHeader.php' ?>
</div>

<div class="row" id="main-area">
    <!-- Sidebar -->
    <?php include '../Elements/SideBar.php' ?>
    <div class="col-md-9 main-content">
        <div class="row">
            <!-- Main contents will go here -->
            <div class="col-md-12 content">
                <h1>Browse Properties</h1>
                <div class="row search-add-row">
                    <div class="col-md-6">
                        <form method="post" Action="" class="form-inline">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" name="searchInput" class="form-control" id="searchInput" placeholder="Enter suburb or property type...">
                                </div>
                            </div>
                            <button type="submit" name="search" role="button" class="btn btn-outline-primary">Search</button>
                        </form>

                    </div>
                    <div class="col-md-2 offset-md-4">
                        <a class="btn btn-primary" href="../add-property/AddProperty.php" role="button">New Property</a>
                    </div>
                </div>

                <div class="row" id="properties-table">
                    <div class="col-md-12">
                        <?php if (isset($_POST['searchInput']) && !empty($_POST["searchInput"])) { ?>
                            <!-- Display the search results -->
                            <?php
                            $searchin = $_POST['searchInput'];
                            $conn = oci_connect($UName,$PWord,$DB);
                            if (!$conn) {
                                $e = oci_error();
                                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                            }
                            $query = "SELECT p.property_id, p.property_number, p.property_street, p.property_suburb, p.property_state, p.property_postcode, pt.type_name
                                      FROM property p LEFT JOIN property_type pt on p.property_type = pt.type_id
                                      WHERE pt.type_name LIKE ('%".$searchin."%')
                                      OR p.property_suburb LIKE ('%".$searchin."%')";

                            $stmt = oci_parse($conn, $query);

                            oci_execute($stmt);
                            ?>
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Property ID</th>
                                    <th>Street Number</th>
                                    <th>Street Name</th>
                                    <th>Suburb</th>
                                    <th>State</th>
                                    <th>ZIP</th>
                                    <th>Property Type</th>
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
                        <?php }
                        else
                        { ?>
                            <!-- Display all properties -->
                            <div>
                                <?php
                                $conn = oci_connect($UName,$PWord,$DB);
                                if (!$conn) {
                                    $e = oci_error();
                                    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                                }
                                $query = "SELECT p.property_id, p.property_number, p.property_street, p.property_suburb, p.property_state, p.property_postcode, pt.type_name
  FROM property p LEFT JOIN property_type pt on p.property_type = pt.type_id";
                                $stmt = oci_parse($conn, $query);
                                oci_execute($stmt);
                                ?>
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Property ID</th>
                                        <th>Street Number</th>
                                        <th>Street Name</th>
                                        <th>Suburb</th>
                                        <th>State</th>
                                        <th>ZIP</th>
                                        <th>Property Type</th>
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

                        <?php } ?>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 offset-md-8">
                        <form method="post" Action="UpdateProperty.php">
                            <div id="hidden">
                                <input id="propId1" type="text" name="activePropertyId"> </input>
                            </div>
                            <button id="update-button" role="button" type="submit" class="btn btn-secondary disabled">Update</button>
                        </form>
                    </div>
                    <!-- Delete property -->
                    <div class="col-md-2">
                        <!-- Confirmation modal -->
                        <button id="delete-button" type="button" class="btn btn-primary disabled" data-toggle="modal" data-target=".bd-delete-prop-modal-sm">Delete</button>

                        <div class="modal fade bd-delete-prop-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="gridModalLabel">Delete Property</h4>
                                    </div>
                                    <form method="post" Action="ManagePropertyDelete.php">
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete the property?</p>
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

    <!-- Add a footer to each displayed page -->
    <div class="col-md-12">
        <nav class="navbar navbar-fixed-bottom navbar-light bg-faded" id="footer">
            <a class="navbar-brand" href="#">Footer</a>
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