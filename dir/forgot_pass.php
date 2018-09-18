<?php

if (!isset($_SESSION)){
    session_start();
}

if (isset($_SESSION['id'])) {
    echo("<script> alert('You are still logged in');
        location.href='../dir/browse.php';</script>");
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
        <h1>Matcha</h1>
    </div>

    <form class="well" action="../lib/process_requests.php" method="post">
        <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <input name="email" type="text" placeholder="email" class="form-control">
            </div>
            <div class="col-lg-4"></div>
        </div>
        <br>
        <input name="forgot_password_submit" type="submit" value="Send Password Reset">
        <br>
        <a href="../index.php" class="btn">Login</a>
    </form>
</main>

<?php include_once "footer.php"?>

</body>
</html>