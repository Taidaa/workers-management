<?php 
    include "db_connect.php";
    include "checklogin.php";

    if (checkLogin()){
        $login = $_COOKIE["login"];
        $res = $conn->query("SELECT roles.permissions as 'perms',roles.id, profile.groupID as 'group'  FROM roles, profile WHERE profile.login='{$login}' AND profile.roleID=roles.id");
        $res = $res->fetch_assoc();
        $perms = isset($res["perms"]) ? $res["perms"] : "";
        $selfID = isset($res["id"]) ? $res["id"] : 0;
        $group = isset($res["group"]) ? $res["group"] : 0;
    }

    if (str_contains($perms, "del_stud")  || 
        str_contains($perms, "manage_all")||
        str_contains($perms, "manage_other")
    ){
        $id = $_POST["id"]; // ID TO DELETE

        $res = $conn->query("SELECT groupID,roleID FROM students WHERE students.id={$id}");
        if ($res = $res->fetch_assoc()){
            if ($res["roleID"] <= $selfID){
                if ($group == $res["groupID"] || str_contains($perms, "manage_all") || str_contains($perms, "manage_other")){
                    $conn->query("DELETE FROM students WHERE id={$id}");
                }
            }    
        } 
    } else {
        echo "\nYou don't have a permission to do this.";
    }
    
?>