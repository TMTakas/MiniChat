<?php
    include_once "functions.php";
    $globalGroups = getGlobalGroups();
    $mygroups = getMyGroups($username);
?>

<div class="page-sidebar navbar-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->
    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <ul class="page-sidebar-menu   " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
        <li class="nav-item start <?php echo $whatPage == "Chatter en groupe" ? "active open" : "" ?>">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-home"></i>
                <span class="title">Discuter en groupe</span>
                <span class="selected"></span>
                <span class="arrow open"></span>
            </a>
            <ul class="sub-menu">
                <!--<li class="nav-item start active open">
                    <a href="index.html" class="nav-link ">
                        <img src="https://lipis.github.io/flag-icon-css/flags/4x3/fr.svg" height="20px" width="20px" style="margin-top: -2px"/>
                        <span class="title">Dashboard 1</span>
                        <span class="selected"></span>
                    </a>
                </li>-->
                <?php
                while ($row = $globalGroups->fetch(PDO::FETCH_ASSOC))
                {
                    $active = $groupId == $row["id"] && $whatPage == "Chatter en groupe" ? "active" : "";
                    echo "<li class=\"nav-item start $active \">";
                    echo "<a href=\"group.php?id=".$row["id"]."\" class=\"nav-link \">";
                    echo "<img src=\"".$row["menu_image"]."\" height=\"20px\" width=\"20px\" style=\"margin-top: -2px; margin-right: 10px\"/>";
                    echo "<span class=\"title\">". $row["name"] ."</span>";
                    echo "</a>";
                    echo "</li>";
                }
                while ($row = $mygroups->fetch(PDO::FETCH_ASSOC))
                {
                    $active = $groupId == $row["id"] && $whatPage == "Chatter en groupe" ? "active" : "";
                    echo "<li class=\"nav-item start $active \">";
                    echo "<a href=\"group.php?id=".$row["id"]."\" class=\"nav-link \">";
                    echo "<img src=\"".$row["menu_image"]."\" height=\"20px\" width=\"20px\" style=\"margin-top: -2px; margin-right: 10px\"/>";
                    echo "<span class=\"title\">". $row["name"] ."</span>";
                    echo "</a>";
                    echo "</li>";
                }
                ?>
            </ul>
        </li>
        <li class="nav-item  <?php echo $whatPage == "Créer un groupe" || $whatPage == "Rechercher un utilisateur" ? "active open" : "" ?>">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-briefcase"></i>
                <span class="title">Fonctionnalité</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  <?php echo $whatPage == "Créer un groupe" ? "active" : "" ?>">
                    <a href="create_group.php" class="nav-link ">
                        <span class="title">Créer un groupe</span>
                    </a>
                </li>
                <li class="nav-item  <?php echo $whatPage == "Rechercher un utilisateur" ? "active" : "" ?>">
                    <a href="search_user.php" class="nav-link ">
                        <span class="title">Rechercher un utilisateur</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- END SIDEBAR MENU -->
</div>