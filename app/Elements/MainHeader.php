<!-- Main header element -->
<div class="col-md-12" id="main-header-right">
    <div class="col-md-10"></div>
    <?php
    if (isset($_SESSION["login"]))
    {
        if($_SESSION["login"] == true)
        {
        ?>
           <div class="col-md-2">
        		<button type="button" class="btn btn-link" id="logout" onclick="location.href='../login-page/logout.php';">Logout</button>
    		</div>
    	<?php
        }
    }
    ?>
</div>