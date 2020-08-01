<?php
    require "UserData.php";
    session_start();

    if(empty($_SESSION["id"])){
        header("Location: ../logout.php");
        exit;
    } else if(empty($_POST["to_id"])){
        echo "IDが入力されていません。";
    } else {
        $fromID = $_SESSION["id"];
        $toID = $_POST["to_id"];
        $userDB = new UserData("localhost", "root", "password", "NetProg");
        $userDB->share($fromID,$toID);
    }
?>