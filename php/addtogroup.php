<?php 
    include "db_connect.php";

    $FIO = $_POST["name"];
    $groupID = $_POST["groupID"];

    $conn->query("INSERT INTO students(FIO, groupID) VALUES ('{$FIO}', {$groupID})");
?>