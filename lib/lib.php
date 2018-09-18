<?php

if (!isset($_SESSION)){
    session_start();
}

define("SITE_NAME", "matcha");
define("URL", $_SERVER['HTTP_HOST']."/".SITE_NAME."/");

define("IMG_FILEPATH", $_SESSION['ROOT'] . "/images/");
define("IMG_URLPATH", "../images/");

/* INFO - basics */
$_SESSION['info_list'] = array("username", "first_name", "last_name", "email", "age", "gender", "pronouns", "attraction");

/* INFO - attraction */
$_SESSION['gender_list'] = array("agender person", "cisgender man", "cisgender woman", "transgender man", "transgender woman", "genderfluid person",
    "genderqueer person", "nonbinary person");

$_SESSION['pronouns_list'] = array("they, them and their", "he, him and his", "she, her and hers");

$_SESSION['attraction_list'] = array("agender people", "cisgender men", "cisgender women", "transgender men",
    "transgender women", "genderfluid people", "genderqueer people", "nonbinary people");


//==================================PROFILE========================================>

function getFormAge(){
    if (isset($_SESSION['age']))
        echo htmlspecialchars($_SESSION['age']);
}

function getFormGender(){
    try{
        if (isset($_SESSION['gender'])){
            echo "<select name=\"gender\" class=\"form-control\"'>
            <option value='".htmlspecialchars($_SESSION['gender'])."'>"."Gender: ".htmlspecialchars($_SESSION['gender'])."</option>";
        }else{
            echo "<select name=\"gender\" class=\"form-control\"'>
            <option value=''>Gender: </option>";
        }

        foreach ($_SESSION['gender_list'] as $e){
            echo "<option value='".htmlspecialchars($e)."'>".ucwords(htmlspecialchars($e))."</option>";
        }
        
        echo "</select>";
    }catch (PDOException $e){
        echo "<script>alert('lib getFormGender() Error');</script>";
        error_log($e);
        return NULL;
    }
}

function getFormPronouns(){
    try{
        if (isset($_SESSION['pronouns'])){
            echo "<select name=\"pronouns\" class=\"form-control\">
            <option value='".htmlspecialchars($_SESSION['pronouns'])."'>" . "<b>Pronouns:</b> " . htmlspecialchars($_SESSION['pronouns']) . "</option>";
        }else{
            echo "<select name=\"pronouns\" class=\"form-control\">
            <option value=''><b>Pronouns: </b></option>";
        }

        foreach ($_SESSION['pronouns_list'] as $e){
            if ($_SESSION['pronouns_list'] !== $e) {
                echo '<option value="' . htmlspecialchars($e) . '">' .htmlspecialchars($e). '</option>';
            }
        }

        echo "</select>";
    }catch (PDOException $e){
        echo "<script>alert('lib getFormPronouns() Error');</script>";
        error_log($e);
        return NULL;
    }
}

function getFormAttraction(){
    try{
        if (isset($_SESSION['attraction'])){
            $attraction = explode(', ', $_SESSION['attraction']);
            foreach ($_SESSION['attraction_list'] as $e){
                if (in_array($e , $attraction)){
                    $isChecked = "checked";
                }else{
                    $isChecked = "";
                }
                echo "<div class='col-lg-3 col-md-3 col-sm-3 text-center'>
                    <label class='css-label'>".ucwords(htmlspecialchars($e))."</label>
                    <br>
                    <input name='attraction[]' type='checkbox' ".$isChecked." value='" . htmlspecialchars($e) . "' />
                </div>"; 
            }
        }else{
            foreach ($_SESSION['attraction_list'] as $e){
                echo "<div class='col-lg-3 col-md-3 col-sm-3 text-center'>
                    <label class='css-label'>".ucwords(htmlspecialchars($e))."</label>
                    <br>
                    <input name='attraction[]' type='checkbox' checked value='" . htmlspecialchars($e) . "' />
                </div>";
            }
        }
    }catch (PDOException $e){
        echo "<script>alert('lib getFormAttraction() Error');</script>";
        error_log($e);
        return NULL;
    }
}

function getFormInterests() {
    try{
        if (empty($_SESSION['interests']) || strlen($_SESSION['interests'][0]) === 0){
            echo "e.g: #music #watching-the-sunset #TheChroniclesofNarnia";
        }else{
            echo htmlspecialchars($_SESSION['interests']);
        }
    }catch (PDOException $e){
        echo "<script>alert('lib getFormInterests() Error');</script>";
        error_log($e);
        return NULL;
    }
}

