<?php
include_once "functions.php";
$user = $_POST["user"];
$name = $_POST["name"];
$Image = $_POST["Image"];
try
{
    $id = addGroup($user,$name,$Image);
    subscribeToGroup($id,$user);
    echo $id;
}
catch (Exception $exception)
{
    echo $exception->getMessage();
}