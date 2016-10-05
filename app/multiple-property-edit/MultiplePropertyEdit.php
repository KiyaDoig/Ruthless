<?php
//======================================================================
// This page displays all properties and allows the update of multiple property prices in one action.

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
$_SESSION["page"] = "MultipleProperty";
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
            <h1>Multiple Property Edit Price</h1>

            <!-- Display a success alert when update is successful-->
            <div class="row" id="update-success-div">
                <?php
                if (isset($_GET["update"]) ) {
                    ?>
                    <div class="col-md-7 offset-md-2">
                        <div class="alert alert-success" role="alert" id="update-success">
                            <strong>Success!</strong> Prices updated.
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>

            <div class="row" id="edit-properties-table">
                <div class="col-md-12">
                    <form name="properties-form">
                        <!-- Display all properties with address and editable price as text input field -->
                        <div>
                            <?php
                            $conn = oci_connect($UName,$PWord,$DB);
                            if (!$conn) {
                                $e = oci_error();
                                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                            }
                            $query = "SELECT p.property_id, p.property_number, p.property_street, p.property_suburb, p.property_state, p.property_postcode, pl.property_listing_price
                                      FROM property p LEFT JOIN property_listing pl ON p.property_id = pl.property_id";
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
                            <table class="table table-hover" id="ptable">
                                <thead>
                                <tr>
                                    <th>Property Id</th>
                                    <th>Street Number</th>
                                    <th>Street Name</th>
                                    <th>Suburb</th>
                                    <th>State</th>
                                    <th>ZIP</th>
                                    <th>Price</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                echo "<tr>";
                                while ($row = oci_fetch_array($stmt, OCI_ASSOC+OCI_RETURN_NULLS)) {
                                    echo "<tr>\n";
                                    $i = 0;
                                    foreach ($row as $item) {
                                        if(++$i === count($row)) {
                                            echo "<td>    <input class='form-control' name='price-input' value='$item' type='number' maxlength='4'  min='1' required>" . "</td>\n";
                                            break;
                                        }
                                        echo "    <td >" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
                                    }
                                    echo "</tr>\n";
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Display invalid input error on error -->
            <div class="col-md-7 offset-md-2" id="input-error">
                <div class="alert alert-danger" role="alert">
                    <strong>Invalid Input</strong> Price values must be numeric and cannot be empty or less than 1.
                </div>
            </div>
            <div class="col-md-2 offset-md-1">
                <button role="button" type="submit" onclick="return getUpdatedPrices()" class="btn btn-primary">UPDATE ALL</button>
                </form>
            </div>
        </div>

        <!-- Add a footer to each displayed page -->
        <div class="col-md-12">
            <nav class="navbar navbar-fixed-bottom navbar-light bg-faded" id="footer">
                <div class="col-md-2 offset-md-8">
                    <p>Click to display code:</p>
                </div>
                <div class="col-md-2">
                    <a class="btn btn-primary display-code" href="../DisplayCode.php" role="button" target="_blank">Multiple Property</a>
                </div>
            </nav>
        </div>
    </div>

</div>
<script>
    //-----------------------------------------------------
    // Validate the form
    //-----------------------------------------------------
    function getUpdatedPrices() {
        var element = document.getElementsByClassName("form-control");
        for (var i = 0; i < element.length; i++) {
            if (!element[i].validity.valid) {
                var alertElement = document.getElementById("input-error");
                alertElement.style.visibility = "visible";
                return false;
            }
        }

        var propertyIds = [];
        var prices = [];

        // Iterate over the propId and price columns and store the values in an array
        // Property Id's
        $('#ptable td:nth-child(1)').each(function() {
            propertyIds.push(this.innerHTML);
        });
        // Prices
        $('#ptable td:nth-child(7) input').each(function() {
            prices.push(this.value);
        });

        // Redirect to php page to manage DB update. Pass the property ID and updated price values.
        window.location.href='ManagePriceUpdate.php?propIds=' + propertyIds + '&prices=' + prices;
        return false;
    }
</script>
<!--  Hide the success alert after 1second -->
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript">
    $(document).ready( function() {
        $('#update-success').delay(1000).fadeOut();
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