function getFormBiography(){
    try{
        if (empty($_SESSION['biography']) || strlen($_SESSION['biography']) === 0){
            echo "Tell us more about yourself...";
        }else{
            echo htmlspecialchars($_SESSION['biography']);
        }
    }catch (PDOException $e){
        echo "<script>alert('lib getFormBiography() Error');</script>";
        error_log($e);
        return NULL;
    }
}

function getFormIsProfilePic($img){
    try{
        if ($img == $_SESSION['profile_pic']){
            echo "checked";
        }else{
            echo "";
        }
    }catch (PDOException $e){
        echo "<script>alert('lib getFormIsProfilePic() Error');</script>";
        error_log($e);
        return NULL;
    }
}

function getFormLatitude(){
    if (isset($_SESSION)){
        if (!empty($_SESSION['latitude'])){
            echo htmlspecialchars($_SESSION['latitude']);
        }else{
            echo "";
        }
    }else{
        echo "";
    }
}

function getFormLongitude(){
    if (isset($_SESSION)){
        if (!empty($_SESSION['longitude'])){
            echo htmlspecialchars($_SESSION['longitude']);
        }else{
            echo "";
        }
    }else{
        echo "";
    }
}

//==================================IMAGES========================================>

function getProfilePic($uid, $profile_pic){
    if (file_exists("../images/".$uid)) {
        if (file_exists("../images/" . $uid . "/" . htmlspecialchars($profile_pic))) {
            return "../images/" . $uid . "/" . htmlspecialchars($profile_pic);
        }
    }
    return "#";
}

function getImage($img = 0, $uid){
    if (file_exists("../images/".htmlspecialchars($uid))) {
        if (file_exists("../images/" . htmlspecialchars($uid) . "/" . $img . ".png")) {
            return "../images/" . htmlspecialchars($uid) . "/" . $img . ".png";
        }
    }
    return "#";
}

function getImages($uid, $profile_pic){
    if (is_numeric($uid)){
        if (file_exists("../images/".$uid)){
            if (file_exists("../images/".$uid."/1.png") || file_exists("../images/".$uid."/2.png") || file_exists("../images/".$uid."/3.png") ||
                file_exists("../images/".$uid."/4.png") || file_exists("../images/".$uid."/5.png")){

                //carousel start
                echo "<div id='myCarousel' class='carousel slide' data-ride='carousel'>";

                //carousel indicators start
                echo "<ol class='carousel-indicators'>";

                //carousel list items
                $numOfImgs = 0;
                for ($y = 1; $y <= 5; $y++) { 
                    if (file_exists("../images/".$uid."/".$y.".png")){
                        $numOfImgs++;
                    }
                }

                $i = 0;
                $img = 1;
                while ($i < $numOfImgs && $img <= 5){
                    if (!file_exists("../images/".$uid."/".$profile_pic)){
                        $profile_pic = '#';
                    }
                    if (file_exists("../images/".$uid."/".$img.".png")){
                        if ($profile_pic === '#'){
                            $profile_pic = $img.".png";
                            echo "<li data-target='#myCarousel' data-slide-to='".$i."' class='active'></li>";
                        }elseif ($profile_pic === ($img.".png")){
                            echo "<li data-target='#myCarousel' data-slide-to='".$i."' class='active'></li>";
                        }else{
                            echo "<li data-target='#myCarousel' data-slide-to='".$i."' ></li>";
                        }
                        $i++;
                    }
                    $img++;
                }

                //carousel indicators end
                echo "</ol>";

                //carousel inner start
                echo "<div class='carousel-inner'>";

                //carousel inner img items
                for ($x = 1; $x <= 5; $x++){
                    if (file_exists("../images/".$uid."/".$x.".png")){
                        if ($profile_pic == '#'){
                            echo "<div class='item active'>";
                        }elseif ($profile_pic == ($x.".png")){
                            echo "<div class='item active'>";
                        }else{
                            echo "<div class='item '>";
                        }
                        echo "<img src='../images/".$uid."/".$x.".png' style='height: 30em'>";
                        echo "</div>";
                    }
                }

                //carousel inner end
                echo "</div>";

                //chevrons
                if ($numOfImgs > 1){
                    echo "<a class='left carousel-control' href='#myCarousel' data-slide='prev'>
                        <span class='glyphicon glyphicon-chevron-left'></span>
                        <span class='sr-only'>Previous</span>
                        </a>
                        <a class='right carousel-control' href='#myCarousel' data-slide='next'>
                            <span class='glyphicon glyphicon-chevron-right'></span>
                            <span class='sr-only'>Next</span>
                        </a>";
                }

                //carousel end
                echo "</div>";
            }
        }
    }
}

