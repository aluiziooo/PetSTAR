<?php

    $dbname = "petstar";
    $host = "localhost";
    $user = "root";
    $password = "";

    $conn = new PDO("mysql:localhost=$host;dbname=$dbname", $user, $password);

    //Habilitar erros PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


