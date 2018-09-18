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
if ($user->hasPermission($user->get->id)){
    if (!$user->hasViewed($user->get->id) && $user->get->id !== $_SESSION['id']){
        $user->view($user->get->id);
        $user->notify($user->get->id, htmlspecialchars($_SESSION['username'])." viewed your profile");
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
    <link rel="stylesheet" href="../css/style.css">

    <?php require_once "../favicon.html"; ?>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="../lib/lib.js"></script> 
</head>
<body class="container">
<main class="text-center">
    <div class="page-header">
        <h1>Matcha</h1>
        <h3>Logged in as <?php echo htmlspecialchars($_SESSION['username']); ?></h3>
    </div>

    <?php include "../dir/menu.php"; ?>

    <?php getImages($user->get->id, $user->get->profile_pic);?>

    <div class="well">
        <h2><?php echo $user->get->username; ?></h2>

        <?php
        if ($user->get->online == true){
            echo "<p><b>Status:</b> Online</p>";
        }else{
            echo "<p><b>Status:</b> Offline <br>(<b>Last Seen: </b>".$user->get->last_seen.")</p>";
        }
        ?>

        <div class="row">
            <div class="col-lg-3"></div>
            <div class="panel col-lg-2 col-sm-4 col-xs-4">
                <a href="../lib/view_fame.php?username=<?php echo htmlspecialchars($user->get->username); ?>">
                <img src="../images/icons/017-sparkles.svg" class="icon">
                <br>
                <h2><b><?php echo ($user->getSumFame($user->get->id));?></b></h2>
                Fame
                </a>
            </div>
            <div class="panel col-lg-2 col-sm-4 col-xs-4">
                <a href="../lib/view_likes.php?username=<?php echo htmlspecialchars($user->get->username); ?>">
                <img src="../images/icons/016-rose.svg"  class="icon">
                <br>
                <h2><b><?php echo ($user->getSumLikes($user->get->id));?></b></h2>
                Likes
                </a>
            </div>
            <div class="panel col-lg-2 col-sm-4 col-xs-4">
                <a href="../lib/view_views.php?username=<?php echo htmlspecialchars($user->get->username); ?>">
                <img src="../images/icons/019-party-mask.svg"  class="icon">
                <br>
                <h2><b><?php echo ($user->getSumViews($user->get->id));?></b></h2>
                Views
                </a>
            </div>
            <div class="col-lg-3"></div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-3 col-sm-2"></div>
            <p class="panel col-lg-6 col-sm-8 col-xs-12 maroon">Info</p>
            <div class="col-lg-3 col-sm-2"></div>
        </div>
        <?php getProfile($user);?>
        <br>
        <?php getChatButton($user->get->id);?>
        <?php getLikeButton($user->get->id); ?>
        <?php getReportButton($user->get->id); ?>
        <?php getBlockButton($user->get->id); ?>


        <br>
    </div>
</main>

<?php include_once "../dir/footer.php"; ?>

</body>
</html>