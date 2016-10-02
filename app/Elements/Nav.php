<!-- Navigation -->
<ul class="nav nav-pills nav-stacked" id="main-navigation">
    <li class="nav-item">
        <a class="nav-link" href="../main-page/Home.php">Main</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="../browse-manage-properties/BrowseManageProperty.php">Property</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="../manage-clients/BrowseManageClient.php">Client</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="../manage-property-types/BrowseManagePropertyType.php">Type</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="../feature-page/BrowseManageFeature.php">Feature</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="../multiple-property-edit/MultiplePropertyEdit.php">Multiple Property Edit</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="../images-page/ImagesPage.php">Images</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="../documentation-page/Documentation.php">Documentation</a>
    </li>
</ul>

<!-- Set the active class on selected nav item -->
<script>
    function setActive() {
        items = document.getElementById('main-navigation').getElementsByTagName('a');
        for(i = 0; i < items.length; i++) {
            if(document.location.href.indexOf(items[i].href)>= 0) {
                items[i].classList.add('active');
            }
        }
    }
    window.onload = setActive;
</script>
