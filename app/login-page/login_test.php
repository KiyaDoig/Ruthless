<?php
//create MDS constants
define("MONASH_DIR", "ldap.monash.edu.au");
define("MONASH_FILTER","o=Monash University, c=au");
?>
<html>
<head>
    <title>LDAP Example</title>
</head>
<body>
<?php
if(empty($_POST["uname"]))
{
?>
<form method="post" action="login_test.php">
    <center>Please log in using your Authcate Details
    </center><p />
    <table border="0" align="center" cellspacing="5">
        <tr>
            <td>Authcate Username</td>
            <td>Authcate Password</td>
        </tr>
        <tr>
            <td><input type="text" name="uname"
                       size="15"></td>
            <td><input type="password" name="pword"
                       size="15"></td>
        </tr>
    </table><p />
    <center>
        <input type="submit" value="Log in">
        <input type="reset" value="Reset">
    </center>
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
            echo "Valid User";
        }
        else
        {
            echo "Invalid User";
        }
    }
    ?>
</body>
</html>