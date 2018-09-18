<?php

if (!isset($_SESSION)){
    session_start();
}

class User extends Database
{
    protected $id, $username, $first_name, $last_name, $email, $pass, $pass2, $token,
        $online,
        $get,
        $images = ['img1' => '1.png', 'img2' => '2.png', 'img3' => '3.png', 'img4' => '4.png', 'img5' => '5.png'],
        $age, $gender, $pronouns,  $interests, $attraction, $biography;



    //================>    MAGIC METHODS    <================//

    function __construct()
    {
        parent::__construct();
    }

    function __set($name, $value)
    {
        $this->$name = $value;
    }

    function __get($key)
    {
        if ($this->$key) {
            return $this->$key;
        } else {
            return NULL;
        }
    }

    //================>    REGISTER    <================//

    function reg(array $input)
    {
        try {
            $this->reg_setInput($input);

            if ($this->reg_check()){
                $this->pass_encrypt($this->pass);
                if ($this->addUser()){
                    $this->get = $this->getUser('email',$this->email);
                    $_SESSION['id'] = $this->get->id;
                    $this->id = $this->get->id;
                    $this->online();
                    return true;
                }
            }
            return false;

        } catch (PDOException $e) {
            echo "<script>alert('User Reg() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function reg_setInput(array $input)
    {
        try{
            foreach ($this->reg_data as $e){
                $this->$e = $input[$e];
                if ($e !== 'pass' && $e !== 'pass2') {
                    $_SESSION[$e] = $input[$e];
                }
            }
        }catch (PDOException $e){
            echo "<script>alert('User reg_setInput() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function reg_check()
    {
        try {
            if ($this->reg_isInput()){
                if (!$this->email_exists($this->email)){
                    if (!$this->username_exists($this->username)){
                        if ($this->pass_match($this->pass, $this->pass2)){
                            return true;
                        }else{
                            echo "<script>alert('Passwords do not match');</script>";
                        }
                    }else{
                        echo "<script>alert('Username already exists');</script>";
                    }
                }else{
                    echo "<script>alert('Email already exists');</script>";
                }
            }else{
                echo "<script>alert('Please fill in all reg form fields');</script>";
            }
            return false;
        } catch (PDOException $e) {
            echo "<script>alert('User reg_check() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function reg_isInput()
    {
        try {
            return (!empty($this->username) && !empty($this->first_name) && !empty($this->last_name)
                && !empty($this->email) && !empty($this->pass) && !empty($this->pass2));
        } catch (PDOException $e) {
            echo "<script>alert('User reg_isInput() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    //================>    LOGIN    <================//

    function login(array $input)
    {
        try {
            $this->login_setInput($input);

            if ($this->login_isInput()){
                $this->pass_encrypt($this->pass);
                if (($this->get = $this->getUser('username', $this->username))){
                    if ($this->pass_match($this->pass, $this->get->password)) {
                        $this->id = $this->get->id;
                        $this->setSession();
                        $this->online();
                        return true;
                    }else{
                        echo "<script>alert('Incorrect Password');</script>";
                    }
                }else{
                    echo "<script>alert('Username does not exist');</script>";
                }
            }
            return false;
        } catch (PDOException $e) {
            echo "<script>alert('User Login() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function login_setInput(array $input){
        try{
            $this->username = $input['username'];
            $this->pass = $input['pass'];
        }catch (PDOException $e){
            echo "<script>alert('User login_setInput() Error');</script>";
            error_log($e);
            return NULL;
        }
    }


    function login_isInput()
    {
        try {
            return (!empty($this->username) && !empty($this->pass));
        } catch (PDOException $e) {
            echo "<script>alert('User login_isInput() Error');</script>";
            error_log($e);
            return NULL;
        }
    }



    function setSession(){
        try{
            foreach ($this->profile_data as $e){        
                $_SESSION[$e] = $this->get->$e;
            }
        }catch (PDOException $e){
            echo "<script>alert('User setSession() Error');</script>";
            return NULL;
        }
    }


    //================>    Profile    <================//

    function profile_updateImages($post, $files){
        $target_dir = "../images/".$_SESSION['id']."/";

        try{
            foreach ($this->images as $key => $val){
                $target_file = $target_dir . $val;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                if ($files[$key]["error"] === 0){
                    if(getimagesize($files[$key]["tmp_name"])) {
                        if ($files[$key]["size"] < 500000) {
                            if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg") {
                                if (!is_dir($target_dir)){
                                    mkdir($target_dir);
                                }
                                if (move_uploaded_file($files[$key]["tmp_name"], $target_file)) {
                                    $imagesUpdated = true;
                                }else{
                                    echo "<script>alert('Upload error')</script>";
                                }
                            }else{
                                echo "<script>alert('Only jpg, jpeg and png image types accepted')</script>";
                            }
                        }else{
                            echo "<script>alert('Your image is too large')</script>";
                        }
                    } else {
                        echo "<script>alert('The file you uploaded was not an image')</script>";
                    }
                }
            }

            //profile pic
            if (isset($post['img'])){
                foreach ($this->images as $key => $val){
                    if ($post['img'] == $key) {
                        if ($_SESSION['profile_pic'] != $val) {
                            $_SESSION['profile_pic'] = $val;
                            $this->profile_updateProfilePic($val);
                        }
                    }
                }
            }

            return $imagesUpdated;
        }catch (PDOException $e){
            echo "<script>alert('User profile_updateImages() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function profile_updateProfilePic($img){
        try{
            $sql = $this->con->prepare("UPDATE users SET profile_pic = ? WHERE id = ?");
            $sql->execute([$img, $_SESSION['id']]);
            echo "<script>alert('Profile Pic Updated');</script>";
        }catch (PDOException $e){
            echo "<script>alert('User profile_updateProfilePic() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function profile_deleteImg($img){
        try{
            if (file_exists("../images/".$_SESSION['id']."/".$this->images[$img])){
                unlink("../images/".$_SESSION['id']."/".$this->images[$img]);
                return true;
            }else{
                return false;
            }
        }catch (PDOException $e){
            echo "<script>alert('User profile_deleteImg() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    //location

    function profile_updateLocation($latitude, $longitude){
        try{
            if (is_numeric($latitude) && is_numeric($longitude)){
                $sql = $this->con->prepare("UPDATE users SET latitude = ?, longitude = ? WHERE id = ?");
                $sql->execute([$latitude, $longitude, $_SESSION['id']]);
                return true;
            }
            return false;
        }catch (PDOException $e){
            echo "<script>alert('User profile_updateLocation() Error');</script>";
            error_log($e);
            return NULL;
        }
    }


    //================>    MISC   <================//

    function online(){
        try {
            $_SESSION['online'] = true;
            $sql = $this->con->prepare("UPDATE users SET online = true, last_seen = CURRENT_TIMESTAMP WHERE id = ?");
            $sql->execute([$this->id]);
        }catch (PDOException $e){
            echo "<script>alert('User online() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function offline(){
        try {
            $sql = $this->con->prepare("UPDATE users SET online = false, last_seen = CURRENT_TIMESTAMP WHERE id = ?");
            $sql->execute([$this->id]);
        }catch (PDOException $e){
            echo "<script>alert('User offline() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function pass_encrypt(&$pass)
    {
        try {
            if (!($pass = (serialize(hash('whirlpool', $pass))))) {
                return false;
            }
            return true;
        } catch (PDOException $e) {
            echo "<script>alert('User pass_encrypt() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

    function forgot_pass($email, $token){
        try {

            $sql = $this->con->prepare("SELECT * FROM users WHERE email = ? AND token = ?");
            $sql->execute([$email, $token]);
            $this->get = $sql->fetch();

            if (!empty($this->get)){
                $this->setSession();
                $this->online();
                return true;
            }else{
                return false;
            }
        } catch (PDOException $e) {
            echo "<script>alert('User forgot_pass() Error');</script>";
            error_log($e);
            return NULL;
        }
    }

}

?>