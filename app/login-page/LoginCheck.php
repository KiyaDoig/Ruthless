<?php
/**
 * Purpose: This file is meant to run the check of the login
 */

session_start();

if (isset($_SESSION["login"]))
{
    if(!$_SESSION["login"])
    {
        $_SESSION["server"] = $_SERVER["PHP_SELF"];
        header("Location: ../home.php?PHPSESSID=".session_id());
    }

}
else
{
    $_SESSION["login"] = false;
    $_SESSION["server"] = $_SERVER["PHP_SELF"];
    header("Location: ../home.php?PHPSESSID=".session_id());
}

?>