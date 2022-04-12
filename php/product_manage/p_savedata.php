<?php

require_once("../connect.php");

$dbConn = db_connect();
switch($_SERVER['REQUEST_METHOD'])
{
    case "POST":
        $body = file_get_contents('php://input');
        $inputData = json_decode($body, true);


        $name=$inputData['name'];
        $price=$inputData['price'];
        $unit=$inputData['unit'];
        $city=$inputData['city'];
        $text=$inputData['text'];
        $p_id=$inputData['p_id'];

        $amount=$inputData['amount'];
        





        $sql = "UPDATE `product` SET `p_unit` = '$unit' , `p_price` = '$price' , `p_name` = '$name' , `p_introduction` = '$text' , `p_amount` = '$amount' , `p_city` = '$city' WHERE `product`.`p_id` = '$p_id'";



 
        
        $reslut=mysqli_query($dbConn,$sql);  //寫入資料庫


        if (!$reslut){
            die('Error: ' . mysqli_connect_error());//如果sql執行失敗輸出錯誤
        }else{
            echo '儲存成功!';
        }



}




?>