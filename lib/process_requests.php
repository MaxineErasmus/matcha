<?php

if (!isset($_SESSION)){
    session_start();
}

require_once "../favicon.html";
require $_SESSION['ROOT'] . "/lib/lib.php";
require $_SESSION['ROOT'] . "/classes/Database.php";
require $_SESSION['ROOT'] . "/classes/User.php";

$user = new User();

if (isset($_POST) && !empty($_POST)){
    //------------------------USER------------------------------
    //Register
    if (isset($_POST['register_submit'])){
        try{
            if ($user->reg($_POST)){
                echo "<script>alert('Welcome to Matcha, ".$user->username."');</script>";
                echo("<script>location.href='../dir/profile.php';</script>");
            }else{
                unset($user);
                echo("<script>location.href='../dir/register.php';</script>");
            }
        }catch (PDOException $e){
            echo "<script>alert('Register Error: " . var_dump($e->getMessage()) . "');</script>";
        }
    }
    //Login
    elseif (isset($_POST['login_submit'])){
        try{
            if ($user->login($_POST)){
                echo "<script>alert('Welcome back, ".$user->username."');</script>";
                echo("<script>location.href='../dir/profile.php';</script>");
            }else{
                unset($user);
                echo("<script>location.href='../index.php';</script>");
            }
        }catch (PDOException $e){
            echo "<script>alert('Login Error: " . var_dump($e->getMessage()) . "');</script>";
        }
    }
    //Forgot Password
    elseif (isset($_POST['forgot_password_submit'])){
    	try{
            if ($user->email_token($_POST['email'])){
                echo "<script>alert('Password reset link sent!');</script>";
                echo("<script>location.href='../index.php';</script>");
            }else{
            	echo "<script>alert('Password reset link failed to send');</script>";
                echo("<script>location.href='../index.php';</script>");
            }
        }catch (PDOException $e){
            echo "<script>alert('Forgot Password Error: " . var_dump($e->getMessage()) . "');</script>";
        }
    }


    if (isset($_SESSION['id'])){
        //------------------------PROFILE------------------------------
        //Images
        if (isset($_POST['images_update_submit'])){
            if ($user->profile_updateImages($_POST,$_FILES)){
                echo "<script>alert('Images Updated')</script>";
            }
            echo "<script>location.href='../dir/profile.php';</script>";
        }

        //Delete pics
        elseif (isset($_POST['img1_delete'])){
            if ($user->profile_deleteImg('img1')){
                echo "<script>alert('Image Deleted')</script>";
            }else{
                echo "<script>alert('No Image to Delete')</script>";
            }
            echo "<script>location.href='../dir/profile.php';</script>";
        }elseif (isset($_POST['img2_delete'])){
            if ($user->profile_deleteImg('img2')){
                echo "<script>alert('Image Deleted')</script>";
            }else{
                echo "<script>alert('No Image to Delete')</script>";
            }
            echo "<script>location.href='../dir/profile.php';</script>";
        }elseif (isset($_POST['img3_delete'])){
            if ($user->profile_deleteImg('img3')){
                echo "<script>alert('Image Deleted')</script>";
            }else{
                echo "<script>alert('No Image to Delete')</script>";
            }
            echo "<script>location.href='../dir/profile.php';</script>";
        }elseif (isset($_POST['img4_delete'])){
            if ($user->profile_deleteImg('img4')){
                echo "<script>alert('Image Deleted')</script>";
            }else{
                echo "<script>alert('No Image to Delete')</script>";
            }
            echo "<script>location.href='../dir/profile.php';</script>";
        }elseif (isset($_POST['img5_delete'])){
            if ($user->profile_deleteImg('img5')){
                echo "<script>alert('Image Deleted')</script>";
            }else{
                echo "<script>alert('No Image to Delete')</script>";
            }
            echo "<script>location.href='../dir/profile.php';</script>";
        }

        //Info
        elseif (isset($_POST['info_update_submit'])){
            if ($user->setUserInfo($_SESSION['id'],$_POST)){
                echo "<script>alert('Info Updated')</script>";
            }else{
                echo "<script>alert('There is nothing to update')</script>";
            }
            echo "<script>location.href='../dir/profile.php';</script>";
        }
        //Interests
        elseif (isset($_POST['interests_update_submit'])){
            if (empty($_POST['interests']))
                echo "<script>alert('Interests field is empty')</script>";
            else{
                if ($user->setUserInterests($_SESSION['id'],$_POST['interests'])){
                    echo "<script>alert('Interests Updated')</script>";
                }else{
                    echo "<script>alert('Incorrect Format')</script>";
                }
            }

            echo "<script>location.href='../dir/profile.php';</script>";
        }
        //Biography
        elseif (isset($_POST['biography_update_submit'])){
            if (empty($_POST['biography']))
                echo "<script>alert('Biography field is empty')</script>";
            else{
                if ($user->setUserBiography($_SESSION['id'],$_POST['biography'])){
                    echo "<script>alert('Biography Updated')</script>";
                } 
            }

            echo "<script>location.href='../dir/profile.php';</script>";
        }

        //------------------------SETTINGS------------------------------
        //Password
        elseif (isset($_POST['password_update_submit'])){
            if (isset($_POST['new_password']) && !empty($_POST['new_password'])){
                $user->new_password($_POST['new_password']);
                echo "<script>alert('Password Updated')</script>";   
            }else{
                echo "<script>alert('Password field is empty')</script>";   
            }
            echo "<script>location.href='../dir/profile.php';</script>";
        }

        //------------------------MAIL------------------------------
        //Message
        elseif (isset($_POST['msg_submit'])){
            if (is_numeric($_POST['to_user'])) {
                if ($user->get = $user->getUser('id', $_POST['to_user'])){
                    if (isset($_POST['msg']) && !empty($_POST['msg'])){
                        if ($user->msg($_POST['to_user'], $_POST['msg'])) {
                            echo "<script>location.href='../lib/view_chat.php?username=".htmlspecialchars($user->get->username)."';</script>";
                        } else {
                            echo "<script>alert('Message Failed to Send')</script>";
                        }
                    }
                    echo "<script>location.href='../lib/view_chat.php?username=".htmlspecialchars($user->get->username)."';</script>";
                }
            }
            echo "<script>alert('User not found');
            location.href='../dir/browse.php';</script>";
        }

        //------------------------LOCATION------------------------------
        //location
        elseif(isset($_POST['location_update_submit'])){
            if (is_numeric($_POST['latitude']) && is_numeric($_POST['longitude'])){
                if ($user->profile_updateLocation($_POST['latitude'], $_POST['longitude'])){
                    $_SESSION['latitude'] = $_POST['latitude'];
                    $_SESSION['longitude'] = $_POST['longitude'];
                    echo "<script>alert('Location updated')</script>";
                }else{
                    echo "<script>alert('Failed to update Location')</script>";
                }
            }
            echo "<script>location.href='../dir/profile.php';</script>";
        }
    }
}

