<?php
    include_once("../php/checkLogin.php");
    
    if (checkLogin()){
        include("../php/db_connect.php");
        $login = isset($_COOKIE["login"]) ? $_COOKIE["login"] : "";
        $conn->query("UPDATE profile SET token='' WHERE token='{$login}'");

        if (isset($_COOKIE['login'])) {
            unset($_COOKIE['login']);
            setcookie('login', '', time() - 3600, '/');
        }

        if (isset($_COOKIE['sessionid'])) {
            unset($_COOKIE['sessionid']);
            setcookie('sessionid', '', time() - 3600, '/'); 
        }
    }
    

?>