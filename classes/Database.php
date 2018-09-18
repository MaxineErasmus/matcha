<?php

if (!isset($_SESSION)){
    session_start();
}

require $_SESSION['ROOT'] . "/config/database.php";

class Database {
    protected $con;
    protected $email;
    protected $get;
    protected $token;
    protected $gender = "agender person, cisgender man, cisgender woman, transgender man, 
        transgender woman, genderfluid person, genderqueer person, nonbinary person";
    protected $attraction = "agender people, cisgender men, cisgender women, transgender men, 
        transgender women, genderfluid people, genderqueer people, nonbinary people";

    protected $reg_data = ["username", "first_name", "last_name", "email", "pass", "pass2"];
    protected $stats_data = ["fame", "likes", "views"];
    protected $info_data = ["username", "first_name", "last_name", "email", "age", "gender", "pronouns", "attraction"];
    protected $profile_data = ["id", "last_seen", "latitude", "longitude", "profile_pic","username", "first_name", "last_name", "email", "age",
                            "gender", "pronouns", "attraction", "interests", "biography"];

    //================>    MAGIC METHODS    <================//

    function __construct()
    {
        $this->connect();
    }

    function __set($name, $value){
        $this->$name = $value;
    }

    function __get($key){
        if ($this->$key){
            return $this->$key;
        }else{
            return NULL;
        }
    }

    //================>    [DATABASE] Connect   <================//

