<?php

    
require_once("connect.php");
$dbConn = db_connect();
switch($_SERVER['REQUEST_METHOD'])
{
    case "POST":
        $body = file_get_contents('php://input');
        $inputData = json_decode($body, true);

        $search_str=$inputData["search_str"];
        $sql = "SELECT * FROM product WHERE p_name LIKE '%$search_str%' ORDER BY p_id ASC";
        $result = mysqli_query($dbConn, $sql);
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);	

        if (count($data)>0){
            $data_amount=count($data);
            $resultarray = array();
            for ($i=0; $i < $data_amount; $i++) { 
                $name= $data[$i]['p_name'];
                $price= $data[$i]['p_price'];
                $p_id=$data[$i]['p_id'];
                $city=$data[$i]['p_city'];
                $text=$data[$i]['p_introduction'];
                $img=$data[$i]['p_first_image'];
                $unit=$data[$i]['p_unit'];


                $u_id=$data[$i]['u_id'];
                $get_username_sql="SELECT * FROM user WHERE `u_id` = '{$u_id}'";
                $get_username=mysqli_query($dbConn,$get_username_sql);
                $username_data = mysqli_fetch_all($get_username, MYSQLI_ASSOC);	
                $u_name=$username_data[0]['u_name'];
                
                $get_phone_sql="SELECT * FROM member WHERE `u_id` = '{$u_id}'";
                $get_phone=mysqli_query($dbConn,$get_phone_sql);
                $phone_data = mysqli_fetch_all($get_phone, MYSQLI_ASSOC);	
                if (count($phone_data)){
                    $u_phone=$phone_data[0]['m_phone'];
                }else{
                    $u_phone="null";
                }
                


                $arraytemp = Array("not_found"=>false, "p_id"=>$p_id, "name" => $name, "price" => $price,"city"=>$city,"imgsrc"=>$img,"u_id"=>$u_id,"u_name"=>$u_name,"text"=>$text,"unit"=>$unit,"u_phone"=>$u_phone);

                array_push($resultarray,json_encode($arraytemp));
                
                
            }

        }else{
            $resultarray=Array("not_found"=>true);
        }
        echo json_encode($resultarray);


}

?>