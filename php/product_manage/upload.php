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
        $u_id=$inputData['u_id'];
        $amount=$inputData['amount'];
        
        $picture=$inputData['picture'];




        $sql="INSERT INTO `product` (`p_id`, `u_id`,`p_unit`,`p_price`,`p_name`,`p_introduction`,`p_amount`,`p_city`,`p_first_image`) VALUES ( NULL, '$u_id', '$unit','$price','$name','$text','$amount','$city','$picture')";
        $reslut=mysqli_query($dbConn,$sql);  //寫入資料庫

        /*p_id為sql指派 此區為重新取得p_id
        $getpidsql = "SELECT * FROM product WHERE `p_name` = '{$name}'";
        $getpid=mysqli_query($dbConn,$getpidsql);
        $data = mysqli_fetch_all($getpid, MYSQLI_ASSOC);	 
        $pid=$data[0]['p_id'];



        $savepicturesql = "INSERT INTO `image_list` (`i_id`, `p_id`,`i_name`) VALUES ( NULL, '$pid', '$picture')";
        $savepicture=mysqli_query($dbConn,$savepicturesql);
        */


        if (!$reslut){
            die('Error: ' . mysqli_connect_error());//如果sql執行失敗輸出錯誤
        }else{
            echo '儲存成功!';
        }



}




?>