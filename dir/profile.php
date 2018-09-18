<?php

if (!isset($_SESSION)){
    session_start();
}

if (!isset($_SESSION['id'])) {
    echo("<script> alert('Login or Register to Join');
        location.href='../index.php';</script>");
}

if (!isset($_SESSION['profile_pic'])){
    $_SESSION['profile_pic'] = "#";
}

require $_SESSION['ROOT'] . "/lib/lib.php";
require $_SESSION['ROOT'] . "/classes/Database.php";
require $_SESSION['ROOT'] . "/classes/User.php";

$user = new User();

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
        <h1>Profile</h1>
        <h3>Logged in as <?php echo htmlspecialchars($_SESSION['username']); ?></h3>
    </div>
    <?php include_once "menu.php"; ?>
    <br>
    <div id="accordion">
        <!--STATS-->
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="profile-stat-block stat-block panel col-lg-2 col-sm-4 col-xs-4">
                <a href="../lib/view_fame.php?username=<?php echo htmlspecialchars($_SESSION['username']); ?>">
                <img src="../images/icons/017-sparkles.svg" class="icon">
                <br>
                <h2><b><?php echo ($user->getSumFame($_SESSION['id']));?></b></h2>
                Fame
                </a>
            </div>
            <div class="profile-stat-block stat-block panel col-lg-2 col-sm-4 col-xs-4">
                <a href="../lib/view_likes.php?username=<?php echo htmlspecialchars($_SESSION['username']); ?>">
                <img src="../images/icons/016-rose.svg"  class="icon">
                <br>
                <h2><b><?php echo ($user->getSumLikes($_SESSION['id']));?></b></h2>
                Likes
                </a>
            </div>
            <div class="profile-stat-block stat-block panel col-lg-2 col-sm-4 col-xs-4">
                <a href="../lib/view_views.php?username=<?php echo htmlspecialchars($_SESSION['username']); ?>">
                <img src="../images/icons/019-party-mask.svg"  class="icon">
                <br>
                <h2><b><?php echo ($user->getSumViews($_SESSION['id']));?></b></h2>
                Views
                </a>
            </div>
            <div class="col-lg-3"></div>
        </div>
        <br>
        <!--IMAGES-->
        <div class="panel panel-default">
            <button type="button" class="btn profile_accordion_btn" data-parent="#accordion"  data-toggle="collapse" data-target="#collapse1">Images</button>
            <div id="collapse1" class="panel-collapse collapse">
                <form action="../lib/process_requests.php" enctype="multipart/form-data" method="post" class="panel-body">
                    <div class="row well">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-8">
                            <img src="<?php echo getProfilePic($_SESSION['id'], $_SESSION['profile_pic']); ?>" 
                            class="img_md img-responsive center-block" >
                            <br>
                            <label>
                                <img src="../images/icons/007-star.svg" class="icon">
                                <br>
                                Profile Pic
                            </label>
                        </div>
                        <div class="col-lg-2"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-1"></div>

                        <div class="col-lg-2 col-xs-12 ">
                            <input type="radio" name="img" value="img1" <?php getFormIsProfilePic('1.png');?>>
                            <img src="<?php echo getImage(1, $_SESSION['id']); ?>" class="center-block img_sm img-responsive">
                            <input type="file" name="img1" class="center-block" size="40">
                            <input type="submit" name="img1_delete" value="Delete" size="40">
                        </div>
                        <div class="col-lg-2 col-xs-12 ">
                            <input type="radio" name="img" value="img2"  <?php getFormIsProfilePic('2.png');?>>
                            <img src="<?php echo getImage(2, $_SESSION['id']); ?>" class="center-block img_sm img-responsive">
                            <input type="file" name="img2" class="center-block" size="40">
                            <input type="submit" name="img2_delete" value="Delete" size="40">
                        </div>
                        <div class="col-lg-2 col-xs-12 ">
                            <input type="radio" name="img" value="img3"  <?php getFormIsProfilePic('3.png');?>>
                            <img src="<?php echo getImage(3, $_SESSION['id']); ?>" class="center-block img_sm img-responsive">
                            <input type="file" name="img3" class="center-block" size="40">
                            <input type="submit" name="img3_delete" value="Delete" size="40">
                            <br>
                        </div>
                        <div class="col-lg-2 col-xs-12 ">
                            <input type="radio" name="img" value="img4"  <?php getFormIsProfilePic('4.png');?>>
                            <img src="<?php echo getImage(4, $_SESSION['id']); ?>" class="center-block img_sm img-responsive">
                            <input type="file" name="img4" class="center-block" size="40">
                            <input type="submit" name="img4_delete" value="Delete" size="40">
                        </div>
                        <div class="col-lg-2 col-xs-12 ">
                            <input type="radio" name="img" value="img5" <?php getFormIsProfilePic('5.png');?>>
                            <img src="<?php echo getImage(5, $_SESSION['id']); ?>" class="center-block img_sm img-responsive">
                            <input type="file" name="img5" class="center-block" size="40">
                            <input type="submit" name="img5_delete" value="Delete" size="40">
                        </div>
                        <div class="col-lg-1"></div>
                    </div>

                    <hr>
                    <br>
                    <input name="images_update_submit" type="submit" value="Update">
                </form>
            </div>
        </div>
        <!--INFO-->
        <div class="panel panel-default">
            <button type="button" class="btn profile_accordion_btn" data-parent="#accordion"  data-toggle="collapse" data-target="#collapse2">Info</button>
            <div id="collapse2" class="panel-collapse collapse">
                <form action="../lib/process_requests.php" method="post" class="panel-body">
                    <div class="row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <input name="username" type="text" class="form-control" autocomplete="username"
                                   placeholder="Username: <?php echo htmlspecialchars($_SESSION['username']);?>">
                        </div>
                        <div class="col-lg-4"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <input name="first_name" type="text" class="form-control" autocomplete="first_name"
                                   placeholder="First Name: <?php echo htmlspecialchars($_SESSION['first_name']);?>">
                        </div>
                        <div class="col-lg-4"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <input name="last_name" type="text" class="form-control" autocomplete="last_name"
                                   placeholder="Last Name: <?php echo htmlspecialchars($_SESSION['last_name']);?>">
                        </div>
                        <div class="col-lg-4"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <input name="email" type="email" class="form-control" autocomplete="email"
                                   placeholder="Email: <?php echo htmlspecialchars($_SESSION['email']);?>">
                        </div>
                        <div class="col-lg-4"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <input name="age" type="number" class="form-control" autocomplete="age"
                                   placeholder="Age: <?php getFormAge();?>">
                        </div>
                        <div class="col-lg-4"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <?php getFormGender();?>
                        </div>
                        <div class="col-lg-4"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <?php getFormPronouns();?>
                        </div>
                        <div class="col-lg-4"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <br>
                            Attraction:
                            <br><br>
                        </div>
                        <div class="col-lg-4"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-10 row">
                            <?php getFormAttraction();?>
                        </div>
                        <div class="col-lg-1"></div>
                    </div>
                    <br>
                    <hr>
                    <br>
                    <input name="info_update_submit" type="submit" value="Update">
                </form>
            </div>
        </div>
        <!--INTERESTS-->
        <div class="panel panel-default">
            <button type="button" class="btn profile_accordion_btn" data-parent="#accordion"  data-toggle="collapse" data-target="#collapse3">Interests</button>
            <div id="collapse3" class="panel-collapse collapse">
                <form action="../lib/process_requests.php" method="post" class="panel-body">
                    <div class="row">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-8">
                            <textarea name="interests" placeholder="<?php getFormInterests();?>" rows="10"  maxlength="1600" class="form-control"></textarea>
                        </div>
                        <div class="col-lg-2"></div>
                    </div>

                    <hr>
                    <br>
                    <input name="interests_update_submit" type="submit" value="Update">
                    <br>
                </form>
            </div>
        </div>
        <!--BIOGRAPHY-->
        <div class="panel panel-default">
            <button type="button" class="btn profile_accordion_btn" data-parent="#accordion"  data-toggle="collapse" data-target="#collapse4">Biography</button>
            <div id="collapse4" class="panel-collapse collapse">
                <form action="../lib/process_requests.php" method="post" class="panel-body">
                    <div class="row">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-8">
                            <textarea name="biography" placeholder="<?php getFormBiography();?>" rows="20" maxlength="1600" class="form-control"></textarea>
                        </div>
                        <div class="col-lg-2"></div>
                    </div>

                    <hr>
                    <br>
                    <input name="biography_update_submit" type="submit" value="Update">
                    <br>
                </form>
            </div>
        </div>
        <!--LOCATION-->
        <div class="panel panel-default">
            <button type="button" class="btn profile_accordion_btn" data-parent="#accordion"  data-toggle="collapse" data-target="#collapse5">Location</button>
            <div id="collapse5" class="panel-collapse collapse">
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8">
                        <br>
                        <button onclick="getLocation()" class="btn-default">Get Current Location</button>
                        <br><br>
                    </div>
                    <div class="col-lg-2"></div>
                </div>
                <div class="row">
                    <div class="col-lg-2 col-sm-2"></div>
                    <div class="col-lg-8 col-sm-8 col-xs-12">
                        <p><div id="latlonlabel"></div></p>
                    </div>
                    <div class="col-lg-2 col-sm-2"></div>
                </div>     
                <form action="../lib/process_requests.php" method="post" class="panel-body">
                    <div class="row">
                        <div class="col-lg-2 col-sm-2"></div>
                        <div class="col-lg-4 col-sm-4 col-xs-6">
                            <input id="latitude" name="latitude" type="location" class="form-control" value="<?php getFormLatitude();?>">
                        </div>
                        <div class="col-lg-4 col-sm-4 col-xs-6">
                            <input id="longitude" name="longitude" type="location" class="form-control" value="<?php getFormLongitude();?>">
                        </div>
                        <div class="col-lg-2 col-sm-2"></div>
                    </div>
                    <hr>
                    <br>
                    <input name="location_update_submit" type="submit" value="Update">
                    <br>
                </form>
            </div>
        </div>
        <!--SETTINGS-->
        <div class="panel panel-default">
            <button type="button" class="btn profile_accordion_btn" data-parent="#accordion"  data-toggle="collapse" data-target="#collapse6">Settings</button>
            <div id="collapse6" class="panel-collapse collapse">
                <form action="../lib/process_requests.php" method="post" class="panel-body">
                    <div class="row">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-8">

                            <label>Change Password</label>
                            <br>
                            <input name="new_password" type="password" autocomplete="password"
                                   pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                   title="Min length: 8, must contain numbers (0-9), uppercase letters (A-Z) and lowercase letters (a-z)"
                                   class="form-control">

                        </div>
                        <div class="col-lg-2"></div>
                    </div>
                           
                <hr>
                <br>
                <input name="password_update_submit" type="submit" value="Update" >
                <br><br>
                </form> 
            </div>
        </div>
    </div>
</main>

<?php include_once "footer.php"; ?>

</body>
</html>