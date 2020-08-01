<?php
    require 'UserData.php';
    // セッション開始
    @session_start();
    if (isset($_SESSION['name'])) {
        echo "OK";
        exit;
    }

    if(empty($_POST["name"])){
        echo "nameが未入力です。";
    }else if(empty($_POST["password"])){
        echo "パスワードが未入力です。";
    } else {
        $username = $_POST["name"];
        $password = $_POST["password"];
        try {
            $userDB = new UserData("localhost", "root", "password", "NetProg");
            if($userDB->user_match($username,$password)) {
                session_regenerate_id(true);
                $_SESSION["id"] = $userDB->getID($username);
                $_SESSION["name"] = $username;
                echo "OK";
                exit;
            } else {
                echo "nameまたはpasswordが違います。";
                http_response_code(403);
            }
        } catch (PDOException $e){
            $errormessage = "データベースエラー";
            echo $e->getMessage();
        }
    }
?>