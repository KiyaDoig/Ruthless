<?php
/**
 * Created by PhpStorm.
 * User: BerettaFTW
 * Date: 1/10/2016
 * Time: 10:47 PM
 */

//======================================================================
// This changes the login status to false, thus logged out.

// Author: Stefan Prioriello
//======================================================================

session_start();

if (isset($_SESSION["login"]))
{
    if($_SESSION["login"] == true)
    {
        $_SESSION["login"] = false;
        $_SESSION["tried"] = false;
        $_SESSION["username"] = "Logged Out";
        header("Location: ../login-page/Login.php?PHPSESSID=".session_id());
    }
    else{
        //Do nothing because they are logged in. YAY!
    }

}

?>