//==================================VIEW PROFILE========================================>


function getProfile($user){
    foreach ($user->profile_data as $e) {
        if (isset($user->get->$e) && $e !== "last_seen" && $e !== "profile_pic" && $e !== "email"
            && $e !== "username" && $e !== "attraction" && $e !== "interests" && $e !== "biography" && $e !== 'id' && $e !== 'latitude' && $e !== 'longitude') {

            echo "<div class=\"row\">
            <div class=\"col-lg-3 col-sm-2\"></div>
            <p class=\"panel col-lg-2 col-sm-3 col-xs-12 light-blue text-left\">" . ucwords(str_replace('_', ' ', $e)) . ":" . "</p>
            <p class=\"panel col-lg-4 col-sm-5 col-xs-12 text-left\">" . htmlspecialchars($user->get->$e) . "</p>
            <div class=\"col-lg-3 col-sm-2\"></div>
        </div>";
        }
        if (!isset($user->get->attraction) || empty($user->get->attraction[0])){
            $user->get->attraction = implode(', ', $_SESSION['attraction_list']);
        }
        if (isset($user->get->$e) && ($e == "attraction" || $e == "interests" || $e == "biography")){
            echo "<div class=\"row\">
            <div class=\"col-lg-3 col-sm-2\"></div>
            <p class=\"panel col-lg-6 col-sm-8 col-xs-12 maroon\">" . ucwords(str_replace('_', ' ', $e)) . ":" . "</p>
            <div class=\"col-lg-3 col-sm-2\"></div>
        </div>";

            echo "<div class=\"row\">
            <div class=\"col-lg-3 col-sm-2\"></div>
            <p class=\"panel col-lg-6 col-sm-8 col-xs-12 text-left\">" . htmlspecialchars($user->get->$e) . "</p>
            <div class=\"col-lg-3 col-sm-2\"></div>
        </div>";
        }
    }
}


function getLikeButton($uid){
    $db = new Database();
    if (is_numeric($uid)){
        if ($db->hasPic($uid)){
            if (!$db->hasLiked($_SESSION['id'], $uid) && ($uid !== $_SESSION['id'])){
                echo "<br>
                <div class=\"row\">
                    <div class=\"col-lg-4 col-sm-2\"></div>
                        <a href=\"process_requests.php?like=".$uid."\">
                            <button class=\"btn btn-info blue col-lg-4 col-sm-8 col-xs-12\">Like</button>
                        </a>
                    <div class=\"col-lg-4 col-sm-2\"></div>
                </div>";
            }else if ($uid !== $_SESSION['id']){
                echo "<br>
                <div class=\"row\">
                    <div class=\"col-lg-4 col-sm-2\"></div>
                        <a href=\"process_requests.php?unlike=".$uid."\">
                            <button class=\"btn btn-info blue col-lg-4 col-sm-8 col-xs-12\">Unlike</button>
                        </a>
                    <div class=\"col-lg-4 col-sm-2\"></div>
                </div>";
            }
        }
    }
}

function getReportButton($uid){
    $db = new Database();
    if (is_numeric($uid)){
        if (!$db->hasReported($_SESSION['id'], $uid) && ($uid !== $_SESSION['id'])){
            echo "<br>
            <div class=\"row\">
                <div class=\"col-lg-4 col-sm-2\"></div>
                    <a href=\"process_requests.php?report=".$uid."\">
                        <button class=\"btn btn-info blue col-lg-4 col-sm-8 col-xs-12\">Report</button>
                    </a>
                <div class=\"col-lg-4 col-sm-2\"></div>
            </div>";
        }
    }
}

function getBlockButton($uid){
    $db = new Database();
    if (is_numeric($uid)){
       if (!$db->hasBlocked($_SESSION['id'], $uid) && ($uid !== $_SESSION['id'])){
            echo "<br>
            <div class=\"row\">
                <div class=\"col-lg-4 col-sm-2\"></div>
                    <a href=\"process_requests.php?block=".$uid."\">
                        <button class=\"btn btn-info blue col-lg-4 col-sm-8 col-xs-12\">Block</button>
                    </a>
                <div class=\"col-lg-4 col-sm-2\"></div>
            </div>";
        } 
    }
}

function getChatButton($uid){
    $db = new Database();
    if (is_numeric($uid)){
        $user = $db->getUser('id', $uid);
        if ($db->hasLiked($_SESSION['id'], $uid) && $db->hasLiked($uid, $_SESSION['id']) && ($uid !== $_SESSION['id'])){
            echo "<br>
            <div class=\"row\">
                <div class=\"col-lg-4 col-sm-2\"></div>
                    <a href=\"view_chat.php?username=".htmlspecialchars($user->username)."\">
                        <button class=\"btn btn-info blue col-lg-4 col-sm-8 col-xs-12\">Chat</button>
                    </a>
                <div class=\"col-lg-4 col-sm-2\"></div>
            </div>";
        }
    }
}

