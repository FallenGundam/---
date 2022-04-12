<?php

require_once("connect.php");


$dbConn = db_connect();
switch($_SERVER['REQUEST_METHOD'])
{
    case "POST":
        $body = file_get_contents('php://input');
        $inputData = json_decode($body, true);

        $username=$inputData['username'];
        $mail=$inputData['mail'];
        $password=$inputData['password'];

 


        $reg_name= mysqli_query($dbConn,"SELECT * FROM `user` WHERE `u_name` = '$username'");  
        $reg_mail= mysqli_query($dbConn,"SELECT * FROM `user` WHERE `u_mail` = '$mail'");

        
        if (mysqli_num_rows($reg_name)==0 && mysqli_num_rows($reg_mail)==0){   //信箱與名稱尚未被註冊
            
            $newpass = md5($password); //密碼加密
            $sql="INSERT INTO `user` (`u_id`, `u_password`,`u_name`,`u_mail`) VALUES ( NULL, '$newpass', '$username','$mail')";
            $reslut=mysqli_query($dbConn,$sql);  //寫入資料庫


            /*
            //創建user資料夾
            $getidsql = "SELECT * FROM user WHERE `u_name` = '{$username}' AND `u_password` = '{$newpass}'";
            $getid=mysqli_query($dbConn,$getidsql);
            $id = mysqli_fetch_row($getid)[0];
        
            $path = "../user_data/$id";
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }*/


            $result = "true";


        }else{                          //信箱被註冊過
            $result = "false";
        }
        echo $result;
        break;

}
mysqli_close($dbConn);		

?>