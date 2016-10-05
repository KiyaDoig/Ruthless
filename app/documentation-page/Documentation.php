<?php
//======================================================================
// This page displays the documentation relating to assignment 2.

//======================================================================

ob_start();
include ("../login-page/LoginCheck.php");
include ("../Config/Connection.php");
include ("../Config/ErrorHandler.php");

// Set error and exception handlers
set_error_handler( "log_error" );
set_exception_handler( "log_exception" );
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
            <h1>Documentation</h1>
            <p>
                1.<br>
                Kiya Doig, 25152017 <br>
                Stephan Prioriello, 25946498 <br>
                <strong>Date of submission: </strong>
            </p>

            <p>
                2. Database <br>
                <strong>Username: s25152017 </strong> <br>
                <strong>Password: monash00 </strong> <br>
            </p>

            <p>
                3.
                <a href='https://drive.google.com/open?id=0B6bzwU9x1k2GOXdxblRXODhVRjg' target="_blank">Link to Create Table statements</a>
            </p>

            <p>
                4.
                <a href='' target="_blank">Link to folder with current database data screenshots</a>
            </p>

            <p>
                5.
                <a href='https://docs.google.com/a/monash.edu/document/d/1osKh1KW8ZDQgp7tU8cMa804Bn-r4uwpeNwydiEceBvY/edit?usp=sharing' target="_blank">Link to work breakdown document</a>
            </p>

        </div>

        <!-- Add a footer to each displayed page -->
        <div class="col-md-12" >
            <nav class="navbar navbar-fixed-bottom navbar-light bg-faded" id="footer">
                <a class="navbar-brand" href="#">Footer</a>
            </nav>
        </div>
    </div>

</div>

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