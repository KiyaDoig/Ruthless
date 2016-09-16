<?php
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
                <h1>Update Property</h1>
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        include ("../Config/Connection.php");
                        $conn = oci_connect($UName,$PWord,$DB);
                        if (!$conn) {
                            $e = oci_error();
                            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
                        }

                        // Get property record by id
                        $query='BEGIN getPropertyById(:arg_pid, :pid, :pnum, :pstreet, :psuburb, :pstate, :pzip, :ptype); END;';
                        $stmt = oci_parse($conn, $query);

                        // TODO (testing only) -put this back and remove j
                        //oci_bind_by_name($stmt, ":arg_pid", $_POST["activePropertyId"]);
                        $j = 2;
                        oci_bind_by_name($stmt, ":arg_pid", $j);
                        //need to specify maximum length of output parameter
                        oci_bind_by_name($stmt,":pid", $pid, 10);
                        oci_bind_by_name($stmt,":pnum", $pnum, 20);
                        oci_bind_by_name($stmt,":pstreet", $pstreet, 20);
                        oci_bind_by_name($stmt,":psuburb", $psuburb, 40);
                        oci_bind_by_name($stmt,":pstate", $pstate, 20);
                        oci_bind_by_name($stmt,":pzip", $pzip, 10);
                        oci_bind_by_name($stmt,":ptype", $ptype, 10);

                        oci_execute($stmt);
                        ?>

                        <?php
                        // Get all property types
                        $query= "SELECT type_id, type_name FROM property_type ORDER BY type_name";
                        $stmt = oci_parse($conn, $query);

                        oci_execute($stmt);
                        $Types = oci_fetch_array ($stmt);


                        ?>

                        <form method="post" Action="ManagePropertyUpdate.php">
                            <div class="form-group row">
                                <label for="prop-id-input" class="col-xs-2 col-form-label">Property ID</label>
                                <div class="col-xs-10">
                                    <input name="id" class="form-control" type="number" value="<?php echo $pid;?>" id="prop-id-input" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="street-num-input" class="col-xs-2 col-form-label">Street Number</label>
                                <div class="col-xs-10">
                                    <input name="streetNum" class="form-control" maxlength="10" type="text" value="<?php echo $pnum;?>" id="street-num-input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="street-name-input" class="col-xs-2 col-form-label">Street Name</label>
                                <div class="col-xs-10">
                                    <input name="streetName" class="form-control" type="text" value="<?php echo $pstreet;?>" id="street-name-input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="suburb-input" class="col-xs-2 col-form-label">Suburb</label>
                                <div class="col-xs-10">
                                    <input name="suburb" class="form-control" type="text" value="<?php echo $psuburb;?>" id="suburb-input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="state-input" class="col-xs-2 col-form-label">State</label>
                                <div class="col-xs-10">
                                    <input name="state" class="form-control" maxlength="6" type="text" value="<?php echo $pstate;?>" id="state-input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="zip-input" class="col-xs-2 col-form-label">ZIP</label>
                                <div class="col-xs-10">
                                    <input name="zip" class="form-control" maxlength="4" type="text" value="<?php echo $pzip;?>" id="zip-input">
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
                                            <option value="<?php echo $types["TYPE_ID"];?>"
                                                <?php echo selectType($ptype, $types["TYPE_NAME"]);?>>
                                                <?php echo $types["TYPE_NAME"]; ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1 offset-md-11">
                                <button type="submit" role="button" class="btn btn-primary">Done</button>
                            </div>

                        </form>
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