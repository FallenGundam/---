<?php
require_once("connect.php");
$dbConn = db_connect();

switch($_SERVER['REQUEST_METHOD'])
{
    case "POST":
        
        $body = file_get_contents('php://input');
        $inputData = json_decode($body, true);

        $location = $inputData["location"];
        $phone = $inputData["phone"];
        $description = $inputData["description"];
        $u_id = $inputData["u_id"];
        


        $search= mysqli_query($dbConn,"SELECT * FROM `member` WHERE `u_id` = '$u_id'");  
        if (mysqli_num_rows($search)==0){
            $sql = "INSERT INTO `member` (`m_location`, `m_phone`, `m_introduction`, `u_id`) VALUES ('$location', '$phone', '$description', '$u_id')";
        }else{
            $sql = "UPDATE `member` SET `m_location` = '$location' , `m_phone` = '$phone' , `m_introduction` = '$description' WHERE `member`.`u_id` = '$u_id'";
        }

        $reslut=mysqli_query($dbConn,$sql);

        if (!$reslut){
            die('Error: ' . mysqli_connect_error());//如果sql執行失敗輸出錯誤
        }else{
            echo '儲存成功!';
        }
   

}


?>