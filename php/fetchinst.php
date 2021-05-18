<?php

    include_once("../php/db_connect.php");
    header("Content-Type: application/json");

    $res = $conn->query("
        SELECT name FROM educational_institution
    ");

    echo json_encode($res->fetch_all());

?>