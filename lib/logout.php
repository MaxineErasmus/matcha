<?php

if (!isset($_SESSION)){
    session_start();
}

require $_SESSION['ROOT'] . "/lib/lib.php";
require $_SESSION['ROOT'] . "/classes/Database.php";
require $_SESSION['ROOT'] . "/classes/User.php";

if (isset($_SESSION['id'])){
    $user = new User();
    $user->id = $_SESSION['id'];
    $user->offline();

    session_destroy();
    echo("<script> alert('Logged Out!'); </script>");
}

echo("<script> location.href='../index.php'; </script>");

?>