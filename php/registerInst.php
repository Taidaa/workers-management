<?php
    include 'db_connect.php';
    include 'checklogin.php';

    if (checklogin()){
        $login = $_COOKIE["login"];
        $res = $conn->query("SELECT profile.roleID as 'role' FROM profile WHERE profile.login='{$login}'");
        $res = $res->fetch_assoc();
        $roleID = isset($res["role"]) ? $res["role"] : 0;

        if ($roleID >= 100){
            $instName = isset($_POST['instname']) ? $_POST['instname'] : null;
            if (!isset($instName)) return; 
            $conn->query("INSERT INTO educational_institution (name) VALUES ('{$instName}')");
            echo 'Учебное заведение '.$instName.' добавлено в базу.';
        } else {
            echo 'У вас не прав чтобы что-то менять на сервере. Пшел нах.';
        }
    } else {
        echo 'Вы не залогинены.';
    }

    
?>