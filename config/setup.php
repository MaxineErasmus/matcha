<?php

require 'database.php';

try {
    echo "----------------SETUP---------------- <br>";

    //create PDO instance
    $con = new PDO(DB_HOST, DB_USER, DB_PASSWORD);
    $con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "1. SQL Connection Successful <br>";

    //PDO mysql CREATE DATABASE
    $sql = "CREATE DATABASE IF NOT EXISTS Matcha";
    $con->exec($sql);
    echo "2. Matcha Database Created <br>";


    //PDO mysql USE DATABASE
    $sql = "USE Matcha";
    $con->exec($sql);
    echo "3. Connected to Matcha <br><br>";


    //PDO mysql CREATE TABLES
    $sql = "CREATE TABLE IF NOT EXISTS Users (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        online TINYINT(1) DEFAULT 0,
        last_seen DATETIME DEFAULT CURRENT_TIMESTAMP,
        latitude DECIMAL (9,6) DEFAULT 0,
        longitude DECIMAL (9,6) DEFAULT 0,
        username VARCHAR (50),
        first_name VARCHAR (50),
        last_name VARCHAR (50),
        age INT UNSIGNED,
        email VARCHAR (100),
        password VARCHAR (1000),
        token VARCHAR (1000),
        gender VARCHAR (50),
        pronouns VARCHAR (50),
        attraction VARCHAR (200) DEFAULT '',
        interests VARCHAR (1600),
        biography VARCHAR (1600),
        profile_pic VARCHAR (50) DEFAULT '#'
    )";
    $con->exec($sql);
    echo "4. Users Table Created <br>";

    $sql = "CREATE TABLE IF NOT EXISTS Interests (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        user_id INT UNSIGNED,
        interest VARCHAR (50),
        FOREIGN KEY (user_id) REFERENCES Users(id)
    )";
    $con->exec($sql);
    echo "5. Interests Table Created <br>";

    $sql = "CREATE TABLE IF NOT EXISTS Views (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        user_id INT UNSIGNED,
        viewed_by INT UNSIGNED,
        FOREIGN KEY (user_id) REFERENCES Users(id),
        FOREIGN KEY (viewed_by) REFERENCES Users(id)
    )";
    $con->exec($sql);
    echo "6. Views Table Created <br>";

    $sql = "CREATE TABLE IF NOT EXISTS Likes (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        user_id INT UNSIGNED,
        liked_by INT UNSIGNED,
        FOREIGN KEY (user_id) REFERENCES Users(id),
        FOREIGN KEY (liked_by) REFERENCES Users(id)
    )";
    $con->exec($sql);
    echo "7. Likes Table Created <br>";

    $sql = "CREATE TABLE IF NOT EXISTS Blocked (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        user_id INT UNSIGNED,
        blocked_by INT UNSIGNED,
        FOREIGN KEY (user_id) REFERENCES Users(id),
        FOREIGN KEY (blocked_by) REFERENCES Users(id)
    )";
    $con->exec($sql);
    echo "8. Blocked Table Created <br>";

    $sql = "CREATE TABLE IF NOT EXISTS Reports (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        user_id INT UNSIGNED,
        reported_by INT UNSIGNED,
        FOREIGN KEY (user_id) REFERENCES Users(id),
        FOREIGN KEY (reported_by) REFERENCES Users(id)
    )";
    $con->exec($sql);
    echo "9. Reports Table Created <br>";

    $sql = "CREATE TABLE IF NOT EXISTS Chats (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        user_id INT UNSIGNED,
        from_id INT UNSIGNED,
        msg VARCHAR (1600),
        has_read TINYINT(1) DEFAULT 0,
        FOREIGN KEY (user_id) REFERENCES Users(id),
        FOREIGN KEY (from_id) REFERENCES Users(id)
    )";
    $con->exec($sql);
    echo "10. Chats Table Created <br>";

    $sql = "CREATE TABLE IF NOT EXISTS Notifications (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        user_id INT UNSIGNED,
        from_id INT UNSIGNED,
        msg VARCHAR (1600),
        FOREIGN KEY (user_id) REFERENCES Users(id),
        FOREIGN KEY (from_id) REFERENCES Users(id)
    )";
    $con->exec($sql);
    echo "11. Notifications Table Created <br>";

    $con = NULL;

    echo("<script> alert('Database configured. Test case users in samples folder'); location.href='../index.php';</script>");
}
catch(PDOException $e) {
    echo "----------------ERROR---------------- <br>";
    echo $sql . "<br>" . $e->getMessage() . "<br>";
}

?>
