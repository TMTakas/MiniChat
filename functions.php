<?php

include_once "db_connection.php";

function register($fullname, $email, $address, $city, $country, $username, $password)
{
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM user WHERE user = :user OR email = :email");
    $stmt->bindParam(':user', $username);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user_found = $stmt->fetchColumn() > 0;
    if($user_found)
        return "0";
    else
    {
        try
        {
            $stmt = $conn->prepare("INSERT INTO user VALUES (:fullname, :email, :address, :city, :country, :username, :password, 0, 'https://www.buira.org/assets/images/shared/default-profile.png')");
            $stmt->bindParam(':fullname', $fullname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':country', $country);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
        }catch(Exception $e)
        {
            echo $e->getMessage();
            return "-1";
        }
        return "1";
    }
}
function checkLogin($username, $password){
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM user WHERE user = :user AND pass = :pass");
    $stmt->bindParam(':user', $username);
    $stmt->bindParam(':pass', $password);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}
function checkEmail($email){
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM user WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}
function sendRestEmail($email)
{
    global $conn;
    $stmt = $conn->prepare("SELECT pass FROM user WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $pass = $stmt->fetchColumn();
    $msg = "Votre mot de pass est : $pass";
    $headers =  'MIME-Version: 1.0' . "\r\n";
    $headers .= 'From: MiniChat <mondir.jaatar@gmail.com>' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    mail("mondir.jaatar@gmail.com","Votre mot de pass",$msg,$headers);
}
function checkUser($username){
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM user WHERE user = :user");
    $stmt->bindParam(':user', $username);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}
function checkUserPermToGroup($group, $SelectedUser)
{
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM subscribed_group WHERE id_group = :id_group AND user = :user");
    $stmt->bindParam(':id_group', $group);
    $stmt->bindParam(':user', $SelectedUser);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}
function AddUserToGroup($group, $SelectedUser)
{
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM subscribed_group WHERE id_group = :id_group AND user = :user");
    $stmt->bindParam(':id_group', $group);
    $stmt->bindParam(':user', $SelectedUser);
    $stmt->execute();
    if($stmt->fetchColumn() > 0)
        return 0;
    else
    {
        try
        {
            $stmt = $conn->prepare("INSERT INTO subscribed_group VALUES(:id_group, :user)");
            $stmt->bindParam(':id_group', $group);
            $stmt->bindParam(':user', $SelectedUser);
            $stmt->execute();
            return 1;
        }
        catch (Exception $e)
        {
            return -1;
        }
    }
    return 1;
}
function resetPassword($email){
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM user WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    if($stmt->fetchColumn() > 0)
    {
        return "4";
    }
    else
        return "5";
}
function getGlobalGroups()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM `group` WHERE is_global = 1 ORDER BY id");
    $stmt->execute();
    return $stmt;
}
function getMyGroups($username)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM minichat.group WHERE id IN(
                                      SELECT id_group FROM subscribed_group WHERE subscribed_group.user = :username)");
    $stmt->bindParam(':username',$username);
    $stmt->execute();
    return $stmt;
}
function getRowById($id)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM `group` WHERE id = :id");
    $stmt->bindParam(':id',$id);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result;
}
function getUser($username)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM `user` WHERE `user` = :user");
    $stmt->bindParam(':user',$username);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result;
}
function getMessagesOfGroup($id_group, $last_id)
{
    global $conn;
    $req = "SELECT * FROM minichat.message WHERE id_group = :id_group ";
    if($last_id != -1)
        $req = $req . " AND id > :id ";
    $req = $req . " ORDER BY id DESC LIMIT 10";
    $stmt = $conn->prepare($req);
    $stmt->bindParam(':id_group',$id_group);
    if($last_id != -1)
        $stmt->bindParam(':id',$last_id);
    $stmt->execute();
    return $stmt;
}
function getMessagesOfUser($last_id,$username_id, $chatWith_id)
{
    global $conn;
    $req = "SELECT * FROM minichat.message WHERE ((sended_user = :username_id AND to_user = :chatWith_id) OR (to_user = :username_id AND sended_user = :chatWith_id))";
    if($last_id != -1)
        $req = $req . " AND id > :id ";
    $req = $req . " ORDER BY id DESC LIMIT 10";
    $stmt = $conn->prepare($req);
    $stmt->bindParam(':username_id',$username_id);
    $stmt->bindParam(':chatWith_id',$chatWith_id);
    if($last_id != -1)
        $stmt->bindParam(':id',$last_id);
    $stmt->execute();
    return $stmt;
}
function postMessage($message, $group_id, $username_id)
{
    global $conn;
    $stmt = $conn->prepare("INSERT INTO message(message,id_group,sended_user) VALUES(:message, :group_id, :username_id)");
    $stmt->bindParam(':message', $message);
    $stmt->bindParam(':group_id', $group_id);
    $stmt->bindParam(':username_id', $username_id);
    $stmt->execute();
    return $conn->lastInsertId();
}
function subscribeToGroup($group_id, $username)
{
    global $conn;
    $stmt = $conn->prepare("INSERT INTO subscribed_group VALUES(:group_id, :username)");
    $stmt->bindParam(':group_id', $group_id);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    return $conn->lastInsertId();
}
function postMessageUser($message, $chatWith_id, $username_id)
{
    global $conn;
    $stmt = $conn->prepare("INSERT INTO message(message,sended_user,to_user) VALUES(:message, :username_id, :chatWith_id)");
    $stmt->bindParam(':message', $message);
    $stmt->bindParam(':username_id', $username_id);
    $stmt->bindParam(':chatWith_id', $chatWith_id);
    $stmt->execute();
    return $conn->lastInsertId();
}
function saveProfile($user, $full_name, $email, $adress, $city, $country)
{
    global $conn;
    $stmt = $conn->prepare("UPDATE user SET full_name = :full_name, email = :email, adress = :adress, city = :city, country = :country WHERE user = :user");
    $stmt->bindParam(':full_name', $full_name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':adress', $adress);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':country', $country);
    $stmt->bindParam(':user', $user);
    $stmt->execute();
}
function addGroup($user, $name, $Image)
{
    global $conn;
    $stmt = $conn->prepare("INSERT INTO `group`(`name`,menu_image,is_global,`user`) VALUES(:name,:Image,0,:user)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':Image', $Image);
    $stmt->bindParam(':user', $user);
    $stmt->execute();
    return $conn->lastInsertId();
}
function getUsers($search, $last_id)
{
    global $conn;
    $req = "SELECT * FROM minichat.user ";
    if($last_id != -1)
        $req = $req . " AND id > :id ";
    if($search != "")
        $req .= " WHERE CONCAT(full_name,';',email,';',adress,';',city,';',country,';',`user`) LIKE '%$search%'";
    //$req = $req . " ORDER BY id DESC LIMIT 10";
    $stmt = $conn->prepare($req);
    //if($search != "")
    //    $stmt->bindParam(':search',$search);
    if($last_id != -1)
        $stmt->bindParam(':id',$last_id);
    $stmt->execute();
    return $stmt;
}