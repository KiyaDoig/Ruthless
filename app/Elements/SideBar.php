<!-- Sidebar, has include for nav element -->
<div class="col-md-3" id="side-bar">
    <div class="row" id="main-header-left">
        <h3>Ruthless</h3>
    </div>
    <div class="row">
        <div id="user-panel">
            <img src="../Images/ic_account_circle_white_48dp_1x.png" class="img-circle" alt="User Image">
            <span id="user-name"><?php echo "User: " . $_SESSION["username"];?></span>
        </div>
    </div>
    <div class="row separator"></div>
    <div class="row">
        <!-- Navigation -->
        <nav role="navigation">
            <?php include 'Nav.php' ?>
        </nav>
    </div>

</div>