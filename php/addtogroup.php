<?php 
    include "db_connect.php";
    include "checklogin.php";

    if (checkLogin()){
        $login = $_COOKIE["login"];
        $res = $conn->query("SELECT roles.permissions as 'perms' FROM roles, profile WHERE profile.login='{$login}' AND profile.roleID=roles.id");
        $perms = $res->fetch_row();
        $perms = isset($perms) ? $perms[0] : "";
    }
    
    if (str_contains($perms, "add_stud") || str_contains($perms, "manage_all")){
        $FIO = $_POST["name"];
        $groupID = $_POST["groupID"];
        $conn->query("INSERT INTO students(FIO, groupID) VALUES ('{$FIO}', {$groupID})");
    } else {
        echo "You don't have permission to do this.";
    }
    
?>