elseif (isset($_GET) && !empty($_GET)){
    //------------------------VIEW PROFILE------------------------------
    //Like
    if(isset($_GET['like'])){
        if (is_numeric($_GET['like'])){
            if ($user->get = $user->getUser('id', $_GET['like'])){
                if ($user->like($_SESSION['id'], $_GET['like'])){
                    if ($user->hasLiked($_GET['like'], $_SESSION['id'])){
                        $user->notify($_GET['like'], htmlspecialchars($_SESSION['username'])." liked you back, You can now chat!");
                    }else{
                        $user->notify($_GET['like'], htmlspecialchars($_SESSION['username'])." liked your profile");
                    }
                    echo "<script>location.href='view_profile.php?username=".$user->get->username."';</script>";
                }
            }
        }
        echo "<script>alert('User not found');
        location.href='../dir/browse.php';</script>";
    }
    //Unlike
    elseif(isset($_GET['unlike'])){
        if (is_numeric($_GET['unlike'])){
            if (($user->get = $user->getUser('id', $_GET['unlike']))) {
                if ($user->hasLiked($_SESSION['id'],$_GET['unlike'])){
                    if ($user->unlike($_SESSION['id'], $_GET['unlike'])){
                        $user->notify($_GET['unlike'], htmlspecialchars($_SESSION['username'])." unliked you... the feeling is no longer mutual");
                        echo "<script>location.href='view_profile.php?username=".$user->get->username."';</script>";
                    }
                }
            }
        }echo "<script>alert('User not found');
        location.href='../dir/browse.php';</script>";
    }
    //Report
    elseif(isset($_GET['report'])){
        if (is_numeric($_GET['report'])){
            if ($user->get = $user->getUser('id', $_GET['report'])){
                if ($user->report($_SESSION['id'], $_GET['report'])){
                    echo "<script>alert('User has been reported');</script>";
                    echo "<script>location.href='view_profile.php?username=".$user->get->username."';</script>";
                }
            }
        }
        echo "<script>alert('User not found');
        location.href='../dir/browse.php';</script>";
    }
    //Block
    elseif(isset($_GET['block'])){
        if (is_numeric($_GET['block'])){
            if ($user->get = $user->getUser('id', $_GET['block'])){
                if ($user->block($_SESSION['id'], $_GET['block'])){
                    echo "<script>alert('User has been blocked');</script>";
                    echo "<script>location.href='view_profile.php?username=".$user->get->username."';</script>";
                }
            }
        }
        echo "<script>alert('User not found');
        location.href='../dir/browse.php';</script>";
    }
}

?>