//==================================CHAT========================================>

function getChatWindow($uid){
    $db = new Database();

    if (is_numeric($uid)){
        if ($chats = $db->getChat($uid)){

            foreach ($chats as $e => $chat){
                $db->get = $db->getUser('id', $chat->from_id);
                echo "<p class='text-left'>"."<b>".htmlspecialchars($db->get->username)."</b>"." : ".htmlspecialchars($chat->msg)."</p>";

                if ($chat->user_id === $_SESSION['id']) {
                    $db->hasReadMsgs($chat->id);
                }
            }
        }else{
            echo "You have no chat history with this person";
        }
    }
}

function getChats(){
    $db = new Database();
    if ($users = $db->getChats()){
        foreach ($users as $e => $uid){
            $db->get = $db->getUser('id', $uid);
            echo "<div class='row'>";
            echo "<a href='../lib/view_chat.php?username=".htmlspecialchars($db->get->username)."'>
                <button class='btn-default col-lg-12 col-sm-12 col-xs-12'>".
                "<b>".htmlspecialchars($db->get->username)."</b>".getSumUnreadMsgs($uid).
                "</button>
                </a><br>";
            echo "</div>";
        }
    }else{
        echo "You have no current chats open";
    }
}

function getSumUnreadMsgs($uid){
    $db = new Database();
    if (is_numeric($uid)){
        if ($unread = $db->getSumUnreadMsgs($uid)){
            return " - ".$unread." new";
        }
    }
    return NULL;
}

function getSumAllUnreadMsgs(){
    $db = new Database();
    if (($unread = $db->getSumAllUnreadMsgs())){
        echo "<span class='badge'>".$unread."</span>";
    }
}

//==================================NOTIFICATIONS========================================>

function getNotifications(){
    $user = new User();
    if ($notifications = $user->getNotifications()){
        foreach ($notifications as $e){
            $user->get = $user->getUser('id', $e->from_id);

            echo "<div class='row'>";
            echo "<a href='../lib/view_profile.php?username=".htmlspecialchars($user->get->username)."'>
            <button class='btn-default col-lg-12 col-sm-12 col-xs-12'>".htmlspecialchars($e->msg)."</button>
            </a><br>";
            echo "</div>";
        }
    }else{
        echo "You have no new notifications";
    }
}

function getSumNotifications(){
    $db = new Database();
    if ($unread = $db->getSumNotifications()){
        echo "<span class='badge'>".$unread."</span>";
    }
}

//==================================BROWSE========================================>

function search($post){
    $db = new Database();
    if ($users = $db->getUsers()){
        foreach ($users as $user){
            if (!$db->hasBlocked($user->id) && !$db->isBlockedBy($user->id) && $db->hasGenderMatch($user->gender) && $db->hasAttractionMatch($user->attraction)){
                if (!empty($post)){
                    $match = true;

                    if (!empty($_POST['search_interests'])){
                        if (!$db->hasSameInterests($user->interests, $post['search_interests'])){
                            $match = false;
                        }
                    }
                    if (!empty($_POST['search_min_age'])){
                        if (!$db->minAge($user->age, $post['search_min_age'])){
                            $match = false;
                        }
                    }
                    if (!empty($_POST['search_max_age'])){
                        if (!$db->maxAge($user->age, $post['search_max_age'])){
                            $match = false;
                        }
                    }
                    if (!empty($_POST['search_min_fame'])){
                        if (!$db->minFame($db->getSumFame($user->id), $post['search_min_fame'])){
                            $match = false;
                        }
                    }
                    if (!empty($_POST['search_max_fame'])){
                        if (!$db->maxFame($db->getSumFame($user->id), $post['search_max_fame'])){
                            $match = false;
                        }
                    }


                    if ($match){
                        $browse_hasUsers = true;
                        if (!isset($i) || $i === 0){
                            $i = 3;
                        }
                        if ($i === 3){
                            echo "<div class='row'>";
                            $opendiv = true;
                        }

                        echo "<div class='col-lg-4 col-sm-4 col-xs-12'>";
                        if (file_exists("../images/".$user->id."/".$user->profile_pic)){
                            echo "<img src='../images/".$user->id."/".$user->profile_pic."' class='img_md'>";
                        }else{
                            echo "<img src='#' class='img_md'>";
                        }

                        echo "<div class='row'>";
                            echo "<div class='col-lg-2 col-sm-2 col-xs-2'></div>";
                            echo "<a href='../lib/view_profile.php?username=".htmlspecialchars($user->username)."'><button class='btn-danger maroon col-lg-8 col-sm-8 col-xs-8'>".
                                htmlspecialchars($user->username)."</button></a>";
                            echo "<div class='col-lg-2 col-sm-2 col-xs-2'></div>";
                        echo "</div>";
                        echo "</div>";

                        if ($i === 1){
                            echo "</div>";
                            $closeddiv = true;
                        }
                        $i--;
                    }
                    
                }
                
            }
        }
        if (!isset($browse_hasUsers)){
            echo "You have no users you can view";
        }
        if ($opendiv && !$closeddiv){
            echo "</div>";
        }
    }
}

