<?php
include_once "functions.php";
$operation = $_POST["operation"];
$user = $_POST["user"];
if($operation == 1)
{
    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $adress = $_POST["adress"];
    $city = $_POST["city"];
    $country = $_POST["country"];
    saveProfile($user,$full_name,$email,$adress,$city,$country);
}
else if($operation == 2)
{
    echo "yes";
}