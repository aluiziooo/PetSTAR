<?php
    require("templates/header.php");

    if($userDAO){
        $userDAO->destroyToken();
    }