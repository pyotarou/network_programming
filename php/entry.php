<?php
    require 'UserData.php';

    if(empty($_POST["name"])) {
        echo "nameが入力されていません。";
    } else if(empty($_POST["password"]) || empty($_POST["passwordCheck"])){
        echo "パスワードがどちらか入力されていません。";
    } else {
        $username = $_POST["name"];
        $password = $_POST["password"];
        $passwordCheck = $_POST["passwordCheck"];
        if($password == $passwordCheck) {        
            try {
                $userDB = new UserData("localhost", "root", "password", "NetProg");
                if($userDB->entry($username,$password)){
                    echo "OK";
                } else {
                    echo "そのユーザ名は使えません";
                    return;
                }
            } catch (PDOException $e){
                $errormessage = "データベースエラー";
                echo $e->getMessage();
            }
        } else {
            echo "２つのパスワードがマッチしません。";
        }
    }
?>