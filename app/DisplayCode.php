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
        echo '<p style="color:red;">Page content by Stefan</p>';
        show_source("login-page/Login.php");
        echo '<p style="color:red;">The code to manage login checks on all the pages</p>';
        show_source("login-page/loginCheck.php");
        echo '<p style="color:red;">The code to manage logouts</p>';
        show_source("login-page/logout.php");
        break;
    // Home page
    case "Main":
        echo '<p style="color:red;">Page content by Stefan</p>';
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
    // Client pages
    case "BrowseMangeClient":
        echo '<p style="color:red;">Page content by Stefan</p>';
        show_source("manage-clients/BrowseManageClient.php");
        echo '<p style="color:red;">The code to manage delete in ManageClientDelete.php</p>';
        show_source("manage-clients/ManageClientDelete.php");
        break;
    case "AddClient":
        echo '<p style="color:red;">Page content by Stefan</p>';
        show_source("manage-clients/AddClient.php");
        echo '<p style="color:red;">The code to manage property type create in ManageClientCreate.php</p>';
        show_source("manage-clients/ManageClientCreate.php");
        break;
    case "UpdateClient":
        echo '<p style="color:red;">Page content by Stefan</p>';
        show_source("manage-clients/UpdateClient.php");
        echo '<p style="color:red;">The code to manage update in ManageClientUpdate.php</p>';
        show_source("manage-clients/ManageClientUpdate.php");
        break;
    // Type Page
    case "BrowsePropertyType":
        echo '<p style="color:red;">Page content by Stefan</p>';
        show_source("manage-property-types/BrowseManagePropertyType.php");
        echo '<p style="color:red;">The code to manage delete in ManagePropertyTypeDelete.php</p>';
        show_source("manage-property-types/ManagePropertyTypeDelete.php");
        break;
    case "AddPropertyType":
        echo '<p style="color:red;">Page content by Stefan</p>';
        show_source("manage-property-types/AddPropertyType.php");
        echo '<p style="color:red;">The code to manage property type create in ManagePropertyTypeCreate.php</p>';
        show_source("manage-property-types/ManagePropertyTypeCreate.php");
        break;
    case "UpdatePropertyType":
        echo '<p style="color:red;">Page content by Stefan</p>';
        show_source("manage-property-types/UpdatePropertyType.php");
        echo '<p style="color:red;">The code to manage update in ManagePropertyTypeUpdate.php</p>';
        show_source("manage-property-types/ManagePropertyTypeUpdate.php");
        break;
    // Feature page
    case "BrowseManageFeature":
        echo '<p style="color:red;">Page content by Stefan</p>';
        show_source("feature-page/BrowseManageFeature.php");
        echo '<p style="color:red;">The code to manage delete in ManageFeatureDelete.php</p>';
        show_source("feature-page/ManageFeatureDelete.php");
        break;
    case "AddFeature":
        echo '<p style="color:red;">Page content by Stefan</p>';
        show_source("feature-page/AddFeature.php");
        echo '<p style="color:red;">The code to manage property type create in ManageFeatureCreate.php</p>';
        show_source("feature-page/ManageFeatureCreate.php");
        break;
    case "UpdateFeature":
        echo '<p style="color:red;">Page content by Stefan</p>';
        show_source("feature-page/UpdateFeature.php");
        echo '<p style="color:red;">The code to manage update in ManageFeatureUpdate.php</p>';
        show_source("feature-page/ManageFeatureUpdate.php");
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
    //Documentation Page
    case "Documentation":
        echo '<p style="color:red;">Page content by Stefan</p>';
        show_source("decumentation-page/Documentation.php");
        break;
}

?>

</body>
</html>
<?php
ob_end_flush();
?>


