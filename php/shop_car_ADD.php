<?php

require_once("connect.php");

$dbConn = db_connect();



switch ($_SERVER['REQUEST_METHOD']) {
    case "POST":
        $body = file_get_contents('php://input');
        $inputData = json_decode($body, true);

        $p_id = $inputData['p_id'];
        $u_id = $inputData['u_id'];
        $amount = $inputData['amount'];
                
        $sql = "INSERT INTO `shop_car` (`shop_car_id`, `p_id`, `u_id`, `shop_car_amount`) VALUES (NULL, '$p_id', '$u_id', $amount)";
        $reslut=mysqli_query($dbConn,$sql);
        if (!$reslut) {
            die('Error: ' . mysqli_connect_error()); //如果sql執行失敗輸出錯誤
        } else {
            echo '儲存成功!';
        }


    }
