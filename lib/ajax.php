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


if ($_REQUEST['method'] === 'getChatWindow' && isset($_REQUEST['username'])){
    $user = new User();
    $html = "";

    if ($user->get = $user->getUser('username', $_REQUEST['username'])){
        if ($chats = $user->getChat($user->get->id)){
            foreach ($chats as $e => $chat){
                if ($chat->user_id === $_SESSION['id']) {
                    $user->hasReadMsgs($chat->id);
                    $html .= "<p class='maroon-text'>"."<b>".htmlspecialchars($user->get->username)."</b>"." : ".htmlspecialchars($chat->msg)."</p>";
                }else{
                    $html .= "<p>"."<b>".htmlspecialchars($_SESSION['username'])."</b>"." : ".htmlspecialchars($chat->msg)."</p>";
                } 
            }
            echo $html;
        }else{
            echo "<p class='text-center'>You have no chat history with this person</p>";
        }
    }
}

if ($_REQUEST['method'] === 'getSumAllUnreadMsgs') {
    $user = new User();
    if (($unread = $user->getSumAllUnreadMsgs())){
        echo $unread;
    }else{
        echo "0";
    }
}

if ($_REQUEST['method'] === 'getSumNotifications') {
     $user = new User();
    if ($unread = $user->getSumNotifications()){
        echo $unread;
    }else{
        echo "0";
    }
}
