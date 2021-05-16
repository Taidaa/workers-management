<?php

    include_once("db_connect.php");
    header("Content-Type: application/json");
    $login = $_POST["login"];
    $sid = $_POST["sessionid"];

    $token = $sid.$login;

    $res = $conn->query("SELECT token FROM profile WHERE login='{$login}'");
    $res = $res->fetch_assoc();
    if ($res != null){
        $tokenatserver = $res["token"];
    } else {
        $tokenatserver = 0;
    }
    
    echo json_encode(["success" => password_verify($token, $tokenatserver)]);
    
?>