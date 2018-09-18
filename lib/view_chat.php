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
if ($user->get = $user->getUser('username', $_GET['username'])){
    if (!$user->isMutual($user->get->id)){
        echo("<script> alert('The feeling is not mutual');
        location.href='../dir/browse.php';</script>");
    }else{
        $_GET['uid'] = $user->get->id;
    }
}else{
    echo("<script> alert('Invalid username');
        location.href='../dir/browse.php';</script>");
}

if ($_GET['username'] == $_SESSION['username']){
    echo("<script> alert('Try chatting to someone other than yourself');
        location.href='../dir/browse.php';</script>");
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
        <h1>Chat</h1>
        <h3>Logged in as <?php echo htmlspecialchars($_SESSION['username']);?></h3>
    </div>
    <?php include "../dir/menu.php"; ?>
    <br>
    <div class="well">
        <h2><?php echo htmlspecialchars($user->get->username); ?></h2>

        <?php
        if ($user->get->online == true){
            echo "<p><b>Status:</b> Online</p>";
        }else{
            echo "<p><b>Status:</b> Offline <br>(<b>Last Seen: </b>".$user->get->last_seen.")</p>";
        }
        ?>

        <input id="username" type="text" value="<?php echo htmlspecialchars($user->get->username); ?>" style="display: none;">
        <div id="chat-window" class="text-left"><div class="text-center">Loading ...</div></div>
        <br>

        <form method="post" action="../lib/process_requests.php">
            <div class="row">
                <input type="text" name="to_user" title="to_user" style="display: none;" value="<?php echo $user->get->id; ?>">
            </div>
            <div class="row">
                <div class="col-lg-1"></div>
                <input type="text" name="msg" placeholder="Type a message..." class="col-lg-8 col-sm-10 col-xs-12">
                <input type="submit" name="msg_submit" value="Send" class="btn-default col-lg-2 col-sm-2 col-xs-12">
                <div class="col-lg-1"></div>
            </div>
        </form>


    </div>
</main>

<?php include_once "../dir/footer.php"?>

<script> 
    getChatWindowAJAX();
</script>

</body>
</html>