<?php
require_once("connect.php");
$dbConn = db_connect();
switch($_SERVER['REQUEST_METHOD'])
{
    case "POST":
        $body = file_get_contents('php://input');
        $inputData = json_decode($body, true);

        $u_id = $inputData["u_id"];

        $sql = "SELECT * FROM member WHERE `u_id` = '{$u_id}'";


        //member: m_location , m_phone , m_introduction , u_id
        $query= mysqli_query($dbConn,$sql);
        $data = mysqli_fetch_all($query, MYSQLI_ASSOC);	
        if(mysqli_num_rows($query) > 0){
            $location = $data[0]['m_location'];
            $phone = $data[0]['m_phone'];
            $introduction = $data[0]['m_introduction'];
            
            $result = Array( "pass"=>true,"region" => $location, "phone" => $phone, "description" => $introduction);
        
        }
        else{
            $result = Array("pass"=>false);
        }
        echo json_encode($result);

}


?>