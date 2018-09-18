<?php

require "../config/database.php";

//create PDO instance
$con = new PDO(DB_HOST, DB_USER, DB_PASSWORD);
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "USE Matcha";
$con->exec($sql);

$sql = "INSERT INTO users (
              username, first_name, last_name, age, email, password, gender, pronouns, attraction, interests)
              VALUES ('PsyQuartz', 'Maxine', 'Erasmus', '23', 'maxerasmus@yahoo.com', 
              's:128:\"7170a12710d34bdf0ca1fbae56e12a232a87cb9426d4525da84123bea9fd539e8b06620d6088034db0155b0d82d51633781f5315ba96e1b4ebe9ef6d2f93fbd8\";', 
              'transgender woman', 'she, her and hers', 'cisgender men, cisgender women, transgender men, transgender women, genderfluid people',
              '#gaming, #art, #nature, #tech, #cats')";

$con->exec($sql);

$sql = "INSERT INTO interests (
              interest, user_id)
              VALUES ()";

$sql = "INSERT INTO interests (interest, user_id)
VALUES
    ('#gaming', '1'),
    ('#art', '1'),
    ('#nature', '1'),
    ('#tech', '1'),
    ('#cats', '1');";

$con->exec($sql);

$sql = "INSERT INTO users (
              username, first_name, last_name, age, email, password, gender, pronouns, attraction, interests)
              VALUES ('Savage', 'Herman', 'Botha', '23', 'hbotha@blah.com', 
              's:128:\"7170a12710d34bdf0ca1fbae56e12a232a87cb9426d4525da84123bea9fd539e8b06620d6088034db0155b0d82d51633781f5315ba96e1b4ebe9ef6d2f93fbd8\";', 
              'cisgender man', 'he, him and his', 'cisgender men, cisgender women',
              '#rupaul, #art, #nature, #food, #stevenuniverse')";

$con->exec($sql);

$sql = "INSERT INTO interests (interest, user_id)
VALUES
    ('#rupaul', '2'),
    ('#art', '2'),
    ('#nature', '2'),
    ('#food', '2'),
    ('#stevenuniverse', '2');";

$con->exec($sql);

$sql = "INSERT INTO users (
              username, first_name, last_name, age, email, password, gender, pronouns, attraction, interests)
              VALUES ('QueenBee', 'Aimee', 'Young', '23', 'ayoung@blah.com', 
              's:128:\"7170a12710d34bdf0ca1fbae56e12a232a87cb9426d4525da84123bea9fd539e8b06620d6088034db0155b0d82d51633781f5315ba96e1b4ebe9ef6d2f93fbd8\";', 
              'genderfluid person', 'she, her and hers', 'cisgender men, transgender men',
              '#nature, #music, #fantasy, #food, #gaming')";

$con->exec($sql);

$sql = "INSERT INTO interests (interest, user_id)
VALUES
    ('#nature', '3'),
    ('#music', '3'),
    ('#fantasy', '3'),
    ('#food', '3'),
    ('#gaming', '3');";

$con->exec($sql);

$sql = "INSERT INTO users (
              username, first_name, last_name, age, email, password, gender, pronouns, attraction, interests)
              VALUES ('Androva', 'Naledi', 'Matutoane', '20', 'nmatutoane@blah.com', 
              's:128:\"7170a12710d34bdf0ca1fbae56e12a232a87cb9426d4525da84123bea9fd539e8b06620d6088034db0155b0d82d51633781f5315ba96e1b4ebe9ef6d2f93fbd8\";', 
              'cisgender woman', 'she, her and hers', 'cisgender men, cisgender women, genderfluid people',
              '#books, #tech, #astronomy, #leagueoflegends, #memes')";

$con->exec($sql);

$sql = "INSERT INTO interests (interest, user_id)
VALUES
    ('#books', '4'),
    ('#tech', '4'),
    ('#astronomy', '4'),
    ('#leagueoflegends', '4'),
    ('#memes', '4');";

$con->exec($sql);

$sql = "INSERT INTO users (
              username, first_name, last_name, age, email, password, gender, pronouns, interests)
              VALUES ('FuzMuz', 'Murray', 'MacDonald', '22', 'mmac@blah.com', 
              's:128:\"7170a12710d34bdf0ca1fbae56e12a232a87cb9426d4525da84123bea9fd539e8b06620d6088034db0155b0d82d51633781f5315ba96e1b4ebe9ef6d2f93fbd8\";', 
              'cisgender man', 'he, him and his',
              '#tech, #nature, #books, #leagueoflegends, #memes')";

$con->exec($sql);

$sql = "INSERT INTO interests (interest, user_id)
VALUES
    ('#tech', '5'),
    ('#nature', '5'),
    ('#books', '5'),
    ('#leagueoflegends', '5'),
    ('#memes', '5');";

$con->exec($sql);

echo "<script>alert('Samples Added to Database');location.href='../index.php';</script>";
?>