<?php
    include_once("db_connect.php");
    header("Content-Type: application/json");

    $usr_login = $_POST["login"];
    $usr_pwd = $_POST["pwd"];

    // Check on db if this fucking login and pwd are here
    $res = $conn->query("SELECT login, password FROM profile WHERE login = '{$usr_login}'");
    $res = $res->fetch_assoc();
    if ($res != null){
        $password = $res["password"];
        if (password_verify($usr_pwd,$password)){
            // Если пароль верный то мы логиним
            $sessionid = isset($_COOKIE["PHPSESSID"]) ? $_COOKIE["PHPSESSID"] : 0;
            setcookie("sessionid", $sessionid, ["path" => "/"]);
            setcookie("login", $usr_login, ["path" => "/"]);
            $token = password_hash($sessionid.$usr_login, PASSWORD_BCRYPT);
            $conn->query("UPDATE profile SET token='{$token}' WHERE login='{$usr_login}'");
            $data = ["success" => true];
        } else {
            $data = ["success" => false, "code" => 0];
        }
    } else {
        $data = ["success" => false, "code" => 0];
    }

    echo json_encode($data);
    $conn->close();
?>