<?php
    require "UserData.php";

    if(empty($_POST["id"])){
        echo "error: show_histry.php";
    } else {
        $id = $_POST["id"];
        $userDB = new UserData("localhost", "root", "password", "NetProg");        
        $histry = $userDB->read_address($id);
        echo "<tr><th>出発地</th><th>目的地</th></tr>";
        foreach($histry as $row){
            echo "<tr><td>" . $row['departure'] . "</td>" .
                "<td>" . $row['destination'] . "</td></tr>";
        }
    }
?>