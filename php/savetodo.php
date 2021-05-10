<?php

    $filename = '../json/todo.json';
    $data = file_get_contents('php://input');

    file_put_contents($filename, $data);
?>