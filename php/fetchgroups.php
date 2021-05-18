<?php

    include_once("../php/db_connect.php");
    header("Content-Type: application/json");

    $res = $conn->query("
        SELECT mark FROM groups
    ");

    echo json_encode($res->fetch_all());

?>