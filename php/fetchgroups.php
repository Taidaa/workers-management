<?php

    include_once("../php/db_connect.php");
    header("Content-Type: application/json");

    $instID = isset($_POST["instID"]) ? $_POST["instID"] : 0;
    $inst = isset($_POST["inst"]) ? $_POST["inst"] : "";
    $res = $conn->query("
    SELECT mark, id FROM groups WHERE institutionID=(SELECT id from educational_institution WHERE name ='{$inst}') or institutionID={$instID}
    ");

    echo json_encode($res->fetch_all());

?>