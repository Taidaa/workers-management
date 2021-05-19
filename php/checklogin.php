<?php

    function checkLogin(){
        include("db_connect.php");
        $login = isset($_COOKIE["login"]) ? $_COOKIE["login"] : "";
        $sid = isset($_COOKIE["sessionid"]) ? $_COOKIE["sessionid"] : "";

        $token = $sid.$login;

        $res = $conn->query("SELECT token FROM profile WHERE login='{$login}'");
        $res = $res->fetch_assoc();
        if ($res != null){
            $tokenatserver = $res["token"];
        } else {
            $tokenatserver = 0;
        }
        
        return password_verify($token, $tokenatserver);
    }
    
?>

