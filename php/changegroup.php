<?php
    include "db_connect.php";
    include "checklogin.php";


    if (checkLogin()){
        
    }

    $groupID = isset($_POST["groupID"]) ? $_POST["groupID"] : null;

    if (checkLogin() && $groupID != 0){


        $login = $_COOKIE["login"];
        $res = $conn->query("SELECT roles.permissions as 'perms' FROM roles, profile WHERE profile.login='{$login}' AND profile.roleID=roles.id");
        $perms = $res->fetch_row();
        $perms = isset($perms) ? $perms[0] : "";


        if (isset($groupID) && (
                                str_contains($perms, "watch_all") 
                                || str_contains($perms, "manage_all") 
                                || str_contains($perms, "watch_other_groups") 
                                || str_contains($perms, "manage_other_groups")
                                )){
            $conn->query("UPDATE profile SET groupID={$groupID} WHERE id=(SELECT id from profile where login='{$_COOKIE['login']}')");
            echo "STATUS 200. OK.";
        } else {
            echo "Preferable Group ID is not defined or you have no permission to change group.";
        }   
    }
?>