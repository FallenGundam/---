<?php
require_once("connect.php");
$dbConn = db_connect();
switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":

        $u_id = $_GET["u_id"];

        $sql = "SELECT * FROM member WHERE `u_id` = '{$u_id}'";

        //member: m_location , m_phone , m_introduction , u_id
        $query = mysqli_query($dbConn, $sql);
        $data = mysqli_fetch_all($query, MYSQLI_ASSOC);
        if (mysqli_num_rows($query) > 0) {
            $location = $data[0]['m_location'];
            $phone = $data[0]['m_phone'];
            $introduction = $data[0]['m_introduction'];
            $img = $data[0]['m_img'];
            $name = $data[0]['m_name'];

            $result = array(
                "pass" => true, 
                "name" => $name,
                "region" => $location, 
                "phone" => $phone, 
                "description" => $introduction,
                "img" => $img,
            );
        } else {
            $result = array("pass" => false);
        }
        echo json_encode($result);



}
