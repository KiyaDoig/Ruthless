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
    <div class="col-md-9 main-content">
        <div class="row">
            <!-- Main contents will go here -->
            <div class="col-md-12 content">
                <h1>Browse Properties</h1>
                <div class="row search-add-row">
                    <div class="col-md-5">
                        <form>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="exampleInputAmount" placeholder="Enter suburb or property type...">
                                    <div class="input-group-addon" role="button">Search</div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-2 offset-md-4">
                        <a class="btn btn-primary" href="../add-property/AddProperty.php" role="button">New Property</a>
                    </div>
                </div>

                <div class="row" id="properties-table">
                    <div class="col-md-12">
                        <?php
                        include ("../Config/Connection.php");
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

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2 offset-md-8">
                        <form method="post" Action="UpdateProperty.php">
                            <div id="hidden">
                                <input id="propId" type="text" name="activePropertyId"> </input>
                            </div>
                            <button id="update-button" role="button" type="submit" class="btn btn-secondary disabled">Update</button>
                        </form>

                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-secondary">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add a footer to each displayed page -->
        <div class="row">
            <?php include '../Elements/Footer.php' ?>
        </div>
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
        document.getElementById("propId").value = activePropertyId;

        // Enable update button
        var updateButton = document.getElementById('update-button');
        if (updateButton.classList.contains('disabled')){
            updateButton.classList.remove('disabled')
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