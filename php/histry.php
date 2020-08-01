<?php
    require 'UserData.php';
    session_start();

    if(empty($_SESSION["id"])){
        header("Location: ../logout.php");
        exit;
    } else if (empty($_POST["departure"]) || empty($_POST["destination"])) {
        echo "出発地または目的地が入力されていません。";
    } else {
        $id = $_SESSION["id"];
        $from = $_POST["departure"];
        $to = $_POST["destination"];
        $userDB = new UserData("localhost", "root", "password", "NetProg");
        $userDB->add_address($id,$from,$to);
        echo   "<tr><td>$from</td><td>$to</td></tr>";
    }
?>