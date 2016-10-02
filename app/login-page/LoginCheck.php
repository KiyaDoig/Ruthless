<?php
/**
 * Created by PhpStorm.
 * User: BerettaFTW
 * Date: 21/09/2016
 * Time: 7:12 PM
 */

//======================================================================
// This checks the status of the login.

// Author: Stefan Prioriello
//======================================================================

session_start();

if (isset($_SESSION["login"]))
{
    if($_SESSION["login"] == false)
    {
        $_SESSION["server"] = $_SERVER["PHP_SELF"];
        header("Location: ../login-page/Login.php?PHPSESSID=".session_id());
    }
    else{
        //Do nothing because they are logged in. YAY!
    }

}
else
{
    $_SESSION["login"] = false;
    $_SESSION["server"] = $_SERVER["PHP_SELF"];
    header("Location: ../login-page/Login.php?PHPSESSID=".session_id());
}

?>