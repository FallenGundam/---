<?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        session_start();
        $u_id = $_SESSION['u_id'];

        require_once("connect.php");
        $dbConn = db_connect();
        $sql = "DELETE FROM login_data WHERE `login_data`.`user_id` = $u_id";
        $dbConn->query($sql);

        unset($_SESSION['u_id']);
    }

?>