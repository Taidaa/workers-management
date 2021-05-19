<?php

    require('db_connect.php');
    header('Content-Type: application/json');
    $login = $_POST["login"];
    $userpass = $_POST["password"];
    $FIO = $_POST["FIO"];
    $inst = $_POST["inst"];
    $group = $_POST["group"];
    $userpass = password_hash($userpass, PASSWORD_BCRYPT);
    
    // Проверим занят ли логин
    $res = $conn->query("SELECT COUNT(*) FROM profile WHERE login = '{$login}'");
    if ($res->fetch_row()[0] > 0){
        $data = ["success" => false, "code" => 1];
        echo json_encode($data);
        $conn->close();
        return;
    }

    
    // Если не занят, то регистрируем

    // Получаем код колледжа
    $res = $conn->query("SELECT id FROM educational_institution WHERE name = '{$inst}'");
    if (null !== $instid = $res->fetch_row()){
        $instid = $instid[0];
    } else {
        $instid = 0;
    }
    
    // Получаем код группы
    $res = $conn->query("SELECT id FROM groups WHERE institutionID = {$instid} AND mark = '{$group}'");
    if (null !== $groupid = $res->fetch_row()){
        $groupid = $groupid[0];
    } else {
        $groupid = 0;
    }
    
    // Добавляем в бд новый акк
    $res = $conn->query("INSERT INTO profile(FIO, groupID, roleID, login, password)
                            VALUES ('{$FIO}', '{$groupid}', 0, '{$login}', '{$userpass}')");
    
    $conn->query("INSERT INTO students(FIO, groupID) VALUES ('{$FIO}', {$groupid})");

    $data = ["success" => $res];
    echo json_encode($data);

    if ($conn->error) {
        die("Connection failed: " . $conn->error);
    }
    
    $conn->close();
?>