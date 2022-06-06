<?php
require_once("connect.php");
$dbConn = db_connect();
switch($_SERVER['REQUEST_METHOD'])
{
    case "POST":
        $body = file_get_contents('php://input');
        $inputData = json_decode($body, true);

        $username=$inputData['username'];
        $password=md5($inputData['password']);

        

        if (strstr($username, '@')){
            $sql = "SELECT * FROM user WHERE `u_mail` = '{$username}' AND `u_password` = '{$password}'";
        }else{
            $sql = "SELECT * FROM user WHERE `u_name` = '{$username}' AND `u_password` = '{$password}'";
        }
		

        $query= mysqli_query($dbConn,$sql);
        
        
        if(mysqli_num_rows($query) > 0)
        {
            //登入成功
            $data = mysqli_fetch_all($query, MYSQLI_ASSOC);	
            $u_name=$data[0]['u_name'];
            $u_id=$data[0]['u_id'];
    
            $result = Array( "is_pass" => true, "u_id" => $u_id, "token" => $u_name);
    
            

            //登入紀錄
            $ip=getClientIP();
            $login_check = "SELECT * FROM login_data WHERE `user_id` = '{$u_id}'";
            $login_query= mysqli_query($dbConn,$login_check);
            if(mysqli_num_rows($login_query) == 0){
                $login_event = "INSERT INTO `login_data` (`user_id`, `user_ip`, `login_date`) VALUES ('$u_id', '$ip', NULL)";
            }else{
                $login_event = "UPDATE `login_data` SET `user_ip` = '$ip' , `login_date` = CURRENT_TIMESTAMP() WHERE `login_data`.`user_id` = '$u_id'";
            }
            $dbConn->query($login_event);




            session_start();
            $_SESSION['u_id']=$u_id;

            //$_SESSION['u_name']=$u_name;

            
        }
        else{
            $result = Array( "is_pass" => false);
        }
        echo json_encode($result);
        break;

}



?>