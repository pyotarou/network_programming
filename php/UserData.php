<?php
    class UserData {
        private $pdo;
        public function __construct($servername, $username, $password, $dbname) {
            // Create connection
            $dsn = "mysql:dbname=" . $dbname . ";host=" . $servername;
            try {
                $this->pdo = new PDO($dsn, $username, $password);
            } catch (PDOException $e) {
                //print('Connection failed: ' . $e->getMessage());
                echo "データベースに接続できません。";
                die();
            }
        }

        public function __destruct() {
            $this->pdo = null;
        }

        //ユーザ登録する関数
        public function entry($username,$password){
            $sql = "SELECT * FROM userdata WHERE name like '$username'";
            $sth = $this->pdo->prepare($sql);
            $sth->execute();
            $result = $sth->fetchALL();
            if(empty($result)){    //入力されたnameが既に使用されていたら
                //idを最後に登録されたidから+1した値する
                $sql = "SELECT max(id) as id FROM userdata;";
                $sth = $this->pdo->prepare($sql);
                $sth->execute();
                $result = $sth->fetchALL();
                if(empty($result)){
                    $id = 0;
                } else {
                    foreach($result as $row) {
                        $id = $row["id"];
                    }
                    $id++;
                }

                //登録する
                $sql = "INSERT INTO userdata (id,name,password) VALUES ($id,'$username','$password')";
                $sth = $this->pdo->prepare($sql);
                $sth->execute();
                return true;
            } else {                
                //echo var_dump($result);
                return false;
            }
        }

        //ログイン情報がマッチしてるかどうか確かめる関数
        public function user_match($username,$password) {
            $sql = "SELECT * FROM userdata WHERE name like '$username' AND password like '$password'";
            $sth = $this->pdo->prepare($sql);
            $sth->execute();
            $result = $sth->fetchALL();
            if(empty($result)){
                return false;
            } else {
                return true;
            }
        }

        //調べた場所を保存する関数
        public function add_address($id,$from,$to) {
            //登録する
            try{
                $sql = "INSERT INTO histry (id,departure,destination) VALUES ('$id','$from','$to');";
                $sth = $this->pdo->prepare($sql);
                $sth->execute();
            } catch(PDOException $e){
                die($e->getMessage());
            }
        }

        //調べた履歴を読み込む関数
        public function read_address($id){
            $sql = "SELECT * FROM histry WHERE id = $id";
            $sth = $this->pdo->prepare($sql);
            $sth->execute();
            return $sth->fetchAll();
        }

        //idを取得する関数
        public function getID($username){
            $sql = "SELECT id FROM userdata WHERE name like '$username'";
            $sth = $this->pdo->prepare($sql);
            $sth->execute();
            $result = $sth->fetchAll();
            foreach($result as $row) {
                $id = $row["id"];
            }
            return $id;
        }

        //データを共有する関数
        public function share($fromID,$toID){
            try{
                $sql = "SELECT id FROM userdata WHERE id like '$toID'";
                $sth = $this->pdo->prepare($sql);
                $sth->execute();
                $result = $sth->fetchAll();
                if(!empty($result)){
                    if($fromID != $toID){
                        $sql = "INSERT INTO share (fromID,toID) VALUES ($fromID,$toID);";
                        $sth = $this->pdo->prepare($sql);
                        $sth->execute();
                        echo "success: 共有されました。";
                    } else {
                        echo "error: それはあなたのIDです。";
                    }
                } else {
                    echo "error: そのIDは見つかりません。";
                }
            } catch(PDOException $e){
                die($e->getMessage());
            }
        }

        //selectタグ内のoptionタグを表示する関数
        public function select_histry($fromID){
            $sql = "SELECT fromID FROM share WHERE toID like '$fromID'";
            $sth = $this->pdo->prepare($sql);
            $sth->execute();
            $result = $sth->fetchAll();
            if(!empty($result)){
                foreach($result as $row){
                    $sql = "SELECT name FROM userdata WHERE id =" . $row["fromID"];
                    $sth = $this->pdo->prepare($sql);
                    $sth->execute();
                    $res_name = $sth->fetchAll();
                    foreach($res_name as $name){
                        echo "<option value=" . $row["fromID"] . ">" . $name["name"] ."</option>";
                    }
                }
            }
        }
    }
?>