<?php
function compareDates($input)
{
    if(new DateTime() > $input)
    {
        echo "hi";
        return "error";
    }
    return "success";
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
<body>
<div class="row" id="main-header">
    <?php include '../Elements/MainHeader.php' ?>
</div>

<div class="row" id="main-area">
    <!-- Sidebar -->
    <?php include '../Elements/SideBar.php' ?>
    <div class="col-md-9 main-content">
        <div class="row content-row">
            <!-- Main contents will go here -->
            <div class="col-md-12 content">
                <h1>Add Property</h1>
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        include ("../Config/Connection.php");
                        $conn = oci_connect($UName,$PWord,$DB);
                        if (!$conn) {
                            $e = oci_error();
                            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                        }

                        // Get all property types
                        $query= "SELECT type_id, type_name FROM property_type ORDER BY type_name";
                        $stmt = oci_parse($conn, $query);

                        oci_execute($stmt);
                        $Types = oci_fetch_array ($stmt);
                        ?>

                        <!-- TODO input validation on date -->
                        <form id="prop-form" data-toggle="validator" method="post" Action="ManagePropertyCreate.php">
                            <div class="form-group date row">
                                <label for="listing-date-input" class="col-xs-2 col-form-label">Listing Date</label>
                                <div class="col-xs-10">
                                    <input name="listingDate" class="form-control" value="" type="text" id="listing-date-input" required>
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
                            <div class="form-group row">
                                <label for="type-input" class="col-xs-2 col-form-label">Property Type</label>
                                <div class="col-xs-10">
                                    <select name="type" class="form-control">
                                        <?php
                                        while ($types = oci_fetch_array ($stmt))
                                        {
                                            ?>
                                            <option value="<?php echo $types["TYPE_ID"];?>">
                                                <?php echo $types["TYPE_NAME"]; ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- TODO price and seller error handling -->
                            <div class="form-group price row">
                                <label for="price-input" class="col-xs-2 col-form-label">Property Price (Numeric Only)</label>
                                <div class="col-xs-10">
                                    <input name="price" class="form-control" maxlength="4" type="number" id="price-input" required>
                                </div>
                            </div>

                            <div class="form-group col-md-1 offset-md-11">
                                <button id="done-button" type="submit" role="button" onclick="go()" class="btn btn-primary">CREATE</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add a footer to each displayed page -->
        <div class="col-md-12" >
            <nav class="navbar navbar-fixed-bottom navbar-light bg-faded" id="footer">
                <a class="navbar-brand" href="#">Footer</a>
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

    var inputElements = [
        "street-num-input",
        "street-name-input",
        "suburb-input",
        "state-input",
        "zip-input"
    ];
    var streetNumInput = document.getElementById("street-num-input");
    var streetNameInput = document.getElementById("street-name-input");
    var suburbInput = document.getElementById("suburb-input");
    var stateNumInput = document.getElementById("state-input");
    var zipNumInput = document.getElementById("zip-input");

    // Add or remove bootstrap styling on key-up
    streetNumInput.addEventListener("keyup", function (event) {
        handleValidation(streetNumInput)
    }, false);
    // Add or remove bootstrap styling on key-up
    streetNameInput.addEventListener("keyup", function (event) {
        handleValidation(streetNameInput)
    }, false);
    // Add or remove bootstrap styling on key-up
    suburbInput.addEventListener("keyup", function (event) {
        handleValidation(suburbInput)
    }, false);
    // Add or remove bootstrap styling on key-up
    stateNumInput.addEventListener("keyup", function (event) {
        handleValidation(stateNumInput)
    }, false);
    // Add or remove bootstrap styling on key-up
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