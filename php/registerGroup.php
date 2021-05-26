<?php
    include 'db_connect.php';
    include 'checklogin.php';

    if (checklogin()){
        $login = $_COOKIE["login"];
        $res = $conn->query("SELECT profile.roleID as 'role' FROM profile WHERE profile.login='{$login}'");
        $res = $res->fetch_assoc();
        $roleID = isset($res["role"]) ? $res["role"] : 0;

        if ($roleID >= 100){
            $instID = isset($_POST['instID']) ? $_POST['instID'] : null;
            $group = isset($_POST['group']) ? $_POST['group'] : null;

            if (!isset($instID) && !isset($group)) return; 

            $conn->query("INSERT INTO groups (mark, institutionID) VALUES ('{$group}', {$instID})");
            echo 'Группа '.$group.' добавлена в базу.';
        } else {
            echo 'У вас не прав чтобы что-то менять на сервере. Пшел нах.';
        }
    } else {
        echo 'Вы не залогинены.';
    }

    
?>