<?php


require_once("../connect.php");
$dbConn = db_connect();
switch($_SERVER['REQUEST_METHOD'])
{
    case "POST":
        $body = file_get_contents('php://input');
        $inputData = json_decode($body, true);

        $p_id=$inputData["p_id"];
        $u_id=$inputData["u_id"];

        $sql = "SELECT * FROM product WHERE `u_id` = '{$u_id}' AND `p_id` = '{$p_id}'";

        $query= mysqli_query($dbConn,$sql);

        /*
        //抓取圖片檔名
        $imgsql= "SELECT * FROM image_list WHERE `p_id` = '{$p_id}'";
        $getimg=mysqli_query($dbConn,$imgsql);
        $imgdata = mysqli_fetch_all($getimg, MYSQLI_ASSOC);	
        $imgsrc=$imgdata[0]['i_name'];
        */

        if(mysqli_num_rows($query) > 0){
            $data = mysqli_fetch_all($query, MYSQLI_ASSOC);	

            $name= $data[0]['p_name'];
            $price= $data[0]['p_price'];
            $unit=$data[0]['p_unit'];
            $introduction=$data[0]['p_introduction'];
            $amount=$data[0]['p_amount'];
            $city=$data[0]['p_city'];
            $imgsrc=$data[0]['p_first_image'];


            $result = Array("name"=>$name,"price"=>$price,"unit"=>$unit,"text"=>$introduction,"amount"=>$amount,"city"=>$city,"imgsrc"=>$imgsrc);


        }
        echo json_encode($result);


}

?>