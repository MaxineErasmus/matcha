<?php

if (!isset($_SESSION)){
    session_start();
}

if (!isset($_SESSION['id'])) {
    echo("<script> alert('Login or Register to Join');
        location.href='../index.php';</script>");
}

require $_SESSION['ROOT'] . "/lib/lib.php";
require $_SESSION['ROOT'] . "/classes/Database.php";
require $_SESSION['ROOT'] . "/classes/User.php";

$user = new User();
if (!$user->get = $user->getUser('username', $_GET['username'])){
    echo("<script> alert('Username not found');
                location.href='../dir/browse.php';</script>");
}

$user->hasPermission($user->get->id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Matcha</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

    <?php require_once "../favicon.html"; ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="../lib/lib.js"></script> 
</head>
<body class="container">
<main class="text-center">
    <div class="page-header">
        <h1>Views</h1>
        <h3>Logged in as <?php echo htmlspecialchars($_SESSION['username']); ?></h3>
    </div>

    <?php include "../dir/menu.php"; ?>

    <div class="well">
        <h2><?php echo htmlspecialchars($user->get->username); ?></h2>

        <?php
        if ($user->get->online == true){
            echo "<p><b>Status:</b> Online</p>";
        }else{
            echo "<p><b>Status:</b> Offline <br>(<b>Last Seen: </b>".$user->get->last_seen.")</p>";
        }
        ?>

        <div class="row">
            <div class="col-lg-4 col-sm-4 col-xs-4"></div>
            <div class="col-lg-4 col-sm-4 col-xs-4">
                <img src="../images/icons/019-party-mask.svg"  class="icon">
                <br>
                <h2><b><?php echo ($user->getSumViews($_SESSION['id']));?></b></h2>
                Views
            </div>
            <div class="col-lg-4 col-sm-4 col-xs-4"></div>
        </div>
        <br>

        <?php getViews($user->get->id); ?>
    </div>
</main>

<?php include_once "../dir/footer.php"; ?>

</body>
</html>