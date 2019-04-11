<?php
include_once "functions.php";
$group = $_POST["group"];
$SelectedUser = $_POST["SelectedUser"];
$id = AddUserToGroup($group,$SelectedUser);
echo $id;