function browse(){
    $db = new Database();
    if ($users = $db->getUsers()){
        foreach ($users as $user){
            if (!$db->hasBlocked($user->id) && !$db->isBlockedBy($user->id) && $db->hasGenderMatch($user->gender) && $db->hasAttractionMatch($user->attraction)){

                $browse_hasUsers = true;
                if (!isset($i) || $i === 0){
                    $i = 3;
                }
                if ($i === 3){
                    echo "<div class='row'>";
                    $opendiv = true;
                }

                echo "<div class='col-lg-4 col-sm-4 col-xs-12'>";
                if (file_exists("../images/".$user->id."/".$user->profile_pic)){
                    echo "<img src='../images/".$user->id."/".$user->profile_pic."' class='img_md'>";
                }else{
                    echo "<img src='#' class='img_md'>";
                }

                echo "<div class='row'>";
                    echo "<div class='col-lg-2 col-sm-2 col-xs-2'></div>";
                    echo "<a href='../lib/view_profile.php?username=".htmlspecialchars($user->username)."'><button class='btn-danger maroon col-lg-8 col-sm-8 col-xs-8'>".
                        htmlspecialchars($user->username)."</button></a>";
                    echo "<div class='col-lg-2 col-sm-2 col-xs-2'></div>";
                echo "</div>";
                echo "</div>";

                if ($i === 1){
                    echo "</div>";
                    $closeddiv = true;
                }
                $i--;
            }
        }
        if (!isset($browse_hasUsers)){
            echo "You have no users you can view";
        }
        if ($opendiv && !$closeddiv){
            echo "</div>";
        }
    }
}

//==================================MUTUALS========================================>

function getMutuals($uid){
    if (is_numeric($uid)){
        $user = new User();

        if ($mutuals = $user->getMutuals($uid)){
            foreach ($mutuals as $e => $user_id) {
                $user->get = $user->getUser('id', $user_id);

                echo "<div class='row'>";
                echo "<a href='view_profile.php?username=".htmlspecialchars($user->get->username)."'>";
                echo "<button class='btn-default col-lg-12'>";
                echo htmlspecialchars($user->get->username);
                echo "</button";
                echo "</a>";
                echo "</div>";
            }
        }else{
            echo "<p>User has no mutuals</p>";
        }
    }
}

//==================================LIKES========================================>


function getLikes($uid){
    if (is_numeric($uid)){
        $user = new User();

        if ($likes = $user->getLikes($uid)){
            foreach ($likes as $e => $like) {
                $user->get = $user->getUser('id', $like->liked_by);

                echo "<div class='row'>";
                echo "<a href='view_profile.php?username=".htmlspecialchars($user->get->username)."'>";
                echo "<button class='btn-default col-lg-12'>";
                echo htmlspecialchars($user->get->username);
                echo "</button";
                echo "</a>";
                echo "</div>";
            }
        }else{
            echo "<p>User has no likes</p>";
        }
    }
}

//==================================VIEWS========================================>

function getViews($uid){
    if (is_numeric($uid)){
        $user = new User();

        if ($views = $user->getViews($uid)){
            foreach ($views as $e => $view) {
                $user->get = $user->getUser('id', $view->viewed_by);

                echo "<div class='row'>";
                echo "<a href='view_profile.php?username=".htmlspecialchars($user->get->username)."'>";
                echo "<button class='btn-default col-lg-12'>";
                echo htmlspecialchars($user->get->username);
                echo "</button";
                echo "</a>";
                echo "</div>";
            }
        }else{
            echo "<p>User has no views</p>";
        }
    }
}


//==================================MISC========================================>

function offline_hide(){
    if (!isset($_SESSION['id'])){
        echo "style='display: none';";
    }
}

?>