    function connect(){
        try{
            $this->con = new PDO (DB_DSN,DB_USER, DB_PASSWORD);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        }catch (PDOException $e){
            echo "<script>alert('Db __connect() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    //================>    [DATABASE] Users   <================//

    function getUser($key, $val){
        try {
            if ($key == "id")
                $sql = $this->con->prepare("SELECT * FROM users WHERE id = ?");
            else if ($key == "username")
                $sql = $this->con->prepare("SELECT * FROM users WHERE username = ?");
            else if ($key == "email")
                $sql = $this->con->prepare("SELECT * FROM users WHERE email = ?");
            else
                exit("Invalid getUser key");

            $sql->execute([$val]);
            $result = $sql->fetch();
            return ($result);
        }catch(PDOException $e) {
            echo "<script>alert('Db getUser() Error);</script>";
            error_log($e);
            return NULL;
        }
    }

    function getUsers($offset = 0, $limit = 0){
        try {
            if (is_numeric($offset) && is_numeric($limit)){
                if ($offset == 0 && $limit == 0){
                    $sql = $this->con->prepare("SELECT * FROM users WHERE id != ?");
                    $sql->execute([$_SESSION['id']]);
                    $result = $sql->fetchALL();
                    return ($result);
                }else {
                    $sql = $this->con->prepare("SELECT * FROM users WHERE id != ? LIMIT ? OFFSET ?");
                    $sql->execute([$_SESSION['id'], $limit, $offset]);
                    $result = $sql->fetchALL();
                    return ($result);
                }
            }
            return false;
        }catch(PDOException $e) {
            echo "<script>alert('Db getUsers() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function addUser(){
        try{
            $sql = $this->con->prepare("INSERT INTO users (
              username, first_name, last_name, email, password, attraction)
              VALUES (?, ?, ?, ?, ?, ?)");

            if (!($sql->execute([$this->username, $this->first_name, $this->last_name,
                $this->email, $this->pass, $this->attraction]))){
                return false;
            }else{
                return true;
            }
        }catch(PDOException $e) {
            echo "<script>alert('Db addUser() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function delUser($key, $val){
        try {
            htmlspecialchars($val);

            if ($key == "id")
                $sql = $this->con->prepare("DELETE FROM users WHERE id = ?");
            else if ($key == "username")
                $sql = $this->con->prepare("DELETE FROM users WHERE username = ?");
            else if ($key == "email")
                $sql = $this->con->prepare("DELETE FROM users WHERE email = ?");
            else
                exit("Invalid delUser key");

            if (!($sql->execute([$val]))){
                return false;
            }else{
                return true;
            }
        }catch(PDOException $e) {
            echo "<script>alert('Db delUser() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    //================>    [DATABASE] Location    <================//

    function getLatitude($uid){
        try{
            if (is_numeric($uid)){
                $sql = $this->con->prepare('SELECT latitude FROM users WHERE id = ?');
                $sql = $this->execute([$uid]);
                return $sql->fetch();
            }
            return NULL;
        }catch(PDOException $e) {
            echo "<script>alert('Db getLatitude() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function getLongitude($uid){
        try{
            if (is_numeric($uid)){
                $sql = $this->con->prepare('SELECT longitude FROM users WHERE id = ?');
                $sql = $this->execute([$uid]);
                return $sql->fetch();
            }
            return NULL;
        }catch(PDOException $e) {
            echo "<script>alert('Db getLatitude() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    //================>    [DATABASE] Username    <================//

    function username_exists($username){
        try{
            return ($this->getUser('username', $username));
        }catch (PDOException $e){
            echo "<script>alert('Db username_exists() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    //================>    [DATABASE] Email    <================//

    function email_exists($email){
        try{
            return ($this->getUser('email', $email));
        }catch (PDOException $e){
            echo "<script>alert('Db email_exists() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function email_token($email){
        try{
            $msg = "Click the following link and update your password under profile settings.\n";
            $msg .= "http://".URL."?email=".$email."&token=".$this->token_gen($email);

            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From: rerasmus <rerasmus@matcha.com>' . "\r\n";

            return (mail($email, "Matcha Forgot Password", $msg, $headers));
        }catch (PDOException $e){
            echo "<script>alert('Db email_token() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    //================>    [DATABASE] Info   <================//

    function setUserInfo($uid, array $post){
        try {
            if (is_numeric($uid)) {
                $isUpdated = false;
                foreach ($this->info_data as $e) {
                    if (isset($post[$e]) && !empty($post[$e])) {
                        if ($e == 'username'){
                            if ($this->username_exists($post[$e])){
                                echo "<script>alert('username already taken');</script>";
                                return false;
                            }
                        }
                        else if ($e == 'email'){
                            if ($this->email_exists($post[$e])){
                                echo "<script>alert('email already used');</script>";
                                return false;
                            }
                        }else if ($e == 'attraction'){
                            $post[$e] = implode(', ',$post[$e]);
                        }
                        if (isset($_SESSION[$e])){
                            if ($post[$e] !== $_SESSION[$e]){
                                $update = "UPDATE users SET ".$e." = ? WHERE id = ?";
                                $sql = $this->con->prepare($update);
                                $sql->execute([$post[$e], $uid]);
                                $_SESSION[$e] = $post[$e];
                                $isUpdated = true;  
                            }
                        }else{
                            $update = "UPDATE users SET ".$e." = ? WHERE id = ?";
                            $sql = $this->con->prepare($update);
                            $sql->execute([$post[$e], $uid]);
                            $_SESSION[$e] = $post[$e];
                            $isUpdated = true;  
                        }
                        
                    }
                }
            }
            return $isUpdated;
        }catch(PDOException $e) {
            echo "<script>alert('Db setUserInfo() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    //================>    [DATABASE] Interests   <================//


    function setUserInterests($uid, $interests){
        try{
            if (is_numeric($uid)){
                $interests = str_replace(',',' ',$interests);
                $interests = explode(' ', $interests);
                $interests = array_filter($interests);
                $interests = array_unique($interests);


                $error = false;

                foreach ($interests as $hashtag){
                    if ($hashtag[0] !== '#' || !isset($hashtag[1])){
                        $error = true;
                    }
                }

                if (!$error){
                    if ($ans = $this->hasInterest($uid)){
                        $sql = $this->con->prepare("DELETE FROM interests WHERE user_id = ?");
                        $sql->execute([$uid]);
                    }
                    foreach ($interests as $hashtag){
                        $this->addInterest($uid , strtolower($hashtag));
                    }
                    $_SESSION['interests'] = implode(', ',$interests);

                    $sql_user_interests = $this->con->prepare("UPDATE users SET interests = ? WHERE id = ?");
                    $sql_user_interests->execute([$_SESSION['interests'],$uid]);

                    return true;
                }else{
                    return false;
                }
            }
            return NULL;
        }catch(PDOException $e) {
            echo "<script>alert('Db setUserInterests() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function addInterest($uid, $interest){
        try{
            if (is_numeric($uid)){
                $sql = $this->con->prepare('INSERT INTO interests (user_id, interest) VALUES (?, ?)');
                $sql->execute([$uid, $interest]);
            }
            return false;
        }catch(PDOException $e) {
            echo "<script>alert('Db addInterest() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function hasInterest($uid, $interest = 0){
        try{
            if (is_numeric($uid)){
                if ($interest == 0){
                    $sql = $this->con->prepare("SELECT COUNT(*) FROM interests WHERE user_id = ?");
                    $sql->execute([$uid]);
                }else{
                    $sql = $this->con->prepare("SELECT COUNT(*) FROM interests WHERE user_id = ? AND interest = ?");
                    $sql->execute([$uid, $interest]);
                }
                return $sql->fetchColumn();
            }
            return false;
        }catch(PDOException $e) {
            echo "<script>alert('Db hasInterest() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    //================>    [DATABASE] Biography   <================//

    function setUserBiography($uid, $biography){
        try {
            if (is_numeric($uid) && !empty($biography)){
                $sql = $this->con->prepare("UPDATE users SET biography = ? WHERE id = ?");
                $sql->execute([$biography, $uid]);
                $_SESSION['biography'] = $biography;
                return true;
            }
            return false;
        }catch(PDOException $e) {
            echo "<script>alert('Db setUserBiography() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    //================>    [DATABASE] Like    <================//

    function like($liked_by, $uid){
        try{
            if (is_numeric($liked_by) && is_numeric($uid)){
                $sql = $this->con->prepare("INSERT INTO likes (user_id, liked_by) VALUES (?,?)");

                return ($sql->execute([$uid, $liked_by]));
            }
            return false;
        }catch (PDOException $e){
            echo "<script>alert('Db like() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function unlike($liked_by, $uid){
        try{
            if (is_numeric($liked_by) && is_numeric($uid)){
                $sql = $this->con->prepare("DELETE FROM likes WHERE user_id = ? AND liked_by = ?");
                return ($sql->execute([$uid, $liked_by]));
            }
            return false;
        }catch (PDOException $e){
            echo "<script>alert('Db unlike() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function hasLiked($liked_by, $uid){
        try{
            if (is_numeric($liked_by) && is_numeric($uid)){
                $sql = $this->con->prepare("SELECT * FROM likes WHERE user_id = ? AND liked_by = ?");
                $sql->execute([$uid, $liked_by]);
                return ($sql->fetch());
            }
            return false;
        }catch (PDOException $e){
            echo "<script>alert('Db hasLiked() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function getSumLikes($uid){
        try{
            if (is_numeric($uid)){
                $sql = $this->con->prepare("SELECT COUNT(liked_by) FROM likes WHERE user_id = ?");
                $sql->execute([$uid]);
                if (!($result = $sql->fetchColumn())){
                    return 0;
                }else{
                    return $result;
                }
            }
            return 0;
        }catch (PDOException $e){
            echo "<script>alert('Db getSumLikes() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function getLikes($uid){
        try{
            if (is_numeric($uid)){
                $sql = $this->con->prepare("SELECT * FROM likes WHERE user_id = ?");
                $sql->execute([$uid]);
                return ($sql->fetchAll());
            }
            return false;
        }catch (PDOException $e){
            echo "<script>alert('Db getLikes() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    //================>    [DATABASE] Chat    <================//

    function msg($uid, $msg){
        try{
            if (is_numeric($uid)){
                $sql = $this->con->prepare("INSERT INTO chats (user_id, from_id, msg) VALUES (?,?,?)");
                $sql->execute([$uid, $_SESSION['id'], $msg]);
                return true;
            }
            return false;
        }catch (PDOException $e){
            echo "<script>alert('Db msg() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function getChat($uid){
        try{
            if (is_numeric($uid)){
                $sql = $this->con->prepare("SELECT * FROM chats WHERE (user_id = ? AND from_id = ?) OR (user_id = ? AND from_id = ?)");
                $sql->execute([$_SESSION['id'], $uid, $uid, $_SESSION['id']]);
                return ($sql->fetchAll());
            }else{
                return false;
            }
        }catch (PDOException $e){
            echo "<script>alert('Db getChat(uid) Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function getChats(){
        try{
            $sql = $this->con->prepare("SELECT user_id FROM chats WHERE from_id = ?");
            $sql->execute([$_SESSION['id']]);
            $res1 = $sql->fetchAll(PDO::FETCH_ASSOC);

            $sql = $this->con->prepare("SELECT from_id FROM chats WHERE user_id = ?");
            $sql->execute([$_SESSION['id']]);
            $res2 = $sql->fetchAll(PDO::FETCH_ASSOC);

            $i = 0;
            $res = array();
            foreach ($res1 as $key => $val){
                foreach ($val as $subkey => $user_id){
                    if (!in_array($user_id, $res) && $this->isMutual($user_id)){
                        $res[$i] = $user_id;
                        $i++;
                    }
                }
            }
            foreach ($res2 as $key => $val){
                foreach ($val as $subkey => $user_id){
                    if (!in_array($user_id, $res) && $this->isMutual($user_id)){
                        $res[$i] = $user_id;
                        $i++;
                    }
                }
            }

            return ($res);
        }catch (PDOException $e){
            echo "<script>alert('Db getChats() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function hasReadMsgs($chat_id){
        try{
            if (is_numeric($chat_id)){
                $sql = $this->con->prepare("UPDATE chats SET has_read = 1 WHERE id = ?");
                $sql->execute([$chat_id]);
            }
        }catch (PDOException $e){
            echo "<script>alert('Db hasReadMsgs() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function getSumUnreadMsgs($uid){
        try{
            if (is_numeric($uid)){
                $sql = $this->con->prepare("SELECT COUNT(*) FROM chats WHERE has_read = 0 AND user_id = ? AND from_id = ?");
                $sql->execute([$_SESSION['id'], $uid]);
                return ($sql->fetchColumn());
            }
            return false;
        }catch (PDOException $e){
            echo "<script>alert('Db getSumUnreadMsgs() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function getSumAllUnreadMsgs(){
        try{
            $sql = $this->con->prepare("SELECT COUNT(*) FROM chats WHERE has_read = 0 AND user_id = ?");
            $sql->execute([$_SESSION['id']]);
            return ($sql->fetchColumn());
        }catch (PDOException $e){
            echo "<script>alert('Db getSumAllUnreadMsgs() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    //================>    [DATABASE] Notify    <================//

    function notify($uid, $msg){
        try{
            if (is_numeric($uid)) {
                $sql = $this->con->prepare("INSERT INTO notifications (user_id, from_id, msg) VALUES (?, ?, ?)");
                $sql->execute([$uid, $_SESSION['id'], $msg]);
            }
        }catch (PDOException $e){
            echo "<script>alert('Db notify() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function getSumNotifications(){
        try{
            $sql = $this->con->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = ?");
            $sql->execute([$_SESSION['id']]);
            return ($sql->fetchColumn());
        }catch (PDOException $e){
            echo "<script>alert('Db getSumNotifications() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function getNotifications(){
        try{
            $sql = $this->con->prepare("SELECT * FROM notifications WHERE user_id = ?");
            $sql->execute([$_SESSION['id']]);
            $this->hasReadNotifications();
            return ($sql->fetchAll());
        }catch (PDOException $e){
            echo "<script>alert('Db getNotifications() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function hasReadNotifications(){
        try{
            $sql = $this->con->prepare("DELETE FROM notifications WHERE user_id = ?");
            $sql->execute([$_SESSION['id']]);
        }catch (PDOException $e){
            echo "<script>alert('Db hasReadNotifications() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    //================>    [DATABASE] Pic    <================//

    function hasPic($uid){
        try{
            if (file_exists("../images/".$uid."/1.png") ||
                file_exists("../images/".$uid."/2.png") ||
                file_exists("../images/".$uid."/3.png") ||
                file_exists("../images/".$uid."/4.png") ||
                file_exists("../images/".$uid."/5.png")){
                return true;
            }else{
                return false;
            }
        }catch (PDOException $e){
            echo "<script>alert('Db hasPic() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    //================>    [DATABASE] Fame i.e: Num of Mutuals   <================//

    function getSumFame($uid){
        try{
            if (is_numeric($uid)){
                $sql = $this->con->prepare("SELECT * FROM likes WHERE user_id = ?");
                $sql->execute([$uid]);
                $res1 = $sql->fetchAll();

                $sql = $this->con->prepare("SELECT * FROM likes WHERE liked_by = ?");
                $sql->execute([$uid]);
                $res2 = $sql->fetchAll();

                $fame = 0;
                foreach ($res1 as $a){
                    foreach ($res2 as $b){
                        if ($a->liked_by === $b->user_id){
                            $fame = $fame + 1;
                        }
                    }
                }

                return ($fame);
            }
            return false;
        }catch (PDOException $e){
            echo "<script>alert('Db getSumFame() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function isMutual($uid){
        try{
            if (is_numeric($uid)){
                $sql = $this->con->prepare("SELECT * FROM likes WHERE user_id = ? AND liked_by = ?");
                $sql->execute([$uid, $_SESSION['id']]);
                if ($sql->fetch()){
                    $sql = $this->con->prepare("SELECT * FROM likes WHERE user_id = ? AND liked_by = ?");
                    $sql->execute([$_SESSION['id'], $uid]);
                    if ($sql->fetch()){
                        return true;
                    }
                }
            }
            return false;
        }catch (PDOException $e){
            echo "<script>alert('Db isMutual() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function getMutuals($uid){
        try {
            if (is_numeric($uid)) {
                $sql = $this->con->prepare("SELECT * FROM likes WHERE user_id = ?");
                $sql->execute([$uid]);
                $list_likedby = $sql->fetchAll();

                $sql = $this->con->prepare("SELECT * FROM likes WHERE liked_by = ?");
                $sql->execute([$uid]);
                $list_liked = $sql->fetchAll();

                $i = 0;
                foreach ($list_likedby as $a) {
                    foreach ($list_liked as $b) {
                        if ($a->liked_by === $b->user_id) {
                            $mutuals[$i] = $b->user_id;
                            $i++;
                        }
                    }
                }
                if (isset($mutuals) && !empty($mutuals)){
                    return $mutuals;
                }
            }
            return false;
        }catch (PDOException $e){
            echo "<script>alert('Db getMutuals() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    //================>    [DATABASE] View    <================//

    function view($uid){
        try{
            if (is_numeric($uid) && $uid !== $_SESSION['id']){
                $sql = $this->con->prepare("INSERT INTO views (user_id, viewed_by) VALUES (?,?)");
                $sql->execute([$uid, $_SESSION['id']]);
            }
        }catch (PDOException $e){
            echo "<script>alert('Db view() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function hasViewed($uid){
        try{
            if (is_numeric($uid)){
                $sql = $this->con->prepare("SELECT * FROM views WHERE user_id = ? AND viewed_by = ?");
                $sql->execute([$uid, $_SESSION['id']]);
                return ($sql->fetch());
            }
            return false;
        }catch (PDOException $e){
            echo "<script>alert('Db hasViewed() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function getSumViews($uid){
        try{
            if (is_numeric($uid)){
                $sql = $this->con->prepare("SELECT COUNT(*) FROM views WHERE user_id = ? AND viewed_by != ?");
                $sql->execute([$uid, $uid]);
                return ($sql->fetchColumn());
            }
            return false;
        }catch (PDOException $e){
            echo "<script>alert('Db getSumViews() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function getViews($uid){
        try{
            if (is_numeric($uid)){
                $sql = $this->con->prepare("SELECT * FROM views WHERE user_id = ? AND viewed_by != ?");
                $sql->execute([$uid, $uid]);
                return ($sql->fetchAll());
            }
            return false;
        }catch (PDOException $e){
            echo "<script>alert('Db getViews() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    //================>    [DATABASE] Report    <================//

    function report($reported_by, $uid){
        try{
            if (is_numeric($reported_by) && is_numeric($uid)){
                $sql = $this->con->prepare("INSERT INTO reports (reported_by, user_id) VALUES (?,?)");

                return ($sql->execute([$reported_by, $uid]));
            }
            return false;
        }catch (PDOException $e){
            echo "<script>alert('Db report() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function hasReported($reported_by, $uid){
        try{
            if (is_numeric($reported_by) && is_numeric($uid)){
                $sql = $this->con->prepare("SELECT * FROM reports WHERE user_id = ? AND reported_by = ?");
                $sql->execute([$uid, $reported_by]);
                return ($sql->fetch());
            }
            return false;
        }catch (PDOException $e){
            echo "<script>alert('Db hasReported() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    //================>    [DATABASE] Block    <================//

    function block($blocked_by, $uid){
        try{
            if (is_numeric($blocked_by) && is_numeric($uid)){
                $sql = $this->con->prepare("INSERT INTO blocked (blocked_by, user_id) VALUES (?,?)");

                return ($sql->execute([$blocked_by, $uid]));
            }
            return false;
        }catch (PDOException $e){
            echo "<script>alert('Db block() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function hasBlocked($uid){
        try{
            if (is_numeric($uid)){
                $sql = $this->con->prepare("SELECT * FROM blocked WHERE user_id = ? AND blocked_by = ?");
                $sql->execute([$uid, $_SESSION['id']]);
                return ($sql->fetch());
            }
            return false;
        }catch (PDOException $e){
            echo "<script>alert('Db hasBlocked() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function isBlockedBy($uid){
        try{
            if (is_numeric($uid)){
                $sql = $this->con->prepare("SELECT * FROM blocked WHERE user_id = ? AND blocked_by = ?");
                $sql->execute([$_SESSION['id'], $uid]);
                return ($sql->fetch());
            }
            return false;
        }catch (PDOException $e){
            echo "<script>alert('Db isBlockedBy() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    //================>    [DATABASE] Search   <================//

    function hasSameInterests($user_interests, $search_interests){
        $user_interests = explode(', ', $user_interests);
        $search_interests = explode(' ', $search_interests);

        foreach ($search_interests as $search_interest) {
            if (!in_array($search_interest, $user_interests)){
                return false;
            }
        }
        return true;
    }

    function getAge($uid){
        try{
            if (is_numeric($uid)){
                $sql = $this->con->prepare('SELECT age FROM users WHERE id = ?');
                $sql->execute([$uid]);
                return $sql->fetch();
            }
        }catch(PDOException $e) {
            echo "<script>alert('Db getAge() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function minAge($user_age, $min_age){
        return $user_age >= $min_age;
    }

    function maxAge($user_age, $max_age){
        return $user_age <= $max_age;
    }

    function minFame($user_age, $min_fame){
        return $user_age >= $min_fame;
    }

    function maxFame($user_age, $max_fame){
        return $user_age <= $max_fame;
    }

    function hasGenderMatch($user_gender){
        $search_attraction = explode(', ', $_SESSION['attraction']);
        if (!empty($search_attraction[0])){
            for ($i = 0; $i < 8; $i++){
                if (in_array($_SESSION['attraction_list'][$i], $search_attraction)){
                    if ($_SESSION['gender_list'][$i] == $user_gender){
                        return true;
                    }
                }
            }
            return false;
        }
        return true;
    }

    function hasAttractionMatch($user_attraction){
        $user_attraction = explode(', ', $user_attraction);
        if (!empty($user_attraction[0])){
            for ($i = 0; $i < 8; $i++){
                if (in_array($_SESSION['attraction_list'][$i], $user_attraction)){
                    if ($_SESSION['gender_list'][$i] == $_SESSION['gender']){
                        return true;
                    }
                }
            }
            return false;
        }
        return true;
    }

    //================>    [DATABASE] Security     <================//

    function pass_match($pass1, $pass2){
        try{
            return ($pass1 == $pass2);
        }catch (PDOException $e){
            echo "<script>alert('Db pass_match() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function new_password($pass){
        try{
            $this->pass_encrypt($pass);
            $sql = $this->con->prepare('UPDATE users SET password = ? WHERE id = ?');
            $sql->execute([$pass, $_SESSION['id']]);
        }catch (PDOException $e){
            echo "<script>alert('Db new_password() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function token_gen($email){
        try{
            $token = substr(md5(uniqid(rand(), true)), 16, 16);
            
            $sql = $this->con->prepare("UPDATE users SET token = ? WHERE email = ?");
            $sql->execute([$token, $email]);
            
            return $token;
        }catch (PDOException $e){
            echo "<script>alert('Db token_gen() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function hasPermission($uid){
        try{
            if (is_numeric($uid)){
                if ($this->hasBlocked($uid)){
                    echo("<script>alert('You blocked this user'); location.href='../dir/browse.php';</script>");
                }elseif ($this->isBlockedBy($uid)){
                    echo("<script>alert('You are blocked by this user'); location.href='../dir/browse.php';</script>");
                }else{
                    return true;
                }
            }
            return false;
        }catch (PDOException $e){
            echo "<script>alert('Db hasPermission() Error');</script>";
            error_log($e);
            return NULL;
        }
    }
}

?>