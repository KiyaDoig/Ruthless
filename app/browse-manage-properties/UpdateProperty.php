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

               <?php  var_dump($_POST); ?>

                    <div class="row" id="properties-table">
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

                        // USE THE POST VARIABLE
                        $j = 2;

                        oci_bind_by_name($stmt, ":arg_pid", $j);
                        //need to specify maximum length of output parameter
                        oci_bind_by_name($stmt,":pid", $pid, 10);
                        oci_bind_by_name($stmt,":pnum", $pnum, 20);
                        oci_bind_by_name($stmt,":pstreet", $pstreet, 20);
                        oci_bind_by_name($stmt,":psuburb", $psuburb, 40);
                        oci_bind_by_name($stmt,":pstate", $pstatet, 20);
                        oci_bind_by_name($stmt,":pzip", $pzip, 10);
                        oci_bind_by_name($stmt,":ptype", $ptype, 10);

                        oci_execute($stmt);
                        ?>
                        <table>
                        <?php
                        echo "<tr>";
                        echo "<td>$pid</td>";
                        echo "<td>$pnum</td>";
                        echo "<td>$pstreet</td>";
                        echo "<td>$psuburb</td>";
                        echo "<td>$pstatet</td>";
                        echo "</tr>";
                        ?>
                        </table>


                    </div>
                </div>
                <d   class="row">
                    <div class="col-md-3 offset-md-9">

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