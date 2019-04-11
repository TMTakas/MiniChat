<?php
include_once "functions.php";
$id_group = $_GET["id_group"];
$last_id = $_GET["last_id"];
$username_id = $_GET["username_id"];
$chatWith_id = $_GET["chatWith_id"];

$messages = $id_group != -1 ? getMessagesOfGroup($id_group, $last_id) : getMessagesOfUser($last_id,$username_id,$chatWith_id);

while ($row = $messages->fetch(PDO::FETCH_ASSOC))
{
    $user = getUser($row["sended_user"]);
    $image = $user["profile_image"];
    $full_name = $user["full_name"];
    $date = $row["sended_date"];
    $message = $row["message"];
    $id = $row["id"];
    $style = $row["sended_user"] == $username_id ? "style='background-color: #c9c9c9;'" : "";
    $style2 = $row["sended_user"] == $username_id ? "style = 'border-right-color: #c9c9c9;'" : "";
    $style3 = $row["sended_user"] == $username_id ? "style = 'color: #787575 !important;'" : "";
    echo "<input name = \"message_id\" type=\"hidden\" value=\"$id\">";
    echo "<div class=\"timeline-item\"><div class=\"timeline-badge\">";
    echo "<img class=\"timeline-badge-userpic\" src=\"$image\"> </div>";
    echo "<div class=\"timeline-body\" $style>
                                            <div class=\"timeline-body-arrow\" $style2> </div>
                                            <div class=\"timeline-body-head\">
                                                <div class=\"timeline-body-head-caption\">";
    echo "<a href=\"javascript:;\" class=\"timeline-body-title font-blue-madison\">$full_name</a>";
    echo "<span class=\"timeline-body-time font-grey-cascade\" $style3>Envoyé $date</span>";
    echo "</div>";
    echo "<div class=\"timeline-body-head-actions\" style='visibility: hidden;'>
                                                    <div class=\"btn-group\">
                                                        <button class=\"btn btn-circle green btn-sm dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\" data-hover=\"dropdown\" data-close-others=\"true\"> Actions
                                                            <i class=\"fa fa-angle-down\"></i>
                                                        </button>
                                                        <ul class=\"dropdown-menu pull-right\" role=\"menu\">
                                                            <li>
                                                                <a href=\"javascript:;\">Action </a>
                                                            </li>
                                                            <li>
                                                                <a href=\"javascript:;\">Another action </a>
                                                            </li>
                                                            <li>
                                                                <a href=\"javascript:;\">Something else here </a>
                                                            </li>
                                                            <li class=\"divider\"> </li>
                                                            <li>
                                                                <a href=\"javascript:;\">Separated link </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>";
    echo "<div class=\"timeline-body-content\">
                                                                        <span class=\"font-grey-cascade\" $style3> $message </span>
                                            </div>
                                        </div>
                                    </div>";
}
?>


