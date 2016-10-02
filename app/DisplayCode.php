<!--
    This page reads and displays the code for the page from which the footer button was clicked.
    It uses the session variable $page to determine the origin page of the request.
---->
<html>
<body>
<?php
ob_start();
session_start();
$page = ($_SESSION['page']);

switch ($page) {
    // Login Page
    case "Login":
        echo '<p style="color:red;">Page content by Stephan</p>';
        show_source("login-page/Login.php");
        break;
    // Home page
    case "Main":
        echo '<p style="color:red;">Page content by Stephan</p>';
        show_source("main-page/Home.php");
        break;
    // Property pages
    case "BrowseManageProperty":
        echo '<p style="color:red;">Page content by Kiya</p>';
        show_source("browse-manage-properties/BrowseManageProperty.php");
        echo '<p style="color:red;">The code to manage delete in ManagePropertyDelete.php</p>';
        show_source("browse-manage-properties/ManagePropertyDelete.php");
        break;
    case "UpdateProperty":
        echo '<p style="color:red;">Page content by Kiya</p>';
        show_source("browse-manage-properties/UpdateProperty.php");
        echo '<p style="color:red;">The code to manage update in ManagePropertyUpdate.php</p>';
        show_source("browse-manage-properties/ManagePropertyUpdate.php");
        break;
    case "AddProperty":
        echo '<p style="color:red;">Page content by Kiya</p>';
        show_source("add-property/AddProperty.php");
        echo '<p style="color:red;">The code to manage property create in ManagePropertyCreate.php</p>';
        show_source("add-property/ManagePropertyCreate.php");
        break;
    case "AddImages":
        echo '<p style="color:red;">Page content by Kiya</p>';
        show_source("add-property/AddImages.php");
        break;
    // Client page
    case "Client":
        echo '<p style="color:red;">Page content by Stephan</p>';
        show_source("manage-clients/ManageClients.php");
        break;
    // Type Page
    case "Types":
        echo '<p style="color:red;">Page content by Stephan</p>';
        show_source("manage-property-types/PropertyTypes.php");
        break;
    // Feature page
    case "Feature":
        echo '<p style="color:red;">Page content by Stephan</p>';
        show_source("feature-page/Feature.php");
        break;
    // Multiple property edit page
    case "MultipleProperty":
        echo '<p style="color:red;">Page content by Kiya</p>';
        show_source("multiple-property-edit/MultiplePropertyEdit.php");
        echo '<p style="color:red;">The code to manage update in ManagePriceUpdate.php</p>';
        show_source("multiple-property-edit/ManagePriceUpdate.php");
        break;
    // Images page
    case "Images":
        echo '<p style="color:red;">Page content by Kiya</p>';
        show_source("images-page/ImagesPage.php");
        echo '<p style="color:red;">The code to manage update in ManageImagesDelete.php</p>';
        show_source("images-page/ManageImagesDelete.php");
        break;
}

?>

</body>
</html>
<?php
ob_end_flush();
?>


