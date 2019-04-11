<?php
include_once "functions.php";
$message = $_POST["message"];
$group_id = $_POST["group_id"];
$username_id = $_POST["username_id"];
$chatWith_id = $_POST["chatWith_id"];
try
{
    $id = $chatWith_id == -1 ? postMessage($message,$group_id,$username_id) : postMessageUser($message,$chatWith_id,$username_id);
    echo $id;
}
catch (Exception $exception)
{
    echo "-1";
}