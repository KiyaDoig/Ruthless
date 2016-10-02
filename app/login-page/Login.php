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

<?php
//create MDS constants
define("MONASH_DIR", "ldap.monash.edu.au");
define("MONASH_FILTER","o=Monash University, c=au");

ob_start();
session_start();

if (!isset($_SESSION["login"]))
{
    $_SESSION["server"] = $_SERVER["PHP_SELF"];
    $_SESSION["login"] = false;
    $_SESSION["tried"] = false;
}

?>

<body>
    <div class="row" id="main-header">
        <?php include '../Elements/MainHeader.php' ?>
    </div>

<div class="row" id="main-area">
    <?php include '../Elements/SideBar.php' ?>
    <!-- Here's where I want my views to be displayed -->
    <div class="col-md-9 main-content">
        <div class="row">
            <!-- Main contents will goes here -->
            <div class="col-md-12">
                <!-- write content here -->
                <h1>Login Page</h1>

                <?php
                if(empty($_POST["uname"]))
                {
                ?>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            if($_SESSION["login"] == true){
                                //If logged in go straight to the home page.
                                echo "You are logged in";
                                header("Location: ../main-page/Home.php");
                            }
                            else{
                                //Not logged in - thus notified

                                    ?>
                                        <div class="alert alert-warning" role="alert">
                                            <strong>Oh snap!</strong> Please attempt to login again.
                                        </div>
                                    <?php
                            }
                            ?>
                            <form method="post" Action="">
                                <center>Please log in using your Authcate Details
                                </center>

                                <div class="form-group row">
                                    <label for="uname" class="col-xs-2 col-form-label">Username</label>
                                    <div class="col-xs-10">
                                        <input class="form-control" type="text" value="" id="uname" name="uname">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="pword" class="col-xs-2 col-form-label">Password</label>
                                    <div class="col-xs-10">
                                        <input class="form-control" type="password" value="" id="pword" name="pword">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Log in</button>
                            </form>

                            <?php
                            }
                            else
                            {
                                $LDAPconn=@ldap_connect(MONASH_DIR);
                                if($LDAPconn)
                                {
                                    $LDAPsearch=@ldap_search($LDAPconn,MONASH_FILTER,
                                        "uid=".$_POST["uname"]);
                                    if($LDAPsearch)
                                    {
                                        $LDAPinfo =
                                            @ldap_first_entry($LDAPconn,$LDAPsearch);
                                        if($LDAPinfo)
                                        {
                                            $LDAPresult=
                                                @ldap_bind($LDAPconn,
                                                    ldap_get_dn($LDAPconn, $LDAPinfo),
                                                    $_POST["pword"]);
                                        }
                                        else
                                        {
                                            $LDAPresult=0;
                                        }
                                    }
                                    else
                                    {
                                        $LDAPresult=0;
                                    }
                                }
                                else
                                {
                                    $LDAPresult=0;
                                }
                                if($LDAPresult)
                                {
                                    //This is where the action can become true
                                    $_SESSION["login"] = true;

                                    //Get the username from the person logged in
                                    $_SESSION["username"] = $_POST["uname"];

                                    $temp = $_SESSION["server"];
                                    header("Location: ../main-page/Home.php");
                                }
                                else
                                {
                                    //This is where the error message should sit
                                    $temp = $_SESSION["server"];
                                    $_SESSION["old"] = true;

                                    //Add session variable to add error message.
                                    $_SESSION["tried"] = true;

                                    header("Location: Login.php");
                                }
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add a footer to each displayed page -->
        <!-- Display a footer -->
        <div class="col-md-12" >
            <nav class="navbar navbar-fixed-bottom navbar-light bg-faded" id="footer">
                <div class="col-md-2 offset-md-8">
                    <p>Click to display code:</p>
                </div>
                <div class="col-md-2">
                    <a class="btn btn-primary display-code" href="../DisplayCode.php" role="button" target="_blank">Login Page</a>
                </div>
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

