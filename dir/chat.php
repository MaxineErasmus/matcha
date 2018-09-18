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
        <h1>Chat</h1>
        <h3>Logged in as <?php echo htmlspecialchars($_SESSION['username']); ?></h3>
    </div>
    <?php include_once "menu.php"; ?>
    <br>
    <div class="well">
        <?php getChats(); ?>
    </div>

</main>

<?php include_once "footer.php"; ?>

</body>
</html>