<?php
include_once "functions.php";
$search = $_GET["search"];
$last_id = $_GET["last_id"];
$users = getUsers($search, $last_id);
$tmpVar = 0;
while ($row = $users->fetch(PDO::FETCH_ASSOC))
{
    if($tmpVar == 0)
        echo "<div class=\"row\">";
    $img = $row["profile_image"];
    $name = $row["full_name"];
    $user = $row["user"];
    echo "<div class=\"col-lg-3 col-md-4 col-sm-6 col-xs-12\">
                                        <div class=\"mt-card-item\">
                                            <div class=\"mt-card-avatar mt-overlay-1\">
                                                <img src=\"$img\">
                                                <div class=\"mt-overlay\">
                                                    <ul class=\"mt-info\">
                                                        <li>
                                                            <a class=\"btn default btn-outline\" href=\"message.php?user=$user\">
                                                                <i class=\"fa fa-envelope\"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <button value='$user' class=\"btn default btn-outline\" data-toggle=\"modal\" data-target=\"#SelectGroupe\" onclick='SelectUserFunction(this);' >
                                                                <i class=\"fa fa-plus\"></i>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class=\"mt-card-content\">
                                                <h3 class=\"mt-card-name\">$name</h3>
                                            </div>
                                        </div>
                                    </div>";
    $tmpVar++;
    if($tmpVar == 4)
    {
        echo "</div>";
        $tmpVar = 0;
    }
}