<?php
//======================================================================
// This page handles errors from the database for connection, statement and execute oci errors.
// A user friendly error page is displayed with a button to return to the previous page.

// Author: Kiya
//======================================================================

function log_error( $num, $str, $file, $line, $context = null )
{

    log_exception( new ErrorException( $str, 0, $num, $file, $line ) );
}

function log_exception( Exception $e )
{
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

    <div class="row" id="main-area">
        <div class="col-md-9 main-content">
            <div class="row">
                <div class="col-md-12">
                    <h1>An Error Occurred</h1>
                    <div class="col-md-6 offset-md-3">
                        <p>An error occurred in the requested database transaction.</p>
                        <p>Please try again or contact your site administrator if the issue persists.</p>
                        <a class="btn btn-primary" href="" onclick="history.go(-1);" role="button">GO BACK</a>
                    </div>
                </div>
            </div>

            <!-- Add a footer to each displayed page -->
            <div class="col-md-12" >
                <nav class="navbar navbar-fixed-bottom navbar-light bg-faded" id="footer">

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
    exit();
}