<?php 
    include "db_connect.php";

    $FIO = $_POST["name"];
    $id = $_POST["id"];

    print_r($_POST);

    $conn->query("UPDATE students SET FIO='{$FIO}' WHERE id={$id}");
?>