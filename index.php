<?php

if (!isset($_SESSION)){
    session_start();
}

if (isset($_SESSION['id'])) {
    echo("<script> alert('You are still logged in');
        location.href='dir/browse.php';</script>");
}

$_SESSION['FILEPATH'] = dirname(__FILE__);
$_SESSION['ROOT'] = realpath(dirname(__FILE__));

require $_SESSION['ROOT'] . "/lib/lib.php";
require $_SESSION['ROOT'] . "/classes/Database.php";
require $_SESSION['ROOT'] . "/classes/User.php";

if (isset($_GET['email']) && isset($_GET['token'])){
    $user = new User();

    if ($user->forgot_pass($_GET['email'], $_GET['token'])){
        echo("<script> alert('Welcome back! Make sure to reset your password under settings');
        location.href='dir/profile.php';</script>");
    }else{
        echo("<script> alert('Incorrect email or token');</script>");
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Matcha</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <?php require_once "favicon-index.html"; ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="lib/lib.js"></script> 
</head>
<body class="container">
    <main class="text-center">
        <div class="page-header">
            <h1>Matcha</h1>
        </div>

        <form class="well" action="lib/process_requests.php" method="post">
            <div class="row">
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                    <input name="username" type="text" class="form-control" placeholder="Username" autocomplete="username">
                </div>
                <div class="col-lg-4"></div>
            </div>
            <div class="row">
                <div class="col-lg-4"></div>
                <div class="col-lg-4">
                    <input name="pass" type="password" class="form-control" placeholder="Password" autocomplete="password">
                </div>
                <div class="col-lg-4"></div>
            </div>
            <br>
            <input name="login_submit" type="submit" value="Log In" class="btn-default">
            <br><br>
            <div class="row">
                <div class="col-lg-3 col-sm-3"></div>
                <div class="col-lg-3 col-sm-3 col-xs-6">
                    <a href="dir/forgot_pass.php">Forgot Password</a>
                </div>
                <div class="col-lg-3 col-sm-3 col-xs-6">
                    <a href="dir/register.php">Register</a>
                </div>
                <div class="col-lg-3 col-sm-3"></div>
            </div>
        </form>
    </main>
    <?php include_once "dir/footer.php"?>
</body>
</html>