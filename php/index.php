<?php
    require 'UserData.php';
    session_start();

    if(!isset($_SESSION["name"])){
        header("Location: ../login.html");
        exit;
    } else {
        $name = $_SESSION["name"];
        $id = $_SESSION["id"];
        $userDB = new UserData("localhost", "root", "password", "NetProg");
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <title>B2課題-ルート検索</title>
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/map.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/jquery-3.4.1.min.js"></script>
    <script src="../js/map.js"></script>
</head>
<body>
    <div id="nav-content">
        <h2><b><?php echo $name; ?></b>さんのルート検索ページ</h2>
        <div class="logout"><a href="./logout.php">ログアウト</a></div>
    </div>
    <div id="map-content" class="container-fluid">
        <div id="menu">
            <div class="col-md-12">
                <p id="id">あなたのID：<span><?php echo $id?></span></p>
                <div class="form-group">
                    <label>出発地</label>
                    <input class="form-control" id="departure" placeholder="出発" type="textbox" name="departure">
                </div>
                <div class="form-group">
                    <label>到着地</label>
                    <input class="form-control" id="destination" placeholder="到着" type="textbox" name="destination">
                </div>
                <div class="form-group">
                    <input class="btn btn-primary" id="route-btn" type="button" value="ルート検索">
                    <input class="btn btn-outline-secondary" id="clear-btn" type="button" value="クリア">
                </div>
                 <div class="histry">
                    <div class="form-group">
                        <label>検索履歴</label>
                        <select name="select_histry" class="form-control">
                            <?php
                                echo "<option value='$id'>$name</option>";
                                $userDB->select_histry($id);
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-info" id="share-btn" type="button" value="履歴を共有">
                    </div>
                    <table class="table" id="histry"></table>
                </div>
            </div>
        </div>
       
        <div id="map"></div>
    </div>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAE7jCwCmiXZRlQTWIhf6Mm9ls_y1y0Pvs&language=ja">
    </script>
</body>
</html>